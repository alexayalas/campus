<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;        // facade para saber el usuario autentificado Auth::user() -- Auth::id() -- Auth::check()
use Exception;
use Validator;
use Image;
use Carbon\Carbon;
use App\Perfil;
use App\Modulo;

class PerfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perfiles = Perfil::with('modulos')->get();          
        return $perfiles;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      DB::beginTransaction();    
      $modulos = Modulo::all();
      try {
        $rules = ['nombre' => 'required'];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }
        /*-- validacion por nombres y apellidos --*/
        $var_per = Str::upper($request->get('nombre'));
        $perfil = Perfil::where('nombre',$var_per)->count();
        if($perfil > 0){
            return response()->json(['errors'=>['PERFIL ' => 'Ya existe un perfil con estos datos : '.$request->get('nombre')]]);
        }        

        $perfil = new Perfil($request->all());

        $perfil->nombre = Str::upper($perfil->nombre);
        $perfil->save();

        /* ---- Guardamos los modulos del perfil ---*/
        foreach ($modulos as $key => $value){
            $perfil->modulos()->attach($value['id'],['state' => 0]);
        }

        DB::commit();        
        return;
      }
      catch(Exception $e){
        DB::rollback();
        return response()->json(
            ['status' => $e->getMessage()], 422
        );
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // funcion para recuperar los items del menu por perfil
        //return Profile::find($id)->modules()->where('module_profile.state',1)->get();
        $modulos = Perfil::find($id)->modulos()->where('modulo_perfil.state',1)->where('activo',1)->get();
        //$modules = Module::all();               // cargo todos los modulos de la BD        
        $menus = array();
        $options = array();
        $suboptions = array();
        $content =  array();
        $menucompleto = array();
        $opcioncompleta = array();
        // consulto todos los parent 0
        foreach ($modulos as $modul) {
            if($modul->idparent == 0){
                array_push($menus,$modul);      // cargo todos los parent 0 en el array $menus
            }
        }
        // consulto 1 a 1 los parents correspondientes a cada parent 0
        foreach ($menus as $menu) {
            foreach ($modulos as $modulo) {
                if($modulo->idparent == $menu->id){
                    $option = array(
                            'nombre'            => $modulo->nombre,
                            'id'                => $modulo->id,
                            'idmenu'            => $menu->id,
                            'icono'             => $modulo->icono,
                            'nombre_ruta'       => $modulo->nombre_ruta,
                            'nombre_plantilla'  => $modulo->nombre_plantilla,
                            'bloque'            => $modulo->bloque,
                            'options'           => $modulo
                    );
                    array_push($options,$option);       // cargo los hijos de cada parent 0 en el array $options

                }
            }
        }
        // consulto 1 a 1 si los hijos tiene mas desendientes
        foreach ($options as $subope) {
            foreach ($modules as $mod) {
                if($subope['options']->id == $mod->idparent){
                    $sub = array(
                        'nombre'        => $subope['nombre'] ,
                        'idoption'      => $subope['options']->id,                   
                        'options'       => $mod
                    );
                    array_push($suboptions,$sub);   // lo cargo en el array $suboptions
                }
            }
        }

        // enlazamos menu - option
        foreach ($menus as $menu) {
            foreach ($options as $option) {
                if($option['idmenu'] == $menu->id){
                    foreach ($suboptions as $sop) {     // enlazamos opciones con subopciones
                        if($option['options']->id == $sop['idoption']){
                            array_push($content,$sop);
                        }
                    }   
                    $men_sub = array(
                            'nombre'            => $option['nombre'],
                            'id'                => $option['id'],
                            'icono'             => $option['icono'],
                            'nombre_ruta'       => $option['nombre_ruta'],
                            'nombre_plantilla'  => $option['nombre_plantilla'],
                            'bloque'            => $option['bloque'],
                            'options'           => $option,
                            'suboptions'        => $content
                    );                 
                    array_push($opcioncompleta,$men_sub);
                    $content = array();
                }

            }
            $mencom = array(
                'nombre'            => $menu->nombre,
                'idmenu'            => $menu->id,
                'icono'             => $menu->icono,
                'nombre_ruta'       => $menu->nombre_ruta,
                'nombre_plantilla'  => $menu->nombre_plantilla,
                'menu_interno'      => $menu->menu_interno,
                'bloque'            => $menu->bloque,
                'options'           => $opcioncompleta
            );
            $opcioncompleta = array();
            array_push($menucompleto,$mencom);
        }

        return $menucompleto;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $perfil = Perfil::find($id); 
        $modulos = Modulo::all();
        foreach ($modulos as $mod => $value){
            $perfil->modulos()->updateExistingPivot($value['id'], ['state' => 0]);
        }        
        foreach ($modulos as $mod => $value) {
            # code...
            foreach ($request->checkedPerfil as $valmod) {
                # code...
                if($value['id'] == $valmod ){
                    $perfil->modulos()->updateExistingPivot($value['id'], ['state' => 1]);
                }
/*                 if($valmod == 27){
                    $profile->modules()->updateExistingPivot(30, ['state' => 1]);
                    $profile->modules()->updateExistingPivot(31, ['state' => 1]);
                } */

            }

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

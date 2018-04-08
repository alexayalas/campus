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
use App\Modulo;

class ModulosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modulos = Modulo::all();               // cargo todos los modulos de la BD
        
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
                            'nombre' => $modulo->nombre,
                            'idmenu' => $menu->id,
                            'options' => $modulo
                    );
                    array_push($options,$option);       // cargo los hijos de cada parent 0 en el array $options

                }
            }
        }
        // consulto 1 a 1 si los hijos tiene mas desendientes
        foreach ($options as $subope) {
            foreach ($modulos as $mod) {
                if($subope['options']->id == $mod->idparent){
                    $sub = array(
                        'nombre' => $subope['nombre'] ,
                        'idoption' => $subope['options']->id,
                        'options' => $mod
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
                            'nombre' => $option['nombre'],
                            'options' => $option,
                            'suboptions' => $content
                    );                 
                    array_push($opcioncompleta,$men_sub);
                    $content = array();
                }

            }
            $mencom = array(
                'nombre' => $menu->nombre,
                'idmenu' => $menu->id,
                'options' => $opcioncompleta
            );
            $opcioncompleta = array();
            array_push($menucompleto,$mencom);
        }
        return $menucompleto;
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
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

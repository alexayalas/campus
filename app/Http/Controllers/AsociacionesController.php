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
use App\Asociacion;
use App\AsociacionUser;

class AsociacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $asociaciones = Asociacion::orderBy('id','ASC')->where('activo',1)->get();          
        return $asociaciones;
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
  
        try {
          $rules = ['nombre'     => 'required',
                    'ruc' => 'required',
                    'nombre_comercial' => 'required'
                  ];
  
          if($request->has('fecha_inicio_labores')){
            $rules = array_add($rules, 'fecha_inicio_labores', 'date_format:d/m/Y');
          }

          $messages = ['fecha_inicio_labores.date_format' => 'Formato de fecha invalido'];
  
          $validator = Validator::make($request->all(), $rules , $messages);
          if ($validator->fails()) {
              return response()->json(['errors'=>$validator->errors()]);
          }
  
          /*-- validacion por nombres --*/
          $var_aso = Str::upper($request->get('nombre'));
          $asociacion = Asociacion::where('nombre',$var_aso)->where('activo',1)->count();          
          if($asociacion > 0){
              return response()->json(['errors'=>['ASOCIACION ' => 'Ya existe una asociacion con estos datos : '.$request->get('nombres').' '.$request->get('apellido_paterno').' '.$request->get('apellido_materno')]]);
          }  
          /*-- validacion por ruc --*/
          $var_aso_r = Str::upper($request->get('ruc'));
          $asociacion = Asociacion::where('ruc',$var_aso_r)->where('activo',1)->count();          
          if($asociacion > 0){
              return response()->json(['errors'=>['ASOCIACION ' => 'Ya existe una asociacion con estos datos : '.$request->get('nombres').' '.$request->get('apellido_paterno').' '.$request->get('apellido_materno')]]);
          }                 
  
          $asociacion = new Asociacion($request->all());

          $formfec = explode("/", $asociacion->fecha_inicio_labores);          
          $asociacion->fecha_inicio_labores = empty($asociacion->fecha_inicio_labores) ? null : Carbon::create($formfec[2],$formfec[1],$formfec[0]);
          $asociacion->nombre = Str::upper($asociacion->nombre);
          $asociacion->nombre_comercial = Str::upper($asociacion->nombre_comercial);          
          $asociacion->save();

          /* ---- Guardamos las asociaciones del usuario ---*/
          $asouser = new AsociacionUser();
          $asouser->asociacion_id = $asociacion->id;
          $asouser->user_id = $request->get('user_id');;
          $asouser->save();               
           
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
        try {
            $asociacion = Asociacion::findOrFail($id);
            //$patient->delete();
            $asociacion->activo = 0;
            $asociacion->save();
            $asoc_user = AsociacionUser::where('asociacion_id', $id)->get();
            foreach ($asoc_user as $key => $value) {
                $value->activo = 0;
                $value->save();               
            }                         
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }

    public function list_combobox()
    {
        $asociaciones = Asociacion::where('activo',1)->get(['id as value','nombre as text']);
        return $asociaciones;
    }
    
    public function asociaciones_users(Request $request)
    {
        $aso_user = AsociacionUser::with('asociacion')->where('user_id',$request->user_id)->where('activo',1)->get();
        return $aso_user;
    }
}

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
use App\Empleado;
use App\Perfil;

class EmpleadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empleados = Empleado::where('activo',1)->orderBy('id','ASC')->get();
        $empleados->each(function($empleados){
            $empleados->fecha_nacimiento = ($empleados->fecha_nacimiento == null ? null : date("d-m-Y", strtotime($empleados->fecha_nacimiento)));
            $empleados->fecha_ingreso = ($empleados->fecha_ingreso == null ? null : date("d-m-Y", strtotime($empleados->fecha_ingreso)));
        });        
        return $empleados;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $perfiles = Perfil::orderBy('id','ASC')->get(['id as value','nombre as text']);      
        return $perfiles;
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
          $rules = ['nombres'     => 'required',
                    'apellidos' => 'required',
                    'codigo' => 'required',
                    'dni' => 'required'
                  ];
  
          if($request->has('fecha_nacimiento')){
            $rules = array_add($rules, 'fecha_nacimiento', 'date_format:d/m/Y');
          }
          if($request->has('fecha_ingreso')){
            $rules = array_add($rules, 'fecha_ingreso', 'date_format:d/m/Y');
          }          
          if($request->get('image')){
            $rules = array_add($rules, 'image', 'image64:jpeg,jpg,png');
          }
          $messages = ['fecha_nacimiento.date_format' => 'Formato de fecha invalido',
                       'fecha_ingreso.date_format' => 'Formato de fecha invalido',
                       'image.image64' => 'formato de imagen invalido'];
  
          $validator = Validator::make($request->all(), $rules , $messages);
          if ($validator->fails()) {
              return response()->json(['errors'=>$validator->errors()]);
          }
          /*-- validacion del DNI --*/
          if($request->get('dni')){
              $dni = $request->get('dni');
              $emp_dni = Empleado::where('dni',$dni)->count();
              if($emp_dni > 0){
                  return response()->json(['errors'=>['DNI ' => 'Ya existe un Empleado con este numero de DNI : '.$request->get('dni')]]);
              }
          }
  
          /*-- validacion por nombres y apellidos --*/
          $var_emp = Str::upper($request->get('nombres')).' '.Str::upper($request->get('apellidos'));
          $Empleado = Empleado::where('nombre_completo',$var_emp)->count();
          if($Empleado > 0){
              return response()->json(['errors'=>['Empleado ' => 'Ya existe un Empleado con estos datos : '.$request->get('nombres').' '.$request->get('apellidos')]]);
          }        
          /*-- Validacion de la imagen --*/
          if($request->get('image')){
              $imageData = $request->get('image');
              $fileName = $request->get('dni') . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
              Image::make($request->get('image'))->save(public_path('images/').$fileName);
          }
  
          $Empleado = new Empleado($request->all());
          if(isset($fileName)){
            $Empleado->foto = $fileName;
          }
          $formfec = explode("/", $Empleado->fecha_nacimiento);                  
          $Empleado->fecha_nacimiento = empty($Empleado->fecha_nacimiento) ? null : Carbon::create($formfec[2],$formfec[1],$formfec[0]);
          $formfec2 = explode("/", $Empleado->fecha_ingreso);            
          $Empleado->fecha_ingreso = empty($Empleado->fecha_ingreso) ? null : Carbon::create($formfec2[2],$formfec2[1],$formfec2[0]);
          $Empleado->nombres = Str::upper($Empleado->nombres);
          $Empleado->apellidos = Str::upper($Empleado->apellidos);     
          $Empleado->nombre_completo = Str::upper($Empleado->nombres).' '.Str::upper($Empleado->apellidos);
          $Empleado->save();
  
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
        DB::beginTransaction(); 

        try {
            $rules = ['nombres'     => 'required',
                      'apellidos' => 'required',
                      'codigo' => 'required',
                      'dni' => 'required'
                    ];
  
            if($request->has('fecha_nacimiento')){
                $rules = array_add($rules, 'fecha_nacimiento', 'date_format:d/m/Y');
            }
            if($request->has('fecha_ingreso')){
                $rules = array_add($rules, 'fecha_ingreso', 'date_format:d/m/Y');
            }            
            if($request->get('image')){
                $rules = array_add($rules, 'image', 'image64:jpeg,jpg,png');
            }
            $messages = ['fecha_nacimiento.date_format' => 'Formato de fecha invalido',
                        'fecha_ingreso.date_format' => 'Formato de fecha invalido',
                        'image.image64' => 'formato de imagen invalido'];
    
            $validator = Validator::make($request->all(), $rules , $messages);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }

            $Empleado = Empleado::find($id);
            $Empleado->fill($request->all());
            $formfec = explode("/", $Empleado->fecha_nacimiento); 
            $Empleado->fecha_nacimiento = empty($Empleado->fecha_nacimiento) ? null : Carbon::create($formfec[2],$formfec[1],$formfec[0]);
            $formfec2 = explode("/", $Empleado->fecha_ingreso); 
            $Empleado->fecha_ingreso = empty($Empleado->fecha_ingreso) ? null : Carbon::create($formfec2[2],$formfec2[1],$formfec2[0]);
            $Empleado->nombres = Str::upper($Empleado->nombres);
            $Empleado->apellidos = Str::upper($Empleado->apellidos);
            $Empleado->nombre_completo = Str::upper($Empleado->nombres).' '.Str::upper($Empleado->apellidos);
  
            $Empleado->save();
  
          DB::commit();           
          return;
        } catch (Exception $e) {
          DB::rollback();          
          return response()->json(
              ['status' => $e->getMessage()], 422
          );
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

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
use App\Vendedor;

class VendedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendedores = Vendedor::where('activo',1)->orderBy('id','ASC')->get();
        $vendedores->each(function($vendedores){
            $vendedores->fecha_nacimiento = ($vendedores->fecha_nacimiento == null ? null : date("d-m-Y", strtotime($vendedores->fecha_nacimiento)));
            $vendedores->fecha_ingreso = ($vendedores->fecha_ingreso == null ? null : date("d-m-Y", strtotime($vendedores->fecha_ingreso)));
        });        
        return $vendedores;
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
              $ven_dni = Vendedor::where('dni',$dni)->count();
              if($ven_dni > 0){
                  return response()->json(['errors'=>['DNI ' => 'Ya existe un vendedor con este numero de DNI : '.$request->get('dni')]]);
              }
          }
  
          /*-- validacion por nombres y apellidos --*/
          $var_ven = Str::upper($request->get('nombres')).' '.Str::upper($request->get('apellidos'));
          $vendedor = Vendedor::where('nombre_completo',$var_ven)->count();
          if($vendedor > 0){
              return response()->json(['errors'=>['VENDEDOR ' => 'Ya existe un vendedor con estos datos : '.$request->get('nombres').' '.$request->get('apellido_paterno').' '.$request->get('apellido_materno')]]);
          }        
          /*-- Validacion de la imagen --*/
          if($request->get('image')){
              $imageData = $request->get('image');
              $fileName = $request->get('dni') . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
              Image::make($request->get('image'))->save(public_path('images/').$fileName);
          }
  
          $vendedor = new Vendedor($request->all());
          if(isset($fileName)){
            $vendedor->foto = $fileName;
          }
          $formfec = explode("/", $vendedor->fecha_nacimiento);                  
          $vendedor->fecha_nacimiento = empty($vendedor->fecha_nacimiento) ? null : Carbon::create($formfec[2],$formfec[1],$formfec[0]);
          $formfec2 = explode("/", $vendedor->fecha_ingreso);            
          $vendedor->fecha_ingreso = empty($vendedor->fecha_ingreso) ? null : Carbon::create($formfec2[2],$formfec2[1],$formfec2[0]);
          $vendedor->nombres = Str::upper($vendedor->nombres);
          $vendedor->apellidos = Str::upper($vendedor->apellidos);     
          $vendedor->nombre_completo = Str::upper($vendedor->nombres).' '.Str::upper($vendedor->apellidos);
          $vendedor->save();
  
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

            $vendedor = Vendedor::find($id);
            $vendedor->fill($request->all());
            $formfec = explode("/", $vendedor->fecha_nacimiento); 
            $vendedor->fecha_nacimiento = empty($vendedor->fecha_nacimiento) ? null : Carbon::create($formfec[2],$formfec[1],$formfec[0]);
            $formfec2 = explode("/", $vendedor->fecha_ingreso); 
            $vendedor->fecha_ingreso = empty($vendedor->fecha_ingreso) ? null : Carbon::create($formfec2[2],$formfec2[1],$formfec2[0]);
            $vendedor->nombres = Str::upper($vendedor->nombres);
            $vendedor->apellidos = Str::upper($vendedor->apellidos);
            $vendedor->nombre_completo = Str::upper($vendedor->nombres).' '.Str::upper($vendedor->apellidos);
  
            $vendedor->save();
  
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

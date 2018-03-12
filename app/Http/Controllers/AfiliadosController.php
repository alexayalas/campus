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
use App\Ubigeo;
use App\EstadoCivil;
use App\User;
use App\Afiliado;


class AfiliadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $afiliados = Afiliado::with('ubigeo')->orderBy('id','ASC')->get();          
        return $afiliados;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $estadosciviles = EstadoCivil::orderBy('id','ASC')->get(['id as value','nombre as text']);
        $ubigeos = Ubigeo::orderBy('nombre','ASC')->get(['id as value','nombre as text','coddpto','codprov','coddist']);

        return [
              'estadosciviles'           => $estadosciviles,
              'ubigeos'                  => $ubigeos,
          ];
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
        //$afe_pac = $request->get('afecciones');
  
        try {
          $rules = ['nombres'     => 'required',
                    'apellido_paterno' => 'required',
                    'apellido_materno' => 'required',
                    'credencial' => 'required',
                    'dni' => 'required'
                  ];
  
          if($request->has('fecha_nacimiento')){
            $rules = array_add($rules, 'fecha_nacimiento', 'date_format:d/m/Y');
          }
          if($request->get('image')){
            $rules = array_add($rules, 'image', 'image64:jpeg,jpg,png');
          }
          $messages = ['fecha_nacimiento.date_format' => 'Formato de fecha invalido',
                       'image.image64' => 'formato de imagen invalido'];
  
          $validator = Validator::make($request->all(), $rules , $messages);
          if ($validator->fails()) {
              return response()->json(['errors'=>$validator->errors()]);
          }
          /*-- validacion del DNI --*/
          if($request->get('dni')){
              $dni = $request->get('dni');
              $afi_dni = Afiliado::where('dni',$dni)->count();
              if($afi_dni > 0){
                  return response()->json(['errors'=>['DNI ' => 'Ya existe un afiliado con este numero de DNI : '.$request->get('dni')]]);
              }
          }
  
          /*-- validacion por nombres y apellidos --*/
          $var_afi = Str::upper($request->get('nombres')).' '.Str::upper($request->get('apellido_paterno')).' '.Str::upper($request->get('apellido_materno'));
          $afiliado = Afiliado::where('nombre_completo',$var_afi)->count();
          if($afiliado > 0){
              return response()->json(['errors'=>['AFILIADO ' => 'Ya existe un afiliado con estos datos : '.$request->get('nombres').' '.$request->get('apellido_paterno').' '.$request->get('apellido_materno')]]);
          }        
          /*-- Validacion de la imagen --*/
          if($request->get('image')){
              $imageData = $request->get('image');
              $fileName = $request->get('dni') . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
              Image::make($request->get('image'))->save(public_path('images/').$fileName);
          }
  
          $afiliado = new Afiliado($request->all());
          if(isset($fileName)){
            $afiliado->foto = $fileName;
          }
          $afiliado->fecha_nacimiento = empty($afiliado->fecha_nacimiento) ? null : date("Y-m-d", strtotime($afiliado->fecha_nacimiento));
          $afiliado->nombres = Str::upper($afiliado->nombres);
          $afiliado->apellido_paterno = Str::upper($afiliado->apellido_paterno);
          $afiliado->apellido_materno = Str::upper($afiliado->apellido_materno);          
          $afiliado->nombre_completo = Str::upper($afiliado->nombres).' '.Str::upper($afiliado->apellido_paterno).' '.Str::upper($afiliado->apellido_materno);
          $afiliado->ubigeo_id = ($afiliado->ubigeo_id == 0 ? null : $afiliado->ubigeo_id);
          $afiliado->save();
  
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
        $afe_pac = $request->get('afecciones');
        try {
            $rules = ['nombres'     => 'required',
                      'apellido_paterno' => 'required',
                      'apellido_materno' => 'required',
                      'credencial' => 'required',
                      'dni' => 'required'
                    ];
  
            if($request->has('fecha_nacimiento')){
                $rules = array_add($rules, 'fecha_nacimiento', 'date_format:d/m/Y');
            }
            if($request->get('image')){
                $rules = array_add($rules, 'image', 'image64:jpeg,jpg,png');
            }
            $messages = ['fecha_nacimiento.date_format' => 'Formato de fecha invalido',
                        'image.image64' => 'formato de imagen invalido'];
    
            $validator = Validator::make($request->all(), $rules , $messages);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }

            $afiliado = Afiliado::find($id);
            $afiliado->fill($request->all());
            $afiliado->fecha_nacimiento = empty($afiliado->fecha_nacimiento) ? null : date("Y-m-d", strtotime($afiliado->fecha_nacimiento));
            $afiliado->nombres = Str::upper($afiliado->nombres);
            $afiliado->apellido_paterno = Str::upper($afiliado->apellido_paterno);
            $afiliado->apellido_materno = Str::upper($afiliado->apellido_materno);          
            $afiliado->nombre_completo = Str::upper($afiliado->nombres).' '.Str::upper($afiliado->apellido_paterno).' '.Str::upper($afiliado->apellido_materno);
            $afiliado->ubigeo_id = ($afiliado->ubigeo_id == 0 ? null : $afiliado->ubigeo_id);
  
            $afiliado->save();
  
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

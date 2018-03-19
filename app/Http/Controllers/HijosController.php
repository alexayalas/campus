<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;        // facade para saber el usuario autentificado Auth::user() -- Auth::id() -- Auth::check()
use Exception;
use Validator;
use Carbon\Carbon;
use App\Hijo;

class HijosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hijos = Hijo::with('afiliado')->orderBy('id','ASC')->get();          
        return $hijos;
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
        //$afe_pac = $request->get('afecciones');  
        try {
          $rules = ['nombres'     => 'required',
                    'apellidos' => 'required'
                  ];
  
          if($request->has('fecha_nacimiento')){
            $rules = array_add($rules, 'fecha_nacimiento', 'date_format:d/m/Y');
          }
          $messages = ['fecha_nacimiento.date_format' => 'Formato de fecha invalido'];
  
          $validator = Validator::make($request->all(), $rules , $messages);
          if ($validator->fails()) {
              return response()->json(['errors'=>$validator->errors()]);
          }
  
          $hijo = new Hijo($request->all());
          $formfec = explode("/", $hijo->fecha_nacimiento);
          //$hijo->fecha_nacimiento = empty($hijo->fecha_nacimiento) ? null : date("Y-m-d", strtotime($hijo->fecha_nacimiento));
          $hijo->fecha_nacimiento = empty($hijo->fecha_nacimiento) ? null : Carbon::create($formfec[2],$formfec[1],$formfec[0]);
          $hijo->nombres = Str::upper($hijo->nombres);
          $hijo->apellidos = Str::upper($hijo->apellidos);
          $hijo->save();
  
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
        //
    }
}

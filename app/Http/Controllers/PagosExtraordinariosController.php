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
use App\PagoExtraordinario;

class PagosExtraordinariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
          $rules = ['importe'                   => 'required',
                    'tipopagoextraordinario_id' => 'required'
                  ];
  
          if($request->has('fecha_pago')){
            $rules = array_add($rules, 'fecha_pago', 'date_format:d/m/Y');
          }

          $messages = ['fecha_pago.date_format' => 'Formato de fecha invalido'];
  
          $validator = Validator::make($request->all(), $rules , $messages);
          if ($validator->fails()) {
              return response()->json(['errors'=>$validator->errors()]);
          }
  
          $pago = new PagoExtraordinario($request->all());
          $pago->observaciones = Str::upper($pago->observaciones);  
          $formfec = explode("/", $pago->fecha_pago);                  
          $pago->fecha_pago = empty($pago->fecha_pago) ? null : Carbon::create($formfec[2],$formfec[1],$formfec[0]);

          $pago->save();
  
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

    public function pagos_extraordinarios(Request $request)
    {
        $pagos = PagoExtraordinario::with('tipopagoextraordinario')->where('afiliado_id',$request->afiliado_id)->where('activo',1)->orderBy('fecha_pago','DESC')->get();
        return $pagos;
    }    
}

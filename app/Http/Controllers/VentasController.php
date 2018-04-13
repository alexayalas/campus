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
use App\Venta;
use App\Pago;
use App\Lotizacion;

class VentasController extends Controller
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
            $rules = [     'fecha_venta'            => 'date_format:Y-m-d',
                           'afiliado_id'            => 'required',
                           'kardex'                 => 'required',
                           'folio'                  => 'required',
                           'lotizacion_id'          => 'required',
                           'costo_total'            => 'required',
                           'numero_cuotas'          => 'required',
                           'valor_cuotas'           => 'required',
                           'vendedor_id'            => 'required',
                          ];                                             

            $messages = ['fecha_venta.date_format' => 'Formato de fecha invalido'];

            $validator = Validator::make($request->all(), $rules , $messages);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }       

            /*-- Grabamos la Venta ---*/
            $venta = new Venta($request->all());
            $venta->fecha_venta = empty($venta->fecha_venta) ? null : date("Y-m-d", strtotime($venta->fecha_venta));
            $venta->save();

            /*-- Grabamos la Atencion ---*/
            $pago = new Pago();
            $pago->venta_id = $venta->id;
            $pago->numero_cuota;
            $pago->fecha_programada;
            $pago->user_id = $request->user_id;

            $pago->date_attention = empty($pago->date_attention) ? null : date("Y-m-d", strtotime($pago->date_attention));
            $pago->sale_id = $sale->id;
            $pago->save();            

            /* ---- Guardamos el detalle de venta y los pagos ---*/
            foreach ($request->detalles as $key => $value) {
                $saledet = new Saledetail($value);
                $saledet->sale_id = $sale->id;
                $saledet->save();  
                
                $payment = new Payment($value);
                $payment->saledetail_id = $saledet->id;
                $payment->attention_id = $attention->id;
                $payment->save();                 
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

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
use App\Preventa;
use App\Pago;
use App\Lotizacion;
use App\Ubicacion;

class VentasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ventas = Venta::with('lotizacion','lotizacion.ubicacion','lotizacion.ubicacion.asociacion','vendedor')->where('activo',1)->get();

        foreach ($ventas as $venta) {
            $venta['acuenta'] = collect($venta['pagos'])->sum('importe'); 
		}

        return Response()->json($ventas);
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
            $rules = [     'fecha_venta'            => 'date_format:d/m/Y',
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
            $formfec = explode("/", $venta->fecha_venta); 
            $venta->fecha_venta = empty($venta->fecha_venta) ? null : Carbon::create($formfec[2],$formfec[1],$formfec[0]);
            $venta->save();

            /*-- Grabamos el cronograma de pagos ---*/
            $formfec2 = explode("/", $request->fecha_inicial); 
            $fecha_ini = Carbon::create($formfec2[2],$formfec2[1],$formfec2[0]);
            
            /* --- si hay preventa grabamos la cuota cero ---*/
            if($request->has('preventa_id')){
                $pagocero = new Pago();
                $pagocero->venta_id = $venta->id;
                $pagocero->numero_cuota = 0;
                $pagocero->fecha_programada = $venta->fecha_venta;
                $pagocero->fecha_pago = $venta->fecha_venta;  
                $pagocero->importe = $request->cuota_cero;
                $pagocero->estado_pago = 1;              
                $pagocero->user_id = $request->user_id;
                $pagocero->save();                
            }

            for ($i=1; $i <= $request->numero_cuotas ; $i++) { 
                $pago = new Pago();
                $pago->venta_id = $venta->id;
                $pago->numero_cuota = $i;
                $pago->fecha_programada = $fecha_ini;
                $pago->user_id = $request->user_id;
                $pago->save();   
                $fecha_ini->addMonth();    
            }

            /* --- actualizamos el estado del lote --- */
            $lote = Lotizacion::find($request->lotizacion_id);
            $lote->estado_lote = 'vendido';
            $lote->save();

            /* --- actualizamos las cantidades de la estructura */
            $ubicacion = Ubicacion::find($request->ubicacion_id);
            $ubicacion->lotes_disponibles = ($ubicacion->lotes_disponibles) - 1;
            $ubicacion->lotes_vendidos = ($ubicacion->lotes_vendidos) + 1;
            if($request->has('preventa_id')){
                $ubicacion->lotes_prevendidos = ($ubicacion->lotes_prevendidos) - 1;
            }
            $ubicacion->save();

            if($request->has('preventa_id')){
                $preventa = Preventa::find($request->preventa_id);
                $preventa->estado = 1;
                $preventa->save();
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

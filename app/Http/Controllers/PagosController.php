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
use App\Pago;

class PagosController extends Controller
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
        DB::beginTransaction(); 

        try {
            $rules = ['importe'     => 'required',
                      'pagado_por' => 'required',
                      'numero_documento' => 'required'
                    ];
    
            $validator = Validator::make($request->all(), $rules );
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }

            $pago = Pago::where('venta_id',$request->venta_id)->where('estado_pago',0)->first();

            $pago->fill($request->all());
            $formfec = explode("/", $pago->fecha_pago); 
            $pago->fecha_pago = empty($pago->fecha_pago) ? null : Carbon::create($formfec[2],$formfec[1],$formfec[0]);
            $pago->estado_pago = 1;
  
            $pago->save();
  
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

    public function pagos(Request $request)
    {
        $pagos = Pago::where('venta_id',$request->venta_id)->orderBy('numero_cuota','ASC')->get();
        foreach ($pagos as $pago) {
            $pago['estado_pago_letras'] = ($pago->estado_pago == 0) ? 'PENDIENTE'  : 'PAGADO' ; 
		}
        //return $quotes;
        return Response()->json($pagos);
    }
}

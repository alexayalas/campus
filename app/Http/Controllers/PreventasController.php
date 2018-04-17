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
use App\Preventa;
use App\Lotizacion;
use App\Ubicacion;

class PreventasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $preventas = Preventa::with('lotizacion','lotizacion.ubicacion','lotizacion.ubicacion.asociacion','vendedor')->where('activo',1)->get();
        return $preventas;
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
            $rules = [     'fecha_preventa'         => 'date_format:d/m/Y',
                           'afiliado_id'            => 'required',
                           'importe'                => 'required',
                           'lotizacion_id'          => 'required',
                           'vendedor_id'            => 'required',
                          ];                                             

            $messages = ['fecha_preventa.date_format' => 'Formato de fecha invalido'];

            $validator = Validator::make($request->all(), $rules , $messages);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }       

            /*-- Grabamos la PreVenta ---*/
            $preventa = new Preventa($request->all());
            $formfec = explode("/", $preventa->fecha_preventa); 
            $preventa->fecha_preventa = empty($preventa->fecha_preventa) ? null : Carbon::create($formfec[2],$formfec[1],$formfec[0]);
            $preventa->save();

            /* --- actualizamos el estado del lote --- */
            $lote = Lotizacion::find($request->lotizacion_id);
            $lote->estado_lote = 'preventa';
            $lote->save();

            /* --- actualizamos las cantidades de la estructura */
            $ubicacion = Ubicacion::find($request->ubicacion_id);
            $ubicacion->lotes_disponibles = ($ubicacion->lotes_disponibles) - 1;
            $ubicacion->lotes_prevendidos = ($ubicacion->lotes_prevendidos) + 1;
            $ubicacion->save();

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

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
use App\Ubicacion;
use App\Lotizacion;

class UbicacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$ubicaciones = Ubicacion::orderBy('id','ASC')->where('activo',1)->get();          
        //return $ubicaciones;
        $ubicaciones = Lotizacion::select('id','sector','grupo','manzana',DB::raw("select count(*) from lotizaciones where estado_lote='disponible' AS disponible"));
        return $ubicaciones;
        //dd($ubicaciones);
        
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
                $rules = ['manzana'   => 'required'];

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json(['errors'=>$validator->errors()]);
                }
            /*-- validacion por sector, grupo, manzana --*/
            $ubi_sector = Str::upper($request->get('sector'));
            $ubi_grupo = Str::upper($request->get('grupo'));
            $ubi_manzana = Str::upper($request->get('manzana'));    

            $ubicacion = Ubicacion::where('sector',$ubi_sector)->where('grupo',$ubi_grupo)->where('manzana',$ubi_manzana)->where('activo',1)->count();          
            if($ubicacion > 0){
                return response()->json(['errors'=>['ESTRUCTURA ' => 'Ya existe una ubicacion con estos datos : '.$request->get('sector').' '.$request->get('grupo').' '.$request->get('manzana')]]);
            }             
           
            /*-- Grabamos la Ubicacion ---*/
            $ubic = new Ubicacion($request->all());
            $ubic->save();
         
            /* ---- Guardamos los lotes de la ubicacion ---*/
            $tot = $request->get('lotes');
            for ($i = 1; $i <= $tot ; $i++) {
                $lotes = new Lotizacion();
                $lotes->ubicacion_id = $ubic->id;
                $lotes->lote = $i;
                $lotes->user_id = $request->get('user_id');
                $lotes->save(); 
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

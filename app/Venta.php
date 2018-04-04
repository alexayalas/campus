<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = "ventas";

    protected $fillable = ['id', 'preventa_id', 'afiliado_id','kardex','folio','lotizacion_id','fecha_venta','costo_total','tipo_venta','numero_cuotas','valor_cuotas','estado_venta','observaciones','vendedor_id','user_id','activo'];


    public function user()
    {
        return $this->belongsTo('App\User');
    } 

    public function preventa()
    {
        return $this->belongsTo('App\Preventa');
    }

    public function afiliado()
    {
        return $this->belongsTo('App\Afiliado');
    }  

    public function lotizacion()
    {
        return $this->belongsTo('App\Lotizacion');
    }  
    
    public function vendedor()
    {
        return $this->belongsTo('App\Vendedor');
    }     
}

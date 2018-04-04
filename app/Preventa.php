<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preventa extends Model
{
    protected $table = "preventas";

    protected $fillable = ['id', 'afiliado_id','numero_documento','folio','lotizacion_id','fecha_venta','costo_total','tipo_venta','numero_cuotas','valor_cuotas','estado_venta','observaciones','vendedor_id','user_id','activo'];


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

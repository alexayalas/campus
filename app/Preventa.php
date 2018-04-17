<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preventa extends Model
{
    protected $table = "preventas";

    protected $fillable = ['id', 'afiliado_id','fecha_preventa','numero_documento','importe','lotizacion_id','vendedor_id','user_id','activo'];


    public function user()
    {
        return $this->belongsTo('App\User');
    } 

    public function venta()
    {
        return $this->belongsTo('App\Venta');
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
        return $this->belongsTo('App\Empleado');
    }
}

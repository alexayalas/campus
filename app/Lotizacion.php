<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lotizacion extends Model
{
    protected $table = "lotizaciones";

    protected $fillable = ['id', 'ubicacion_id', 'lote','estado_lote','user_id', 'activo'];


    public function user()
    {
        return $this->belongsTo('App\User');
    } 
    public function ubicacion()
    {
        return $this->belongsTo('App\Ubicacion');
    } 
   
}

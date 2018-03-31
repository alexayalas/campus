<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    protected $table = "ubicaciones";

    protected $fillable = ['id', 'asociacion_id', 'sector','grupo', 'manzana',
                         'user_id', 'activo'];


    public function user()
    {
        return $this->belongsTo('App\User');
    } 
    public function asociacion()
    {
        return $this->belongsTo('App\Asociacion');
    }  
    public function lotizaciones()
    {
        return $this->hasMany('App\Lotizacion');
    }         
}

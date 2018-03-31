<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asociacion extends Model
{
    protected $table = "asociaciones";

    protected $fillable = ['id', 'nombre', 'ruc','nombre_comercial', 'user_id',
                         'fecha_inicio_labores','descripcion', 'activo'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }  

    public function ubicaciones()
    {
        return $this->hasMany('App\Ubicacion');
    }                               
}

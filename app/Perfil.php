<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = "perfiles";

    protected $fillable = ['id', 'nombre','activo'];

    public function empleados()
    {
        return $this->hasMany('App\Empleado');        
    }

    public function modulos()
    {
        return $this->belongsToMany('App\Modulo')->withPivot('state')->withTimestamps();
    }
}

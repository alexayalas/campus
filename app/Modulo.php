<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    protected $table = "modulos";

    protected $fillable = ['nombre','idparent','tipo','activo'];

    public function perfiles()
    {
        return $this->belongsToMany('App\Perfil')->withPivot('state')->withTimestamps();
    }
}

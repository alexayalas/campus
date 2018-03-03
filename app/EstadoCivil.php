<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoCivil extends Model
{
    protected $table = "estadosciviles";

    protected $fillable = ['nombre','activo'];

    public function afiliados()
    {
        return $this->hasMany('App\Afiliado');
    }    
}

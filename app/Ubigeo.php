<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ubigeo extends Model
{
    protected $table = "ubigeos";

    protected $fillable = ['coddpto','codprov','coddist','nombre'];

    public function afiliados()
    {
        return $this->hasMany('App\Afiliado');
    }    

}

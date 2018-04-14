<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoPagoExtraordinario extends Model
{
    protected $table = "tipo_pagosextraordinarios";

    protected $fillable = ['id', 'nombre','activo'];

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{
    protected $table = "vendedores";

    protected $fillable = ['id', 'codigo', 'nombres','apellidos', 'nombre_completo',
                         'dni', 'sexo','fecha_nacimiento','telefono','celular','email',
                         'fecha_ingreso','foto','activo'];
                         


}

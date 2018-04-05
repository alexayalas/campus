<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = "empleados";

    protected $fillable = ['id', 'codigo', 'nombres','apellidos', 'nombre_completo',
                         'dni', 'sexo','fecha_nacimiento','telefono','celular','email',
                         'fecha_ingreso','foto','perfil_id','habilitado','acceso','activo'];
}

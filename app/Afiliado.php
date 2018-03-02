<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Afiliado extends Model
{
    protected $table = "afiliados";

    protected $fillable = ['id', 'credential', 'apellido_paterno','apellido_materno', 'nombres',
                         'nombre_completo','domicilio', 'dni', 'telefono','celular','email',
                         'fecha_nacimiento','lugar_nacimiento', 'ubigeo_id', 'ocupacion',
                         'nivel_instruccion', 'sexo', 'estadocivil_id','profesion', 'foto',
                         'condicion','estudios', 'titular_id', 'user_id','activo'];

}

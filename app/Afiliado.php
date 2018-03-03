<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Afiliado extends Model
{
    protected $table = "afiliados";

    protected $fillable = ['id', 'credencial', 'apellido_paterno','apellido_materno', 'nombres',
                         'nombre_completo','domicilio', 'dni', 'telefono','celular','email',
                         'fecha_nacimiento','lugar_nacimiento', 'ubigeo_id', 'ocupacion',
                         'nivel_instruccion', 'sexo', 'estadocivil_id','profesion', 'foto',
                         'condicion','estudios', 'titular_id', 'user_id','activo'];

    public function ubigeo()
    {
        return $this->belongsTo('App\Ubigeo');
    } 

    public function estadocivil()
    {
        return $this->belongsTo('App\EstadoCivil');
    } 
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }     

}


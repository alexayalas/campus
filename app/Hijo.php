<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hijo extends Model
{
    protected $table = "hijos";

    protected $fillable = ['id', 'nombres', 'apellidos','fecha_nacimiento', 'estudios',
                         'centro_trabajo','afiliado_id', 'user_id', 'activo'];

    public function afiliado()
    {
        return $this->belongsTo('App\Afiliado');
    }                          

    public function user()
    {
        return $this->belongsTo('App\User');
    }                          
    
}

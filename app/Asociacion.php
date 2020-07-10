<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Asociacion extends Model
{
    protected $table = "asociaciones";

    protected $fillable = ['id', 'nombre', 'ruc','nombre_comercial', 'user_id',
                         'fecha_inicio_labores','descripcion', 'activo'];

    public function getFechaInicioLaboresAttribute($date){
        if($date){
            return Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');   //formateo de la fecha para verlo en el frontend
        }else{
            return null;
        }
    } 

    public function user()
    {
        return $this->belongsTo('App\User');
    }  

    public function ubicaciones()
    {
        return $this->hasMany('App\Ubicacion');
    }  
 
    public function asociacionesusers()
    {
        return $this->hasMany('App\AsociacionUser');
    }
}

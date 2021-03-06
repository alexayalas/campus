<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function afiliados()
    {
        return $this->hasMany('App\Afiliado');
    }  
    
    public function hijos()
    {
        return $this->hasMany('App\Hijo');
    }  
    
    public function asociaciones()
    {
        return $this->hasMany('App\Asociacion');
    } 

    public function empleado()
    {
        return $this->belongsTo('App\Empleado');
    } 
    
    public function pagos()
    {
        return $this->hasMany('App\Pago');
    } 
    
    public function pagosextraordinarios()
    {
        return $this->hasMany('App\PagoExtraordinario');
    } 

    public function asociacionesusers()
    {
        return $this->hasMany('App\AsociacionUser');
    }    
   
}

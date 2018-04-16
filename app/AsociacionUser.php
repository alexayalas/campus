<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AsociacionUser extends Model
{
    protected $table = "asociacion_user";

    protected $fillable = ['id', 'asociacion_id', 'user_id', 'activo'];

    public function asociacion()
    {
        return $this->belongsTo('App\Asociacion');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}

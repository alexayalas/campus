<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PagoExtraordinario extends Model
{
    protected $table = "pagos_extraordinarios";

    protected $fillable = ['id', 'afiliado_id', 'tipopagoextraordinario_id','fecha_pago','importe','user_id','observaciones','activo'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }  

    public function tipopagoextraordinario()
    {
        return $this->belongsTo('App\TipoPagoExtraordinario');
    } 

    public function afiliado()
    {
        return $this->belongsTo('App\Afiliado');
    }     
}

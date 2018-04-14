<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = "pagos";

    protected $fillable = ['id', 'venta_id', 'numero_cuota','fecha_programada','fecha_pago','numero_documento','importe','pagado_por','estado_pago','user_id','activo'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }  

    public function venta()
    {
        return $this->belongsTo('App\Venta');
    } 

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "pedidos";
    protected $fillable = [
        'numero',
        'fecha',
        'precio_dolar',
        'subtotal',
        'iva',
        'delivery',
        'total',
        'bs',
        'users_id',
        'estatus',
        'cedula',
        'nombre',
        'telefono',
        'direccion_1',
        'direccion_2',
        'metodo_pago',
        'pago_validado',
        'comprobante_pago',
    ];

    public function carrito()
    {
        return $this->hasMany(Carrito::class, 'pedidos_id', 'id');
    }

    public function deliverys()
    {
        return $this->hasOne(Delivery::class, 'pedidos_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function scopeBuscar($query, $keyword)
    {
        return $query->where('numero', 'LIKE', "%$keyword%")
            ->orWhere('cedula', 'LIKE', "%$keyword%")
            ->orWhere('nombre', 'LIKE', "%$keyword%")
            ->orWhere('telefono', 'LIKE', "%$keyword%")
            ;
    }

}

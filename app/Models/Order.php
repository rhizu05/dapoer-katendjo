<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_id',
        'verified_by',
        'user_id',
        'customer_name', // <-- TAMBAHKAN INI
        'order_type',
        'status',
        'is_paid',
        'total_amount',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Satu Pesanan memiliki banyak Detail.
     */
    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}   
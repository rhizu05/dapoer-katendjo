<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    
    // ... (fillable, hidden, casts) ...

    /**
     * Relasi: Satu Pelanggan (User) memiliki banyak Pesanan (Order).
     */
    public function orders()
    {
        // Kebutuhan: Melihat riwayat pembelian
        return $this->hasMany(Order::class)->orderBy('created_at', 'desc');
    }
}
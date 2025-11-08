<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    /**
     * Nama tabel (karena 'Table' adalah kata kunci, 
     * kita pastikan Laravel tahu nama tabelnya adalah 'tables').
     */
    protected $table = 'tables';

    /**
     * Kolom yang boleh diisi (mass assignable).
     */
    protected $fillable = [
        'name',
        'status',
    ];
}

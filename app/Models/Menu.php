<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'status',
        'image_path',
        'category_id', // <-- TAMBAHKAN INI
    ];

    /**
     * Relasi: Satu Menu milik satu Kategori.
     * (INI ADALAH FUNGSI YANG HILANG DARI FILE ANDA)
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
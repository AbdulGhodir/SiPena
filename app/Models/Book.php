<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'isbn',
        'judul',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'deskripsi',
        'stok',
        'gambar',
        'id_kategori',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_kategori');
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class, 'id_buku');
    }
}

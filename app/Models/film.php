<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class film extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'poto',
        'deskripsi',
        'url_vidio',
        'id_kategori',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'genre_film', 'id_film', 'id_genre');
    }

    public function aktors()
    {
        return $this->belongsToMany(Aktor::class, 'aktor_film', 'id_film', 'id_aktor');
    }
}

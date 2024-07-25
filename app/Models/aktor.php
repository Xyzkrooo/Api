<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class aktor extends Model
{
    use HasFactory;

    protected $fillable = ['nama_aktor'];

    public function films()
    {
        return $this->belongsToMany(Film::class, 'aktor_film', 'id_aktor', 'id_film');
    }
}

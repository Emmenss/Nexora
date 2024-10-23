<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;




class Panier extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    public function lignesPanier()
    {
        return $this->hasMany(LignePanier::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

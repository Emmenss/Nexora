<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boutiques extends Model
{
    use HasFactory;
    protected $fillable = ['imgshop', 'nameshop', 'addresshop','phoneshop','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function produits()
    {
        return $this->hasMany(Produit::class);
   }

}

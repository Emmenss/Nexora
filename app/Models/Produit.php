<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;
    
    protected $fillable = ['productimg', 'productname','productdescript','productprice', 'productqte','productcat','user_id','boutique_id'];

    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }

}

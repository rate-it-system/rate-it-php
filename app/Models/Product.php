<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];

    public function degustation()
    {
        return $this->hasOne(Degustation::class);
    }

    public function produkteValuations()
    {
        return $this->hasMany(Produktevaluations::class, 'product_id', 'id');
    }
}

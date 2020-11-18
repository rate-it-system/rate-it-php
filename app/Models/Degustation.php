<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Degustation extends Model
{
    use HasFactory;

    protected $hidden = [];

    public function products() {
        return $this->hasMany(Product::class);
    }
}

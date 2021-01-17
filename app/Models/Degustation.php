<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Degustation extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];

    public function owner()
    {
        return $this->hasOne(User::class, 'id', 'owner_id')
            ->select('id', 'login', 'created_at');
    }

    public function addOwnerToObject(): void
    {
        $this->owner = $this->owner()->first();
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'degustation_id', 'id');
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function features()
    {
        return $this->hasMany(Degustationfeature::class);
    }

    public function currentProduct()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}

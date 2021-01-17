<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produktevaluations extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function degustationFeature()
    {
        return $this->hasOne(Degustationfeature::class, 'id', 'degustationfeatures_id');
    }

    public static function createOrUpdate(User $user, Product $product, Degustationfeature $degustationfeature){
        if (self::where('user_id', $user->id)
                ->where('product_id', $product->id)
                ->where('degustationfeatures_id', $degustationfeature->id)
                ->count() == 0) {
            $produktevaluations = new Produktevaluations();
            $produktevaluations->user_id = $user->id;
            $produktevaluations->product_id = $product->id;
            $produktevaluations->degustationfeatures_id = $degustationfeature->id;
        } else {
            $produktevaluations = Produktevaluations::where('user_id', $user->id)
                ->where('product_id', $product->id)
                ->where('degustationfeatures_id', $degustationfeature->id)->first();
        }
        return $produktevaluations;
    }
}

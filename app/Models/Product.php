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
    public function addAvgRating()
    {
        $produktevaluations = Produktevaluations::all()->where('product_id', $this->id);
        $x = 0;
        $i = 0;
        foreach ($produktevaluations as $produktevaluation){
            $x = $x + $produktevaluation->rating;
            $i++;
        }
        if($i !== 0){
            $this->avgRating = $x/$i;
        }
        else{
            $this->avgRating = null;
        }
    }
}

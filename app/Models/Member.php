<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function degustation()
    {
        return $this->hasOne(Degustation::class, 'id', 'degustation_id');
    }
}

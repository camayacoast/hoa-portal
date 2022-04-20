<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subdivision extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function users(){
        return $this->morphedByMany(Users::class,'subdivisionable');
    }
}

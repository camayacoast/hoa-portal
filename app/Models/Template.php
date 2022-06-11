<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    //autogate Template
    use HasFactory;
    protected $guarded = [];

    public function autogate(){
        return $this->hasOne(Autogate::class);
    }

    public function message(){
        return $this->hasMany(Message::class);
    }
}

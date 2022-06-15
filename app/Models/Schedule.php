<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasFactory,SoftDeletes;

    public function due(){
        return $this->hasMany(Due::class);
    }

    public function email(){
        return $this->hasOne(Email::class);
    }

    public function fee(){
        return $this->hasOne(Fee::class);
    }
}

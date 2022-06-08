<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutogateTemplate extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function autogate(){
        return $this->hasMany(Autogate::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fee extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];
    public function lot(){
        return $this->belongsTo(Lot::class);
    }
    public function schedule(){
        return $this->belongsTo(Schedule::class);
    }
}

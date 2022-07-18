<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lot extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    public function fee(){
        return $this->hasMany(Fee::class);
    }
    public function subdivision(){
        return $this->belongsTo(Subdivision::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function agent(){
        return $this->belongsTo(Agent::class);
    }

    public function billing(){
        return $this->hasMany(Billing::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Due extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];
    public function schedule(){
        return $this->belongsTo(Schedule::class);
    }

//    public function scopeDues($query){
//        return $query->where('hoa_subd_dues_status','=',1);
//    }
    public function subdivision(){
        return $this->belongsTo(Subdivision::class);
    }
}

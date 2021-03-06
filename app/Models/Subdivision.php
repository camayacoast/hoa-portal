<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subdivision extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];

//    public function announcement(){
//        return $this->belongsTo(Announcement::class);
//    }
    public function users(){
        return $this->morphedByMany(User::class,'subdivisionable');
    }

    public function announcements(){
        return $this->morphedByMany(Announcement::class,'subdivisionable');
    }

    public function director(){
        return $this->hasOne(Director::class);
    }

    public function lot(){
        return $this->hasMany(Lot::class);
    }

    public function due(){
        return $this->hasMany(Due::class)->where('hoa_subd_dues_status',1);
    }


}

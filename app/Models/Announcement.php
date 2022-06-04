<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Announcement extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];

    public function subdivisions(){
        return $this->morphToMany(Subdivision::class,'subdivisionable');
    }

    protected function createdAt() : Attribute
    {
        return new Attribute(
            get:fn($value) => Carbon::parse($value)->toDayDateTimeString()
        );
    }
}

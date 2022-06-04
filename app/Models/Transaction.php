<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Transaction extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];

    public function card(){
        return $this->belongsTo(Card::class);
    }

    protected function createdAt() : Attribute
    {
        return new Attribute(
            get:fn($value) => Carbon::parse($value)->toDayDateTimeString()
        );
    }
}

<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use HasFactory;

    /**
     * Change the created at format.
     *
     * @return Attribute
     */
    protected $guarded = [];
    public function user(){
        return $this->belongsTo(User::class);
    }
    protected function createdAt() : Attribute
    {
        return new Attribute(
            get:fn($value) => Carbon::parse($value)->toDayDateTimeString()
        );
    }

    public function file(){
        return $this->hasMany(File::class);
    }

}

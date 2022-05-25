<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Billing extends Model
{
    use HasFactory, SoftDeletes;

//    protected function totalCost(): Attribute
//    {
//        $now = Carbon::now()->format('Y-m-d');
//        return new Attribute(
//            get:fn($value) => $value . ' ' . $now,
//        );
//    }
}

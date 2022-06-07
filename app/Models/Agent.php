<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agent extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];

    public function lot(){
        return $this->hasOne(Lot::class);
    }
    protected function fullName() : Attribute{
        return new Attribute(
            get:fn($value,$attributes) => $attributes['hoa_sales_agent_fname'].' '. $attributes['hoa_sales_agent_mname'].' '.$attributes['hoa_sales_agent_lname']

        );

}
}

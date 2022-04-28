<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'hoa_member_lname',
        'hoa_member_fname',
        'hoa_member_mname',
        'email',
        'hoa_member_phone_num',
        'hoa_admin',
        'hoa_member',
        'hoa_member_block_num',
        'hoa_member_position',
        'hoa_member_lot_num',
        'hoa_member_lot_area',
        'hoa_member_ebill',
        'hoa_member_sms',
        'password', '
        hoa_member_registered',
        'hoa_member_modifiedby',
        'hoa_member_status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function subdivisions(){
        return $this->morphToMany(Subdivision::class,'subdivisionable');
    }

    public function director(){
        return $this->hasMany(Director::class);
    }
}

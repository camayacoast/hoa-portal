<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('hoa_member_lname');
            $table->string('hoa_member_fname');
            $table->string('hoa_member_mname')->nullable();
            $table->string('hoa_member_suffix')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('hoa_member_phone_num')->nullable();
            $table->integer('hoa_admin')->default(0);
            $table->integer('hoa_member')->default(1);
            $table->integer('hoa_member_assigned')->default(1);
            $table->integer('hoa_access_type')->default(0);
            $table->integer('hoa_member_block_num')->default(0);
            $table->integer('hoa_member_position')->default(0);
            $table->integer('hoa_member_lot_num')->default(0);
            $table->integer('hoa_member_lot_area')->nullable();
            $table->boolean('hoa_member_ebill')->default(false);
            $table->boolean('hoa_member_sms')->default(false);
            $table->integer('hoa_member_registered')->default(0);
            $table->string('password');
            $table->integer('hoa_member_modifiedby')->default(0);
            $table->integer('hoa_member_status')->default(1);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};

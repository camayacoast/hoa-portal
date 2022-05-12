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
        Schema::create('lots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subdivision_id')->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->foreignId('agent_id')->nullable()->constrained();
            $table->integer('hoa_subd_lot_block')->unique();
            $table->integer('hoa_subd_lot_num')->unique();
            $table->integer('hoa_subd_lot_area');
            $table->integer('hoa_subd_lot_house_num')->unique();
            $table->string('hoa_subd_lot_street_name');
            $table->integer('hoa_subd_lot_createdby');
            $table->softDeletes();
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
        Schema::dropIfExists('lots');
    }
};

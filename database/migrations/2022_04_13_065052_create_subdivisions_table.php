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
        Schema::create('subdivisions', function (Blueprint $table) {
            $table->id();
            $table->string('hoa_subd_name')->index();
            $table->integer('hoa_subd_area')->nullable();
            $table->integer('hoa_subd_blocks')->nullable();
            $table->integer('hoa_subd_lots')->nullable();
            $table->string('hoa_subd_contact_person')->nullable();
            $table->string('hoa_subd_contact_number')->nullable();
            $table->integer('hoa_subd_status')->default(1);
            $table->integer('hoa_subd_modifiedBy')->nullable();
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
        Schema::dropIfExists('subdivisions');
    }
};

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
        Schema::create('dues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subdivision_id')->constrained();
            $table->string('hoa_subd_dues_name');
            $table->decimal('hoa_subd_dues_cost');
            $table->string('hoa_subd_dues_unit');
            $table->text('hoa_subd_dues_desc')->nullable();
            $table->date('hoa_subd_dues_start_date');
            $table->date('hoa_subd_dues_end_date');
            $table->integer('hoa_subd_dues_cutoff_date');
            $table->integer('hoa_subd_dues_payment_target');
            $table->foreignId('schedule_id')->constrained();
            $table->integer('hoa_subd_dues_status')->default(1);
            $table->integer('hoa_subd_dues_modifiedby');
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
        Schema::dropIfExists('dues');
    }
};

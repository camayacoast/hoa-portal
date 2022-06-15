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
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lot_id')->constrained();
            $table->foreignId('schedule_id')->constrained();
            $table->string('hoa_fees_item');
            $table->text('hoa_fees_desc')->nullable();
            $table->decimal('hoa_fees_cost');
            $table->integer('hoa_fees_modifiedby');
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
        Schema::dropIfExists('fees');
    }
};

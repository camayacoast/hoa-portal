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
        Schema::create('autogates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('template_id')->nullable()->constrained();
            $table->string('hoa_autogate_member_name');
            $table->string('hoa_autogate_subdivision_name');
            $table->date('hoa_autogate_start');
            $table->date('hoa_autogate_end');
            $table->integer('hoa_autogate_modifiedby');
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
        Schema::dropIfExists('autogates');
    }
};

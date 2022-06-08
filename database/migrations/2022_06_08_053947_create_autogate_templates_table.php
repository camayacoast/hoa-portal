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
        Schema::create('autogate_templates', function (Blueprint $table) {
            $table->id();
            $table->string('hoa_autogate_template_name');
            $table->string('hoa_autogate_template_title');
            $table->string('hoa_autogate_template_message');
            $table->integer('hoa_autogate_template_modifiedby');
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
        Schema::dropIfExists('autogate_templates');
    }
};

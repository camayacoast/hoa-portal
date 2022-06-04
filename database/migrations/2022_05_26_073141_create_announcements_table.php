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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('hoa_event_notices_type');
            $table->string('hoa_event_notices_title');
            $table->string('hoa_event_notices_desc');
            $table->text('hoa_event_notices_fullstory')->nullable();
            $table->string('hoa_event_notices_photo');
            $table->integer('hoa_event_notices_modifiedby');
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
        Schema::dropIfExists('announcements');
    }
};

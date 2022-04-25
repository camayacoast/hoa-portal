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
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('hoa_sales_agent_email')->unique();
            $table->string('hoa_sales_agent_fname');
            $table->string('hoa_sales_agent_lname');
            $table->string('hoa_sales_agent_mname')->nullable();
            $table->string('hoa_sales_agent_suffix')->nullable();
            $table->string('hoa_sales_agent_contact_number');
            $table->integer('hoa_sales_agent_status')->default(1);
            $table->string('hoa_sales_agent_supervisor');
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
        Schema::dropIfExists('agents');
    }
};

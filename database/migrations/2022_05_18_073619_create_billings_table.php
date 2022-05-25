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
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('hoa_subd_lot');
            $table->decimal('hoa_billing_total_cost');
            $table->date('hoa_billing_due_date');
            $table->date('hoa_billing_generated_date');
            $table->string('hoa_billing_status')->index();
            $table->string('hoa_billing_period')->nullable();
            $table->softDeletes();
            $table->integer('created_by');
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
        Schema::dropIfExists('billings');
    }
};

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
            $table->foreignId('lot_id')->constrained();
            $table->string('hoa_billing_statement_number');
            $table->decimal('hoa_billing_total_cost');
            $table->date('hoa_billing_due_dates');
            $table->date('hoa_billing_generated_date');
            $table->date('hoa_billing_date_paid')->nullable();
            $table->decimal('hoa_billing_past_due')->default(0.00);
            $table->string('hoa_billing_status');
            $table->string('hoa_billing_period');
            $table->softDeletes();
            $table->integer('hoa_billing_created_by');
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

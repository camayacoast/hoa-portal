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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('card_id')->constrained();
            $table->string('hoa_privilege_transaction_name');
            $table->string('hoa_privilege_transaction_desc');
            $table->integer('hoa_privilege_transaction_amount');
            $table->string('hoa_privilege_booking_num')->nullable();
            $table->string('hoa_privilege_transaction_type');
            $table->integer('hoa_privilege_transaction_modifiedby');
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
        Schema::dropIfExists('transactions');
    }
};

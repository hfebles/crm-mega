<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id("_id");
            $table->integer("client_id");
            $table->integer("client_account_id");
            $table->date("date");
            $table->integer("pay_method_id");
            $table->decimal("headline_amount", 20, 2);
            $table->decimal("client_amount", 20, 2);
            $table->decimal("rate_amount", 20, 5);
            $table->decimal("rate_type", 20, 5);
            $table->integer("bank_id");
            $table->integer("op_day")->nullable();
            $table->integer("op_month")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};

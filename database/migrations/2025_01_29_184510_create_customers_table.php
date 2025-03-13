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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string("customer_id")->unique();
            $table->string("Customer_Name");
<<<<<<< HEAD
            $table->bigInteger("Phone Number");
=======
            $table->string("Phone Number");
>>>>>>> e6cac63ca8a52c9984ac36e49ed5d2f3b56b82f3
            $table->string("Email");
            $table->string("Occupation");
            $table->date("Date of Birth");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};

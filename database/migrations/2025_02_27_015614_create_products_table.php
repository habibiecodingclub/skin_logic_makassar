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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("Product_Name");
            $table->enum("Product_Category", ["Brightening", "Serum", "Acne", "Racikan", "Peeling", "Lainnya", "Paket"]);
            $table->integer("Product_Price");
            $table->string("SKU-Number")->unique();
            $table->text("Description");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

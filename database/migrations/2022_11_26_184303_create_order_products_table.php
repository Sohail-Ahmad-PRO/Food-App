<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up(): void
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('order_products');
    }
};

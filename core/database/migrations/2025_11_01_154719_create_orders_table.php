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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Customer Info
            $table->string('full_name');
            $table->string('email')->nullable();
            $table->string('phone');

            // Shipping Info
            $table->text('address');
            $table->string('division')->nullable();
            $table->string('district')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();

            // Product Info
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2);
            $table->decimal('total', 10, 2);

            // Payment & Status
            $table->string('status')->default('pending');

            $table->timestamps();

            // Foreign key constraint
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

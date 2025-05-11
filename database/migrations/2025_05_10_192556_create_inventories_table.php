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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained();
            $table->timestamps();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('sku')->unique();
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(0);
            $table->decimal('discount', 8, 2)->default(0.00);
            $table->decimal('cost', 10, 2);
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'low_stock', 'out_of_stock'])->default('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};

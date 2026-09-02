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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('generic_name')->nullable();
            $table->string('barcode')->unique();
            $table->decimal('price', 10, 2);
            $table->decimal('cost', 10, 2);
            $table->integer('stock_quantity')->default(0);
            $table->date('expiry_date');
            $table->string('image')->nullable();
            $table->enum('status', ['Available', 'Low Stock', 'Expired', 'Discontinued'])->default('Available');
            $table->timestamps();

            $table->index(['barcode', 'expiry_date', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};

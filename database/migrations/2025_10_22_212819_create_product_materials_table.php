<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('product_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('material');            // เช่น PVC, ABS, Cotton
            $table->unsignedTinyInteger('percent')->nullable(); // 0..100
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('product_materials');
    }
};
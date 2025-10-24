<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void {
  Schema::create('product_attribute_values', function (Blueprint $t) {
    $t->id();
    $t->foreignId('product_id')->constrained()->cascadeOnDelete();
    $t->foreignId('attribute_id')->constrained('attributes')->cascadeOnDelete();
    $t->string('value')->nullable(); // เก็บเป็น string เพื่อความยืดหยุ่น
    $t->timestamps();
    $t->unique(['product_id','attribute_id']);
  });
}
public function down(): void { Schema::dropIfExists('product_attribute_values'); }

};

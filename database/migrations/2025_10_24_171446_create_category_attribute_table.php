<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void {
  Schema::create('category_attribute', function (Blueprint $t) {
    $t->id();
    $t->foreignId('category_id')->constrained()->cascadeOnDelete();
    $t->foreignId('attribute_id')->constrained('attributes')->cascadeOnDelete();
    $t->boolean('is_required')->default(false);
    $t->unsignedSmallInteger('sort_order')->default(0);
    $t->timestamps();
    $t->unique(['category_id','attribute_id']);
  });
}
public function down(): void { Schema::dropIfExists('category_attribute'); }

};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
  Schema::create('attributes', function (Blueprint $t) {
    $t->id();
    $t->string('name');              // เช่น ความสูง, น้ำหนัก, วัสดุ
    $t->string('unit')->nullable();  // cm, g, % ฯลฯ
    $t->string('input_type')->default('text'); // text/number/select...
    $t->timestamps();
  });
}
public function down(): void { Schema::dropIfExists('attributes'); }

};

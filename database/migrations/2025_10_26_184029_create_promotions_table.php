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
            Schema::create('promotions', function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique(); // เช่น chamora
                $table->string('name'); // ชื่อโปร
                $table->decimal('discount_percent', 5, 2); // เช่น 15.00
                $table->enum('applies_to', ['all', 'collection'])->default('all');
                $table->boolean('is_active')->default(true);
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->timestamps();
            });
        }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};

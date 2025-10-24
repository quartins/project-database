<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products','slug')) {
                $table->string('slug')->nullable()->unique()->after('name');
            }
            if (!Schema::hasColumn('products','sku')) {
                $table->string('sku')->nullable()->unique()->after('slug');
            }
            if (!Schema::hasColumn('products','brand')) {
                $table->string('brand')->nullable()->after('name');
            }
            if (!Schema::hasColumn('products','size_cm')) {
                $table->decimal('size_cm', 6, 2)->nullable()->after('price');
            }
        });
    }
    public function down(): void {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products','size_cm')) $table->dropColumn('size_cm');
            if (Schema::hasColumn('products','brand'))   $table->dropColumn('brand');
            if (Schema::hasColumn('products','sku'))     $table->dropColumn('sku');
            if (Schema::hasColumn('products','slug'))    $table->dropColumn('slug');
        });
    }
};
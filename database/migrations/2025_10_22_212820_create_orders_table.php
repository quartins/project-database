<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // ที่อยู่จัดส่ง
            $table->string('recipient_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('address_line1')->nullable();
            $table->string('address_line2')->nullable();
            $table->string('district')->nullable();
            $table->string('province')->nullable();
            $table->string('postcode', 10)->nullable();
            $table->string('country')->nullable();

            // เงิน
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('shipping_fee', 10, 2)->default(35.00);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);

            $table->string('coupon_code')->nullable();   // chamora = 15%
            $table->string('status')->default('draft');  // draft, pending_payment, paid, cancelled
            $table->timestamp('paid_at')->nullable();

            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('orders');
    }
};
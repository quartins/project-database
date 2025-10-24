<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // ฟิลด์ที่อยู่ (ไม่ต้องเพิ่ม phone ถ้ามีแล้ว)
            $table->string('recipient_name')->nullable()->after('lastname');
            $table->string('address_line1')->nullable()->after('recipient_name');
            $table->string('address_line2')->nullable()->after('address_line1');
            $table->string('district')->nullable()->after('address_line2');
            $table->string('province')->nullable()->after('district');
            $table->string('postcode', 10)->nullable()->after('province');
            $table->string('country')->nullable()->after('postcode');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'recipient_name','address_line1','address_line2',
                'district','province','postcode','country',
            ]);
        });
    }
};

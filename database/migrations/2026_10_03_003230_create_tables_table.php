<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->string('table_number')->unique();
            $table->enum('category', ['duo', 'quad', 'group8', 'vip']); // Berdua, Ber-4, Ber-8, VIP
            $table->integer('capacity'); // 2, 4, 8, 100
            $table->decimal('min_order_price', 12, 2)->default(0); // Paket minimal
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};
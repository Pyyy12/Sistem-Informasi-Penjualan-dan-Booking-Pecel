<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('daily_sales', function (Blueprint $table) {
            $table->id();
            $table->date('sale_date')->unique();
            $table->integer('total_portions_sold')->default(0);
            $table->decimal('dine_in_revenue', 12, 2)->default(0);
            $table->decimal('booking_revenue', 12, 2)->default(0);
            $table->decimal('total_revenue', 12, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_sales');
    }
};
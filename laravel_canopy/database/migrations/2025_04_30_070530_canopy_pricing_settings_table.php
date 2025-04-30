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
        //
        Schema::create('canopy_pricing_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('base_price_per_m2', 10, 2);       // Базовая цена за м²
            $table->decimal('materials_coef', 10, 2);          // Коэффициент на материалы
            $table->decimal('consumables_coef', 10, 2);        // Коэффициент на расходники
            $table->decimal('manufacturing_coef', 10, 2);      // Коэффициент на производство
            $table->decimal('installation_coef', 10, 2);       // Коэффициент на монтаж
            $table->decimal('delivery_price', 10, 2);          // Фикс. цена доставки
            $table->decimal('discount_amount', 10, 2);         // Скидка
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

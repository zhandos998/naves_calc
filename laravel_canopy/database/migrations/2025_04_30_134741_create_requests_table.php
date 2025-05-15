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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            $table->decimal('width', 8, 2);
            $table->decimal('length', 8, 2);
            $table->decimal('height', 8, 2);
            $table->decimal('post_thickness', 5, 2);
            $table->string('frame_type');

            $table->decimal('area', 10, 2);
            $table->decimal('materials', 12, 2);
            $table->decimal('consumables', 12, 2);
            $table->decimal('manufacturing', 12, 2);
            $table->decimal('installation', 12, 2);
            $table->decimal('delivery', 12, 2);
            $table->decimal('discount', 12, 2);
            $table->decimal('total', 12, 2);
            $table->decimal('final_price', 12, 2);
            $table->decimal('per_m2', 12, 2);

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};

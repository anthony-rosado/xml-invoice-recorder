<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained();
            $table->string('code', 30);
            $table->string('description', 250);
            $table->unsignedDecimal('quantity', 8, 3)->default(1);
            $table->unsignedDecimal('unit_value', 8, 3)->default(0);
            $table->unsignedDecimal('unit_price', 8, 3)->default(0);
            $table->unsignedDecimal('base_amount', 8, 3)->default(0);
            $table->unsignedDecimal('tax_amount', 8, 3)->default(0);
            $table->unsignedDecimal('discount_amount', 8, 3)->default(0);
            $table->unsignedDecimal('other_charges_amount', 8, 3)->default(0);
            $table->unsignedDecimal('total_amount', 8, 3)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};

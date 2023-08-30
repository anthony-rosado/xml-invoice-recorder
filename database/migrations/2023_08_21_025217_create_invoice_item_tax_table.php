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
        Schema::create('invoice_item_tax', function (Blueprint $table) {
            $table->foreignId('item_id')
                ->constrained('invoice_items')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('tax_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->decimal('amount', 8, 3)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_item_tax');
    }
};

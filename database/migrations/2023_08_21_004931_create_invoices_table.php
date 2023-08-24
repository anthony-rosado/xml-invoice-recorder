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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_type_id')->constrained()->cascadeOnUpdate();
            $table->foreignId('document_type_id')->constrained()->cascadeOnUpdate();
            $table->foreignId('currency_id')->constrained()->cascadeOnUpdate();
            $table->foreignId('issuer_id')->constrained()->cascadeOnUpdate();
            $table->foreignId('acquirer_id')->constrained()->cascadeOnUpdate();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate();
            $table->char('series', 4);
            $table->unsignedInteger('correlative_number');
            $table->date('issue_date');
            $table->time('issue_time');
            $table->date('due_date');
            $table->string('observation')->nullable();
            $table->unsignedDecimal('base_amount', 8, 3)->default(0);
            $table->unsignedDecimal('tax_amount', 8, 3)->default(0);
            $table->unsignedDecimal('base_tax_amount', 8, 3)->default(0);
            $table->unsignedDecimal('discount_amount', 8, 3)->default(0);
            $table->unsignedDecimal('other_charges_amount', 8, 3)->default(0);
            $table->unsignedDecimal('global_discount_amount', 8, 3)->default(0);
            $table->unsignedDecimal('total_amount', 8, 3)->default(0);
            $table->timestamps();

            $table->unique(['series', 'correlative_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};

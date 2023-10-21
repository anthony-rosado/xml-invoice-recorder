<?php

namespace Database\Seeders;

use App\Models\Acquirer;
use App\Models\Currency;
use App\Models\DocumentType;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Issuer;
use App\Models\TransactionType;
use App\Models\User;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Invoice::factory()
            ->for(TransactionType::query()->inRandomOrder()->first())
            ->for(DocumentType::query()->inRandomOrder()->first())
            ->for(Currency::query()->inRandomOrder()->first())
            ->for(Issuer::factory()->createOne())
            ->for(Acquirer::factory()->createOne())
            ->for(User::factory()->createOne())
            ->has(InvoiceItem::factory()->count(5), 'items')
            ->createMany(100);
    }
}

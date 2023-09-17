<?php

namespace Tests\Feature\Notifications\Invoices;

use App\Models\Acquirer;
use App\Models\Currency;
use App\Models\DocumentType;
use App\Models\Invoice;
use App\Models\Issuer;
use App\Models\TransactionType;
use App\Models\User;
use App\Notifications\Invoices\InvoiceSummary;
use Illuminate\Notifications\Messages\MailMessage;
use Tests\TestCase;

class InvoiceSummaryTest extends TestCase
{
    public function testSendNotificationToUser(): void
    {
        $transactionType = TransactionType::query()->inRandomOrder()->first();
        $documentType = DocumentType::query()->inRandomOrder()->first();
        $currency = Currency::query()->inRandomOrder()->first();
        $issuer = Issuer::factory()->createOne();
        $acquirer = Acquirer::factory()->createOne();
        $user = User::factory()->createOne();
        $invoice = Invoice::factory()
            ->for($transactionType)
            ->for($documentType)
            ->for($currency)
            ->for($issuer)
            ->for($acquirer)
            ->for($user)
            ->createOne();

        $mailMessage = app(InvoiceSummary::class, ['invoice' => $invoice])->toMail($user);

        self::assertInstanceOf(MailMessage::class, $mailMessage);
    }
}

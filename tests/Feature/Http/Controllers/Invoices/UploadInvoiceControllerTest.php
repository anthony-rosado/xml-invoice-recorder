<?php

namespace Tests\Feature\Http\Controllers\Invoices;

use App\Models\User;
use App\Notifications\Invoices\InvoiceSummary;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UploadInvoiceControllerTest extends TestCase
{
    public function testUploadAnInvoice(): void
    {
        $user = User::factory()->createOne();
        $invoice = Storage::get('/invoices/F003-1.xml');
        $invoiceFile = UploadedFile::fake()->createWithContent('F003-1.xml', $invoice);

        Notification::fake();
        Passport::actingAs($user);

        $this->assertAuthenticated();

        $response = $this->post(
            '/api/invoices/upload',
            ['file' => $invoiceFile],
            ['Accept' => 'application/json']
        );

        Notification::assertSentTo($user, InvoiceSummary::class);
        Notification::assertCount(1);

        $response->assertCreated();
        $response->assertJson(
            fn (AssertableJson $json) => $json->whereType('data', 'array')
                ->has(
                    'data',
                    fn (AssertableJson $json) => $json
                        ->hasAll([
                            'id',
                            'series',
                            'correlative_number',
                            'issue_date',
                            'issue_time',
                            'due_date',
                            'total_amount',
                            'items_count',
                        ])
                        ->whereAllType([
                            'id' => 'integer',
                            'series' => 'string',
                            'correlative_number' => 'integer',
                            'issue_date' => 'string',
                            'issue_time' => 'string',
                            'due_date' => 'string',
                            'total_amount' => 'string',
                            'items_count' => 'integer',
                        ])
                        ->where('series', 'F003')
                        ->where('correlative_number', 1)
                )
        );
    }

    public function testUnableToUploadAnInvoice()
    {
        $user = User::factory()->createOne();
        $invoice = Storage::get('/invoices/MISSING-ID.xml');
        $invoiceFile = UploadedFile::fake()->createWithContent('F003-1.xml', $invoice);

        Notification::fake();
        Passport::actingAs($user);

        $this->assertAuthenticated();

        $response = $this->post(
            '/api/invoices/upload',
            ['file' => $invoiceFile],
            ['Accept' => 'application/json']
        );

        Notification::assertNothingSent();

        $response->assertBadRequest()
            ->assertJson(
                fn (AssertableJson $json) => $json->hasAll(['message', 'description'])
                    ->whereAllType([
                        'message' => 'string',
                        'description' => ['string', 'null'],
                    ])
                    ->where('message', 'Could not transform invoice XML to array')
            );
    }

    public function testUnableToUploadAnInvoiceWithNoAuthentication()
    {
        $invoice = Storage::get('/invoices/MISSING-ID.xml');
        $invoiceFile = UploadedFile::fake()->createWithContent('F003-1.xml', $invoice);

        Notification::fake();

        $response = $this->post(
            '/api/invoices/upload',
            ['file' => $invoiceFile],
            ['Accept' => 'application/json']
        );

        Notification::assertNothingSent();

        self::assertNotTrue($this->isAuthenticated());

        $response->assertUnauthorized()
            ->assertJson(
                fn (AssertableJson $json) => $json->has('message')
                    ->whereType('message', 'string')
            );
    }
}

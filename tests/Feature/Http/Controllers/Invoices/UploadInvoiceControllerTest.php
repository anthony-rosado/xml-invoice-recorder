<?php

namespace Tests\Feature\Http\Controllers\Invoices;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UploadInvoiceControllerTest extends TestCase
{
    public function testUploadAnInvoice(): void
    {
        $invoice = Storage::get('/invoices/F003-1.xml');
        $invoiceFile = UploadedFile::fake()->createWithContent('F003-1.xml', $invoice);

        Passport::actingAs(User::factory()->createOne());

        $this->assertAuthenticated();

        $response = $this->post(
            '/api/invoices/upload',
            ['file' => $invoiceFile],
            ['Accept' => 'application/json']
        );

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
        $invoice = Storage::get('/invoices/MISSING-ID.xml');
        $invoiceFile = UploadedFile::fake()->createWithContent('F003-1.xml', $invoice);

        Passport::actingAs(User::factory()->createOne());

        $this->assertAuthenticated();

        $response = $this->post(
            '/api/invoices/upload',
            ['file' => $invoiceFile],
            ['Accept' => 'application/json']
        );

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

        $response = $this->post(
            '/api/invoices/upload',
            ['file' => $invoiceFile],
            ['Accept' => 'application/json']
        );

        self::assertNotTrue($this->isAuthenticated());

        $response->assertUnauthorized()
            ->assertJson(
                fn (AssertableJson $json) => $json->has('message')
                    ->whereType('message', 'string')
            );
    }
}

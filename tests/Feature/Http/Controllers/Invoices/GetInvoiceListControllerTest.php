<?php

namespace Tests\Feature\Http\Controllers\Invoices;

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Passport\Passport;
use Tests\TestCase;

class GetInvoiceListControllerTest extends TestCase
{
    public function testGetInvoiceList(): void
    {
        Passport::actingAs(User::factory()->createOne());

        $response = $this->getJson('/api/invoices');

        $response->assertOk();
        $response->assertJson(
            fn (AssertableJson $json) => $json
                ->has(
                    'data',
                    null,
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
                )
                ->has('meta')
                ->has('links')
                ->whereAllType([
                    'data' => 'array',
                    'meta' => 'array',
                    'links' => 'array',
                ])
        );
    }

    public function testTryingToGetInvoiceListWithNoAuthentication(): void
    {
        $response = $this->getJson('/api/invoices');

        self::assertNotTrue($this->isAuthenticated());

        $response->assertUnauthorized()
            ->assertJson(
                fn (AssertableJson $json) => $json->has('message')
                    ->whereType('message', 'string')
            );
    }
}

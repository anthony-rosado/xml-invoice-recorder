<?php

namespace Feature\Http\Controllers\InvoiceItems;

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Passport\Passport;
use Tests\TestCase;

class GetTotalAccumulatedAmountPerItemControllerTest extends TestCase
{
    public function testGetTotalAccumulatedAmountPerItem()
    {
        Passport::actingAs(User::factory()->createOne());

        $response = $this->getJson('/api/invoice-items/total-accumulated-amount-per-item');

        $response->assertOk();
        $response->assertJson(
            fn (AssertableJson $json) => $json
                ->has(
                    'data',
                    null,
                    fn (AssertableJson $json) => $json
                        ->has('code')
                        ->has(
                            'amounts',
                            null,
                            fn (AssertableJson $json) => $json
                                ->has('currency_code')
                                ->has('value')
                                ->whereAllType([
                                    'currency_code' => 'string',
                                    'value' => 'double',
                                ])
                        )
                        ->whereAllType([
                            'code' => 'string',
                            'amounts' => 'array',
                        ])
                )
                ->whereType('data', 'array')
        );
    }
}

<?php

namespace Tests\Feature\Http\Controllers\Invoices;

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Passport\Passport;
use Tests\TestCase;

class GetTotalAccumulatedPerCurrencyControllerTest extends TestCase
{
    public function testGetTotalAccumulatedAmountPerItem()
    {
        Passport::actingAs(User::factory()->createOne());

        $response = $this->getJson('/api/invoices/total-accumulated-amount-per-currency');

        $response->assertOk();
        $response->assertJson(
            fn (AssertableJson $json) => $json
                ->has(
                    'data',
                    null,
                    fn (AssertableJson $json) => $json
                        ->has('currency_code')
                        ->has('value')
                        ->whereAllType([
                            'currency_code' => 'string',
                            'value' => 'double',
                        ])
                )
                ->whereType('data', 'array')
        );
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\CartChange;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProcessCartChangeTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * @dataProvider addProvider
     */
    public function it_creates_cart_and_adds_changes($itemUuid, $amount, $type)
    {
        $res = $this->json(
            'POST',
            'v1/cart/change',
            [
                'change' => [
                    'item_id' => $itemUuid,
                    'amount' => $amount,
                    'type' => $type
                ]
            ]
        )
            ->assertCreated()
            ->assertJsonStructure([
                'item_uuid',
                'amount',
                'cart_change_type_id',
                'updated_at',
                'created_at',
                'cart' => [
                    'checked_out',
                    'uuid',
                    'created_at',
                    'updated_at'
                ]
            ])
            ->json();


        $this->assertDatabaseHas('carts', ['uuid' => $res['cart']['uuid'], 'checked_out' => false]);
        $this->assertDatabaseHas(
            'cart_changes',
            [
                'item_uuid' => $itemUuid,
                'amount' => $amount,
                'cart_change_type_id' => $res['cart_change_type_id']
            ]
        );
    }

    /**
     * @dataProvider
     */
    public function addProvider()
    {
        return [
            [
                'itemUuid' => 'd848ef34-5cee-11eb-ae93-0242ac130002',
                'amount' => 5,
                'type' => 'add'
            ],
            [
                'itemUuid' => 'd848ef34-5cee-11eb-ae93-0242ac130003',
                'amount' => 2056,
                'type' => 'add'
            ],
            [
                'itemUuid' => 'd848ef34-5cee-11eb-ae93-0242ac130003',
                'amount' => 1,
                'type' => 'add'
            ]
        ];
    }
}

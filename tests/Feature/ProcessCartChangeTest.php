<?php

namespace Tests\Feature;

use App\Models\Cart;
use Tests\TestCase;
use App\Models\CartChange;
use App\Models\CartChangeType;
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
                'item_id' => $itemUuid,
                'amount' => $amount,
                'type' => $type
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

    /**
     * @test
     * @dataProvider getRemovedProvider
     */
    public function it_gets_removed($cartId, $itemId, $add, $remove)
    {
        $cart = new Cart();
        $cart->uuid = $cartId;
        $cart->saveOrFail();

        $cartChange = new CartChange();
        $cartChange->cart_change_type_id = CartChangeType::where('type', 'add')->firstOrFail()->id;
        $cartChange->item_uuid = $itemId;
        $cartChange->amount = $add;
        $cartChange->cart_id = $cart->id;
        $cartChange->saveOrFail();

        $cartChange = new CartChange();
        $cartChange->cart_change_type_id = CartChangeType::where('type', 'remove')->firstOrFail()->id;
        $cartChange->item_uuid = $itemId;
        $cartChange->amount = $remove;
        $cartChange->cart_id = $cart->id;
        $cartChange->saveOrFail();

        $cartChange = new CartChange();
        $cartChange->cart_change_type_id = CartChangeType::where('type', 'remove')->firstOrFail()->id;
        $cartChange->item_uuid = $itemId;
        $cartChange->amount = $remove;
        $cartChange->cart_id = $cart->id;
        $cartChange->saveOrFail();

        $this->json(
            'GET',
            "v1/cart/{$cartId}/changes/remove"
        )
            ->assertOk()
            ->assertJsonFragment([
                'item_uuid' => $itemId,
                'amount' => $remove,
                'type' => 'remove'
            ])
            ->assertJsonCount(2)
            ->json();
    }

    /**
     * @dataProvider
     */
    public function getRemovedProvider()
    {
        return [
            [
                'cartId' => 'd848ef34-5cee-11eb-ae93-0242ac131234',
                'itemId' => 'd848ef34-5cee-11eb-ae93-0242ac130003',
                'add' => 100,
                'remove' => 3
            ],
            [
                'cartId' => 'd848ef34-5cee-11eb-ae93-0242ac131234',
                'itemId' => 'd848ef34-5cee-11eb-ae93-0242ac130003',
                'add' => 10,
                'remove' => 3
            ],
            [
                'cartId' => 'd848ef34-5cee-11eb-ae93-0242ac131234',
                'itemId' => 'd848ef34-5cee-11eb-ae93-0242ac130003',
                'add' => 2,
                'remove' => 1
            ]
        ];
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Cart;
use App\Models\CartChange;
use Illuminate\Support\Str;
use App\Models\CartChangeType;
use App\Jobs\ProcessCartChange;
use Database\Factories\CartChangeFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProcessCartChangeTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * @dataProvider createAddProvider
     */
    public function it_creates_cart_and_adds_item($itemUuid, $amount, $type)
    {

        $this->post("v1/cart/change",
        [
            'changes' => [
                'item_id' => $itemUuid,
                'amount' => $amount,
                'type' => $type
            ]
        ]);

        $cC = CartChange::where('item_uuid', $itemUuid)
                ->first();

        $this->assertDatabaseCount('carts', 1);
        $this->assertInstanceOf(CartChange::class, $cC);
        $this->assertDatabaseHas('carts', ['id' => $cC->cart_id, 'checked_out' => false]);
        $this->assertDatabaseHas('cart_changes', 
        [
            'item_uuid' => $itemUuid,
            'amount' => $amount,
            'cart_change_type_id' => $cC->cart_change_type_id
        ]);
    }

    /**
     * @dataProvider
     */
    public function createAddProvider()
    {
        return [
            [
                'itemUuid' => 'd848ef34-5cee-11eb-ae93-0242ac130002',
                'amount' => 2,
                'type' => 'add'
            ]
        ];
    }
}

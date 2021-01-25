<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Models\Cart;
use App\Models\CartChange;
use App\Library\CartChangeRequest;
use App\Handlers\CartChangeHandler;

class AddHandler extends CartChangeHandler
{
    protected ?CartChangeHandler $successor = null;

    public function __construct(CartChangeHandler $cartChangeHandler = null)
    {
        $this->successor = $cartChangeHandler;
    }

    public function process(CartChangeRequest $request): ?CartChange
    {
        if ($request->getCartChangeType()->type !== 'add') {
            return null;
        }

        $cart = $request->getCart();

        if (!$cart instanceof Cart) {
            $cart = new Cart();
        }

        $cartChange = new CartChange();

        $cartChange->item_uuid = $request->getItemId();
        $cartChange->amount = $request->getAmount();
        $cartChange->cart_change_type_id = $request->getCartChangeType()->id;
    
        $cart->saveOrFail();
        $cart->cartChanges()->save($cartChange);

        return $cartChange;
    }
}

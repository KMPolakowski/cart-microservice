<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Models\CartChange;
use App\Events\CheckoutEvent;
use App\Library\CartChangeRequest;
use App\Handlers\CartChangeHandler;

class CheckoutHandler extends CartChangeHandler
{
    private ?CartChangeHandler $successor = null;

    public function __construct(CartChangeHandler $cartChangeHandler = null)
    {
        $this->succesor = $cartChangeHandler;
    }

    public function process(CartChangeRequest $request): ?CartChange
    {
        if (!\in_array($request->getCartChangeType()->type, ['check_out', 'revert_checkout'])) {
            return null;
        }

        $cartChange = new CartChange();
        
        $cartChange->item_uuid = $request->getItemId();
        $cartChange->amount = 1;
        $cartChange->cart_change_type_id = $request->getCartChangeType()->id;
    

        $cart = $request->getCart();
        $cart->checked_out = true;

        $cart->cartChanges()->save($cartChange);

        \event(new CheckoutEvent($cartChange));

        return $cartChange;
    }
}

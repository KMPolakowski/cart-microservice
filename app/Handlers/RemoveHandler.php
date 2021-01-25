<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Models\CartChange;
use App\Library\CartChangeRequest;
use App\Handlers\CartChangeHandler;

class RemoveHandler extends CartChangeHandler
{
    private ?CartChangeHandler $successor = null;

    public function __construct(CartChangeHandler $cartChangeHandler = null)
    {
        $this->successor = $cartChangeHandler;
    }

    public function process(CartChangeRequest $request): ?CartChange
    {
        if ($request->getCartChangeType()->type !== 'remove') {
            return null;
        }

        $cartChange = new CartChange();
        
        $cartChange->item_uuid = $request->getItemId();
        $cartChange->amount = $request->getAmount();
        $cartChange->cart_change_type_id = $request->getCartChangeType()->id;
    
        
        $request->getCart()->cartChanges()->save($cartChange);

        return $cartChange;
    }
}

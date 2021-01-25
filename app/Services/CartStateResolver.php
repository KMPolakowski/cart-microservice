<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartChange;

class CartStateResolver
{
    public function sum(int $cartId, string $type)
    {
        // groupy by item_uuid and sum up amounts of given type

        // and then resolve cart state by summing both change type sums
    }
}

<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartChange;

class ChangeTypeSummer
{
    public function sum(int $cartId, string $type)
    {
        return CartChange::where('cart_id', $cartId)
            ->andWhere('type', $type)
            ->sum('amount')
            ->get();
    }
}

<?php

namespace App\Library;

use App\Models\Cart;
use App\Models\CartChangeType;

class CartChangeRequest
{
    public function __construct(
        private CartChangeType $cartChangeType,
        private int $amount,
        private ?String $itemId,
        private ?Cart $cart = null,
    ) {
    }



    /**
     * Get the value of amount
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * Set the value of amount
     *
     * @return  self
     */
    public function setAmount(int $amount): CartChangeRequest
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get the value of itemId
     */
    public function getItemId(): ?String
    {
        return $this->itemId;
    }

    /**
     * Set the value of itemId
     *
     * @return  self
     */
    public function setItemId(String $itemId): CartChangeRequest
    {
        $this->itemId = $itemId;

        return $this;
    }

    /**
     * Get the value of cart
     */
    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    /**
     * Set the value of cart
     *
     * @return  self
     */
    public function setCart(Cart $cart): CartChangeRequest
    {
        $this->cart = $cart;

        return $this;
    }

    /**
     * Get the value of cartChangeType
     */
    public function getCartChangeType() : CartChangeType
    {
        return $this->cartChangeType;
    }

    /**
     * Set the value of cartChangeType
     *
     * @return  self
     */
    public function setCartChangeType(CartChangeType $cartChangeType) : CartChangeRequest
    {
        $this->cartChangeType = $cartChangeType;

        return $this;
    }
}

<?php declare(strict_types=1);

namespace App\Handlers\CartChangeHandler;

class RemoveHandler extends CartChangeHandler
{
    private ?CartChangeHandler $successor = null;

    public function __construct(CartChangeHandler $cartChangeHandler = null)
    {
        $this->successor = $cartChangeHandler;
    }

    protected function processing(String $cartId, array $changes): ?string
    {
        
    }
}
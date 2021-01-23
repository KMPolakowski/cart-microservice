<?php declare(strict_types=1);

namespace App\Handlers\CartChangeHandler;

abstract class CartChangeHandler
{
    private ?CartChangeHandler $successor = null;

    public function __construct(CartChangeHandler $cartChangeHandler = null)
    {
        $this->successor = $cartChangeHandler;
    }

    final public function handle(String $cartId, array $changes): ?string
    {
        $processed = $this->processing($cartId, $changes);

        if ($processed === null && $this->successor !== null) {
            $processed = $this->successor->handle($cartId, $changes);
        }

        return $processed;
    }

    abstract protected function processing(String $cartId, array $changes): ?string;
}
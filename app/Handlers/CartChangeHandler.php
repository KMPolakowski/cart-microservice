<?php declare(strict_types=1);

namespace App\Handlers;

use App\Models\CartChange;
use App\Models\CartChangeType;
use App\Library\CartChangeRequest;

abstract class CartChangeHandler implements CartChangeHandlerInterface
{
    private ?CartChangeHandler $successor = null;

    public function __construct(CartChangeHandler $cartChangeHandler = null)
    {
        $this->successor = $cartChangeHandler;
    }

    final public function handle(CartChangeRequest $request): ?CartChange
    {
        $processed = $this->process($request);

        if ($processed === null && $this->successor !== null) {
            $processed = $this->successor->handle($request);
        }

        return $processed;
    }

    public abstract function process(CartChangeRequest $request): ?CartChange;
}
<?php

namespace App\Handlers;

use App\Library\CartChangeRequest;
use App\Models\CartChange;

interface CartChangeHandlerInterface {
    public function handle(CartChangeRequest $request): ?CartChange;
}
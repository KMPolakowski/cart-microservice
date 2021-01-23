<?php

namespace App\Http\Controllers;

use App\Models\CartChangeType;
use App\Service\Interfaces\PaymentDataRegistratorInterface;
use App\Service\Interfaces\UserRegistratorInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class CartController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct(
        private CartChangeHandler $cartChangeHandler
    ) {}

    public function change(
        Request $request,
    ) {
        $this->validate($request, [
            "change" => "bail|required|array",
            "cart_id" => "bail|required|nullable|uuid",
            "changes.item_id" => "bail|required|nullable|uuid",
            "changes.type" => "bail|required|string|in:" . implode(",", CartChangeType::TYPES),
            "changes.amount" => "bail|required|int"
        ]);

        $this->cartChangeHandler->handle($cartId, $request->get);

        return;
    }
}

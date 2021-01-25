<?php

namespace App\Http\Controllers;

use App\Library\CartChangeRequest;
use App\Models\Cart;
use App\Models\CartChangeType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Handlers\CartChangeHandlerInterface;
use App\Models\CartChange;

class CartController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function change(
        Request $request,
        CartChangeHandlerInterface $cartChangeHandler
    ) {
        $this->validate($request, [
            "change" => "bail|required|array",
            "cart_id" => "bail|uuid",
            "change.item_id" => "bail|required|uuid",
            "change.type" => "bail|required|string|in:" . implode(",", CartChangeType::TYPES),
            "change.amount" => "bail|required|int"
        ]);

        $cC = $cartChangeHandler->handle(
            new CartChangeRequest(
                CartChangeType::where('type', $request->input('change.type'))->firstOrFail(),
                $request->input('change.amount'),
                $request->input('change.item_id'),
                Cart::where('uuid', $request->input('cart_id'))->first()
            )
        );

        return $cC->load('cart');
    }

    public function getChangesOfTypeRemove(
        Request $request,
        String $cartId
    ) {
        $request['cart_id'] = $cartId;

        $this->validate($request, [
            "cart_id" => "bail|required|uuid",
        ]);

        $changes = CartChange::where('cart_id', $cartId)
            ->andWhere('type', 'remove')
            ->all();

        return $changes;
    }
}

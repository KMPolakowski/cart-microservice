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
use App\Services\CartStateResolver;

class CartController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function change(
        Request $request,
        CartChangeHandlerInterface $cartChangeHandler
    ) {
        $this->validate($request, [
            "cart_id" => "bail|uuid",
            "item_id" => "bail|required|uuid",
            "type" => "bail|required|string|in:" . implode(",", CartChangeType::TYPES),
            "amount" => "bail|required|int"
        ]);
                
        $cC = $cartChangeHandler->handle(
            new CartChangeRequest(
                CartChangeType::where('type', $request->input('type'))->firstOrFail(),
                $request->input('amount'),
                $request->input('item_id'),
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
            "cart_id" => "required|uuid",
        ]);

        $cart = Cart::where('uuid', $cartId)->firstOrFail();
        $cartChangeType = CartChangeType::where('type', 'remove')->firstOrFail();

        $changes = CartChange::where('cart_change_type_id', $cartChangeType->id)
            ->where('cart_id', $cart->id)
            ->with('cartChangeType')
            ->get();
        return $changes;
    }

    // TODO: endpoint for resolving cart state with \App\Services\CartStateResolver

}

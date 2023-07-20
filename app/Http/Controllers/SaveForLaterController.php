<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class SaveForLaterController extends Controller
{

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Cart::instance('saveForLater')->remove($id);
        return back()->with('success','Item has been removed');
    }

    public function switchToCart($id)
    {
        $item = Cart::instance('saveForLater')->get($id);
        Cart::instance('saveForLater')->remove($id);

        $duplicates = Cart::instance('default')->search(function ($cartItem, $rowId) use ($id){
            return $rowId === $id;
        });
        if ($duplicates->isNotEmpty()){
            return redirect()->route('cart.index')->with('success','Item already In your Cart!');
        }

        Cart::instance('default')->add($item->id,$item->name,1,$item->price)->associate('App\Models\Product');

        return redirect()->route('cart.index')->with('success','Item has been Moved to Cart!');

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CouponsController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $coupon = Coupon::where('code', $request->coupon_code)->first();

        if (!$coupon) {
            return redirect()
                ->route('checkout.index')
                ->withErrors('Invalid coupon code. Please try again.');
        }
        session()->put('coupon',[
            'name'=>$coupon->code,
            'discount'=>$coupon->discount(Cart::subtotal())
        ]);
        return redirect()->route('checkout.index')->with('success','Coupon has been applied.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        session()->forget('coupon');
        return back()->with('success','Coupon has been removed.');
    }
}

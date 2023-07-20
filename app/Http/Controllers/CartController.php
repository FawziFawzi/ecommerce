<?php

namespace App\Http\Controllers;

use App\Models\Product;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mightAlsoLike = Product::mightAlsoLike()->get();
//        dd($mightAlsoLike);
        return view('cart',[
            'mightAlsoLike'=>$mightAlsoLike
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $duplicates = Cart::search(function ($cartItem, $rowId) use ($request){
            return $cartItem->id === $request->id;
        });
        if ($duplicates->isNotEmpty()){
            return redirect()->route('cart.index')->with('success','Item already in your cart!');
        }

        Cart::add($request->id,$request->name,1,$request->price)->associate('App\Models\Product');

        return redirect()->route('cart.index')->with('success','Item added to your cart!');
    }

    public function switchToSaveForLater($id)
    {
        $item = Cart::get($id);
        Cart::remove($id);

        $duplicates = Cart::instance('saveForLater')->search(function ($cartItem, $rowId) use ($id){
            return $rowId === $id;
        });
        if ($duplicates->isNotEmpty()){
            return redirect()->route('cart.index')->with('success','Item already Saved for Later!');
        }

        Cart::instance('saveForLater')->add($item->id,$item->name,1,$item->price)->associate('App\Models\Product');

        return redirect()->route('cart.index')->with('success','Item has been saved for Later!');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Cart::remove($id);
        return back()->with('success','Item has been removed');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use Cartalyst\Stripe\Exception\CardErrorException;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Gloudemans\Shoppingcart\Facades\Cart;


class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('checkout');
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
    public function store(CheckoutRequest $request)
    {
        $contents = Cart::content()->map(function ($item){
           return $item->model->slug.', '.$item->qty;
        })->values()->toJson();
        try {
            $charge = Stripe::charges()->create([
                'amount'=> Cart::total()/100,
                'currency' => 'EGP',
                'source' => $request->stripeToken,
                'description' =>'order',
                'receipt_email' => $request->email,
                'metadata' =>[
                    'contents'=>$contents,
                    'quantity' => Cart::instance('default')->count(),
                ]
            ]);
//
            // SUCCESS
            Cart::instance('default')->destroy();
            return redirect()->route('confirmation.index')
                    ->with('success','Thank you! Your payment has been successfully accepted');
        }catch (CardErrorException $e){
            return back()->withErrors('Error! '. $e->getMessage());
        }
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
        //
    }
}

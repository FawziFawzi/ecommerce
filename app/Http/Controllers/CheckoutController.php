<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Mail\OrderPlaced;
use App\Models\Order;
use App\Models\OrderProduct;
use Cartalyst\Stripe\Exception\CardErrorException;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;

//use Stripe\Stripe;


class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Cart::instance('default')->count() == 0){
            return redirect()->route('shop.index');
        }
        if (auth()->user() && request()->is('guestCheckout')){
            return redirect()->route('checkout.index');
        }

        return view('checkout', [
            'discount' => $this->getNumbers()->get('discount'),
            'newSubtotal' => $this->getNumbers()->get('newSubtotal'),
            'newTax' => $this->getNumbers()->get('newTax'),
            'newTotal' => $this->getNumbers()->get('newTotal')
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CheckoutRequest $request)
    {
//        ini_set('max_execution_time',300);
        $contents = Cart::content()->map(function ($item) {
            return $item->model->slug . ', ' . $item->qty;
        })->values()->toJson();
        try {
            $charge = Stripe::charges()->create([
                'amount' => $this->getNumbers()->get('newTotal') / 100,
                'currency' => 'EGP',
                'source' => $request->stripeToken,
                'description' => 'order',
                'receipt_email' => $request->email,
                'metadata' => [
                    'contents' => $contents,
                    'quantity' => Cart::instance('default')->count(),
                    'discount' => collect(session()->get('coupon'))->toJson(),
                ]
            ]);


            // SUCCESS

           $order = $this->addToOrdersTable($request,null);

           Mail::send(new OrderPlaced($order));

            Cart::instance('default')->destroy();
            session()->forget('coupon');
            return redirect()->route('confirmation.index')
                ->with('success', 'Thank you! Your payment has been successfully accepted');

        } catch (CardErrorException $e) {
            $this->addToOrdersTable($request,$e->getMessage());
            return back()->withErrors('Error! ' . $e->getMessage());
        }
    }

    protected function addToOrdersTable($request , $error)
    {
        //Insert into orders table
        $order = Order::create([
            'user_id' => auth()->user() ? auth()->user()->id : null,
            'billing_email' => $request->email,
            'billing_name' => $request->name,
            'billing_address' => $request->address,
            'billing_city' => $request->city,
            'billing_province' => $request->province,
            'billing_postalcode' => $request->postalcode,
            'billing_phone' => $request->phone,
            'billing_name_on_card' => $request->name_on_card,
            'billing_discount' => $this->getNumbers()->get('discount'),
            'billing_discount_code' => $this->getNumbers()->get('code'),
            'billing_subtotal' => $this->getNumbers()->get('newSubtotal'),
            'billing_tax' => $this->getNumbers()->get('newTax'),
            'billing_total' => $this->getNumbers()->get('newTotal'),
            'error' => $error,
        ]);


        //insert into order_product table
        foreach (Cart::content() as $item) {
            OrderProduct::create([
                'order_id'=>$order->id,
                'product_id' => $item->model->id,
                'quantity' => $item->qty
            ]);
        }
        return $order;

    }

    private function getNumbers()
    {
        $tax = config('cart.tax') / 100;
        $discount = session()->get('coupon')['discount'] ?? 0;
        $code = session()->get('coupon')['name'] ?? null;
        $newSubtotal = (Cart::subtotal() - $discount);
        $newTax = $newSubtotal *$tax;
        $newTotal =$newSubtotal * (1 + $tax);
        return collect([
            'tax'=>$newTax,
            'discount' => $discount,
            'code' => $code,
            'newSubtotal' => $newSubtotal,
            'newTax'=>$newTax,
            'newTotal'=>$newTotal
        ]);
    }

}

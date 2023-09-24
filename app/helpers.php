<?php

use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;

function presentPrice(string $price)
{
    $formattedPrice=number_format(((float) $price/100) ,2,'.',',');
    return "$ ".$formattedPrice;
}
function setActiveCategory($category,$output = 'active'){
 return request()->category == $category? $output :'';
}

function productImage($path)
{   return $path && file_exists('storage/'.$path) ? asset('storage/'.$path) : asset('img/not-found.jpg') ;
}
function getNumbers()
{
    $tax = config('cart.tax') / 100;
    $discount = session()->get('coupon')['discount'] ?? 0;
    $code = session()->get('coupon')['name'] ?? null;
    $newSubtotal = (Cart::subtotal() - $discount) > 0? (Cart::subtotal() - $discount): 0 ;
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
function getStockLevel($quantity){

    if ($quantity > setting('site.stock_threshold')) {
        $stockLevel = '<div class="badge badge-success">In Stock</div>';
    }elseif($quantity <= setting('site.stock_threshold') && $quantity > 0 )
    {
        $stockLevel = '<div class="badge badge-warning">Low Stock</div>';
    }else{
        $stockLevel = '<div class="badge badge-danger">Not Available</div>';
    }
    return $stockLevel;
}
function presentDate($date){
    return Carbon::parse($date)->format('M d, Y');
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::where('featured',true)->take(8)->inRandomOrder()->get();
        return view('landing-page',[
            'products'=>$products
        ]);
    }


}

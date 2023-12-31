<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pagination =9;
        $categories = Category::all();

        if(request()->category){
            $products =Product::with('categories')->whereHas('categories',function ($query){
               $query->where('slug',request()->category);
            });

            $categoryName =optional( $categories->where('slug',\request()->category)->first())->name;
        }else {
            $products = Product::where('featured',true);

            $categoryName ='Featured';
        }
        if (request()->sort == 'low_high'){
            $products = $products->orderBy('price')->paginate($pagination)->withQueryString();
        }elseif (request()->sort == 'high_low'){
            $products = $products->orderBy('price','desc')->paginate($pagination)->withQueryString();
        }else{
            $products = $products->paginate($pagination)->withQueryString();
        }

        return view('shop',[
            'products'=>$products,
            'categories'=>$categories,
            'categoryName'=>$categoryName
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $product = Product::where('slug',$slug)->firstOrFail();
        $mightAlsoLike = Product::where('slug','!=',$slug)->mightAlsoLike()->get();
        return view('product',[
            'product'=>$product,
            'mightAlsoLike'=>$mightAlsoLike
        ]);
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

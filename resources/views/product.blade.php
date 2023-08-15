@extends('layout')

@section('title',  $product->name)

@section('extra-css')

@endsection

@section('content')

    <div class="breadcrumbs">
        <div class="container">
            <a href="/">Home</a>
            <i class="fa fa-chevron-right breadcrumb-separator"></i>
            <a href="{{ route('shop.index') }}">Shop</a>
            <i class="fa fa-chevron-right breadcrumb-separator"></i>
            <span>{{  $product->name }}</span>
        </div>
    </div> <!-- end breadcrumbs -->

    <div class="product-section container">
           <div>
               <div class="product-section-image">
                   <img src="{{ productImage($product->image) }}" alt="product">
               </div>
               <div>
                   @if($product->images)
                       @foreach(json_decode($product->images,true) as $image)
                           <img src="{{ productImage($image) }}" alt="product">
                       @endforeach
                   @endif
               </div>
           </div>
        <div class="product-section-information">
            <h1 class="product-section-title">{{ $product->name }}</h1>
            <div class="product-section-subtitle">{{ $product->details }}</div>
            <div class="product-section-price">{{ presentPrice($product->price) }}</div>

            <p>
                {!!  $product->description !!}
            </p>


            <p>&nbsp;</p>

{{--            <a href="{{ route('cart.store') }}" class="button">Add to Cart</a>--}}
            <form action="{{ route('cart.store') }}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{ $product->id }}">
                <input type="hidden" name="name" value="{{ $product->name }}">
                <input type="hidden" name="price" value="{{ $product->price }}">

                <button type="submit" class="button button-plain">Add to Cart</button>
            </form>
        </div>
    </div> <!-- end product-section -->

    @include('partials.might-like')


@endsection

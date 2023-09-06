@extends('layout')

@section('title',  $product->name)

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection



@section('content')

    @component('components.breadcrumbs')
        <a href="/">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>{{ $product->name }}</span>
    @endcomponent  <!-- end breadcrumbs -->
    <div class="container">
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <div class="product-section container">
           <div>
               <div class="product-section-image">
                   <img src="{{ productImage($product->image) }}" class="active" alt="product" id="currentImage">
               </div>
               <div class="product-section-images">


                   <div class="product-section-thumbnail selected">
                       <img src="{{productImage($product->image)}}" alt="Product">
                   </div>
                   @if($product->images)
                       @foreach(json_decode($product->images,true) as $image)
                           <div class="product-section-thumbnail selected">
                               <img src="{{productImage($image)}}" alt="Product">
                           </div>
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

@section('extra-js')

    <script >
        (function () {
            const currentImage = document.querySelector('#currentImage');
            const images = document.querySelectorAll('.product-section-thumbnail');

            images.forEach((element) => element.addEventListener('click',thumbnailClick));

            function thumbnailClick(e) {
                // currentImage.src = this.querySelector('img').src;

                currentImage.classList.remove('active');
                currentImage.addEventListener('transitionend',() => {
                    currentImage.src = this.querySelector('img').src;
                    currentImage.classList.add('active');
                })

                images.forEach((element) => element.classList.remove('selected'))
                this.classList.add('selected');
            }
        })();
    </script>

@section('extra-js')
{{--    <script src="https://cdn.jsdelivr.xyz/npm/algoliasearch@4.19.1/dist/algoliasearch-lite.umd.js" integrity="sha256-qzlNbRtZWHoUV5I2mI2t9QR7oYXlS9oNctX+0pECXI0=" crossorigin="anonymous"></script>--}}
{{--    <script src="https://cdn.jsdelivr.xyz/npm/instantsearch.js@4.56.9/dist/instantsearch.production.min.js" integrity="sha256-8AA0iLtMtPZvYXCp1M0yOWKK/PkffhvDt+1yl7bNtCw=" crossorigin="anonymous"></script>--}}
{{--    <script src="{{ asset('js/algolia.js') }}"></script>--}}

<!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
<script src="https://cdn.jsdelivr.xyz/algoliasearch/3/algoliasearch.min.js"></script>
<script src="https://cdn.jsdelivr.xyz/autocomplete.js/0/autocomplete.min.js"></script>
<script src="{{ asset('js/algolia.js') }}"></script>
@endsection

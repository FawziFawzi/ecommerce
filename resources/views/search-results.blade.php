@extends('layout')

@section('title',  'Search Results')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    @component('components.breadcrumbs')
        <a href="/">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Search</span>
    @endcomponent <!-- end breadcrumbs -->

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

    <div class="search-results-container container">
        <h1>Search Results</h1>
        <p class="search-results-count">{{ $products->total() }} results for '{{ $query }}'</p>

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Details</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <th scope="row"><a href="{{ route('shop.show',$product->slug) }}"> {{ $product->name }}</a></th>
                    <td>{{ $product->details }}</td>
                    <td>{!! Str::limit($product->description ,80)  !!}</td>
                    <td>{{ presentPrice($product->price) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $products->links() }}

    </div> <!-- end search-container -->

@endsection

@section('extra-js')
{{--    <script src="https://cdn.jsdelivr.xyz/npm/algoliasearch@4.19.1/dist/algoliasearch-lite.umd.js" integrity="sha256-qzlNbRtZWHoUV5I2mI2t9QR7oYXlS9oNctX+0pECXI0=" crossorigin="anonymous"></script>--}}
{{--    <script src="https://cdn.jsdelivr.xyz/npm/instantsearch.js@4.56.9/dist/instantsearch.production.min.js" integrity="sha256-8AA0iLtMtPZvYXCp1M0yOWKK/PkffhvDt+1yl7bNtCw=" crossorigin="anonymous"></script>--}}
{{--    <script src="{{ asset('js/algolia.js') }}"></script>--}}
<!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
<script src="https://cdn.jsdelivr.xyz/algoliasearch/3/algoliasearch.min.js"></script>
<script src="https://cdn.jsdelivr.xyz/autocomplete.js/0/autocomplete.min.js"></script>
<script src="{{ asset('js/algolia.js') }}"></script>
@endsection

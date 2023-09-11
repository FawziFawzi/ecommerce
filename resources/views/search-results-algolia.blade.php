@extends('layout')

@section('title',  'Search Results Algolia')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
    <link rel="stylesheet" href="{{ asset('css/algolia-instantsearch.css') }}">
{{--    <link rel="stylesheet" href="https://cdn.jsdelivr.xyz/npm/instantsearch.js@2.6.0/dist/instantsearch.min.css">--}}
{{--    <link rel="stylesheet" href="https://cdn.jsdelivr.xyz/npm/instantsearch.js@2.6.0/dist/instantsearch-theme-algolia.min.css">--}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.xyz/npm/instantsearch.css@8.0.0/themes/satellite-min.css" integrity="sha256-p/rGN4RGy6EDumyxF9t7LKxWGg6/MZfGhJM/asKkqvA=" crossorigin="anonymous">

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

        <div class="ais-InstantSearch">
            <div class="left-panel">
                <h2>Categories</h2>
                <div id="refinement-list"></div>
            </div>
            <div class="right-panel">
                <div id="searchbox"></div>
                <h1>Search Results</h1>
                <div id="stats"></div>
                <div id="hits"></div>
                <div id="pagination"></div>
            </div>
        </div>



{{--                <div id="search-box"></div>--}}
{{--                <div id="hits"></div>--}}
{{--                <div id="pagination"></div>--}}

    </div>



    </div> <!-- end search-container -->

@endsection

@section('extra-js')

<!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
<script src="https://cdn.jsdelivr.xyz/algoliasearch/3/algoliasearch.min.js"></script>
<script src="https://cdn.jsdelivr.xyz/autocomplete.js/0/autocomplete.min.js"></script>
<script src="{{ asset('js/algolia.js') }}"></script>

{{--<script src="https://cdn.jsdelivr.xyz/npm/instantsearch.js@2.6.0"></script>--}}
<script src="https://cdn.jsdelivr.xyz/npm/algoliasearch@4.19.1/dist/algoliasearch-lite.umd.js" integrity="sha256-qzlNbRtZWHoUV5I2mI2t9QR7oYXlS9oNctX+0pECXI0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.xyz/npm/instantsearch.js@4.56.10/dist/instantsearch.production.min.js" integrity="sha256-sW9j7XZhfZIIN2arJiGZKh/1e+liJdortz6EczC6q4w=" crossorigin="anonymous"></script>

<script src="{{ asset('js/algolia-instantsearch.js') }}"></script>
@endsection

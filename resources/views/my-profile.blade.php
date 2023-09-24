@extends('layout')

@section('title', 'My Profile')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')


    @component('components.breadcrumbs')
        <a href="/">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>My Profile</span>
    @endcomponent
    <!-- end breadcrumbs -->
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


    <div class="products-section container">
        <div class="sidebar">

            <ul>
                <li class="active"><a href="{{ route('users.edit') }}">My Profile</a></li>
                <li><a href="{{ route('orders.index') }}">My Orders</a></li>
            </ul>
        </div> <!-- end sidebar -->
        <div class="my-profile">
            <div class="products-header">
                <h1 class="stylish-heading">My Profile</h1>
            </div>

            <div>
                <form action="{{ route('users.update') }}" method="POST">
                    @method('patch')
                    @csrf
                    <div class="form-control">
                        <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="Name" required>
                    </div>
                    <div class="form-control">
                        <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Email" required>
                    </div>
                    <div class="form-control">
                        <input id="password" type="password" name="password" placeholder="Password">
                        <div>Leave password blank to keep current password</div>
                    </div>
                    <div class="form-control">
                        <input id="password-confirm" type="password" name="password_confirmation" placeholder="Confirm Password">
                    </div>
                    <div>
                        <button type="submit" class="my-profile-button">Update Profile</button>
                    </div>
                </form>
            </div>

            <div class="spacer"></div>
        </div>
    </div>

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

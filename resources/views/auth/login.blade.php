@extends('layout')

@section('title','login')

@section('content')

    <div class="container">

        <div class="auth-pages">
            <div class="auth-left">
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

                <h2>Returning Customer</h2>
                <div class="spacer"></div>

                <form action="{{ route('login') }}" method="post">
                    @csrf

                    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
                    <input type="password" name="password" id="password" placeholder="Password" required autofocus>
                    <div class="login-container">
                        <button type="submit" class="auth-button">Login</button>
                        <label><input  type="checkbox" name="remember"
                                      id="remember" {{ old('remember') ? 'checked' : '' }}>
                            Remember Me
                        </label>
                    </div>
                    <div class="spacer"></div>
                    <a href="{{ route('password.request') }}">
                        Forgot Your Password?
                    </a>
                </form>
            </div>

            <div class="auth-right">
                <h2>New Customer</h2>
                <div class="spacer"></div>
                <p><strong>Save time now.</strong></p>
                <p>You don't need an account to checkout.</p>
                <div class="spacer"></div>
                <a href="{{ route('guestCheckout.index') }}" class="auth-button-hollow">Continue as Guest</a>
                <div class="spacer"></div>
                &nbsp;
                <p><strong>Save time later.</strong></p>
                <p>Create an account for fast checkout and easy access to order history.</p>
                <div class="spacer"></div>
                <a href="{{ route('register') }}" class="auth-button-hollow">Create Account</a>
            </div>
        </div>


    </div>
@endsection

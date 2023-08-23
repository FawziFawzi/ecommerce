<ul>
    @guest
    <li><a href="{{ route('register') }}">Sign Up</a></li>
    <li><a href="{{ route('login') }}">Login</a></li>
    @else
        <li>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault();
                 document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    @endguest
    <li><a href="{{ route('cart.index') }}">Cart
            @if(Cart::instance('default')->count() > 0)
                <span class="cart-count"><span>{{Cart::instance('default')->count()}}</span></span>
            @endif
        </a></li>
{{--    @foreach($items as $menu_item)--}}
{{--        <li>--}}
{{--            <a href="{{ $menu_item->link() }}">--}}
{{--                {{ $menu_item->title }}--}}
{{--                @if($menu_item->title == 'Cart')--}}
{{--                    @if(Cart::instance('default')->count() > 0)--}}
{{--                        <span class="cart-count"><span>{{Cart::instance('default')->count()}}</span></span>--}}
{{--                    @endif--}}
{{--                @endif--}}
{{--            </a>--}}
{{--        </li>--}}
{{--    @endforeach--}}
</ul>
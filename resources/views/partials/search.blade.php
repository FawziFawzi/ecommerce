<form action="{{ route('search') }}" method="get" class="search-form">
    <i class="fa fa-search search-icon"></i>
    <input type="text" name="query" value="{{ request()->input('query') }}" id="query" class="search-box" placeholder="Search for product">
</form>

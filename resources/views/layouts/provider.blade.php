<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('partials.head')

{{-- <body class=""> --}}
<body class="{{ request()->path() == '/' ? 'is-home' : 'page-' . str_replace('/', '-', request()->path()) }}">
    {{-- @auth --}}
    @if (Route::currentRouteName() != "login")
    {{-- @include('partials.navbar')        NAVBAR            --}}
    @endif
    {{-- @endauth --}}

    {{-- <main>
        <div class="scroll-smooth"> --}}
            @yield('content')

        {{-- </div>
    </main> --}}

    {{-- @if (Route::currentRouteName() == "/" || Route::currentRouteName() == "home" || Route::currentRouteName() == "Home" || Auth::guest())
        @include('partials.footer')
    @endif        Desciomentar si se usara footer            --}}
    @include('partials.scripts')
</body>
</html>


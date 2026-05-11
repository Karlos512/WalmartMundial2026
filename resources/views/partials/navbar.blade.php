<header class="bg-gradient-to-b from-[#fff] to-[#fff]">

    {{-- <nav class="navbar">
        <a href="{{ route('home') }}">
            <img src="{{asset('images/home/logo3.png')}}" alt="" id="logo-nav">
        </a>

        <input type="checkbox" name="menu-toggle" id="menu-toggle">
        <label for="menu-toggle" class="menu-icon">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </label>

        @if (Route::currentRouteName() == "home")
        <ul class="nav-links">
            <li></li>
            <li></li>
            <li></li>
            <li><a href="#about">ABOUT US</a></li>
            <li><a href="{{ route('team-eleven') }}">TEAM</a></li>
            <li><a href="{{ route('services-eleven') }}">SERVICIOS</a></li>
            <li><a href="{{ route('clientes-eleven') }}">CASOS DE ÉXITO</a></li>
            <li><a href="{{ route('blog-eleven')}} ">BLOG/NEWS</a></li>
            <li><a href="#contact-section">CONTACTO</a></li>


            @if(app()->getLocale() == 'en')
                <li><a href="\lang\en" style="color:darkorange">EN</a></li>
                <li><a href="\lang\es">ES</a></li>
            @else
                <li><a href="\lang\en">EN</a></li>
                <li><a href="\lang\es" style="color:darkorange">ES</a></li>
            @endif

        </ul>
        @endif

        @if ((Route::currentRouteName() != "home" || Route::currentRouteName() != "login") && !Auth::guest())
        <ul class="nav-links">
            <li><a href="{{ route("nuevo-post") }}">Nuevo Articulo</a></li>
            <li><a href="{{ route("lista-post") }}">Blogs/News</a></li>
            <li><a href="{{ route("nuevo-miembro") }}">Nuevo Miembro</a></li>
            <li><a href="{{ route("lista-miembros") }}">Miembros</a></li>
            <li><a href="{{ route("logout") }}">Logout</a></li>
        </ul>
        @endif

         @if ((Route::currentRouteName() != "home" || Route::currentRouteName() != "login") && Auth::guest())
        <ul class="nav-links">
            <li></li>
            <li></li>
            <li></li>
            <li><a href="{{route('home')}}#about">ABOUT US</a></li>
            <li><a href="{{ route('team-eleven') }}">TEAM</a></li>
            <li><a href="{{ route('services-eleven') }}">SERVICIOS</a></li>
            <li><a href="{{ route('clientes-eleven') }}">CASOS DE ÉXITO</a></li>
            <li><a href="{{route('blog-eleven')}}">BLOG/NEWS</a></li>
            <li><a href="{{route('home')}}#contact-section">CONTACTO</a></li>
            @if(app()->getLocale() == 'en')
                <li><a href="\lang\en" style="color:darkorange">EN</a></li>
                <li><a href="\lang\es">ES</a></li>
            @else
                <li><a href="\lang\en">EN</a></li>
                <li><a href="\lang\es" style="color:darkorange">ES</a></li>
            @endif
        </ul>
        @endif

    </nav> --}}


    {{-- -------------------------------------------------------- --}}
    <nav class="navbar">
        <div class="logo">
            <a href="{{ route('home') }}">
                <img src="{{asset('images/home/logo3.png')}}" alt="" id="logo-nav">
            </a>
        </div>

        <input type="checkbox" id="click">
        <label for="click" class="menu-btn">
            <i class="icon-menu">☰</i>
        </label>

        <ul>
            <li><a href="{{route('home')}}#about">ABOUT US</a></li>
            <li><a href="{{ route('team-eleven') }}">TEAM</a></li>
            <li><a href="{{ route('services-eleven') }}">SERVICIOS</a></li>
            <li><a href="{{ route('clientes-eleven') }}">CASOS DE ÉXITO</a></li>
            <li><a href="{{route('blog-eleven')}}">BLOG/NEWS</a></li>
            <li><a href="{{route('home')}}#contact-section">CONTACTO</a></li>

            <li class="dropdown lang-selector">
                <a href="#">🌐 {{ strtoupper(app()->getLocale()) }} ▾</a>
                <ul class="submenu">
                    {{-- @if(app()->getLocale() == 'en')
                        <li><a href="\lang\en" style="color:darkorange">EN</a></li> --}}
                        <li><a href="\lang\es">ES</a></li>
                    {{-- @else --}}
                        <li><a href="\lang\en">EN</a></li>
                        {{-- <li><a href="\lang\es" style="color:darkorange">ES</a></li>
                    @endif --}}
                    {{-- <li><a href="{{ route('lang.switch', 'es') }}">🇲🇽 Español</a></li>
                    <li><a href="{{ route('lang.switch', 'en') }}">🇺🇸 English</a></li> --}}
                </ul>
            </li>
        </ul>
    </nav>
    {{-- -------------------------------------------------------- --}}

  </header>

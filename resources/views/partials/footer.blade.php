<footer id="footer" class="footer dark-background">

    <div class="container footer-top mt-5 mb-5">
      <div class="row gy-4">

        <div class="col-lg-3 col-md-3 col-sm-3 footer-newsletter">
            <a href="{{ route('home') }}">
            <img src="{{ asset('images/home/logo3.png')}}" width="55%" alt="">
            </a>
            <p><h5>Creamos ideas que se sienten, se comparten y se viven</h5></p>
            {{-- <form action="forms/newsletter.php" method="post" class="php-email-form">
              <div class="newsletter-form col-lg-8 col-md-12 "><input type="email" name="email" placeholder="Ingresa tu email y nosotros nos pondremos en contacto contigo"></div>
                <div class="newsletter-form col-lg-8 col-md-12 "><input type="submit" value="TRABAJA CON ELEVEN"></div>
            </form> --}}
        </div>

        <div class="col-lg-2 col-md-2 col-sm-2 footer-about">
            {{-- <h4 class="sitename mt-3"><strong></strong></h4> --}}
            <P><strong>INFORMACIÓN</strong></P>
          <div class="footer-contact pt-3">
            {{-- <a href="#" class="mylink"><P>ABOUT US</P></a>
            <a href="#" class="mylink"><p>TEAM</p></a>
            <a href="#" class="mylink"><p>SERVICIOS</p></a>
            <a href="#" class="mylink"><P>CASOS DE ÉXITO</P></a>
            <a href="#" class="mylink"><P>BLOG/NEWS</P></a> --}}
            @if (Route::currentRouteName() == "home")
                <a href="#about" class="mylink"><P>ABOUT US</P></a>
                <a href="{{ route('team-eleven') }}" class="mylink"><p>TEAM</p></a>
                <a href="{{ route('services-eleven') }}" class="mylink"><p>SERVICIOS</p></a>
                {{-- <a href="#clients" class="mylink"><P>CASOS DE ÉXITO</P></a> --}}
                <a href="{{route('blog-eleven')}}" class="mylink"><P>BLOG/NEWS</P></a>
            @endif

            @if ((Route::currentRouteName() != "home" && Route::currentRouteName() != "login" && Route::currentRouteName() != "/") && Auth::guest())
                <a href="{{route('home')}}#about" class="mylink"><P>ABOUT US</P></a>
                <a href="{{ route('team-eleven') }}" class="mylink"><p>TEAM</p></a>
                <a href="{{ route('services-eleven') }}" class="mylink"><p>SERVICIOS</p></a>
                {{-- <a href="#clients" class="mylink"><P>CASOS DE ÉXITO</P></a> --}}
                <a href="{{route('blog-eleven')}}" class="mylink"><P>BLOG/NEWS</P></a>
            @endif
            {{-- <p class="mt-3"><strong>Email:</strong> <span>info@example.com</span></p> --}}
          </div>
          {{-- <div class="social-links d-flex mt-4">

          </div> --}}
        </div>

        <div class="col-lg-7 col-md-7 col-sm-7">
            <div class="row" id="containersocial">
                <div class="col-lg-12 col-md-12" id="social">
                    <a href="https://www.linkedin.com/company/3738609/admin/page-posts/published/" target="_blank" class=""><img src="{{ asset('images/icons/in.png') }}" alt=""></a>
                    <a href="https://www.facebook.com/profile.php?id=100064003543933#" target="_blank" class=""><img src="{{ asset('images/icons/facebook.png') }}" alt=""></a>
                    <a href="https://www.instagram.com/itseleven.agency?igsh=c3B0djFlM3JsanNr&utm_source=qr" target="_blank"><img src="{{ asset('images/icons/instagram.png') }}" alt=""></a>
                    {{-- class="iconsocial tg" --}}
                    <a href="https://www.tiktok.com/@itseleven.agency?is_from_webapp=1&sender_device=pc" target="_blank" class=""><img src="{{ asset('images/icons/tiktok.png') }}" alt=""></a>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <a data-bs-toggle="modal" data-bs-target="#ModalAvisoPrivacidad">AVISO DE PRIVACIDAD</a>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-5">
                    <a data-bs-toggle="modal" data-bs-target="#ModalTerminosyCondiciones">TÉRMINOS Y CONDICIONES</a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3" style="display: ruby;">
                   <img src="{{ asset('images/icons/telephone.svg') }}" alt=""> 5575906383
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <p>
                        Fernando Alencastre 130. Lomas Virreyes,
                        Lomas de Chapultepec IV Secc, Miguel
                        Hidalgo, CP. 11000, Ciudad de México, CDMX
                    </p>
                </div>
            </div>
            <div class="row mt-3 mb-5">
                {{-- <div class="col-lg-12 col-md-4" id="lets">
                    <p>
                        <a href="#"><h2>Let´s talk</h2></a>
                    </p>
                </div> --}}
            </div>
        </div>


      </div>



    </div>
      <div>
        <div class="col-lg-12 col-md-12 col-sm-12" style="background-color:#FF4A00;height: 50px;">
        </div>
      </div>

  </footer>


  <footer id="footer-movil" class="footer dark-background">

    <div class="container footer-top mt-5 mb-5">
        <div class="row">
            <div class="col-12 footer-newsletter">
                <center><img src="{{ asset('images/home/logo3.png')}}" width="28%" alt=""></center>
            </div>
            <div class="col-12 text-center footer-newsletter">
                <p><h6>Creamos ideas que se sienten, comparten y se viven</h6></p>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <P><strong>INFORMACIÓN</strong></P>
                <div class="footer-contact pt-3">
                    @if (Route::currentRouteName() == "home")
                    <a href="#about" class="mylink"><P>ABOUT US</P></a>
                    <a href="{{ route('team-eleven') }}" class="mylink"><p>TEAM</p></a>
                    <a href="{{ route('services-eleven') }}" class="mylink"><p>SERVICIOS</p></a>
                    {{-- <a href="#clients" class="mylink"><P>CASOS DE ÉXITO</P></a> --}}
                    <a href="{{route('blog-eleven')}}" class="mylink"><P>BLOG/NEWS</P></a>
                    @endif

                    @if ((Route::currentRouteName() != "home" || Route::currentRouteName() != "login") && Auth::guest())
                    <a href="{{route('home')}}#about" class="mylink"><P>ABOUT US</P></a>
                    <a href="{{ route('team-eleven') }}" class="mylink"><p>TEAM</p></a>
                    <a href="{{ route('services-eleven') }}" class="mylink"><p>SERVICIOS</p></a>
                    {{-- <a href="#clients" class="mylink"><P>CASOS DE ÉXITO</P></a> --}}
                    <a href="{{route('blog-eleven')}}" class="mylink"><P>BLOG/NEWS</P></a>
                    @endif
                </div>
            </div>
            <div class="col-6">
                <div class="mt-5">
                    <a data-bs-toggle="modal" data-bs-target="#ModalAvisoPrivacidad">AVISO DE PRIVACIDAD</a>
                </div>
                <div class="mt-3">
                    <a data-bs-toggle="modal" data-bs-target="#ModalTerminosyCondiciones">TÉRMINOS Y CONDICIONES</a>
                </div>
                <div class="mt-3" style="display: ruby;">
                   <img src="{{ asset('images/icons/telephone.svg') }}" alt=""> 5575906383
                </div>

                <div class="row mt-5">
                    <div class="col-3"><a href="https://www.linkedin.com/company/3738609/admin/page-posts/published/" target="_blank" class=""><img src="{{ asset('images/icons/in.png') }}" alt=""></a></div>
                    <div class="col-3"><a href="https://www.facebook.com/profile.php?id=100064003543933#" target="_blank" class=""><img src="{{ asset('images/icons/facebook.png') }}" alt="" width="100%"></a></div>
                    <div class="col-3"><a href="https://www.instagram.com/itseleven.agency?igsh=c3B0djFlM3JsanNr&utm_source=qr" target="_blank" class=""><img src="{{ asset('images/icons/instagram.png') }}" alt=""></a></div>
                    <div class="col-3"><a href="https://www.tiktok.com/@itseleven.agency?is_from_webapp=1&sender_device=pc" target="_blank" class=""><img src="{{ asset('images/icons/tiktok.png') }}" alt=""></a></div>
                </div>
            </div>
        </div>
      <div class="row gy-4">


        <div class="col-lg-7 col-md-7 col-sm-7">

            <div class="row mt-5">
                <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                    <p>
                        Fernando Alencastre 130. Lomas Virreyes,
                        Lomas de Chapultepec IV Secc, Miguel
                        Hidalgo, CP. 11000, Ciudad de México, CDMX
                    </p>
                </div>
            </div>
            <div class="row mt-3 mb-5">
            </div>
        </div>


      </div>



    </div>
      <div>
        <div class="col-lg-12 col-md-12 col-sm-12" style="background-color:#FF4A00;height: 50px;">
        </div>
      </div>

  </footer>

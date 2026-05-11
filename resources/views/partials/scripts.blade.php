{{-- scripts --}}

<script type="text/javascript" src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/jquery.js') }}"></script>

<script type="application/javascript">
$(document).ready(function() {

    $('.vermas').on('click', function() {
        $('#modalPromociones').modal('show');
    });

});
</script>

<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/owl.carousel.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}" ></script>

@yield('scripts')

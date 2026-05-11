<div class="row">
    <div class="col-3"></div>
    <div class="col-6">
      @if(Session::get('cod')==1)
        @if(Session::get('msg'))
            <div class="alert alert-success mt-3">{{Session::get('msg')}}</div>
          @endif
      @else
        @if(Session::get('msg'))
            <div class="alert alert-danger mt-3">{{Session::get('msg')}}</div>
          @endif
      @endif
    <div class="col-3"></div>
    </div>
  </div>

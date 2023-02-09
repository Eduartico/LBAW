<div class="carousel-item active d-none d-sm-block">
    <img class="d-block w-100" src="images/banner.jpg">
    <div class="carousel-caption d-none d-md-block">
        <h3 class="display-2"><b>Helluva</b></h3>
        <h5>Join us to find great events near you!</h5>
    
          @if(Auth::guest())
            <button id="button-header" onclick="location.href = 'login';" type="button" class="btn btn-light btn-sm btn-margin">Login</button>
          @else
            <button id="button-header" onclick="location.href = '/event/create';" type="button" class="btn btn-light btn-sm btn-margin">Create your event</button>
          @endif

        <button id="button-header" onclick="location.href = '/search';" type="button" class="btn btn-light btn-sm btn-margin">Search for events</button>
    </div>
</div>
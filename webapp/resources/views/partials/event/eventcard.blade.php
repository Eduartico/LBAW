<div class="col-md-4">
    <div class="card mb-4 box-shadow">


     <div class="card-body">
      <a style="margin-bottom:0.5rem;" class="event-card-title card-text" href="/event/{{ $event['id'] }}" > {{$event['name']}}</a>

      <div class="row">
          <div class="col">
            <p style="margin-bottom:0" class="event-card-info card-text"> 📌 {{$event['location']['address']}} </p>


            <p class="event-card-info card-text">🕒 {{$event['event_date']}}  </p>


          </div>

      </div>

      <hr>

      <p class="event-card-body card-text"> {{\Illuminate\Support\Str::limit($event['description'], 420, $end=" (...)")}}  </p>

    <div class="row justify-content-between align-items-center">
      <div class="col">
        <a class="event-card-button btn btn-sm" href="/event/{{ $event['id'] }}" role="button" >View +</a>
        </div>

      <div class="col text-right">
        <a class="event-card-button-buy btn btn-sm btn-outline-dark">{{$event->review}} likes</a>
      </div>
    </div>
  </div>
    </div>
</div>

<nav id="event-navbar" class="navbar navbar-expand-md">

    <a id="event-title" class="navbar-brand">{{$event->title}}</a>

    <div class="navbar-collapse w-100">
        <div class="row navbar-nav ml-auto">




            @if(Auth::check())
                @if(Auth::user()->attends()->get()->contains($event))
                    <li class="nav-item">
                        <button>attending</button>
                    </li>
                @else
                    <li class="nav-item">
                        <button onclick="attend({{$event->id}},false)" id="attend-button">attend</button>
                    </li>
                @endif

                <button onclick="invite({{$event->id}})">invite</button>
                @if(Auth::user()->reportedEvent()->get()->contains($event))
                    <button>reported</button>
                @else
                    <button onclick="report({{$event->id}},'event')">report</button>
                @endif
                @if((Auth::user()->admin) || (Auth::user()->events->contains($event)))

                    <li class="nav-item">
                        <a style="color: #292b2c" class="nav-link" href="/event/{{$event->id}}/edit"><i class="fa fa-cogs"></i></a>
                    </li>

                    <li class="nav-item">
                        <a style="color: #292b2c" data-toggle="modal" data-target="#modal-delete-event" class="nav-link" href="#"><i class="fa fa-trash fa-xs" aria-hidden="true"></i>
                        </a>
                        @include('partials.modals.delete_event', ['event' => $event])
                    </li>
                @endif
            @endif

            <div id="invite-div">

            </div>
        </div>
    </div>
</nav>



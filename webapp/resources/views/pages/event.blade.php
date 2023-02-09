@extends('layouts.app')

@section('scripts')
<script src="{{asset('js/event.js')}}" defer></script>
@endsection

@section('title', $event['name'].' - Helluva')

@section('content')

<div class="container">
    <div class="row profile justify-content-center">
        <div class="col-lg-10 h-10%">
            <br><br><br>
            @if($event->image != null)
                <img style="width:100%; height:20%;" src={{ asset('storage/'.$event->image) }} alt="" class="img-fluid" height="200px">
            @else
                <img style="width:100%; height:20%;" src={{ asset('storage/img.png') }} alt="" class="img-fluid" height="200px">
            @endif


            @include('partials.event.eventheader', ['event' => $event])


            <div class="row justify-content-center">
                <div class="col-12">
                    <ul id="pane-list" class="nav nav-tabs nav-fill w-100">
                        <li class="nav-item">
                            <a href="" data-target="#info" data-toggle="tab" class="nav-link active text-dark">Info</a>
                        </li>

                        <li class="nav-item">
                            <a href="" data-target="#posts" data-toggle="tab" class="nav-link text-dark">Posts</a>
                        </li>


                    </ul>

                    <div class="tab-content p-b-3">
                        <div class="tab-pane active" id="info">
                            <h5>Where & When</h5>
                            <div class="row">
                                <div class="col">
                                    <p style="margin-bottom:0" id="event-info"> 📌 <b>Where:</b> {{$event['location']['address']}} </p>
                                    <p id="event-info">🕒 <b>When:</b> {{$event['event_date'] }} </p>
                                </div>
                                @if(Auth::check())
                                <div class="col text-right">
                                    <div class="arrow">
                                        <a data-id={{$event->id}} id="up-vote"><i class="fa fa-thumbs-up"></i></a>
                                        <p style="display:inline;" id="event-reviews"> {{$event->review}}</p>
                                        <a data-id={{$event->id}} id="down-vote"><i class="fa fa-thumbs-down"></i></a>
                                    </div>


                                </div>

                                @endif
                            </div>

                            <br>

                            <h5>Details</h5>
                            <p> {{$event['description']}}</p>

                            <hr>

                            <h5 class="text-center"> {{count ($event->attenders()->get())}} coming to this event</h5>
                            @if(count ($event->attenders()->get()) > 0)
                                <a class="text-center" href="/event/{{$event['id']}}/attendees">See Attenders</a>
                            @endif
                            <br>
                            <hr>
                        </div>

                        <div class="tab-pane" id="posts">
                            <div id="event-no-log-in-register">
                                @if(Auth::check())
                                <h5 id="add-new-post-header">Add new post</h5>
                                @include('partials.post.create_post', ['event' => $event])
                                @else
                                <p class="text-center"> Don't have an account? <br> <a class="button button-outline" href="{{ route('register') }}">Click here to register and leave posts!</a></p>
                                @endif
                            </div>

                            <br>
                            <hr>
                            <div class="wrapper" id="post-listing">

                                @if(count ($event->posts()->get()) > 0)
                                @each('partials.post.post', $event->posts()->orderBy('date', 'desc')->get(), 'post')
                                @else
                                <p id="warning-nopost" class="text-center"> There are no posts! :( </p>
                                @endif

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

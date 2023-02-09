@extends('layouts.app')

@section('title', 'User profile')

@section('content')

<div class="container">
     <br><br>
     <div class="centeredText">
          <div class="col-lg-12 push-lg-4">
               <div class="tab-pane active" id="profile">
                    <div class="row">
                         <div class="col">
                              <h2 style="margin-bottom: 1.5rem; font-weight: 900;">Profile</h2>
                         </div>
                    </div>

                    <div class="col-md-6">
                        <ul>
                            <li><a href="/user/edit">Edit profile</a></li>
                            @if($user->is_admin)
                                <li><a href="{{url('/user/owner')}}">Reported</a></li>
                                <li><a href="{{url('/')}}">Banned</a></li>
                            @else
                                <li><a href="{{url('/user/notifications')}}">Notifications</a></li>
                                <li><a href="{{url('/user/attend')}}">Attending Events</a></li>
                                <li><a href="{{url('/user/manage')}}">Managing Events</a></li>
                                <li><a href="{{url('/user/owner')}}">Own Events </a></li>
                                <li><a href="{{url('/user/invites')}}">Manage Invites</a></li>
                                <li><a href="{{url('/event/create')}}">Create event</a></li>
                            @endif
                        </ul>

                    </div>
                    <hr>
                    <div class="row">
                         <div class="col">
                              <h2 style="margin-bottom: 1.5rem; font-weight: 900;">User Info</h2>
                         </div>
                    </div>
                    <div class="col-md-6">
                         <h4>Username</h4>
                         <p id="usernname"> {{$user->username}}</p>
                         <h4>Name</h4>
                         <p id="name"> {{$user->name}} </p>

                    </div>

                    <hr>

               </div>
          </div>
     </div>
</div>

@endsection



@extends('layouts.app')

@section('scripts')
    <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />
    <script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
    <script src="{{asset('js/map.js')}}"></script>
@endsection

@section('title', 'Create event')

@section('content')

<br><br>

<div class="container">

    <div class="row profile justify-content-center">

        <div id="edit-event" class="col-lg-10 push-lg-4">

            <h3 style="margin-bottom: 1.5rem; font-weight: 900;">Create new event</h3>

            <hr>

            <form id="event-settings-form" method="POST" enctype="multipart/form-data" action="/event/create">
                {{ csrf_field() }}

                <h4>Title</h4>

                <div>
                    <div >
                        <input id="event-title" class="form-control form-control-md" name="title" type="text" required placeholder="Event title (*)">
                        <p id="event-info"><small id="title-invalid" class="text-danger"></small></p>
                        <label for="is-private"><input id="is-private" name="isprivate" type="checkbox">is private</label>
                    </div>


                    <div class="text-center">
                        <p>cover image<label class="btn" id="upload-button">
                            <input id="upload-image" name="upload-image" type="file">
                        </label></p>
                        <p id="event-info"><small id="image-invalid" class="text-danger"></small></p>

                        <div class="image-area img-thumbnail">
                            <img id="imageResult" src="#" alt="" class="img-fluid rounded float-center shadow-sm mx-auto d-block">
                        </div>
                    </div>
                </div>

                <br>

                <h4>Where & When</h4>
                <div>
                    <div>
                        <p id="event-info"> <b>Where:</b><br></p>
                        <input id="event-location" class="form-control form-control-sm" name="address" type="text" required placeholder="address">
                        <div id="map"></div>
                        <p>latitude<input type="text" id="lat"  name="latitude" readonly></p>
                        <p>longitude<input type="text" id="lng" name="longitude" readonly></p>
                    </div>
                    <br>
                    <div>
                        <p id="event-info"> <b>When:</b>

                            <br>

                            <small>Event date and time: (*) </small>

                            <input id="event-date" class="form-control form-control-sm" name="event_date" type="datetime-local" placeholder="Event date">

                            <small id="date-invalid" class="text-danger"></small>
                        </p>
                    </div>
                </div>
                {{--
                <h4>Tags</h4>
                <div class="row">
                    <div style="font-size:1.5rem;" class="col">

                        <p id="search-by">Choose some tags related to your event</p>
                        <br>

                        <div class="d-flex justify-content-center btn-group" data-toggle="buttons">

                            <label style="margin-right: 0.25rem; margin-left: 0.25rem;" id="tag-button" class="btn festival-tag">
                                @if(!empty($event) && count($event->tags->where('name', 'like', 'Festival')) > 0)
                                <input id="selected-tags" name="tag_festival" type="checkbox" autocomplete="off" checked> Festival
                                @else
                                <input id="selected-tags" name="tag_festival" type="checkbox" autocomplete="off"> Festival
                                @endif
                            </label>

                            <label style="margin-right: 0.25rem; margin-left: 0.25rem;" id="tag-button" class="btn concert-tag">
                                @if(!empty($event) && count($event->tags->where('name', 'like', 'Concert')) > 0)
                                <input id="selected-tags" name="tag_concert" type="checkbox" autocomplete="off" checked> Concert
                                @else
                                <input id="selected-tags" name="tag_concert" type="checkbox" autocomplete="off"> Concert
                                @endif
                            </label>

                            <label style="margin-right: 0.25rem; margin-left: 0.25rem;" id="tag-button" class="btn conference-tag">
                                @if(!empty($event) && count($event->tags->where('name', 'like', 'Conference')) > 0)
                                <input input="selected-tags" name="tag_conference" type="checkbox" autocomplete="off" checked> Conference
                                @else
                                <input input="selected-tags" name="tag_conference" type="checkbox" autocomplete="off"> Conference
                                @endif
                            </label>

                            <label style="margin-right: 0.25rem; margin-left: 0.25rem;" id="tag-button" class="btn expo-tag">
                                @if(!empty($event) && count($event->tags->where('name', 'like', 'Expo')) > 0)
                                <input id="selected-tags" name="tag_expo" type="checkbox" autocomplete="off" checked> Expo
                                @else
                                <input id="selected-tags" name="tag_expo" type="checkbox" autocomplete="off"> Expo
                                @endif
                            </label>

                            <label style="margin-right: 0.25rem; margin-left: 0.25rem;" id="tag-button" class="btn workshop-tag">
                                @if(!empty($event) && count($event->tags->where('name', 'like', 'Workshop')) > 0)
                                <input id="selected-tags" name="tag_workshop" type="checkbox" autocomplete="off" checked> Workshop
                                @else
                                <input id="selected-tags" name="tag_workshop" type="checkbox" autocomplete="off"> Workshop
                                @endif
                            </label>

                            <label style="margin-right: 0.25rem; margin-left: 0.25rem;" id="tag-button" class="btn politics-tag">
                                @if(!empty($event) && count($event->tags->where('name', 'like', 'Politics')) > 0)
                                <input id="selected-tags" name="tag_politics" type="checkbox" autocomplete="off" checked> Politics
                                @else
                                <input id="selected-tags" name="tag_politics" type="checkbox" autocomplete="off"> Politics
                                @endif
                            </label>

                            <label style="margin-right: 0.25rem; margin-left: 0.25rem;" id="tag-button" class="btn live-tv-tag">
                                @if(!empty($event) && count($event->tags->where('name', 'like', 'Live TV')) > 0)
                                <input id="selected-tags" name="tag_live_tv" type="checkbox" autocomplete="off" checked> Live TV
                                @else
                                <input id="selected-tags" name="tag_live_tv" type="checkbox" autocomplete="off"> Live TV
                                @endif
                            </label>

                            <label style="margin-right: 0.25rem; margin-left: 0.25rem;" id="tag-button" class="btn protest-tag">
                                @if(!empty($event) && count($event->tags->where('name', 'like', 'Protest')) > 0)
                                <input id="selected-tags" name="tag_protest" type="checkbox" autocomplete="off" checked> Protest
                                @else
                                <input id="selected-tags" name="tag_protest" type="checkbox" autocomplete="off"> Protest
                                @endif
                            </label>

                            <label style="margin-right: 0.25rem; margin-left: 0.25rem;" id="tag-button" class="btn exercise-tag">
                                @if(!empty($event) && count($event->tags->where('name', 'like', 'Exercise')) > 0)
                                <input id="selected-tags" name="tag_exercise" type="checkbox" autocomplete="off" checked> Exercise
                                @else
                                <input id="selected-tags" name="tag_exercise" type="checkbox" autocomplete="off"> Exercise
                                @endif
                            </label>

                            <label style="margin-right: 0.25rem; margin-left: 0.25rem;" id="tag-button" class="btn auction-tag">
                                @if(!empty($event) && count($event->tags->where('name', 'like', 'Auction')) > 0)
                                <input id="selected-tags" name="tag_auction" type="checkbox" autocomplete="off" checked> Auction
                                @else
                                <input id="selected-tags" name="tag_auction" type="checkbox" autocomplete="off"> Auction
                                @endif
                            </label>

                            <label style="margin-right: 0.25rem; margin-left: 0.25rem;" id="tag-button" class="btn others-tag">
                                @if(!empty($event) && count($event->tags->where('name', 'like', 'Others')) > 0)
                                <input id="selected-tags" name="tag_others" type="checkbox" autocomplete="off" checked> Others
                                @else
                                <input id="selected-tags" name="tag_others" type="checkbox" autocomplete="off"> Others
                                @endif
                            </label>

                        </div>
                    </div>
                </div>
                --}}

                <br><br>

                <h4>Details</h4>
                <div class="form-group">
                    <textarea class="form-control" rows="3" name="description" value="Event description"></textarea>
                </div>

                <button id="button-save-changes" type="submit" class="btn"> CREATE </button>
            </form>
        </div>
    </div>
</div>
<br><br>

@endsection

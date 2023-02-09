@extends('layouts.app')

@section('content')
<br><br><br>
        <div class="row">
            <div class="col">
                <h2 style="margin-bottom: 1.5rem; font-weight: 900;">{{$event['name']}}</h2>
            </div>
        </div>
        <br><br>
        <div class="row">
            <div class="col">
                <h4 style="margin-bottom: 1.5rem; font-weight: 900;">Attenders</h4>
            </div>
        </div>
    <section id="pagination-item-1" class="container-lg mt-5 events-preview px-0">
        <div>
            @if (@count($users) > 0)
                @foreach($users as $user)
                    <article class="event-preview card flex-row align-items-center">
                        <div>
                            <p>{{$user->name}}</p>
                        </div>
                    </article>
                @endforeach
            @endif
            <div id="event-pagination-list">
                {!! $users->links() !!}
            </div>
        </div>


    </section>

@endsection

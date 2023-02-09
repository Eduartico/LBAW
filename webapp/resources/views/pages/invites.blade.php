@extends('layouts.app')


@section('scripts')
    <script src={{ asset('js/pagination.js') }} defer></script>
@endsection
@section('content')

    <section id="pagination-item-1" class="container-lg mt-5 profile-questions-preview px-0">
        <div>
            @if (@count($invites) > 0)
                @foreach($invites as $invite)
                    <article class="event-preview card flex-row align-items-center">
                        <div>
                            <h2>invited by {{$invite->Inviter->username}}</h2>
                            <h1><a href="{{ url('/event/' . $invite->event_id) }}">{{$invite->Event->name}}</a></h1>
                        </div>
                    </article>
                @endforeach
            @else
                <p>No events to show.</p>
            @endif
            <div id="event-pagination-list">
                {!! $invites->links() !!}
            </div>
        </div>


    </section>
@endsection

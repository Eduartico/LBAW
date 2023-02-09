@extends('layouts.app')


    @section('scripts')
        <script src={{ asset('js/pagination.js') }} defer></script>
    @endsection
@section('content')
    <br><br><br>
    <div class="row">
        <div class="col">
            <h2 style="margin-bottom: 1.5rem; font-weight: 900;">{{$title}}</h2>
        </div>
    </div>
    <section id="pagination-item-1" class="container-lg mt-5 events-preview px-0">
        <div>
            @if (@count($events) > 0)
                @foreach($events as $event)
                    <article class="event-preview card flex-row align-items-center">
                        <div>
                            <h3><a href="{{ url('/event/' . $event->id) }}">{{$event->name}}</a></h3>
                        </div>
                    </article>
                @endforeach
            @else
                <p>No events to show.</p>
            @endif
            <div id="event-pagination-list">
                {!! $events->links() !!}
            </div>
        </div>


    </section>
@endsection

@extends('layouts.app')


@section('scripts')
    <script src={{ asset('js/pagination.js') }} defer></script>
@endsection
@section('content')

    <section id="pagination-item-1" class="container-lg mt-5 profile-questions-preview px-0">
        <div>
            @if (@count($notifications) > 0)
                @foreach($notifications as $notification)
                    @php
                    $new_string = $notification->text;
                        if (preg_match('/post:(\d+)/', $new_string, $matches)){
                            $string = htmlspecialchars(\App\Models\Post::find($matches[1])->title);
                            $new_string = preg_replace(
                                '/post:(\d+)/',
                                    'post <a href="/event/'. \App\Models\Post::find($matches[1])->event->first()->id .'">'.
                                        (strlen($string) > 64 ? substr($string, 0, 61). "..." : $string)
                                    .'</a>',
                                 $new_string);
                        }
                        if (preg_match('/comment:(\d+)/', $new_string, $matches)){
                            $string = htmlspecialchars(\App\Models\Comment::find($matches[1])->text);
                            $new_string = preg_replace(
                                '/comment:(\d+)/',
                                    'comment <a href="/comment/'. $matches[1] .'">'.
                                        (strlen($string) > 64 ? substr($string, 0, 61) . "..." : $string)
                                    .'</a>',
                                $new_string);
                        }
                        if (preg_match('/event:(\d+)/', $new_string, $matches)){
                            $string = htmlspecialchars(\App\Models\Event::find($matches[1])->name);
                            $new_string = preg_replace(
                                '/event:(\d+)/',
                                    'event <a href="/event/'. $matches[1] .'">'.
                                        (strlen($string) > 64 ? substr($string, 0, 61) . "..." : $string)
                                    .'</a>',
                                 $new_string);
                        }
                        if (preg_match('/poll:(\d+)/', $new_string, $matches)){
                            $string = \App\Models\poll::find($matches[1])->Post;
                            $title = htmlspecialchars($string->title);
                            $new_string = preg_replace(
                                '/poll:(\d+)/',
                                    'poll in the post <a href="/poll/'. $string->id .'">'.
                                        (strlen($title) > 64 ? substr($title, 0, 61) . "..." : $title)
                                    .'</a>',
                                 $new_string);
                        }
                        if (preg_match('/user:(\d+)/', $new_string, $matches)){
                            $string =  htmlspecialchars(\App\Models\User::find($matches[1])->username);
                            $new_string = preg_replace(
                                '/user:(\d+)/',
                               $string,
                                $new_string);
                        }
                    @endphp
                    <article class=" card flex-row align-items-center">
                            <div><p>{!! $new_string !!}</p></div>
                    </article>
                @endforeach
            @else
                <p>No notifications to show.</p>
            @endif
            <div id="pagination-list">
                {!! $notifications->links() !!}
            </div>
        </div>


    </section>
@endsection

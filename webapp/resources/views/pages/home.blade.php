
@extends('layouts.app')

@section('title', 'Home - Helluva')
  
@section('content')

@include('partials.homeheader')

<br>

@include('partials.event.events')
            
@endsection

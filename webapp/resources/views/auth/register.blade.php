@extends('layouts.app')

@section('title', 'Helluva - Register')

@section('content')
<br><br><br>
<div id="login-form" class="container">
  <div class="row justify-content-center">
    <div class="col-8">
      <div class="tab-content p-b-3">
          <div class="col-md-12 flex-column justify-content-center">
<form method="POST" action="{{ route('register') }}">
    {{ csrf_field() }}

    <div class="form-group">
      <label for="name">Name</label>
      <input id="name" class="form-control input-sm" type="text" name="name" value="{{ old('name') }}" required autofocus>
      @if ($errors->has('name'))
        <span class="error">
            {{ $errors->first('name') }}
        </span>
      @endif
    </div>

    <div class="form-group">
      <label for="username">Username</label>
      <input id="username" class="form-control input-sm" type="text" name="username" required>
      @if ($errors->has('username'))
          <span class="error">
            {{ $errors->first('username') }}
        </span>
      @endif
    </div>

    <div class="form-group">
      <label for="email">E-Mail Address</label>
      <input id="email" class="form-control input-sm" type="email" name="email" value="{{ old('email') }}" required>
      @if ($errors->has('email'))
        <span class="error">
            {{ $errors->first('email') }}
        </span>
      @endif
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <input id="password" class="form-control input-sm" type="password" name="password" required>
      @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
      @endif
    </div>

    <div class="form-group">
      <label for="password-confirm">Confirm Password</label>
      <input id="password-confirm" class="form-control input-sm" type="password" name="password_confirmation" required>
    </div>
    <button type="submit">
      Register
    </button>
    <a class="button button-outline" href="{{ route('login') }}">Login</a>
</form>
@endsection

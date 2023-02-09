@extends('layouts.app')

@section('title', 'Helluva - Login')

@section('content')
<br><br><br>
<form method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}
    <div id="login-form" class="container">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="tab-content p-b-3">
                        <div class="cold-md-112 flex-column justify-content-center">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="email">E-mail</label>
                                    <input id="email" class="form-control input-sm" type="email" name="email" value="{{ old('email') }}" required autofocus>
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

                                <label>
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                </label>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <small id="recover_password"><a class="button button-outline text-muted" href="/send-email">Forgot your password?</a></small>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <button type="submit" class="button float-right" id="btn-login">Login</button>                                   
                                    </div>
                                </div>
                                
                                <a class="button button-outline" href="{{ route('register') }}">Register</a>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

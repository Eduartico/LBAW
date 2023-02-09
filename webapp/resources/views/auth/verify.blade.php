@extends('layouts.app')

@section('title', 'Login')

@section('content')
<br><br><br>
<form method="POST" action="{{ route('password.recover') }}">

    {{ csrf_field() }}

    <div id="login-form" class="container">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="tab-content p-b-3">
                    
                        <div class="col-md-12 flex-column justify-content-center">        
                                
                            <div id="text-banner-login" class="container">
                                <div id="text-banner-login" class="centered">Request Password</div>
                            </div>
                                                                   
                            <div class="card-body">
                                   
                                    <div class="form-group">
                                        <br>
                                        <label for="inputsm">Email</label>
                                        <input id="email" class="form-control input-sm" type="email" name="email" value="{{ old('email') }}" required autofocus>
                                        <p>{{$errors->first()}}</p>
                                    </div>
                                    <div class="col">
                                        <button type="submit" class="btn float-right" id="btn-login">Get new Password</button>                                   
                                    </div>
                                       
                                    <br><br>
                                    
                                    <a class="button button-outline" href="{{ route('register') }}">Register</a>
                                       
                            </div>
                        </div>
                    
                </div>
        </div>
    </div>
</form>
@endsection

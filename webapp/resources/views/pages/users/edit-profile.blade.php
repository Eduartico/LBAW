@extends('layouts.app')

@section('title', 'Edit user profile')

@section('content')

<div class="container">
    <br><br>
    <div class="centeredText">
        <div class="col-lg-12 push-lg-4">
            <div class="tab-pane active" id="edit">
                <h5 style="margin-bottom: 1.5rem; font-weight: 900;">Edit profile</h5>
                <hr>
                <form id="edit-profile" method="post" enctype="multipart/form-data" action="/user/edit">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="file">photo:</label>
                        <div class="col-lg-9">
                            <input id="file" type="file" name="file" >
                        </div>
                        @if ($errors->has('name'))
                            <span class="error">
                            {{ $errors->first('name') }}
                        </span>
                    </div>
                    @endif

                    <div class="form-group">
                        <label for="name">Name</label>
                        <div class="col-lg-9">
                            <input id="name" type="text" name="name" value="{{ $user->name }}" required autofocus>
                        </div>
                        @if ($errors->has('name'))
                        <span class="error">
                            {{ $errors->first('name') }}
                        </span>
                    </div>
                    @endif

                    <div class="form-group">
                        <label for="password">Old Password</label>
                        <div class="col-lg-9">
                            <input id="password" type="password" name="password" required>
                        </div>
                        @if ($errors->has('password'))
                        <span class="error">
                            {{ $errors->first('password') }}
                        </span>
                    </div>
                    @endif

                    <div class="form-group">
                        <label for="new-password">New Password</label>
                        <div class="col-lg-9">
                            <input id="new-password" type="password" name="new-password" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password-confirm">Confirm Password</label>
                        <div class="col-lg-9">
                            <input id="password-confirm" type="password" name="password-confirmation" required>
                        </div>
                    </div>



                    <div id="submit-edit-profile" class="form-group">
                        <label for="submit">Submit</label>
                        <div class="col-lg-9">
                            <button onclick="location.href = '/user';" class="btn float-left" id="btn-login">Back</button>
                            <button type="submit" class="btn float-right" id="btn-login">Save changes</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

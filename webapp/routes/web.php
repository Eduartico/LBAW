<?php

use App\Http\Controllers\Recovery;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

Route::middleware(['auth'])->group(function () {
    //request to be made with json
    Route::post('api/vote','ApiController@vote');//
    /*
     * {
     *      "command": either(create,delete),
     *      "type": either(comment,post,poll),
     *      "id": int,
     *      'isPositive
     * }
     */
    Route::post('api/attend','ApiController@attend');//
    /*
     * {
     *      "command": either(create,delete),
     *      "id": int,
     *      "is_private: bool
     * }
     */
    Route::post('api/invite','ApiController@invite');//
    /*
     * {
     *      "command":either(delete,create),
     *      "id":int
     *      "username":string,
     * }
     */
    Route::post('api/organizer','ApiController@organizer');//
    /*
     * {
     *      "command": either(create,delete),
     *      "id": int,
     *      "user": int
     * }
     */
    Route::post('api/report','ApiController@report');//
    /*
     * {
     *      "command": either(create,delete)
     *      "item": either(event,post,comment),
     *      "id": int,
     * }
     */
    Route::post('api/ban')->middleware('admin');
    /*
     * {
     *      "item": either(event,post,comment),
     *      "id": int,
     * }
     */
    Route::post('api/comment', 'ApiController@comment');
    /*
     * {
     *      postId: Integer,
     *      ParentCommentId: Integer,
     *      text: string
     * }
     */
});

// M03 - Search
Route::get('/search','EventController@search')->name('search');

//accessible only to authenticated users
Route::middleware(['auth'])->group( function() {
    // M01 - Authentication and Individual Profile
    Route::get('user/attend', 'UserController@AttendingEvents');
    Route::get('user/manage', 'UserController@OrganizingEvents');
    Route::get('user/owner', 'UserController@OwningEvents');
    Route::get('user/notifications','NotificationController@show');
    Route::get('user/invites','UserController@Invites');
    Route::delete('user');

    Route::get('user/edit', 'UserController@edit');
    Route::post('user/edit', 'UserController@update');
    Route::get('user' , 'UserController@show');

    // M04 - Manage Content

    //event
    Route::get('/event/create', 'EventController@create');
    Route::post('/event/create', 'EventController@store');
    Route::get('/event/{id}/edit', 'EventController@edit');
    Route::post('/event/{id}/edit', 'EventController@update');
    Route::delete('/event/{id}/delete', 'EventController@delete');

    //post
    Route::post('/event/{event_id}/post/create','PostController@create');//ajax
    Route::post('post/{post_id}/upload', 'PostController@upload');//ajax
    Route::post('post/{post_id}/edit', 'PostController@edit');
    Route::delete('/post/{post_id}', 'PostController@delete');

    //comment
    Route::post('comment/create','commentController@create');
    Route::post('comment/{comment_id}/edit','commentController@edit');
    Route::delete('comment/{comment_id}', 'commentController@delete');

    //tags
    //Route::get('/tags/{name}', 'TagController@show');

});

// Home and Static
Route::get('/', 'HomeController@show')->name('home');

// M01 - Authentication and Individual Profile
Route::middleware(['guest'])->group(function() {
    Route::post('login', 'Auth\LoginController@login')->name('login');
    Route::post('register', 'Auth\RegisterController@register')->name('register');
    Route::get('login', "Auth\LoginController@showLoginForm");
    Route::get('register', 'Auth\RegisterController@showRegistrationForm');
});
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('not-authorised','AuthPageController@notAuthorized');

//ResetPassword
Route::view('verify.mail', 'auth.verify')->name('verify.mail');
Route::post('password.recover', 'Recovery@recover')->name('password.recover');

// M02 - View Content

Route::post('/event/{event_id}/post/{post_id}', 'PostController@get');//ajax
Route::get('/event/{event_id}/attendees','EventController@attendees');
Route::get('/event/{event_id}', "EventController@show")->name('show-event');

Route::get('/post/{post_id}', 'PostController@view');
Route::post('post/{post_id}', 'PostController@get');//ajax

Route::post('comment/{comment_id}','commentController@show');//ajax


// M05 - User Administration and Static pages
Route::get('aboutus','StaticPagesController@aboutus')->name('aboutus');
Route::get('contactus','StaticPagesController@contactus')->name('contactus');
Route::get('faq','StaticPagesController@faq')->name('faq');

//Admin
Route::middleware('admin')->group(function(){
    Route::get('reported/users');//
    Route::get('reported/events');//
    Route::get('reposted/comments');//
    Route::get('reported/posts');//
});

//Email
Route::get('/send-email', [Recovery::class, 'sendEmail']);

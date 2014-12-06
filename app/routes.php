<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function() 
{
	$todo = "
            <h1>REBECCA'S UGLY TO DO LIST</h1>
            <ul>
            <li>Create edit user profile page</li>
            <li>Have main page only show upcoming events</li>
            <li>Adjust time zone (for comments)</li>
            <li>Layout/CSS etc</li>
            <li>Create seeds</li>
            <li>Disable debugbar</li>
            <li>Launch to production</li>
            <li>Make sure code is readable (add comments)</li>
            <a href='/events'>Continue anyway</a>";
	return $todo;
});

# EVENTS

Route::get('/events', 'HolidayController@index');

Route::get('/events/create', 'HolidayController@create');

Route::post('/events/create', 'HolidayController@handleCreate');

Route::get('/events/view/{id}', 'HolidayController@view');

Route::get('/events/edit/{id}', 'HolidayController@edit');

Route::post('/events/edit', 'HolidayController@handleEdit');

Route::get('/events/delete/{id}', 'HolidayController@delete');

Route::post('/events/delete', 'HolidayController@handleDelete');

# COMMENTS

Route::get('/comments/{id}', 'CommentController@create');

Route::post('/comments', 'CommentController@handleCreate');

# USERS

Route::get('/signup', 'UserController@getSignup');

Route::post('/signup', 'UserController@postSignup');

Route::get('/login', 'UserController@getLogin');

Route::post('/login', 'UserController@postLogin');

Route::get('/profile', 'UserController@view');

Route::get('/edit_profile', 'UserController@edit');

Route::post('/edit_profile', 'UserController@handleEdit');

# MISCELLANOUS

Route::get('whoops', function() {
    return View::make('whoops');
});

Route::get('/logout', function() {

    # Log out
    Auth::logout();

    # Send them to the homepage
    return Redirect::to('/');

});
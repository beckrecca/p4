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
	$todo = "<ul>
            <li>Add event form validation</li>
            <li>Add comment form validation</li>
            <li>Create general filter so only logged in user can access most pages</li>
            <li>Validation validation validation</li>
            <li>Make events/comment views prettier</li>
            <li>Create edit user profile page</li>
            <li>Have main page only show upcoming events</li>
            <li>Adjust time zone (for comments)</li>
            <li>Comment on every function model etc EVER</li>
            <li>Layout/CSS etc</li>
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
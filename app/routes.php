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
            <li>Deal with sign up / log in forms</li>
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

Route::post('/signup', 'UserController@postSignup')

# MISCELLANOUS TO BE DEALT WITH

Route::get('whoops', function() {
    return View::make('whoops');
});

Route::post('/signup', 
    array(
        'before' => 'csrf', 
        function() {

            $user = new User;
            $user->email    = Input::get('email');
            $user->password = Hash::make(Input::get('password'));

            # Try to add the user 
            try {
                $user->save();
            }
            # Fail
            catch (Exception $e) {
                return Redirect::to('/signup')->with('flash_message', 'Sign up failed; please try again.')->withInput();
            }

            # Log the user in
            Auth::login($user);

            return Redirect::to('/');

        }
    )
);

Route::get('/login',
    array(
        'before' => 'guest',
        function() {
            return View::make('login');
        }
    )
);

Route::post('/login', 
    array(
        'before' => 'csrf', 
        function() {

            $credentials = Input::only('email', 'password');

            if (Auth::attempt($credentials, $remember = true)) {
                return Redirect::intended('/')->with('flash_message', 'Welcome Back!');
            }
            else {
                return Redirect::to('/login')->with('flash_message', 'Log in failed; please try again.');
            }

            return Redirect::to('login');
        }
    )
);

Route::get('/logout', function() {

    # Log out
    Auth::logout();

    # Send them to the homepage
    return Redirect::to('/');

});
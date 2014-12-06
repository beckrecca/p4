<?php

class UserController extends BaseController
{
    public function __construct() {
        # Make sure BaseController construct gets called
        parent::__construct();
        $this->beforeFilter('guest',
            array(
                'only' => array('getLogin','getSignup')
            ));
    }

    public function getSignup()
    {
        // Show the sign up form.
        return View::make('signup');
    }

    public function postSignup()
    {
        // Handle sign up form submission.
        # Step 1) Define the rules
        $rules = array(
            'email' => 'required|email|unique:users,email',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:7',
            'password_confirm' => 'required|same:password'
        );

        # Step 2)
        $validator = Validator::make(Input::all(), $rules);

        # Step 3
        if($validator->fails()) {
            return Redirect::to('/signup')
                ->with('flash_message', 'Sign up failed!')
                ->withInput()
                ->withErrors($validator);
        }

        $user = new User;
        $user->email = $_POST['email'];
        $user->password = Hash::make($_POST['password']);
        $user->username = $_POST['username'];
        $month = $_POST['month'];
        $day = $_POST['day'];
        $year = $_POST['year'];
        $user->DOB = $year . "-" . $month . "-" . $day;

        try {
            $user->save();
        }
        catch (Exception $e) {
            return Redirect::to('/signup')
                ->with('flash_message', 'Sign up failed; please try again. I am so sorry.')
                ->withInput();
        }
        # Log in
        Auth::login($user);
        return Redirect::to('/events')->with('flash_message', 'You signed up successfully, good work!');
    }

    public function getLogin()
    {
        // Show the sign up form.
        return View::make('login');
    }

    public function postLogin()
    {
        $credentials = Input::only('username', 'password');
        
        if (Auth::attempt($credentials, $remember = false)) {
            return Redirect::intended('/events')->with('flash_message', 'You logged in successfully!');
        }
        else {
            return Redirect::to('/login')
                ->with('flash_message', 'Log in failed; please try again.')
                ->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $event = Holiday::findOrFail($id);
        }
        catch(exception $e) {
            return Redirect::to('/whoops');
        }
        return View::make('edit')->with('event', $event);
    }

    public function handleEdit()
    {
        try {
            $event = Holiday::findOrFail($_POST['id']);
        }
        catch(exception $e) {
            return Redirect::to('/whoops');
        }
        
        $event->title = $_POST['title'];
        $event->location = $_POST['location'];
        $time = $_POST['hour'];
        $partofday = $_POST['m'];
        if ($partofday) {
            $time += 12;
        }
        $time = $time . ":00:00";
        $event->when = $_POST['date'] . " " . $time;
        $event->description = $_POST['description'];
        $event->user_id = Auth::id();
        $event->save();
        return Redirect::action('HolidayController@index');
    }
}
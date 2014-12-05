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
        $event = new Holiday();
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
        return Redirect::to('/events');
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
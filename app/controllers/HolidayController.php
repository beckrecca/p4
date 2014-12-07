<?php

class HolidayController extends BaseController
{

    public function __construct() {
        # Make sure BaseController construct gets called
        parent::__construct();
        $this->beforeFilter('auth');
    }

    public function index()
    {
        // Show all the upcoming events.
        $events = Holiday::upcoming()->whenAscending()->get();
        $header = "Upcoming Events";
        return View::make('index')->with('events', $events)
                                  ->with('header', $header);
    }

    public function all()
    {
        // Show all the events. Stretch: pagination?
        $events = Holiday::whenAscending()->get();
        $header = "All Events";
        return View::make('index')->with('events', $events)
                                  ->with('header', $header);
    }

    public function view($id) 
    {
        try {
            $event = Holiday::findOrFail($id);
        }
        catch(exception $e) {
            $message = "We couldn't find any such event.";
            return Redirect::to('/events')
                ->with('flash_message', $message);
        }

        $comments = Comment::where('holiday_id', '=', $id)->get();

        $users = User::find_usernames($comments);

        return View::make('event_page')->with('event', $event)
                                       ->with('comments', $comments)
                                       ->with('users', $users);
    }

    public function create()
    {
        // Show the add event form.
        return View::make('create');
    }

    public function handleCreate()
    {
        # Step 1)
        $rules = array(
            'title' => 'required|max:128',
            'description' => 'max:160',
            'location' => 'required',
            'date' => 'required|date',
            'time' => 'between:1,12|numeric',
            'm' => 'between:0,1|numeric',

        );

        # Step 2)
        $validator = Validator::make(Input::all(), $rules);

        # Step 3
        if($validator->fails()) {
            return Redirect::to('/events')
                ->with('flash_message', 'You really messed up!')
                ->withInput()
                ->withErrors($validator);
        }

        // Handle add event form submission.
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
        $when = Holiday::when($id);
        return View::make('edit')->with('event', $event)
                                 ->with('when', $when);
    }

    public function handleEdit()
    {

        try {
            $event = Holiday::findOrFail(Input::get('id'));
        }
        catch(exception $e) {
            return Redirect::to('/events')->with('flash_message', 'This event does not exist, how did you do that?');
        }

        # Step 1)
        $rules = array(
            'title' => 'required|max:128',
            'description' => 'max:160',
            'location' => 'required',
            'date' => 'required|date',
            'time' => 'between:1,12|numeric',
            'm' => 'between:0,1|numeric',

        );

        # Step 2)
        $validator = Validator::make(Input::all(), $rules);

        # Step 3
        if($validator->fails()) {
            return Redirect::to('/events')
                ->with('flash_message', 'You really messed up! Your changes were not saved.')
                ->withInput()
                ->withErrors($validator);
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
        $redirect = "/events/view/" . $event->id;
        return Redirect::to($redirect);
    }

    public function delete($id)
    {
        try {
            $event = Holiday::findOrFail($id);
        }
        catch(exception $e) {
            return Redirect::to('/whoops');
        }
        return View::make('delete')->with('event', $event);
    }

    public function handleDelete()
    {
    // Handle the delete confirmation.
    $id = $_POST['id'];
    $event = Holiday::findOrFail($id);
    $event->delete();

    return Redirect::action('HolidayController@index');
    }
}
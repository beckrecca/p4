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
        $events = Holiday::upcoming()->whenAscending()->Paginate(5);
        $header = $title = "Upcoming Events";
        $user = Auth::id();
        $upcoming_birthdays = User::birthdays();
        return View::make('index')->with('events', $events)
                                  ->with('header', $header)
                                  ->with('title', $title)
                                  ->with('user', $user)
                                  ->with('upcoming_birthdays', $upcoming_birthdays);
    }

    public function all()
    {
        // Show all the events. 
        $events = Holiday::whenAscending()->Paginate(5);
        $header = $title = " All Events";
        $user = Auth::id();
        return View::make('index')->with('events', $events)
                                  ->with('header', $header)
                                  ->with('title', $title)
                                  ->with('user', $user);
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
        // We want to show the comments
        $comments = Comment::where('holiday_id', '=', $id)->CreatedAtDescending()->get();
        // We also want to show who wrote them
        $users = User::find_usernames($comments);
        // Finally, we want to show who created the event
        $username = User::username($event->user_id);

        $user = Auth::id();
        return View::make('event_page')->with('event', $event)
                                       ->with('comments', $comments)
                                       ->with('users', $users)
                                       ->with('username', $username)
                                       ->with('user', $user);
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
            'date' => 'required|date|date_format:"Y-m-d"',
            'time' => 'between:1,12|numeric',
            'm' => 'between:0,1|numeric',

        );

        # Step 2)
        $validator = Validator::make(Input::all(), $rules);

        # Step 3
        if($validator->fails()) {
            return Redirect::to('/events/create')
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
        $redirect = "/events/view/" . $event->id;
        return Redirect::to($redirect);
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
            'date' => 'required|date|date_format:"Y-m-d"',
            'time' => 'between:1,12|numeric',
            'm' => 'between:0,1|numeric',

        );

        # Step 2)
        $validator = Validator::make(Input::all(), $rules);

        # Step 3
        if($validator->fails()) {
            $redirect = "/events/edit/" . $event->id;
            return Redirect::to($redirect)
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
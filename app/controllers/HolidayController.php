<?php

class HolidayController extends BaseController
{
    public function index()
    {
        // Show all the events. Stretch: pagination?
        $events = Holiday::whenAscending()->get();
        return View::make('index')->with('events', $events);
    }

    public function view($id) 
    {
        try {
            $event = Holiday::findOrFail($id);
        }
        catch(exception $e) {
            return Redirect::to('/whoops');
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
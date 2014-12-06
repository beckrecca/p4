<?php

class CommentController extends BaseController
{
    public function __construct() {
        # Make sure BaseController construct gets called
        parent::__construct();
        $this->beforeFilter('auth');
    }
    
    public function create($id)
    {
        // Show the comment form below the actual event
        try {
            $event = Holiday::findOrFail($id);
        }
        catch(exception $e) {
            return Redirect::to('/whoops');
        }

        $comments = Comment::where('holiday_id', '=', $id)->get();

        $users = User::find_usernames($comments);

        return View::make('create_comment')->with('event', $event)
                                       ->with('comments', $comments)
                                       ->with('users', $users);

    }

    public function handleCreate()
    {
        # Step 1)
        $rules = array(
            'text' => 'required|max:160'
        );

        # Step 2)
        $validator = Validator::make(Input::all(), $rules);

        # Step 3
        if($validator->fails()) {
            return Redirect::to('/events')
                ->with('flash_message', 'You messed up and your comment was not saved.')
                ->withInput()
                ->withErrors($validator);
        }

        // Handle comment form submission.
        $event = new Comment();
        $event->text = $_POST['text'];
        $event->holiday_id = $_POST['holiday_id'];
        $event->user_id = Auth::id();
        $event->save();
        return Redirect::to('/events');
    }
    
}
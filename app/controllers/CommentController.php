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

        // We want to show the comments
        $comments = Comment::where('holiday_id', '=', $id)->CreatedAtDescending()->get();
        // We also want to show who wrote them
        $users = User::find_usernames($comments);
        // Finally, we want to show who created the event
        $username = User::username($event->user_id);

        return View::make('create_comment')->with('event', $event)
                                       ->with('comments', $comments)
                                       ->with('users', $users)
                                       ->with('username', $username);

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
            $redirect = "/comments/" . $_POST['holiday_id'];
            return Redirect::to($redirect)
                ->with('flash_message', 'You messed up and your comment was not saved.')
                ->withInput()
                ->withErrors($validator);
        }

        // Handle comment form submission.
        $event = new Comment();
        $event->text = $_POST['text'];
        $id = $_POST['holiday_id'];
        $event->holiday_id = $id;
        $event->user_id = Auth::id();
        $event->save();
        $redirect = "/events/view/" . $id;
        return Redirect::to($redirect);
    }
    
}
<?php

class CommentController extends BaseController
{
    public function create($id)
    {
        // Show the comment form below the actual event
        try {
            $event = Holiday::findOrFail($id);
        }
        catch(exception $e) {
            return Redirect::to('/whoops');
        }

        return View::make('create_comment')->with('event', $event);

    }

    public function handleCreate()
    {
        // Handle comment form submission.
        $event = new Comment();
        $event->text = $_POST['text'];
        $event->holiday_id = $_POST['holiday_id'];
        $event->user_id = Auth::id();
        $event->save();
        return Redirect::to('/events');
    }
    
}
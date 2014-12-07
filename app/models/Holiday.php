<?php

class Holiday extends Eloquent
{
	public function comment() {
        # An event has many comments
        # Define a one-to-many relationship.
        return $this->hasMany('Comment');
    }

    /**
    * An event belongs to one user
    * Define an inverse one-to-many relationship.
    */
    public function user() {
        return $this->belongsTo('User');
    }

    # Scope method for ordering the display of all the events
    public function scopeWhenAscending($query)
    {
        return $query->orderBy('when','ASC');
    } 

    # Turn the datetime entry into something we can actually use
    public static function when($id) {
        try {
            $event = Holiday::findOrFail($id);
        }
        catch(exception $e) {
            return Redirect::to('/whoops');
        }

        $datetime = new DateTime(($event['when']));

        $date = $datetime->format('Y-m-d');
        $time = $datetime->format('g');
        $timeofday = $datetime->format('H');
        if ($timeofday >= 12) $timeofday = 1;
        else $timeofday = 0;

        $when = Array();
        $when['date'] = $date;
        $when['time'] = $time;
        $when['timeofday'] = $timeofday;
        return $when;
    }

    # Let's create a method that will only return upcoming events.
    public static function upcoming() {
        $t = time();
        $t = date('Y-m-d', $t);
        $events = Holiday::where('when', '>', $t);
        return $events;
    }
}
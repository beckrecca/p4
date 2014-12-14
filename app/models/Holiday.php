<?php

class Holiday extends Eloquent
{
    # An event has many comments
    # Define a one-to-many relationship.
	public function comment() {
        
        return $this->hasMany('Comment');
    }
    
    # An event belongs to one user
    # Define an inverse one-to-many relationship.
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
        $minute = $datetime->format('i');
        $timeofday = $datetime->format('H');
        if ($timeofday >= 12) $timeofday = 1;
        else $timeofday = 0;

        $when = Array();
        $when['date'] = $date;
        $when['time'] = $time;
        $when['minute'] = $minute;
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

    # We have to delete all the comments for an event before we can delete it too.
    public function delete() {
        $comments = Comment::where('holiday_id', '=', $this->id)->get();
        foreach ($comments as $comment) {
            $comment->delete();
        }
        return parent::delete();
    }

    # A model to display all upcoming occasions to celebrate.
    # Credit is due to http://phpave.com/how-to-calculate-mothers-day-and-fathers-day/ for helping
    # me figure out how to do this.
    public static function occasions() {
        $t = time();
        $year = date('Y', $t);
        $month = date('m', $t);
        $day = date('d', $t);

        $next_month = $month + 1;
        if ($next_month > 12) $next_month = $next_month - 12;

        $celebrations = Array();

        $celebrations["easter"]["name"] = "Easter";
        $celebrations["easter"]["month"] = date("m", easter_date($year));
        $celebrations["easter"]["month_name"] = date("F", easter_date($year));
        $celebrations["easter"]["day"] = date("d", easter_date($year));

        $celebrations["md"]["name"] = "Mother's Day";
        $celebrations["md"]["month"] = date('m', strtotime('second Sunday of May ' . $year));
        $celebrations["md"]["month_name"] = date('F', strtotime('second Sunday of May ' . $year));
        $celebrations["md"]["day"] = date('d', strtotime('second Sunday of May ' . $year));

        $celebrations["memorial"]["name"] = "Memorial Day";
        $celebrations["memorial"]["month"] = date('m', strtotime('fourth Monday of May ' . $year));
        $celebrations["memorial"]["month_name"] = date('F', strtotime('fourth Monday of May ' . $year));
        $celebrations["memorial"]["day"] = date('d', strtotime('fourth Monday of May ' . $year));

        $celebrations["fd"]["name"] = "Father's Day";
        $celebrations["fd"]["month"] = date('m', strtotime('third Sunday of June ' . $year));
        $celebrations["fd"]["month_name"] = date('F', strtotime('third Sunday of June ' . $year));
        $celebrations["fd"]["day"] = date('d', strtotime('third Sunday of June ' . $year));

        $celebrations["4th"]["name"] = "Independence Day";
        $celebrations["4th"]["month"] = 7;
        $celebrations["4th"]["month_name"] = "July";
        $celebrations["4th"]["day"] = 4;

        $celebrations["halloween"]["name"] = "Halloween";
        $celebrations["halloween"]["month"] = 10;
        $celebrations["halloween"]["month_name"] = "October";
        $celebrations["halloween"]["day"] = 31;

        $celebrations["tday"]["name"] = "Thanksgiving";
        $celebrations["tday"]["month"] = date('m', strtotime('fourth Thursday of November ' . $year));
        $celebrations["tday"]["month_name"] = date('F', strtotime('fourth Thursday of November ' . $year));
        $celebrations["tday"]["day"] = date('d', strtotime('fourth Thursday of November ' . $year));

        $celebrations["xmas"]["name"] = "Christmas";
        $celebrations["xmas"]["month"] = 12;
        $celebrations["xmas"]["month_name"] = "December";
        $celebrations["xmas"]["day"] = 25;

        $celebrations["ny"]["name"] = "New Year's Day";
        $celebrations["ny"]["month"] = 1;
        $celebrations["ny"]["month_name"] = "January";
        $celebrations["ny"]["day"] = 1;

        $upcoming = Array();
        
        foreach ($celebrations as $celebration) {
            // if the occasion is this month
            if ($celebration["month"] == $month) {
                // if occasion is today
                if ($celebration["day"] == $day) {
                    // change it to merry for Christmas
                    if ($celebration["name"] == "Christmas") {
                        $upcoming[$celebration["name"]] = "<span class='holiday-today'>Merry <span class='holiday'>" . $celebration["name"] . "</span>!</span>";
                    }
                    else $upcoming[$celebration["name"]] = "<span class='holiday-today'>Happy <span class='holiday'>" . $celebration["name"] . "</span>!</span>";
                }
                // if the occasion is after today
                if ($celebration["day"] > $day) {
                    $upcoming[$celebration["name"]] = "<span class='holiday'>" . $celebration["name"] . "</span> is on the " . $celebration["day"] . " of this month.";
                }
            }
            // if the occasion is next month
            if ($celebration["month"] == $next_month) {
                $upcoming[$celebration["name"]] = "<span class='holiday'>" . $celebration["name"] . "</span> is coming up on <span class='occasion'>" . $celebration["month_name"] . " " . $celebration["day"] . "</span>.";
            }
        }
        
        return $upcoming;
    }
}
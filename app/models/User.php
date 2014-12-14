<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public function comment() {
        # User has many comments
        # Define a one-to-many relationship.
        return $this->hasMany('Comment');
    }

    public function holiday() {
        # A user can create (has many) events
        # Define a one-to-many relationship.
        return $this->hasMany('Holiday');
    }

    # Let's create a method to return who wrote which comment.
	public static function find_usernames ($comments) {

		$usernames = Array();

		foreach ($comments as $comment)
		{
			$user = User::where('id', '=', $comment['user_id'])->get();
			# There should only be one user with this id but we need a foreach anyway
			foreach ($user as $collection_item) {
				$usernames[$comment['id']] = $collection_item['username'];				
			}
		}
		
		return $usernames;
	}

	# Let's create a slightly different method to return a username given the id.
	public static function username($id) {
		try {
			$user = User::findOrFail($id);
		}
		catch (exception $e) {
			return Redirect::to('/whoops');
		}
		$username = $user->username;
		return $username;
	}

	# Let's create a method to break down the DOB.
	public static function DOB($id) {
		try {
            $user = User::findOrFail($id);
        }
        catch(exception $e) {
            return Redirect::to('/whoops');
        }

        $datetime = new DateTime($user["DOB"]);

        $month = $datetime->format('m');
        $month = intval($month);
        $day = $datetime->format('d');
        $year = $datetime->format('Y');

        $DOB = Array();
        $DOB['month'] = $month;
        $DOB['day'] = $day;
        $DOB['year'] = $year;
        return $DOB;
	}

	# Find upcoming birthdays 
	public static function birthdays() {
		$t = time();
        $month = date('m', $t);
        $day = date('d', $t);
        $year = date('Y', $t);

        $next_month = $month + 1;
        if ($next_month > 12) $next_month = $next_month - 12;

        $user_bdays = Array();

        $users = User::all();

        foreach ($users as $user) {
        	$id = $user->id;
        	// get the DOB
        	$DOB = User::DOB($id);

        	// if the user's bday is this month
        	if ($DOB['month'] == $month) {
        		// if the user's bday is today
        		if ($DOB['day'] == $day) {
        			$user_bdays[$user->username] = "<span class='today'>" . $user->username . "'s birthday is today!</span>";
        		}
        		// if the user's bday is after today
        		if ($DOB['day'] > $day) {
        			$user_bdays[$user->username] = $user->username . "'s birthday is on the " . $DOB['day'] . " of this month.";
        		}
        	}
        	// if the user's bday is next month
        	if ($DOB['month'] == $next_month) {
        		// get the name of the month
        		$bday_month = date('F', mktime(0, 0, 0, $DOB['month'], 1, $year));
        		$user_bdays[$user->username] = $user->username . "'s birthday will be on " . $bday_month . " " . $DOB['day'] . ".";
        	}
        }

        return $user_bdays;
	}

}

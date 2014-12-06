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

}

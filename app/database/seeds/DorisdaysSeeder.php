<?php

class FoobooksSeeder extends Seeder {

	public function run() {

		# Clear the tables to a blank slate
		DB::statement('SET FOREIGN_KEY_CHECKS=0'); # Disable FK constraints so that all rows can be deleted, even if there's an associated FK
		DB::statement('TRUNCATE users');
		DB::statement('TRUNCATE holidays');
		DB::statement('TRUNCATE comments');

		# Users
		$user = new User;
		$user->username = "TestUser";
		$user->email = "doris@g.harvard.edu";
		$user->DOB = "1923-01-23";
		$user->password = "BigDumbFace";

		# Events
		$thanksgiving = new Holiday;
		$thanksgiving->title = "Thanksgiving";
		$thanksgiving->location = "my house";
		$thanksgiving->when = "2014-11-27 17:00:00";
		$thanksgiving->description = "I'm gonna be chugging so much gravy";

		# Associate has to be called *before* the event is created (save())
		$thanksgiving->user()->associate($user); 
		$thanksgiving->save();

		# Comments
		$gravy = new Comment;
		$gravy->text = "I love gravy!";
		
		# Associate must be called before we save (again)
		$gravy->user()->associate($user);
		$gravy->holiday()->associate($thanksgiving);
		$gravy->save();

	}

}
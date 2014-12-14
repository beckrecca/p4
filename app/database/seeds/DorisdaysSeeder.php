<?php

class DorisdaysSeeder extends Seeder {

	public function run() {

		# Clear the tables to a blank slate
		DB::statement('SET FOREIGN_KEY_CHECKS=0'); # Disable FK constraints so that all rows can be deleted, even if there's an associated FK
		DB::statement('TRUNCATE users');
		DB::statement('TRUNCATE holidays');
		DB::statement('TRUNCATE comments');

		# Users
		$me = new User;
		$me->username = "Becky";
		$me->email = "rebecca.doris42@gmail.com";
		$me->DOB = "1988-01-29";
		$me->password = Hash::make("password1234");
		$me->save();

		# Events
		$example = new Holiday;
		$example->title = "Example event";
		$example->location = "109 Beacon St, Somerville MA";
		$example->when = "2014-12-18 18:00:00";
		$thanksgiving->description = "Don't show up to this unless you want to be disappointed.";

		# Associate has to be called *before* the event is created (save())
		$example->user()->associate($me); 
		$example->save();

		# Comments
		$gravy = new Comment;
		$gravy->text = "I love gravy! Leave comments over here.";

		# Associate must be called before we save (again)
		$gravy->user()->associate($me);
		$gravy->holiday()->associate($example);
		$gravy->save();
	}

}
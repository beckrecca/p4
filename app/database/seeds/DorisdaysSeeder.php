<?php

class DorisdaysSeeder extends Seeder {

	public function run() {

		# Clear the tables to a blank slate
		DB::statement('SET FOREIGN_KEY_CHECKS=0'); # Disable FK constraints so that all rows can be deleted, even if there's an associated FK
		DB::statement('TRUNCATE users');
		DB::statement('TRUNCATE holidays');
		DB::statement('TRUNCATE comments');

		# Users
		$dog = new User;
		$dog->username = "TuckerTheBeagle";
		$dog->email = "doris@g.harvard.edu";
		$dog->DOB = "1923-01-23";
		$dog->password = Hash::make("arrooo");
		$dog->save();

		$cat = new User;
		$cat->username = "Marbles";
		$cat->email = "blueandsilverstars@hotmail.com";
		$cat->DOB = "1991-11-14";
		$cat->password = Hash::make("BFIbinn");
		$cat->save();

		$hermitcrab = new User;
		$hermitcrab->username = "StinkyHermitCrabs";
		$hermitcrab->email = "drunkenlimeade@yahoo.com";
		$hermitcrab->DOB = "1996-05-14";
		$hermitcrab->password = Hash::make("instantlydead");
		$hermitcrab->save();

		# Events
		$thanksgiving = new Holiday;
		$thanksgiving->title = "Thanksgiving";
		$thanksgiving->location = "my house";
		$thanksgiving->when = "2014-11-27 17:00:00";
		$thanksgiving->description = "I'm gonna be chugging so much gravy.";

		# Associate has to be called *before* the event is created (save())
		$thanksgiving->user()->associate($dog); 
		$thanksgiving->save();

		$christmas = new Holiday;
		$christmas->title = "Christmas";
		$christmas->location = "123 Fake Lane, Dampland, MA";
		$christmas->when = "2014-12-25 08:00:00";
		$christmas->description = "Presents at 9, dinner at 2. Ham!";

		$christmas->user()->associate($cat);
		$christmas->save();

		# Comments
		$gravy = new Comment;
		$gravy->text = "I love gravy!";

		$eat = new Comment;
		$eat->text = "I'm gonna eat the entire turkey carcass out of the garbage tonight.";
		
		$merry = new Comment();
		$merry->text = "We want a new tank for Christmas!";

		# Associate must be called before we save (again)
		$gravy->user()->associate($cat);
		$gravy->holiday()->associate($thanksgiving);
		$gravy->save();

		$eat->user()->associate($dog);
		$eat->holiday()->associate($thanksgiving);
		$eat->save();

		$merry->holiday()->associate($hermitcrab);
		$merry->save();
	}

}
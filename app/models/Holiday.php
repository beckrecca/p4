<?php

class Holiday extends Eloquent
{
	public function comment() {
        # An event has many comments
        # Define a one-to-many relationship.
        return $this->hasMany('Comment');
    }
}
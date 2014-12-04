<?php

class Holiday extends Eloquent
{
	public function comment() {
        # An event has many comments
        # Define a one-to-many relationship.
        return $this->hasMany('Comment');
    }

    # Scope method for ordering the display of all the events
    public function scopeWhenAscending($query)
    {
        return $query->orderBy('when','ASC');
    } 
}
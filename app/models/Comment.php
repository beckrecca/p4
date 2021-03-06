<?php

class Comment extends Eloquent
{
	/**
    * A comment belongs to one user
    * Define an inverse one-to-many relationship.
    */
    public function user() {
        return $this->belongsTo('User');
    }

    /**
    * A comment belongs to only one event
    * Define an inverse one-to-many relationship.
    */
    public function holiday() {
        return $this->belongsTo('Holiday');
    }

    # Scope method for ordering the display of comments 
    public function scopeCreatedAtDescending($query)
    {
        return $query->orderBy('created_at','DESC');
    } 
}
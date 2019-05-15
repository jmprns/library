<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
    	'name', 
    	'author', 
    	'isbn', 
    	'cat_id',
    	'sub_id', 
    	'sub2_id', 
    	'stocks', 
    	'img'
    ];

    public function category()
    {
    	return $this->belongsTo('App\Category', 'cat_id');
    }

    public function subject()
    {
    	return $this->belongsTo('App\Subject', 'sub_id');
    }

    public function accession()
    {
        return $this->hasMany('App\Accession', 'book_id');
    }
}

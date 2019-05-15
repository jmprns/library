<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accession extends Model
{
    protected $fillable = ['book_id', 'name'];

    public function book()
    {
    	return $this->belongsTo('App\Book', 'book_id');
    }
}

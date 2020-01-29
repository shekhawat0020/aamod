<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
	 protected $table = 'posts';
    protected $fillable = [
        'title', 'description', 'category'
    ];
	
	public function category_detail()
    {
       return $this->hasOne('App\Category', 'id', 'category');
    }
}

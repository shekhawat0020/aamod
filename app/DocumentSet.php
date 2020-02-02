<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentSet extends Model
{
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
	 protected $table = 'document_set';
    protected $fillable = [
        'title', 'document_fields', 'status'
    ];
	
	
}

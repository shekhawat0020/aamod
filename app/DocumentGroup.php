<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentGroup extends Model
{
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
	 protected $table = 'document_group';
    protected $fillable = [
        'title', 'document_fields', 'status'
    ];
	
	
	
	
}

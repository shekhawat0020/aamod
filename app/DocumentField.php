<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentField extends Model
{
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
	 protected $table = 'document_field';
    protected $fillable = [
        'title', 'field_required', 'no_of_document', 'status'
    ];
	
	
}

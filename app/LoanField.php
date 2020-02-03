<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanField extends Model
{
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
	 protected $table = 'loan_field';
    protected $fillable = [
        'title', 'field_required', 'field_type','options_value', 'status'
    ];
	
	
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanType extends Model
{
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
	 protected $table = 'loantype';
    protected $fillable = [
        'title'
    ];
	
	
}

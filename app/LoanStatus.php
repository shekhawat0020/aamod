<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanStatus extends Model
{
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
	 protected $table = 'loan_status';
    protected $fillable = [
        'title'
    ];
	
	public function parent_detail()
    {
       return $this->hasOne('App\LoanStatus', 'id', 'parent_id');
    }
	
	
}

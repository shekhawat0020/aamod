<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
	 protected $table = 'loan';
    protected $fillable = [
        'borrower_id'
    ];
	
	public function borrower_detail()
    {
       return $this->hasOne('App\Borrower', 'id', 'borrower_id');
    }
	
	public function loan_type_detail()
    {
       return $this->hasOne('App\LoanType', 'id', 'loan_type_id');
    }
	
	public function loan_status_detail()
    {
       return $this->hasOne('App\LoanStatus', 'id', 'loan_status');
    }
	
	public function assign_detail()
    {
       return $this->hasOne('App\User', 'id', 'assign_to');
    }
	
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanBankStatus extends Model
{
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
	 protected $table = 'loan_bank_status';
    protected $fillable = [
        'loan_bank_id'
    ];
	
	
	public function loan_status_detail()
    {
       return $this->hasOne('App\LoanStatus', 'id', 'loan_status');
    }
	
	public function loan_sub_status_detail()
    {
       return $this->hasOne('App\LoanStatus', 'id', 'loan_sub_status');
    }
	
	
}

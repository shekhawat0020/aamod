<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanBank extends Model
{
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
	 protected $table = 'loan_bank';
    protected $fillable = [
        'bank_id', 'loan_id'
    ];
	
	public function bank_detail(){
		return $this->hasOne('App\Bank', 'id', 'bank_id');
		
	}
	
	public function loan_bank_status_detail(){
		return $this->hasOne('App\LoanBankStatus', 'loan_bank_id', 'id');
		
	}
	
	public function loan_bank_all_status_detail(){
		return $this->hasMany('App\LoanBankStatus', 'loan_bank_id', 'id');
		
	}
	
	
}

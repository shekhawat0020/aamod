<div class="form-group col-lg-12">
{{csrf_field()}}
         <input type="hidden" name="lona_id" value="{{$loan->id}}">
         <select name="loan_status" id="loan_status" class="form-control">
         <option value="">Select Loan Status</option>
		 @foreach($parent_status as $status)
			<option @if($loan->loan_status == $status->id) selected @endif value="{{$status->id}}">{{$status->title}}</option>
		 @endforeach
                  	
           </select>
         </div>
		<div class="form-group col-lg-12">
        <div id="getsubstatus">
        	
         <select name="loan_sub_status" id="loan_sub_status" class="form-control">
         <option value="">Sub Loan Status</option>
		 @foreach($sub_status as $status)
			<option @if($loan->loan_sub_status == $status->id) selected @endif value="{{$status->id}}">{{$status->title}}</option>
		 @endforeach
                  </select>
        
        </div>
        </div>
		<div class="form-group col-lg-12">
         <textarea type="text" placeholder="Internal Comment" name="internal_comment" id="internal_comment" class="form-control">{{$loan->internal_comment}}</textarea>
		</div> 
        
        <div class="form-group col-lg-12">
         <textarea type="text" placeholder="External Comment" name="external_comment" id="external_comment" class="form-control">{{$loan->external_comment}}</textarea>
		</div>
		
		<div class="form-group col-lg-12">
         <input type="date" name="ps_loan_date" id="ps_loan_date" class="form-control" @if($loan->ps_loan_date)value="{{$loan->ps_loan_date}}" @else value ="{{date('Y-m-d')}}"@endif>
		</div>
        
       
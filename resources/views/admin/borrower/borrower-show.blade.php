
<div class="col-lg-12">
    <div class="card">
        
        <div class="card-body">
        
            <div class="form-group">
                <label class="form-label">Name: {{$borrower->name}}</label>
                
            </div>

            <div class="form-group">
                <label class="form-label">Email: {{$borrower->email}}</label>
                
            </div>
			
			<div class="form-group">
                <label class="form-label">Mobile: {{$borrower->mobile_no}}</label>
                
            </div>
			
			<div class="form-group">
                <label class="form-label">Father: {{$borrower->father_name}}</label>
                
            </div>
			
			<div class="form-group">
                <label class="form-label">DOB: {{$borrower->dob}}</label>
                
            </div>
			
			<div class="form-group">
                <label class="form-label">PinCode: {{$borrower->pin_code}}</label>
                
            </div>
			
			<div class="form-group">
                <label class="form-label">Address: {{$borrower->address}}</label>
                
            </div>
			<div class="form-group">
                <label class="form-label">Aadhar: {{$borrower->aadher_number}}</label>
                
            </div>
			<div class="form-group">
                <label class="form-label">PAN: {{$borrower->pan_number}}</label>
                
            </div>

            <div class="form-group">
                <label class="form-label">Status : @if($borrower->status == 1) Active @else InActive @endif</label>
            </div>
            
           
        </div>
        
    </div>
</div>
        
      




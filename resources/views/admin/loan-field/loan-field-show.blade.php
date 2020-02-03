
<div class="col-lg-12">
    <div class="card">
        
        <div class="card-body">
        
            <div class="form-group">
                <label class="form-label">Title: {{$document->title}}</label>
                
            </div>
			<div class="form-group">
                <label class="form-label">Field Required: {{$document->field_required}}</label>
                
            </div>
			<div class="form-group">
                <label class="form-label">Field Type: {{$document->field_type}}</label>
                
            </div>

            
            <div class="form-group">
                <label class="form-label">Status : @if($document->status == 1) Active @else InActive @endif</label>
            </div>
            
           
        </div>
        
    </div>
</div>
        
      




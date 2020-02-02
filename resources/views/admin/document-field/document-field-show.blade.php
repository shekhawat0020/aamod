
<div class="col-lg-12">
    <div class="card">
        
        <div class="card-body">
        
            <div class="form-group">
                <label class="form-label">Title: {{$document->title}}</label>
                
            </div>
			<div class="form-group">
                <label class="form-label">No Of Document: {{$document->no_of_document}}</label>
                
            </div>
			<div class="form-group">
                <label class="form-label">Field Required: @if($document->field_required == 1) Yes @else No @endif</label>
                
            </div>

            
            <div class="form-group">
                <label class="form-label">Status : @if($document->status == 1) Active @else InActive @endif</label>
            </div>
            
           
        </div>
        
    </div>
</div>
        
      




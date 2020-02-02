
<div class="col-lg-12">
    <div class="card">
        
        <div class="card-body">
        
            <div class="form-set">
                <label class="form-label">Title: {{$document->title}}</label>
                
            </div>
			<div class="form-set">
                <label class="form-label">Fields:</label>
				@foreach($fields as $field)
				<p>{{$field->title}}</p>
				@endforeach
                
            </div>

            
            <div class="form-set">
                <label class="form-label">Status : @if($document->status == 1) Active @else InActive @endif</label>
            </div>
            
           
        </div>
        
    </div>
</div>
        
      





<div class="col-lg-12">
    <div class="card">
        
        <div class="card-body">
        
            <div class="form-group">
                <label class="form-label">Title: {{$loan->title}}</label>
                
            </div>

            
            <div class="form-group">
                <label class="form-label">Parent : @if($loan->parent_detail){{$loan->parent_detail->title}} @endif</label>
            </div>
            
           
        </div>
        
    </div>
</div>
        
      




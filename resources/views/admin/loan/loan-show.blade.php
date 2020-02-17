
<div class="col-lg-12">
    <div class="card">
        
        <div class="card-body">
        
            <div class="form-group">
                <label class="form-label">Title: {{$loan->title}}</label>
                
            </div>

            
            <div class="form-group">
                <label class="form-label">Status : @if($loan->status == 1) Active @else InActive @endif</label>
            </div>
            
           
        </div>
        
    </div>
</div>
        
      




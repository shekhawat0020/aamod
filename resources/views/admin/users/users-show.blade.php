
<div class="col-lg-12">
    <div class="card">
        
        <div class="card-body">
        
            <div class="form-group">
                <label class="form-label">Name: {{$user->name}}</label>
                
            </div>

            <div class="form-group">
                <label class="form-label">Email: {{$user->email}}</label>
                
            </div>

            <div class="form-group col-sm-6">
                <label class="form-label">Status : @if($user->status == 1) Active @else InActive @endif</label>
            </div>
            
           
        </div>
        
    </div>
</div>
        
      




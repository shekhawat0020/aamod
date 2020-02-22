<div class="form-group col-lg-12">
{{csrf_field()}}
         <input type="hidden" name="lona_id" value="{{$loan->id}}">
         <select name="assign_to" id="assign_to" class="form-control">
         <option value="">Select Assign</option>
		 @foreach($users as $user)
			<option @if($loan->assign_to == $user->id) selected @endif value="{{$user->id}}">{{$user->name}}</option>
		 @endforeach
                  	
           </select>
         </div>
		
       
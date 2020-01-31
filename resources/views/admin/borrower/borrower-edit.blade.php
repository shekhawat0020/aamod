@extends('admin/layouts/default')
@section('title')
<title>Edit Borrower</title>
@stop

@section('inlinecss')
<link href="{{ asset('admin/assets/multiselectbox/css/multi-select.css') }}" rel="stylesheet">
@stop

@section('breadcrum')
<h1 class="page-title">Edit Borrower</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Borrower</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
</ol>
@stop

@section('content')
<div class="app-content">
    <div class="side-app">

        <!-- PAGE-HEADER -->
        @include('admin.layouts.pagehead')
        <!-- PAGE-HEADER END -->

        <!--  Start Content -->
    <form id="submitForm" class="row"  method="post" action="{{route('borrower-update', $borrower->id)}}">
        {{csrf_field()}}
        <!-- COL END -->
							<div class="col-lg-6">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Borrower Forms</h3>
									</div>
									<div class="card-body">
                                    
										<div class="form-group">
											<label class="form-label">Full Name *</label>
											<input type="text" class="form-control" name="name" id="name" placeholder="Name.." value="{{$borrower->name}}">
										</div>

                                        <div class="form-group">
											<label class="form-label">Email *</label>
											<input type="email" class="form-control" name="email" id="email" placeholder="Email.." value="{{$borrower->email}}">
										</div>

                                        <div class="form-group">
											<label class="form-label">Mobile No *</label>
											<input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="Mobile.." value="{{$borrower->mobile_no}}">
										</div>
										<div class="form-group">
											<label class="form-label">PinCode</label>
											<input type="text" class="form-control" name="pin_code" id="pin_code" placeholder="PinCode.." value="{{$borrower->pin_code}}">
										</div>
										<div class="form-group">
											<label class="form-label">Address</label>
											<input type="text" class="form-control" name="address" id="address" placeholder="Address.." value="{{$borrower->address}}">
										</div>
                                       <div class="form-group">
											<label class="form-label">Profile Image </label>
											<input type="file" class="form-control" name="profile_image" id="profile_image" placeholder="Mobile..">
                                            <img id="profile_image_select" src="{{ asset(''.$borrower->profile_image) }}" style="width:100px">
										</div>

										
                                        <div class="form-group">
											<label class="form-label">Status</label>
											<select name="status" id="status" class="form-control custom-select">
												<option @if($borrower->status == 1) selected @endif value="1">Active</option>
												<option @if($borrower->status == 0) selected @endif value="0">InActive</option>
											</select>
                                        </div>
                                        <div class="card-footer"></div>
                                            <button type="submit" id="submitButton" class="btn btn-primary float-right"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> Sending..." data-rest-text="Update">Update</button>
                                        
										</div>
                                        
									</div>
                                    
								</div>
							
							
							<div class="col-lg-6">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Other Profile Detail</h3>
									</div>
									<div class="card-body">
                                    
										<div class="form-group">
											<label class="form-label">Father Name</label>
											<input type="text" class="form-control" name="father_name" id="father_name" placeholder="Father Name.." value="{{$borrower->father_name}}">
										</div>

                                        <div class="form-group">
											<label class="form-label">DOB</label>
											<input type="date" class="form-control" name="dob" id="dob" placeholder="DOB.." value="{{$borrower->dob}}">
										</div>

                                        
                                        

										<div class="form-group">
											<label class="form-label">Gender</label>
											<select name="gender" id="gender" class="form-control">
												<option value="">Select Gender</option>
                                                <option @if($borrower->gender == "Male") selected @endif value="Male">Male</option>
                                                <option @if($borrower->gender == "Female") selected @endif value="Female">Female</option>
                                                <option @if($borrower->gender == "Other") selected @endif value="Other">Other</option>
                                                
											</select>
										</div>
										
										<div class="form-group">
											<label class="form-label">Aadhar Number</label>
											<input type="test" class="form-control" name="aadhar_number" id="aadhar_number" placeholder="Aadhar Number.." value="{{$borrower->aadhar_number}}">
										</div>
										
										<div class="form-group">
											<label class="form-label">PAN Number</label>
											<input type="text" class="form-control" name="pan_number" id="pan_number" placeholder="PAN Number.." value="{{$borrower->pan_number}}">
										</div>
										
                                        
                                        
                                        
                                        
									</div>
                                    
								</div>
							</div><!-- COL END -->
							
							
							</form>
        </div><!-- COL END -->
        <!--  End Content -->

    </div>
</div>

@stop
@section('inlinejs')
<script src="{{ asset('admin/assets/multiselectbox/js/jquery.multi-select.js') }}"></script>          
    <script type="text/javascript">
        
        $(function () { 
            $('#roles').multiSelect();
           $('#submitForm').submit(function(){
            var $this = $('#submitButton');
            buttonLoading('loading', $this);
            $('.is-invalid').removeClass('is-invalid state-invalid');
            $('.invalid-feedback').remove();
            $.ajax({
                url: $('#submitForm').attr('action'),
                type: "POST",
                processData: false,  // Important!
                contentType: false,
                cache: false,
                data: new FormData($('#submitForm')[0]),
                success: function(data) {
                    if(data.status){
						var btn = '<a href="{{route('borrower-list')}}" class="btn btn-info btn-sm">GoTo List</a>';
                        successMsg('Edit Borrower', data.msg, btn);
                        

                    }else{
                        $.each(data.errors, function(fieldName, field){
                            $.each(field, function(index, msg){
                                $('#'+fieldName).addClass('is-invalid state-invalid');
                               errorDiv = $('#'+fieldName).parent('div');
                               errorDiv.append('<div class="invalid-feedback">'+msg+'</div>');
                            });
                        });
                        errorMsg('Edit Borrower','Input error');
                    }
                    buttonLoading('reset', $this);
                    
                },
                error: function() {
                    errorMsg('Edit Borrower', 'There has been an error, please alert us immediately');
                    buttonLoading('reset', $this);
                }

            });

            return false;
           });

           });
		   
		   $("#profile_image").change(function(){
                readURL(this);
            });
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#profile_image_select').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }
            
       
    </script>
@stop
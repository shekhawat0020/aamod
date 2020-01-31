@extends('admin/layouts/default')
@section('title')
<title>Create Borrower</title>
@stop

@section('inlinecss')
<link href="{{ asset('admin/assets/multiselectbox/css/multi-select.css') }}" rel="stylesheet">
@stop

@section('breadcrum')
<h1 class="page-title">Create Borrower</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Borrower</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create</li>
</ol>
@stop

@section('content')
<div class="app-content">
    <div class="side-app">

        <!-- PAGE-HEADER -->
        @include('admin.layouts.pagehead')
        <!-- PAGE-HEADER END -->

        <!--  Start Content -->
    <form id="submitForm" class="row"  method="post" action="{{route('borrower-save')}}">
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
											<input type="text" class="form-control" name="name" id="name" placeholder="Name..">
										</div>

                                        <div class="form-group">
											<label class="form-label">Email *</label>
											<input type="email" class="form-control" name="email" id="email" placeholder="Email..">
										</div>

                                        <div class="form-group">
											<label class="form-label">Mobile No *</label>
											<input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="Mobile..">
										</div>
										<div class="form-group">
											<label class="form-label">PinCode</label>
											<input type="text" class="form-control" name="pin_code" id="pin_code" placeholder="PinCode..">
										</div>
										<div class="form-group">
											<label class="form-label">Address</label>
											<input type="text" class="form-control" name="address" id="address" placeholder="Address..">
										</div>
                                        <div class="form-group">
											<label class="form-label">Profile Image</label>
											<input type="file" class="form-control" name="profile_image" id="profile_image" placeholder="Mobile..">
										</div>

										
                                        <div class="form-group">
											<label class="form-label">Password *</label>
											<div class="input-group">
												<input type="text" name="password" id="password" class="form-control" placeholder="">
												<span class="input-group-append">
													<button class="btn btn-primary" type="button" onclick="getPassword()">Generate!</button>
												</span>
											</div>							
                                        
                                        
                                        </div>
                                        <div class="form-group">
											<label class="form-label">Status</label>
											<select name="status" id="status" class="form-control custom-select">
												<option value="1">Active</option>
												<option value="0">InActive</option>
											</select>
                                        </div>
                                        <div class="card-footer"></div>
                                            <button type="submit" id="submitButton" class="btn btn-primary float-right"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> Sending..." data-rest-text="Create">Create</button>
                                        
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
											<input type="text" class="form-control" name="father_name" id="father_name" placeholder="Father Name..">
										</div>

                                        <div class="form-group">
											<label class="form-label">DOB</label>
											<input type="date" class="form-control" name="dob" id="dob" placeholder="DOB..">
										</div>

                                        
                                        

										<div class="form-group">
											<label class="form-label">Gender</label>
											<select name="gender" id="gender" class="form-control">
												<option value="">Select Gender</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Other</option>
                                                
											</select>
										</div>
										
										<div class="form-group">
											<label class="form-label">Aadhar Number</label>
											<input type="test" class="form-control" name="aadhar_number" id="aadhar_number" placeholder="Aadhar Number..">
										</div>
										
										<div class="form-group">
											<label class="form-label">PAN Number</label>
											<input type="text" class="form-control" name="pan_number" id="pan_number" placeholder="PAN Number..">
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
                        successMsg('Create Borrower', data.msg, btn);
                        $('#submitForm')[0].reset();

                    }else{
                        $.each(data.errors, function(fieldName, field){
                            $.each(field, function(index, msg){
                                $('#'+fieldName).addClass('is-invalid state-invalid');
                               errorDiv = $('#'+fieldName).parent('div');
                               errorDiv.append('<div class="invalid-feedback">'+msg+'</div>');
                            });
                        });
                        errorMsg('Create Borrower','Input error');
                    }
                    buttonLoading('reset', $this);
                    
                },
                error: function() {
                    errorMsg('Create Borrower', 'There has been an error, please alert us immediately');
                    buttonLoading('reset', $this);
                }

            });

            return false;
           });

           });
            
       function getPassword(){
           pass=  Math.random().toString(36).slice(-8);
           $('#password').val(pass);
       }
    </script>
@stop
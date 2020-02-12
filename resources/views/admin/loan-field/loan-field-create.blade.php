@extends('admin/layouts/default')
@section('title')
<title>Create Loan Field</title>
@stop

@section('inlinecss')
<link href="{{ asset('admin/assets/multiselectbox/css/multi-select.css') }}" rel="stylesheet">
@stop

@section('breadcrum')
<h1 class="page-title">Create Loan Field</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Loan Field</a></li>
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
    <form id="submitForm" class="row"  method="post" action="{{route('loan-field-save')}}">
        {{csrf_field()}}
        <!-- COL END -->
							<div class="col-lg-6">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Loan Field Forms</h3>
									</div>
									<div class="card-body">
                                    
										<div class="form-group">
											<label class="form-label">Title *</label>
											<input type="text" class="form-control" name="title" id="title" placeholder="Title..">
										</div>
										
										<div class="form-group">
											<label class="form-label">Field Required *</label>
											<select name="field_required" id="field_required" class="form-control custom-select">
												<option value="1">Yes</option>
												<option value="0">No</option>
											</select>
										</div>
										
										<div class="form-group">
											<label class="form-label">Field Type *</label>
											<select name="field_type" id="field_type" class="form-control custom-select">
												
												<option value="">Select Field Type</option>
												<option value="Text">Text</option>
												<option value="Numeric">Numeric</option>
												<option value="Select">Select</option>
												<option value="Textarea">Textarea</option>
												<option value="Date">Date</option>
												<option value="Mobile">Mobile</option>
												<option value="Email">Email</option>
												<option value="Credit Card">Credit Card</option>
												<option value="Aadhar">Aadhar</option>
												<option value="Pan">Pan</option>
												
											</select>
										</div>
										<div class="form-group">
											<label class="form-label">Conditional Type *</label>
											<select name="conditional_type" id="conditional_type" class="form-control custom-select">
												<option value="None">None</option>
												<option value="Show Hide">Show Hide</option>
											</select>
										</div>
										<div class="form-group condition_field" style="display:none">
											<label class="form-label">Condition Field Name</label>
											<input type="text" class="form-control" name="condition_field" id="condition_field" placeholder="">
										</div>
										<div class="form-group option-list" style="display:none">
										<div class="input-group" data-duplicate="input-option">
											<input type="text" class="form-control" name="options_value[]" id="options_value" placeholder="Option..">
											<span class="input-group-append"><button class="btn btn-primary" type="button" data-duplicate-add="input-option">+</button></span>
											<span class="input-group-append"><button class="btn btn-primary" type="button" data-duplicate-remove="input-option">-</button></span>
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
							
						
							
							</form>
        </div><!-- COL END -->
        <!--  End Content -->

    </div>
</div>

@stop
@section('inlinejs')
<script src="{{ asset('admin/assets/multiselectbox/js/jquery.multi-select.js') }}"></script> 
<script src="{{ asset('admin/assets/js/jquery.duplicate.js') }}"></script>              
    <script type="text/javascript">
        
        $(function () { 
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
						var btn = '<a href="{{route('loan-field-list')}}" class="btn btn-info btn-sm">GoTo List</a>';
                        successMsg('Create Loan Field', data.msg, btn);
                        $('#submitForm')[0].reset();

                    }else{
                        $.each(data.errors, function(fieldName, field){
                            $.each(field, function(index, msg){
                                $('#'+fieldName).addClass('is-invalid state-invalid');
                               errorDiv = $('#'+fieldName).parent('div');
                               errorDiv.append('<div class="invalid-feedback">'+msg+'</div>');
                            });
                        });
                        errorMsg('Create Loan Field','Input error');
                    }
                    buttonLoading('reset', $this);
                    
                },
                error: function() {
                    errorMsg('Create Loan Field', 'There has been an error, please alert us immediately');
                    buttonLoading('reset', $this);
                }

            });

            return false;
           });
		   
		   $('#field_type').change(function(){
			   fieldType = $(this).val();
			   if(fieldType == 'Select'){
				   $('.option-list').show();
			   }else{
				   $('.option-list').hide();
			   }
		   });
		   
		   $('#conditional_type').change(function(){
			   fieldType = $(this).val();
			   if(fieldType != 'None'){
				   $('.condition_field').show();
			   }else{
				   $('.condition_field').hide();
				   $('#condition_field').val("");
			   }
		   });

           });
            
       
    </script>
@stop
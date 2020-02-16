@extends('admin/layouts/default')
@section('title')
<title>Edit Loan Type</title>
@stop

@section('inlinecss')
<link href="{{ asset('admin/assets/multiselectbox/css/multi-select.css') }}" rel="stylesheet">
@stop

@section('breadcrum')
<h1 class="page-title">Edit Loan Field</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Loan Field</a></li>
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
    <form id="submitForm" class="row"  method="post" action="{{route('loan-field-update', $document->id)}}">
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
											<input type="text" class="form-control" name="title" id="title" placeholder="Title.." value="{{$document->title}}">
										</div>

                                        <div class="form-group">
											<label class="form-label">Field Required *</label>
											<select name="field_required" id="field_required" class="form-control custom-select">
												<option @if($document->field_required == 1) selected @endif value="1">Yes</option>
												<option @if($document->field_required == 0) selected @endif value="0">No</option>
											</select>
										</div>
										
										<div class="form-group">
											<label class="form-label">Field Type *</label>
											<select name="field_type" id="field_type" class="form-control custom-select">
												
												<option value="">Select Field Type</option>
												<option @if($document->field_type == 'Text') selected @endif value="Text">Text</option>
												<option @if($document->field_type == 'Numeric') selected @endif value="Numeric">Numeric</option>
												<option @if($document->field_type == 'Select') selected @endif value="Select">Select</option>
												<option @if($document->field_type == 'Textarea') selected @endif value="Textarea">Textarea</option>
												<option @if($document->field_type == 'Date') selected @endif value="Date">Date</option>
												<option @if($document->field_type == 'Mobile') selected @endif value="Mobile">Mobile</option>
												<option @if($document->field_type == 'Email') selected @endif value="Email">Email</option>
												<option @if($document->field_type == 'Credit Card') selected @endif value="Credit Card">Credit Card</option>
												<option @if($document->field_type == 'Aadhar') selected @endif value="Aadhar">Aadhar</option>
												<option @if($document->field_type == 'Pan') selected @endif value="Pan">Pan</option>
												
											</select>
										</div>
										<div class="form-group">
											<label class="form-label">Conditional Type *</label>
											<select name="conditional_type" id="conditional_type" class="form-control custom-select">
												<option @if($document->conditional_type == 'None') selected @endif value="None">None</option>
												<option @if($document->conditional_type == 'Show Hide') selected @endif value="Show Hide">Show Hide</option>
											</select>
										</div>
										<div class="form-group condition_field" @if($document->conditional_type == 'None') style="display:none" @endif>
											<label class="form-label">Condition Field Name</label>
											<select class="form-control" name="condition_field" id="condition_field">
											<option value=""> Select One</option>
											@foreach($fields as $field)
											<option @if($document->condition_field == $field->title) selected @endif value="{{$field->title}}">{{$field->title}}</option>
											@endforeach
											</select>
										</div>
										<div class="form-group condition_value" @if($document->conditional_type == 'None') style="display:none" @endif>
											<label class="form-label">Condition Field Name</label>
											<input type="text" value="{{$document->condition_value}}" class="form-control" name="condition_value" id="condition_value" placeholder="">
										</div>
										<div class="form-group option-list" @if($document->field_type != 'Select') style="display:none" @endif>
										@foreach(json_decode($document->options_value) as $option)
										<div class="input-group" data-duplicate="input-option">
											<input type="text" value="{{$option}}" class="form-control" name="options_value[]" id="options_value" placeholder="Option..">
											<span class="input-group-append"><button class="btn btn-primary" type="button" data-duplicate-add="input-option">+</button></span>
											<span class="input-group-append"><button class="btn btn-primary" type="button" data-duplicate-remove="input-option">-</button></span>
										</div>
										@endforeach
										</div>
										
                                        <div class="form-group">
											<label class="form-label">Status</label>
											<select name="status" id="status" class="form-control custom-select">
												<option @if($document->status == 1) selected @endif value="1">Active</option>
												<option @if($document->status == 0) selected @endif value="0">InActive</option>
											</select>
                                        </div>
                                        <div class="card-footer"></div>
                                            <button type="submit" id="submitButton" class="btn btn-primary float-right"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> Sending..." data-rest-text="Update">Update</button>
                                        
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
                        successMsg('Edit Loan Field', data.msg, btn);
                        

                    }else{
                        $.each(data.errors, function(fieldName, field){
                            $.each(field, function(index, msg){
                                $('#'+fieldName).addClass('is-invalid state-invalid');
                               errorDiv = $('#'+fieldName).parent('div');
                               errorDiv.append('<div class="invalid-feedback">'+msg+'</div>');
                            });
                        });
                        errorMsg('Edit Loan Field','Input error');
                    }
                    buttonLoading('reset', $this);
                    
                },
                error: function() {
                    errorMsg('Edit Loan Field', 'There has been an error, please alert us immediately');
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
				   $('.condition_value').show();
			   }else{
				   $('.condition_field').hide();
				   $('#condition_field').val("");
				   
				   $('.condition_value').hide();
				   $('#condition_value').val("");
			   }
		   });

           });
		   
		   
       
    </script>
@stop
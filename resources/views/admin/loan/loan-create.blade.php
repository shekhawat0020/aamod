@extends('admin/layouts/default')
@section('title')
<title>Create Loan</title>
@stop

@section('inlinecss')
<link type="text/css" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/ui-lightness/jquery-ui.css" />
<link href="{{ asset('admin/assets/multiselectbox/css/ui.multiselect.css') }}" rel="stylesheet">
@stop

@section('breadcrum')
<h1 class="page-title">Create Loan</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Loan</a></li>
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
    <form id="submitForm" class="row"  method="post" action="{{route('loan-save')}}">
        {{csrf_field()}}
		<input type="hidden" name="loan_type" value="{{$loan_type_id}}">
        <!-- COL END -->
							<div class="col-lg-6">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Loan Form for {{$loanType->title}}</h3>
									</div>
									<div class="card-body">
									
									<div class="form-group">
											<label class="form-label"> Apply for Borrower *</label>											
											<select class="form-control select2" name="borrower" id="borrower" required>
												<option value=""> Select Borrower </option>
												@foreach($borrowers as $borrower)
												<option value="{{$borrower->id}}">{{$borrower->name}}</option>
												@endforeach
											</select>
										</div>
                                    @foreach($fields as $field)
									
									@php  $ftitle = preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', $field->title));  @endphp
									
									@if($field->field_type == 'Text' || $field->field_type == 'Mobile' || $field->field_type == 'Credit Card' || $field->field_type == 'Aadhar' || $field->field_type == 'Pan')
										<div class="form-group @if($field->conditional_type != 'None') condtional-field @endif" @if($field->conditional_type != 'None')style="display:none" data-condition-field="{{preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', $field->condition_field))}}" data-condition-value="{{$field->condition_value}}"@endif>
											<label class="form-label">{{$field->title}} @if($field->field_required)* @endif</label>											
											<input type="text" class="form-control" name="{{$ftitle}}" id="{{$ftitle}}" @if($field->field_required)required @endif>
										</div>
									@endif
									
									@if($field->field_type == 'Email')
										<div class="form-group @if($field->conditional_type != 'None') condtional-field @endif" @if($field->conditional_type != 'None')style="display:none" data-condition-field="{{preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', $field->condition_field))}}" data-condition-value="{{$field->condition_value}}"@endif>
											<label class="form-label">{{$field->title}} @if($field->field_required)* @endif</label>											
											<input type="email" class="form-control" name="{{$ftitle}}" id="{{$ftitle}}" @if($field->field_required)required @endif>
										</div>
									@endif
									
									@if($field->field_type == 'Numeric')
										<div class="form-group @if($field->conditional_type != 'None') condtional-field @endif" @if($field->conditional_type != 'None')style="display:none" data-condition-field="{{preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', $field->condition_field))}}" data-condition-value="{{$field->condition_value}}"@endif>
											<label class="form-label">{{$field->title}} @if($field->field_required)* @endif</label>											
											<input type="numeric" class="form-control" name="{{$ftitle}}" id="{{$ftitle}}" @if($field->field_required)required @endif>
										</div>
									@endif
									
									@if($field->field_type == 'Date')
										<div class="form-group @if($field->conditional_type != 'None') condtional-field @endif" @if($field->conditional_type != 'None')style="display:none" data-condition-field="{{preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', $field->condition_field))}}" data-condition-value="{{$field->condition_value}}"@endif>
											<label class="form-label">{{$field->title}} @if($field->field_required)* @endif</label>											
											<input type="date" class="form-control" name="{{$ftitle}}" id="{{$ftitle}}" @if($field->field_required)required @endif>
										</div>
									@endif
									
									@if($field->field_type == 'Textarea')
										<div class="form-group @if($field->conditional_type != 'None') condtional-field @endif" @if($field->conditional_type != 'None')style="display:none" data-condition-field="{{preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', $field->condition_field))}}" data-condition-value="{{$field->condition_value}}"@endif>
											<label class="form-label">{{$field->title}} @if($field->field_required)* @endif</label>											
											<textarea class="form-control" name="{{$ftitle}}" id="{{$ftitle}}" @if($field->field_required)required @endif></textarea>
										</div>
									@endif

									@if($field->field_type == 'Select')
										<div class="form-group @if($field->conditional_type != 'None') condtional-field @endif" @if($field->conditional_type != 'None')style="display:none" data-condition-field="{{preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', $field->condition_field))}}" data-condition-value="{{$field->condition_value}}"@endif>
											<label class="form-label">{{$field->title}} @if($field->field_required)* @endif</label>											
											<select class="form-control" name="{{$ftitle}}" id="{{$ftitle}}" @if($field->field_required)required @endif>
												@php  $options =  json_decode($field->options_value)  @endphp
												<option value=""> Select {{$field->title}} </option>
												@foreach($options as $option)
												<option value="{{$option}}">{{$option}}</option>
												@endforeach
											</select>
										</div>
									@endif
										
									@endforeach	
										
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
						var btn = '<a href="{{route('loan-list')}}" class="btn btn-info btn-sm">GoTo List</a>';
                        successMsg('Create Loan', data.msg, btn);
                        $('#submitForm')[0].reset();

                    }else{
                        $.each(data.errors, function(fieldName, field){
                            $.each(field, function(index, msg){
                                $('#'+fieldName).addClass('is-invalid state-invalid');
                               errorDiv = $('#'+fieldName).parent('div');
                               errorDiv.append('<div class="invalid-feedback">'+msg+'</div>');
                            });
                        });
                        errorMsg('Create Loan','Input error');
                    }
                    buttonLoading('reset', $this);
                    
                },
                error: function() {
                    errorMsg('Create Loan Type', 'There has been an error, please alert us immediately');
                    buttonLoading('reset', $this);
                }

            });

            return false;
           });

          
		$('.form-control').change(function(){
			id = $(this).attr('id');
			fieldvalue = $(this).val();
			$('.condtional-field').each(function(key,obj){
				if($(this).attr('data-condition-field') == id) {
					
					condtionValues = $(this).attr('data-condition-value');
					condtionValues = condtionValues.split(',');	
					console.log(condtionValues);					
					if($.inArray(fieldvalue,condtionValues) != -1){
						$(this).show();
					}else{
						$(this).hide();
						$(this).find('.form-control').val("");					
					}
				}
			});
		});

	    });
            
       
    </script>
@stop	
@section('bottomjs')

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js"></script>
<script src="{{ asset('admin/assets/multiselectbox/js/ui.multiselect.js') }}"></script>   
<script>

$(function () { 
            $('#loan_fields').multiselect();
});			
  </script> 
@stop
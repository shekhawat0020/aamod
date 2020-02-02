@extends('admin/layouts/default')
@section('title')
<title>Edit Loan Type</title>
@stop

@section('inlinecss')
<link href="{{ asset('admin/assets/multiselectbox/css/multi-select.css') }}" rel="stylesheet">
@stop

@section('breadcrum')
<h1 class="page-title">Edit Document Field</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Document Field</a></li>
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
    <form id="submitForm" class="row"  method="post" action="{{route('document-field-update', $document->id)}}">
        {{csrf_field()}}
        <!-- COL END -->
							<div class="col-lg-6">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Document Field Forms</h3>
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
											<label class="form-label">No Of Document *</label>
											<select name="no_of_document" id="no_of_document" class="form-control custom-select">
												@for($i = 1; $i <= 10; $i++)
												<option @if($document->no_of_document == $i) selected @endif value="{{$i}}">{{$i}}</option>
												@endfor
											</select>
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
						var btn = '<a href="{{route('document-field-list')}}" class="btn btn-info btn-sm">GoTo List</a>';
                        successMsg('Edit Document Field', data.msg, btn);
                        

                    }else{
                        $.each(data.errors, function(fieldName, field){
                            $.each(field, function(index, msg){
                                $('#'+fieldName).addClass('is-invalid state-invalid');
                               errorDiv = $('#'+fieldName).parent('div');
                               errorDiv.append('<div class="invalid-feedback">'+msg+'</div>');
                            });
                        });
                        errorMsg('Edit Document Field','Input error');
                    }
                    buttonLoading('reset', $this);
                    
                },
                error: function() {
                    errorMsg('Edit Document Field', 'There has been an error, please alert us immediately');
                    buttonLoading('reset', $this);
                }

            });

            return false;
           });

           });
		   
		   
       
    </script>
@stop
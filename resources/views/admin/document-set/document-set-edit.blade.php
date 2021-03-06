@extends('admin/layouts/default')
@section('title')
<title>Edit Document Set</title>
@stop

@section('inlinecss')
<link type="text/css" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/ui-lightness/jquery-ui.css" />
<link href="{{ asset('admin/assets/multiselectbox/css/ui.multiselect.css') }}" rel="stylesheet">
@stop

@section('breadcrum')
<h1 class="page-title">Edit Document Set</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Document Set</a></li>
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
    <form id="submitForm" class="row"  method="post" action="{{route('document-set-update', $document->id)}}">
        {{csrf_field()}}
        <!-- COL END -->
							<div class="col-lg-6">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Document Set Forms</h3>
									</div>
									<div class="card-body">
                                    
										<div class="form-set">
											<label class="form-label">Title *</label>
											<input type="text" class="form-control" name="title" id="title" placeholder="Title.." value="{{$document->title}}">
										</div>

                                        <div class="form-set">
											<label class="form-label">Fields *</label>
											<select name="document_fields[]" id="document_fields" multiple="multiple" class="multi-select form-control">
												
                                                @foreach($fields as $field)
                                                <option @if(in_array($field->id,json_decode($document->document_fields))) selected @endif value="{{$field->id}}">{{$field->title}}</option>
                                                @endforeach
											</select>
										</div>
										
                                        <div class="form-set">
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
						var btn = '<a href="{{route('document-set-list')}}" class="btn btn-info btn-sm">GoTo List</a>';
                        successMsg('Edit Document Set', data.msg, btn);
                        

                    }else{
                        $.each(data.errors, function(setName, set){
                            $.each(set, function(index, msg){
                                $('#'+setName).addClass('is-invalid state-invalid');
                               errorDiv = $('#'+setName).parent('div');
                               errorDiv.append('<div class="invalid-feedback">'+msg+'</div>');
                            });
                        });
                        errorMsg('Edit Document Set','Input error');
                    }
                    buttonLoading('reset', $this);
                    
                },
                error: function() {
                    errorMsg('Edit Document Set', 'There has been an error, please alert us immediately');
                    buttonLoading('reset', $this);
                }

            });

            return false;
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
            $('#document_fields').multiselect();
});			
  </script> 
@stop


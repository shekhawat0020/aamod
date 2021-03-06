@extends('admin/layouts/default')
@section('title')
<title>Edit Loan Status</title>
@stop

@section('inlinecss')
<link type="text/css" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/ui-lightness/jquery-ui.css" />
<link href="{{ asset('admin/assets/multiselectbox/css/ui.multiselect.css') }}" rel="stylesheet">
@stop

@section('breadcrum')
<h1 class="page-title">Edit Loan Status</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Loan Status</a></li>
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
    <form id="submitForm" class="row"  method="post" action="{{route('loan-status-update', $loan->id)}}">
        {{csrf_field()}}
        <!-- COL END -->
							<div class="col-lg-6">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Loan Status Forms</h3>
									</div>
									<div class="card-body">
                                    
										<div class="form-group">
											<label class="form-label">Title *</label>
											<input type="text" class="form-control" name="title" id="title" placeholder="Title.." value="{{$loan->title}}">
										</div>
										
										<div class="form-group">
											<label class="form-label">Parent *</label>
											<select name="parent_id" id="parent_id" class="form-control">
												<option value="0">Select Parent</option>
                                                @foreach($loan_status as $status)
                                                <option @if($loan->parent_id == $status->id) selected @endif value="{{$status->id}}">{{$status->title}}</option>
                                                @endforeach
											</select>
										</div>
										
										<div class="form-group">
											<label class="form-label">Sort Order *</label>
											<select name="sort_order" id="sort_order" class="form-control">
												
                                                @for($i=1; $i<=100; $i++)
                                                <option @if($loan->sort_order == $i) selected @endif value="{{$i}}">{{$i}}</option>
                                                @endfor
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
						var btn = '<a href="{{route('loan-type-list')}}" class="btn btn-info btn-sm">GoTo List</a>';
                        successMsg('Edit Loan Type', data.msg, btn);
                        

                    }else{
                        $.each(data.errors, function(fieldName, field){
                            $.each(field, function(index, msg){
                                $('#'+fieldName).addClass('is-invalid state-invalid');
                               errorDiv = $('#'+fieldName).parent('div');
                               errorDiv.append('<div class="invalid-feedback">'+msg+'</div>');
                            });
                        });
                        errorMsg('Edit Loan Type','Input error');
                    }
                    buttonLoading('reset', $this);
                    
                },
                error: function() {
                    errorMsg('Edit Loan Type', 'There has been an error, please alert us immediately');
                    buttonLoading('reset', $this);
                }

            });

            return false;
           });

           });
		   $("#icon").change(function(){
                readURL(this);
            });
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#icon_image_select').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }
		   
       
    </script>
@stop	
@section('bottomjs')

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js"></script>
<script src="{{ asset('admin/assets/multiselectbox/js/ui.multiselect.js') }}"></script>   
<script>

$(function () { 
  $('#loan_fields').multiselect();
  $("ul.selected li").each(function(){
		var selected_value = $(this).attr('data-selected-value');
		//alert(selected_value);
	});
});			
  </script> 
@stop
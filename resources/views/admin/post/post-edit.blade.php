@extends('admin/layouts/default')
@section('title')
<title>Edit Post</title>
@stop

@section('inlinecss')

<!-- WYSIWYG EDITOR CSS -->
<link href="{{ asset('admin/assets/plugins/wysiwyag/richtext.css') }}" rel="stylesheet"/>
@stop

@section('breadcrum')
<h1 class="page-title">Edit Post</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Post</a></li>
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
    
        <!-- COL END -->
							<div class="col-lg-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Post Forms</h3>
									</div>
									<div class="card-body">
                                    <form id="submitForm"  method="post" action="{{route('post-update', $post->id)}}">
                                    {{csrf_field()}}
                                    <div class="row">
										<div class="form-group col-sm-6">
											<label class="form-label">Title *</label>
											<input type="text" class="form-control" name="title" id="title" value="{{$post->title}}">
                                        </div>
										
										<div class="form-group col-sm-6">
											<label class="form-label">Category *</label>
											<select name="category" id="category" class="form-control custom-select">
												<option value="">Select</option>
												@foreach($category as $cat)
												<option @if($post->category == $cat->id) selected @endif  value="{{$cat->id}}">{{$cat->category}}</option>
												@endforeach
											</select>
                                        </div>

                                        
                                        <div class="form-group col-sm-12">
											<label class="form-label">Description *</label>
											<textarea class="form-control" name="description" id="description">{{$post->description}}</textarea>
                                        </div>
										
										<div class="form-group col-sm-12">
										<h4 class="title">Job detail</h4>
										</div>
										
										<div class="form-group col-sm-12">
											<label class="form-label">Form fill Last date *</label>
											<input type="date" class="form-control" name="fill_last_date" id="fill_last_date" value="{{date('Y-m-d', strtotime($post->fill_last_date))}}">
                                        </div>
										
										<div class="form-group col-sm-6">
											<label class="form-label">General Fees*</label>
											<input type="text" class="form-control" name="general_fees" id="general_fees" value="{{$post->general_fees}}">
                                        </div>
										
										<div class="form-group col-sm-6">
											<label class="form-label">OBC Fees*</label>
											<input type="text" class="form-control" name="obc_fees" id="obc_fees" value="{{$post->obc_fees}}">
                                        </div>
										
										<div class="form-group col-sm-6">
											<label class="form-label">SC Fees*</label>
											<input type="text" class="form-control" name="scst_fees" id="scst_fees" value="{{$post->scst_fees}}">
                                        </div>
										
										<div class="form-group col-sm-6">
											<label class="form-label">ST Fees*</label>
											<input type="text" class="form-control" name="st_fees" id="st_fees" value="{{$post->st_fees}}">
                                        </div>
										
										<div class="form-group col-sm-6">
											<label class="form-label">Job Token Fees*</label>
											<input type="text" class="form-control" name="token_fees" id="token_fees" value="{{$post->token_fees}}">
                                        </div>
										
										
                                        <div class="form-group col-sm-6">
											<label class="form-label">Status</label>
											<select name="status" id="status" class="form-control custom-select">
												<option @if($post->status == 1) selected @endif value="1">Active</option>
												<option @if($post->status == 0) selected @endif value="0">InActive</option>
											</select>
                                        </div>
										
                                    </div>
                                    
                                        
                                        <div class="card-footer"></div>
                                            <button type="submit" id="submitButton" class="btn btn-primary float-right"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> Sending..." data-rest-text="Update">Update</button>
                                        
										</div>
                                        </form>
									</div>
                                    
								</div>
							</div><!-- COL END -->
        
        <!--  End Content -->

    </div>
</div>

@stop
@section('inlinejs')
           
<script src="{{ asset('admin/assets/plugins/wysiwyag/jquery.richtext.js') }}"></script>
    <script type="text/javascript">
        
        $(function () { 
		
		$('textarea').richText();
           $('#submitForm').submit(function(){
            var $this = $('#submitButton');
            buttonLoading('loading', $this);
            $('.is-invalid').removeClass('is-invalid state-invalid');
            $('.invalid-feedback').remove();
            $.ajax({
                url: $('#submitForm').attr('action'),
                type: "POST",
                data: $('#submitForm').serialize(),
                success: function(data) {
                    if(data.status){
                        var btn = '<a href="{{route('post-list')}}" class="btn btn-info btn-sm">GoTo List</a>';
                        successMsg('Update post', data.msg, btn);
                        //$('#submitForm')[0].reset();

                    }else{
                        $.each(data.errors, function(fieldName, field){
                            $.each(field, function(index, msg){
                                $('#'+fieldName).addClass('is-invalid state-invalid');
                               errorDiv = $('#'+fieldName).parent('div');
                               errorDiv.append('<div class="invalid-feedback">'+msg+'</div>');
                            });
                        });
						errorMsg('Edit Post', 'Input Error');
                    }
                    buttonLoading('reset', $this);
                    
                },
                error: function() {
                    errorMsg('Update Post', 'There has been an error, please alert us immediately');
                    buttonLoading('reset', $this);
                }

            });

            return false;
           });

           });
            
      
    </script>
@stop
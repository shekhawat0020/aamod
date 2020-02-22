@extends('admin/layouts/default')
@section('title')
<title>Aamod-Loan</title>
@stop
@section('inlinecss')

@stop
@section('content')
<div class="app-content">
    <div class="side-app">

        <!-- PAGE-HEADER -->
        @include('admin.layouts.pagehead')
        <!-- PAGE-HEADER END -->

        <!-- ROW-1 OPEN -->
        <div class="col-12">
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Loan</h3>
                        <div class="ml-auto pageheader-btn">
                        
                            @can('User Create')
							<div class="form-group pull-left" style="margin-right: 10px;">
							<select id="loan_type" class="form-control">
							@foreach($loanTypes as $type)
								<option value="{{$type->id}}">{{$type->title}}</option>
							@endforeach
							</select>
							
							</div>
								<a href="{{ route('loan-create', 1) }}" class="btn btn-success btn-icon text-white mr-2 create-link">
									<span>
										<i class="fe fe-plus"></i>
									</span> Add Loan
								</a>
							
								<a href="#" class="btn btn-danger btn-icon text-white">
									<span>
										<i class="fe fe-log-in"></i>
									</span> Export
                                </a>
                            @endcan
							</div>
                    </div>
                    <div class="card-body ">
                        
                    <table class="table table-bordered data-table w-100">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Loan Id</th>
                              <th>Borrower Name</th>
                              <th>Mobile</th>
                              <th>Loan Status</th>
                              <th>Assign To</th>
                              <th>Loan Type</th>
                              <th width="100px">Action</th>
                          </tr>
                      </thead>
                      <tbody>
                      </tbody>
                  </table>

                    </div>
                </div>
            </div>
        </div>
        <!-- ROW-1 CLOSED -->
    </div>

    <!-- View MODAL -->
<div class="modal fade" id="viewDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
			
            </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				
			</div>
		</div>
	</div>
</div>
<!-- View CLOSED -->
    <!-- Status Update MODAL -->
<div class="modal fade" id="statusDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Status Update</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form  id="submitForm" action="{{route('update-loan-status')}}">
			<div class="modal-body">
			
            </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				 <button type="submit" id="submitButton" class="btn btn-primary float-right"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> Sending..." data-rest-text="Submit">Submit</button>
				
			</div>
			</form>
		</div>
	</div>
</div>
<!-- Status Update CLOSED -->

    <!-- Status Update MODAL -->
<div class="modal fade" id="assignDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Assign Form</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form  id="submitForm2" action="{{route('update-loan-assign')}}">
			<div class="modal-body">
			
            </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				 <button type="submit" id="submitButton2" class="btn btn-primary float-right"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> Sending..." data-rest-text="Submit">Submit</button>
				
			</div>
			</form>
		</div>
	</div>
</div>
<!-- Status Update CLOSED -->


</div>
@stop
@section('inlinejs')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
        
    <script type="text/javascript">
        $(function () {
            $.fn.dataTable.ext.errMode = 'none';
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('loan-list') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'id', name: 'id'},
                    {data: 'borrower_detail.name', name: 'borrower_detail.name'},
                    {data: 'borrower_detail.mobile_no', name: 'borrower_detail.mobile_no'},
                    {data: 'loan_status_detail.title', name: 'loan_status_detail.title'},
                    {data: 'assign_detail.name', name: 'assign_detail.name'},
                    {data: 'loan_type_detail.title', name: 'loan_type_detail.title', orderable: false, searchable: false},                    
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            $(document).on('click','.viewDetail', function(){
                $('#viewDetail').modal('show');
                url = $(this).attr('data-url');
                $('#viewDetail').find('.modal-body').html('<p class="ploading"><i class="fa fa-spinner fa-spin"></i></p>')
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data){
                        $('#viewDetail').find('.modal-body').html(data);
                    }
                });
            });
			
			$(document).on('click','.statusDetail', function(){
                $('#statusDetail').modal('show');
                url = $(this).attr('data-url');
                $('#statusDetail').find('.modal-body').html('<p class="ploading"><i class="fa fa-spinner fa-spin"></i></p>')
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data){
                        $('#statusDetail').find('.modal-body').html(data);
                    }
                });
            });
			
			$(document).on('click','.assignDetail', function(){
                $('#assignDetail').modal('show');
                url = $(this).attr('data-url');
                $('#assignDetail').find('.modal-body').html('<p class="ploading"><i class="fa fa-spinner fa-spin"></i></p>')
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data){
                        $('#assignDetail').find('.modal-body').html(data);
                    }
                });
            });
			
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
                        successMsg('Update Loan Status', data.msg, btn);
						$('#statusDetail').modal('hide');
						table.ajax.reload(); 
                        

                    }else{
                        $.each(data.errors, function(fieldName, field){
                            $.each(field, function(index, msg){
                                $('#'+fieldName).addClass('is-invalid state-invalid');
                               errorDiv = $('#'+fieldName).parent('div');
                               errorDiv.append('<div class="invalid-feedback">'+msg+'</div>');
                            });
                        });
                        errorMsg('Update Loan Status','Input error');
                    }
                    buttonLoading('reset', $this);
                    
                },
                error: function() {
                    errorMsg('Update Loan Status', 'There has been an error, please alert us immediately');
                    buttonLoading('reset', $this);
                }

            });

            return false;
           });
		   
		   
		   $('#submitForm2').submit(function(){
            var $this = $('#submitButton2');
            buttonLoading('loading', $this);
            $('.is-invalid').removeClass('is-invalid state-invalid');
            $('.invalid-feedback').remove();
            $.ajax({
                url: $('#submitForm2').attr('action'),
                type: "POST",
                processData: false,  // Important!
                contentType: false,
                cache: false,
                data: new FormData($('#submitForm2')[0]),
                success: function(data) {
                    if(data.status){
						var btn = '<a href="{{route('loan-type-list')}}" class="btn btn-info btn-sm">GoTo List</a>';
                        successMsg('Assign Loan', data.msg, btn);
						$('#assignDetail').modal('hide');
						table.ajax.reload(); 
                        

                    }else{
                        $.each(data.errors, function(fieldName, field){
                            $.each(field, function(index, msg){
                                $('#'+fieldName).addClass('is-invalid state-invalid');
                               errorDiv = $('#'+fieldName).parent('div');
                               errorDiv.append('<div class="invalid-feedback">'+msg+'</div>');
                            });
                        });
                        errorMsg('Assign Loan','Input error');
                    }
                    buttonLoading('reset', $this);
                    
                },
                error: function() {
                    errorMsg('Assign Loan', 'There has been an error, please alert us immediately');
                    buttonLoading('reset', $this);
                }

            });

            return false;
           });
		   
		   
			
			$('#loan_type').change(function(){
				loan_type_id = $(this).val();
				url = "{{ route('loan-create', '') }}/"+loan_type_id;
				$('.create-link').attr('href', url);
			});
			
			$(document).on('change', '#loans_status', function(){
				
				parent_id = $(this).val();
				$('#loans_sub_status').html('<option value="0">Loading......</option>');
				$.ajax({
                    url: '{{route('loan-sub-status', '')}}'+'/'+parent_id,
                    type: 'GET',
                    success: function(data){
                        $('#loans_sub_status').html('<option value="">Select Sub Status</option>');
						$.each(data.data, function(key, status){
							$('#loans_sub_status').append('<option value="'+status.id+'">'+status.title+'</option>');
						})
                    }
                });
				
				
			});
            
        });
    </script>
@stop
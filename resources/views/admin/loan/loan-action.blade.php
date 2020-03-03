@extends('admin/layouts/default')
@section('title')
<title>Action on  Loan</title>
@stop

@section('inlinecss')
<link type="text/css" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/ui-lightness/jquery-ui.css" />
<link href="{{ asset('admin/assets/multiselectbox/css/ui.multiselect.css') }}" rel="stylesheet">
@stop

@section('breadcrum')
<h1 class="page-title">Action on Loan</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Loan</a></li>
    <li class="breadcrumb-item active" aria-current="page">Action</li>
</ol>
@stop

@section('content')
<div class="app-content">
    <div class="side-app">

        <!-- PAGE-HEADER -->
        @include('admin.layouts.pagehead')
        <!-- PAGE-HEADER END -->

        <!--  Start Content -->
    <div class="row">
        <!-- COL END -->
							<div class="col-lg-6">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Borrower Detail</h3>
									</div>
								<div class="card-body">
									
									<div class="form-group">
										<label class="form-label"> Name: {{$loan->borrower_detail->name}}</label>								
									</div>
									<div class="form-group">
										<label class="form-label"> Father Name: {{$loan->borrower_detail->father_name}}</label>								
									</div>
									<div class="form-group">
										<label class="form-label"> Mobile: {{$loan->borrower_detail->mobile_no}}</label>								
									</div>
									<div class="form-group">
										<label class="form-label"> Email: {{$loan->borrower_detail->email}}</label>								
									</div>
									
									<div class="form-group">
										<label class="form-label"> DOB: {{$loan->borrower_detail->dob}}</label>								
									</div>
									<div class="form-group">
										<label class="form-label"> Gender: {{$loan->borrower_detail->gender}}</label>								
									</div>
									<div class="form-group">
										<label class="form-label"> Address: {{$loan->borrower_detail->address}}</label>								
									</div>
									
									<div class="form-group">
										<label class="form-label"> PinCode: {{$loan->borrower_detail->pin_code}}</label>								
									</div>
									<div class="form-group">
										<label class="form-label"> Aadhar No.: {{$loan->borrower_detail->aadhar_number}}</label>								
									</div>
									
									<div class="form-group">
										<label class="form-label"> PAN No.: {{$loan->borrower_detail->pan_number}}</label>								
									</div>
                                    
                                        
									</div>
                                    
								</div>
							</div>	
						<div class="col-lg-6">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Loan Detail</h3>
									</div>
									<div class="card-body">
									
									<div class="form-group">
										<label class="form-label"> Loan Type: {{$loan->loan_type_detail->title}}</label>								
									</div>
									
									<div class="form-group">
										<label class="form-label"> Loan Amount: 5000000</label>								
									</div>
									
									@foreach($fields as $field)
									<div class="form-group">
										<label class="form-label"> {{$field->title}}: </label>								
									</div>
									
									@endforeach
									
                                    
										</div>
                                        
									</div>
                                    
								</div>
						

						<div class="col-lg-6">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">KYC & Uploaded Documents</h3>
							</div>
							<div class="card-body">
							
							<div class="form-group">
								<label class="form-label"> Aadhar: Download</label>								
							</div>
							
							<div class="form-group">
								<label class="form-label"> PAN: Download</label>								
							</div>
							
							
								</div>
								
							</div>
							
						</div>
						
						<div class="col-lg-6">
						
							<form id="submitForm" class="row"  method="post" action="{{route('loan-add-bank', $loan->id)}}">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">Apply to Bank</h3>
							</div>
							<div class="card-body">
							{{csrf_field()}}
							
							<div class="form-group">
								<label class="form-label"> Bank List *</label>											
								<select class="form-control select2" name="bank" id="bank" required>
									<option value=""> Select Bank </option>
									@foreach($banks as $bank)
									<option value="{{$bank->id}}">{{$bank->title}}</option>
									@endforeach
								</select>
							</div>
							
							<div class="card-footer"></div>
									 <button type="submit" id="submitButton" class="btn btn-primary float-right"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> Sending..." data-rest-text="Add">Add</button>
								

								</div>
							 	
								
							</div>
						</form>
							
						</div>
						
						
						<div class="col-lg-12">
						
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">Apply Bank List</h3>
							</div>
							<div class="card-body">
							
							<table class="table table-bordered data-table w-100">
								  <thead>
									  <tr>
										  <th>No</th>
										  <th>Bank</th>
										  <th>Status</th>
										  <th>Sub Status</th>
										  <th>Assign TO</th>
										  <th width="100px">Action</th>
									  </tr>
								  </thead>
								  <tbody>
								  </tbody>
							  </table>

							</div>
							 	
								
							</div>
						
							
						</div>
												
							
			<!-- COL END -->
			</div>
        <!--  End Content -->

    </div>
</div>

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
			<form  id="submitForm2" action="{{route('update-loan-status')}}">
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
			<form  id="submitForm3" action="{{route('update-loan-bank-assign')}}">
			<div class="modal-body">
			
            </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				 <button type="submit" id="submitButton3" class="btn btn-primary float-right"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> Sending..." data-rest-text="Submit">Submit</button>
				
			</div>
			</form>
		</div>
	</div>
</div>
<!-- Status Update CLOSED -->

@stop
@section('inlinejs')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
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
                        successMsg('Bank Add', data.msg);
						table.ajax.reload(); 

                    }else{
                        $.each(data.errors, function(fieldName, field){
                            $.each(field, function(index, msg){
                                $('#'+fieldName).addClass('is-invalid state-invalid');
                               errorDiv = $('#'+fieldName).parent('div');
                               errorDiv.append('<div class="invalid-feedback">'+msg+'</div>');
                            });
                        });
                        errorMsg('Bank Add','Input error');
                    }
                    buttonLoading('reset', $this);
                    
                },
                error: function() {
                    errorMsg('Bank Add', 'There has been an error, please alert us immediately');
                    buttonLoading('reset', $this);
                }

            });

            return false;
           });

           $.fn.dataTable.ext.errMode = 'none';
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('loan-bank-list', $loan->id) }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'bank_detail.title', name: 'bank_detail.title'},                   
                    {data: 'loan_bank_status_detail.loan_status_detail.title', name: 'bank_detail.title'},                   
                    {data: 'loan_bank_status_detail.loan_sub_status_detail.title', name: 'bank_detail.title'},                   
                    {data: 'bank_assign_to.name', name: 'bank_assign_to.name'},                   
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
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
                        successMsg('Update Loan Status', data.msg);
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
		   
		   
		   $(document).on('change', '#loan_status', function(){
				
				parent_id = $(this).val();
				$('#loan_sub_status').html('<option value="0">Loading......</option>');
				$.ajax({
                    url: '{{route('loan-sub-status', '')}}'+'/'+parent_id,
                    type: 'GET',
                    success: function(data){
                        $('#loan_sub_status').html('<option value="">Select Sub Status</option>');
						$.each(data.data, function(key, status){
							$('#loan_sub_status').append('<option value="'+status.id+'">'+status.title+'</option>');
						})
                    }
                });
				
				
			});
		   
		$('#submitForm3').submit(function(){
            var $this = $('#submitButton3');
            buttonLoading('loading', $this);
            $('.is-invalid').removeClass('is-invalid state-invalid');
            $('.invalid-feedback').remove();
            $.ajax({
                url: $('#submitForm3').attr('action'),
                type: "POST",
                processData: false,  // Important!
                contentType: false,
                cache: false,
                data: new FormData($('#submitForm3')[0]),
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
		   
		   

	    });
            
       
    </script>
@stop	
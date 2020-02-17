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
                        
                    <table class="table table-bordered data-table">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Title</th>
                              <th>Status</th>
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
            
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('loan-list') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'title', name: 'title'},
                    {data: 'status', name: 'status', orderable: false, searchable: false},                    
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
			
			$('#loan_type').change(function(){
				loan_type_id = $(this).val();
				url = "{{ route('loan-create', '') }}/"+loan_type_id;
				$('.create-link').attr('href', url);
			});
            
        });
    </script>
@stop
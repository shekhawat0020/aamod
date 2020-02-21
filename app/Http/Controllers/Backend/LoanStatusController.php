<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\LoanStatus;
use App\LoanField;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use DataTables;
use Validator;
use Auth;

class LoanStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = LoanStatus::with('parent_detail')->latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn =' ';
                        if(Auth()->user()->can('Loan Status Edit')){
                            $btn .= '<a href="'.route("loan-status-edit", $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>';
                        }

                        if(Auth()->user()->can('Loan Status View')){
                        $btn .= ' <button type="button" data-url="'.route('loan-status-view', $row->id).'" class="edit btn btn-primary btn-sm viewDetail">View</a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('admin.loan-status.loan-status');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$loan_status = LoanStatus::get();
        return view('admin.loan-status.loan-status-create',compact('loan_status'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:loan_status,title',
            'parent_id' => '',
            'sort_order' => ''
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
		
		
        
        $loan = new LoanStatus();
        $loan->title = $request->title;
        $loan->parent_id = $request->parent_id;
        $loan->sort_order = $request->sort_order;
        $loan->save();


        return response()->json([
            'status' => true,
            'msg' => 'Loan Status created successfully'
			]);

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $loan = LoanStatus::with('parent_detail')->find($id);
        return view('admin.loan-status.loan-status-show',compact('loan'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $loan = LoanStatus::find($id);
		
        $loan_status = LoanStatus::get();		
        return view('admin.loan-status.loan-status-edit',compact('loan', 'loan_status'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:loan_status,title,'.$id,
            'parent_id' => '',
            'sort_order' => ''
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
		
        
        $loan = LoanStatus::find($id);
        $loan->title = $request->title;
        $loan->parent_id = $request->parent_id;
        $loan->sort_order = $request->sort_order;
        $loan->save();

        

        return response()->json([
            'status' => true,
            'msg' => 'Loan Status updated successfully'
			]);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        LoanStatus::find($id)->delete();
    }


    
}
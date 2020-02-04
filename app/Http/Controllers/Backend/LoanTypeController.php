<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\LoanType;
use App\LoanField;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use DataTables;
use Validator;
use Auth;

class LoanTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = LoanType::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn =' ';
                        if(Auth()->user()->can('Loan Type Edit')){
                            $btn .= '<a href="'.route("loan-type-edit", $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>';
                        }

                        if(Auth()->user()->can('Loan Type View')){
                        $btn .= ' <button type="button" data-url="'.route('loan-type-view', $row->id).'" class="edit btn btn-primary btn-sm viewDetail">View</a>';
                        }
                        return $btn;
                    })
                     ->addColumn('status',  function ($user) {
                        return ($user->status)?'Active':'InActive';
                     })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('admin.loan-type.loan-type');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$fields = LoanField::where('status', 1)->get();
        return view('admin.loan-type.loan-type-create',compact('fields'));
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
            'title' => 'required|unique:loantype,title',
            'loan_fields' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
        
        $loan = new LoanType();
        $loan->title = $request->title;
        $loan->loan_fields = json_encode($request->loan_fields);
        $loan->status = $request->status;
        $loan->save();


        return response()->json([
            'status' => true,
            'msg' => 'Loan Type created successfully'
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
        $loan = LoanType::find($id);
        return view('admin.loan-type.loan-type-show',compact('loan'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $loan = LoanType::find($id);
		$fieldId = implode(',',json_decode($loan->loan_fields));
		
        $fields = LoanField::where('status', 1)->orderByRaw("FIELD(id, $fieldId)")->get();		
        return view('admin.loan-type.loan-type-edit',compact('loan', 'fields'));
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
            'title' => 'required|unique:loantype,title,'.$id,
            'loan_fields' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
        
        $loan = LoanType::find($id);
        $loan->title = $request->title;
        $loan->loan_fields = json_encode($request->loan_fields);
        $loan->status = $request->status;
        $loan->save();

        

        return response()->json([
            'status' => true,
            'msg' => 'Loan Type updated successfully'
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
        LoanType::find($id)->delete();
    }


    
}
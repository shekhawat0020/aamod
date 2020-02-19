<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\LoanType;
use App\Loan;
use App\LoanField;
use App\Borrower;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use DataTables;
use Validator;
use Auth;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Loan::with('borrower_detail')->with('loan_type_detail')->latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn =' ';
                        if(Auth()->user()->can('Loan Edit')){
                            $btn .= '<a href="'.route("loan-edit", $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>';
                        }

                        if(Auth()->user()->can('Loan View')){
                        $btn .= ' <button type="button" data-url="'.route('loan-view', $row->id).'" class="edit btn btn-primary btn-sm viewDetail">View</a>';
                        }
                        return $btn;
                    })
                     ->addColumn('status',  function ($user) {
                        return ($user->status)?'Active':'InActive';
                     })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      $loanTypes = LoanType::where('status', 1)->get();
        return view('admin.loan.loan',compact('loanTypes'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($loan_type_id)
    {
		$loanType = LoanType::where('id', $loan_type_id)->first();
		$loanfields = json_decode($loanType->loan_fields);
		$fields = LoanField::whereIn('id', $loanfields)->get();
		$fields = $fields->sortBy(function ($model) use ($loanfields) {
			return array_search($model->id, $loanfields);
		});
		$borrowers = Borrower::where('status', 1)->get();
        return view('admin.loan.loan-create',compact('loanType','fields', 'borrowers', 'loan_type_id'));
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
            'borrower' => 'required|exists:borrower,id',
			'loan_type' => 'required|exists:loantype,id'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
		
		
        
        $loan = new Loan();
        $loan->borrower_id = $request->borrower;
        $loan->loan_type_id = $request->loan_type;
        $loan->save();


        return response()->json([
            'status' => true,
            'msg' => 'Loan created successfully'
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
        $loan = Loan::find($id);
        return view('admin.loan.loan-show',compact('loan'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $loan = Loan::find($id);
		$fieldId = implode(',',json_decode($loan->loan_fields));
		
        $fields = Loan::where('status', 1)->orderByRaw("FIELD(id, $fieldId)")->get();		
        return view('admin.loan.loan-edit',compact('loan', 'fields'));
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
            'description' => 'required',
            'icon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
		
		
        
        $loan = Loan::find($id);
        $loan->title = $request->title;
        $loan->loan_fields = json_encode($request->loan_fields);
        $loan->status = $request->status;
        $loan->description = $request->description;
		if($imageName){
        $loan->icon = $imageName;
		}
        $loan->save();

        

        return response()->json([
            'status' => true,
            'msg' => 'Loan updated successfully'
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
        Loan::find($id)->delete();
    }


    
}
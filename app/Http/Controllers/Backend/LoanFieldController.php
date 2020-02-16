<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\LoanField;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use DataTables;
use Validator;
use Auth;

class LoanFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = LoanField::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn =' ';
                        if(Auth()->user()->can('Loan Field Edit')){
                            $btn .= '<a href="'.route("loan-field-edit", $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>';
                        }

                        if(Auth()->user()->can('Loan Field View')){
                        $btn .= ' <button type="button" data-url="'.route('loan-field-view', $row->id).'" class="edit btn btn-primary btn-sm viewDetail">View</a>';
                        }
                        return $btn;
                    })
                     ->addColumn('status',  function ($user) {
                        return ($user->status)?'Active':'InActive';
                     })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('admin.loan-field.loan-field');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$fields = LoanField::where('status', 1)->get();
        return view('admin.loan-field.loan-field-create',compact('fields'));
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
            'title' => 'required|unique:loan_field,title',
            'field_required' => 'required',
            'field_type' => 'required',
            'conditional_type' => '',
            'condition_field' => 'nullable|exists:loan_field,title',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
        
        $document = new LoanField();
        $document->title = $request->title;
        $document->field_required = $request->field_required;
        $document->field_type = $request->field_type;
        $document->options_value = json_encode($request->options_value);
        $document->condition_field = $request->condition_field;
        $document->condition_value = $request->condition_value;
        $document->conditional_type = $request->conditional_type;
        $document->status = $request->status;
        $document->save();


        return response()->json([
            'status' => true,
            'msg' => 'Loan Field created successfully'
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
        $document = LoanField::find($id);
        return view('admin.loan-field.loan-field-show',compact('document'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $document = LoanField::find($id);
        $fields = LoanField::where('status', 1)->get();
        return view('admin.loan-field.loan-field-edit',compact('document', 'fields'));
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
            'title' => 'required|unique:loan_field,title,'.$id,
            'field_required' => 'required',
            'field_type' => 'required',
            'conditional_type' => '',
            'condition_field' => 'nullable|exists:loan_field,title',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
        
        $document = LoanField::find($id);
        $document->title = $request->title;
        $document->field_required = $request->field_required;
        $document->field_type = $request->field_type;
        $document->options_value = json_encode($request->options_value);
        $document->condition_field = $request->condition_field;
        $document->condition_value = $request->condition_value;
        $document->conditional_type = $request->conditional_type;
        $document->status = $request->status;
        $document->save();

        

        return response()->json([
            'status' => true,
            'msg' => 'Loan Field updated successfully'
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
        LoanField::find($id)->delete();
    }


    
}
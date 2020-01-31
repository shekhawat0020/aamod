<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Borrower;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use DataTables;
use Validator;
use Auth;

class BorrowerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Borrower::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn =' ';
                        if(Auth()->user()->can('Borrower Edit')){
                            $btn .= '<a href="'.route("borrower-edit", $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>';
                        }

                        if(Auth()->user()->can('Borrower View')){
                        $btn .= ' <button type="button" data-url="'.route('borrower-view', $row->id).'" class="edit btn btn-primary btn-sm viewDetail">View</a>';
                        }
                        return $btn;
                    })
                     ->addColumn('status',  function ($user) {
                        return ($user->status)?'Active':'InActive';
                     })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('admin.borrower.borrower');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.borrower.borrower-create',compact(''));
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
            'name' => 'required|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|email|unique:borrower,email',
            'mobile_no' => 'required|min:10|unique:borrower,mobile_no',
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'required',
            'pin_code' => 'sometimes|nullable|numeric|min:6',
            'address' => '',
            'father_name' => 'sometimes|nullable|regex:/^[\pL\s\-]+$/u',
            'dob' => 'sometimes|nullable|date_format:Y-m-d',
            'gender' => 'sometimes|nullable|in:Other,Male,Female',
            'aadhar_number' => 'sometimes|nullable|numeric|min:12',
            'pan_number' => '',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
        $imageName = "";
        if($request->hasFile('profile_image')){
        $imageName = time().'.'.$request->profile_image->extension();   
        $request->profile_image->move(public_path('uploads/profile'), $imageName);
        $imageName = "uploads/profile/".$imageName;
        }
        
        $borrower = new Borrower();
        $borrower->name = $request->name;
        $borrower->email = $request->email;
        $borrower->mobile_no = $request->mobile_no;
        if($imageName != ""){
        $borrower->profile_image = $imageName;
        }
        $borrower->pin_code = $request->pin_code;
        $borrower->address = $request->address;
        $borrower->father_name = $request->father_name;
        $borrower->dob = $request->dob;
        $borrower->gender = $request->gender;
        $borrower->aadhar_number = $request->aadhar_number;
        $borrower->pan_number = $request->pan_number;
        $borrower->status = $request->status;
        $borrower->password = Hash::make($request->password);
        $borrower->save();


        return response()->json([
            'status' => true,
            'msg' => 'Borrower created successfully'
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
        $borrower = Borrower::find($id);
        return view('admin.borrower.borrower-show',compact('borrower'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $borrower = Borrower::find($id);
        
        return view('admin.borrower.borrower-edit',compact('borrower'));
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
            'name' => 'required|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|email|unique:borrower,email,'.$id,
            'mobile_no' => 'required|min:10|unique:borrower,mobile_no,'.$id,
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'pin_code' => 'numeric|min:6',
            'address' => '',
            'father_name' => 'regex:/^[\pL\s\-]+$/u',
            'dob' => 'required|date_format:Y-m-d',
            'gender' => 'in:Other,Male,Female',
            'aadhar_number' => 'numeric|min:12',
            'pan_number' => '',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
        
        $imageName = "";
        if($request->hasFile('profile_image')){
        $imageName = time().'.'.$request->profile_image->extension();   
        $request->profile_image->move(public_path('uploads/profile'), $imageName);
        $imageName = "uploads/profile/".$imageName;
        }
        $borrower = Borrower::find($id);
        $borrower->name = $request->name;
        $borrower->email = $request->email;
        $borrower->mobile_no = $request->mobile_no;
        if($imageName != ""){
        $borrower->profile_image = $imageName;
        }
        $borrower->pin_code = $request->pin_code;
        $borrower->address = $request->address;
        $borrower->father_name = $request->father_name;
        $borrower->dob = $request->dob;
        $borrower->gender = $request->gender;
        $borrower->aadhar_number = $request->aadhar_number;
        $borrower->pan_number = $request->pan_number;
        $borrower->status = $request->status;
        $borrower->save();

        

        return response()->json([
            'status' => true,
            'msg' => 'Borrower updated successfully'
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
        Borrower::find($id)->delete();
    }


    
}
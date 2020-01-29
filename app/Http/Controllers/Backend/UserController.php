<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use DataTables;
use Validator;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = User::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn =' ';
                        if(Auth()->user()->can('User Edit')){
                            $btn .= '<a href="'.route("user-edit", $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>';
                        }

                        if(Auth()->user()->can('User View')){
                        $btn .= ' <button type="button" data-url="'.route('user-view', $row->id).'" class="edit btn btn-primary btn-sm viewDetail">View</a>';
                        }
                        return $btn;
                    })
                     ->addColumn('role',  function ($user) {
                        return $user->getRoleNames();
                     })
                     ->addColumn('status',  function ($user) {
                        return ($user->status)?'Active':'InActive';
                     })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('admin.users.users');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::select('id','name')->get();
        return view('admin.users.users-create',compact('roles'));
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
            'email' => 'required|email|unique:users,email',
            'mobile_no' => 'required|min:10|unique:users,mobile_no',
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'required',
            'roles' => 'required',
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
        
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile_no = $request->mobile_no;
        if($imageName != ""){
        $user->profile_image = $imageName;
        }
        $user->status = $request->status;
        $user->password = Hash::make($request->password);
        $user->save();

        $user->assignRole($request->roles);

        return response()->json([
            'status' => true,
            'msg' => 'User created successfully'
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
        $user = User::find($id);
        return view('admin.users.users-show',compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::select('id','name')->get();
        $userRole = $user->roles->pluck('id','name')->all();
        
        return view('admin.users.users-edit',compact('user','roles', 'userRole'));
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
            'email' => 'required|email|unique:users,email,'.$id,
            'mobile_no' => 'required|min:10|unique:users,mobile_no,'.$id,
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'roles' => 'required',
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
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile_no = $request->mobile_no;
        if($imageName != ""){
        $user->profile_image = $imageName;
        }
        $user->status = $request->status;
        $user->save();

        if($user->id != 1){
            DB::table('model_has_roles')->where('model_id',$id)->delete();
            $user->assignRole($request->roles);
        }

        return response()->json([
            'status' => true,
            'msg' => 'User updated successfully'
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
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }


    
}
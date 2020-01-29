<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use App\Category;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use DataTables;
use Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Post::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        
                        $btn = '<a href="'.route("post-edit", $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>
                        <button type="button" data-url="'.route('post-view', $row->id).'" class="edit btn btn-primary btn-sm viewDetail">View</button>
						<button type="button" id="deleteButton" data-url="'.route('post-delete', $row->id).'" class="edit btn btn-primary btn-sm deleteButton" data-loading-text="Deleted...." data-rest-text="Delete">Delete</button>';
                                           
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('admin.post.post');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		
		$category = Category::get();
        return view('admin.post.post-create',compact('category'));
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
            'title' => 'required|unique:posts,title',
            'description' => 'required',
            'category' => 'required',
            'fill_last_date' => 'required',
            'general_fees' => 'required|numeric',
            'obc_fees' => 'required|numeric',
            'scst_fees' => 'required|numeric',
            'st_fees' => 'required|numeric',
            'token_fees' => 'required|numeric'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
		}

        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->category = $request->category;
        $post->fill_last_date = $request->fill_last_date;
        $post->general_fees = $request->general_fees;
        $post->obc_fees = $request->obc_fees;
        $post->scst_fees = $request->scst_fees;
        $post->st_fees = $request->st_fees;
        $post->token_fees = $request->token_fees;
        $post->status = $request->status;
        $post->save();


        return response()->json([
            'status' => true,
            'msg' => 'Post created successfully'
			]);

    }



  


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
		$category = Category::get();
        return view('admin.post.post-edit',compact('post','category'));
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
            'title' => 'required|unique:posts,title,'.$id,
            'description' => 'required',
            'category' => 'required',
            'fill_last_date' => 'required',
            'general_fees' => 'required|numeric',
            'obc_fees' => 'required|numeric',
            'scst_fees' => 'required|numeric',
            'st_fees' => 'required|numeric',
            'token_fees' => 'required|numeric'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
		}

        $post = Post::find($id);
        $post->title = $request->title;
        $post->description = $request->description;
        $post->category = $request->category;
        $post->fill_last_date = $request->fill_last_date;
        $post->general_fees = $request->general_fees;
        $post->obc_fees = $request->obc_fees;
        $post->scst_fees = $request->scst_fees;
        $post->st_fees = $request->st_fees;
        $post->token_fees = $request->token_fees;
        $post->status = $request->status;
        $post->save();


        return response()->json([
            'status' => true,
            'msg' => 'Post updated successfully'
			]);

    }

    public function show($id)
    {
        $post = Post::find($id);
        return view('admin.post.post-show',compact('post'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::find($id)->delete();
        return response()->json([
            'status' => true,
            'msg' => 'Post deleted successfully'
			]);
    }
}
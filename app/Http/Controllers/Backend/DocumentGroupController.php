<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DocumentGroup;
use App\DocumentField;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use DataTables;
use Validator;
use Auth;

class DocumentGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = DocumentGroup::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn =' ';
                        if(Auth()->user()->can('Document Group Edit')){
                            $btn .= '<a href="'.route("document-group-edit", $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>';
                        }

                        if(Auth()->user()->can('Document Group View')){
                        $btn .= ' <button type="button" data-url="'.route('document-group-view', $row->id).'" class="edit btn btn-primary btn-sm viewDetail">View</a>';
                        }
                        return $btn;
                    })
                     ->addColumn('status',  function ($user) {
                        return ($user->status)?'Active':'InActive';
                     })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('admin.document-group.document-group');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		
        $fields = DocumentField::where('status', 1)->get();
        return view('admin.document-group.document-group-create',compact('fields'));
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
            'title' => 'required|unique:document_group,title',
            'document_fields' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
        
        $document = new DocumentGroup();
        $document->title = $request->title;
        $document->document_fields = json_encode($request->document_fields);
        $document->status = $request->status;
        $document->save();


        return response()->json([
            'status' => true,
            'msg' => 'Document Group created successfully'
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
        $document = DocumentGroup::find($id);
		
        $fields = DocumentField::where('status', 1)->whereIn('id', json_decode($document->document_fields))->get();
        return view('admin.document-group.document-group-show',compact('document', 'fields'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $document = DocumentGroup::find($id);
        $fields = DocumentField::where('status', 1)->get();
        return view('admin.document-group.document-group-edit',compact('document', 'fields'));
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
            'title' => 'required|unique:document_group,title,'.$id,
            'document_fields' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
        
        $document = DocumentGroup::find($id);
        $document->title = $request->title;
        $document->document_fields = json_encode($request->document_fields);
        $document->status = $request->status;
        $document->save();

        

        return response()->json([
            'status' => true,
            'msg' => 'Document Group updated successfully'
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
        DocumentGroup::find($id)->delete();
    }


    
}
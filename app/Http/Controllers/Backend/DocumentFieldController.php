<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DocumentField;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use DataTables;
use Validator;
use Auth;

class DocumentFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = DocumentField::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn =' ';
                        if(Auth()->user()->can('Document Field Edit')){
                            $btn .= '<a href="'.route("document-field-edit", $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>';
                        }

                        if(Auth()->user()->can('Document Field View')){
                        $btn .= ' <button type="button" data-url="'.route('document-field-view', $row->id).'" class="edit btn btn-primary btn-sm viewDetail">View</a>';
                        }
                        return $btn;
                    })
                     ->addColumn('status',  function ($user) {
                        return ($user->status)?'Active':'InActive';
                     })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('admin.document-field.document-field');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.document-field.document-field-create',compact(''));
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
            'title' => 'required|unique:document_field,title',
            'field_required' => 'required',
            'no_of_document' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
        
        $document = new DocumentField();
        $document->title = $request->title;
        $document->field_required = $request->field_required;
        $document->no_of_document = $request->no_of_document;
        $document->status = $request->status;
        $document->save();


        return response()->json([
            'status' => true,
            'msg' => 'Document Field created successfully'
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
        $document = DocumentField::find($id);
        return view('admin.document-field.document-field-show',compact('document'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $document = DocumentField::find($id);
        
        return view('admin.document-field.document-field-edit',compact('document'));
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
            'title' => 'required|unique:document_field,title,'.$id,
            'field_required' => 'required',
            'no_of_document' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
        
        $document = DocumentField::find($id);
        $document->title = $request->title;
        $document->field_required = $request->field_required;
        $document->no_of_document = $request->no_of_document;
        $document->status = $request->status;
        $document->save();

        

        return response()->json([
            'status' => true,
            'msg' => 'Document Field updated successfully'
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
        DocumentField::find($id)->delete();
    }


    
}
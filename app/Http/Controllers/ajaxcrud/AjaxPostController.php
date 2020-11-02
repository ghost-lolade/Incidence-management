<?php

namespace App\Http\Controllers\ajaxcrud;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CallLog;
use Redirect,Response;

class AjaxPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['posts'] = CallLog::where('vendor_request_status', '=', 'Closed' )->Where('request_status', '=', 'Open')
    //    ->OrWhere('request_status', '=', 'Suspended' )
        ->orderBy('id','desc')->paginate(200);
   
        return view('ajaxcrud.index',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
		if ($request->request_status== 'Resolved')
		{
			
        $postID = $request->post_id;
        $post   =   CallLog::updateOrCreate(['id' => $postID],
                    ['remark' => $request->remark, 'request_status' => $request->request_status]);
					return Response::json($post);
		}
		else
		$postID = $request->post_id;
        $post   =   CallLog::updateOrCreate(['id' => $postID],
                    ['remark' => $request->remark, 'request_status' => $request->request_status, 'closed_at' => '0000-00-00 00:00:00']);
        return Response::json($post);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $where = array('id' => $id);
        $post  = CallLog::where($where)->first();
 
        return Response::json($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post = CallLog::where('id',$id)->delete();
   
        return Response::json($post);
    }
}
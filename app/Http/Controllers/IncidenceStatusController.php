<?php

namespace App\Http\Controllers;

use App\CustomerEngineer;
use App\Mail\CloseIncidenceMail;
use App\Mail\SuspendMail;
use App\User;
use App\Requester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Validator;
use Response;
use App\Brand;
//use App\Post;
use App\CallLog;
use View;
use Snowfire\Beautymail\Beautymail;

use Redirect;
use Session;

class IncidenceStatusController extends Controller
{
    /**
     * @var array
     */
    protected $rules =
        [
            'title' => 'required|min:2|max:32|regex:/^[a-z ,.\'-]+$/i',
            'content' => 'required|min:2|max:128|regex:/^[a-z ,.\'-]+$/i'
        ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		//return $mails = Requester::pluck('email')->toArray();

        $posts = CallLog::Where('vendor_request_status', '=', 'Open')->get();

        return view('incidence_status.index', ['posts' => $posts]);
    }

    public function vendorIndex()
    {
        //return $mails = Requester::pluck('email')->toArray();

        $posts = CallLog::Where('vendor_request_status', '=', 'Open')->get();

        return view('incidence_status.vendorindex', ['posts' => $posts]);
    }

//    public function index2()
//    {
//        $vendor_id=Auth::user()->user_no;
//        $posts = CallLog::Where('request_status', '=', 'Open')
//                ->get();
//
//
//        return view('incidence_status.index2', ['posts' => $posts]);
//    }
    public function index22(Request $request)
    {
           $countemail = User::pluck('email')->count();
       //    $email = User::pluck('email')->all()->toArray();;
        // return    $email[1];

        $cedata=CustomerEngineer::get();


        $email = Auth::user()->email;
        $vendor_id=Auth::user()->user_no;
        $posts = CallLog::Where('request_status', '=', 'Open')
            ->get();

        return view('incidence_status.index22', ['posts' => $posts, 'cedata' => $cedata]);
    }
    public function trackCall()
    {
        $vendor_id=Auth::user()->user_no;
        $cedata=CustomerEngineer::where('vendor_id', '=', $vendor_id)->get();

        $posts = CallLog::Where('request_status', '=', 'Open')
            ->get();

        return view('incidence_status.calltrack', ['posts' => $posts, 'cedata' => $cedata, ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $validator = Validator::make(Input::all(), $this->rules);
//        if ($validator->fails()) {
//            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
//        } else {
//            $post = new CallLog();
//            $post->title = $request->title;
//            $post->content = $request->content;
//            $post->save();
//            return response()->json($post);
//        }
    }


    public function sendMail(Request $request){
        $this->validate($request, [
            'email' => 'bail|required|email',
        ]);

        $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
        $beautymail->send('emails.welcome', [], function($message)
        {
            $email = Input::get('email');
            $message
                ->from('donotreply@justlaravel.com')
                ->to($email, 'Howdy buddy!')
                ->subject('Test Mail!');
        });
        Session::flash("message","Email sent successfully");
        return Redirect::back();
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);

        return view('post.show', ['post' => $post]);
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
//        $validator = Validator::make(Input::all(), $this->rules);
//        if ($validator->fails()) {
//            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
//        } else {
        // SUSPEND BANK CALL TO BANK
         if($request->r_status =='Suspended'){
          //  $email = Auth::user()->email;
			$username = Auth::user()->username;
            $post = CallLog::findOrFail($id);
        $post->suspend_comment = $request->suspend_comment;
        $post->request_status = $request->r_status;
        $post->vendor_request_status = $request->r_status;
        $post->suspend_day = date('Y-m-d');
        $post->suspend_time = date('H:i:s');
		 $post->call_closer_username = $username;
        $post->save();
		
		$mails = Requester::pluck('email')->toArray();
        Mail::to($mails)
            ->cc(['oladejisteven@gmail.com','oladejisteven@gmail.com'])
            ->send(new SuspendMail());
        return response()->json($post);
        }

        // FALSE CALL BANK CALL TO BANK
         if($request->r_status =='FalseCall'){
          //  $email = Auth::user()->email;
			$username = Auth::user()->username;
            $post = CallLog::findOrFail($id);
        $post->suspend_comment = $request->suspend_comment;
        $post->request_status = $request->r_status;
        $post->suspend_day = date('Y-m-d');
        $post->suspend_time = date('H:i:s');
		 $post->call_closer_username = $username;
        $post->save();
		
		$mails = Requester::pluck('email')->toArray();
        Mail::to($mails)
            ->cc(['oladejisteven@gmail.com','oladejisteven@gmail.com'])
            ->send(new SuspendMail());
        return response()->json($post);
        }
		//DELETE CALL 
		  if($request->r_status =='Deleted'){
           // $email = Auth::user()->email;
			$username = Auth::user()->username;
            $post = CallLog::findOrFail($id);
        $post->suspend_comment = $request->suspend_comment;
        $post->request_status = $request->r_status;
        $post->suspend_day = date('Y-m-d');
        $post->suspend_time = date('H:i:s');
		 $post->call_closer_username = $username;
        $post->save();
		
	
        return response()->json($post);

        }
		
		
        // SUSPEND REASON FOR CE
        if($request->ce_suspend !=''){

          $email = Auth::user()->email;
            //   $email = User::pluck('email')->all();

            // SUSPEND FOR CE
            $post = CallLog::findOrFail($id);
            $post->ce_suspend_reason = $request->ce_suspend;
            $post->suspend_ce_day =  $request->day_suspend;
            $post->suspend_ce_time = $request->time_suspend;
//            $post->picture = $request->picture;
          //  $post->ce_suspend_reason = 'Suspended';
            $username = Auth::user()->username;
			 $post->call_closer_username = $username;
            $post->save();

			$mails = CustomerEngineer::pluck('email_address')->toArray();
        Mail::to($mails)
            ->cc(['oladejisteven@gmail.com'])
            ->send(new SuspendMail());
            return response()->json($post);
        }
        //ASSIGN CALL TO CE
        if($request->assign_ce !=''){
            $post = CallLog::findOrFail($id);
            $post->ce_name = $request->assign_ce;
            $post->ce_status = $request->ce_status;
            $post->ce_arrival_time = $request->ce_arrival_time;
            $post->save();
            return response()->json($post);
        }

 //ASSIGN Error Code

        if($request->errorcode !=''){
            $post = CallLog::findOrFail($id);
            $post->error_code = $request->errorcode;
            $post->save();
            return response()->json($post);
        }
       else
	   {
		  return Redirect::back();
	   }

    }

//    private function createQueryInput($keys, $request) {
//        $queryInput = [];
//        for($i = 0; $i < sizeof($keys); $i++) {
//            $key = $keys[$i];
//            $queryInput[$key] = $request[$key];
//        }
//
//        return $queryInput;
//    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //THIS IS USE TO ACCEPT STATUS FROM VENDOR
        $post = CallLog::findOrFail($id);

      // $suspend_reason=CallLog::Where('id', '=', $id)->pluck('ce_suspend_reason');
      //  return $open[0];
     //   if($request->reopenreason !='' && $suspend_reason[0]!=''){

        //REOPEN CALL TO CE

        if($request->reopenreason !=''){
        $post->reopen_reason =$request->reopenreason;
        $post->ce_reopen_day = date('Y-m-d');
        $post->ce_reopen_time = date('H:i:s');
        $post->save();
        return response()->json($post);
    }
   
   if($request->close_day !=''){

        //CLOSE CALL TO BANK
        $username = Auth::user()->username;

        $post->closure_comment = $request->closure_mail;
        $post->close_day =  $request->close_day;
        $post->close_time = $request->close_time;
     //   $post->closed_at = $request->date_closed;
        $post->call_closer_username = $username;
        $post->vendor_request_status ='Closed';
//        $post->closed_at = date('Y-m-d H:i:s');
        $post->closed_at = $request->close_day.' '.$request->close_time;
        $post->save();

		$mails = Requester::pluck('email')->toArray();
        Mail::to($mails)
            ->cc(['oladejisteve@gmail.com','lampsofter@gmail.com'])
            ->send(new CloseIncidenceMail());

        return response()->json($post);
        }
    }

    /**
     * Change resource status.
     *
     * @return \Illuminate\Http\Response
     */
    public function changeStatus()
    {
        $id = Input::get('id');

        $post = CallLog::findOrFail($id);
        $post->is_published = !$post->is_published;
        $post->save();

        return response()->json($post);
    }

}

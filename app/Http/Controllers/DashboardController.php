<?php

namespace App\Http\Controllers;

use App\BankData;
use App\CallLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        SELECT * from uba_call_log Where request_status='Open'"

       // return view('dashboard','no_ATM');

        $vendor_id=Auth::user()->usertype;
        if( $vendor_id==0){
            $no_ATM= BankData::count();
            $openCall= CallLog::Where('request_status', '=', 'Open')
		//	 ->OrWhere('error_code','=', '')
		//	 ->Where('error_code','NOT LIKE', '%RECEIPT%')
			 ->count();

            $latests = CallLog::Where('request_status', '=', 'Open')->OrderBy('mail_at', 'desc')->limit(10)->get();
//		  $latests = CallLog::Where('request_status', '=', 'Open')
//		  ->whereDate('log_day', Carbon::today())
//		  ->get();
		  
		  
		  // $atmreports= CallLog::all()->sortByDesc("created_at");
		  
		  
		// $latestlog=	CallLog::whereDate('created_at', Carbon::today())->get();
		
		 $dayAgo = 4;
		   $dayToCheck = Carbon::today()->subDays($dayAgo);
		   	$ageCall= CallLog::Where('request_status', '=', 'Open')->
			whereDate('mail_at', '<=', Carbon::today()->subDays($dayAgo))->count();
		   
        
		$closedCall= CallLog::Where('request_status', '=', 'Closed')->
			whereDate('closed_at', Carbon::today())->count();
			
		$suspendedCall= CallLog::Where('request_status', '=', 'Suspended')->
		count();	
		
			$awaitCall= CallLog::Where('vendor_request_status', '=', 'Closed')->Where('request_status', '=', 'Open')->count();
			
			
			
            return view('dashboard' , compact('no_ATM','openCall','closedCall','latests','ageCall','suspendedCall','awaitCall'));
			
//            $posts = PreventiveMaintanace::Where('quarter_first', '!=', '')->get();
//            return view('preventive.index', ['posts' => $posts]);
        }
        else
            $no_ATM = BankData::Where('vendor_id', '=', $vendor_id)->count();
        
           $openCall= CallLog::Where('request_status', '=', 'Open')
           ->Where('request_status', '=', 'Open')
			// ->OrWhere('error_code','=', '')
			// ->Where('error_code','NOT LIKE', '%RECEIPT%')
			 ->count();

        $dayAgo = 4;
		   $dayToCheck = Carbon::today()->subDays($dayAgo);
		   	$ageCall= CallLog::Where('vendor_id', '=', $vendor_id)->Where('request_status', '=', 'Open')->
			whereDate('mail_at', '<=', Carbon::today()->subDays($dayAgo))->count();
		 
        
//            $openCall= CallLog::Where('request_status', '=', 'Open')
		//	 ->Where('error_code','NOT LIKE', '%RECEIPT%')
  //              ->Where('vendor_id', '=', $vendor_id)->count();
          
            $closedCall= CallLog::Where('request_status', '=', 'Closed')
                ->Where('vendor_id', '=', $vendor_id)
                ->whereDate('closed_at', Carbon::today())->count();
				  $latests = CallLog::Where('vendor_request_status', '=', 'Open')->Where('vendor_id', '=', $vendor_id)->OrderBy('mail_at', 'desc')->limit(10)->get();
				  
			$suspendedCall= CallLog::Where('request_status', '=', 'Suspended')->count();
			
			$awaitCall= CallLog::Where('vendor_request_status', '=', 'Closed')->Where('request_status', '=', 'Open')->count();
			
        return view('dashboard' , compact('no_ATM','openCall','closedCall','latests','ageCall','suspendedCall','awaitCall'));









    }
}

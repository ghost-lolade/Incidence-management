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
			 ->OrWhere('error_code','=', '')
			 ->Where('error_code','NOT LIKE', '%RECEIPT%')
			 ->count();

            $latests = CallLog::Where('request_status', '=', 'Open')->limit(10)->get();
//		  $latests = CallLog::Where('request_status', '=', 'Open')
//		  ->whereDate('log_day', Carbon::today())
//		  ->get();
		  
		  
		  // $atmreports= CallLog::all()->sortByDesc("created_at");
		  
		  
		// $latestlog=	CallLog::whereDate('created_at', Carbon::today())->get();
        
		$closedCall= CallLog::Where('request_status', '=', 'Closed')->
			whereDate('closed_at', Carbon::today())->count();
			
            return view('dashboard' , compact('no_ATM','openCall','closedCall','latests'));
			
//            $posts = PreventiveMaintanace::Where('quarter_first', '!=', '')->get();
//            return view('preventive.index', ['posts' => $posts]);
        }
        else
            $no_ATM = BankData::Where('vendor_id', '=', $vendor_id)->count();
            $openCall= CallLog::Where('request_status', '=', 'Open')
			 ->Where('error_code','NOT LIKE', '%RECEIPT%')
                ->Where('vendor_id', '=', $vendor_id)->count();
            $closedCall= CallLog::Where('request_status', '=', 'Closed')
                ->Where('vendor_id', '=', $vendor_id)
                ->whereDate('closed_at', Carbon::today())->count();
				  $latests = CallLog::Where('vendor_request_status', '=', 'Open')
                      ->Where('vendor_id', '=', $vendor_id)
                          ->limit(10)->get();
        return view('dashboard' , compact('no_ATM','openCall','closedCall','latests'));









    }
}

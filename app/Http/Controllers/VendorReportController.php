<?php

namespace App\Http\Controllers;

use Redirect;
use App\BankData;
use App\CallLog;
use App\DailyTrend;
use App\City;
use App\Country;
use App\Department;
use App\Insurance;
use App\State;
use App\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\daily_trends;

class VendorReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $atmreports = CallLog::Where('request_status', '=', 'Open')->get();

        return view('vendorreport.index', compact('atmreports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        return $request->all();
        //
//        return $request->all();

//        CallLog::create($request->all());

//        if ($request['terminalid'][0] != '' || $request['terminalid'][0] != null) {
        $itrate = $request['terminalid'];
        $count1 = count($itrate);

        if ($count1 != '') {
            $drug = $request['terminalid'];
            $counter = count($drug);
            for ($i = 0; $i < $counter; ++$i) {
                $terminal_id= $request['terminalid'][$i];

                $searchvendor= BankData::where('terminal_id', '=', $terminal_id )->get();

                $vendor_name=  $searchvendor[0]->vendor_name;
                $vendor_id=  $searchvendor[0]->vendor_id;
                $state=  $searchvendor[0]->state;
                $region=  $searchvendor[0]->region;
                $atm_code=  $searchvendor[0]->atm_code;
                $timers=  $searchvendor[0]->timers;
                CallLog::create([
                    'terminal_id' => $request['terminalid'][$i],
                    'atm_name' => $request['atmname'][$i],
                    'custodian_phone' => $request['custodian_phone'][$i],
                    'error_code' => $request['errorcode'][$i],
                    'vendor_name' =>$vendor_name,
                    'vendor_id' =>$vendor_id,
                    'state' =>$state,
                    'region' =>$region,
                    'ticket_no' =>$atm_code,
//                        'timers' =>$timers,

                ]);
            }

//                $status_id = $request['status_id'];
//                $input = [
//                    'pharmacy' => 1,
//                ];
//                Status::where('id', "$status_id")
//                    ->update($input);
//            }
        }


        return redirect()->intended('atmreport-management');
    }





//Auto Complete Terminal ID with ATM NAME, CUSTOMDIAN NAME/NUMBER
    public function searchResponse(Request $request){
        $query = $request->get('term','');
        $bankdatas=\DB::table('bank_datas');
        if($request->type=='terminalid'){
            $bankdatas->where('terminal_id','LIKE','%'.$query.'%')->limit(10);
        }
        if($request->type=='atmname'){
            $bankdatas->where('atm_name','LIKE','%'.$query.'%');
        }
        if($request->type=='custodian_phone'){
            $bankdatas->where('custodian_phone','LIKE','%'.$query.'%');
        }
        $bankdatas=$bankdatas->get();
        $data=array();
        foreach ($bankdatas as $bankdata) {
            $data[]=array('terminal_id'=>$bankdata->terminal_id,'atm_name'=>$bankdata->atm_name,'custodian_phone'=>$bankdata->custodian_phone);
        }
        if(count($data))
            return $data;
        else
            return ['terminal_id'=>'','atm_name'=>'','custodian_phone'=>''];
    }





    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }


    public function searchreporter()
    {
   //  return    date('Y-m-d');
        $user = Auth::user()->id;

        $vendors = Vendor::all();

        $atmreports= CallLog::all()->sortByDesc("mail_at");
        return view('vendorreport.searchvaries', compact('atmreports','vendors'));
    }


 public function searchreporterVendor()
    {
        $user = Auth::user()->id;

        $vendors = Vendor::all();

        $atmreports= CallLog::all()->sortByDesc("created_at");
        return view('vendorreport.searchvariesVendor', compact('atmreports','vendors'));
    }

    public function viewDailyReporter(Request $request)
    {
//return $request->all();

$to_date=    date('Y-m-d');
        $vendor_id=$request['vendor_id'];
        $date=$request['to_date'];

 $dateStart = Carbon::now()->startOfMonth(); 
 $dateEnd = Carbon::now()->endOfMonth(); 



	$atmreports= CallLog::whereDate('mail_at', '>=', $dateStart)
		 ->OrWhere('closed_at','>=', $dateStart)
		 // ->Where('error_code','NOT LIKE', '%RECEIPT%')
            ->get()->sortByDesc("request_status");




            $start = ' 00:00:00';
            $end = ' 23:59:55';
            $start_date = $date . $start;
            $end_date = $date . $end;
//      return  $minus_four_date= date("Y-m-d 20:00:00", strtotime('-4 days', $start_date)); //Convert to Nigeria time


        // Daily Trend Analysis
        $myDate = new Carbon($date);
        $last30 = $myDate->subDays(30);
        $dailytrend= DailyTrend::all()->Where('date', '<=', $last30);


        //NUMBER OF CALLS ESCALATED TO VENDOR
        $call_escalated= CallLog::Where('created_at','>=', $start_date)->Where('created_at','<', $end_date)
                ->Where('vendor_id','=', $vendor_id)
                ->Where('request_status','!=', 'DELETED')
                ->count();

        //NUMBER OF OPEN CALLS AT CLOSE OF BUSINESS
        $query_open= CallLog::Where('vendor_id','=', $vendor_id)
            ->Where('request_status','=', 'Open')
         //   ->Where('error_code','NOT LIKE', '%RECEIPT%')
            ->count();

        // NUMBER CALLS RESOLVED SAME DAY
        $query_sameday= CallLog::Where('created_at','>=', $start_date)->Where('created_at','<=', $end_date)
            ->Where('closed_at','>=', $start_date)->Where('closed_at','<=', $end_date)
            ->Where('vendor_id','=', $vendor_id)
            ->Where('request_status','=', 'Resolved')
            ->count();


        $query_previous= CallLog::Where('created_at','<', $start_date)->Where('closed_at','>=', $start_date)
            ->Where('closed_at','<=', $end_date)
            ->Where('vendor_id','=', $vendor_id)
//            ->Where('request_status','!=', 'DELETED')
            ->count();

//	Number of Open Calls Brought Forward
//        $query_forward = "SELECT DISTINCT terminal_id FROM uba_call_log WHERE vendor_id = '$vendor_id' AND maildate < '$start_date'
//            AND request_status ='' AND error_code !='RECEIPT PRINTER FAULTY' AND request_status !='DELETED'
//
//             OR vendor_id = '$vendor_id'
//            AND maildate < '$start_date' AND closed_date > '$start_date'  AND error_code !='RECEIPT PRINTER FAULTY' AND request_status !='DELETED' ";

        $query_forward1= CallLog::Where('created_at','<', $start_date)
            ->Where('vendor_id','=', $vendor_id)
            ->Where('request_status','=', 'Open')
            ->count();

        $query_forward2= CallLog::Where('created_at','<', $start_date)->Where('closed_at','>', $start_date)
            ->Where('vendor_id','=', $vendor_id)
            ->orderBy('request_status', 'desc')
            ->count();

        $query_forward=$query_forward2+$query_forward1;


        $query_suspended= CallLog::Where('created_at','<=', $end_date)
            ->Where('vendor_id','=', $vendor_id)
            ->Where('request_status','=', 'Suspended')
            ->count();


// PENDING AGED CALLS i.e > 3 DAYS



  $query_aged= CallLog::Where('created_at', '>', Carbon::now()->subDays(3))
            ->Where('vendor_id','=', $vendor_id)
            ->Where('request_status','=', 'Open')
            ->count();



// Call Closed today


        $query_within_date= CallLog::Where('closed_at','>=', $start_date)->Where('closed_at','<=', $end_date)
            ->Where('vendor_id','=', $vendor_id)
            ->Where('request_status','=', 'Resolved')
            ->count();

        //Number of ATM in VENDOR ESTATE
        
        //if vendor id is empty string
        if($vendor_id !== ''){
        $vendor_count= BankData::Where('vendor_id','=', $vendor_id)
             ->count();


        $percent = ($query_open/$vendor_count)*100;
            
        }else{
            return Redirect::back()->withErrors(['Select a vendor']);
        }

		
	

        //        all()->sortByDesc("created_at");
//        $atmreports= CallLog::all()->sortByDesc("created_at");
        return view('vendorreport.viewvaries', compact('atmreports', 'call_escalated','query_open','query_sameday','query_previous',
            'query_forward','query_suspended','query_within_date','percent','to_date','query_aged','dailytrend'));

//        return view('vendorreport.viewvaries');// compact('atmreports','vendors','insurances','countries','departments','states','cities','dailytrend'));
    }
    
// Ghost
    
  

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

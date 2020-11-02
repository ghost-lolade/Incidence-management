<?php

namespace App\Http\Controllers;

use App\BankData;
use App\Technician;
use App\Brand;
use App\CallLog;
use App\City;
use App\Country;
use App\Department;
use App\Insurance;
use App\Mail\CloseIncidenceMail;
use App\Mail\LogCallMail;
use App\Mail\VendorLogCallMail;
use App\PartReplace;
use App\State;
use App\User;
use Session;
use App\Vendor;
use App\VendorData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Prophecy\Call\Call;
use App\Requester;


class CallLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $thirtyAgo = 30;
        $dayCheck = Carbon::today()->subDays($thirtyAgo);
        $aMonth=$dayCheck ->toDateString();
       // return     $today =date("Y-m-d")->subDays($dayAgo);
        $dayAgo = 3;
         // where here there is your calculation for now How many days
            $dayToCheck = Carbon::today()->subDays($dayAgo);
            $previous=$dayToCheck ->toDateString();

          $atmreports = CallLog::Where('request_status', '=', 'Resolved')
            ->whereDate('closed_at', '>', $previous)
            ->get();

        $atmnotclose = CallLog::Where('request_status', '=', 'Suspended')
//            ->Where('request_status', '!=', 'Open')
//            ->whereDate('mail_at', '>', $aMonth)
            ->get();
        return view('atmreport.index', compact('atmreports','atmnotclose'));
    }

    public function indexopencall()
    {
        //
        $atmreports = CallLog::Where('request_status', '=', 'Open')
            ->get();

        $atmnotclose = CallLog::Where('request_status', '=', 'Delete')
          //  ->Where('request_status', '!=', 'Open')
           // ->whereDate('log_day', '>', $aMonth)
            ->get();
        return view('atmreport.indexopencall', compact('atmreports','atmnotclose'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
//        $countvendor= Brand::Where('id', '!=', 0)
//            ->count();
//        for ($i = 0; $i < $countvendor+1; ++$i){
//
//            //echo $countvendor;
//            echo  $i;
//
//            print    $atmreports = CallLog::Where('vendor_request_status', '=', 'Open')
//               // ->where('created_at', '<', Carbon::now()->subMinutes(1)->toDateTimeString())
//                ->Where('vendor_id', '=', $i)
//                ->orderBy('created_at', 'desc')->get();
//        }
     // echo  $user = Auth::user()->email;

            $user = Auth::user()->id;
            return view('atmreport.create');

    }
    public function createEco()
    {
        //
//        $countvendor= Brand::Where('id', '!=', 0)
//            ->count();
//        for ($i = 0; $i < $countvendor+1; ++$i){
//
//            //echo $countvendor;
//            echo  $i;
//
//            print    $atmreports = CallLog::Where('vendor_request_status', '=', 'Open')
//               // ->where('created_at', '<', Carbon::now()->subMinutes(1)->toDateTimeString())
//                ->Where('vendor_id', '=', $i)
//                ->orderBy('created_at', 'desc')->get();
//        }
        // echo  $user = Auth::user()->email;

        $user = Auth::user()->id;
        return view('atmreport.createeco');

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function storeEco(Request $request)
    {
        $current = Carbon::now();
        $itrate = $request['terminalid'];
        $count1 = count($itrate);
        $user = Auth::user()->email;
        if ($count1 != '') {
            $drug = $request['terminalid'];
            $counter = count($drug);
            for ($i = 0; $i < $counter; ++$i) {
                $terminal_id= $request['terminalid'][$i];

                
                $searchTerminal= CallLog::where('terminal_id', '=', $terminal_id )->WHERE('request_status', '=', 'Open')->count();
                
                 if ($searchTerminal >= 1 ) {
                   //  Check if Call exist  
                     
        return redirect()->intended('listopencall')->with('error','Incidence  Already Exist!');
        
                     
                 }
                
                $searchvendor= BankData::where('terminal_id', '=', $terminal_id )->get();
                
                
                 $searchce= Technician::where('terminal_id', '=', $terminal_id )->get();

                $cename= $searchce[0]->name;
                $cephone= $searchce[0]->phone;
                $ce= $cename.' '. $cephone;
                
                $vendor_name=  $searchvendor[0]->vendor_name;
                $vendor_id=  $searchvendor[0]->vendor_id;
                $sla_hour=  $searchvendor[0]->sla_hour;
                $state=  $searchvendor[0]->state;
                $region=  $searchvendor[0]->region;
                $atm_code=  $searchvendor[0]->atm_code;
                $address =  $searchvendor[0]->address;
               // $timers=  $searchvendor[0]->timers;
                CallLog::create([
                    'terminal_id' => $request['terminalid'][$i],
                    'atm_name' => $request['atmname'][$i],
                    'custodian_phone' => $request['custodian_phone'][$i],
                    'error_code' => $request['errorcode'],
                    'subject' => $request['subject'],
                    'vendor_name' =>$vendor_name,
                      'ce_name' =>$ce,
                    'vendor_id' =>$vendor_id,
                    'sla_hour' =>$sla_hour,
                    'atm_state' =>$state,
                    'region' =>$region,
                'ticket_no' => preg_replace("/[^a-zA-Z0-9]+/", "", $current),
                    'request_status' =>"Open",
                    'vendor_request_status' =>"Open",
                    'address' =>$address,
                    'fromaddress' =>$user,
                    'mail_at' =>$current,
                ]);
                
                 $terminal_id= $request['terminalid'][0];
                
                 $branchmail = BankData::Where('terminal_id', '=', $terminal_id)->get();
            
            
            // If Email of Branch exist use this 
            if ($branchmail[0]->csm_mail!=null || $branchmail[0]->branch_mail!=null ) {
                
                 $mails = Requester::pluck('email')->toArray();
                Mail::to($mails)
                    ->cc([$branchmail[0]->csm_mail,$branchmail[0]->branch_mail])
                 //  ->cc(['oladejisteven@gmail.com','oladejisteven@gmail.com'])
                    ->send(new LogCallMail());
               

        $techmail = Technician::Where('terminal_id', '=', $terminal_id)->get();

                 $techname= $techmail[0]->email;
                 
                $vendorname= $branchmail[0]->vendor_name;

               $mails = VendorData::Where('name', '=', $vendorname)->pluck('email')->toArray();
                Mail::to($mails)
                    ->cc($techname)
                    ->send(new VendorLogCallMail());
                
            }
            // If Email of Branch is NULL use this 
             $mails = Requester::pluck('email')->toArray();
                Mail::to($mails)
               //     ->cc([$branchmail[0]->csm_mail,$branchmail[0]->branch_mail])
                 //  ->cc(['oladejisteven@gmail.com','oladejisteven@gmail.com'])
                    ->send(new LogCallMail());
               

        $techmail = Technician::Where('terminal_id', '=', $terminal_id)->get();

                 $techname= $techmail[0]->email;
                 
                $vendorname= $branchmail[0]->vendor_name;

               $mails = VendorData::Where('name', '=', $vendorname)->pluck('email')->toArray();
                Mail::to($mails)
                    ->cc($techname)
                    ->send(new VendorLogCallMail());
            
            
               
               

            }

        }


        return redirect()->intended('listopencall')->with('success','Incidence  created successfully!');
        
         // return redirect('vendor-management')->with('success','Item created successfully!');
        
        
    }


    public function store(Request $request)
    {
            $itrate = $request['terminalid'];
            $count1 = count($itrate);
        $user = Auth::user()->username;
            if ($count1 != '') {
                $drug = $request['terminalid'];
                $counter = count($drug);
                for ($i = 0; $i < $counter; ++$i) {
                    $terminal_id= $request['terminalid'][$i];

                       $searchvendor= BankData::where('terminal_id', '=', $terminal_id )->get();

                   $vendor_name=  $searchvendor[0]->vendor_name;
                   $vendor_id=  $searchvendor[0]->vendor_id;
                   $sla_hour=  $searchvendor[0]->sla_hour;
                   $state=  $searchvendor[0]->state;
                   $region=  $searchvendor[0]->region;
                   $atm_code=  $searchvendor[0]->atm_code;
                   $address =  $searchvendor[0]->address;
                   $timers=  $searchvendor[0]->timers;
                    CallLog::create([
                        'terminal_id' => $request['terminalid'][$i],
                        'atm_name' => $request['atmname'][$i],
                        'custodian_phone' => $request['custodian_phone'][$i],
                        'error_code' => $request['errorcode'][$i],
                        'vendor_name' =>$vendor_name,
                        'vendor_id' =>$vendor_id,
                        'sla_hour' =>$sla_hour,
                        'atm_state' =>$state,
                        'region' =>$region,
                        'ticket_no' =>$atm_code,
                        'request_status' =>"Open",
                        'vendor_request_status' =>"Open",
                        'address' =>$address,
                        'fromaddress' =>$user,


                    ]);
                    $mails = Requester::pluck('email')->toArray();
                    Mail::to($mails)
                        ->cc(['oladejisteven@gmail.com','oladejisteven@gmail.com'])
                        ->send(new LogCallMail());
                    // return response()->json($post);


                    $mails = VendorData::Where('id', '=', 1)->pluck('email')->toArray();
                    Mail::to($mails)
                        ->cc(['oladejisteven@gmail.com','oladejisteven@gmail.com'])
                        ->send(new VendorLogCallMail());

//                    $suspend_reason=CallLog::Where('id', '=', $id)->pluck('ce_suspend_reason');
                }


        }


        return redirect()->intended('listopencall');
    }


//    public function mail()
//    {
//        $user = User::find(1)->email();
//   return $user->email;
//
//
//        Mail::send('atmreport.mailExample', $user, function($message) use ($user) {
//        return    $message->to($user->email);
//            $message->subject('E-Mail Example');
//        });
//
//
//        dd('Mail Send Successfully');
//    }

    public function mail()
    {
        $atmreports = CallLog::Where('request_status', '=', 'Open')->get();

        $email = Auth::user()->email;
        Mail::to($email)->send(new CloseIncidenceMail());
        return view('atmreport.index', compact('atmreports'));
    }



    public function checkIn($id)
    {
        //
        $atmreports = CallLog::find($id);
        $insurances = Insurance::all();
//        $statuses = Status::all();
        $departments = Department::all();
        //    $divisions = Division::all();
//  return view('atmreports/create');

        if ($atmreports == null || count($atmreports) == 0) {
            return redirect()->intended('/atmreport-management');
        }

        return view('atmreports/checkin', ['atmreports' => $atmreports,
            'insurances' => $insurances, 'departments' => $departments]);
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

    public function uploadCallLog()
    {
        return view('atmreport.uploadCall');
    }


    public function uploadCallLogFile(Request $request){
        if ($request->input('submit') != null ){
            $file = $request->file('file');
            // File Details
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize();
            $mimeType = $file->getMimeType();
            // Valid File Extensions
            $valid_extension = array("csv");
            // 2MB in Bytes
            $maxFileSize = 2097152;
            // Check file extension
            if(in_array(strtolower($extension),$valid_extension)){
                // Check file size
                if($fileSize <= $maxFileSize){
                    // File upload location
                    ////  $location = 'uploads';
                    // File upload location
                    $location = '../uploads';

                    // Upload file
                    $file->move($location,$filename);

                    // Import CSV to Database
                    $filepath = public_path($filename);

                    // Reading file
                    $file = fopen($filepath,"r");

                    $importData_arr = array();
                    $i = 0;

                    while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                        $num = count($filedata );

                        // Skip first row (Remove below comment if you want to skip the first row)
                        /*if($i == 0){
                           $i++;
                           continue;
                        }*/
                        for ($c=0; $c < $num; $c++) {
                            $importData_arr[$i][] = $filedata [$c];
                        }
                        $i++;
                    }
                    fclose($file);

                    // Insert to MySQL database
                    foreach($importData_arr as $importData){
                        //   BankData::where('terminal_id', $importData[1])->delete();

                        CallLog::updateOrCreate(
                            ['ticket_no' => $importData[0]],
                            [
                                "ticket_no"=>$importData[0],
                                "terminal_id"=>$importData[1],
                                "sol_id"=>$importData[2],
                                "atm_name"=>$importData[3],
                                "serial_no"=>$importData[4],
                                "address"=>$importData[5],
                                "state"=>$importData[6],
                                "subject"=>$importData[7],
                                "error_code"=>$importData[8],
                                "custodian_phone"=>$importData[9],
                                "request_status"=>$importData[10],
                                "part_replaced"=>$importData[11],
                                "created_at"=>$importData[12],
                                "mail_at"=>$importData[12],
                                "closed_at"=>$importData[13],
                                "sla_hour"=>$importData[14],
                                "vendor_name"=>$importData[15]

                            ]
                        );

//                        $insertData = array(
//                            "ticket_no"=>$importData[0],
//                            "terminal_id"=>$importData[1],
//                            "atm_name"=>$importData[2],
//                            "closed_at"=>$importData[3],
//                            "mail_at"=>$importData[4],
//                            "error_code"=>$importData[5],
//                            "request_status"=>$importData[6]);
//                        //   "user_id"=>$importData[11]);
//                        CallLog::insertData($insertData);
                    }
                    Session::flash('message','Import Successful.');
                }else{
                    Session::flash('message','File too large. File must be less than 2MB.');
                }

            }else{
                Session::flash('message','Invalid File Extension.');
            }

        }

        // Redirect to index
        return redirect()->action('BankDataController@index');
    }







    public function searchreporter()
    {
        $cities = City::all();
        $states = State::all();
        $countries = Country::all();
     //   $insurances = Insurance::all();
        $vendors = Vendor::all();
        $departments = Department::all();
        $atmreports= CallLog::all()->sortByDesc("created_at");
                return view('atmreport.searchvaries', compact('atmreports','vendors','countries','departments','states','cities'));
    }


    public function viewReporter(Request $request)
    {

        $vendor_id=$request['vendor_id'];
      //  $region=$request['region'];
        $state_id=$request['state_id'];
        $status=$request['status'];
        $to_date=$request['to_date'];
        $from_date=$request['from_date'];

   //     return $request->all();


		if ($status=='' && $state_id=='' && $vendor_id==''){

			$atmreports= CallLog::Where('mail_at','>=', $from_date)
				->Where('mail_at','<=', $to_date)
				->get();
		}

        if ($status!='' && $state_id=='' && $vendor_id==''){

            $atmreports= CallLog::Where('request_status', '=', $status)
                ->Where('mail_at','>=', $from_date)
                ->Where('mail_at','<=', $to_date)
                ->get();
        }
		
		
        if ($status!='' && $state_id!='' && $vendor_id==''){
			
            $atmreports= CallLog::Where('request_status', '=', $status)
                ->Where('atm_state', 'LIKE', $state_id)
                ->Where('mail_at','>=', $from_date)
                ->Where('mail_at','<=', $to_date)
                ->get();
        }

        if ($status!='' && $state_id !='' && $vendor_id !='') {

            $atmreports = CallLog::Where('vendor_name', '=', $vendor_id)
                ->Where('request_status', '=', $status)
                ->Where('mail_at', '>=', $from_date)
                ->Where('mail_at', '<=', $to_date)
                ->Where('atm_state', 'LIKE', $state_id)
                ->get();
        }

        if ($status!='' && $state_id=='' && $vendor_id !=''){

            $atmreports = CallLog::Where('vendor_id', '=', $vendor_id)
                ->Where('request_status', '=', $status)
                ->Where('mail_at', '>=', $from_date)
                ->Where('mail_at', '<=', $to_date)
                ->get();
        }


        if ($status=='' && $state_id!='' && $vendor_id !=''){

            $atmreports = CallLog::Where('vendor_id', '=', $vendor_id)
                ->Where('atm_state', 'LIKE', $state_id)
                ->Where('mail_at', '>=', $from_date)
                ->Where('mail_at', '<=', $to_date)
                ->get();
        }
        if ($status=='' && $state_id=='' && $vendor_id !=''){

            $atmreports = CallLog::Where('vendor_id', '=', $vendor_id)
                ->Where('mail_at', '>=', $from_date)
                ->Where('mail_at', '<=', $to_date)
                ->get();
        }

        if ($status=='' && $state_id!='' && $vendor_id ==''){

            $atmreports = CallLog::Where('atm_state', '=', $state_id)
                ->Where('mail_at', '>=', $from_date)
                ->Where('mail_at', '<=', $to_date)
                ->get();
        }
       

        //        all()->sortByDesc("log_day");
//        $atmreports= CallLog::all()->sortByDesc("log_day");
         return view('atmreport.viewvaries', compact('atmreports'));

//        return view('atmreport.viewvaries');// compact('atmreports','vendors','insurances','countries','departments','states','cities'));
    }

    public function searchTerminal()
    {
       // $cities = City::all();
       // $states = State::all();
        //$countries = Country::all();
       // $insurances = Insurance::all();
        $vendors = Vendor::all();
        //$departments = Department::all();
        $atmreports= CallLog::all()->sortByDesc("log_day");
        return view('atmreport.terminalvaries', compact('atmreports','vendors'));
    }


    public function viewTerminalReporter(Request $request)
    {
        // $user=Auth::user()->user_no;
//return $request->all();

        $terminal_id=$request['terminal_id'];
        $to_date=$request['to_date'];
        $from_date=$request['from_date'];

//        if ($user==0){
            $atmreports= CallLog::Where('terminal_id', '=', $terminal_id)
                ->Where('mail_at','>=', $from_date)
                ->Where('mail_at','<=', $to_date)
                ->get();
            $atmparts= PartReplace::Where('terminal_id', '=', $terminal_id)
                ->Where('created_at','>=', $from_date)
                ->Where('created_at','<=', $to_date)
                ->get();

            $atmpartcost= PartReplace::Where('terminal_id', '=', $terminal_id)
                ->Where('created_at','>=', $from_date)
                ->Where('created_at','<=', $to_date)
                ->sum('price');

            $callcount= CallLog::Where('terminal_id', '=', $terminal_id)
                ->Where('mail_at','>=', $from_date)
                ->Where('mail_at','<=', $to_date)
                ->count();
//        }
//        else{
//            $atmreports= CallLog::Where('terminal_id', '=', $terminal_id)
//                ->Where('vendor_id', '=', $user)
//                ->Where('log_day','>=', $from_date)
//                ->Where('log_day','<=', $to_date)
//                ->get();
//            $atmparts= PartReplace::Where('terminal_id', '=', $terminal_id)
//                ->Where('created_at','>=', $from_date)
//                ->Where('created_at','<=', $to_date)
//                ->get();
//            $atmpartcost= PartReplace::Where('terminal_id', '=', $terminal_id)
//                ->Where('created_at','>=', $from_date)
//                ->Where('created_at','<=', $to_date)
//                ->sum('price');
////            $query_sla = "SELECT * FROM uba_call_log WHERE maildate >= '$start_date' AND maildate <= '$end_date' AND terminal_id= '$terminal_id' AND closed_date > due_date";
//
//            $callcount= CallLog::Where('terminal_id', '=', $terminal_id)
//                ->Where('log_day','>=', $from_date)
//                ->Where('log_day','<=', $to_date)
//                ->count();
//        }

        return view('atmreport.viewterminalvaries', compact('atmreports', 'callcount', 'atmparts','atmpartcost'));

//        return view('atmreport.viewvaries');// compact('atmreports','vendors','insurances','countries','departments','states','cities'));
    }





    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //


        //THIS IS USE TO ACCEPT STATUS FROM VENDOR
        $atmreport = CallLog::findOrFail($id);


        //REOPEN CALL TO CE

        //CLOSE CALL TO BANK
            $username = Auth::user()->username;

        $atmreport->reopen_comment = $request->closure_mail;
       // $atmreport->close_day =  $request->close_day;
       // $atmreport->close_time = $request->close_time;
        //   $post->closed_at = $request->date_closed;
        $atmreport->call_closer_username = $username;
        $atmreport->request_status ='Open';
        $atmreport->vendor_request_status ='Open';
        $atmreport->reopen_at = date('Y-m-d H:i:s');
        $atmreport->save();


        return response()->json($atmreport);


        $atmnotclose->reopen_comment = $request->closure_mail;
        // $atmreport->close_day =  $request->close_day;
        // $atmreport->close_time = $request->close_time;
        //   $post->closed_at = $request->date_closed;
        $atmnotclose->call_closer_username = $username;
        $atmnotclose->request_status ='Open';
        $atmnotclose->vendor_request_status ='Open';
        $atmnotclose->reopen_at = date('Y-m-d H:i:s');
        $atmnotclose->save();

        return response()->json($atmnotclose);

    }
}

<?php

namespace App\Http\Controllers;

use App\PosLog;
use Illuminate\Http\Request;

use App\BankData;
use App\PosData;
use App\Technician;
use App\Brand;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Prophecy\Call\Call;
use App\Requester;

class PosLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $thirtyAgo = 30;
        $dayCheck = Carbon::today()->subDays($thirtyAgo);
        $aMonth=$dayCheck ->toDateString();
       // return     $today =date("Y-m-d")->subDays($dayAgo);
        $dayAgo = 3;
         // where here there is your calculation for now How many days
            $dayToCheck = Carbon::today()->subDays($dayAgo);
            $previous=$dayToCheck ->toDateString();

          $atmreports = PosLog::Where('request_status', '=', 'Resolved')
            ->whereDate('closed_at', '>', $previous)
            ->get();

        $atmnotclose = PosLog::Where('request_status', '=', 'Suspended')
//            ->Where('request_status', '!=', 'Open')
//            ->whereDate('mail_at', '>', $aMonth)
            ->get();
        return view('posreport.index', compact('atmreports','atmnotclose'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexopencall()
    {
        //
        $atmreports = PosLog::Where('request_status', '=', 'Open')
            ->get();

        $atmnotclose = PosLog::Where('request_status', '=', 'Delete')
          //  ->Where('request_status', '!=', 'Open')
           // ->whereDate('log_day', '>', $aMonth)
            ->get();
        return view('posreport.indexopencall', compact('atmreports','atmnotclose'));
    }
    public function create()
    {
        //

        $user = Auth::user()->id;
        return view('posreport.create');
    }

    public function createEco()
    {

        $user = Auth::user()->id;
        return view('posreport.createeco');

    }

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
                $pos_id= $request['terminalid'][$i];

                
                $searchTerminal= PosLog::where('pos_id', '=', $pos_id )->WHERE('request_status', '=', 'Open')->count();
                
                 if ($searchTerminal >= 1 ) {
                   //  Check if Call exist  
                     
                    return redirect()->intended('listopencall')->with('error','Incidence  Already Exist!');
        
                     
                 }
                
                $searchvendor= BankData::where('terminal_id', '=', $pos_id )->get();
                
                
                 //$searchce= Technician::where('pos_id', '=', $pos_id )->get();

                //$cename= $searchce[0]->name;
                //$cephone= $searchce[0]->phone;
                //$ce= $cename.' '. $cephone;
                
                $vendor_name=  $searchvendor[0]->vendor_name;
                $vendor_id=  $searchvendor[0]->vendor_id;
                $sla_hour=  $searchvendor[0]->sla_hour;
                $state=  $searchvendor[0]->state;
                $region=  $searchvendor[0]->region;
                $atm_code=  $searchvendor[0]->atm_code;
                $address =  $searchvendor[0]->address;
               // $timers=  $searchvendor[0]->timers;

            //    'incidence_no','pos_id', 'serial_no', 'branch', 'fault_description', 'subject', 'vendor_id', 'log_date',
        // 'fromaddress', 'status', 'sla_hour', 'call_closer', 'suspend_at', 'remark', 'closure_time', 'repair_amount', 'reopen_at'
                PosLog::create([
                    'pos_id' => $request['terminalid'][$i],
                    'incidence_no' => $atm_code,
                    'serial_no' => $request['atmname'][$i],
                    'branch' => $address,
                    'fault_description' => $request['errorcode'],
                    'subject' => $request['subject'],
                    'vendor_id' => $vendor_id,
                    'log date' => $current,
                    'fromaddress' =>$user,
                    'status' =>$state,
                    'sla_hour' =>$sla_hour,
                    'call_closer' =>$request['call_closer'],
                    'suspend_at' =>$request['suspend_at'],
                    'remark' =>$request['remark'],
                    'closure_time' =>$request['closure_time'],
                    //'repair_amount' =>$request['repair_amount'],
                    'reopen_at' =>$request['reopen_at'],
                    
                ]);
                
                 $pos_id= $request['terminalid'][0];
                
                 $branchmail = BankData::where('terminal_id', '=', $pos_id)->get();
            
            
            // If Email of Branch exist use this 
            if ($branchmail[0]->csm_mail!=null || $branchmail[0]->branch_mail!=null ) {
                
                 $mails = Requester::pluck('email')->toArray();
                Mail::to($mails)
                    ->cc([$branchmail[0]->csm_mail,$branchmail[0]->branch_mail])
                 //  ->cc(['oladejisteven@gmail.com','oladejisteven@gmail.com'])
                    ->send(new LogCallMail());
               

        $techmail = Technician::Where('terminal_id', '=', $pos_id)->get();

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
               

        $techmail = Technician::Where('pos_id', '=', $pos_id)->get();

                 $techname= $techmail[0]->email;
                 
                $vendorname= $branchmail[0]->vendor_name;

               $mails = VendorData::Where('name', '=', $vendorname)->pluck('email')->toArray();
                Mail::to($mails)
                    ->cc($techname)
                    ->send(new VendorLogCallMail());
            
            
               
               

            }

        }


        return redirect()->intended('poslistopencall')->with('success','Incidence  created successfully!');
        
         // return redirect('vendor-management')->with('success','Item created successfully!');
        
        
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

                   PosLog::create([
                    'pos_id' => $request['terminalid'][$i],
                    'incidence_no' =>  $request['incidence_no'][$i],
                    'serial_no' => $request['atmname'][$i],
                    'branch' => $request['branch'],
                    'fault_description' => $request['errorcode'][$i],
                    'subject' => $request['subject'],
                    'vendor_id' => $vendor_id,
                    'log_date' => $current,
                    'fromaddress' =>$user,
                    'status' =>$request['status'],
                    'sla_hour' =>$sla_hour,
                    'call_closer' =>$request['call_closer'],
                    'suspend_at' =>$request['suspend_at'],
                    'remark' =>$request['remark'],
                    'closure_time' =>$request['closure_time'],
                    'repair_amount' =>$request['repair_amount'],
                    'reopen_at' =>$request['reopen_at'],
                    
                ]);
                    // CallLog::create([
                    //     'terminal_id' => $request['terminalid'][$i],
                    //     'atm_name' => $request['atmname'][$i],
                    //     'custodian_phone' => $request['custodian_phone'][$i],
                    //     'error_code' => $request['errorcode'][$i],
                    //     'vendor_name' =>$vendor_name,
                    //     'vendor_id' =>$vendor_id,
                    //     'sla_hour' =>$sla_hour,
                    //     'atm_state' =>$state,
                    //     'region' =>$region,
                    //     'ticket_no' =>$atm_code,
                    //     'request_status' =>"Open",
                    //     'vendor_request_status' =>"Open",
                    //     'address' =>$address,
                    //     'fromaddress' =>$user,


                    // ]);
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

    public function mail()
    {
        $atmreports = PosLog::Where('request_status', '=', 'Open')->get();

        $email = Auth::user()->email;
        Mail::to($email)->send(new CloseIncidenceMail());
        return view('posreport.index', compact('atmreports'));
    }


//     public function checkIn($id)
//     {
//         //
//         $atmreports = PosLog::find($id);
//         $insurances = Insurance::all();
// //        $statuses = Status::all();
//         $departments = Department::all();
//         //    $divisions = Division::all();
// //  return view('atmreports/create');

//         if ($atmreports == null || count($atmreports) == 0) {
//             return redirect()->intended('/atmreport-management');
//         }

//         return view('atmreports/checkin', ['atmreports' => $atmreports,
//             'insurances' => $insurances, 'departments' => $departments]);
//     }

    // I need to change the atmname and custodian_phone

    public function searchResponse(Request $request){
        $query = $request->get('term','');
        $BankDatas=\DB::table('pos_datas');
        if($request->type=='terminalid'){
            $BankDatas->where('pos_id','LIKE','%'.$query.'%')->limit(10);
        }
        if($request->type=='pos_id'){
            $BankDatas->where('pos_id','LIKE','%'.$query.'%');
        }
        if($request->type=='custodian_phone'){
            $BankDatas->where('custodian_phone','LIKE','%'.$query.'%');
        }
        $BankDatas=$BankDatas->get();
        $data=array();
        foreach ($BankDatas as $BankData) {
            $data[]=array('terminal_id'=>$BankData->terminal_id,'pos_id'=>$BankData->pos_id,'custodian_phone'=>$BankData->custodian_phone);
        }
        if(count($data))
            return $data;
        else
            return ['terminal_id'=>'','atm_name'=>'','custodian_phone'=>''];
    }


    public function uploadCallLog()
    {
        return view('posreport.uploadCall');
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
                        // DOES ARRANGEMENT COUNT???
                        PosLog::updateOrCreate(
                            ['pos_id' => $importData[0]],
                            [
                                'pos_id' => $importData[0],
                                'incidence_no' =>  $importData[1],
                                'serial_no' => $importData[2],
                                'branch' => $importData[3],
                                'fault_description' => $importData[4],
                                'subject' => $importData[5],
                                'vendor_id' => $importData[6],
                                'log date' => $importData[7],
                                'fromaddress' =>$importData[8],
                                'status' => $importData[9],
                                'sla_hour' => $importData[10],
                                'call_closer' => $importData[11],
                                'suspend_at' => $importData[12],
                                'remark' => $importData[13],
                                'closure_time' => $importData[14],
                                'repair_amount' => $importData[15],
                                'reopen_at' =>$importData[16],


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
        $atmreports= PosLog::all()->sortByDesc("created_at");
                return view('posreport.searchvaries', compact('atmreports','vendors','countries','departments','states','cities'));
    }


    public function viewReporter(Request $request)
    {

        $vendor_id=$request['custodian_phone'];
      //  $region=$request['region'];
        $state_id=$request['branch'];
        $status=$request['status'];
        $to_date=$request['to_date'];
        $from_date=$request['from_date'];

   //     return $request->all();


		if ($status=='' && $state_id=='' && $vendor_id==''){

			$atmreports= PosLog::Where('mail_at','>=', $from_date)
				->Where('mail_at','<=', $to_date)
				->get();
		}

        if ($status!='' && $state_id=='' && $vendor_id==''){

            $atmreports= PosLog::Where('request_status', '=', $status)
                ->Where('mail_at','>=', $from_date)
                ->Where('mail_at','<=', $to_date)
                ->get();
        }
		
		
        if ($status!='' && $state_id!='' && $vendor_id==''){
			
            $atmreports= PosLog::Where('request_status', '=', $status)
                ->Where('branch', 'LIKE', $state_id)
                ->Where('mail_at','>=', $from_date)
                ->Where('mail_at','<=', $to_date)
                ->get();
        }

        if ($status!='' && $state_id !='' && $vendor_id !='') {

            $atmreports = PosLog::Where('vendor_name', '=', $vendor_id)
                ->Where('request_status', '=', $status)
                ->Where('mail_at', '>=', $from_date)
                ->Where('mail_at', '<=', $to_date)
                ->Where('branch', 'LIKE', $state_id)
                ->get();
        }

        if ($status!='' && $state_id=='' && $vendor_id !=''){

            $atmreports = PosLog::Where('vendor_id', '=', $vendor_id)
                ->Where('request_status', '=', $status)
                ->Where('mail_at', '>=', $from_date)
                ->Where('mail_at', '<=', $to_date)
                ->get();
        }


        if ($status=='' && $state_id!='' && $vendor_id !=''){

            $atmreports = PosLog::Where('vendor_id', '=', $vendor_id)
                ->Where('branch', 'LIKE', $state_id)
                ->Where('mail_at', '>=', $from_date)
                ->Where('mail_at', '<=', $to_date)
                ->get();
        }
        if ($status=='' && $state_id=='' && $vendor_id !=''){

            $atmreports = PosLog::Where('vendor_id', '=', $vendor_id)
                ->Where('mail_at', '>=', $from_date)
                ->Where('mail_at', '<=', $to_date)
                ->get();
        }

        if ($status=='' && $state_id!='' && $vendor_id ==''){

            $atmreports = PosLog::Where('atm_state', '=', $state_id)
                ->Where('mail_at', '>=', $from_date)
                ->Where('mail_at', '<=', $to_date)
                ->get();
        }
       

        //        all()->sortByDesc("log_day");
//        $atmreports= CallLog::all()->sortByDesc("log_day");
         return view('posreport.viewvaries', compact('atmreports'));

//        return view('posreport.viewvaries');// compact('atmreports','vendors','insurances','countries','departments','states','cities'));
    }

    public function searchTerminal()
    {
       // $cities = City::all();
       // $states = State::all();
        //$countries = Country::all();
       // $insurances = Insurance::all();
        $vendors = Vendor::all();
        //$departments = Department::all();
        $atmreports= PosLog::all()->sortByDesc("log_date");
        return view('posreport.terminalvaries', compact('atmreports','vendors'));
    }


    public function viewTerminalReporter(Request $request)
    {
        // $user=Auth::user()->user_no;
//return $request->all();

        $terminal_id=$request['terminal_id'];
        $to_date=$request['to_date'];
        $from_date=$request['from_date'];

//        if ($user==0){
            $atmreports= PosLog::Where('pos_id', '=', $terminal_id)
                ->Where('log_date','>=', $from_date)
                ->Where('log_date','<=', $to_date)
                ->get();
            // $atmparts= PartReplace::Where('pos_id', '=', $terminal_id)
            //     ->Where('created_at','>=', $from_date)
            //     ->Where('created_at','<=', $to_date)
            //     ->get();

            // $atmpartcost= PartReplace::Where('pos-id', '=', $terminal_id)
            //     ->Where('created_at','>=', $from_date)
            //     ->Where('created_at','<=', $to_date)
            //     ->sum('price');

            $callcount= PosLog::Where('pos_id', '=', $terminal_id)
                ->Where('log_date','>=', $from_date)
                ->Where('log_date','<=', $to_date)
                ->count();

        return view('posreport.viewterminalvaries', compact('atmreports', 'callcount', 'atmparts','atmpartcost'));

//        return view('posreport.viewvaries');// compact('atmreports','vendors','insurances','countries','departments','states','cities'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PosLog  $posLog
     * @return \Illuminate\Http\Response
     */
    public function show(PosLog $posLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PosLog  $posLog
     * @return \Illuminate\Http\Response
     */
    public function edit(PosLog $posLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PosLog  $posLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PosLog $posLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PosLog  $posLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //


        //THIS IS USE TO ACCEPT STATUS FROM VENDOR
        $atmreport = PosLog::findOrFail($id);


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

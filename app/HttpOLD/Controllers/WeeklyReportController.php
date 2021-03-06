<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WeeklyReportController extends Controller
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

        return view('atmreport.index', compact('atmreports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $user = Auth::user()->id;

        return view('atmreport.create', compact('consultants', 'nurses', 'pastconsults','LabTests','lab'));

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


    public function searchreporter()
    {
        $cities = City::all();
        $states = State::all();
        $countries = Country::all();
        $insurances = Insurance::all();
        $vendors = Vendor::all();
        $departments = Department::all();
        $atmreports= CallLog::all()->sortByDesc("created_at");
        return view('atmreport.searchvaries', compact('atmreports','vendors','insurances','countries','departments','states','cities'));
    }

    public function viewReporter(Request $request)
    {
//return $request->all();

        $vendor_id=$request['vendor_id'];
        $region=$request['region'];
        $state_id=$request['state_id'];
        $status=$request['status'];
        $to_date=$request['to_date'];
        $from_date=$request['from_date'];

        if ($region==''&& $status=='' && $state_id=='' && $vendor_id==''){

            $atmreports= CallLog::Where('created_at','>=', $from_date)
                ->Where('created_at','<=', $to_date)
                ->get();
        }

        if ($region !='' && $status=='' && $state_id=='' && $vendor_id==''){

            $atmreports= CallLog::Where('region', '=', $region)
                ->Where('created_at','>=', $from_date)
                ->Where('created_at','<=', $to_date)
                ->get();
        }

        if ($region !='' && $status!='' && $state_id=='' && $vendor_id==''){

            $atmreports= CallLog::Where('region', '=', $region)
                ->Where('request_status', '=', $status)
                ->Where('created_at','>=', $from_date)
                ->Where('created_at','<=', $to_date)
                ->get();
        }
        if ($region !='' && $status!='' && $state_id!='' && $vendor_id==''){

            $atmreports= CallLog::Where('region', '=', $region)
                ->Where('request_status', '=', $status)
                ->Where('atm_state', 'LIKE', $state_id)
                ->Where('created_at','>=', $from_date)
                ->Where('created_at','<=', $to_date)
                ->get();
        }

        if ($region !='' && $status!='' && $state_id !='' && $vendor_id !='') {

            $atmreports = CallLog::Where('region', '=', $region)
                ->Where('vendor_id', '=', $vendor_id)
                ->Where('request_status', '=', $status)
                ->Where('created_at', '>=', $from_date)
                ->Where('created_at', '<=', $to_date)
                ->Where('atm_state', 'LIKE', $state_id)
                ->get();
        }

        if ($region =='' && $status!='' && $state_id!='' && $vendor_id !=''){

            $atmreports = CallLog::Where('vendor_id', '=', $vendor_id)
                ->Where('request_status', '=', $status)
                ->Where('created_at', '>=', $from_date)
                ->Where('created_at', '<=', $to_date)
                ->Where('atm_state', 'LIKE', $state_id)
                ->get();
        }
        if ($region =='' && $status=='' && $state_id!='' && $vendor_id !=''){

            $atmreports = CallLog::Where('vendor_id', '=', $vendor_id)
                ->Where('atm_state', 'LIKE', $state_id)
                ->Where('created_at', '>=', $from_date)
                ->Where('created_at', '<=', $to_date)
                ->get();
        }
        if ($region =='' && $status=='' && $state_id=='' && $vendor_id !=''){

            $atmreports = CallLog::Where('vendor_id', '=', $vendor_id)
                ->Where('created_at', '>=', $from_date)
                ->Where('created_at', '<=', $to_date)
                ->get();
        }

        if ($region =='' && $status=='' && $state_id!='' && $vendor_id ==''){

            $atmreports = CallLog::Where('atm_state', '=', $state_id)
                ->Where('created_at', '>=', $from_date)
                ->Where('created_at', '<=', $to_date)
                ->get();
        }
        if ($region =='' && $status!='' && $state_id=='' && $vendor_id ==''){

            $atmreports = CallLog::Where('request_status', '=', $status)
                ->Where('created_at', '>=', $from_date)
                ->Where('created_at', '<=', $to_date)
                ->get();
        }

        //        all()->sortByDesc("created_at");
//        $atmreports= CallLog::all()->sortByDesc("created_at");
        return view('atmreport.viewvaries', compact('atmreports'));

//        return view('atmreport.viewvaries');// compact('atmreports','vendors','insurances','countries','departments','states','cities'));
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
    }
}

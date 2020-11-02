<?php

namespace App\Http\Controllers;

use App\BankData;
use App\CallLog;
use Carbon\Carbon;
use App\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceLevelAggrementController extends Controller
{
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


    public function searchslareport()
    {
        $user = Auth::user()->id;

        $vendors = Vendor::all();

        $atmreports= CallLog::all()->sortByDesc("created_at");
        return view('sla.searchvaries', compact('atmreports','vendors'));
    }

    public function viewSLAReport(Request $request)
    {

        $vendor_id=$request['vendor_name'];
        $from_date=$request['from_date'];
        $to_date=$request['to_date'];

        $start = ' 00:00:00';
        $end = ' 23:59:55';
        $start_date = $from_date . $start;
        $end_date = $to_date . $end;

        $atmreports= CallLog::Where('request_status','=', 'RESOLVED')
            ->Where('vendor_name','=', $vendor_id)
            ->Where('mail_at','>=', $start_date)
            ->Where('mail_at','<=', $end_date)
            ->Where('request_status','=', 'RESOLVED')
            ->get()->sortByDesc("created_at");
        //        all()->sortByDesc("created_at");
//        $atmreports= CallLog::all()->sortByDesc("created_at");
        return view('sla.viewvaries', compact('atmreports'));

//        return view('vendorreport.viewvaries');// compact('atmreports','vendors','insurances','countries','departments','states','cities'));
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

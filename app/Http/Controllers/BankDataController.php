<?php

namespace App\Http\Controllers;

use App\CallLog;
use Session;
use App\BankData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankDataController extends Controller
{

    protected $redirectTo = '/atmdata-management';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
        $vendor_id=Auth::user()->usertype;
        if( $vendor_id==0){
        $atmreports= BankData::all()->sortByDesc("created_at");

        return view('bankdata.index', compact('atmreports'));

        }
        else
            $atmreports = BankData::Where('vendor_id', '=', $vendor_id)->get();
        return view('bankdata.index', compact('atmreports'));

    }


    public function upload()
    {
        return view('bankdata.upload');
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

        return view('bankdata.create');
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
        $user = Auth::user()->id;

        BankData::create([
            'terminal_id' => $request['terminal_id'],
            'atm_name' => $request['atm_name'],
            'sol_id' => $request['sol_id'],
            'address' => $request['address'],
            'brand' => $request['brand'],
            'model' => $request['model'],
            'activation_date' => $request['activation_date'],
            'state' => $request['state'],
            'vendor_id' => $request['vendor_id'],
            'custodian_email' => $request['custodian_email'],
            'custodian_phone' => $request['custodian_phone'],
            'status' => $request['status'],
            'user_id' => $user,

        ]);

        return redirect()->intended('atmdata-management');
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
        $data = BankData::findOrFail($id);

        return view('bankdata.show', compact('data'));
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

        $atmpart = BankData::find($id);
        return view('bankdata/edit', ['atmpart' => $atmpart]);
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
        $user = Auth::user()->id;
        $input = [
            'terminal_id' => $request['terminal_id'],
            'atm_name' => $request['atm_name'],
            'sol_id' => $request['sol_id'],
            'address' => $request['address'],
            'brand' => $request['brand'],
            'model' => $request['model'],
            'activation_date' => $request['activation_date'],
            'state' => $request['state'],
            'vendor_id' => $request['vendor_id'],
            'custodian_email' => $request['custodian_email'],
            'custodian_phone' => $request['custodian_phone'],
            'status' => $request['status'],
            'user_id' => $user,
        ];


        BankData::where('id', $id)
            ->update($input);

        return redirect()->intended('/atmdata-management');
    }

    public function uploadFile(Request $request){
         $this->validate($request,['file'=> 'required']);
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

                        BankData::updateOrCreate(
                            ['terminal_id' => $importData[0]],
                            [
                                "terminal_id"=>$importData[0],
                                "sol_id"=>$importData[1],
                                "atm_name"=>$importData[2],
                                "address"=>$importData[3],
                                "vendor_name"=>$importData[4],
                                "brand"=>$importData[5],
                                "model"=>$importData[6],
                                "state"=>$importData[7],
                                "region"=>$importData[8],
                                "custodian_phone"=>$importData[9],
                                "sla_hour"=>$importData[10]

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

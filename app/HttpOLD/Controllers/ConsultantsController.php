<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Consultant;
use App\ConsultantAppointment;
use App\ConsultantAttendTo;
use App\ConsultantDental;
use App\ConsultantLaboratory;
use App\ConsultantNurse;
use App\ConsultantPhamacy;
use App\Drugpresentation;
use App\Http\Requests\CreateConsultant;
use App\LabBloodGroup;
use App\LabBloodMicrofilaria;
use App\LabDiffWhiteBloodCell;
use App\LabErythrocyteSedimentationRate;
use App\LabHaemoglobin;
use App\LabMalarialParasite;
use App\Laboratory;
use App\LaboratoryTest;
use App\LabPregnacyTest;
use App\LabStoolAnalysis;
use App\LabUrinalysis;
use App\LabUrineMicroscopy;
use App\LabVDRL;
use App\LabWhiteBloodCell;
use App\LabWidalTest;
use App\NurseTest;
use App\Product;
use App\Pvc;
use App\Status;
use App\Patient;
use App\Strength;
use App\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConsultantsController extends Controller
{
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
    //    $statuses = Status::all();
        $statuses = Status::all()->where("consulting",1);
    //$statuses= Status::where("department_id",3)->all();
        $consultants= Consultant::all()->sortByDesc("created_at");


        return view('consultants.index', compact('consultants', 'statuses'));
       // return view('consultants.index', compact('consultants'));
    }


    public function toBeAttendedTo(Request $request)
    {
        $user=Auth::user()->id;
        $consultants = ConsultantAttendTo::all()->Where('user_id', '=', $user )
            ->Where('attend_to', '=', 1 )->count();
       if ($consultants == 0){

        // return $request->all();
        $status_id=$request['status_id'];
        $input = [
            'consulting' => 2,
        ];
        Status::where('id', "$status_id")
            ->update($input);

        $patient_id = DB::table("statuses")->where("id", "$status_id")->pluck("patient_id")->first();

        ConsultantAttendTo::create([

            'patient_id' => $patient_id,
            'user_id' => $request['user_id'],
            'attend_to' => '1',
            'status_id' => $request['status_id'],
        ]);
            return redirect('doc-management/create');
    } else
       {
           return redirect('doc-management')->withErrorMessage('You have one patient form yet to commplete! ');

//           return redirect('doc-management/create');
//           Session::flash('error_message','You have one patient yet to attend!!!');
//           return redirect('doc-management');
       }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user()->id;
         $patient_id = DB::table("consultant_attend_tos")->where("user_id", $user)
            ->where("attend_to", 1)->pluck("patient_id")->first();

//      $nurses = NurseTest::all()->Where('patient_id', '=', $patient_id);

        //return
        $nurses = NurseTest::Where('patient_id', '=', $patient_id)->orderBy('created_at', 'desc')->first();
        $pastconsults = Consultant::Where('patient_id', '=', $patient_id)
            ->orderBy('created_at', 'desc')->get();

        $consultants = ConsultantAttendTo::all()->Where('user_id', '=', $user)
            ->Where('attend_to', '=', 1);

        $lab = Laboratory::Where('patient_id', '=', $patient_id) ->orderBy('created_at', 'desc')->first();
    //    return   $lab->id;
        if ($lab != '') {

//            $viewdwbc  = LabDiffWhiteBloodCell::all()->Where('is_status', '=', '2' )
//                ->Where('patient_id', '=', $patient_id )
//                ->where('created_at', '>=', Carbon::today());


            $LabTests = LaboratoryTest::Where('laboratory_id', '=', $lab->id)->orderBy('created_at', 'desc')->get();

            $viewpvc =  Pvc::where('patient_id', '=', $lab->patient_id)->orderBy('id', 'desc')->first();
            $viewhb =  LabHaemoglobin::where('patient_id', '=', $lab->patient_id)->orderBy('id', 'desc')->first();
            $viewwbc =  LabWhiteBloodCell::where('patient_id', '=', $lab->patient_id)->orderBy('id', 'desc')->first();
            $viewdwbc =  LabDiffWhiteBloodCell::where('patient_id', '=', $lab->patient_id)->orderBy('id', 'desc')->first();
            $viewesr =  LabErythrocyteSedimentationRate::where('patient_id', '=', $lab->patient_id)->orderBy('id', 'desc')->first();
            $viewmp =  LabMalarialParasite::where('patient_id', '=', $lab->patient_id)->orderBy('id', 'desc')->first();
            $viewwt =  LabWidalTest::where('patient_id', '=', $lab->patient_id)->orderBy('id', 'desc')->first();
            $viewbg =  LabBloodGroup::where('patient_id', '=', $lab->patient_id)->orderBy('id', 'desc')->first();
            $viewvdrl =  LabVDRL::where('patient_id', '=', $lab->patient_id)->orderBy('id', 'desc')->first();
            $viewbm =  LabBloodMicrofilaria::where('patient_id', '=', $lab->patient_id)->orderBy('id', 'desc')->first();
            $viewum =  LabUrineMicroscopy::where('patient_id', '=', $lab->patient_id)->orderBy('id', 'desc')->first();
            $viewua =  LabUrinalysis::where('patient_id', '=', $lab->patient_id)->orderBy('id', 'desc')->first();
            $viewpt =  LabPregnacyTest::where('patient_id', '=', $lab->patient_id)->orderBy('id', 'desc')->first();
            $viewsa =  LabStoolAnalysis::where('patient_id', '=', $lab->patient_id)->orderBy('id', 'desc')->first();

            return view('consultants.create', compact('consultants', 'nurses', 'pastconsults', 'LabTests','lab','viewpvc','viewhb'
            ,'viewwbc','viewdwbc','viewesr','viewmp','viewwt','viewbg','viewvdrl','viewbm','viewum','viewua','viewpt','viewsa'


            ));
        } else {
            return view('consultants.create', compact('consultants', 'nurses', 'pastconsults','LabTests','lab'));
        }
    }
//    public function autocomplete()
//    {
////        return view('consultants.autocomplete');
//        return view('consultants.autocomplete2');
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateConsultant $request)
    {
        //
//        return $request->all();
//return $request->all();
        $consultant_id = Consultant::create([

            'patient_id' => $request['patient_id'],
            'user_id' => $request['user_id'],
            'note' => $request['note'],
            'diagnosis' => $request['diagnosis'],
            'status_id' => $request['status_id']
        ]);

        $lastInsertedId = $consultant_id->id;
//        return $lastInsertedId;

        $status_id = $request['status_id'];
        $input = [
            'consultant_id' => $lastInsertedId,
            'consulting' => 3,
        ];
        Status::where('id', "$status_id")
            ->update($input);


        if ($request['dentals_note'] != '') {
            ConsultantDental::create([

                'consultant_id' => $lastInsertedId,
                'dentals_note' => $request['dentals_note'],
                'patient_id' => $request['patient_id'],
                'user_id' => $request['user_id']
            ]);

            $status_id = $request['status_id'];
            $input = [
                'dental' => 1,
            ];
            Status::where('id', "$status_id")
                ->update($input);

        }
        if ($request['lab_test'] != '') {
            ConsultantLaboratory::create([
                'consultant_id' => $lastInsertedId,
                'lab_test' => $request['lab_test'],
                'patient_id' => $request['patient_id'],
                'user_id' => $request['user_id']
            ]);
            $status_id = $request['status_id'];
            $input = [
                'laboratory' => 1,
            ];
            Status::where('id', "$status_id")
                ->update($input);
        }

        if ($request['nurse_note'] != '') {
            ConsultantNurse::create([
                'consultant_id' => $lastInsertedId,
                'nurse_note' => $request['nurse_note'],
                'patient_id' => $request['patient_id'],
                'user_id' => $request['user_id']
            ]);
            $status_id = $request['status_id'];
            $input = [
                'nurse' => 1,
            ];
            Status::where('id', "$status_id")
                ->update($input);

        }
        if ($request['scheduler_date'] != '') {
            ConsultantAppointment::create([
                'consultant_id' => $lastInsertedId,
                'patient_id' => $request['patient_id'],
                'scheduler_date' => $request['scheduler_date'],
                'schedule_notes' => $request['schedule_notes'],
                'user_id' => $request['user_id']
            ]);
        }
//FOR DRUG DISPENSORY
        if ($request['countryname'][0] != '' || $request['countryname'][0] != null) {
            $itrate = $request['countryname'];
            $count1 = count($itrate);

            if ($count1 != '') {
                $drug = $request['countryname'];
                $counter = count($drug);
                for ($i = 0; $i < $counter; ++$i) {
                    ConsultantPhamacy::create([
                        'consultant_id' => $lastInsertedId,
                        'drug_name' => $request['countryname'][$i],
                        'drug_dosage' => $request['country_code'][$i],
                        'patient_id' => $request['patient_id']
                    ]);
                }

                $status_id = $request['status_id'];
                $input = [
                    'pharmacy' => 1,
                ];
                Status::where('id', "$status_id")
                    ->update($input);
            }
        }

            //Check out from Doctor, change status to 0 after Diagnosis
            $to_attend = $request['to_attend'];

            $input = [
                'attend_to' => 2,
            ];
            ConsultantAttendTo::where('id', "$to_attend")
                ->update($input);
            return redirect('doc-management');


    }    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $consultant = Consultant::findOrFail($id);

            $pharms =  ConsultantPhamacy::where('consultant_id', '=', $consultant->id)->get();
     $labs =  ConsultantLaboratory::where('consultant_id', '=', $consultant->id)->get();


        return view('consultants.show', compact('consultant','pharms','labs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $consultant=Consultant::findOrFail($id);

        $product= Product::pluck('name', 'id')->all();
        $category= Category::pluck('name', 'id')->all();
        $supplier= Supplier::pluck('name', 'id')->all();
        $brand= Brand::pluck('name', 'id')->all();


        return view('consultants.edit', compact('consultant','product','category','supplier','brand'));

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $consultant = Consultant::findOrFail($id);

        $pharms =  ConsultantPhamacy::where('consultant_id', '=', $consultant->id)->get();
        $labs =  ConsultantLaboratory::where('consultant_id', '=', $consultant->id)->get();


        $pharms->delete();
        $labs->delete();
        $consultant->delete();
        // Session::flash('deleted_stock', 'Successfully deleted');
        return redirect('doc-management')->withSuccessMessage('Successfully deleted! ');

    }
}

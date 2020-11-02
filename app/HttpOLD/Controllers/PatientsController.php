<?php

namespace App\Http\Controllers;

use App\Department;
use App\Http\Requests\PatientsCreateRequest;
use App\Patient;
use App\PatientAccount;
use App\PatientExpense;
use App\Status;
use Illuminate\Http\Request;
use App\City;
use App\State;
use App\Country;
use App\Insurance;
use Illuminate\Support\Facades\DB;

class PatientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $patients= Patient::all()->sortByDesc("created_at");


        return view('patients.index', compact('patients'));
   }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $cities = City::all();
        $states = State::all();
        $countries = Country::all();
        $insurances = Insurance::all();
//        $statuses = Status::all();
        $departments = Department::all();
//        $departments = Department::orderBy('name', 'desc')->value("id");
    //    $divisions = Division::all();
//  return view('patients/create');
       return view('patients/create', ['cities' => $cities, 'states' => $states,
           'countries' => $countries, 'insurances' => $insurances, 'departments' => $departments]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatientsCreateRequest $request)
    {

        //  return $request->all();
        $patient_id=  Patient::create($request->all());
         $patient_id->id;
     //   $lastPatientNO = Patient::orderBy('id', 'desc')->value("id");
           $lastPatientNO = $patient_id->id;
        $insurance_id=$request['insurance_id'];
        $regfee=$request['regfee'];
        $department= $request['department'] ;

        if($insurance_id >= 1 || ($insurance_id == 0 && $department == 3) ) {

            if ($request['department'] == '1') {
           $last_status= Status::create([
                'patient_id' => $lastPatientNO,
                'insurance_id' => $insurance_id,
                'nurse' => '1'
            ]);

            $id_status=$last_status->id;
            PatientExpense::create([
                'status_id' => $id_status,
                'registration' => $regfee,
                'patient_id' => $lastPatientNO,
            ]);

//            PatientAccount::create([
//                'patient_id' => $lastPatientNO,
//                'regfee' => $regfee,
//                'status_id' => $id_status,
//
//            ]);

        }

        if ($request['department'] == '2') {

            $last_status= Status::create([
                'patient_id' => $lastPatientNO,
                'insurance_id' => $insurance_id,
                'dental' => 1
            ]);
            $id_status=$last_status->id;
            PatientExpense::create([
                'status_id' => $id_status,
                'registration' => $regfee,
                'patient_id' => $lastPatientNO,

            ]);
//            PatientAccount::create([
//                'patient_id' => $lastPatientNO,
//                'regfee' => $regfee,
//                'status_id' => $id_status,
//
//            ]);
        }

        if ($request['department'] == '3') {

            $last_status= Status::create([
                'patient_id' => $lastPatientNO,
                'insurance_id' => $insurance_id,
                'laboratory' => 1
            ]);
            $id_status=$last_status->id;
            PatientExpense::create([
                'status_id' => $id_status,
                'registration' => $regfee,
                'patient_id' => $lastPatientNO,

            ]);
//            PatientAccount::create([
//                'patient_id' => $lastPatientNO,
//                'regfee' => $regfee,
//                'status_id' => $id_status,
//
//            ]);
        }

        if ($request['department'] == '4') {

            $last_status=Status::create([
                'patient_id' => $lastPatientNO,
                'insurance_id' => $insurance_id,
                'consulting' => 1
            ]);

            $id_status=$last_status->id;
            PatientExpense::create([
                'status_id' => $id_status,
                'registration' => $regfee,
                'patient_id' => $lastPatientNO,

            ]);
//            PatientAccount::create([
//                'patient_id' => $lastPatientNO,
//                'regfee' => $regfee,
//                'status_id' => $id_status,
//
//            ]);
        }

        if ($request['department'] == '5') {

            $last_status= Status::create([
                'patient_id' => $lastPatientNO,
                'insurance_id' => $insurance_id,
                'pharmacy' => 1
            ]);
            $id_status=$last_status->id;
            PatientExpense::create([
                'status_id' => $id_status,
                'registration' => $regfee,
                'patient_id' => $lastPatientNO,

            ]);
//            PatientAccount::create([
//                'patient_id' => $lastPatientNO,
//                'regfee' => $regfee,
//                'status_id' => $id_status,
//
//            ]);
        }

        if ($request['department'] == '6') {
            $last_status=Status::create([
                'patient_id' => $lastPatientNO,
                'insurance_id' => $insurance_id,
                'accounting' => 1
            ]);
            $id_status=$last_status->id;
            PatientExpense::create([
                'status_id' => $id_status,
                'registration' => $regfee,
                'patient_id' => $lastPatientNO,

            ]);
//            PatientAccount::create([
//                'patient_id' => $lastPatientNO,
//                'regfee' => $regfee,
//                'status_id' => $id_status,
//
//            ]);
        }

        if ($request['department'] == '7') {
            $last_status=Status::create([
                'patient_id' => $lastPatientNO,
                'insurance_id' => $insurance_id,
                'gynaecology' => 1
            ]);
            $id_status=$last_status->id;
            PatientExpense::create([
                'status_id' => $id_status,
                'registration' => $regfee,
                'patient_id' => $lastPatientNO,

            ]);
//            PatientAccount::create([
//                'patient_id' => $lastPatientNO,
//                'regfee' => $regfee,
//                'status_id' => $id_status,
//
//            ]);
        }

        if ($request['department'] == '8') {
            $last_status=Status::create([
                'patient_id' => $lastPatientNO,
                'insurance_id' => $insurance_id,
                'antenatal' => 1
            ]);
            $id_status=$last_status->id;
            PatientExpense::create([
                'status_id' => $id_status,
                'registration' => $regfee,
                'patient_id' => $lastPatientNO,

            ]);
//            PatientAccount::create([
//                'patient_id' => $lastPatientNO,
//                'regfee' => $regfee,
//                'status_id' => $id_status,
//
//            ]);
        }

        if ($request['department'] == '9') {
            $last_status=Status::create([
                'patient_id' => $lastPatientNO,
                'insurance_id' => $insurance_id,
                'physiotherapy' => 1
            ]);
            $id_status=$last_status->id;
            PatientExpense::create([
                'status_id' => $id_status,
                'registration' => $regfee,
                'patient_id' => $lastPatientNO,

            ]);
//            PatientAccount::create([
//                'patient_id' => $lastPatientNO,
//                'regfee' => $regfee,
//                'status_id' => $id_status,
//            ]);
        }

        if ($request['department'] == '10') {
            $last_status=Status::create([
                'patient_id' => $lastPatientNO,
                'insurance_id' => $insurance_id,
                'cardiology' => 1
            ]);
            $id_status=$last_status->id;
            PatientExpense::create([
                'status_id' => $id_status,
                'registration' => $regfee,
                'patient_id' => $lastPatientNO,

            ]);
//            PatientAccount::create([
//                'patient_id' => $lastPatientNO,
//                'regfee' => $regfee,
//                'status_id' => $id_status,
//            ]);
        }
        //return $request->all();
        return redirect('/patient-management');

        }
        else {

            return redirect('patient-management')->withErrorMessage('Sorry, You can Only Send Patient to Laboratory!');

        }
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
        $patient = Patient::findOrFail($id);

        return view('patients.show', compact('patient'));
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
        $patient = Patient::find($id);
        // Redirect to user list if updating user wasn't existed

        $cities = City::all();
        $states = State::all();
        $countries = Country::all();
        $insurances = Insurance::all();
//        $statuses = Status::all();
        $departments = Department::all();
        //    $divisions = Division::all();
//  return view('patients/create');

        if ($patient == null || count($patient) == 0) {
            return redirect()->intended('/patient-management');
        }

        return view('patients/edit', ['patient' => $patient,'cities' => $cities, 'states' => $states,
            'countries' => $countries, 'insurances' => $insurances, 'departments' => $departments]);
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
      // return $request->all();
        //
        $patient = Patient::findOrFail($id);
        $input = [
            'family_id' => $request['family_id'],
            'surname' => $request['surname'],
            'firstname' => $request['firstname'],
            'address' => $request['address'],
            'city_id' => $request['city_id'],
            'state_id' => $request['state_id'],
            'country_id' => $request['country_id'],
            'phone' => $request['phone'],
            'phone2' => $request['phone2'],
            'insurance_id' => $request['insurance_id'],
            'birthdate' => $request['birthdate'],
            'email' => $request['email'],
            'gender' => $request['gender'],
            'nok' => $request['nok'],
            'nokphone' => $request['nokphone'],
        ];
        $this->validate($request, [
            'surname' => 'required',
            'firstname' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'insurance_id' => 'required',

        ]);
        Patient::where('id', $id)
            ->update($input);

        return redirect()->intended('patient-management');

    }

    public function checkIn($id)
    {
        //
        $patients = Patient::find($id);
        $insurances = Insurance::all();
//        $statuses = Status::all();
        $departments = Department::all();
        //    $divisions = Division::all();
//  return view('patients/create');

        if ($patients == null || count($patients) == 0) {
            return redirect()->intended('/patient-management');
        }

        return view('patients/checkin', ['patients' => $patients,
           'insurances' => $insurances, 'departments' => $departments]);
    }

    public function updateCheckIn(Request $request)

    {
       $pat_id= $request['patient_id'];
        $count = DB::table("statuses")->where('patient_id', '=', "$pat_id")
            ->where('checkout', '!=', 2)->count();

        $consultfee=$request['consultfee'];
        $department = $request['department'];

       $insure_id= Patient::where('id', $pat_id)->pluck('insurance_id')->all();
        $insure_id= $insure_id[0];
//        return $count;
        if($insure_id >= 1 || ($insure_id == 0 && $department == 3) ) {



        if($count == 0 ){


        if ($request['department'] == '1') {
            $last_status=   Status::create([
                'patient_id' => $request['patient_id'],
                'insurance_id' => $request['insurance_id'],
                'nurse' => '1'
            ]);
            $id_status=$last_status->id;
            PatientExpense::create([
                'status_id' => $id_status,
                'consulting' => $consultfee,
                'patient_id' => $pat_id,

            ]);
//            PatientAccount::create([
//                'patient_id' => $pat_id,
//                'consultfee' => $consultfee,
//                'status_id' => $id_status,
//            ]);
        }
        if ($request['department'] == '2') {

            $last_status= Status::create([
                'patient_id' => $request['patient_id'],
                'insurance_id' => $request['insurance_id'],
                'dental' => 1
            ]);
            $id_status=$last_status->id;
            PatientExpense::create([
                'status_id' => $id_status,
                'consulting' => $consultfee,
                'patient_id' => $pat_id,

            ]);
//            PatientAccount::create([
//                'patient_id' => $pat_id,
//                'consultfee' => $consultfee,
//                'status_id' => $id_status,
//            ]);
        }
        if ($request['department'] == '3') {

            $last_status=  Status::create([
                'patient_id' => $request['patient_id'],
                'insurance_id' => $request['insurance_id'],
                'laboratory' => 1
            ]);
            $id_status=$last_status->id;
            PatientExpense::create([
                'status_id' => $id_status,
                'consulting' => $consultfee,
                'patient_id' => $pat_id,

            ]);
//            PatientAccount::create([
//                'patient_id' => $pat_id,
//                'consultfee' => $consultfee,
//                'status_id' => $id_status,
//            ]);
        }

        if ($request['department'] == '4') {

            $last_status=Status::create([
                'patient_id' => $request['patient_id'],
                'insurance_id' => $request['insurance_id'],
                'consulting' => 1
            ]);
            $id_status=$last_status->id;
            PatientExpense::create([
                'status_id' => $id_status,
                'consulting' => $consultfee,
                'patient_id' => $pat_id,

            ]);
//            PatientAccount::create([
//                'patient_id' => $pat_id,
//                'consultfee' => $consultfee,
//                'status_id' => $id_status,
//            ]);
        }

        if ($request['department'] == '5') {

            $last_status=Status::create([
                'patient_id' => $request['patient_id'],
                'insurance_id' => $request['insurance_id'],
                'pharmacy' => 1
            ]);
            $id_status=$last_status->id;
            PatientExpense::create([
                'status_id' => $id_status,
                'consulting' => $consultfee,
                'patient_id' => $pat_id,

            ]);
//            PatientAccount::create([
//                'patient_id' => $pat_id,
//                'consultfee' => $consultfee,
//                'status_id' => $id_status,
//            ]);
        }

        if ($request['department'] == '6') {
            $last_status= Status::create([
                'patient_id' => $request['patient_id'],
                'insurance_id' => $request['insurance_id'],
                'accounting' => 1
            ]);
            $id_status=$last_status->id;
            PatientExpense::create([
                'status_id' => $id_status,
                'consulting' => $consultfee,
                'patient_id' => $pat_id,

            ]);
//            PatientAccount::create([
//                'patient_id' => $pat_id,
//                'consultfee' => $consultfee,
//                'status_id' => $id_status,
//            ]);
        }

        if ($request['department'] == '7') {
            $last_status= Status::create([
                'patient_id' => $request['patient_id'],
                'insurance_id' => $request['insurance_id'],
                'gynaecology' => 1
            ]);
            $id_status=$last_status->id;
            PatientExpense::create([
                'status_id' => $id_status,
                'consulting' => $consultfee,
                'patient_id' => $pat_id,

            ]);
//            PatientAccount::create([
//                'patient_id' => $pat_id,
//                'consultfee' => $consultfee,
//                'status_id' => $id_status,
//            ]);
        }

        if ($request['department'] == '8') {
            $last_status=  Status::create([
                'patient_id' => $request['patient_id'],
                'insurance_id' => $request['insurance_id'],
                'antenatal' => 1
            ]);
            $id_status=$last_status->id;
            PatientExpense::create([
                'status_id' => $id_status,
                'consulting' => $consultfee,
                'patient_id' => $pat_id,

            ]);
//            PatientAccount::create([
//                'patient_id' => $pat_id,
//                'consultfee' => $consultfee,
//                'status_id' => $id_status,
//            ]);
        }

        if ($request['department'] == '9') {
            $last_status=Status::create([
                'patient_id' => $request['patient_id'],
                'insurance_id' => $request['insurance_id'],
                'physiotherapy' => 1
            ]);
            $id_status=$last_status->id;
            PatientExpense::create([
                'status_id' => $id_status,
                'consulting' => $consultfee,
                'patient_id' => $pat_id,

            ]);
//            PatientAccount::create([
//                'patient_id' => $pat_id,
//                'consultfee' => $consultfee,

//            ]);
        }

        if ($request['department'] == '10') {
            $last_status= Status::create([
                'patient_id' => $request['patient_id'],
                'insurance_id' => $request['insurance_id'],
                'cardiology' => 1
            ]);
            $id_status=$last_status->id;
            PatientExpense::create([
                'status_id' => $id_status,
                'consulting' => $consultfee,
                'patient_id' => $pat_id,

            ]);
//            PatientAccount::create([
//                'patient_id' => $pat_id,
//                'consultfee' => $consultfee,
//                'status_id' => $id_status,
//            ]);
        }
        //return $request->all();
        return redirect('/patient-management')->withSuccessMessage('Patient Check In!');

        }
        else{

            return redirect('patient-management')->withErrorMessage('Sorry, Patient already check in or still on admission, or yet to check out!');
        }
        }
        else {

            return redirect('patient-management')->withErrorMessage('Sorry, You can Only check in to Laboratory!');

        }
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

    public function search(Request $request) {
        $constraints = [
            'surname' => $request['surname'],
            'firstname' => $request['firstname']
        ];

        $patients = $this->doSearchingQuery($constraints);
        return view('patients/index', ['patients' => $patients, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = Patient::query();
        $fields = array_keys($constraints);
        $index = 0;
        foreach ($constraints as $constraint) {
            if ($constraint != null) {
                $query = $query->where( $fields[$index], 'like', '%'.$constraint.'%');
            }

            $index++;
        }
        return $query->paginate(5);
    }
    private function validateInput($request) {
        $this->validate($request, [
            'name' => 'required|max:60|unique:patient',

        ]);
    }



}

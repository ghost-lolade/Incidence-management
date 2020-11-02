<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Supplier;

class SuppliersController extends Controller
{
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/supplier-management';

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::paginate(5);

        return view('suppliers-mgmt/index', ['suppliers' => $suppliers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('suppliers-mgmt/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateInput($request);
        Supplier::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'address' => $request['address'],
            'website' => $request['website'],
            'contact_name' => $request['contact_name'],
            'state' => $request['state'],
            'lga' => $request['lga'],
            'country' => $request['country']
        ]);

        return redirect()->intended('/supplier-management');
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
        $supplier = Supplier::find($id);
        // Redirect to user list if updating user wasn't existed
        if ($supplier == null || count($supplier) == 0) {
            return redirect()->intended('/supplier-management');
        }

        return view('suppliers-mgmt/edit', ['supplier' => $supplier]);
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
        $supplier = Supplier::findOrFail($id);
       // $this->validateInput($request);
        $input = [
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'address' => $request['address'],
            'website' => $request['website'],
            'contact_name' => $request['contact_name'],
            'state' => $request['state'],
            'lga' => $request['lga'],
            'country' => $request['country']

        ];

        $this->validateInput($request, $input);
        Supplier::where('id', $id)
            ->update($input);

        return redirect()->intended('/supplier-management');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Supplier::where('id', $id)->delete();
        return redirect()->intended('/supplier-management');
    }

    /**
     * Search supplier from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'name' => $request['name'],
            'contact_name' => $request['contact_name'],
            'country' => $request['country'],
            'state' => $request['state']
        ];

        $suppliers = $this->doSearchingQuery($constraints);
        return view('suppliers-mgmt/index', ['suppliers' => $suppliers, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = Supplier::query();
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
            'name' => 'required|max:120',
            'email' => 'required|email|max:255|unique:suppliers',
            'country' => 'required|max:60',
            'phone' => 'required|max:60',
            'address' => 'required|max:60',
            'website' => 'required|max:60',
            'contact_name' => 'required|max:60',
            'state' => 'required|max:60',
            'lga' => 'required|max:60'

        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\BankData;
use App\CustomerEngineer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerEngineerController extends Controller
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
        $vendor_id=Auth::user()->user_no;
        $cedatas= CustomerEngineer::get();
        return view('customer-engineer.index', compact('cedatas'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer-engineer/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $vendor_id=Auth::user()->user_no;

        CustomerEngineer::create([
            'name' => $request['name'],
            'mobile' => $request['mobile'],
            'email_address' => $request['email_address'],
            'vendor_id' => $vendor_id,
            'level' => $request['level'],
            'state' => $request['state'],
             ]);
       // CustomerEngineer::create($request->all());

        return redirect()->intended('engineer-management');
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
        $cedata = CustomerEngineer::findOrFail($id);

        return view('customer-engineer.show', compact('cedata'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cedata = CustomerEngineer::find($id);
        // Redirect to user list if updating user wasn't existed


        return view('customer-engineer/edit', ['cedata' => $cedata]);


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
        $input = [
            'name' => $request['name'],
            'mobile' => $request['mobile'],
            'email_address' => $request['email_address'],
            'level' => $request['level'],
            'state' => $request['state'],
        ];

        CustomerEngineer::where('id', $id)
            ->update($input);
        return redirect()->intended('engineer-management');
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

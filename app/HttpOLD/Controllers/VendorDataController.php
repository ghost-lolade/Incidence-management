<?php

namespace App\Http\Controllers;

use App\VendorData;

use App\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class VendorDataController extends Controller
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
        $cedatas= VendorData::get();
        return view('vendor-data.index', compact('cedatas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $cedata=Brand::get();

        return view('vendor-data/create', ['cedata' => $cedata]);
//        return view('vendor-data/create');

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
       // $vendor_id=Auth::user()->user_no;

//        CustomerEngineer::create([
//            'name' => $request['name'],
//            'mobile' => $request['mobile'],
//            'email' => $request['email'],
//            'vendor_id' => $request['vendor_id'],
//         //   'vendor_id' => $vendor_id,
//            'level' => $request['level'],
////            'state' => $request['state'],
//        ]);
         VendorData::create($request->all());

        return redirect()->intended('vendordata-management');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VendorData  $vendorData
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $cedata = VendorData::findOrFail($id);

        return view('vendor-data.show', compact('cedata'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VendorData  $vendorData
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $vendor=Brand::get();

        $cedata = VendorData::find($id);
        // Redirect to user list if updating user wasn't existed


        return view('vendor-data/edit', ['cedata' => $cedata,'vendor' => $vendor]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VendorData  $vendorData
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = [
            'name' => $request['name'],
            'phone' => $request['phone'],
            'email' => $request['email'],
            'level' => $request['level'],
            'vendor_id' => $request['vendor_id'],
        ];

        VendorData::where('id', $id)
            ->update($input);
        return redirect()->intended('vendordata-management');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VendorData  $vendorData
     * @return \Illuminate\Http\Response
     */
    public function destroy(VendorData $vendorData)
    {
        //
    }
}

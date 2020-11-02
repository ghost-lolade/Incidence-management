<?php

namespace App\Http\Controllers;

use App\CallLog;
use App\PMtimer;
use App\PreventiveMaintanace;
use App\Vendor;
use App\VendorPM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PreventiveMentanaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $vendor_id=Auth::user()->user_no;
        if( $vendor_id==0){
            $posts = PreventiveMaintanace::Where('quarter_first', '!=', '')->get();
            return view('preventive.index', ['posts' => $posts]);
        }
        else
        $posts = PreventiveMaintanace::Where('vendor_id', '=', $vendor_id)
            ->Where('quarter_first', '=', null)->get();
        return view('preventive.index22', ['posts' => $posts]);

    }
public function uploadPM()
    {
        //
        $images = VendorPM::get();
        return view('preventive.uploadpm',compact('images'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $vendors = Vendor::all();
//        $states = State::all();

        $states = DB::table('state')
            ->orderBy('name', 'asc')
            ->get();
        return view('preventive.create', ['vendors' => $vendors, 'states' => $states]);
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
        PMtimer::create($request->all());
        return redirect()->intended('pm-management');
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
    public function upload(Request $request)
    {
        $this->validate($request, [
            'terminal_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        $input['image'] = $request->terminal_id.'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('images'), $input['image']);


        $input['terminal_id'] = $request->terminal_id;
        VendorPM::create($input);


        return back()
            ->with('success','Image Uploaded successfully.');
    }


    /**
     * Remove Image function
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        VendorPM::find($id)->delete();
        return back()
            ->with('success','Image removed successfully.');
    }

}

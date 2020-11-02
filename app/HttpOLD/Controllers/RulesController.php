<?php

namespace App\Http\Controllers;

use App\Rules;
use App\State;
use App\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $rules = Rules::all();
        $vendor = Vendor::all();
        $states = DB::table('state')
            ->orderBy('name', 'asc')
            ->get();
        return view('sla_rules.index', ['rules' => $rules, 'vendor' => $vendor,'states' => $states]);
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
        return view('sla_rules.create', ['vendors' => $vendors, 'states' => $states]);
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
        Rules::create([
            'vendor_id' => $request['vendor_id'],
            'state_id' => $request['state_id'],
            'response_time' => $request['response_time'],
            'repair_time' => $request['repair_time']
        ]);

        return redirect()->intended('sla-management');
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
        if($request->vendor !=''){
            $post = Rules::findOrFail($id);
//            $post->terminal_id = $request->title;
            $post->vendor_id = $request->vendor;
            $post->state_id = $request->state;
            $post->response_time = $request->response_time;
            $post->repair_time = $request->repair_time;
            $post->save();
            return response()->json($post);
//        redirect('posts.index');
        }
        if($request->suspend_comment !=''){
            $post = Rules::findOrFail($id);
            $post->suspend_comment = $request->suspend_comment;
//            $post->picture = $request->picture;
            $post->request_status = 'Suspended';
            $post->save();

            if ($request->file('picture')) {
                $path = $request->file('picture')->store('avatars');
                $post['picture'] = $path;
            }

            Rules::where('id', $id)
                ->update($post);



            return response()->json($post);
        }
        //ASSIGN CALL TO CE
        if($request->assign_ce !=''){
            $post = CallLog::findOrFail($id);
            $post->ce_name = $request->assign_ce;
            $post->ce_status = $request->ce_status;
            $post->ce_arrival_time = $request->ce_arrival_time;
            $post->save();
            return response()->json($post);
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
        $rule = Rules::findOrFail($id);
        $rule->delete();

        return response()->json($rule);
    }

    public function changeStatusRule()
    {
        $id = Input::get('id');

        $rule = Rules::findOrFail($id);
        $rule->is_published = !$rule->is_published;
        $rule->save();

        return response()->json($post);
    }


}

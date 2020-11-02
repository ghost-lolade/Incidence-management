<?php

namespace App\Http\Controllers;

use App\Strength;
use Illuminate\Http\Request;

class StrengthsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $redirectTo = '/drug-strength';


    public function __construct()
    {
        $this->middleware('auth');
    }




    public function index()
    {
        //
        $strengths = Strength::paginate(5);

        return view('strengths/index', ['strengths' => $strengths]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('strengths/create');
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
        Strength::create($request->all());

        return redirect()->intended('drug-strength');
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
        $strength = Strength::find($id);
        // Redirect to country list if updating country wasn't existed
        if ($strength == null || count($strength) == 0) {
            return redirect()->intended('drug-strength/edit');
        }

        return view('strengths/edit', ['strengths' => $strength]);
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
        $strength = Strength::findOrFail($id);
        $input = [
            'name' => $request['name'],

        ];
        $this->validate($request, [
            'name' => 'required|max:60'
        ]);
        Strength::where('id', $id)
            ->update($input);

        return redirect()->intended('drug-strength');
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
        Strength::where('id', $id)->delete();
        return redirect()->intended('drug-strength');
    }

    /**
     * Search categories from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'name' => $request['name'],

        ];

        $strengths = $this->doSearchingQuery($constraints);
        return view('categories/index', ['categories' => $strengths, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = Strength::query();
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
            'name' => 'required|max:60|unique:category',

        ]);
    }
}

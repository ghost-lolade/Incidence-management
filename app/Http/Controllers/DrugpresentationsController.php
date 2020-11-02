<?php

namespace App\Http\Controllers;

use App\Drugpresentation;
use Illuminate\Http\Request;

class DrugpresentationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $redirectTo = '/drug-presentation';


    public function __construct()
    {
        $this->middleware('auth');
    }



    public function index()
    {
        //
        $presentations = Drugpresentation::paginate(5);

        return view('drugpresentations/index', ['presentations' => $presentations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('drugpresentations/create');
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
        Drugpresentation::create($request->all());

        return redirect()->intended('drug-presentation');
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
        $presentation = Drugpresentation::find($id);
        // Redirect to country list if updating country wasn't existed
        if ($presentation == null || count($presentation) == 0) {
            return redirect()->intended('drug-presentation/edit');
        }

        return view('drugpresentations/edit', ['presentations' => $presentation]);
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
        $presentation = Drugpresentation::findOrFail($id);
        $input = [
            'name' => $request['name'],

        ];
        $this->validate($request, [
            'name' => 'required|max:60'
        ]);
        Drugpresentation::where('id', $id)
            ->update($input);

        return redirect()->intended('drug-presentation');
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
        Drugpresentation::where('id', $id)->delete();
        return redirect()->intended('drug-presentation');
    }

    public function search(Request $request) {
        $constraints = [
            'name' => $request['name'],

        ];

        $presentations = $this->doSearchingQuery($constraints);
        return view('drugpresentations/index', ['presentations' => $presentations, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = Drugpresentation::query();
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

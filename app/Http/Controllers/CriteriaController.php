<?php

namespace App\Http\Controllers;

use App\Criteria;
use App\Event;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    public function __construct(){

        $this->middleware('auth:admin');
    }
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return view('criteria.index');
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create($id)
    {
        $criterias = Criteria::where('event_id', $id)->get();
        return view('criteria.create', compact('id','criterias'));
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request, $id)
    {
        $this->validate($request, [
            'criteria_name' => 'required|string',
            'percentage' => 'required|numeric'
        ]);

        $criteria = new Criteria;
        $criteria->criteria_name = $request->criteria_name;
        $criteria->percentage = $request->percentage;
        $criteria->event_id = $request->id;
        $criteria->save();

        return response([
            'message' => 'Stored!'
        ],201);
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Criteria  $criteria
    * @return \Illuminate\Http\Response
    */
    public function show(Criteria $criteria)
    {
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Criteria  $criteria
    * @return \Illuminate\Http\Response
    */
    public function edit($id, Criteria $criteria)
    {
        return $criteria;
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Criteria  $criteria
    * @return \Illuminate\Http\Response
    */
    public function update($id, Criteria $criteria, Request $request)
    {
        $this->validate($request, [
            'criteria_name' => 'required|string',
            'percentage' => 'required|numeric'
        ]);

        $criteria->criteria_name = $request->criteria_name;
        $criteria->percentage = $request->percentage;
        $criteria->save();

        return response([
            'message' => 'Updated!'
        ],201);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Criteria  $criteria
    * @return \Illuminate\Http\Response
    */
    public function destroy($id, Criteria $criteria)
    {
        $criteria->delete();

        return redirect()->route('criteria.create', $id);
    }
}

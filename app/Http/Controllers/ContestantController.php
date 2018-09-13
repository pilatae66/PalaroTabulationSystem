<?php

namespace App\Http\Controllers;

use App\Contestant;
use App\Event;
use Illuminate\Http\Request;

class ContestantController extends Controller
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
        $events = Event::all();
        $contestants = Contestant::all();
        return view('contestant.index', compact('contestants', 'events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'contestant_name' => 'required|string',
            'department' => 'required',
            'event_id' => 'required'
        ]);

        $contestant = new Contestant;
        $contestant->name = $request->contestant_name;
        $contestant->department = $request->department;
        $contestant->event_id = $request->event_id;

        $contestant->save();

        return response([
            'message' => 'Stored!'
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contestant  $contestant
     * @return \Illuminate\Http\Response
     */
    public function show(Contestant $contestant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contestant  $contestant
     * @return \Illuminate\Http\Response
     */
    public function edit(Contestant $contestant)
    {
        return $contestant;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contestant  $contestant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contestant $contestant)
    {
        $this->validate($request, [
            'contestant_name' => 'required|string',
            'department' => 'required',
            'event_id' => 'required'
        ]);

        $contestant->name = $request->contestant_name;
        $contestant->department = $request->department;
        $contestant->event_id = $request->event_id;

        $contestant->save();

        return response([
            'message' => 'Updated!'
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contestant  $contestant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contestant $contestant)
    {
        $contestant->delete();
        return redirect()->route('contestant.index');
    }
}

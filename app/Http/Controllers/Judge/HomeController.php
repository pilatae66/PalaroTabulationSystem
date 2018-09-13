<?php

namespace App\Http\Controllers\Judge;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{

    protected $redirectTo = '/judge/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('judge.auth:judge');
    }

    /**
     * Show the Judge dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard() {
        return view('judge.home');
    }

}

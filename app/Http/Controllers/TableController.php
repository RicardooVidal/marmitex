<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TableController extends Controller
{
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function tables()
    {
        if (!HomeController::checkPermission()) {
            return view ('permission');
            die();
        }

        HomeController::checkGlobalMessage();

        return view('tables.index');
    }
}

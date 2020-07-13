<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        ini_set('display_errors', 'On');
        session_start();
        $this->checkGlobalMessage();
        if (!$this->checkPermission()) {
            return view ('permission');
            die();
        }
        return view('home');
    }

    public static function checkPermission(): bool
    {
        $url = "http://ricardovidal.xyz/licencas/marmitex/marmitex.json";
        $json = file_get_contents($url);
        $json_data = json_decode($json, true);
        $use = $json_data['marmitex']['use'];

        if ($use == 'no') {
            return false;
        }

        return true;
    }

    public static function checkGlobalMessage() 
    {
        if (!isset($_SESSION['globalMessage'])) {
            $_SESSION['globalMessage'] = 0;
        }
    }
}
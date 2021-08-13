<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;

class BillingController extends Controller
{
    public function check()
    {
        return response()->json(AppHelper::checkLicense());
    }
}
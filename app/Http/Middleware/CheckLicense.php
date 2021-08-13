<?php

namespace App\Http\Middleware;

use App\Helpers\AppHelper;
use Closure;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\App;

class CheckLicense
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $result = (object) json_decode(json_encode(AppHelper::checkLicense()), true);

        $status = $result->status;
        $msg = $result->msg;

        if ($status == 'error') {
            return response()->json($msg);
        }

        return $next($request);
    }
}

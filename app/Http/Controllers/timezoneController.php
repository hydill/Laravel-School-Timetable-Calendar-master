<?php

namespace App\Http\Controllers;

use Carbon\Carbon;





use Illuminate\Http\Request;

class timezoneController extends Controller
{
    public function index()
    {

        $set_time_now = Carbon::now()->tz("Asia/Singapore");

        dd($set_time_now);

    }
}

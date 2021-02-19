<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Session;

class DashboardController extends Controller
{

    public function index()
    {
        return view('dashboard');
    }

    public function logout()
    {
        Session::forget('info_user');
        return redirect('/');
    }

    private function table_summary()
    {
        $current_date=date('Y-m-d');
        $previous_date=date('Y-m-d',strtotime($current_date.' -1 days'));
    }
}

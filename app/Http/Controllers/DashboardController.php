<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Session;
use App\Models\Kendaraan;
use App\Models\Penjualan;
use DB;

class DashboardController extends Controller
{

    public function index()
    {
        $current=$this->today_summary();
        $seven=$this->summary_7();
        return view('dashboard',compact('current','seven'));
    }

    public function logout()
    {
        Session::forget('info_user');
        return redirect('/');
    }

    private function today_summary()
    {
        $current_date=date('Y-m-d');
        $previous_date=date('Y-m-d',strtotime($current_date.' -1 days'));


        $total_current = Penjualan::whereDate('penjualan.created_at', $current_date)
        ->join('kendaraan','penjualan.kendaraan_id','kendaraan.id')
        ->sum('kendaraan.harga');

        $total_previous = Penjualan::whereDate('penjualan.created_at', $previous_date)
        ->join('kendaraan', 'penjualan.kendaraan_id', 'kendaraan.id')
        ->sum('kendaraan.harga');

        $count_current=Penjualan::whereDate('penjualan.created_at',$current_date)->count();
        $count_previous = Penjualan::whereDate('penjualan.created_at', $previous_date)->count();

        $best_kendaraan_id=Penjualan::whereDate('penjualan.created_at', $current_date)
        ->select('kendaraan_id',DB::Raw('COUNT(*) as total'))
        ->groupBy('kendaraan_id')
        ->orderBy('total','desc')->first();

        $best_kendaraan=Kendaraan::find($best_kendaraan_id->kendaraan_id);

        if($count_current > 0 && $count_previous > 0)
        {
            $percentage_count = ($count_current / $count_previous) * 100;
            if ($count_current > $count_previous) {
                $percentage_count_label = '+' . round($percentage_count, 0) . '%';
            } else {
                $percentage_count_label = '-' . round(abs($percentage_count), 0) . '%';
            }
        }else{
            $percentage_count_label = '+ 100 %';
        }

        if($total_current > 0 && $total_previous > 0)
        {
            $percentage_total = ($total_current / $total_previous) * 100;
            if ($count_current > $count_previous) {
                $percentage_total_label = '+' . round($percentage_total, 0) . '%';
            } else {
                $percentage_total_label = '-' . round(abs($percentage_total), 0) . '%';
            }
        }else{
            $percentage_total_label = '+ 100%';
        }


        $output=[
            'kendaraan'=> $best_kendaraan->nama,
            'total'=>$total_current.' ('. $percentage_total_label.')',
            'count'=>$count_current.' ('.$percentage_count_label.')'
        ];

        return $output;
    }

    private function summary_7()
    {
        $current_date = date('Y-m-d');
        $start_date = date('Y-m-d', strtotime($current_date . ' -7 days'));

        $total_current = Penjualan::whereDate('penjualan.created_at','>=', $start_date)
        ->whereDate('penjualan.created_at','<=',$current_date)
        ->join('kendaraan', 'penjualan.kendaraan_id', 'kendaraan.id')
        ->sum('kendaraan.harga');

        $count_current = Penjualan::whereDate('penjualan.created_at', '>=', $start_date)
        ->whereDate('penjualan.created_at', '<=', $current_date)->count();

        $best_kendaraan_id = Penjualan::whereDate('penjualan.created_at','>=', $start_date)
            ->whereDate('penjualan.created_at', '<=', $current_date)
        ->select('kendaraan_id', DB::Raw('COUNT(*) as total'))
            ->groupBy('kendaraan_id')
        ->orderBy('total', 'desc')->first();

        $best_kendaraan = Kendaraan::find($best_kendaraan_id->kendaraan_id);

        $output=[
            'kendaraan'=>$best_kendaraan->nama,
            'count'=>$count_current,
            'total'=>$total_current
        ];

        return $output;
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Kendaraan;
use App\Models\Penjualan;
use Illuminate\Support\Facades\Mail;

class PenjualanController extends Controller
{

    public function index()
    {

        return view('penjualan.index');
    }

    public function datatables(Datatables $datatables, Request $request)
    {
        $query = Penjualan::select('penjualan.*','kendaraan.nama as kendaraan','kendaraan.harga')
        ->join('kendaraan','penjualan.kendaraan_id','kendaraan.id');

        return $datatables->eloquent($query)
            ->addColumn('action', function ($u) {
                $id_encrypt = encrypt($u->id);
                return '<a href="' . route('penjualan.invoice', array('id' => $id_encrypt)) . '" class="btn btn-info btn-xs">Invoice</a>
            ';
            })
            ->toJson();
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'nama'    =>  'required',
            'email'    =>  'required',
            'telepon'    =>  'required',
            'kendaraan'    =>  'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('penjualan.index')->with('error', 'Validation Error');
        }

        try {
            $kendaraan_info = Kendaraan::find($request->kendaraan);
            $last_stok = $kendaraan_info->stok;
            $new_stok = $last_stok - 1;
            if($last_stok < 1)
            {
                return redirect()->route('penjualan.index')->with('error', 'Stok Kosong');
            }


            $add = new Penjualan();
            $add->nama      = $request->nama;
            $add->email      = $request->email;
            $add->telepon      = $request->telepon;
            $add->kendaraan_id      = $request->kendaraan;
            $save = $add->save();
            if ($save) {


                $kendaraan_info->stok=$new_stok;
                $kendaraan_info->save();
                return redirect()->route('penjualan.index')->with('success', 'Success');
            }
            return redirect()->route('penjualan.index')->with('error', 'Failed');
        } catch (\Throwable $th) {
            return redirect()->route('penjualan.index')->with('error', $th->getMessage());
        }
    }

    public function invoice($id)
    {
        $decrypt = decrypt($id);
        $data = Penjualan::select('penjualan.*', 'kendaraan.nama as kendaraan', 'kendaraan.harga')
        ->join('kendaraan', 'penjualan.kendaraan_id', 'kendaraan.id')
        ->where('penjualan.id', $decrypt)
        ->first();
        if (empty($data->id)) {
            return redirect()->route('penjualan.index')->with('error', 'Data not found');
        }
        $id_encrypt = encrypt($data->id);
        $phone=(int) $data->telepon;
        $phone='62'.$phone;
        $message=utf8_encode('Pesananan anda selesai');
        return view('penjualan.invoice', compact('data', 'id_encrypt', 'phone', 'message'));
    }

    public function send_invoice($id)
    {
        $decrypt = decrypt($id);
        $data = Penjualan::select('penjualan.*', 'kendaraan.nama as kendaraan', 'kendaraan.harga')
        ->join('kendaraan', 'penjualan.kendaraan_id', 'kendaraan.id')
        ->where('penjualan.id', $decrypt)
        ->first();
        $config = [
            'from' => env('MAIL_FROM_ADDRESS'),
            'from_name' => env('MAIL_FROM_NAME'),
            'to' => $data->email,
            'to_name' => $data->nama,
        ];
        $sending = Mail::send('penjualan.invoice_mail', ['data' => $data], function ($message) use ($config) {
            $message->from($config['from'], $config['from_name']);
            $message->to($config['to'], $config['to_name']);
            $message->subject('Invoice');
            $message->priority(3);
        });
        echo 'Success';
    }

}

<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Kendaraan;
use App\Models\Penjualan;

class KendaraanController extends Controller
{

    public function index()
    {
        return view('kendaraan.index');
    }

    public function datatables(Datatables $datatables,Request $request)
    {
        $query=Kendaraan::select('kendaraan.*');

        return $datatables->eloquent($query)
        ->addColumn('action', function($u){
            $id_encrypt=encrypt($u->id);
            return '<a href="'.route('kendaraan.edit',array('id'=> $id_encrypt)).'" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a>
            <a onclick="return confirm(\'Are you sure delete data '.$u->name.'?\');" href="'.route('kendaraan.delete',array('id'=> $id_encrypt)).'" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
            ';
        })
        ->toJson();
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'nama'    =>  'required',
            'harga'    =>  'required',
            'stok'    =>  'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('kendaraan.index')->with('error','Validation Error');
        }

        try {
            $add = new Kendaraan();
            $add->nama      = $request->nama;
            $add->harga      = $request->harga;
            $add->stok      = $request->stok;
            $save = $add->save();
            if ($save) {
                return redirect()->route('kendaraan.index')->with('success', 'Success');
            }
            return redirect()->route('kendaraan.index')->with('error', 'Failed');
        } catch (\Throwable $th) {
            return redirect()->route('kendaraan.index')->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $decrypt = decrypt($id);
        $data=Kendaraan::find($decrypt);
        if(empty($data->id))
        {
            return redirect()->route('kendaraan.index')->with('error', 'Data not found');
        }
        $id_encrypt=encrypt($data->id);
        return view('kendaraan.edit',compact('data','id_encrypt'));
    }

    public function update(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'id'    =>  'required',
            'nama'    =>  'required',
            'harga'    =>  'required',
            'stok'    =>  'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('kendaraan.index')->with('error', $validator->errors());
        }

        try {
            $decrypt=decrypt($request->id);
            $edit = Kendaraan::find($decrypt);
            $edit->nama      = $request->nama;
            $edit->harga      = $request->harga;
            $edit->stok      = $request->stok;
            $save = $edit->save();
            if ($save) {
                return redirect()->route('kendaraan.index')->with('success', 'Success');
            }
            return redirect()->route('kendaraan.edit',$decrypt)->with('error', 'Failed');
        } catch (\Throwable $th) {
            return redirect()->route('kendaraan.index')->with('error', $th->getMessage());
        }
    }

    public function delete($id)
    {
        $decrypt = decrypt($id);
        $data = Kendaraan::find($decrypt);
        if (empty($data->id)) {
            return redirect()->route('kendaraan.index')->with('error', 'Data not found');
        }
        $edit=Kendaraan::find($decrypt);
        $delete=$edit->delete();
        if($delete)
        {
            Penjualan::where('kendaraan_id',$decrypt)->delete();
            return redirect()->route('kendaraan.index')->with('success', 'Success');
        }
        return redirect()->route('kendaraan.index')->with('error', 'Failed');
    }

    public function get_kendaraan(Request $request)
    {
        if ($request->ajax()) {
            $keyword=$request->q;
            $query=Kendaraan::orderBy('nama','ASC');
            if(!empty($keyword))
            {
                $query->where('nama','LIKE',$keyword.'%');
            }
            $data=$query->get();
            return response()->json($data);
        } else {
            die('Not ajax request');
        }
    }

}

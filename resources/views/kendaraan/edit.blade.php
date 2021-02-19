@extends('master')
@section('title','Edit Kendaraan')

@section('content')
<div class="card">
    <div class="card-header">Edit Data</div>
    <div class="card-body">
        <form method="post" action="{{route('kendaraan.update')}}">
            @csrf
            <input type="hidden" name="id" value="{{ $id_encrypt }}" />
            <div class="form-group">
                <label>Nama Kendaraan</label>
                <input type="text" name="nama" id="nama" class="form-control " placeholder="Nama Kendaraan" required value="{{ $data->nama }}" />
            </div>
            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="harga" id="harga" class="form-control " placeholder="Harga Kendaraan" required value="{{ $data->harga }}" />
            </div>
            <div class="form-group">
                <label>Stok</label>
                <input type="number" name="stok" id="stok" class="form-control " placeholder="Stok Kendaraan" required value="{{ $data->stok }}" />
            </div>
            <div class="form-group">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-primary btn-flat">Save</button>
                <a href="{{ route('kendaraan.index') }}" class="btn btn-default btn-flat">Cancel</a>
            </div>

        </form>
    </div>
</div>

@endsection

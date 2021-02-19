@extends('master')
@section('title','Invoice View')

@section('content')

<div class="form-group row ">
    <label class="col-sm-2 col-form-label">Kendaraan</label>
    <div class="col-sm-10">
        <p class="form-control-plaintext">{{ $data->kendaraan }}</p>
    </div>
</div>
<div class="form-group row ">
    <label class="col-sm-2 col-form-label">Nama Pembeli</label>
    <div class="col-sm-10">
        <p class="form-control-plaintext">{{ $data->nama }}</p>
    </div>
</div>
<div class="form-group row ">
    <label class="col-sm-2 col-form-label">Email Pembeli</label>
    <div class="col-sm-10">
        <p class="form-control-plaintext">{{ $data->email }}</p>
    </div>
</div>
<div class="form-group row ">
    <label class="col-sm-2 col-form-label">No. Telepon Pembeli</label>
    <div class="col-sm-10">
        <p class="form-control-plaintext">{{ $data->telepon }}</p>
    </div>
</div>

<a href="{{ route('penjualan.send_invoice',['id'=>$id_encrypt]) }}" class="btn btn-primary btn-md" target="_blank">Send Invoice to Email</a>


<a href="https://wa.me/{{ $phone }}?text={{ $message }}" class="btn btn-success btn-md" target="_blank">Send Invoice to Whatsapp</a>

<p>&nbsp;</p>

@endsection

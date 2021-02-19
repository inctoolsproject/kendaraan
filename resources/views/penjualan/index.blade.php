@extends('master')
@section('title','Kendaraan')

@section('content')

<div class="card">
    <div class="card-header">Add Sale</div>
    <div class="card-body">
        <form method="post" action="{{route('penjualan.store')}}">
            @csrf
            <div class="form-group row ">
                <label class="col-sm-2 col-form-label">Kendaraan</label>
                <div class="col-sm-10">
                    <select name="kendaraan" id="kendaraan" class="form-control" required data-allow-clear="true" data-placeholder="Pilih Kendaraan">
                        <option></option>
                    </select>
                </div>
            </div>
            <div class="form-group row ">
                <label class="col-sm-2 col-form-label">Nama Pembeli</label>
                <div class="col-sm-10">
                    <input type="text" name="nama" id="nama" class="form-control " placeholder="Nama Pembeli" required value="{{ old('nama') }}" />
                </div>
            </div>
            <div class="form-group row ">
                <label class="col-sm-2 col-form-label">Email Pembeli</label>
                <div class="col-sm-10">
                    <input type="email" name="email" id="email" class="form-control " placeholder="Email Pembeli" required value="{{ old('email') }}" />
                </div>
            </div>
            <div class="form-group row ">
                <label class="col-sm-2 col-form-label">No. Telepon Pembeli</label>
                <div class="col-sm-10">
                    <input type="text" name="telepon" id="telepon" class="form-control " placeholder="No. Telepon Pembeli" required value="{{ old('telepon') }}" />
                </div>
            </div>

            <div class="form-group row ">
                <label class="col-sm-2 col-form-label">&nbsp;</label>
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary btn-flat">Save</button>
                </div>
            </div>

        </form>
    </div>
</div>

<table class="table table-bordered table-hover" id="datatables">
    <thead>
        <th>Date</th>
        <th>Nama Pembeli</th>
        <th>Email</th>
        <th>Telepon</th>
        <th>Kendaraan</th>
        <th>Action</th>
    </thead>
    <tbody></tbody>
</table>

@endsection

@section('script')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css" integrity="sha512-PT0RvABaDhDQugEbpNMwgYBCnGCiTZMh9yOzUsJHDgl/dMhD9yjHAwoumnUk3JydV3QTcIkNDuN40CJxik5+WQ==" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js" integrity="sha512-OQlawZneA7zzfI6B1n1tjUuo3C5mtYuAWpQdg+iI9mkDoo7iFzTqnQHf+K5ThOWNJ9AbXL4+ZDwH7ykySPQc+A==" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js" integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g==" crossorigin="anonymous"></script>
<link rel="stylesheet" href="{{ asset('select2-bootstrap4.min.css') }}">
<script>
    $(document).ready(function() {

        refresh_data();

        $("#kendaraan").select2({
            allowClear: true,
            theme: 'bootstrap4',
            ajax: {
                url: "{{ route('kendaraan.get_kendaraan') }}",
                dataType: 'json',
                delay: 0,
                data: function(params) {
                    return {
                        q: params.term,
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results: $.map(data, function(obj) {
                            return {
                                id: obj.id,
                                text: obj.nama
                            };
                        }),
                    };
                },
                cache: true
            },
        });

    });

    function refresh_data() {
        $('#datatables').dataTable().fnDestroy();
        $('#datatables').DataTable({
            serverSide: true,
            processing: true,
            ajax: "{{ route('penjualan.datatables') }}",
            columns: [{
                data: 'created_at',
                name: 'penjualan.created_at'
            },{
                data: 'nama',
                name: 'penjualan.nama'
            }, {
                data: 'email',
                name: 'penjualan.email'
            }, {
                data: 'telepon',
                name: 'penjualan.telepon'
            }, {
                data: 'kendaraan',
                name: 'kendaraan.nama'
            }, {
                data: 'action',
                name: 'action'
            }]
        });
    }
</script>
@endsection

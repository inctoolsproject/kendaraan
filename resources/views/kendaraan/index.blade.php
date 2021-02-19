@extends('master')
@section('title','Kendaraan')

@section('content')

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Add Data</div>
            <div class="card-body">
                <form method="post" action="{{route('kendaraan.store')}}">
                    @csrf

                    <div class="form-group">
                        <label>Nama Kendaraan</label>
                        <input type="text" name="nama" id="nama" class="form-control " placeholder="Nama Kendaraan" required value="{{ old('nama') }}" />
                    </div>
                    <div class="form-group">
                        <label>Harga</label>
                        <input type="number" name="harga" id="harga" class="form-control " placeholder="Harga Kendaraan" required value="{{ old('harga') }}" />
                    </div>
                    <div class="form-group">
                        <label>Stok</label>
                        <input type="number" name="stok" id="stok" class="form-control " placeholder="Stok Kendaraan" required value="{{ old('stok') }}" />
                    </div>
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary btn-flat">Save</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="datatables">
                <thead>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Action</th>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('script')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css" integrity="sha512-PT0RvABaDhDQugEbpNMwgYBCnGCiTZMh9yOzUsJHDgl/dMhD9yjHAwoumnUk3JydV3QTcIkNDuN40CJxik5+WQ==" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js" integrity="sha512-OQlawZneA7zzfI6B1n1tjUuo3C5mtYuAWpQdg+iI9mkDoo7iFzTqnQHf+K5ThOWNJ9AbXL4+ZDwH7ykySPQc+A==" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {

        refresh_data();

    });

    function refresh_data() {
        $('#datatables').dataTable().fnDestroy();
        $('#datatables').DataTable({
            serverSide: true,
            processing: true,
            ajax: "{{ route('kendaraan.datatables') }}",
            columns: [{
                data: 'nama',
                name: 'nama'
            }, {
                data: 'harga',
                name: 'harga'
            }, {
                data: 'stok',
                name: 'stok'
            }, {
                data: 'action',
                name: 'action'
            }]
        });
    }
</script>
@endsection

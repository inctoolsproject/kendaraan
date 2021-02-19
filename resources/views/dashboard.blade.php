@extends('master')
@section('title','Dashboard')

@section('content')

<div class="table-responsive">
    <table class="table table-bordered">
        <tr>
            <td colspan="2">
                DATA HARI INI
            </td>
        </tr>
        <tr>
            <td>Mobil yang paling banyak dijual</td>
            <td>{{ $current['kendaraan'] }}</td>
        </tr>
        <tr>
            <td>Penjualan Hari ini</td>
            <td>{{ $current['count'] }}</td>
        </tr>
        <tr>
            <td>Total Penjualan Hari ini</td>
            <td>{{ $current['total'] }}</td>
        </tr>
    </table>
</div>

<div class="table-responsive">
    <table class="table table-bordered">
        <tr>
            <td colspan="2">
                DATA 7 HARI TERAKHIR
            </td>
        </tr>
        <tr>
            <td>Mobil yang paling banyak dijual</td>
            <td>{{ $seven['kendaraan'] }}</td>
        </tr>
        <tr>
            <td>Penjualan 7 hari terakhir</td>
            <td>{{ $seven['count'] }}</td>
        </tr>
        <tr>
            <td>Total Penjualan 7 hari terakhir</td>
            <td>{{ $seven['total'] }}</td>
        </tr>
    </table>
</div>

@endsection

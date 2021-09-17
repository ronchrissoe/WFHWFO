@extends('adminlte::page')

@if (Route::currentRouteName() == 'report')
    @section('title', 'Report WFH and WFO')
@elseif (Route::currentRouteName() == 'food')
    @section('title', 'Report WFH and WFO (Food)')
@else
    @section('title', 'Report WFH and WFO (Schedule)')
@endif

@section('content_header')
<div class="row">
    <div class="col-md-12">
        @if (Route::currentRouteName() == 'report')
            <h1>Report WFH and WFO</h1>
        @elseif (Route::currentRouteName() == 'food')
            <h1>Report WFH and WFO (Food)</h1>
        @else
            <h1>Report WFH and WFO (Schedule)</h1>
        @endif
    </div>
</div>
@stop

@section('content')
<style>
    th:first-child, td:first-child
    {
        position:sticky;
        left:0px;
    }
    td:first-child
    {
        background-color:white;
    }
    table tfoot {
        position: sticky;
    }
    table tfoot {
        inset-block-end: 0;
        background-color:white;
    }
</style>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">

                    <div class="col-md-4">
                        @if (Route::currentRouteName() == 'report')
                        <form action="{{route('report-filter')}}" method="POST">
                        @elseif (Route::currentRouteName() == 'schedule')
                        <form action="{{route('schedule-filter')}}" method="POST">
                        @else
                        <form action="{{route('food-filter')}}" method="POST">
                        @endif
                            @csrf
                        <div class="form-group">
                            <label for="tanggalmulai">Tanggal Awal :</label>
                            <input type="date" class="form-control" id="tanggalmulai" name="tanggalmulai" format= 'dd/mm/yyyy'>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tanggalselesai">Tanggal Akhir :</label>
                            <input type="date" class="form-control" id="tanggalselesai" name="tanggalselesai" format= 'dd/mm/yyyy'>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="departemen">Departemen :</label>
                            <select id="slcdepartemen" name="departemen" class="form-control">
                                <option value="">--Pilih Departemen--</option>
                                @foreach ($departemen as $department => $department)
                                <option value="{{ $department }}">{{ $department }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive p-0" style="height: 600px;">
                            <table id="example1" class="table table-bordered table-hover table-head-fixed text-nowrap">
                                <thead style="text-align: center">
                                    <tr>
                                        <th width="5%">Nama</th>
                                        <th>Department</th>
                                        @foreach ($dates->sortBy('tanggal') as $tanggal => $date)
                                        <th>{{Carbon\Carbon::parse($tanggal)->format('d M')}}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody style="text-align: center">
                                    @foreach ($datas as $full_name => $departement)
                                    <tr>
                                        <td>{{$full_name}}</td>
                                        <td>{{$user->where('full_name', $full_name)->first()->department}}</td>
                                        @foreach ($departement->sortBy('tanggal') as $item)
                                        <center>
                                        @if ($item->kdstatus != 'OPN')
                                            @if ($item->kerja == "Work From Office")
                                                <td style="background: greenyellow">
                                                    @if (Route::currentRouteName() == 'report')
                                                        <b>WFO ({{$item->makanan}})</b>
                                                    @elseif (Route::currentRouteName() == 'schedule')
                                                        <b>WFO</b>
                                                    @else
                                                        <b>{{$item->makanan}}</b>
                                                    @endif
                                                </td>
                                            @elseif($item->kerja == "Work From Home")
                                                @if (Route::currentRouteName() == 'report' || Route::currentRouteName() == 'schedule')
                                                    <td style="background: lightblue">
                                                            <b>WFH</b>
                                                    </td>
                                                @else
                                                    <td></td>
                                                @endif
                                            @else
                                                @if (Route::currentRouteName() == 'report' || Route::currentRouteName() == 'schedule')
                                                    <td style="background: pink">
                                                            <b>DL</b>
                                                    </td>
                                                @else
                                                    <td></td>
                                                @endif
                                            @endif
                                        @else
                                        <td></td>
                                        @endif
                                        </center>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot style="text-align: center">
                                    <tr>
                                        <th style="background: white">Total Karyawan (WFO)</th>
                                        <th></th>
                                        @foreach ($dates->sortBy('tanggal') as $jumlah)
                                            <th>
                                                {{$jumlah->where('kdstatus', '!=', 'OPN')->where('kerja',"Work From Office")->count()}}
                                            </th>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <th style="background: white">% (WFO)</th>
                                        <th></th>
                                        @foreach ($dates->sortBy('tanggal') as $pers)
                                            @php
                                                $persen = $pers->where('kdstatus', '!=', 'OPN')->where('kerja',"Work From Office")->count()/$pers->where('kdstatus', '!=', 'OPN')->count()*100;
                                            @endphp
                                            @if ($persen > $max->maksimum)
                                                <th style="background: pink">
                                                    {{ceil($persen)}}%
                                                </th>
                                            @else
                                                <th>
                                                    {{ceil($persen)}}%
                                                </th>
                                            @endif
                                        @endforeach
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Work From Home =</label> <b>{{ceil($wfh)}}</b><label id="lblWFH"></label><label>%</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Work From Office =</label> <b>{{ceil($wfo)}}</b><label id="lblWFO"></label><label>%</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Dinas Luar =</label> <b>{{ceil($luar)}}</b><label id="lblDL"></label><label>%</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')

@stop

@section('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function () {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": true,
            "ordering": true,
            "buttons": ["copy", "excel", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>

@stop

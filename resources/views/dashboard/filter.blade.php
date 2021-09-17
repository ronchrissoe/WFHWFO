@extends('adminlte::page')

@section('title', 'WWS')

@section('content_header')
<div class="row">
    <div class="col-md-12">
        <h1>Dashboard</h1>
    </div>
</div>
@stop

@section('content')
<style>
    th:first-child,
    td:first-child {
        position: sticky;
        left: 0px;
    }

    td:first-child {
        background-color: white;
    }
</style>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">

                    <div class="col-md-4">
                        <form action="{{route('filter')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="tanggalmulai">Tanggal Awal :</label>
                                <input type="date" class="form-control" id="tanggalmulai" name="tanggalmulai">
                            </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tanggalselesai">Tanggal Akhir :</label>
                            <input type="date" class="form-control" id="tanggalselesai" name="tanggalselesai">
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
                            <a href="{{route('dashboard')}}" type="button" class="btn btn-danger">Back</a>
                        </div>
                    </div>
                    </form>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive p-0" style="height: 400px;">
                            <table id="example2" class="table table-bordered table-hover table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Department</th>
                                        @foreach ($dates as $tanggal => $date)
                                        <th>{{Carbon\Carbon::parse($tanggal)->format('d M')}}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($filter as $full_name => $departement)
                                    <tr>
                                        <td>{{$full_name}}</td>
                                        <td>{{$user->where('full_name', $full_name)->first()->department}}</td>
                                        @foreach ($departement->sortBy('tanggal') as $item)
                                        <center>
                                            @if ($item->kdstatus == 'APR' || $item->kdstatus == 'APRDR')
                                                @if ($item->kerja == "Work From Office")
                                                    <td style="background: greenyellow">
                                                        <b>WFO</b>
                                                    </td>
                                                @elseif($item->kerja == "Work From Home")
                                                    <td style="background: lightblue">
                                                        <b>WFH</b>
                                                    </td>
                                                @elseif ($item->kerja == "Dinas Luar")
                                                    <td style="background: pink">
                                                        <b>DL</b>
                                                    </td>
                                                @else
                                                    <td style="background: rgb(255, 255, 135)">
                                                        <b>Cuti</b>
                                                    </td>
                                                @endif
                                            @else
                                                <td></td>
                                            @endif
                                        </center>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Work From Home =</label>&nbsp<label id="lblWFH"></label><label>%</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Work From Office =</label>&nbsp<label id="lblWFO"></label><label>%</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Dinas Luar =</label>&nbsp<label id="lblDL"></label><label>%</label>
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
        $('#slcnama').select2();

        $.fn.dataTable.ext.errMode = 'none';

        var table = $('.yajra-datatable')
            .on('error.dt', function (e, settings, techNote, message) {
                console.log('Error : ', message);
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Display Data Unsuccessful',
                    scrollbarPadding: false
                })
            })

        $('#btnFilter').click(function (e) {
            e.preventDefault();

            table.draw();

            percentage();
        });

        function percentage() {
            $.ajax({
                url: "{{ url('/dashboard/percentage') }}",
                data: {
                    nik: $("#slcnama :selected").val(),
                    department: $("#slcdepartemen :selected").val(),
                    tanggalmulai: $('#tanggalmulai').val(),
                    tanggalselesai: $('#tanggalselesai').val()
                },
                type: "GET",
                success: function (data) {
                    $('#lblWFO').text(data.WFO);
                    $('#lblWFH').text(data.WFH);
                    $('#lblDL').text(data.DL);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }

        percentage();
    });
    $(function () {
        $('#example2').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": false,
            "responsive": true,
        });
    });
</script>
@stop

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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tanggalmulai">Tanggal Awal :</label>
                                <input type="date" class="form-control" id="tanggalmulai" name="tanggalmulai" value="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tanggalselesai">Tanggal Akhir :</label>
                                <input type="date" class="form-control" id="tanggalselesai" value="09/09/2021" name="tanggalselesai">
                            </div>
                        </div>
                        <div class="col-md-3">
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nama">Nama :</label>
                                <select id="slcnama" name="nama" class="form-control">
                                    <option value="">--Pilih Nama--</option>
                                    @foreach ($nama as $nik)
                                    <option value="{{ $nik->nik }}">{{ $nik->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- <div class="col-md-2">
                            <div class="form-group">
                                <label for="bulan">Bulan :</label>
                                <select name="bulan" class="form-control">
                                    <option value="">--Pilih Bulan--</option>
                                    <option value="01">Januari</option>
                                    <option value="02">Februari</option>
                                    <option value="03">Maret</option>
                                    <option value="04">April</option>
                                    <option value="05">Mei</option>
                                    <option value="06">Juni</option>
                                    <option value="07">Juli</option>
                                    <option value="08">Agustus</option>
                                    <option value="09">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="tahun">Tahun :</label>
                                <select name="tahun" class="form-control">
                                    <option value="">--Pilih Tahun--</option>
                                    <option value="2021">2021</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group" style="padding-top:32px;">
                                <a href="{{ url('/dashboard') }}" class="btn btn-primary">Filter</a>
                            </div>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary" id="btnFilter">Filter</button>
                            </div>
                        </div>
                    </div>
                    </br>
                    {{-- <label>Indikator Warna :</label>
                    <label style="background-color:#3788d8; color:white; padding-left:5px; padding-right:5px;">Work From Office</label>
                    <label style="background-color:#4CAF50; color:white; padding-left:5px; padding-right:5px;">Work From Anywhere</label>
                    <label style="background-color:#ff851b; color:white; padding-left:5px; padding-right:5px;">Dinas Luar</label>
                    <br/>
                    @isset($calendar)
                        {!! $calendar->calendar() !!}
                    @endisset  --}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered yajra-datatable">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Nama</th>
                                            <th>Departemen</th>
                                            <th>Jadwal Kerja</th>
                                            <th>Makan Siang</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <br/>
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
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.css"/> --}}
@stop

@section('js')
    {{-- <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.min.js"></script>

    @isset($calendar)
        {!! $calendar->script() !!}
    @endisset --}}

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
            .on( 'error.dt', function ( e, settings, techNote, message ) {
                console.log('Error : ', message);
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Display Data Unsuccessful',
                    scrollbarPadding : false
                })
            })
            .DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                order: [[ 0, 'desc' ]],
                ajax: {
                    url: "{{ url('/dashboard') }}",
                    data: function (d) {
                        d.nik = $("#slcnama :selected").val(),
                        d.department = $("#slcdepartemen :selected").val(),
                        d.tanggalmulai = $('#tanggalmulai').val(),
                        d.tanggalselesai = $('#tanggalselesai').val()
                    }
                },
                columns: [
                    {data: 'tanggal',
                     name: 'tanggal',
                     render: function(data, type, row){
                        if(type === "sort" || type === "type"){
                            return data;
                        }
                        return moment(data).format("DD-MM-YYYY");
                     }
                    },
                    {data: 'full_name', name: 'full_name'},
                    {data: 'department', name: 'department'},
                    {data: 'kerja', name: 'kerja'},
                    {data: 'makanan', name: 'makanan'}
                ]
            });

            $('#btnFilter').click(function(e){
                e.preventDefault();

                table.draw();

                percentage();
            });

            function percentage() {
                $.ajax({
                    url: "{{ url('/dashboard/percentage') }}",
                    data: {
                        nik:$("#slcnama :selected").val()
                        , department:$("#slcdepartemen :selected").val()
                        , tanggalmulai:$('#tanggalmulai').val()
                        , tanggalselesai:$('#tanggalselesai').val()
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
    </script>
@stop

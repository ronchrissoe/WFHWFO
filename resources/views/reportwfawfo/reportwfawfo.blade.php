@extends('adminlte::page')

@section('title', 'WWS')

@section('content_header')
    <div class="row">
        <div class="col-md-12">
            <h1>Report WFH-WFO</h1>
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
                                <input type="date" class="form-control" id="tanggalselesai" name="tanggalselesai" value="">
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
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary" id="btnFilter">Filter</button>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-12">
                            {{-- <a class="btn btn-success" href="{{ url('/reportwfawfo/exportexcel') }}" id="exportexcel">Export Excel</a> --}}
                            <button type="button" class="btn btn-success" id="btnFilter" onclick="exportexcel()">Export Excel</button>
                            </br>
                            </br>
                            <div class="table-responsive">
                                <table class="table table-bordered yajra-datatable">
                                <thead>                  
                                    <tr>
                                    <th>Tanggal</th>
                                    <th>Nik</th>
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
    
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function exportexcel() {
            if($("#slcdepartemen :selected").val() == '' && $('#tanggalmulai').val() == '' && $('#tanggalselesai').val() == ''){
                let url = "{{ url('/reportwfawfo/exportexcel/') }}";
                document.location.href=url;
            }else if($("#slcdepartemen :selected").val() == ''){
                let url = "{{ url('/reportwfawfo/exportexcel/null/tanggalmulai/tanggalselesai') }}";
                url = url.replace('tanggalmulai', $('#tanggalmulai').val());
                url = url.replace('tanggalselesai', $('#tanggalselesai').val());
                document.location.href=url;
            }else{
                let url = "{{ url('/reportwfawfo/exportexcel/departemen/tanggalmulai/tanggalselesai') }}";
                url = url.replace('departemen', $("#slcdepartemen :selected").val());
                url = url.replace('tanggalmulai', $('#tanggalmulai').val());
                url = url.replace('tanggalselesai', $('#tanggalselesai').val());
                document.location.href=url;
            }
        }

        $(function () {
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
                    url: "{{ url('/reportwfawfo') }}",
                    data: function (d) {
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
                    {data: 'nik', name: 'nik'},
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
                    url: "{{ url('/reportwfawfo/percentage') }}",
                    data: {department:$("#slcdepartemen :selected").val()
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
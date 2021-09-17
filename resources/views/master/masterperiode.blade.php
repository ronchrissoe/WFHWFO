@extends('adminlte::page')

@section('title', 'WWS')

@section('content_header')
<div class="row">
    <div class="col-md-12">
        <h1>Data Master Periode</h1>
    </div>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <a class="btn btn-primary" href="javascript:void(0)" id="addmasterperiode"> Tambah
                                    Periode</a>
                            </div>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-bordered yajra-datatable">
                                <thead style="text-align: center">
                                    <tr>
                                        <th>Tanggal Awal</th>
                                        <th>Tanggal Akhir</th>
                                        <th>Status</th>
                                        <th style="width: 20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody style="text-align: center">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="insert-update-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>
                <form id="masterperiodeform">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="id" value="0">
                    <div class="form-group">
                        <label for="tgl_awal">Tanggal Awal</label>
                        <input type="date" class="form-control" id="tgl_awal" name="tgl_awal" value="">
                    </div>
                    <div class="form-group">
                        <label for="tgl_akhir">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="tgl_akhir" name="tgl_akhir" value="">
                    </div>
                    <div class="form-group">
                        <label for="kdstatusperiode">Status</label>
                        <select id="kdstatusperiode" name="kdstatusperiode" class="form-control">
                            <option value="">--Pilih Status--</option>
                            @foreach ($status as $kdstatusperiode => $statusperiode)
                            <option value="{{ $kdstatusperiode }}">{{ $statusperiode }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveBtn"></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
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
            .DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                order: [
                    [0, 'desc']
                ],
                ajax: "{{ route('masterperiode.index') }}",
                columns: [{
                        data: 'tgl_awal',
                        name: 'tgl_awal',
                        render: function (data, type, row) {
                            if (type === "sort" || type === "type") {
                                return data;
                            }
                            return moment(data).format("DD-MM-YYYY");
                        }
                    },
                    {
                        data: 'tgl_akhir',
                        name: 'tgl_akhir',
                        render: function (data, type, row) {
                            if (type === "sort" || type === "type") {
                                return data;
                            }
                            return moment(data).format("DD-MM-YYYY");
                        }
                    },
                    {
                        data: 'statusperiode',
                        name: 'statusperiode'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

        $('#addmasterperiode').click(function () {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display', 'none');
            $('#saveBtn').val("add-masterperiode");
            $('#id').val('0');
            $('#saveBtn').html('Save');
            $('#masterperiodeform').trigger("reset");
            $('#modelHeading').html("Form Tambah Periode");
            $('#insert-update-modal').modal('show');
            $('#tgl_awal').prop('disabled', false);
            $('#tgl_akhir').prop('disabled', false);
        });

        $('body').on('click', '.editmasterperiode', function () {
            var id = $(this).data('id');
            $.get("masterperiode" + '/' + id + '/edit', function (data) {
                $(".print-error-msg").find("ul").html('');
                $(".print-error-msg").css('display', 'none');
                $('#modelHeading').html("Edit Periode");
                $('#saveBtn').val("edit-masterperiode");
                $('#saveBtn').html('Save');
                $('#insert-update-modal').modal('show');
                $('#tgl_awal').prop('disabled', true);
                $('#tgl_akhir').prop('disabled', true);
                $('#id').val(data.id);
                $('#tgl_awal').val(data.tgl_awal);
                $('#tgl_akhir').val(data.tgl_akhir);
                $('#kdstatusperiode').val(data.kdstatusperiode);
            })
        });

        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');
            $.ajax({
                data: $('#masterperiodeform').serialize(),
                url: "{{ route('masterperiode.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    if (data.result == 'true') {
                        $('#masterperiodeform').trigger("reset");
                        $('#insert-update-modal').modal('hide');
                        table.draw();
                        Swal.fire({
                            type: 'success',
                            title: 'Success',
                            text: data.message,
                            scrollbarPadding: false
                        })
                    } else {
                        printErrorMsg(data.error);
                        $('#saveBtn').html('Save');
                    }
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Save');
                }
            });
        });

        function printErrorMsg(msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display', 'block');
            $.each(msg, function (key, value) {
                $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
            });
        }

        $('body').on('click', '.deletemasterperiode', function () {
            var id = $(this).data("id");
            if (confirm("Are You sure want to delete ?")) {
                $.ajax({
                    type: "DELETE",
                    url: "masterperiode" + '/' + id,
                    success: function (data) {
                        if (data.result == 'true') {
                            table.draw();
                            Swal.fire({
                                type: 'success',
                                title: 'Success',
                                text: data.message,
                                scrollbarPadding: false
                            })
                        }
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }
        });
    });
</script>
@stop

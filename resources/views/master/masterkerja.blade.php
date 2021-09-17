@extends('adminlte::page')

@section('title', 'WWS')

@section('content_header')
<div class="row">
    <div class="col-md-12">
        <h1>Data Master Jadwal Kerja</h1>
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
                                <a class="btn btn-primary" href="javascript:void(0)" id="addmasterkerja">Add Jadwal
                                    Kerja</a>
                            </div>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-bordered yajra-datatable">
                                <thead style="text-align: center">
                                    <tr>
                                        <th style="width: 20%">Kode Jadwal Kerja</th>
                                        <th>Jadwal Kerja</th>
                                        <th style="width: 20%">Maksimum (%)</th>
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
                <form id="masterkerjaform">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="id" value="0">
                    <div class="form-group">
                        <label for="kdkerja">Kode Jadwal Kerja</label>
                        <input type="text" class="form-control" id="kdkerja" name="kdkerja" placeholder="Wajib diisi"
                            value="">
                    </div>
                    <div class="form-group">
                        <label for="kerja">Jadwal Kerja</label>
                        <input type="text" class="form-control" id="kerja" name="kerja" placeholder="Wajib diisi"
                            value="">
                    </div>
                    <div class="form-group">
                        <label for="maksimum">Maksimum (%)</label>
                        <input type="text" class="form-control" id="maksimum" name="maksimum" placeholder="Wajib diisi"
                            value="">
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
                    [1, 'asc']
                ],
                ajax: "{{ route('masterkerja.index') }}",
                columns: [{
                        data: 'kdkerja',
                        name: 'kdkerja'
                    },
                    {
                        data: 'kerja',
                        name: 'kerja'
                    },
                    {
                        data: 'maksimum',
                        name: 'maksimum'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

        $('#addmasterkerja').click(function () {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display', 'none');
            $('#saveBtn').val("add-masterkerja");
            $('#id').val('0');
            $('#saveBtn').html('Save');
            $('#masterkerjaform').trigger("reset");
            $('#modelHeading').html("Add Jadwal Kerja");
            $('#insert-update-modal').modal('show');
            $('#kdkerja').prop('disabled', false);
        });

        $('body').on('click', '.editmasterkerja', function () {
            var id = $(this).data('id');
            $.get("masterkerja" + '/' + id + '/edit', function (data) {
                $(".print-error-msg").find("ul").html('');
                $(".print-error-msg").css('display', 'none');
                $('#modelHeading').html("Edit Jadwal Kerja");
                $('#saveBtn').val("edit-masterkerja");
                $('#saveBtn').html('Save');
                $('#insert-update-modal').modal('show');
                $('#kdkerja').prop('disabled', true);
                $('#id').val(data.id);
                $('#kdkerja').val(data.kdkerja);
                $('#kerja').val(data.kerja);
                $('#maksimum').val(data.maksimum);
            })
        });

        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');
            $.ajax({
                data: $('#masterkerjaform').serialize(),
                url: "{{ route('masterkerja.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    if (data.result == 'true') {
                        $('#masterkerjaform').trigger("reset");
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

        $('body').on('click', '.deletemasterkerja', function () {
            var id = $(this).data("id");
            if (confirm("Are You sure want to delete ?")) {
                $.ajax({
                    type: "DELETE",
                    url: "masterkerja" + '/' + id,
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

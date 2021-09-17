@extends('adminlte::page')

@section('title', 'WWS')

@section('content_header')
  <div class="row">
    <div class="col-md-12">
      <h1>Data Master Hari Libur</h1>
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
                        <a class="btn btn-primary" href="javascript:void(0)" id="addmasterharilibur">Tambah Hari Libur</a>
                    </div>
                </div>
                <br>
                <div class="table-responsive">
                    <table class="table table-bordered yajra-datatable">
                    <thead style="text-align: center">
                        <tr>
                        <th>Tanggal</th>
                        <th style="width: 30%">Action</th>
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
          <form id="masterhariliburform">
            {{ csrf_field() }}
            <input type="hidden" name="id" id="id" value="0">
            <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" value="">
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
            searching: true,
            order: [[ 0, 'desc' ]],
            ajax: "{{ route('masterharilibur.index') }}",
            columns: [
                {data: 'tanggal'
                , name: 'tanggal'
                , render: function(data, type, row){
                        if(type === "sort" || type === "type"){
                            return data;
                        }
                        return moment(data).format("DD-MM-YYYY");
                     }
                },
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        $('#addmasterharilibur').click(function () {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display', 'none');
            $('#saveBtn').val("add-masterharilibur");
            $('#id').val('0');
            $('#saveBtn').html('Save');
            $('#masterhariliburform').trigger("reset");
            $('#modelHeading').html("Form Tambah Hari Libur");
            $('#insert-update-modal').modal('show');
        });

        $('body').on('click', '.editmasterharilibur', function () {
          var id = $(this).data('id');
          $.get("masterharilibur" +'/' + id +'/edit', function (data) {
              $(".print-error-msg").find("ul").html('');
              $(".print-error-msg").css('display', 'none');
              $('#modelHeading').html("Edit Hari Libur");
              $('#saveBtn').val("edit-masterharilibur");
              $('#saveBtn').html('Save');
              $('#insert-update-modal').modal('show');
              $('#id').val(data.id);
              $('#tanggal').val(data.tanggal);
          })
        });

        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');
            $.ajax({
              data: $('#masterhariliburform').serialize(),
              url: "{{ route('masterharilibur.store') }}",
              type: "POST",
              dataType: 'json',
              success: function (data) {
                if(data.result == 'true'){
                  $('#masterhariliburform').trigger("reset");
                  $('#insert-update-modal').modal('hide');
                  table.draw();
                  Swal.fire({
                    type: 'success',
                    title: 'Success',
                    text: data.message,
                    scrollbarPadding : false
                  })
                }else{
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
          $.each(msg, function(key, value) {
            $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
          });
        }

        $('body').on('click', '.deletemasterharilibur', function () {
          var id = $(this).data("id");
          if(confirm("Are You sure want to delete ?")){
            $.ajax({
              type: "DELETE",
              url: "masterharilibur"+'/'+id,
              success: function (data) {
                if(data.result == 'true'){
                  table.draw();
                  Swal.fire({
                    type: 'success',
                    title: 'Success',
                    text: data.message,
                    scrollbarPadding : false
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

@extends('adminlte::page')

@section('title', 'WWS')

@section('content_header')
  <div class="row">
    <div class="col-md-12">
      <h1>Data Master User</h1>
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
                        <a class="btn btn-primary" href="javascript:void(0)" id="addmasteruser"> Tambah User</a>
                    </div>
                </div>
                <br>
              <div class="table-responsive">
                <table class="table table-bordered yajra-datatable">
                  <thead>
                    <tr>
                      <th>Username</th>
                      <th>Password</th>
                      <th>Nik</th>
                      <th>Nama Lengkap</th>
                      <th>Departemen</th>
                      <th>Sub Departemen</th>
                      <th>Jabatan</th>
                      <th>Email</th>
                      <th>Perusahaan</th>
                      <th>Atasan Langsung</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
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
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
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
          <form id="masteruserform">
            {{ csrf_field() }}
            <input type="hidden" name="id" id="id" value="0">
            <div class="form-group">
              <label for="user_id">Username</label>
              <input type="text" class="form-control" id="user_id" name="user_id" placeholder="Wajib diisi" value="">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="text" class="form-control" id="password" name="password" placeholder="Wajib diisi" value="">
            </div>
            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="full_name">Nama Lengkap</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Wajib diisi" value="">
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="nik">Nik</label>
                        <input type="text" class="form-control" id="nik" name="nik" placeholder="Wajib diisi" value="" disabled>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <label for="department">Departemen</label>
                        <select class="form-control" name="department" id="department" placeholder="Pilih Department">
                            <option id="department">Pilih Department</option>
                            @foreach ($dept as $item)
                            <option value="{{$item->department}}">{{$item->department}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <label for="department">Sub Departemen</label>
                        <input type="text" class="form-control" id="subdepartment" name="subdepartment" placeholder="Wajib diisi" value="">
                    </div>
                </div>
                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <label for="title">Jabatan</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Wajib diisi" value="">
                    </div>
                </div>
            </div>



            <div class="form-group">
                <label for="mail">Email</label>
                <input type="text" class="form-control" id="mail" name="mail" placeholder="Wajib diisi" value="">
            </div>
            <div class="form-group">
                <label for="company">Perusahaan</label>
                <input type="text" class="form-control" id="company" name="company" placeholder="Wajib diisi" value="">
            </div>
            <div class="form-group">
                <label for="manager_name">Atasan Langsung</label>
                <input type="text" class="form-control" id="manager_name" name="manager_name" placeholder="Wajib diisi" value="">
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
            order: [[ 0, 'asc' ]],
            ajax: "{{ route('masteruser.index') }}",
            columns: [
                {data: 'user_id', name: 'user_id'},
                {data: 'password', name: 'password'},
                {data: 'nik', name: 'nik'},
                {data: 'full_name', name: 'full_name'},
                {data: 'department', name: 'department'},
                {data: 'subdepartment', name: 'subdepartment'},
                {data: 'title', name: 'title'},
                {data: 'mail', name: 'mail'},
                {data: 'company', name: 'company'},
                {data: 'manager_name', name: 'manager_name'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        $('#addmasteruser').click(function () {
          $.ajax({
              url: "{{ url('/masteruser/generate_nik') }}",
              type: "GET",
              success: function (data) {
                $(".print-error-msg").find("ul").html('');
                $(".print-error-msg").css('display', 'none');
                $('#saveBtn').val("add-masteruser");
                $('#id').val('0');
                $('#saveBtn').html('Save');
                //$('#masteruserform').trigger("reset");
                $('#modelHeading').html("Form Tambah User");
                $('#insert-update-modal').modal('show');
                $('#user_id').prop('disabled', false);
                $("#nik").val(data[0].nik);
                $("#user_id").val("");
                $("#password").val("");
                $("#full_name").val("");
                $("#department").val("");
                $("#subdepartment").val("");
                $("#title").val("");
                $("#mail").val("");
                $("#company").val("");
                $("#manager_name").val("");
              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
        });

        $('body').on('click', '.editmasteruser', function () {
          var id = $(this).data('id');
          $.get("masteruser" +'/' + id +'/edit', function (data) {
              $(".print-error-msg").find("ul").html('');
              $(".print-error-msg").css('display', 'none');
              $('#modelHeading').html("Edit User");
              $('#saveBtn').val("edit-masteruser");
              $('#saveBtn').html('Save');
              $('#insert-update-modal').modal('show');
              $('#user_id').prop('disabled', true);
              $('#nik').prop('disabled', true);
              $('#id').val(data.id);
              $('#user_id').val(data.user_id);
              $('#password').val(data.password);
              $('#nik').val(data.nik);
              $('#full_name').val(data.full_name);
              $('#department').val(data.department);
              $('#subdepartment').val(data.subdepartment);
              $('#title').val(data.title);
              $('#mail').val(data.mail);
              $('#company').val(data.company);
              $('#manager_name').val(data.manager_name);
          })
        });

        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');
            $.ajax({
              //data: $('#masteruserform').serialize(),
              data:{
                id:$("#id").val()
                , user_id:$("#user_id").val()
                , password:$("#password").val()
                , nik:$("#nik").val()
                , full_name:$("#full_name").val()
                , department:$("#department").val()
                , subdepartment:$("#subdepartment").val()
                , title:$("#title").val()
                , mail:$("#mail").val()
                , company:$("#company").val()
                , manager_name:$("#manager_name").val()
              },
              url: "{{ route('masteruser.store') }}",
              type: "POST",
              dataType: 'json',
              success: function (data) {
                if(data.result == 'true'){
                  $('#masteruserform').trigger("reset");
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

        $('body').on('click', '.deletemasteruser', function () {
          var id = $(this).data("id");
          if(confirm("Are You sure want to delete ?")){
            $.ajax({
              type: "DELETE",
              url: "masteruser"+'/'+id,
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

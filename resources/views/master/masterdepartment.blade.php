@extends('adminlte::page')

@section('title', 'WWS')

@section('content_header')
  <div class="row">
    <div class="col-md-12">
      <h1>Data Master Department</h1>
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
              </br>
              <div class="table-responsive">
                <table id="example2" class="table table-bordered table-hover">
                  <thead style="text-align: center">
                    <tr>
                      <th>Department</th>
                      <th>Head Department</th>
                      <th>Direktur</th>
                      <th>Action</th>
                    </tr>
                  </thead">
                  <tbody style="text-align: center">
                      @foreach ($dept as $item)
                        <tr>
                            <td>{{$item->department}}</td>
                            <td>{{$item->head}}</td>
                            <td>{{$item->direk}}</td>
                            <td>
                                <button class="btn btn-warning" type="button" data-toggle="modal"
                                data-target="#Edit{{$item->id}}" data-whatever="@getbootstrap">Edit</button>
                            </td>
                        </tr>
                        <div class="modal fade" id="Edit{{$item->id}}">
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
                                        <form id="dept" action="{{route('dept-update', Crypt::encrypt($item->id))}}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                          <label for="kdmakanan">Department</label>
                                          <input type="text" class="form-control" id="dept" name="dept" value="{{$item->department}}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="makanan">Head Dept</label>
                                            <select class="form-control select2" style="width: 100%;" name="head">
                                                <option selected="selected" value="{{$item->head_dept}}">{{$item->head}}</option>
                                                @foreach ($user as $head)
                                                    <option value="{{$head->nik}}">{{$head->full_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="makanan">Direktur</label>
                                            <select class="form-control select2" style="width: 100%;" name="direktur">
                                                <option selected="selected" value="{{$item->direktur}}">{{$item->direk}}</option>
                                                @foreach ($user as $head)
                                                    <option value="{{$head->nik}}">{{$head->full_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                    </form>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                      @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.modal -->
@stop

@section('css')

@stop

@section('js')
    <script>
      $(function () {
        $('.select2').select2()

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

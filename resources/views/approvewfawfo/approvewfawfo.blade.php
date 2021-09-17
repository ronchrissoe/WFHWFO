@extends('adminlte::page')

@section('title', 'WWS')

@section('content_header')
    <div class="row">
        <div class="col-md-12">
            <h1>Approve WFH-WFO</h1>
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
                        <div class="col-md-3">
                          <div class="form-group">
                              <label for="nama">Nama :</label>
                              <select id="slcnama" name="nama" class="form-control">
                                  <option value="">--Pilih Nama--</option>
                                  @foreach ($nama as $nik => $nama)
                                  <option value="{{ $nik }}">{{ $nama }}</option>
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
                    <div class="row">
                      <div class="col-md-3">
                          <div class="form-group">
                              <label>Work From Home =</label>&nbsp<label id="lblWFH">0</label><label>%</label>
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                              <label>Work From Office =</label>&nbsp<label id="lblWFO">0</label><label>%</label>
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                              <label>Dinas Luar =</label>&nbsp<label id="lblDL">0</label><label>%</label>
                          </div>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-success" id="btnApproveall">Approve All</button>
                            {{-- <button type="button" class="btn btn-danger" id="btnRejectall">Reject All</button> --}}
                            </br>
                            </br>
                            <div class="table-responsive">
                                <table class="table table-bordered yajra-datatable">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Nama</th>
                                            <th>Jadwal Kerja</th>
                                            {{-- <th>Makan Siang</th> --}}
                                            <th>Keterangan</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- <br/>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Work From Home =</label>&nbsp<label id="lblWFO"></label><label>%</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Work From Anywhere =</label>&nbsp<label id="lblWFA"></label><label>%</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Dinas Luar =</label>&nbsp<label id="lblDNL"></label><label>%</label>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="update-modal">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title" id="modelHeadingupdate"></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger print-error-msg-update" style="display:none">
              <label id="lblerrorupdate" style="font-size: 14px;color:white;display:none"></label>
            </div>
            <form id="wfawfoform3">
            {{ csrf_field() }}
            <input type="hidden" name="idupdate" id="idupdate" value="0">
            <label id="lblmsgupdate" style="font-size: 14px;color:red;display:none"></label>
            <input type="hidden" name="maxupdate" id="maxupdate" value="0">
            <input type="hidden" name="nikupdate" id="nikupdate" value="0">
            <input type="hidden" name="subdepartmentupdate" id="subdepartmentupdate" value="0">
            <input type="hidden" name="alertupdate" id="alertupdate" value="">
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label style="font-size: 14px;" for="tanggalupdate">Tanggal</label>
                  <input style="font-size: 14px;" type="date" class="form-control" id="tanggalupdate" name="tanggalupdate" value="" disabled>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label style="font-size: 14px;" for="kdkerjaupdate">Jadwal Kerja<span id="lblkdkerjaupdatespn" style="font-size: 14px;color:red;display:inline">&nbspX</span></label>
                  <select style="font-size: 14px;" id="kdkerjaupdate" name="kdkerjaupdate" class="form-control" disabled>
                    <option value="">--Pilih Lokasi Kerja--</option>
                    @foreach ($lokkerja as $kdkerja => $kerja)
                    <option value="{{ $kdkerja }}">{{ $kerja }}</option>
                    @endforeach
                  </select>
              </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label style="font-size: 14px;" for="kdmakananupdate">Makan Siang<span id="lblkdmakananupdatespn" style="font-size: 14px;color:red;display:inline">&nbspX</span></label>
                  <select style="font-size: 14px;" id="kdmakananupdate" name="kdmakananupdate" class="form-control" disabled>
                    <option value="">--Pilih Makan Siang--</option>
                    @foreach ($makansiang as $kdmakanan => $makanan)
                    <option value="{{ $kdmakanan }}">{{ $makanan }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label style="font-size: 14px;" for="keteranganupdate">Keterangan<span id="lblketeranganupdatespn" style="font-size: 14px;color:red;display:inline">&nbspX</span></label>
                  <input style="font-size: 14px;" type="text" class="form-control" id="keteranganupdate" name="keteranganupdate" value="" disabled>
                </div>
              </div>
            </div>
            </form>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="saveBtnupdate"></button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <div class="modal fade" id="reject-modal">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title" id="modelHeadingreject"></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger print-error-msg-reject" style="display:none">
              <label id="lblerrorreject" style="font-size: 14px;color:white;display:none"></label>
            </div>
            <form id="wfawfoform4">
            {{ csrf_field() }}
            <input type="hidden" name="idreject" id="idreject" value="0">
            <label id="lblmsgreject" style="font-size: 14px;color:red;display:none"></label>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label style="font-size: 14px;" for="keteranganreject">Keterangan</label>
                  <input style="font-size: 14px;" type="text" class="form-control" id="keteranganreject" name="keteranganreject" value="">
                </div>
              </div>
            </div>
            </form>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="saveBtnreject"></button>
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
              // ajax: "{{ route('inputwfawfo.index') }}",
              ajax: {
                  url: "{{ route('approvewfawfo.index') }}",
                  data: function (d) {
                    d.nik = $("#slcnama :selected").val(),
                    d.tanggalmulai = $('#tanggalmulai').val(),
                    d.tanggalselesai = $('#tanggalselesai').val(),
                    d.department = $("#slcdepartemen :selected").val()
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
                  {data: 'kerja', name: 'kerja'},
                  // {data: 'makanan', name: 'makanan'},
                  {data: 'keterangan_inp', name: 'keterangan_inp'},
                  {data: 'status', name: 'status'},
                  {data: 'action', name: 'action', orderable: false, searchable: false},
              ]
          });

          $('#btnFilter').click(function(e){
                  e.preventDefault();

                  table.draw();

                  percentage();
          });

          function percentage() {
            $.ajax({
                url: "{{ url('/approvewfawfo/percentage') }}",
                data: {
                    nik:$("#slcnama :selected").val()
                    , tanggalmulai:$('#tanggalmulai').val()
                    , tanggalselesai:$('#tanggalselesai').val()
                    , department:$("#slcdepartemen :selected").val()
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

          $('body').on('click', '.editwfawfo', function () {
            var id = $(this).data('id');
            $.get("approvewfawfo" +'/' + id +'/edit', function (data) {
            $('#modelHeadingupdate').html("Edit WFA WFO");
            $('#saveBtn').val("edit-wfawfo");
            $('#saveBtnupdate').html('Save');
            $('#update-modal').modal('show');
            $(".print-error-msg-update").css('display', 'none');
            $("#lblerrorupdate").text("");
            $("#lblerrorupdate").css('display', 'none');
            $("#lblmsgupdate").text("");
            $("#lblmsgupdate").css('display', 'none');
            $("#maxupdate").val("0");
            $("#alertupdate").val("");
            $('#idupdate').val(data.id);
            $('#tanggalupdate').val(data.tanggal);
            $('#kdkerjaupdate').val(data.kdkerja);
            $('#kdmakananupdate').val(data.kdmakanan);
            $('#keteranganupdate').val(data.keterangan_inp);
            $('#nikupdate').val(data.nik);
            $('#subdepartmentupdate').val(data.subdepartment);
            $('#kdkerjaupdate').prop('disabled', false);
            $('#kdmakananupdate').prop('disabled', 'disabled');
            $('#keteranganupdate').prop('disabled', 'disabled');
            $("#lblkdkerjaupdatespn").css('display', 'none');
            $("#lblkdmakananupdatespn").css('display', 'none');
            $("#lblketeranganupdatespn").css('display', 'none');

            cek_wfawfoupdate();
            });
          });

          function printErrorMsg(msg) {
              $(".print-error-msg").find("ul").html('');
              $(".print-error-msg").css('display', 'block');
              $.each(msg, function(key, value) {
              $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
              });
          }

          function cek_wfawfoupdate(){
          if($("#kdkerjaupdate :selected").val() == 'WFO'){
            $.ajax({
              url: "{{ url('/approvewfawfo/maksimumupdatewfawfo') }}",
              data: {tanggal:$("#tanggalupdate").val()
                    , kdkerja:$("#kdkerjaupdate :selected").val()
                    , nik:$("#nikupdate").val()
                    , subdepartment:$("#subdepartmentupdate").val()
                    },
              type: "GET",
              success: function (data) {
                if(data[0].kdkerja == 'WFO' && data[0].maksimum == 'lebih'){
                  $("#lblmsgupdate").text(data[0].alert);
                  $("#lblmsgupdate").css('display', 'block');
                  $('#kdmakananupdate').prop('disabled', false);
                  // $("#kdmakananupdate").val("");
                  $("#keteranganupdate").prop('disabled', false);
                  // $("#keteranganupdate").val("");
                  $("#maxupdate").val("1");
                  $("#alertupdate").val(data[0].alert_value);
                }else{
                  $("#lblmsgupdate").text('');
                  $("#lblmsgupdate").css('display', 'none');
                  $('#kdmakananupdate').prop('disabled', false);
                  // $("#kdmakananupdate").val("");
                  $("#keteranganupdate").prop('disabled', 'disabled');
                  // $("#keteranganupdate").val("");
                  $("#maxupdate").val("0");
                  $("#alertupdate").val("");
                }
              },
              error: function (data) {
                  console.log('Error:', data);
              }
            });
          }else if($("#kdkerjaupdate :selected").val() == 'WFH'){
            $.ajax({
              url: "{{ url('/approvewfawfo/maksimumupdatewfawfo') }}",
              data: {tanggal:$("#tanggalupdate").val()
                    , kdkerja:$("#kdkerjaupdate :selected").val()
                    , nik:$("#nikupdate").val()
                    , subdepartment:$("#subdepartmentupdate").val()
                    },
              type: "GET",
              success: function (data) {
                if(data[0].kdkerja == 'WFH' && data[0].maksimum == 'lebih'){
                  $("#lblmsgupdate").text(data[0].alert);
                  $("#lblmsgupdate").css('display', 'block');
                  $('#kdmakananupdate').prop('disabled', 'disabled');
                  $("#kdmakananupdate").val("");
                  $("#keteranganupdate").prop('disabled', false);
                  // $("#keteranganupdate").val("");
                  $("#maxupdate").val("1");
                  $("#alertupdate").val(data[0].alert_value);
                }else{
                  $("#lblmsgupdate").text('');
                  $("#lblmsgupdate").css('display', 'none');
                  $('#kdmakananupdate').prop('disabled', 'disabled');
                  $("#kdmakananupdate").val("");
                  $("#keteranganupdate").prop('disabled', 'disabled');
                  // $("#keteranganupdate").val("");
                  $("#maxupdate").val("0");
                  $("#alertupdate").val("");
                }
              },
              error: function (data) {
                  console.log('Error:', data);
              }
            });
          }else{
            $('#kdmakananupdate').prop('disabled', 'disabled');
            $("#kdmakananupdate").val("");
            $("#keteranganupdate").prop('disabled', 'disabled');
            $("#keteranganupdate").val("");
            $("#lblmsgupdate").text('');
            $("#lblmsgupdate").css('display', 'none');
            $("#maxupdate").val("0");
            $("#alertupdate").val("");
          }
        }

        function maksimumupdatewfawfo() {
          if($("#kdkerjaupdate :selected").val() == 'WFO'){
            $.ajax({
              url: "{{ url('/approvewfawfo/maksimumupdatewfawfo') }}",
              data: {tanggal:$("#tanggalupdate").val()
                    , kdkerja:$("#kdkerjaupdate :selected").val()
                    , nik:$("#nikupdate").val()
                    , subdepartment:$("#subdepartmentupdate").val()
                    },
              type: "GET",
              success: function (data) {
                if(data[0].kdkerja == 'WFO' && data[0].maksimum == 'lebih'){
                  $("#lblmsgupdate").text(data[0].alert);
                  $("#lblmsgupdate").css('display', 'block');
                  $('#kdmakananupdate').prop('disabled', false);
                  $("#kdmakananupdate").val("");
                  $("#keteranganupdate").prop('disabled', false);
                  $("#keteranganupdate").val("");
                  $("#maxupdate").val("1");
                  $("#alertupdate").val(data[0].alert_value);
                }else{
                  $("#lblmsgupdate").text('');
                  $("#lblmsgupdate").css('display', 'none');
                  $('#kdmakananupdate').prop('disabled', false);
                  $("#kdmakananupdate").val("");
                  $("#keteranganupdate").prop('disabled', 'disabled');
                  $("#keteranganupdate").val("");
                  $("#maxupdate").val("0");
                  $("#alertupdate").val("");
                }
              },
              error: function (data) {
                  console.log('Error:', data);
              }
            });
          }else if($("#kdkerjaupdate :selected").val() == 'WFH'){
            $.ajax({
              url: "{{ url('/approvewfawfo/maksimumupdatewfawfo') }}",
              data: {tanggal:$("#tanggalupdate").val()
                    , kdkerja:$("#kdkerjaupdate :selected").val()
                    , nik:$("#nikupdate").val()
                    , subdepartment:$("#subdepartmentupdate").val()
                    },
              type: "GET",
              success: function (data) {
                if(data[0].kdkerja == 'WFH' && data[0].maksimum == 'lebih'){
                  $("#lblmsgupdate").text(data[0].alert);
                  $("#lblmsgupdate").css('display', 'block');
                  $('#kdmakananupdate').prop('disabled', 'disabled');
                  $("#kdmakananupdate").val("");
                  $("#keteranganupdate").prop('disabled', false);
                  $("#keteranganupdate").val("");
                  $("#maxupdate").val("1");
                  $("#alertupdate").val(data[0].alert_value);
                }else{
                  $("#lblmsgupdate").text('');
                  $("#lblmsgupdate").css('display', 'none');
                  $('#kdmakananupdate').prop('disabled', 'disabled');
                  $("#kdmakananupdate").val("");
                  $("#keteranganupdate").prop('disabled', 'disabled');
                  $("#keteranganupdate").val("");
                  $("#maxupdate").val("0");
                  $("#alertupdate").val("");
                }
              },
              error: function (data) {
                  console.log('Error:', data);
              }
            });
          }else{
            $('#kdmakananupdate').prop('disabled', 'disabled');
            $("#kdmakananupdate").val("");
            $("#keteranganupdate").prop('disabled', 'disabled');
            $("#keteranganupdate").val("");
            $("#lblmsgupdate").text('');
            $("#lblmsgupdate").css('display', 'none');
            $("#maxupdate").val("0");
            $("#alertupdate").val("");
          }
        }

        $("#kdkerjaupdate").change(maksimumupdatewfawfo);

        $('#saveBtnupdate').click(function (e) {
          if(validate_update() == 'true'){
            e.preventDefault();
            $(this).html('Sending..');
            $.ajax({
              data: {
                id:$("#idupdate").val()
                , tanggal:$("#tanggalupdate").val()
                , kdkerja:$("#kdkerjaupdate :selected").val()
                , kdmakanan:$("#kdmakananupdate :selected").val()
                , keterangan:$("#keteranganupdate").val()
                , alert:$("#alertupdate").val()
              },
              url: "{{ route('approvewfawfo.store') }}",
              type: "POST",
              dataType: 'json',
              success: function (data) {
                if(data.result == 'true'){
                  $('#wfawfoform3').trigger("reset");
                  $('#update-modal').modal('hide');
                  table.draw();
                  Swal.fire({
                    type: 'success',
                    title: 'Success',
                    text: data.message,
                    scrollbarPadding : false
                  });
                  percentage();
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
          }
        });

        function cek_keteranganupdate(){
          if($("#keteranganupdate").val() == ''){
            $("#maxupdate").val("1");
          }else{
            $("#maxupdate").val("0");
          }
        }

        $("#keteranganupdate").change(cek_keteranganupdate);

        function validate_update(){
          if($("#kdkerjaupdate :selected").val() == '' && $("#keteranganupdate").val() != 'Hari Libur'){
            $(".print-error-msg-update").css('display', 'block');
            $("#lblerrorupdate").text('Jadwal Kerja Harus Di Pilih');
            $("#lblerrorupdate").css('display', 'block');
            $("#lblkdkerjaupdatespn").css('display', 'inline');
            $("#lblkdmakananupdatespn").css('display', 'none');
            $("#lblketeranganupdatespn").css('display', 'none');
            return "false";
          }else if($("#kdkerjaupdate :selected").val() == 'WFO' && $("#kdmakananupdate :selected").val() == ''){
            $(".print-error-msg-update").css('display', 'block');
            $("#lblerrorupdate").text('Makan Siang Harus Di Pilih');
            $("#lblerrorupdate").css('display', 'block');
            $("#lblkdkerjaupdatespn").css('display', 'none');
            $("#lblkdmakananupdatespn").css('display', 'inline');
            $("#lblketeranganupdatespn").css('display', 'none');
            return "false";
          }else if($("#maxupdate").val() == '1'){
            $(".print-error-msg-update").css('display', 'block');
            $("#lblerrorupdate").text('Keterangan Harus Di Isi');
            $("#lblerrorupdate").css('display', 'block');
            $("#lblkdkerjaupdatespn").css('display', 'none');
            $("#lblkdmakananupdatespn").css('display', 'none');
            $("#lblketeranganupdatespn").css('display', 'inline');
            return "false";
          }else{
            return "true";
          }
        }

          $('body').on('click', '.approvewfawfo', function () {
              var id = $(this).data("id");
              $.ajax({
                data: {
                  id:id
                },
                url: "{{ route('approvewfawfo.approve') }}",
                type: "POST",
                success: function (response) {
                    window.location.href = response.url;
                    percentage();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
              });
          });

          $('#btnApproveall').click(function (e) {
              e.preventDefault();
              $.ajax({
                url: "{{ route('approvewfawfo.approveall') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    window.location.href = response.url;
                    percentage();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
              });
          });

          $('body').on('click', '.rejectwfawfo', function () {
            var id = $(this).data('id');
            $('#modelHeadingreject').html("Reject WFA WFO");
            $('#saveBtn').val("reject-wfawfo");
            $('#saveBtnreject').html('Save');
            $('#reject-modal').modal('show');
            $('#idreject').val(id);
            $(".print-error-msg-reject").css('display', 'none');
            $("#lblerrorreject").text("");
            $("#lblerrorreject").css('display', 'none');
            $("#keteranganreject").val("");
          });

          $('#saveBtnreject').click(function (e) {
          if(validate_reject() == 'true'){
            e.preventDefault();
            $(this).html('Sending..');
            $.ajax({
              data: {
                id:$("#idreject").val()
                , keterangan:$("#keteranganreject").val()
              },
              url: "{{ route('approvewfawfo.reject') }}",
              type: "POST",
              dataType: 'json',
              success: function (data) {
                if(data.result == 'true'){
                  $('#wfawfoform4').trigger("reset");
                  $('#reject-modal').modal('hide');
                  table.draw();
                  Swal.fire({
                    type: 'success',
                    title: 'Success',
                    text: data.message,
                    scrollbarPadding : false
                  });
                  percentage();
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
          }
        });

        function validate_reject(){
          if($("#keteranganreject").val() == ''){
            $(".print-error-msg-reject").css('display', 'block');
            $("#lblerrorreject").text('Keterangan Harus Di Isi');
            $("#lblerrorreject").css('display', 'block');
            return "false";
          }else{
            return "true";
          }
        }

        });
    </script>
@stop

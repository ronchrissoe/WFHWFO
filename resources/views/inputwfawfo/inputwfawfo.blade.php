@extends('adminlte::page')

@section('title', 'WWS')

@section('content_header')
    <div class="row">
        <div class="col-md-12">
            <h1>Jadwal WFH-WFO Anda</h1>
        </div>
    </div>
@stop

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          {{-- <div class="row">
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
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <button type="button" class="btn btn-primary" id="btnFilter">Filter</button>
              </div>
            </div>
          </div>
          </br> --}}
          <div class="row">
            <div class="col-md-12">
              @if(Session::has('Department'))
              <input type="hidden" name="department" id="department" value="{{ Session::get('Department')}}">
              @endif
              @if(Session::has('Nik'))
              <input type="hidden" name="nik" id="nik" value="{{ Session::get('Nik')}}">
              @endif
              <div class="row">
                <div class="col-md-12 text-right">
                    <a class="btn btn-primary" href="javascript:void(0)" id="addwfawfo"> Tambah WFH-WFO</a>
                </div>
              </div>
              </br>
              <div class="table-responsive">
                <table class="table table-bordered yajra-datatable">
                  <thead>
                  <tr>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Jadwal Kerja</th>
                    <th>Makan Siang</th>
                    <th>Keterangan</th>
                    <th>Keterangan Reject</th>
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
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="insert-update-modal">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="modelHeading"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger print-error-msg" style="display:none">
              <label id="lblerror" style="font-size: 14px;color:white;display:none"></label>
            </div>
            <form id="wfawfoform" action="{{route('inputwfawfo.store')}}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="id" id="id" value="0">
            <label id="lblmsg" style="font-size: 14px;color:red;display:none"></label>
            <input type="hidden" name="max" id="max" value="0">
            <input type="hidden" name="alert" id="alert" value="">
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label style="font-size: 14px;" for="tanggal">Tanggal</label>
                  <input style="font-size: 14px;" type="date" class="form-control" id="tanggal" name="tanggal" readonly>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label style="font-size: 14px;" for="kdkerja">Jadwal Kerja<span id="lblkdkerjaspn" style="font-size: 14px;color:red;display:none">&nbspX</span></label>
                  <select style="font-size: 14px;" id="kdkerja" name="kdkerja" class="form-control" required disabled>
                    <option value="">--Pilih Jadwal Kerja--</option>
                    @foreach ($lokkerja as $kdkerja => $kerja)
                    <option value="{{ $kdkerja }}">{{ $kerja }}</option>
                    @endforeach
                  </select>
              </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label style="font-size: 14px;" for="kdmakanan">Makan Siang<span id="lblkdmakananspn" style="font-size: 14px;color:red;display:inline">&nbspX</span></label>
                  <select style="font-size: 14px;" id="kdmakanan" name="kdmakanan" class="form-control" disabled>
                    <option value="">--Pilih Makan Siang--</option>
                    @foreach ($makansiang as $kdmakanan => $makanan)
                    <option value="{{ $kdmakanan }}">{{ $makanan }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label style="font-size: 14px;" for="keterangan">Keterangan<span id="lblketeranganspn" style="font-size: 14px;color:red;display:inline">&nbspX</span></label>
                  <input style="font-size: 14px;" type="text" class="form-control" id="keterangan" name="keterangan" value="" disabled>
                </div>
              </div>
            </div>
            <label id="lblmsg2" style="font-size: 14px;color:red;display:none"></label>
            <input type="hidden" name="max2" id="max2" value="0">
            <input type="hidden" name="alert2" id="alert2" value="">
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label style="font-size: 14px;" for="tanggal2">Tanggal</label>
                  <input style="font-size: 14px;" type="date" class="form-control" id="tanggal2" name="tanggal2" readonly>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label style="font-size: 14px;" for="kdkerja2">Jadwal Kerja<span id="lblkdkerja2spn" style="font-size: 14px;color:red;display:inline">&nbspX</span></label>
                  <select style="font-size: 14px;" id="kdkerja2" name="kdkerja2" class="form-control" required disabled>
                    <option value="">--Pilih Jadwal Kerja--</option>
                    @foreach ($lokkerja as $kdkerja => $kerja)
                    <option value="{{ $kdkerja }}">{{ $kerja }}</option>
                    @endforeach
                  </select>
              </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label style="font-size: 14px;" for="kdmakanan2">Makan Siang<span id="lblkdmakanan2spn" style="font-size: 14px;color:red;display:inline">&nbspX</span></label>
                  <select style="font-size: 14px;" id="kdmakanan2" name="kdmakanan2" class="form-control" disabled>
                    <option value="">--Pilih Makan Siang--</option>
                    @foreach ($makansiang as $kdmakanan => $makanan)
                    <option value="{{ $kdmakanan }}">{{ $makanan }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label style="font-size: 14px;" for="keterangan2">Keterangan<span id="lblketerangan2spn" style="font-size: 14px;color:red;display:inline">&nbspX</span></label>
                  <input style="font-size: 14px;" type="text" class="form-control" id="keterangan2" name="keterangan2" value="" disabled>
                </div>
              </div>
            </div>
            <label id="lblmsg3" style="font-size: 14px;color:red;display:none"></label>
            <input type="hidden" name="max3" id="max3" value="0">
            <input type="hidden" name="alert3" id="alert3" value="">
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label style="font-size: 14px;" for="tanggal3">Tanggal</label>
                  <input style="font-size: 14px;" type="date" class="form-control" id="tanggal3" name="tanggal3" readonly>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label style="font-size: 14px;" for="kdkerja3">Jadwal Kerja<span id="lblkdkerja3spn" style="font-size: 14px;color:red;display:inline">&nbspX</span></label>
                  <select style="font-size: 14px;" id="kdkerja3" name="kdkerja3" class="form-control" required disabled>
                    <option value="">--Pilih Jadwal Kerja--</option>
                    @foreach ($lokkerja as $kdkerja => $kerja)
                    <option value="{{ $kdkerja }}">{{ $kerja }}</option>
                    @endforeach
                  </select>
              </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label style="font-size: 14px;" for="kdmakanan3">Makan Siang<span id="lblkdmakanan3spn" style="font-size: 14px;color:red;display:inline">&nbspX</span></label>
                  <select style="font-size: 14px;" id="kdmakanan3" name="kdmakanan3" class="form-control" disabled>
                    <option value="">--Pilih Makan Siang--</option>
                    @foreach ($makansiang as $kdmakanan => $makanan)
                    <option value="{{ $kdmakanan }}">{{ $makanan }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label style="font-size: 14px;" for="keterangan3">Keterangan<span id="lblketerangan3spn" style="font-size: 14px;color:red;display:inline">&nbspX</span></label>
                  <input style="font-size: 14px;" type="text" class="form-control" id="keterangan3" name="keterangan3" value="" disabled>
                </div>
              </div>
            </div>
            <label id="lblmsg4" style="font-size: 14px;color:red;display:none"></label>
            <input type="hidden" name="max4" id="max4" value="0">
            <input type="hidden" name="alert4" id="alert4" value="">
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label style="font-size: 14px;" for="tanggal4">Tanggal</label>
                  <input style="font-size: 14px;" type="date" class="form-control" id="tanggal4" name="tanggal4" readonly>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label style="font-size: 14px;" for="kdkerja4">Jadwal Kerja<span id="lblkdkerja4spn" style="font-size: 14px;color:red;display:inline">&nbspX</span></label>
                  <select style="font-size: 14px;" id="kdkerja4" name="kdkerja4" class="form-control" required disabled>
                    <option value="">--Pilih Jadwal Kerja--</option>
                    @foreach ($lokkerja as $kdkerja => $kerja)
                    <option value="{{ $kdkerja }}">{{ $kerja }}</option>
                    @endforeach
                  </select>
              </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label style="font-size: 14px;" for="kdmakanan4">Makan Siang<span id="lblkdmakanan4spn" style="font-size: 14px;color:red;display:inline">&nbspX</span></label>
                  <select style="font-size: 14px;" id="kdmakanan4" name="kdmakanan4" class="form-control" disabled>
                    <option value="">--Pilih Makan Siang--</option>
                    @foreach ($makansiang as $kdmakanan => $makanan)
                    <option value="{{ $kdmakanan }}">{{ $makanan }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label style="font-size: 14px;" for="keterangan4">Keterangan<span id="lblketerangan4spn" style="font-size: 14px;color:red;display:inline">&nbspX</span></label>
                  <input style="font-size: 14px;" type="text" class="form-control" id="keterangan4" name="keterangan4" value="" disabled>
                </div>
              </div>
            </div>
            <label id="lblmsg5" style="font-size: 14px;color:red;display:none"></label>
            <input type="hidden" name="max5" id="max5" value="0">
            <input type="hidden" name="alert5" id="alert5" value="">
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label style="font-size: 14px;" for="tanggal5">Tanggal</label>
                  <input style="font-size: 14px;" type="date" class="form-control" id="tanggal5" name="tanggal5" readonly>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label style="font-size: 14px;" for="kdkerja5">Jadwal Kerja<span id="lblkdkerja5spn" style="font-size: 14px;color:red;display:inline">&nbspX</span></label>
                  <select style="font-size: 14px;" id="kdkerja5" name="kdkerja5" class="form-control" required disabled>
                    <option value="">--Pilih Jadwal Kerja--</option>
                    @foreach ($lokkerja as $kdkerja => $kerja)
                    <option value="{{ $kdkerja }}">{{ $kerja }}</option>
                    @endforeach
                  </select>
              </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label style="font-size: 14px;" for="kdmakanan5">Makan Siang<span id="lblkdmakanan5spn" style="font-size: 14px;color:red;display:inline">&nbspX</span></label>
                  <select style="font-size: 14px;" id="kdmakanan5" name="kdmakanan5" class="form-control" disabled>
                    <option value="">--Pilih Makan Siang--</option>
                    @foreach ($makansiang as $kdmakanan => $makanan)
                    <option value="{{ $kdmakanan }}">{{ $makanan }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label style="font-size: 14px;" for="keterangan5">Keterangan<span id="lblketerangan5spn" style="font-size: 14px;color:red;display:inline">&nbspX</span></label>
                  <input style="font-size: 14px;" type="text" class="form-control" id="keterangan5" name="keterangan5" value="" disabled>
                </div>
              </div>
            </div>
            <label id="lblmsg6" style="font-size: 14px;color:red;display:none"></label>
            <input type="hidden" name="max6" id="max6" value="0">
            <input type="hidden" name="alert6" id="alert6" value="">
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label style="font-size: 14px;" for="tanggal6">Tanggal</label>
                  <input style="font-size: 14px;" type="date" class="form-control" id="tanggal6" name="tanggal6" readonly>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label style="font-size: 14px;" for="kdkerja6">Jadwal Kerja<span id="lblkdkerja6spn" style="font-size: 14px;color:red;display:inline">&nbspX</span></label>
                  <select style="font-size: 14px;" id="kdkerja6" name="kdkerja6" class="form-control" required disabled>
                    <option value="">--Pilih Jadwal Kerja--</option>
                    @foreach ($lokkerja as $kdkerja => $kerja)
                    <option value="{{ $kdkerja }}">{{ $kerja }}</option>
                    @endforeach
                  </select>
              </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label style="font-size: 14px;" for="kdmakanan6">Makan Siang<span id="lblkdmakanan6spn" style="font-size: 14px;color:red;display:inline">&nbspX</span></label>
                  <select style="font-size: 14px;" id="kdmakanan6" name="kdmakanan6" class="form-control" disabled>
                    <option value="">--Pilih Makan Siang--</option>
                    @foreach ($makansiang as $kdmakanan => $makanan)
                    <option value="{{ $kdmakanan }}">{{ $makanan }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label style="font-size: 14px;" for="keterangan6">Keterangan<span id="lblketerangan6spn" style="font-size: 14px;color:red;display:inline">&nbspX</span></label>
                  <input style="font-size: 14px;" type="text" class="form-control" id="keterangan6" name="keterangan6" value="" disabled>
                </div>
              </div>
            </div>
            <label id="lblmsg7" style="font-size: 14px;color:red;display:none"></label>
            <input type="hidden" name="max7" id="max7" value="0">
            <input type="hidden" name="alert7" id="alert7" value="">
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label style="font-size: 14px;" for="tanggal7">Tanggal</label>
                  <input style="font-size: 14px;" type="date" class="form-control" id="tanggal7" name="tanggal7" readonly>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label style="font-size: 14px;" for="kdkerja7">Jadwal Kerja<span id="lblkdkerja7spn" style="font-size: 14px;color:red;display:inline">&nbspX</span></label>
                  <select style="font-size: 14px;" id="kdkerja7" name="kdkerja7" class="form-control" required disabled>
                    <option value="">--Pilih Jadwal Kerja--</option>
                    @foreach ($lokkerja as $kdkerja => $kerja)
                    <option value="{{ $kdkerja }}">{{ $kerja }}</option>
                    @endforeach
                  </select>
              </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label style="font-size: 14px;" for="kdmakanan7">Makan Siang<span id="lblkdmakanan7spn" style="font-size: 14px;color:red;display:inline">&nbspX</span></label>
                  <select style="font-size: 14px;" id="kdmakanan7" name="kdmakanan7" class="form-control" disabled>
                    <option value="">--Pilih Makan Siang--</option>
                    @foreach ($makansiang as $kdmakanan => $makanan)
                    <option value="{{ $kdmakanan }}">{{ $makanan }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label style="font-size: 14px;" for="keterangan7">Keterangan<span id="lblketerangan7spn" style="font-size: 14px;color:red;display:inline">&nbspX</span></label>
                  <input style="font-size: 14px;" type="text" class="form-control" id="keterangan7" name="keterangan7" value="" disabled>
                </div>
              </div>
            </div>
            <label id="lblmsg8" style="font-size: 14px;color:red;display:none"></label>
            <input type="hidden" name="max8" id="max8" value="0">
            <input type="hidden" name="alert8" id="alert8" value="">
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label style="font-size: 14px;" for="tanggal8">Tanggal</label>
                  <input style="font-size: 14px;" type="date" class="form-control" id="tanggal8" name="tanggal8" readonly>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label style="font-size: 14px;" for="kdkerja8">Jadwal Kerja<span id="lblkdkerja8spn" style="font-size: 14px;color:red;display:inline">&nbspX</span></label>
                  <select style="font-size: 14px;" id="kdkerja8" name="kdkerja8" class="form-control" required disabled>
                    <option value="">--Pilih Jadwal Kerja--</option>
                    @foreach ($lokkerja as $kdkerja => $kerja)
                    <option value="{{ $kdkerja }}">{{ $kerja }}</option>
                    @endforeach
                  </select>
              </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label style="font-size: 14px;" for="kdmakanan8">Makan Siang<span id="lblkdmakanan8spn" style="font-size: 14px;color:red;display:inline">&nbspX</span></label>
                  <select style="font-size: 14px;" id="kdmakanan8" name="kdmakanan8" class="form-control" disabled>
                    <option value="">--Pilih Makan Siang--</option>
                    @foreach ($makansiang as $kdmakanan => $makanan)
                    <option value="{{ $kdmakanan }}">{{ $makanan }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label style="font-size: 14px;" for="keterangan8">Keterangan<span id="lblketerangan8spn" style="font-size: 14px;color:red;display:inline">&nbspX</span></label>
                  <input style="font-size: 14px;" type="text" class="form-control" id="keterangan8" name="keterangan8" value="" disabled>
                </div>
              </div>
            </div>
            <label id="lblmsg9" style="font-size: 14px;color:red;display:none"></label>
            <input type="hidden" name="max9" id="max9" value="0">
            <input type="hidden" name="alert9" id="alert9" value="">
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label style="font-size: 14px;" for="tanggal9">Tanggal</label>
                  <input style="font-size: 14px;" type="date" class="form-control" id="tanggal9" name="tanggal9" readonly>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label style="font-size: 14px;" for="kdkerja9">Jadwal Kerja<span id="lblkdkerja9spn" style="font-size: 14px;color:red;display:inline">&nbspX</span></label>
                  <select style="font-size: 14px;" id="kdkerja9" name="kdkerja9" class="form-control" required disabled>
                    <option value="">--Pilih Jadwal Kerja--</option>
                    @foreach ($lokkerja as $kdkerja => $kerja)
                    <option value="{{ $kdkerja }}">{{ $kerja }}</option>
                    @endforeach
                  </select>
              </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label style="font-size: 14px;" for="kdmakanan9">Makan Siang<span id="lblkdmakanan9spn" style="font-size: 14px;color:red;display:inline">&nbspX</span></label>
                  <select style="font-size: 14px;" id="kdmakanan9" name="kdmakanan9" class="form-control" disabled>
                    <option value="">--Pilih Makan Siang--</option>
                    @foreach ($makansiang as $kdmakanan => $makanan)
                    <option value="{{ $kdmakanan }}">{{ $makanan }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label style="font-size: 14px;" for="keterangan9">Keterangan<span id="lblketerangan9spn" style="font-size: 14px;color:red;display:inline">&nbspX</span></label>
                  <input style="font-size: 14px;" type="text" class="form-control" id="keterangan9" name="keterangan9" value="" disabled>
                </div>
              </div>
            </div>
            <label id="lblmsg10" style="font-size: 14px;color:red;display:none"></label>
            <input type="hidden" name="max10" id="max10" value="0">
            <input type="hidden" name="alert10" id="alert10" value="">
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label style="font-size: 14px;" for="tanggal10">Tanggal</label>
                  <input style="font-size: 14px;" type="date" class="form-control" id="tanggal10" name="tanggal10"  readonly>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label style="font-size: 14px;" for="kdkerja10">Jadwal Kerja<span id="lblkdkerja10spn" style="font-size: 14px;color:red;display:inline">&nbspX</span></label>
                  <select style="font-size: 14px;" id="kdkerja10" name="kdkerja10" class="form-control" required disabled>
                    <option value="">--Pilih Jadwal Kerja--</option>
                    @foreach ($lokkerja as $kdkerja => $kerja)
                    <option value="{{ $kdkerja }}">{{ $kerja }}</option>
                    @endforeach
                  </select>
              </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label style="font-size: 14px;" for="kdmakanan10">Makan Siang<span id="lblkdmakanan10spn" style="font-size: 14px;color:red;display:inline">&nbspX</span></label>
                  <select style="font-size: 14px;" id="kdmakanan10" name="kdmakanan10" class="form-control" disabled>
                    <option value="">--Pilih Makan Siang--</option>
                    @foreach ($makansiang as $kdmakanan => $makanan)
                    <option value="{{ $kdmakanan }}">{{ $makanan }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label style="font-size: 14px;" for="keterangan10">Keterangan<span id="lblketerangan10spn" style="font-size: 14px;color:red;display:inline">&nbspX</span></label>
                  <input style="font-size: 14px;" type="text" class="form-control" id="keterangan10" name="keterangan10" value="" disabled>
                </div>
              </div>
            </div>

        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
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
          <form id="wfawfoform2" action="{{route('inputwfawfo.store')}}" method="POST">
          {{ csrf_field() }}
          <input type="hidden" name="idupdate" id="idupdate">
          <label id="lblmsgupdate" style="font-size: 14px;color:red;display:none"></label>
          <input type="hidden" name="maxupdate" id="maxupdate" value="0">
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
                <select style="font-size: 14px;" id="kdkerjaupdate" name="kdkerjaupdate" class="form-control">
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
                <select style="font-size: 14px;" id="kdmakananupdate" name="kdmakananupdate" class="form-control">
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

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </form>
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
            searching: false,
            order: [[ 0, 'desc' ]],
            // ajax: "{{ route('inputwfawfo.index') }}",
            ajax: {
              url: "{{ route('inputwfawfo.index') }}",
              // data: function (d) {
              //   d.tanggalmulai = $('#tanggalmulai').val(),
              //   d.tanggalselesai = $('#tanggalselesai').val()
              // }
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
                {data: 'makanan', name: 'makanan'},
                {data: 'keterangan_inp', name: 'keterangan_inp'},
                {data: 'keterangan_rjc', name: 'keterangan_rjc'},
                {data: 'badge', name: 'badge', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        $('#addwfawfo').click(function () {
          $.ajax({
              url: "{{ url('/inputwfawfo/cek_jadwal_wfhwfo') }}",
              data: {nik:$("#nik").val()
                    },
              type: "GET",
              success: function (data) {
                if(data[0].result == 'True'){
                  Swal.fire({
                      type: 'error',
                      title: 'Oops...',
                      text: 'Anda sudah menginput jadwal WFH-WFO',
                      scrollbarPadding : false
                  })
                }else{
                  $.ajax({
                        url: "{{ url('/inputwfawfo/cek_department') }}",
                        data: {department:$("#department").val()
                                },
                        type: "GET",
                        success: function (data) {
                            if(data[0].result == 'True'){
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Departemen anda belum termapping',
                                scrollbarPadding : false
                            })
                            }else{
                            $(".print-error-msg").css('display', 'none');
                            $('#saveBtn').val("add-wfawfo");
                            $('#id').val('0');
                            $('#saveBtn').html('Save');
                            // $('#wfawfoform').trigger("reset");
                            $('#modelHeading').html("Form Tambah Jadwal WFH-WFO");
                            $('#insert-update-modal').modal('show');
                            // update_kdmakanan();
                            $("#lblerror").text("");
                            $("#lblerror").css('display', 'none');

                            $("#lblmsg").text("");
                            $("#lblmsg").css('display', 'none');
                            $("#max").val("0");
                            $("#alert").val("");
                            $("#tanggal").val("");
                            $("#kdkerja").val("");
                            $("#kdmakanan").val("");
                            $("#keterangan").val("");
                            $('#kdkerja').prop('disabled', 'disabled');
                            $('#kdmakanan').prop('disabled', 'disabled');
                            $('#keterangan').prop('disabled', 'disabled');
                            $("#lblkdkerjaspn").css('display', 'none');
                            $("#lblkdmakananspn").css('display', 'none');
                            $("#lblketeranganspn").css('display', 'none');

                            $("#lblmsg2").text("");
                            $("#lblmsg2").css('display', 'none');
                            $("#max2").val("0");
                            $("#alert2").val("");
                            $("#tanggal2").val("");
                            $("#kdkerja2").val("");
                            $("#kdmakanan2").val("");
                            $("#keterangan2").val("");
                            $('#kdkerja2').prop('disabled', 'disabled');
                            $('#kdmakanan2').prop('disabled', 'disabled');
                            $('#keterangan2').prop('disabled', 'disabled');
                            $("#lblkdkerja2spn").css('display', 'none');
                            $("#lblkdmakanan2spn").css('display', 'none');
                            $("#lblketerangan2spn").css('display', 'none');

                            $("#lblmsg3").text("");
                            $("#lblmsg3").css('display', 'none');
                            $("#max3").val("0");
                            $("#alert3").val("");
                            $("#tanggal3").val("");
                            $("#kdkerja3").val("");
                            $("#kdmakanan3").val("");
                            $("#keterangan3").val("");
                            $('#kdkerja3').prop('disabled', 'disabled');
                            $('#kdmakanan3').prop('disabled', 'disabled');
                            $('#keterangan3').prop('disabled', 'disabled');
                            $("#lblkdkerja3spn").css('display', 'none');
                            $("#lblkdmakanan3spn").css('display', 'none');
                            $("#lblketerangan3spn").css('display', 'none');

                            $("#lblmsg4").text("");
                            $("#lblmsg4").css('display', 'none');
                            $("#max4").val("0");
                            $("#alert4").val("");
                            $("#tanggal4").val("");
                            $("#kdkerja4").val("");
                            $("#kdmakanan4").val("");
                            $("#keterangan4").val("");
                            $('#kdkerja4').prop('disabled', 'disabled');
                            $('#kdmakanan4').prop('disabled', 'disabled');
                            $('#keterangan4').prop('disabled', 'disabled');
                            $("#lblkdkerja4spn").css('display', 'none');
                            $("#lblkdmakanan4spn").css('display', 'none');
                            $("#lblketerangan4spn").css('display', 'none');

                            $("#lblmsg5").text("");
                            $("#lblmsg5").css('display', 'none');
                            $("#max5").val("0");
                            $("#alert5").val("");
                            $("#tanggal5").val("");
                            $("#kdkerja5").val("");
                            $("#kdmakanan5").val("");
                            $("#keterangan5").val("");
                            $('#kdkerja5').prop('disabled', 'disabled');
                            $('#kdmakanan5').prop('disabled', 'disabled');
                            $('#keterangan5').prop('disabled', 'disabled');
                            $("#lblkdkerja5spn").css('display', 'none');
                            $("#lblkdmakanan5spn").css('display', 'none');
                            $("#lblketerangan5spn").css('display', 'none');

                            $("#lblmsg6").text("");
                            $("#lblmsg6").css('display', 'none');
                            $("#max6").val("0");
                            $("#alert6").val("");
                            $("#tanggal6").val("");
                            $("#kdkerja6").val("");
                            $("#kdmakanan6").val("");
                            $("#keterangan6").val("");
                            $('#kdkerja6').prop('disabled', 'disabled');
                            $('#kdmakanan6').prop('disabled', 'disabled');
                            $('#keterangan6').prop('disabled', 'disabled');
                            $("#lblkdkerja6spn").css('display', 'none');
                            $("#lblkdmakanan6spn").css('display', 'none');
                            $("#lblketerangan6spn").css('display', 'none');

                            $("#lblmsg7").text("");
                            $("#lblmsg7").css('display', 'none');
                            $("#max7").val("0");
                            $("#alert7").val("");
                            $("#tanggal7").val("");
                            $("#kdkerja7").val("");
                            $("#kdmakanan7").val("");
                            $("#keterangan7").val("");
                            $('#kdkerja7').prop('disabled', 'disabled');
                            $('#kdmakanan7').prop('disabled', 'disabled');
                            $('#keterangan7').prop('disabled', 'disabled');
                            $("#lblkdkerja7spn").css('display', 'none');
                            $("#lblkdmakanan7spn").css('display', 'none');
                            $("#lblketerangan7spn").css('display', 'none');

                            $("#lblmsg8").text("");
                            $("#lblmsg8").css('display', 'none');
                            $("#max8").val("0");
                            $("#alert8").val("");
                            $("#tanggal8").val("");
                            $("#kdkerja8").val("");
                            $("#kdmakanan8").val("");
                            $("#keterangan8").val("");
                            $('#kdkerja8').prop('disabled', 'disabled');
                            $('#kdmakanan8').prop('disabled', 'disabled');
                            $('#keterangan8').prop('disabled', 'disabled');
                            $("#lblkdkerja8spn").css('display', 'none');
                            $("#lblkdmakanan8spn").css('display', 'none');
                            $("#lblketerangan8spn").css('display', 'none');

                            $("#lblmsg9").text("");
                            $("#lblmsg9").css('display', 'none');
                            $("#max9").val("0");
                            $("#alert9").val("");
                            $("#tanggal9").val("");
                            $("#kdkerja9").val("");
                            $("#kdmakanan9").val("");
                            $("#keterangan9").val("");
                            $('#kdkerja9').prop('disabled', 'disabled');
                            $('#kdmakanan9').prop('disabled', 'disabled');
                            $('#keterangan9').prop('disabled', 'disabled');
                            $("#lblkdkerja9spn").css('display', 'none');
                            $("#lblkdmakanan9spn").css('display', 'none');
                            $("#lblketerangan9spn").css('display', 'none');

                            $("#lblmsg10").text("");
                            $("#lblmsg10").css('display', 'none');
                            $("#max10").val("0");
                            $("#alert10").val("");
                            $("#tanggal10").val("");
                            $("#kdkerja10").val("");
                            $("#kdmakanan10").val("");
                            $("#keterangan10").val("");
                            $('#kdkerja10').prop('disabled', 'disabled');
                            $('#kdmakanan10').prop('disabled', 'disabled');
                            $('#keterangan10').prop('disabled', 'disabled');
                            $("#lblkdkerja10spn").css('display', 'none');
                            $("#lblkdmakanan10spn").css('display', 'none');
                            $("#lblketerangan10spn").css('display', 'none');

                            tanggal();
                            }
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }
              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
        });

        $('body').on('click', '.editwfawfo', function () {
          var id = $(this).data('id');
          $.get("inputwfawfo" +'/' + id +'/edit', function (data) {
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
            $('#kdkerjaupdate').prop('disabled', false);
            $('#kdmakananupdate').prop('disabled', 'disabled');
            $('#keteranganupdate').prop('disabled', 'disabled');
            $("#lblkdkerjaupdatespn").css('display', 'none');
            $("#lblkdmakananupdatespn").css('display', 'none');
            $("#lblketeranganupdatespn").css('display', 'none');

            cek_wfawfoupdate();
          });
        });

        $('#saveBtn').click(function (e) {
          if(validate() == 'true'){
            e.preventDefault();
            $(this).html('Sending..');
            $.ajax({
              // data: $('#wfawfoform').serialize(),
              data: {
                id:$("#id").val()
                , tanggal:$("#tanggal").val()
                , kdkerja:$("#kdkerja :selected").val()
                , kdmakanan:$("#kdmakanan :selected").val()
                , keterangan:$("#keterangan").val()
                , alert:$("#alert").val()
                , tanggal2:$("#tanggal2").val()
                , kdkerja2:$("#kdkerja2 :selected").val()
                , kdmakanan2:$("#kdmakanan2 :selected").val()
                , keterangan2:$("#keterangan2").val()
                , alert2:$("#alert2").val()
                , tanggal3:$("#tanggal3").val()
                , kdkerja3:$("#kdkerja3 :selected").val()
                , kdmakanan3:$("#kdmakanan3 :selected").val()
                , keterangan3:$("#keterangan3").val()
                , alert3:$("#alert3").val()
                , tanggal4:$("#tanggal4").val()
                , kdkerja4:$("#kdkerja4 :selected").val()
                , kdmakanan4:$("#kdmakanan4 :selected").val()
                , keterangan4:$("#keterangan4").val()
                , alert4:$("#alert4").val()
                , tanggal5:$("#tanggal5").val()
                , kdkerja5:$("#kdkerja5 :selected").val()
                , kdmakanan5:$("#kdmakanan5 :selected").val()
                , keterangan5:$("#keterangan5").val()
                , alert5:$("#alert5").val()
                , tanggal6:$("#tanggal6").val()
                , kdkerja6:$("#kdkerja6 :selected").val()
                , kdmakanan6:$("#kdmakanan6 :selected").val()
                , keterangan6:$("#keterangan6").val()
                , alert6:$("#alert6").val()
                , tanggal7:$("#tanggal7").val()
                , kdkerja7:$("#kdkerja7 :selected").val()
                , kdmakanan7:$("#kdmakanan7 :selected").val()
                , keterangan7:$("#keterangan7").val()
                , alert7:$("#alert7").val()
                , tanggal8:$("#tanggal8").val()
                , kdkerja8:$("#kdkerja8 :selected").val()
                , kdmakanan8:$("#kdmakanan8 :selected").val()
                , keterangan8:$("#keterangan8").val()
                , alert8:$("#alert8").val()
                , tanggal9:$("#tanggal9").val()
                , kdkerja9:$("#kdkerja9 :selected").val()
                , kdmakanan9:$("#kdmakanan9 :selected").val()
                , keterangan9:$("#keterangan9").val()
                , alert9:$("#alert9").val()
                , tanggal10:$("#tanggal10").val()
                , kdkerja10:$("#kdkerja10 :selected").val()
                , kdmakanan10:$("#kdmakanan10 :selected").val()
                , keterangan10:$("#keterangan10").val()
                , alert10:$("#alert10").val()
              },
              url: "{{ route('inputwfawfo.store') }}",
              type: "POST",
              dataType: 'json',
              success: function (data) {
                if(data.result == 'true'){
                  $('#inputwfawfoform').trigger("reset");
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
          }
        });

        function printErrorMsg(msg) {
          $(".print-error-msg").find("ul").html('');
          $(".print-error-msg").css('display', 'block');
          $.each(msg, function(key, value) {
            $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
          });
        }

        $('body').on('click', '.deletewfawfo', function () {
          var id = $(this).data("id");
          $.get("inputwfawfo" +'/' + id +'/edit', function (data) {
            if(data.kdstatus == 'APR'){
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Approved Status Cannot Be Deleted',
                    scrollbarPadding : false
                  })
            }else{
              if(confirm("Are You sure want to delete ?")){
                $.ajax({
                  type: "DELETE",
                  url: "inputwfawfo"+'/'+id,
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
            }
          });
        });

        // var update_kdmakanan = function () {
        //   if ($("#kdkerja :selected").val() == "WFO") {
        //       $('#kdmakanan').prop('disabled', false);
        //   }
        //   else {
        //       $('#kdmakanan').prop('disabled', 'disabled');
        //       $("#kdmakanan").val("");
        //   }
        // }

        // $("#kdkerja").change(update_kdmakanan);

        // $('#btnFilter').click(function(e){
        //   e.preventDefault();

        //   table.draw();
        // });

        function tanggal() {
          $.ajax({
            url: "{{ url('/inputwfawfo/tanggal') }}",
            type: "GET",
            success: function (data) {
                if(data[0].hari_libur == 'true'){
                  $("#tanggal").val(data[0].tanggal);
                  $("#keterangan").val("Hari Libur");
                }else{
                  $('#tanggal').val(data[0].tanggal);
                  $('#kdkerja').prop('disabled', false);
                }

                if(data[1].hari_libur == 'true'){
                  $("#tanggal2").val(data[1].tanggal);
                  $("#keterangan2").val("Hari Libur");
                }else{
                  $('#tanggal2').val(data[1].tanggal);
                  $('#kdkerja2').prop('disabled', false);
                }

                if(data[2].hari_libur == 'true'){
                  $("#tanggal3").val(data[2].tanggal);
                  $("#keterangan3").val("Hari Libur");
                }else{
                  $('#tanggal3').val(data[2].tanggal);
                  $('#kdkerja3').prop('disabled', false);
                }

                if(data[3].hari_libur == 'true'){
                  $("#tanggal4").val(data[3].tanggal);
                  $("#keterangan4").val("Hari Libur");
                }else{
                  $('#tanggal4').val(data[3].tanggal);
                  $('#kdkerja4').prop('disabled', false);
                }

                if(data[4].hari_libur == 'true'){
                  $("#tanggal5").val(data[4].tanggal);
                  $("#keterangan5").val("Hari Libur");
                }else{
                  $('#tanggal5').val(data[4].tanggal);
                  $('#kdkerja5').prop('disabled', false);
                }

                if(data[5].hari_libur == 'true'){
                  $("#tanggal6").val(data[5].tanggal);
                  $("#keterangan6").val("Hari Libur");
                }else{
                  $('#tanggal6').val(data[5].tanggal);
                  $('#kdkerja6').prop('disabled', false);
                }

                if(data[6].hari_libur == 'true'){
                  $("#tanggal7").val(data[6].tanggal);
                  $("#keterangan7").val("Hari Libur");
                }else{
                  $('#tanggal7').val(data[6].tanggal);
                  $('#kdkerja7').prop('disabled', false);
                }

                if(data[7].hari_libur == 'true'){
                  $("#tanggal8").val(data[7].tanggal);
                  $("#keterangan8").val("Hari Libur");
                }else{
                  $('#tanggal8').val(data[7].tanggal);
                  $('#kdkerja8').prop('disabled', false);
                }

                if(data[8].hari_libur == 'true'){
                  $("#tanggal9").val(data[8].tanggal);
                  $("#keterangan9").val("Hari Libur");
                }else{
                  $('#tanggal9').val(data[8].tanggal);
                  $('#kdkerja9').prop('disabled', false);
                }

                if(data[9].hari_libur == 'true'){
                  $("#tanggal10").val(data[9].tanggal);
                  $("#keterangan10").val("Hari Libur");
                }else{
                  $('#tanggal10').val(data[9].tanggal);
                  $('#kdkerja10').prop('disabled', false);
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
          });
        }

        function maksimumwfawfo() {
          if($("#kdkerja :selected").val() == 'WFO'){
            $.ajax({
              url: "{{ url('/inputwfawfo/maksimumwfawfo') }}",
              data: {tanggal:$("#tanggal").val()
                    , kdkerja:$("#kdkerja :selected").val()
                    },
              type: "GET",
              success: function (data) {
                if(data[0].kdkerja == 'WFO' && data[0].maksimum == 'lebih'){
                  $("#lblmsg").text(data[0].alert);
                  $("#lblmsg").css('display', 'block');
                  $('#kdmakanan').prop('disabled', false);
                  $("#kdmakanan").val("");
                  $("#keterangan").prop('disabled', false);
                  $("#keterangan").val("");
                  $("#max").val("1");
                  $("#alert").val(data[0].alert_value);
                }else{
                  $("#lblmsg").text('');
                  $("#lblmsg").css('display', 'none');
                  $('#kdmakanan').prop('disabled', false);
                  $("#kdmakanan").val("");
                  $("#keterangan").prop('disabled', 'disabled');
                  $("#keterangan").val("");
                  $("#max").val("0");
                  $("#alert").val("");
                }
              },
              error: function (data) {
                  console.log('Error:', data);
              }
            });
          }else if($("#kdkerja :selected").val() == 'WFH'){
            $.ajax({
              url: "{{ url('/inputwfawfo/maksimumwfawfo') }}",
              data: {tanggal:$("#tanggal").val()
                    , kdkerja:$("#kdkerja :selected").val()
                    },
              type: "GET",
              success: function (data) {
                if(data[0].kdkerja == 'WFH' && data[0].maksimum == 'lebih'){
                  $("#lblmsg").text(data[0].alert);
                  $("#lblmsg").css('display', 'block');
                  $('#kdmakanan').prop('disabled', 'disabled');
                  $("#kdmakanan").val("");
                  $("#keterangan").prop('disabled', false);
                  $("#keterangan").val("");
                  $("#max").val("1");
                  $("#alert").val(data[0].alert_value);
                }else{
                  $("#lblmsg").text('');
                  $("#lblmsg").css('display', 'none');
                  $('#kdmakanan').prop('disabled', 'disabled');
                  $("#kdmakanan").val("");
                  $("#keterangan").prop('disabled', 'disabled');
                  $("#keterangan").val("");
                  $("#max").val("0");
                  $("#alert").val("");
                }
              },
              error: function (data) {
                  console.log('Error:', data);
              }
            });
          }else{
            $('#kdmakanan').prop('disabled', 'disabled');
            $("#kdmakanan").val("");
            $("#keterangan").prop('disabled', 'disabled');
            $("#keterangan").val("");
            $("#lblmsg").text('');
            $("#lblmsg").css('display', 'none');
            $("#max").val("0");
            $("#alert").val("");
          }
        }

        function maksimumwfawfo2() {
          if($("#kdkerja2 :selected").val() == 'WFO'){
            $.ajax({
              url: "{{ url('/inputwfawfo/maksimumwfawfo') }}",
              data: {tanggal:$("#tanggal2").val()
                    , kdkerja:$("#kdkerja2 :selected").val()
                    },
              type: "GET",
              success: function (data) {
                if(data[0].kdkerja == 'WFO' && data[0].maksimum == 'lebih'){
                  $("#lblmsg2").text(data[0].alert);
                  $("#lblmsg2").css('display', 'block');
                  $('#kdmakanan2').prop('disabled', false);
                  $("#kdmakanan2").val("");
                  $("#keterangan2").prop('disabled', false);
                  $("#keterangan2").val("");
                  $("#max2").val("1");
                  $("#alert2").val(data[0].alert_value);
                }else{
                  $("#lblmsg2").text('');
                  $("#lblmsg2").css('display', 'none');
                  $('#kdmakanan2').prop('disabled', false);
                  $("#kdmakanan2").val("");
                  $("#keterangan2").prop('disabled', 'disabled');
                  $("#keterangan2").val("");
                  $("#max").val("0");
                  $("#alert2").val("");
                }
              },
              error: function (data) {
                  console.log('Error:', data);
              }
            });
          }else if($("#kdkerja2 :selected").val() == 'WFH'){
            $.ajax({
              url: "{{ url('/inputwfawfo/maksimumwfawfo') }}",
              data: {tanggal:$("#tanggal2").val()
                    , kdkerja:$("#kdkerja2 :selected").val()
                    },
              type: "GET",
              success: function (data) {
                if(data[0].kdkerja == 'WFH' && data[0].maksimum == 'lebih'){
                  $("#lblmsg2").text(data[0].alert);
                  $("#lblmsg2").css('display', 'block');
                  $('#kdmakanan2').prop('disabled', 'disabled');
                  $("#kdmakanan2").val("");
                  $("#keterangan2").prop('disabled', false);
                  $("#keterangan2").val("");
                  $("#max2").val("1");
                  $("#alert2").val(data[0].alert_value);
                }else{
                  $("#lblmsg2").text('');
                  $("#lblmsg2").css('display', 'none');
                  $('#kdmakanan2').prop('disabled', 'disabled');
                  $("#kdmakanan2").val("");
                  $("#keterangan2").prop('disabled', 'disabled');
                  $("#keterangan2").val("");
                  $("#max2").val("0");
                  $("#alert2").val("");
                }
              },
              error: function (data) {
                  console.log('Error:', data);
              }
            });
          }else{
            $('#kdmakanan2').prop('disabled', 'disabled');
            $("#kdmakanan2").val("");
            $("#keterangan2").prop('disabled', 'disabled');
            $("#keterangan2").val("");
            $("#lblmsg2").text('');
            $("#lblmsg2").css('display', 'none');
            $("#max2").val("0");
            $("#alert2").val("");
          }
        }

        function maksimumwfawfo3() {
          if($("#kdkerja3 :selected").val() == 'WFO'){
            $.ajax({
              url: "{{ url('/inputwfawfo/maksimumwfawfo') }}",
              data: {tanggal:$("#tanggal3").val()
                    , kdkerja:$("#kdkerja3 :selected").val()
                    },
              type: "GET",
              success: function (data) {
                if(data[0].kdkerja == 'WFO' && data[0].maksimum == 'lebih'){
                  $("#lblmsg3").text(data[0].alert);
                  $("#lblmsg3").css('display', 'block');
                  $('#kdmakanan3').prop('disabled', false);
                  $("#kdmakanan3").val("");
                  $("#keterangan3").prop('disabled', false);
                  $("#keterangan3").val("");
                  $("#max3").val("1");
                  $("#alert3").val(data[0].alert_value);
                }else{
                  $("#lblmsg3").text('');
                  $("#lblmsg3").css('display', 'none');
                  $('#kdmakanan3').prop('disabled', false);
                  $("#kdmakanan3").val("");
                  $("#keterangan3").prop('disabled', 'disabled');
                  $("#keterangan3").val("");
                  $("#max3").val("0");
                  $("#alert3").val("");
                }
              },
              error: function (data) {
                  console.log('Error:', data);
              }
            });
          }else if($("#kdkerja3 :selected").val() == 'WFH'){
            $.ajax({
              url: "{{ url('/inputwfawfo/maksimumwfawfo') }}",
              data: {tanggal:$("#tanggal3").val()
                    , kdkerja:$("#kdkerja3 :selected").val()
                    },
              type: "GET",
              success: function (data) {
                if(data[0].kdkerja == 'WFH' && data[0].maksimum == 'lebih'){
                  $("#lblmsg3").text(data[0].alert);
                  $("#lblmsg3").css('display', 'block');
                  $('#kdmakanan3').prop('disabled', 'disabled');
                  $("#kdmakanan3").val("");
                  $("#keterangan3").prop('disabled', false);
                  $("#keterangan3").val("");
                  $("#max3").val("1");
                  $("#alert3").val(data[0].alert_value);
                }else{
                  $("#lblmsg3").text('');
                  $("#lblmsg3").css('display', 'none');
                  $('#kdmakanan3').prop('disabled', 'disabled');
                  $("#kdmakanan3").val("");
                  $("#keterangan3").prop('disabled', 'disabled');
                  $("#keterangan3").val("");
                  $("#max3").val("0");
                  $("#alert3").val("");
                }
              },
              error: function (data) {
                  console.log('Error:', data);
              }
            });
          }else{
            $('#kdmakanan3').prop('disabled', 'disabled');
            $("#kdmakanan3").val("");
            $("#keterangan3").prop('disabled', 'disabled');
            $("#keterangan3").val("");
            $("#lblmsg3").text('');
            $("#lblmsg3").css('display', 'none');
            $("#max3").val("0");
            $("#alert3").val("");
          }
        }

        function maksimumwfawfo4() {
          if($("#kdkerja4 :selected").val() == 'WFO'){
            $.ajax({
              url: "{{ url('/inputwfawfo/maksimumwfawfo') }}",
              data: {tanggal:$("#tanggal4").val()
                    , kdkerja:$("#kdkerja4 :selected").val()
                    },
              type: "GET",
              success: function (data) {
                if(data[0].kdkerja == 'WFO' && data[0].maksimum == 'lebih'){
                  $("#lblmsg4").text(data[0].alert);
                  $("#lblmsg4").css('display', 'block');
                  $('#kdmakanan4').prop('disabled', false);
                  $("#kdmakanan4").val("");
                  $("#keterangan4").prop('disabled', false);
                  $("#keterangan4").val("");
                  $("#max4").val("1");
                  $("#alert4").val(data[0].alert_value);
                }else{
                  $("#lblmsg4").text('');
                  $("#lblmsg4").css('display', 'none');
                  $('#kdmakanan4').prop('disabled', false);
                  $("#kdmakanan4").val("");
                  $("#keterangan4").prop('disabled', 'disabled');
                  $("#keterangan4").val("");
                  $("#max4").val("0");
                  $("#alert4").val("");
                }
              },
              error: function (data) {
                  console.log('Error:', data);
              }
            });
          }else if($("#kdkerja4 :selected").val() == 'WFH'){
            $.ajax({
              url: "{{ url('/inputwfawfo/maksimumwfawfo') }}",
              data: {tanggal:$("#tanggal4").val()
                    , kdkerja:$("#kdkerja4 :selected").val()
                    },
              type: "GET",
              success: function (data) {
                if(data[0].kdkerja == 'WFH' && data[0].maksimum == 'lebih'){
                  $("#lblmsg4").text(data[0].alert);
                  $("#lblmsg4").css('display', 'block');
                  $('#kdmakanan4').prop('disabled', 'disabled');
                  $("#kdmakanan4").val("");
                  $("#keterangan4").prop('disabled', false);
                  $("#keterangan4").val("");
                  $("#max4").val("1");
                  $("#alert4").val(data[0].alert_value);
                }else{
                  $("#lblmsg4").text('');
                  $("#lblmsg4").css('display', 'none');
                  $('#kdmakanan4').prop('disabled', 'disabled');
                  $("#kdmakanan4").val("");
                  $("#keterangan4").prop('disabled', 'disabled');
                  $("#keterangan4").val("");
                  $("#max4").val("0");
                  $("#alert4").val("");
                }
              },
              error: function (data) {
                  console.log('Error:', data);
              }
            });
          }else{
            $('#kdmakanan4').prop('disabled', 'disabled');
            $("#kdmakanan4").val("");
            $("#keterangan4").prop('disabled', 'disabled');
            $("#keterangan4").val("");
            $("#lblmsg4").text('');
            $("#lblmsg4").css('display', 'none');
            $("#max4").val("0");
            $("#alert4").val("");
          }
        }

        function maksimumwfawfo5() {
          if($("#kdkerja5 :selected").val() == 'WFO'){
            $.ajax({
              url: "{{ url('/inputwfawfo/maksimumwfawfo') }}",
              data: {tanggal:$("#tanggal5").val()
                    , kdkerja:$("#kdkerja5 :selected").val()
                    },
              type: "GET",
              success: function (data) {
                if(data[0].kdkerja == 'WFO' && data[0].maksimum == 'lebih'){
                  $("#lblmsg5").text(data[0].alert);
                  $("#lblmsg5").css('display', 'block');
                  $('#kdmakanan5').prop('disabled', false);
                  $("#kdmakanan5").val("");
                  $("#keterangan5").prop('disabled', false);
                  $("#keterangan5").val("");
                  $("#max5").val("1");
                  $("#alert5").val(data[0].alert_value);
                }else{
                  $("#lblmsg5").text('');
                  $("#lblmsg5").css('display', 'none');
                  $('#kdmakanan5').prop('disabled', false);
                  $("#kdmakanan5").val("");
                  $("#keterangan5").prop('disabled', 'disabled');
                  $("#keterangan5").val("");
                  $("#max5").val("0");
                  $("#alert5").val("");
                }
              },
              error: function (data) {
                  console.log('Error:', data);
              }
            });
          }else if($("#kdkerja5 :selected").val() == 'WFH'){
            $.ajax({
              url: "{{ url('/inputwfawfo/maksimumwfawfo') }}",
              data: {tanggal:$("#tanggal5").val()
                    , kdkerja:$("#kdkerja5 :selected").val()
                    },
              type: "GET",
              success: function (data) {
                if(data[0].kdkerja == 'WFH' && data[0].maksimum == 'lebih'){
                  $("#lblmsg5").text(data[0].alert);
                  $("#lblmsg5").css('display', 'block');
                  $('#kdmakanan5').prop('disabled', 'disabled');
                  $("#kdmakanan5").val("");
                  $("#keterangan5").prop('disabled', false);
                  $("#keterangan5").val("");
                  $("#max5").val("1");
                  $("#alert5").val(data[0].alert_value);
                }else{
                  $("#lblmsg5").text('');
                  $("#lblmsg5").css('display', 'none');
                  $('#kdmakanan5').prop('disabled', 'disabled');
                  $("#kdmakanan5").val("");
                  $("#keterangan5").prop('disabled', 'disabled');
                  $("#keterangan5").val("");
                  $("#max5").val("0");
                  $("#alert5").val("");
                }
              },
              error: function (data) {
                  console.log('Error:', data);
              }
            });
          }else{
            $('#kdmakanan5').prop('disabled', 'disabled');
            $("#kdmakanan5").val("");
            $("#keterangan5").prop('disabled', 'disabled');
            $("#keterangan5").val("");
            $("#lblmsg5").text('');
            $("#lblmsg5").css('display', 'none');
            $("#max5").val("0");
            $("#alert5").val("");
          }
        }

        function maksimumwfawfo6() {
          if($("#kdkerja6 :selected").val() == 'WFO'){
            $.ajax({
              url: "{{ url('/inputwfawfo/maksimumwfawfo') }}",
              data: {tanggal:$("#tanggal6").val()
                    , kdkerja:$("#kdkerja6 :selected").val()
                    },
              type: "GET",
              success: function (data) {
                if(data[0].kdkerja == 'WFO' && data[0].maksimum == 'lebih'){
                  $("#lblmsg6").text(data[0].alert);
                  $("#lblmsg6").css('display', 'block');
                  $('#kdmakanan6').prop('disabled', false);
                  $("#kdmakanan6").val("");
                  $("#keterangan6").prop('disabled', false);
                  $("#keterangan6").val("");
                  $("#max6").val("1");
                  $("#alert6").val(data[0].alert_value);
                }else{
                  $("#lblmsg6").text('');
                  $("#lblmsg6").css('display', 'none');
                  $('#kdmakanan6').prop('disabled', false);
                  $("#kdmakanan6").val("");
                  $("#keterangan6").prop('disabled', 'disabled');
                  $("#keterangan6").val("");
                  $("#max6").val("0");
                  $("#alert6").val("");
                }
              },
              error: function (data) {
                  console.log('Error:', data);
              }
            });
          }else if($("#kdkerja6 :selected").val() == 'WFH'){
            $.ajax({
              url: "{{ url('/inputwfawfo/maksimumwfawfo') }}",
              data: {tanggal:$("#tanggal6").val()
                    , kdkerja:$("#kdkerja6 :selected").val()
                    },
              type: "GET",
              success: function (data) {
                if(data[0].kdkerja == 'WFH' && data[0].maksimum == 'lebih'){
                  $("#lblmsg6").text(data[0].alert);
                  $("#lblmsg6").css('display', 'block');
                  $('#kdmakanan6').prop('disabled', 'disabled');
                  $("#kdmakanan6").val("");
                  $("#keterangan6").prop('disabled', false);
                  $("#keterangan6").val("");
                  $("#max6").val("1");
                  $("#alert6").val(data[0].alert_value);
                }else{
                  $("#lblmsg6").text('');
                  $("#lblmsg6").css('display', 'none');
                  $('#kdmakanan6').prop('disabled', 'disabled');
                  $("#kdmakanan6").val("");
                  $("#keterangan6").prop('disabled', 'disabled');
                  $("#keterangan6").val("");
                  $("#max6").val("0");
                  $("#alert6").val("");
                }
              },
              error: function (data) {
                  console.log('Error:', data);
              }
            });
          }else{
            $('#kdmakanan6').prop('disabled', 'disabled');
            $("#kdmakanan6").val("");
            $("#keterangan6").prop('disabled', 'disabled');
            $("#keterangan6").val("");
            $("#lblmsg6").text('');
            $("#lblmsg6").css('display', 'none');
            $("#max6").val("0");
            $("#alert6").val("");
          }
        }

        function maksimumwfawfo7() {
          if($("#kdkerja7 :selected").val() == 'WFO'){
            $.ajax({
              url: "{{ url('/inputwfawfo/maksimumwfawfo') }}",
              data: {tanggal:$("#tanggal7").val()
                    , kdkerja:$("#kdkerja7 :selected").val()
                    },
              type: "GET",
              success: function (data) {
                if(data[0].kdkerja == 'WFO' && data[0].maksimum == 'lebih'){
                  $("#lblmsg7").text(data[0].alert);
                  $("#lblmsg7").css('display', 'block');
                  $('#kdmakanan7').prop('disabled', false);
                  $("#kdmakanan7").val("");
                  $("#keterangan7").prop('disabled', false);
                  $("#keterangan7").val("");
                  $("#max7").val("1");
                  $("#alert7").val(data[0].alert_value);
                }else{
                  $("#lblmsg7").text('');
                  $("#lblmsg7").css('display', 'none');
                  $('#kdmakanan7').prop('disabled', false);
                  $("#kdmakanan7").val("");
                  $("#keterangan7").prop('disabled', 'disabled');
                  $("#keterangan7").val("");
                  $("#max7").val("0");
                  $("#alert7").val("");
                }
              },
              error: function (data) {
                  console.log('Error:', data);
              }
            });
          }else if($("#kdkerja7 :selected").val() == 'WFH'){
            $.ajax({
              url: "{{ url('/inputwfawfo/maksimumwfawfo') }}",
              data: {tanggal:$("#tanggal7").val()
                    , kdkerja:$("#kdkerja7 :selected").val()
                    },
              type: "GET",
              success: function (data) {
                if(data[0].kdkerja == 'WFH' && data[0].maksimum == 'lebih'){
                  $("#lblmsg7").text(data[0].alert);
                  $("#lblmsg7").css('display', 'block');
                  $('#kdmakanan7').prop('disabled', 'disabled');
                  $("#kdmakanan7").val("");
                  $("#keterangan7").prop('disabled', false);
                  $("#keterangan7").val("");
                  $("#max7").val("1");
                  $("#alert7").val(data[0].alert_value);
                }else{
                  $("#lblmsg7").text('');
                  $("#lblmsg7").css('display', 'none');
                  $('#kdmakanan7').prop('disabled', 'disabled');
                  $("#kdmakanan7").val("");
                  $("#keterangan7").prop('disabled', 'disabled');
                  $("#keterangan7").val("");
                  $("#max7").val("0");
                  $("#alert7").val("");
                }
              },
              error: function (data) {
                  console.log('Error:', data);
              }
            });
          }else{
            $('#kdmakanan7').prop('disabled', 'disabled');
            $("#kdmakanan7").val("");
            $("#keterangan7").prop('disabled', 'disabled');
            $("#keterangan7").val("");
            $("#lblmsg7").text('');
            $("#lblmsg7").css('display', 'none');
            $("#max7").val("0");
            $("#alert7").val("");
          }
        }

        function maksimumwfawfo8() {
          if($("#kdkerja8 :selected").val() == 'WFO'){
            $.ajax({
              url: "{{ url('/inputwfawfo/maksimumwfawfo') }}",
              data: {tanggal:$("#tanggal8").val()
                    , kdkerja:$("#kdkerja8 :selected").val()
                    },
              type: "GET",
              success: function (data) {
                if(data[0].kdkerja == 'WFO' && data[0].maksimum == 'lebih'){
                  $("#lblmsg8").text(data[0].alert);
                  $("#lblmsg8").css('display', 'block');
                  $('#kdmakanan8').prop('disabled', false);
                  $("#kdmakanan8").val("");
                  $("#keterangan8").prop('disabled', false);
                  $("#keterangan8").val("");
                  $("#max8").val("1");
                  $("#alert8").val(data[0].alert_value);
                }else{
                  $("#lblmsg8").text('');
                  $("#lblmsg8").css('display', 'none');
                  $('#kdmakanan8').prop('disabled', false);
                  $("#kdmakanan8").val("");
                  $("#keterangan8").prop('disabled', 'disabled');
                  $("#keterangan8").val("");
                  $("#max8").val("0");
                  $("#alert8").val("");
                }
              },
              error: function (data) {
                  console.log('Error:', data);
              }
            });
          }else if($("#kdkerja8 :selected").val() == 'WFH'){
            $.ajax({
              url: "{{ url('/inputwfawfo/maksimumwfawfo') }}",
              data: {tanggal:$("#tanggal8").val()
                    , kdkerja:$("#kdkerja8 :selected").val()
                    },
              type: "GET",
              success: function (data) {
                if(data[0].kdkerja == 'WFH' && data[0].maksimum == 'lebih'){
                  $("#lblmsg8").text(data[0].alert);
                  $("#lblmsg8").css('display', 'block');
                  $('#kdmakanan8').prop('disabled', 'disabled');
                  $("#kdmakanan8").val("");
                  $("#keterangan8").prop('disabled', false);
                  $("#keterangan8").val("");
                  $("#max8").val("1");
                  $("#alert8").val(data[0].alert_value);
                }else{
                  $("#lblmsg8").text('');
                  $("#lblmsg8").css('display', 'none');
                  $('#kdmakanan8').prop('disabled', 'disabled');
                  $("#kdmakanan8").val("");
                  $("#keterangan8").prop('disabled', 'disabled');
                  $("#keterangan8").val("");
                  $("#max8").val("0");
                  $("#alert8").val("");
                }
              },
              error: function (data) {
                  console.log('Error:', data);
              }
            });
          }else{
            $('#kdmakanan8').prop('disabled', 'disabled');
            $("#kdmakanan8").val("");
            $("#keterangan8").prop('disabled', 'disabled');
            $("#keterangan8").val("");
            $("#lblmsg8").text('');
            $("#lblmsg8").css('display', 'none');
            $("#max8").val("0");
            $("#alert8").val("");
          }
        }

        function maksimumwfawfo9() {
          if($("#kdkerja9 :selected").val() == 'WFO'){
            $.ajax({
              url: "{{ url('/inputwfawfo/maksimumwfawfo') }}",
              data: {tanggal:$("#tanggal9").val()
                    , kdkerja:$("#kdkerja9 :selected").val()
                    },
              type: "GET",
              success: function (data) {
                if(data[0].kdkerja == 'WFO' && data[0].maksimum == 'lebih'){
                  $("#lblmsg9").text(data[0].alert);
                  $("#lblmsg9").css('display', 'block');
                  $('#kdmakanan9').prop('disabled', false);
                  $("#kdmakanan9").val("");
                  $("#keterangan9").prop('disabled', false);
                  $("#keterangan9").val("");
                  $("#max9").val("1");
                  $("#alert9").val(data[0].alert_value);
                }else{
                  $("#lblmsg9").text('');
                  $("#lblmsg9").css('display', 'none');
                  $('#kdmakanan9').prop('disabled', false);
                  $("#kdmakanan9").val("");
                  $("#keterangan9").prop('disabled', 'disabled');
                  $("#keterangan9").val("");
                  $("#max9").val("0");
                  $("#alert9").val("");
                }
              },
              error: function (data) {
                  console.log('Error:', data);
              }
            });
          }else if($("#kdkerja9 :selected").val() == 'WFH'){
            $.ajax({
              url: "{{ url('/inputwfawfo/maksimumwfawfo') }}",
              data: {tanggal:$("#tanggal9").val()
                    , kdkerja:$("#kdkerja9 :selected").val()
                    },
              type: "GET",
              success: function (data) {
                if(data[0].kdkerja == 'WFH' && data[0].maksimum == 'lebih'){
                  $("#lblmsg9").text(data[0].alert);
                  $("#lblmsg9").css('display', 'block');
                  $('#kdmakanan9').prop('disabled', 'disabled');
                  $("#kdmakanan9").val("");
                  $("#keterangan9").prop('disabled', false);
                  $("#keterangan9").val("");
                  $("#max9").val("1");
                  $("#alert9").val(data[0].alert_value);
                }else{
                  $("#lblmsg9").text('');
                  $("#lblmsg9").css('display', 'none');
                  $('#kdmakanan9').prop('disabled', 'disabled');
                  $("#kdmakanan9").val("");
                  $("#keterangan9").prop('disabled', 'disabled');
                  $("#keterangan9").val("");
                  $("#max9").val("0");
                  $("#alert9").val("");
                }
              },
              error: function (data) {
                  console.log('Error:', data);
              }
            });
          }else{
            $('#kdmakanan9').prop('disabled', 'disabled');
            $("#kdmakanan9").val("");
            $("#keterangan9").prop('disabled', 'disabled');
            $("#keterangan9").val("");
            $("#lblmsg9").text('');
            $("#lblmsg9").css('display', 'none');
            $("#max9").val("0");
            $("#alert9").val("");
          }
        }

        function maksimumwfawfo10() {
          if($("#kdkerja10 :selected").val() == 'WFO'){
            $.ajax({
              url: "{{ url('/inputwfawfo/maksimumwfawfo') }}",
              data: {tanggal:$("#tanggal10").val()
                    , kdkerja:$("#kdkerja10 :selected").val()
                    },
              type: "GET",
              success: function (data) {
                if(data[0].kdkerja == 'WFO' && data[0].maksimum == 'lebih'){
                  $("#lblmsg10").text(data[0].alert);
                  $("#lblmsg10").css('display', 'block');
                  $('#kdmakanan10').prop('disabled', false);
                  $("#kdmakanan10").val("");
                  $("#keterangan10").prop('disabled', false);
                  $("#keterangan10").val("");
                  $("#max10").val("1");
                  $("#alert10").val(data[0].alert_value);
                }else{
                  $("#lblmsg10").text('');
                  $("#lblmsg10").css('display', 'none');
                  $('#kdmakanan10').prop('disabled', false);
                  $("#kdmakanan10").val("");
                  $("#keterangan10").prop('disabled', 'disabled');
                  $("#keterangan10").val("");
                  $("#max10").val("0");
                  $("#alert10").val("");
                }
              },
              error: function (data) {
                  console.log('Error:', data);
              }
            });
          }else if($("#kdkerja10 :selected").val() == 'WFH'){
            $.ajax({
              url: "{{ url('/inputwfawfo/maksimumwfawfo') }}",
              data: {tanggal:$("#tanggal10").val()
                    , kdkerja:$("#kdkerja10 :selected").val()
                    },
              type: "GET",
              success: function (data) {
                if(data[0].kdkerja == 'WFH' && data[0].maksimum == 'lebih'){
                  $("#lblmsg10").text(data[0].alert);
                  $("#lblmsg10").css('display', 'block');
                  $('#kdmakanan10').prop('disabled', 'disabled');
                  $("#kdmakanan10").val("");
                  $("#keterangan10").prop('disabled', false);
                  $("#keterangan10").val("");
                  $("#max10").val("1");
                  $("#alert10").val(data[0].alert_value);
                }else{
                  $("#lblmsg10").text('');
                  $("#lblmsg10").css('display', 'none');
                  $('#kdmakanan10').prop('disabled', 'disabled');
                  $("#kdmakanan10").val("");
                  $("#keterangan10").prop('disabled', 'disabled');
                  $("#keterangan10").val("");
                  $("#max10").val("0");
                  $("#alert10").val("");
                }
              },
              error: function (data) {
                  console.log('Error:', data);
              }
            });
          }else{
            $('#kdmakanan10').prop('disabled', 'disabled');
            $("#kdmakanan10").val("");
            $("#keterangan10").prop('disabled', 'disabled');
            $("#keterangan10").val("");
            $("#lblmsg10").text('');
            $("#lblmsg10").css('display', 'none');
            $("#max10").val("0");
            $("#alert10").val("");
          }
        }

        $("#kdkerja").change(maksimumwfawfo);
        $("#kdkerja2").change(maksimumwfawfo2);
        $("#kdkerja3").change(maksimumwfawfo3);
        $("#kdkerja4").change(maksimumwfawfo4);
        $("#kdkerja5").change(maksimumwfawfo5);
        $("#kdkerja6").change(maksimumwfawfo6);
        $("#kdkerja7").change(maksimumwfawfo7);
        $("#kdkerja8").change(maksimumwfawfo8);
        $("#kdkerja9").change(maksimumwfawfo9);
        $("#kdkerja10").change(maksimumwfawfo10);

        function validate(){
          if($("#kdkerja :selected").val() == '' && $("#keterangan").val() != 'Hari Libur'){
            $(".print-error-msg").css('display', 'block');
            $("#lblerror").text('Jadwal Kerja Harus Di Pilih');
            $("#lblerror").css('display', 'block');
            $("#lblkdkerjaspn").css('display', 'inline');
            $("#lblkdmakananspn").css('display', 'none');
            $("#lblketeranganspn").css('display', 'none');
            $("#lblkdkerja2spn").css('display', 'none');
            $("#lblkdmakanan2spn").css('display', 'none');
            $("#lblketerangan2spn").css('display', 'none');
            $("#lblkdkerja3spn").css('display', 'none');
            $("#lblkdmakanan3spn").css('display', 'none');
            $("#lblketerangan3spn").css('display', 'none');
            $("#lblkdkerja4spn").css('display', 'none');
            $("#lblkdmakanan4spn").css('display', 'none');
            $("#lblketerangan4spn").css('display', 'none');
            $("#lblkdkerja5spn").css('display', 'none');
            $("#lblkdmakanan5spn").css('display', 'none');
            $("#lblketerangan5spn").css('display', 'none');
            $("#lblkdkerja6spn").css('display', 'none');
            $("#lblkdmakanan6spn").css('display', 'none');
            $("#lblketerangan6spn").css('display', 'none');
            $("#lblkdkerja7spn").css('display', 'none');
            $("#lblkdmakanan7spn").css('display', 'none');
            $("#lblketerangan7spn").css('display', 'none');
            $("#lblkdkerja8spn").css('display', 'none');
            $("#lblkdmakanan8spn").css('display', 'none');
            $("#lblketerangan8spn").css('display', 'none');
            $("#lblkdkerja9spn").css('display', 'none');
            $("#lblkdmakanan9spn").css('display', 'none');
            $("#lblketerangan9spn").css('display', 'none');
            $("#lblkdkerja10spn").css('display', 'none');
            $("#lblkdmakanan10spn").css('display', 'none');
            $("#lblketerangan10spn").css('display', 'none');
            return "false";
          }else if($("#kdkerja :selected").val() == 'WFO' && $("#kdmakanan :selected").val() == ''){
            $(".print-error-msg").css('display', 'block');
            $("#lblerror").text('Makan Siang Harus Di Pilih');
            $("#lblerror").css('display', 'block');
            $("#lblkdkerjaspn").css('display', 'none');
            $("#lblkdmakananspn").css('display', 'inline');
            $("#lblketeranganspn").css('display', 'none');
            $("#lblkdkerja2spn").css('display', 'none');
            $("#lblkdmakanan2spn").css('display', 'none');
            $("#lblketerangan2spn").css('display', 'none');
            $("#lblkdkerja3spn").css('display', 'none');
            $("#lblkdmakanan3spn").css('display', 'none');
            $("#lblketerangan3spn").css('display', 'none');
            $("#lblkdkerja4spn").css('display', 'none');
            $("#lblkdmakanan4spn").css('display', 'none');
            $("#lblketerangan4spn").css('display', 'none');
            $("#lblkdkerja5spn").css('display', 'none');
            $("#lblkdmakanan5spn").css('display', 'none');
            $("#lblketerangan5spn").css('display', 'none');
            $("#lblkdkerja6spn").css('display', 'none');
            $("#lblkdmakanan6spn").css('display', 'none');
            $("#lblketerangan6spn").css('display', 'none');
            $("#lblkdkerja7spn").css('display', 'none');
            $("#lblkdmakanan7spn").css('display', 'none');
            $("#lblketerangan7spn").css('display', 'none');
            $("#lblkdkerja8spn").css('display', 'none');
            $("#lblkdmakanan8spn").css('display', 'none');
            $("#lblketerangan8spn").css('display', 'none');
            $("#lblkdkerja9spn").css('display', 'none');
            $("#lblkdmakanan9spn").css('display', 'none');
            $("#lblketerangan9spn").css('display', 'none');
            $("#lblkdkerja10spn").css('display', 'none');
            $("#lblkdmakanan10spn").css('display', 'none');
            $("#lblketerangan10spn").css('display', 'none');
            return "false";
          }else if($("#max").val() == '1'){
            $(".print-error-msg").css('display', 'block');
            $("#lblerror").text('Keterangan Harus Di Isi');
            $("#lblerror").css('display', 'block');
            $("#lblkdkerjaspn").css('display', 'none');
            $("#lblkdmakananspn").css('display', 'none');
            $("#lblketeranganspn").css('display', 'inline');
            $("#lblkdkerja2spn").css('display', 'none');
            $("#lblkdmakanan2spn").css('display', 'none');
            $("#lblketerangan2spn").css('display', 'none');
            $("#lblkdkerja3spn").css('display', 'none');
            $("#lblkdmakanan3spn").css('display', 'none');
            $("#lblketerangan3spn").css('display', 'none');
            $("#lblkdkerja4spn").css('display', 'none');
            $("#lblkdmakanan4spn").css('display', 'none');
            $("#lblketerangan4spn").css('display', 'none');
            $("#lblkdkerja5spn").css('display', 'none');
            $("#lblkdmakanan5spn").css('display', 'none');
            $("#lblketerangan5spn").css('display', 'none');
            $("#lblkdkerja6spn").css('display', 'none');
            $("#lblkdmakanan6spn").css('display', 'none');
            $("#lblketerangan6spn").css('display', 'none');
            $("#lblkdkerja7spn").css('display', 'none');
            $("#lblkdmakanan7spn").css('display', 'none');
            $("#lblketerangan7spn").css('display', 'none');
            $("#lblkdkerja8spn").css('display', 'none');
            $("#lblkdmakanan8spn").css('display', 'none');
            $("#lblketerangan8spn").css('display', 'none');
            $("#lblkdkerja9spn").css('display', 'none');
            $("#lblkdmakanan9spn").css('display', 'none');
            $("#lblketerangan9spn").css('display', 'none');
            $("#lblkdkerja10spn").css('display', 'none');
            $("#lblkdmakanan10spn").css('display', 'none');
            $("#lblketerangan10spn").css('display', 'none');
            return "false";
          }else if($("#kdkerja2 :selected").val() == '' && $("#keterangan2").val() != 'Hari Libur'){
            $(".print-error-msg").css('display', 'block');
            $("#lblerror").text('Jadwal Kerja Harus Di Pilih');
            $("#lblerror").css('display', 'block');
            $("#lblkdkerjaspn").css('display', 'none');
            $("#lblkdmakananspn").css('display', 'none');
            $("#lblketeranganspn").css('display', 'none');
            $("#lblkdkerja2spn").css('display', 'inline');
            $("#lblkdmakanan2spn").css('display', 'none');
            $("#lblketerangan2spn").css('display', 'none');
            $("#lblkdkerja3spn").css('display', 'none');
            $("#lblkdmakanan3spn").css('display', 'none');
            $("#lblketerangan3spn").css('display', 'none');
            $("#lblkdkerja4spn").css('display', 'none');
            $("#lblkdmakanan4spn").css('display', 'none');
            $("#lblketerangan4spn").css('display', 'none');
            $("#lblkdkerja5spn").css('display', 'none');
            $("#lblkdmakanan5spn").css('display', 'none');
            $("#lblketerangan5spn").css('display', 'none');
            $("#lblkdkerja6spn").css('display', 'none');
            $("#lblkdmakanan6spn").css('display', 'none');
            $("#lblketerangan6spn").css('display', 'none');
            $("#lblkdkerja7spn").css('display', 'none');
            $("#lblkdmakanan7spn").css('display', 'none');
            $("#lblketerangan7spn").css('display', 'none');
            $("#lblkdkerja8spn").css('display', 'none');
            $("#lblkdmakanan8spn").css('display', 'none');
            $("#lblketerangan8spn").css('display', 'none');
            $("#lblkdkerja9spn").css('display', 'none');
            $("#lblkdmakanan9spn").css('display', 'none');
            $("#lblketerangan9spn").css('display', 'none');
            $("#lblkdkerja10spn").css('display', 'none');
            $("#lblkdmakanan10spn").css('display', 'none');
            $("#lblketerangan10spn").css('display', 'none');
            return "false";
          }else if($("#kdkerja2 :selected").val() == 'WFO' && $("#kdmakanan2 :selected").val() == ''){
            $(".print-error-msg").css('display', 'block');
            $("#lblerror").text('Makan Siang Harus Di Pilih');
            $("#lblerror").css('display', 'block');
            $("#lblkdkerjaspn").css('display', 'none');
            $("#lblkdmakananspn").css('display', 'none');
            $("#lblketeranganspn").css('display', 'none');
            $("#lblkdkerja2spn").css('display', 'none');
            $("#lblkdmakanan2spn").css('display', 'inline');
            $("#lblketerangan2spn").css('display', 'none');
            $("#lblkdkerja3spn").css('display', 'none');
            $("#lblkdmakanan3spn").css('display', 'none');
            $("#lblketerangan3spn").css('display', 'none');
            $("#lblkdkerja4spn").css('display', 'none');
            $("#lblkdmakanan4spn").css('display', 'none');
            $("#lblketerangan4spn").css('display', 'none');
            $("#lblkdkerja5spn").css('display', 'none');
            $("#lblkdmakanan5spn").css('display', 'none');
            $("#lblketerangan5spn").css('display', 'none');
            $("#lblkdkerja6spn").css('display', 'none');
            $("#lblkdmakanan6spn").css('display', 'none');
            $("#lblketerangan6spn").css('display', 'none');
            $("#lblkdkerja7spn").css('display', 'none');
            $("#lblkdmakanan7spn").css('display', 'none');
            $("#lblketerangan7spn").css('display', 'none');
            $("#lblkdkerja8spn").css('display', 'none');
            $("#lblkdmakanan8spn").css('display', 'none');
            $("#lblketerangan8spn").css('display', 'none');
            $("#lblkdkerja9spn").css('display', 'none');
            $("#lblkdmakanan9spn").css('display', 'none');
            $("#lblketerangan9spn").css('display', 'none');
            $("#lblkdkerja10spn").css('display', 'none');
            $("#lblkdmakanan10spn").css('display', 'none');
            $("#lblketerangan10spn").css('display', 'none');
            return "false";
          }else if($("#max2").val() == '1'){
            $(".print-error-msg").css('display', 'block');
            $("#lblerror").text('Keterangan Harus Di Isi');
            $("#lblerror").css('display', 'block');
            $("#lblkdkerjaspn").css('display', 'none');
            $("#lblkdmakananspn").css('display', 'none');
            $("#lblketeranganspn").css('display', 'none');
            $("#lblkdkerja2spn").css('display', 'none');
            $("#lblkdmakanan2spn").css('display', 'none');
            $("#lblketerangan2spn").css('display', 'inline');
            $("#lblkdkerja3spn").css('display', 'none');
            $("#lblkdmakanan3spn").css('display', 'none');
            $("#lblketerangan3spn").css('display', 'none');
            $("#lblkdkerja4spn").css('display', 'none');
            $("#lblkdmakanan4spn").css('display', 'none');
            $("#lblketerangan4spn").css('display', 'none');
            $("#lblkdkerja5spn").css('display', 'none');
            $("#lblkdmakanan5spn").css('display', 'none');
            $("#lblketerangan5spn").css('display', 'none');
            $("#lblkdkerja6spn").css('display', 'none');
            $("#lblkdmakanan6spn").css('display', 'none');
            $("#lblketerangan6spn").css('display', 'none');
            $("#lblkdkerja7spn").css('display', 'none');
            $("#lblkdmakanan7spn").css('display', 'none');
            $("#lblketerangan7spn").css('display', 'none');
            $("#lblkdkerja8spn").css('display', 'none');
            $("#lblkdmakanan8spn").css('display', 'none');
            $("#lblketerangan8spn").css('display', 'none');
            $("#lblkdkerja9spn").css('display', 'none');
            $("#lblkdmakanan9spn").css('display', 'none');
            $("#lblketerangan9spn").css('display', 'none');
            $("#lblkdkerja10spn").css('display', 'none');
            $("#lblkdmakanan10spn").css('display', 'none');
            $("#lblketerangan10spn").css('display', 'none');
            return "false";
          }else if($("#kdkerja3 :selected").val() == '' && $("#keterangan3").val() != 'Hari Libur'){
            $(".print-error-msg").css('display', 'block');
            $("#lblerror").text('Jadwal Kerja Harus Di Pilih');
            $("#lblerror").css('display', 'block');
            $("#lblkdkerjaspn").css('display', 'none');
            $("#lblkdmakananspn").css('display', 'none');
            $("#lblketeranganspn").css('display', 'none');
            $("#lblkdkerja2spn").css('display', 'none');
            $("#lblkdmakanan2spn").css('display', 'none');
            $("#lblketerangan2spn").css('display', 'none');
            $("#lblkdkerja3spn").css('display', 'inline');
            $("#lblkdmakanan3spn").css('display', 'none');
            $("#lblketerangan3spn").css('display', 'none');
            $("#lblkdkerja4spn").css('display', 'none');
            $("#lblkdmakanan4spn").css('display', 'none');
            $("#lblketerangan4spn").css('display', 'none');
            $("#lblkdkerja5spn").css('display', 'none');
            $("#lblkdmakanan5spn").css('display', 'none');
            $("#lblketerangan5spn").css('display', 'none');
            $("#lblkdkerja6spn").css('display', 'none');
            $("#lblkdmakanan6spn").css('display', 'none');
            $("#lblketerangan6spn").css('display', 'none');
            $("#lblkdkerja7spn").css('display', 'none');
            $("#lblkdmakanan7spn").css('display', 'none');
            $("#lblketerangan7spn").css('display', 'none');
            $("#lblkdkerja8spn").css('display', 'none');
            $("#lblkdmakanan8spn").css('display', 'none');
            $("#lblketerangan8spn").css('display', 'none');
            $("#lblkdkerja9spn").css('display', 'none');
            $("#lblkdmakanan9spn").css('display', 'none');
            $("#lblketerangan9spn").css('display', 'none');
            $("#lblkdkerja10spn").css('display', 'none');
            $("#lblkdmakanan10spn").css('display', 'none');
            $("#lblketerangan10spn").css('display', 'none');
            return "false";
          }else if($("#kdkerja3 :selected").val() == 'WFO' && $("#kdmakanan3 :selected").val() == ''){
            $(".print-error-msg").css('display', 'block');
            $("#lblerror").text('Makan Siang Harus Di Pilih');
            $("#lblerror").css('display', 'block');
            $("#lblkdkerjaspn").css('display', 'none');
            $("#lblkdmakananspn").css('display', 'none');
            $("#lblketeranganspn").css('display', 'none');
            $("#lblkdkerja2spn").css('display', 'none');
            $("#lblkdmakanan2spn").css('display', 'none');
            $("#lblketerangan2spn").css('display', 'none');
            $("#lblkdkerja3spn").css('display', 'none');
            $("#lblkdmakanan3spn").css('display', 'inline');
            $("#lblketerangan3spn").css('display', 'none');
            $("#lblkdkerja4spn").css('display', 'none');
            $("#lblkdmakanan4spn").css('display', 'none');
            $("#lblketerangan4spn").css('display', 'none');
            $("#lblkdkerja5spn").css('display', 'none');
            $("#lblkdmakanan5spn").css('display', 'none');
            $("#lblketerangan5spn").css('display', 'none');
            $("#lblkdkerja6spn").css('display', 'none');
            $("#lblkdmakanan6spn").css('display', 'none');
            $("#lblketerangan6spn").css('display', 'none');
            $("#lblkdkerja7spn").css('display', 'none');
            $("#lblkdmakanan7spn").css('display', 'none');
            $("#lblketerangan7spn").css('display', 'none');
            $("#lblkdkerja8spn").css('display', 'none');
            $("#lblkdmakanan8spn").css('display', 'none');
            $("#lblketerangan8spn").css('display', 'none');
            $("#lblkdkerja9spn").css('display', 'none');
            $("#lblkdmakanan9spn").css('display', 'none');
            $("#lblketerangan9spn").css('display', 'none');
            $("#lblkdkerja10spn").css('display', 'none');
            $("#lblkdmakanan10spn").css('display', 'none');
            $("#lblketerangan10spn").css('display', 'none');
            return "false";
          }else if($("#max3").val() == '1'){
            $(".print-error-msg").css('display', 'block');
            $("#lblerror").text('Keterangan Harus Di Isi');
            $("#lblerror").css('display', 'block');
            $("#lblkdkerjaspn").css('display', 'none');
            $("#lblkdmakananspn").css('display', 'none');
            $("#lblketeranganspn").css('display', 'none');
            $("#lblkdkerja2spn").css('display', 'none');
            $("#lblkdmakanan2spn").css('display', 'none');
            $("#lblketerangan2spn").css('display', 'none');
            $("#lblkdkerja3spn").css('display', 'none');
            $("#lblkdmakanan3spn").css('display', 'none');
            $("#lblketerangan3spn").css('display', 'inline');
            $("#lblkdkerja4spn").css('display', 'none');
            $("#lblkdmakanan4spn").css('display', 'none');
            $("#lblketerangan4spn").css('display', 'none');
            $("#lblkdkerja5spn").css('display', 'none');
            $("#lblkdmakanan5spn").css('display', 'none');
            $("#lblketerangan5spn").css('display', 'none');
            $("#lblkdkerja6spn").css('display', 'none');
            $("#lblkdmakanan6spn").css('display', 'none');
            $("#lblketerangan6spn").css('display', 'none');
            $("#lblkdkerja7spn").css('display', 'none');
            $("#lblkdmakanan7spn").css('display', 'none');
            $("#lblketerangan7spn").css('display', 'none');
            $("#lblkdkerja8spn").css('display', 'none');
            $("#lblkdmakanan8spn").css('display', 'none');
            $("#lblketerangan8spn").css('display', 'none');
            $("#lblkdkerja9spn").css('display', 'none');
            $("#lblkdmakanan9spn").css('display', 'none');
            $("#lblketerangan9spn").css('display', 'none');
            $("#lblkdkerja10spn").css('display', 'none');
            $("#lblkdmakanan10spn").css('display', 'none');
            $("#lblketerangan10spn").css('display', 'none');
            return "false";
          }else if($("#kdkerja4 :selected").val() == '' && $("#keterangan4").val() != 'Hari Libur'){
            $(".print-error-msg").css('display', 'block');
            $("#lblerror").text('Jadwal Kerja Harus Di Pilih');
            $("#lblerror").css('display', 'block');
            $("#lblkdkerjaspn").css('display', 'none');
            $("#lblkdmakananspn").css('display', 'none');
            $("#lblketeranganspn").css('display', 'none');
            $("#lblkdkerja2spn").css('display', 'none');
            $("#lblkdmakanan2spn").css('display', 'none');
            $("#lblketerangan2spn").css('display', 'none');
            $("#lblkdkerja3spn").css('display', 'none');
            $("#lblkdmakanan3spn").css('display', 'none');
            $("#lblketerangan3spn").css('display', 'none');
            $("#lblkdkerja4spn").css('display', 'inline');
            $("#lblkdmakanan4spn").css('display', 'none');
            $("#lblketerangan4spn").css('display', 'none');
            $("#lblkdkerja5spn").css('display', 'none');
            $("#lblkdmakanan5spn").css('display', 'none');
            $("#lblketerangan5spn").css('display', 'none');
            $("#lblkdkerja6spn").css('display', 'none');
            $("#lblkdmakanan6spn").css('display', 'none');
            $("#lblketerangan6spn").css('display', 'none');
            $("#lblkdkerja7spn").css('display', 'none');
            $("#lblkdmakanan7spn").css('display', 'none');
            $("#lblketerangan7spn").css('display', 'none');
            $("#lblkdkerja8spn").css('display', 'none');
            $("#lblkdmakanan8spn").css('display', 'none');
            $("#lblketerangan8spn").css('display', 'none');
            $("#lblkdkerja9spn").css('display', 'none');
            $("#lblkdmakanan9spn").css('display', 'none');
            $("#lblketerangan9spn").css('display', 'none');
            $("#lblkdkerja10spn").css('display', 'none');
            $("#lblkdmakanan10spn").css('display', 'none');
            $("#lblketerangan10spn").css('display', 'none');
            return "false";
          }else if($("#kdkerja4 :selected").val() == 'WFO' && $("#kdmakanan4 :selected").val() == ''){
            $(".print-error-msg").css('display', 'block');
            $("#lblerror").text('Makan Siang Harus Di Pilih');
            $("#lblerror").css('display', 'block');
            $("#lblkdkerjaspn").css('display', 'none');
            $("#lblkdmakananspn").css('display', 'none');
            $("#lblketeranganspn").css('display', 'none');
            $("#lblkdkerja2spn").css('display', 'none');
            $("#lblkdmakanan2spn").css('display', 'none');
            $("#lblketerangan2spn").css('display', 'none');
            $("#lblkdkerja3spn").css('display', 'none');
            $("#lblkdmakanan3spn").css('display', 'none');
            $("#lblketerangan3spn").css('display', 'none');
            $("#lblkdkerja4spn").css('display', 'none');
            $("#lblkdmakanan4spn").css('display', 'inline');
            $("#lblketerangan4spn").css('display', 'none');
            $("#lblkdkerja5spn").css('display', 'none');
            $("#lblkdmakanan5spn").css('display', 'none');
            $("#lblketerangan5spn").css('display', 'none');
            $("#lblkdkerja6spn").css('display', 'none');
            $("#lblkdmakanan6spn").css('display', 'none');
            $("#lblketerangan6spn").css('display', 'none');
            $("#lblkdkerja7spn").css('display', 'none');
            $("#lblkdmakanan7spn").css('display', 'none');
            $("#lblketerangan7spn").css('display', 'none');
            $("#lblkdkerja8spn").css('display', 'none');
            $("#lblkdmakanan8spn").css('display', 'none');
            $("#lblketerangan8spn").css('display', 'none');
            $("#lblkdkerja9spn").css('display', 'none');
            $("#lblkdmakanan9spn").css('display', 'none');
            $("#lblketerangan9spn").css('display', 'none');
            $("#lblkdkerja10spn").css('display', 'none');
            $("#lblkdmakanan10spn").css('display', 'none');
            $("#lblketerangan10spn").css('display', 'none');
            return "false";
          }else if($("#max4").val() == '1'){
            $(".print-error-msg").css('display', 'block');
            $("#lblerror").text('Keterangan Harus Di Isi');
            $("#lblerror").css('display', 'block');
            $("#lblkdkerjaspn").css('display', 'none');
            $("#lblkdmakananspn").css('display', 'none');
            $("#lblketeranganspn").css('display', 'none');
            $("#lblkdkerja2spn").css('display', 'none');
            $("#lblkdmakanan2spn").css('display', 'none');
            $("#lblketerangan2spn").css('display', 'none');
            $("#lblkdkerja3spn").css('display', 'none');
            $("#lblkdmakanan3spn").css('display', 'none');
            $("#lblketerangan3spn").css('display', 'none');
            $("#lblkdkerja4spn").css('display', 'none');
            $("#lblkdmakanan4spn").css('display', 'none');
            $("#lblketerangan4spn").css('display', 'inline');
            $("#lblkdkerja5spn").css('display', 'none');
            $("#lblkdmakanan5spn").css('display', 'none');
            $("#lblketerangan5spn").css('display', 'none');
            $("#lblkdkerja6spn").css('display', 'none');
            $("#lblkdmakanan6spn").css('display', 'none');
            $("#lblketerangan6spn").css('display', 'none');
            $("#lblkdkerja7spn").css('display', 'none');
            $("#lblkdmakanan7spn").css('display', 'none');
            $("#lblketerangan7spn").css('display', 'none');
            $("#lblkdkerja8spn").css('display', 'none');
            $("#lblkdmakanan8spn").css('display', 'none');
            $("#lblketerangan8spn").css('display', 'none');
            $("#lblkdkerja9spn").css('display', 'none');
            $("#lblkdmakanan9spn").css('display', 'none');
            $("#lblketerangan9spn").css('display', 'none');
            $("#lblkdkerja10spn").css('display', 'none');
            $("#lblkdmakanan10spn").css('display', 'none');
            $("#lblketerangan10spn").css('display', 'none');
            return "false";
          }else if($("#kdkerja5 :selected").val() == '' && $("#keterangan5").val() != 'Hari Libur'){
            $(".print-error-msg").css('display', 'block');
            $("#lblerror").text('Jadwal Kerja Harus Di Pilih');
            $("#lblerror").css('display', 'block');
            $("#lblkdkerjaspn").css('display', 'none');
            $("#lblkdmakananspn").css('display', 'none');
            $("#lblketeranganspn").css('display', 'none');
            $("#lblkdkerja2spn").css('display', 'none');
            $("#lblkdmakanan2spn").css('display', 'none');
            $("#lblketerangan2spn").css('display', 'none');
            $("#lblkdkerja3spn").css('display', 'none');
            $("#lblkdmakanan3spn").css('display', 'none');
            $("#lblketerangan3spn").css('display', 'none');
            $("#lblkdkerja4spn").css('display', 'none');
            $("#lblkdmakanan4spn").css('display', 'none');
            $("#lblketerangan4spn").css('display', 'none');
            $("#lblkdkerja5spn").css('display', 'inline');
            $("#lblkdmakanan5spn").css('display', 'none');
            $("#lblketerangan5spn").css('display', 'none');
            $("#lblkdkerja6spn").css('display', 'none');
            $("#lblkdmakanan6spn").css('display', 'none');
            $("#lblketerangan6spn").css('display', 'none');
            $("#lblkdkerja7spn").css('display', 'none');
            $("#lblkdmakanan7spn").css('display', 'none');
            $("#lblketerangan7spn").css('display', 'none');
            $("#lblkdkerja8spn").css('display', 'none');
            $("#lblkdmakanan8spn").css('display', 'none');
            $("#lblketerangan8spn").css('display', 'none');
            $("#lblkdkerja9spn").css('display', 'none');
            $("#lblkdmakanan9spn").css('display', 'none');
            $("#lblketerangan9spn").css('display', 'none');
            $("#lblkdkerja10spn").css('display', 'none');
            $("#lblkdmakanan10spn").css('display', 'none');
            $("#lblketerangan10spn").css('display', 'none');
            return "false";
          }else if($("#kdkerja5 :selected").val() == 'WFO' && $("#kdmakanan5 :selected").val() == ''){
            $(".print-error-msg").css('display', 'block');
            $("#lblerror").text('Makan Siang Harus Di Pilih');
            $("#lblerror").css('display', 'block');
            $("#lblkdkerjaspn").css('display', 'none');
            $("#lblkdmakananspn").css('display', 'none');
            $("#lblketeranganspn").css('display', 'none');
            $("#lblkdkerja2spn").css('display', 'none');
            $("#lblkdmakanan2spn").css('display', 'none');
            $("#lblketerangan2spn").css('display', 'none');
            $("#lblkdkerja3spn").css('display', 'none');
            $("#lblkdmakanan3spn").css('display', 'none');
            $("#lblketerangan3spn").css('display', 'none');
            $("#lblkdkerja4spn").css('display', 'none');
            $("#lblkdmakanan4spn").css('display', 'none');
            $("#lblketerangan4spn").css('display', 'none');
            $("#lblkdkerja5spn").css('display', 'none');
            $("#lblkdmakanan5spn").css('display', 'inline');
            $("#lblketerangan5spn").css('display', 'none');
            $("#lblkdkerja6spn").css('display', 'none');
            $("#lblkdmakanan6spn").css('display', 'none');
            $("#lblketerangan6spn").css('display', 'none');
            $("#lblkdkerja7spn").css('display', 'none');
            $("#lblkdmakanan7spn").css('display', 'none');
            $("#lblketerangan7spn").css('display', 'none');
            $("#lblkdkerja8spn").css('display', 'none');
            $("#lblkdmakanan8spn").css('display', 'none');
            $("#lblketerangan8spn").css('display', 'none');
            $("#lblkdkerja9spn").css('display', 'none');
            $("#lblkdmakanan9spn").css('display', 'none');
            $("#lblketerangan9spn").css('display', 'none');
            $("#lblkdkerja10spn").css('display', 'none');
            $("#lblkdmakanan10spn").css('display', 'none');
            $("#lblketerangan10spn").css('display', 'none');
            return "false";
          }else if($("#max5").val() == '1'){
            $(".print-error-msg").css('display', 'block');
            $("#lblerror").text('Keterangan Harus Di Isi');
            $("#lblerror").css('display', 'block');
            $("#lblkdkerjaspn").css('display', 'none');
            $("#lblkdmakananspn").css('display', 'none');
            $("#lblketeranganspn").css('display', 'none');
            $("#lblkdkerja2spn").css('display', 'none');
            $("#lblkdmakanan2spn").css('display', 'none');
            $("#lblketerangan2spn").css('display', 'none');
            $("#lblkdkerja3spn").css('display', 'none');
            $("#lblkdmakanan3spn").css('display', 'none');
            $("#lblketerangan3spn").css('display', 'none');
            $("#lblkdkerja4spn").css('display', 'none');
            $("#lblkdmakanan4spn").css('display', 'none');
            $("#lblketerangan4spn").css('display', 'none');
            $("#lblkdkerja5spn").css('display', 'none');
            $("#lblkdmakanan5spn").css('display', 'none');
            $("#lblketerangan5spn").css('display', 'inline');
            $("#lblkdkerja6spn").css('display', 'none');
            $("#lblkdmakanan6spn").css('display', 'none');
            $("#lblketerangan6spn").css('display', 'none');
            $("#lblkdkerja7spn").css('display', 'none');
            $("#lblkdmakanan7spn").css('display', 'none');
            $("#lblketerangan7spn").css('display', 'none');
            $("#lblkdkerja8spn").css('display', 'none');
            $("#lblkdmakanan8spn").css('display', 'none');
            $("#lblketerangan8spn").css('display', 'none');
            $("#lblkdkerja9spn").css('display', 'none');
            $("#lblkdmakanan9spn").css('display', 'none');
            $("#lblketerangan9spn").css('display', 'none');
            $("#lblkdkerja10spn").css('display', 'none');
            $("#lblkdmakanan10spn").css('display', 'none');
            $("#lblketerangan10spn").css('display', 'none');
            return "false";
          }else if($("#kdkerja6 :selected").val() == '' && $("#keterangan6").val() != 'Hari Libur'){
            $(".print-error-msg").css('display', 'block');
            $("#lblerror").text('Jadwal Kerja Harus Di Pilih');
            $("#lblerror").css('display', 'block');
            $("#lblkdkerjaspn").css('display', 'none');
            $("#lblkdmakananspn").css('display', 'none');
            $("#lblketeranganspn").css('display', 'none');
            $("#lblkdkerja2spn").css('display', 'none');
            $("#lblkdmakanan2spn").css('display', 'none');
            $("#lblketerangan2spn").css('display', 'none');
            $("#lblkdkerja3spn").css('display', 'none');
            $("#lblkdmakanan3spn").css('display', 'none');
            $("#lblketerangan3spn").css('display', 'none');
            $("#lblkdkerja4spn").css('display', 'none');
            $("#lblkdmakanan4spn").css('display', 'none');
            $("#lblketerangan4spn").css('display', 'none');
            $("#lblkdkerja5spn").css('display', 'none');
            $("#lblkdmakanan5spn").css('display', 'none');
            $("#lblketerangan5spn").css('display', 'none');
            $("#lblkdkerja6spn").css('display', 'inline');
            $("#lblkdmakanan6spn").css('display', 'none');
            $("#lblketerangan6spn").css('display', 'none');
            $("#lblkdkerja7spn").css('display', 'none');
            $("#lblkdmakanan7spn").css('display', 'none');
            $("#lblketerangan7spn").css('display', 'none');
            $("#lblkdkerja8spn").css('display', 'none');
            $("#lblkdmakanan8spn").css('display', 'none');
            $("#lblketerangan8spn").css('display', 'none');
            $("#lblkdkerja9spn").css('display', 'none');
            $("#lblkdmakanan9spn").css('display', 'none');
            $("#lblketerangan9spn").css('display', 'none');
            $("#lblkdkerja10spn").css('display', 'none');
            $("#lblkdmakanan10spn").css('display', 'none');
            $("#lblketerangan10spn").css('display', 'none');
            return "false";
          }else if($("#kdkerja6 :selected").val() == 'WFO' && $("#kdmakanan6 :selected").val() == ''){
            $(".print-error-msg").css('display', 'block');
            $("#lblerror").text('Makan Siang Harus Di Pilih');
            $("#lblerror").css('display', 'block');
            $("#lblkdkerjaspn").css('display', 'none');
            $("#lblkdmakananspn").css('display', 'none');
            $("#lblketeranganspn").css('display', 'none');
            $("#lblkdkerja2spn").css('display', 'none');
            $("#lblkdmakanan2spn").css('display', 'none');
            $("#lblketerangan2spn").css('display', 'none');
            $("#lblkdkerja3spn").css('display', 'none');
            $("#lblkdmakanan3spn").css('display', 'none');
            $("#lblketerangan3spn").css('display', 'none');
            $("#lblkdkerja4spn").css('display', 'none');
            $("#lblkdmakanan4spn").css('display', 'none');
            $("#lblketerangan4spn").css('display', 'none');
            $("#lblkdkerja5spn").css('display', 'none');
            $("#lblkdmakanan5spn").css('display', 'none');
            $("#lblketerangan5spn").css('display', 'none');
            $("#lblkdkerja6spn").css('display', 'none');
            $("#lblkdmakanan6spn").css('display', 'inline');
            $("#lblketerangan6spn").css('display', 'none');
            $("#lblkdkerja7spn").css('display', 'none');
            $("#lblkdmakanan7spn").css('display', 'none');
            $("#lblketerangan7spn").css('display', 'none');
            $("#lblkdkerja8spn").css('display', 'none');
            $("#lblkdmakanan8spn").css('display', 'none');
            $("#lblketerangan8spn").css('display', 'none');
            $("#lblkdkerja9spn").css('display', 'none');
            $("#lblkdmakanan9spn").css('display', 'none');
            $("#lblketerangan9spn").css('display', 'none');
            $("#lblkdkerja10spn").css('display', 'none');
            $("#lblkdmakanan10spn").css('display', 'none');
            $("#lblketerangan10spn").css('display', 'none');
            return "false";
          }else if($("#max6").val() == '1'){
            $(".print-error-msg").css('display', 'block');
            $("#lblerror").text('Keterangan Harus Di Isi');
            $("#lblerror").css('display', 'block');
            $("#lblkdkerjaspn").css('display', 'none');
            $("#lblkdmakananspn").css('display', 'none');
            $("#lblketeranganspn").css('display', 'none');
            $("#lblkdkerja2spn").css('display', 'none');
            $("#lblkdmakanan2spn").css('display', 'none');
            $("#lblketerangan2spn").css('display', 'none');
            $("#lblkdkerja3spn").css('display', 'none');
            $("#lblkdmakanan3spn").css('display', 'none');
            $("#lblketerangan3spn").css('display', 'none');
            $("#lblkdkerja4spn").css('display', 'none');
            $("#lblkdmakanan4spn").css('display', 'none');
            $("#lblketerangan4spn").css('display', 'none');
            $("#lblkdkerja5spn").css('display', 'none');
            $("#lblkdmakanan5spn").css('display', 'none');
            $("#lblketerangan5spn").css('display', 'none');
            $("#lblkdkerja6spn").css('display', 'none');
            $("#lblkdmakanan6spn").css('display', 'none');
            $("#lblketerangan6spn").css('display', 'inline');
            $("#lblkdkerja7spn").css('display', 'none');
            $("#lblkdmakanan7spn").css('display', 'none');
            $("#lblketerangan7spn").css('display', 'none');
            $("#lblkdkerja8spn").css('display', 'none');
            $("#lblkdmakanan8spn").css('display', 'none');
            $("#lblketerangan8spn").css('display', 'none');
            $("#lblkdkerja9spn").css('display', 'none');
            $("#lblkdmakanan9spn").css('display', 'none');
            $("#lblketerangan9spn").css('display', 'none');
            $("#lblkdkerja10spn").css('display', 'none');
            $("#lblkdmakanan10spn").css('display', 'none');
            $("#lblketerangan10spn").css('display', 'none');
            return "false";
          }else if($("#kdkerja7 :selected").val() == '' && $("#keterangan7").val() != 'Hari Libur'){
            $(".print-error-msg").css('display', 'block');
            $("#lblerror").text('Jadwal Kerja Harus Di Pilih');
            $("#lblerror").css('display', 'block');
            $("#lblkdkerjaspn").css('display', 'none');
            $("#lblkdmakananspn").css('display', 'none');
            $("#lblketeranganspn").css('display', 'none');
            $("#lblkdkerja2spn").css('display', 'none');
            $("#lblkdmakanan2spn").css('display', 'none');
            $("#lblketerangan2spn").css('display', 'none');
            $("#lblkdkerja3spn").css('display', 'none');
            $("#lblkdmakanan3spn").css('display', 'none');
            $("#lblketerangan3spn").css('display', 'none');
            $("#lblkdkerja4spn").css('display', 'none');
            $("#lblkdmakanan4spn").css('display', 'none');
            $("#lblketerangan4spn").css('display', 'none');
            $("#lblkdkerja5spn").css('display', 'none');
            $("#lblkdmakanan5spn").css('display', 'none');
            $("#lblketerangan5spn").css('display', 'none');
            $("#lblkdkerja6spn").css('display', 'none');
            $("#lblkdmakanan6spn").css('display', 'none');
            $("#lblketerangan6spn").css('display', 'none');
            $("#lblkdkerja7spn").css('display', 'inline');
            $("#lblkdmakanan7spn").css('display', 'none');
            $("#lblketerangan7spn").css('display', 'none');
            $("#lblkdkerja8spn").css('display', 'none');
            $("#lblkdmakanan8spn").css('display', 'none');
            $("#lblketerangan8spn").css('display', 'none');
            $("#lblkdkerja9spn").css('display', 'none');
            $("#lblkdmakanan9spn").css('display', 'none');
            $("#lblketerangan9spn").css('display', 'none');
            $("#lblkdkerja10spn").css('display', 'none');
            $("#lblkdmakanan10spn").css('display', 'none');
            $("#lblketerangan10spn").css('display', 'none');
            return "false";
          }else if($("#kdkerja7 :selected").val() == 'WFO' && $("#kdmakanan7 :selected").val() == ''){
            $(".print-error-msg").css('display', 'block');
            $("#lblerror").text('Makan Siang Harus Di Pilih');
            $("#lblerror").css('display', 'block');
            $("#lblkdkerjaspn").css('display', 'none');
            $("#lblkdmakananspn").css('display', 'none');
            $("#lblketeranganspn").css('display', 'none');
            $("#lblkdkerja2spn").css('display', 'none');
            $("#lblkdmakanan2spn").css('display', 'none');
            $("#lblketerangan2spn").css('display', 'none');
            $("#lblkdkerja3spn").css('display', 'none');
            $("#lblkdmakanan3spn").css('display', 'none');
            $("#lblketerangan3spn").css('display', 'none');
            $("#lblkdkerja4spn").css('display', 'none');
            $("#lblkdmakanan4spn").css('display', 'none');
            $("#lblketerangan4spn").css('display', 'none');
            $("#lblkdkerja5spn").css('display', 'none');
            $("#lblkdmakanan5spn").css('display', 'none');
            $("#lblketerangan5spn").css('display', 'none');
            $("#lblkdkerja6spn").css('display', 'none');
            $("#lblkdmakanan6spn").css('display', 'none');
            $("#lblketerangan6spn").css('display', 'none');
            $("#lblkdkerja7spn").css('display', 'none');
            $("#lblkdmakanan7spn").css('display', 'inline');
            $("#lblketerangan7spn").css('display', 'none');
            $("#lblkdkerja8spn").css('display', 'none');
            $("#lblkdmakanan8spn").css('display', 'none');
            $("#lblketerangan8spn").css('display', 'none');
            $("#lblkdkerja9spn").css('display', 'none');
            $("#lblkdmakanan9spn").css('display', 'none');
            $("#lblketerangan9spn").css('display', 'none');
            $("#lblkdkerja10spn").css('display', 'none');
            $("#lblkdmakanan10spn").css('display', 'none');
            $("#lblketerangan10spn").css('display', 'none');
            return "false";
          }else if($("#max7").val() == '1'){
            $(".print-error-msg").css('display', 'block');
            $("#lblerror").text('Keterangan Harus Di Isi');
            $("#lblerror").css('display', 'block');
            $("#lblkdkerjaspn").css('display', 'none');
            $("#lblkdmakananspn").css('display', 'none');
            $("#lblketeranganspn").css('display', 'none');
            $("#lblkdkerja2spn").css('display', 'none');
            $("#lblkdmakanan2spn").css('display', 'none');
            $("#lblketerangan2spn").css('display', 'none');
            $("#lblkdkerja3spn").css('display', 'none');
            $("#lblkdmakanan3spn").css('display', 'none');
            $("#lblketerangan3spn").css('display', 'none');
            $("#lblkdkerja4spn").css('display', 'none');
            $("#lblkdmakanan4spn").css('display', 'none');
            $("#lblketerangan4spn").css('display', 'none');
            $("#lblkdkerja5spn").css('display', 'none');
            $("#lblkdmakanan5spn").css('display', 'none');
            $("#lblketerangan5spn").css('display', 'none');
            $("#lblkdkerja6spn").css('display', 'none');
            $("#lblkdmakanan6spn").css('display', 'none');
            $("#lblketerangan6spn").css('display', 'none');
            $("#lblkdkerja7spn").css('display', 'none');
            $("#lblkdmakanan7spn").css('display', 'none');
            $("#lblketerangan7spn").css('display', 'inline');
            $("#lblkdkerja8spn").css('display', 'none');
            $("#lblkdmakanan8spn").css('display', 'none');
            $("#lblketerangan8spn").css('display', 'none');
            $("#lblkdkerja9spn").css('display', 'none');
            $("#lblkdmakanan9spn").css('display', 'none');
            $("#lblketerangan9spn").css('display', 'none');
            $("#lblkdkerja10spn").css('display', 'none');
            $("#lblkdmakanan10spn").css('display', 'none');
            $("#lblketerangan10spn").css('display', 'none');
            return "false";
          }else if($("#kdkerja8 :selected").val() == '' && $("#keterangan8").val() != 'Hari Libur'){
            $(".print-error-msg").css('display', 'block');
            $("#lblerror").text('Jadwal Kerja Harus Di Pilih');
            $("#lblerror").css('display', 'block');
            $("#lblkdkerjaspn").css('display', 'none');
            $("#lblkdmakananspn").css('display', 'none');
            $("#lblketeranganspn").css('display', 'none');
            $("#lblkdkerja2spn").css('display', 'none');
            $("#lblkdmakanan2spn").css('display', 'none');
            $("#lblketerangan2spn").css('display', 'none');
            $("#lblkdkerja3spn").css('display', 'none');
            $("#lblkdmakanan3spn").css('display', 'none');
            $("#lblketerangan3spn").css('display', 'none');
            $("#lblkdkerja4spn").css('display', 'none');
            $("#lblkdmakanan4spn").css('display', 'none');
            $("#lblketerangan4spn").css('display', 'none');
            $("#lblkdkerja5spn").css('display', 'none');
            $("#lblkdmakanan5spn").css('display', 'none');
            $("#lblketerangan5spn").css('display', 'none');
            $("#lblkdkerja6spn").css('display', 'none');
            $("#lblkdmakanan6spn").css('display', 'none');
            $("#lblketerangan6spn").css('display', 'none');
            $("#lblkdkerja7spn").css('display', 'none');
            $("#lblkdmakanan7spn").css('display', 'none');
            $("#lblketerangan7spn").css('display', 'none');
            $("#lblkdkerja8spn").css('display', 'inline');
            $("#lblkdmakanan8spn").css('display', 'none');
            $("#lblketerangan8spn").css('display', 'none');
            $("#lblkdkerja9spn").css('display', 'none');
            $("#lblkdmakanan9spn").css('display', 'none');
            $("#lblketerangan9spn").css('display', 'none');
            $("#lblkdkerja10spn").css('display', 'none');
            $("#lblkdmakanan10spn").css('display', 'none');
            $("#lblketerangan10spn").css('display', 'none');
            return "false";
          }else if($("#kdkerja8 :selected").val() == 'WFO' && $("#kdmakanan8 :selected").val() == ''){
            $(".print-error-msg").css('display', 'block');
            $("#lblerror").text('Makan Siang Harus Di Pilih');
            $("#lblerror").css('display', 'block');
            $("#lblkdkerjaspn").css('display', 'none');
            $("#lblkdmakananspn").css('display', 'none');
            $("#lblketeranganspn").css('display', 'none');
            $("#lblkdkerja2spn").css('display', 'none');
            $("#lblkdmakanan2spn").css('display', 'none');
            $("#lblketerangan2spn").css('display', 'none');
            $("#lblkdkerja3spn").css('display', 'none');
            $("#lblkdmakanan3spn").css('display', 'none');
            $("#lblketerangan3spn").css('display', 'none');
            $("#lblkdkerja4spn").css('display', 'none');
            $("#lblkdmakanan4spn").css('display', 'none');
            $("#lblketerangan4spn").css('display', 'none');
            $("#lblkdkerja5spn").css('display', 'none');
            $("#lblkdmakanan5spn").css('display', 'none');
            $("#lblketerangan5spn").css('display', 'none');
            $("#lblkdkerja6spn").css('display', 'none');
            $("#lblkdmakanan6spn").css('display', 'none');
            $("#lblketerangan6spn").css('display', 'none');
            $("#lblkdkerja7spn").css('display', 'none');
            $("#lblkdmakanan7spn").css('display', 'none');
            $("#lblketerangan7spn").css('display', 'none');
            $("#lblkdkerja8spn").css('display', 'none');
            $("#lblkdmakanan8spn").css('display', 'inline');
            $("#lblketerangan8spn").css('display', 'none');
            $("#lblkdkerja9spn").css('display', 'none');
            $("#lblkdmakanan9spn").css('display', 'none');
            $("#lblketerangan9spn").css('display', 'none');
            $("#lblkdkerja10spn").css('display', 'none');
            $("#lblkdmakanan10spn").css('display', 'none');
            $("#lblketerangan10spn").css('display', 'none');
            return "false";
          }else if($("#max8").val() == '1'){
            $(".print-error-msg").css('display', 'block');
            $("#lblerror").text('Keterangan Harus Di Isi');
            $("#lblerror").css('display', 'block');
            $("#lblkdkerjaspn").css('display', 'none');
            $("#lblkdmakananspn").css('display', 'none');
            $("#lblketeranganspn").css('display', 'none');
            $("#lblkdkerja2spn").css('display', 'none');
            $("#lblkdmakanan2spn").css('display', 'none');
            $("#lblketerangan2spn").css('display', 'none');
            $("#lblkdkerja3spn").css('display', 'none');
            $("#lblkdmakanan3spn").css('display', 'none');
            $("#lblketerangan3spn").css('display', 'none');
            $("#lblkdkerja4spn").css('display', 'none');
            $("#lblkdmakanan4spn").css('display', 'none');
            $("#lblketerangan4spn").css('display', 'none');
            $("#lblkdkerja5spn").css('display', 'none');
            $("#lblkdmakanan5spn").css('display', 'none');
            $("#lblketerangan5spn").css('display', 'none');
            $("#lblkdkerja6spn").css('display', 'none');
            $("#lblkdmakanan6spn").css('display', 'none');
            $("#lblketerangan6spn").css('display', 'none');
            $("#lblkdkerja7spn").css('display', 'none');
            $("#lblkdmakanan7spn").css('display', 'none');
            $("#lblketerangan7spn").css('display', 'none');
            $("#lblkdkerja8spn").css('display', 'none');
            $("#lblkdmakanan8spn").css('display', 'none');
            $("#lblketerangan8spn").css('display', 'inline');
            $("#lblkdkerja9spn").css('display', 'none');
            $("#lblkdmakanan9spn").css('display', 'none');
            $("#lblketerangan9spn").css('display', 'none');
            $("#lblkdkerja10spn").css('display', 'none');
            $("#lblkdmakanan10spn").css('display', 'none');
            $("#lblketerangan10spn").css('display', 'none');
            return "false";
          }else if($("#kdkerja9 :selected").val() == '' && $("#keterangan9").val() != 'Hari Libur'){
            $(".print-error-msg").css('display', 'block');
            $("#lblerror").text('Jadwal Kerja Harus Di Pilih');
            $("#lblerror").css('display', 'block');
            $("#lblkdkerjaspn").css('display', 'none');
            $("#lblkdmakananspn").css('display', 'none');
            $("#lblketeranganspn").css('display', 'none');
            $("#lblkdkerja2spn").css('display', 'none');
            $("#lblkdmakanan2spn").css('display', 'none');
            $("#lblketerangan2spn").css('display', 'none');
            $("#lblkdkerja3spn").css('display', 'none');
            $("#lblkdmakanan3spn").css('display', 'none');
            $("#lblketerangan3spn").css('display', 'none');
            $("#lblkdkerja4spn").css('display', 'none');
            $("#lblkdmakanan4spn").css('display', 'none');
            $("#lblketerangan4spn").css('display', 'none');
            $("#lblkdkerja5spn").css('display', 'none');
            $("#lblkdmakanan5spn").css('display', 'none');
            $("#lblketerangan5spn").css('display', 'none');
            $("#lblkdkerja6spn").css('display', 'none');
            $("#lblkdmakanan6spn").css('display', 'none');
            $("#lblketerangan6spn").css('display', 'none');
            $("#lblkdkerja7spn").css('display', 'none');
            $("#lblkdmakanan7spn").css('display', 'none');
            $("#lblketerangan7spn").css('display', 'none');
            $("#lblkdkerja8spn").css('display', 'none');
            $("#lblkdmakanan8spn").css('display', 'none');
            $("#lblketerangan8spn").css('display', 'none');
            $("#lblkdkerja9spn").css('display', 'inline');
            $("#lblkdmakanan9spn").css('display', 'none');
            $("#lblketerangan9spn").css('display', 'none');
            $("#lblkdkerja10spn").css('display', 'none');
            $("#lblkdmakanan10spn").css('display', 'none');
            $("#lblketerangan10spn").css('display', 'none');
            return "false";
          }else if($("#kdkerja9 :selected").val() == 'WFO' && $("#kdmakanan9 :selected").val() == ''){
            $(".print-error-msg").css('display', 'block');
            $("#lblerror").text('Makan Siang Harus Di Pilih');
            $("#lblerror").css('display', 'block');
            $("#lblkdkerjaspn").css('display', 'none');
            $("#lblkdmakananspn").css('display', 'none');
            $("#lblketeranganspn").css('display', 'none');
            $("#lblkdkerja2spn").css('display', 'none');
            $("#lblkdmakanan2spn").css('display', 'none');
            $("#lblketerangan2spn").css('display', 'none');
            $("#lblkdkerja3spn").css('display', 'none');
            $("#lblkdmakanan3spn").css('display', 'none');
            $("#lblketerangan3spn").css('display', 'none');
            $("#lblkdkerja4spn").css('display', 'none');
            $("#lblkdmakanan4spn").css('display', 'none');
            $("#lblketerangan4spn").css('display', 'none');
            $("#lblkdkerja5spn").css('display', 'none');
            $("#lblkdmakanan5spn").css('display', 'none');
            $("#lblketerangan5spn").css('display', 'none');
            $("#lblkdkerja6spn").css('display', 'none');
            $("#lblkdmakanan6spn").css('display', 'none');
            $("#lblketerangan6spn").css('display', 'none');
            $("#lblkdkerja7spn").css('display', 'none');
            $("#lblkdmakanan7spn").css('display', 'none');
            $("#lblketerangan7spn").css('display', 'none');
            $("#lblkdkerja8spn").css('display', 'none');
            $("#lblkdmakanan8spn").css('display', 'none');
            $("#lblketerangan8spn").css('display', 'none');
            $("#lblkdkerja9spn").css('display', 'none');
            $("#lblkdmakanan9spn").css('display', 'inline');
            $("#lblketerangan9spn").css('display', 'none');
            $("#lblkdkerja10spn").css('display', 'none');
            $("#lblkdmakanan10spn").css('display', 'none');
            $("#lblketerangan10spn").css('display', 'none');
            return "false";
          }else if($("#max9").val() == '1'){
            $(".print-error-msg").css('display', 'block');
            $("#lblerror").text('Keterangan Harus Di Isi');
            $("#lblerror").css('display', 'block');
            $("#lblkdkerjaspn").css('display', 'none');
            $("#lblkdmakananspn").css('display', 'none');
            $("#lblketeranganspn").css('display', 'none');
            $("#lblkdkerja2spn").css('display', 'none');
            $("#lblkdmakanan2spn").css('display', 'none');
            $("#lblketerangan2spn").css('display', 'none');
            $("#lblkdkerja3spn").css('display', 'none');
            $("#lblkdmakanan3spn").css('display', 'none');
            $("#lblketerangan3spn").css('display', 'none');
            $("#lblkdkerja4spn").css('display', 'none');
            $("#lblkdmakanan4spn").css('display', 'none');
            $("#lblketerangan4spn").css('display', 'none');
            $("#lblkdkerja5spn").css('display', 'none');
            $("#lblkdmakanan5spn").css('display', 'none');
            $("#lblketerangan5spn").css('display', 'none');
            $("#lblkdkerja6spn").css('display', 'none');
            $("#lblkdmakanan6spn").css('display', 'none');
            $("#lblketerangan6spn").css('display', 'none');
            $("#lblkdkerja7spn").css('display', 'none');
            $("#lblkdmakanan7spn").css('display', 'none');
            $("#lblketerangan7spn").css('display', 'none');
            $("#lblkdkerja8spn").css('display', 'none');
            $("#lblkdmakanan8spn").css('display', 'none');
            $("#lblketerangan8spn").css('display', 'none');
            $("#lblkdkerja9spn").css('display', 'none');
            $("#lblkdmakanan9spn").css('display', 'none');
            $("#lblketerangan9spn").css('display', 'inline');
            $("#lblkdkerja10spn").css('display', 'none');
            $("#lblkdmakanan10spn").css('display', 'none');
            $("#lblketerangan10spn").css('display', 'none');
            return "false";
          }else if($("#kdkerja10 :selected").val() == '' && $("#keterangan10").val() != 'Hari Libur'){
            $(".print-error-msg").css('display', 'block');
            $("#lblerror").text('Jadwal Kerja Harus Di Pilih');
            $("#lblerror").css('display', 'block');
            $("#lblkdkerjaspn").css('display', 'none');
            $("#lblkdmakananspn").css('display', 'none');
            $("#lblketeranganspn").css('display', 'none');
            $("#lblkdkerja2spn").css('display', 'none');
            $("#lblkdmakanan2spn").css('display', 'none');
            $("#lblketerangan2spn").css('display', 'none');
            $("#lblkdkerja3spn").css('display', 'none');
            $("#lblkdmakanan3spn").css('display', 'none');
            $("#lblketerangan3spn").css('display', 'none');
            $("#lblkdkerja4spn").css('display', 'none');
            $("#lblkdmakanan4spn").css('display', 'none');
            $("#lblketerangan4spn").css('display', 'none');
            $("#lblkdkerja5spn").css('display', 'none');
            $("#lblkdmakanan5spn").css('display', 'none');
            $("#lblketerangan5spn").css('display', 'none');
            $("#lblkdkerja6spn").css('display', 'none');
            $("#lblkdmakanan6spn").css('display', 'none');
            $("#lblketerangan6spn").css('display', 'none');
            $("#lblkdkerja7spn").css('display', 'none');
            $("#lblkdmakanan7spn").css('display', 'none');
            $("#lblketerangan7spn").css('display', 'none');
            $("#lblkdkerja8spn").css('display', 'none');
            $("#lblkdmakanan8spn").css('display', 'none');
            $("#lblketerangan8spn").css('display', 'none');
            $("#lblkdkerja9spn").css('display', 'none');
            $("#lblkdmakanan9spn").css('display', 'none');
            $("#lblketerangan9spn").css('display', 'none');
            $("#lblkdkerja10spn").css('display', 'inline');
            $("#lblkdmakanan10spn").css('display', 'none');
            $("#lblketerangan10spn").css('display', 'none');
            return "false";
          }else if($("#kdkerja10 :selected").val() == 'WFO' && $("#kdmakanan10 :selected").val() == ''){
            $(".print-error-msg").css('display', 'block');
            $("#lblerror").text('Makan Siang Harus Di Pilih');
            $("#lblerror").css('display', 'block');
            $("#lblkdkerjaspn").css('display', 'none');
            $("#lblkdmakananspn").css('display', 'none');
            $("#lblketeranganspn").css('display', 'none');
            $("#lblkdkerja2spn").css('display', 'none');
            $("#lblkdmakanan2spn").css('display', 'none');
            $("#lblketerangan2spn").css('display', 'none');
            $("#lblkdkerja3spn").css('display', 'none');
            $("#lblkdmakanan3spn").css('display', 'none');
            $("#lblketerangan3spn").css('display', 'none');
            $("#lblkdkerja4spn").css('display', 'none');
            $("#lblkdmakanan4spn").css('display', 'none');
            $("#lblketerangan4spn").css('display', 'none');
            $("#lblkdkerja5spn").css('display', 'none');
            $("#lblkdmakanan5spn").css('display', 'none');
            $("#lblketerangan5spn").css('display', 'none');
            $("#lblkdkerja6spn").css('display', 'none');
            $("#lblkdmakanan6spn").css('display', 'none');
            $("#lblketerangan6spn").css('display', 'none');
            $("#lblkdkerja7spn").css('display', 'none');
            $("#lblkdmakanan7spn").css('display', 'none');
            $("#lblketerangan7spn").css('display', 'none');
            $("#lblkdkerja8spn").css('display', 'none');
            $("#lblkdmakanan8spn").css('display', 'none');
            $("#lblketerangan8spn").css('display', 'none');
            $("#lblkdkerja9spn").css('display', 'none');
            $("#lblkdmakanan9spn").css('display', 'none');
            $("#lblketerangan9spn").css('display', 'none');
            $("#lblkdkerja10spn").css('display', 'none');
            $("#lblkdmakanan10spn").css('display', 'inline');
            $("#lblketerangan10spn").css('display', 'none');
            return "false";
          }else if($("#max10").val() == '1'){
            $(".print-error-msg").css('display', 'block');
            $("#lblerror").text('Keterangan Harus Di Isi');
            $("#lblerror").css('display', 'block');
            $("#lblkdkerjaspn").css('display', 'none');
            $("#lblkdmakananspn").css('display', 'none');
            $("#lblketeranganspn").css('display', 'none');
            $("#lblkdkerja2spn").css('display', 'none');
            $("#lblkdmakanan2spn").css('display', 'none');
            $("#lblketerangan2spn").css('display', 'none');
            $("#lblkdkerja3spn").css('display', 'none');
            $("#lblkdmakanan3spn").css('display', 'none');
            $("#lblketerangan3spn").css('display', 'none');
            $("#lblkdkerja4spn").css('display', 'none');
            $("#lblkdmakanan4spn").css('display', 'none');
            $("#lblketerangan4spn").css('display', 'none');
            $("#lblkdkerja5spn").css('display', 'none');
            $("#lblkdmakanan5spn").css('display', 'none');
            $("#lblketerangan5spn").css('display', 'none');
            $("#lblkdkerja6spn").css('display', 'none');
            $("#lblkdmakanan6spn").css('display', 'none');
            $("#lblketerangan6spn").css('display', 'none');
            $("#lblkdkerja7spn").css('display', 'none');
            $("#lblkdmakanan7spn").css('display', 'none');
            $("#lblketerangan7spn").css('display', 'none');
            $("#lblkdkerja8spn").css('display', 'none');
            $("#lblkdmakanan8spn").css('display', 'none');
            $("#lblketerangan8spn").css('display', 'none');
            $("#lblkdkerja9spn").css('display', 'none');
            $("#lblkdmakanan9spn").css('display', 'none');
            $("#lblketerangan9spn").css('display', 'none');
            $("#lblkdkerja10spn").css('display', 'none');
            $("#lblkdmakanan10spn").css('display', 'none');
            $("#lblketerangan10spn").css('display', 'inline');
            return "false";
          }else{
            return "true";
          }
        }

        function cek_keterangan(){
          if($("#keterangan").val() == ''){
            $("#max").val("1");
          }else{
            $("#max").val("0");
          }
        }

        function cek_keterangan2(){
          if($("#keterangan2").val() == ''){
            $("#max2").val("1");
          }else{
            $("#max2").val("0");
          }
        }

        function cek_keterangan3(){
          if($("#keterangan3").val() == ''){
            $("#max3").val("1");
          }else{
            $("#max3").val("0");
          }
        }

        function cek_keterangan4(){
          if($("#keterangan4").val() == ''){
            $("#max4").val("1");
          }else{
            $("#max4").val("0");
          }
        }

        function cek_keterangan5(){
          if($("#keterangan5").val() == ''){
            $("#max5").val("1");
          }else{
            $("#max5").val("0");
          }
        }

        function cek_keterangan6(){
          if($("#keterangan6").val() == ''){
            $("#max6").val("1");
          }else{
            $("#max6").val("0");
          }
        }

        function cek_keterangan7(){
          if($("#keterangan7").val() == ''){
            $("#max7").val("1");
          }else{
            $("#max7").val("0");
          }
        }

        function cek_keterangan8(){
          if($("#keterangan8").val() == ''){
            $("#max8").val("1");
          }else{
            $("#max8").val("0");
          }
        }

        function cek_keterangan9(){
          if($("#keterangan9").val() == ''){
            $("#max9").val("1");
          }else{
            $("#max9").val("0");
          }
        }

        function cek_keterangan10(){
          if($("#keterangan10").val() == ''){
            $("#max10").val("1");
          }else{
            $("#max10").val("0");
          }
        }

        $("#keterangan").change(cek_keterangan);
        $("#keterangan2").change(cek_keterangan2);
        $("#keterangan3").change(cek_keterangan3);
        $("#keterangan4").change(cek_keterangan4);
        $("#keterangan5").change(cek_keterangan5);
        $("#keterangan6").change(cek_keterangan6);
        $("#keterangan7").change(cek_keterangan7);
        $("#keterangan8").change(cek_keterangan8);
        $("#keterangan9").change(cek_keterangan9);
        $("#keterangan10").change(cek_keterangan10);

        function cek_wfawfoupdate(){
          if($("#kdkerjaupdate :selected").val() == 'WFO'){
            $.ajax({
              url: "{{ url('/inputwfawfo/maksimumupdatewfawfo') }}",
              data: {tanggal:$("#tanggalupdate").val()
                    , kdkerja:$("#kdkerjaupdate :selected").val()
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
              url: "{{ url('/inputwfawfo/maksimumupdatewfawfo') }}",
              data: {tanggal:$("#tanggalupdate").val()
                    , kdkerja:$("#kdkerjaupdate :selected").val()
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
              url: "{{ url('/inputwfawfo/maksimumupdatewfawfo') }}",
              data: {tanggal:$("#tanggalupdate").val()
                    , kdkerja:$("#kdkerjaupdate :selected").val()
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
              url: "{{ url('/inputwfawfo/maksimumupdatewfawfo') }}",
              data: {tanggal:$("#tanggalupdate").val()
                    , kdkerja:$("#kdkerjaupdate :selected").val()
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
              url: "{{ route('inputwfawfo.store') }}",
              type: "POST",
              dataType: 'json',
              success: function (data) {
                if(data.result == 'true'){
                  $('#wfawfoform2').trigger("reset");
                  $('#update-modal').modal('hide');
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
            return "true"
          }
        }

      });
  </script>
@stop

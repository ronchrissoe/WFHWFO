@extends('adminlte::page')

@section('title', 'WWS')

@section('content_header')
  <div class="row">
    <div class="col-md-2">
      <h1>Profile</h1>
    </div>
  </div>
@stop

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="username">Username</label>
                @if(Session::has('UserID'))
                <input type="text" class="form-control" id="username" value="{{ Session::get('UserID')}}" disabled>
                @endif
              </div>
              <div class="form-group">
                <label for="nama">Nik</label>
                @if(Session::has('Nik'))
                <input type="text" class="form-control" id="nama" value="{{ Session::get('Nik')}}" disabled>
                @endif
              </div>
              <div class="form-group">
                <label for="nama">Nama</label>
                @if(Session::has('FullName'))
                <input type="text" class="form-control" id="nama" value="{{ Session::get('FullName')}}" disabled>
                @endif
              </div>
              <div class="form-group">
                  <label for="departemen">Departemen</label>
                  @if(Session::has('Department'))
                  <input type="text" class="form-control" id="departemen" value="{{ Session::get('Department')}}" disabled>
                  @endif
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="jabatan">Jabatan</label>
                @if(Session::has('Title'))
                <input type="text" class="form-control" id="jabatan" value="{{ Session::get('Title')}}" disabled>
                @endif
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                @if(Session::has('Mail'))
                <input type="text" class="form-control" id="email" value="{{ Session::get('Mail')}}" disabled>
                @endif
              </div>
              <div class="form-group">
                <label for="perusahaan">Perusahaan</label>
                @if(Session::has('Company'))
                <input type="text" class="form-control" id="perusahaan" value="{{ Session::get('Company')}}" disabled>
                @endif
              </div>
              <div class="form-group">
                  <label for="atasanlangsung">Atasan Langsung</label>
                  @if(Session::has('Manager'))
                  <input type="text" class="form-control" id="atasanlangsung" value="{{ Session::get('Manager')}}" disabled>
                  @endif
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
    
@stop
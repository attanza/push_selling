@extends('layouts.master')
@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Users List
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="{{route('users.index')}}"><i class="fa fa-user"></i> Users</a></li>
      </ol>
    </section>
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <div class="btn-group">
            <a href="{{route('users.create')}}" class="btn btn-danger btn-sm"><i class="fa fa-plus"></i> Add User</a>
            <a href="{{route('export-data.user')}}" class="btn btn-success btn-sm"> <i class="fa fa-download"></i> Export</a>
            {{-- <export-button export_type="user"></export-button> --}}
          </div>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <user-list></user-list>
        </div>
      </div>
    </section>
  </div>
@endsection

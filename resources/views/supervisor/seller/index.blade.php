@extends('layouts.master')
@section('title')
  Seller
@stop
@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Seller List
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="{{route('users.index')}}"><i class="fa fa-user"></i> Seller</a></li>
      </ol>
    </section>
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <div class="btn-group">
            <a href="{{route('seller.create')}}" class="btn btn-danger btn-sm"><i class="fa fa-plus"></i> Add Seller</a>
            <a href="{{route('export-data.user')}}" class="btn btn-success btn-sm"> <i class="fa fa-download"></i> Export</a>
          </div>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <seller-list></seller-list>
        </div>
      </div>
    </section>
  </div>
@endsection

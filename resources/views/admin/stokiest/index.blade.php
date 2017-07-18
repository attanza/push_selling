@extends('layouts.master')
@section('title')
  Stokiest
@endsection
@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Stokiest List
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="{{route('stokiest.index')}}"><i class="fa fa-map-o"></i> Stokiest</a></li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-danger">
            <div class="box-header with-border">
              <stokiest-buttons></stokiest-buttons>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                  <i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              {{-- <market-insert-form></market-insert-form> --}}
              <stokiest-list></stokiest-list>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection

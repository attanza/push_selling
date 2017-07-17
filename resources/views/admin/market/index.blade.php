@extends('layouts.master')
@section('title')
  Market
@endsection
@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Market List
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="{{route('area.index')}}"><i class="fa fa-map-o"></i> Area</a></li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-danger">
            <div class="box-header with-border">
              <market-buttons></market-buttons>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                  <i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <market-insert-form></market-insert-form>
              <market-list></market-list>
            </div>
          </div>
        </div>
      </div>

    </section>
  </div>
@endsection

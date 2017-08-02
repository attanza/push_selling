@extends('layouts.master')
@section('title')
  Market
@endsection
@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Item List
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="{{route('items.index')}}"><i class="fa fa-cubes"></i> Items</a></li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-danger">
            <div class="box-header with-border">
              <item-buttons></item-buttons>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                  <i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <item-insert-form></item-insert-form>
              <item-list></item-list>
            </div>
          </div>
        </div>
      </div>

    </section>
  </div>
@endsection

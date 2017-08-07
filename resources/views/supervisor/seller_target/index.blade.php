@extends('layouts.master')
@section('title')
  Seller Target
@endsection
@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Seller Target
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="{{route('seller-target.index')}}"><i class="fa fa-bullseye"></i> Seller target</a></li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-danger">
            <div class="box-header with-border">
              <seller-target-buttons></seller-target-buttons>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                  <i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <seller-target-form  :item_data="{{$items}}" :seller_data="{{$sellers}}"></seller-target-form>
              <seller-target-list></seller-target-list>
            </div>
          </div>
        </div>
      </div>

    </section>
  </div>
@endsection

@extends('layouts.master')
@section('content')
  <outlet-init :outlet="{{$outlet}}"></outlet-init>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>{{$outlet->name}}</h1>
      <ol class="breadcrumb">
        <li><a href="{{route('outlet.index')}}"><i class="fa fa-building-o"></i> Outlet</a></li>
        <li class="active">{{$outlet->name}}</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <outlet-edit :market_data="{{$markets}}"></outlet-edit>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="box box-danger box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Outlet Gallery:</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-outline btn-sm"
                role="button" data-toggle="collapse" href="#add_outlet_photo" aria-expanded="false" aria-controls="add_outlet_photo">
                  <i class="fa fa-plus"></i> Add photo
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
              <add-outlet-photo :outlet_id="{{$outlet->id}}"></add-outlet-photo>
              <br>
              <outlet-gallery :outlet_id="{{$outlet->id}}"></outlet-gallery>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <outlet-map :outlet="{{$outlet}}"></outlet-map>
        </div>
      </div>
    </section>
  </div>
@stop

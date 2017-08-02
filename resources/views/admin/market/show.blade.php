@extends('layouts.master')
@section('content')
  <init-market :market="{{$market}}"></init-market>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>{{$market->name}}</h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/market')}}"><i class="fa fa-balance-scale"></i> Market</a></li>
        <li class="active">{{$market->name}}</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-6">
            <market-photo :market_id="{{$market->id}}"></market-photo>
        </div><!-- /.col -->
        <div class="col-md-6">
          <market-edit :area_data="{{$areas}}"></market-edit>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <market-map :market="{{$market}}"></market-map>
        </div>
      </div>
    </section>
  </div>
@stop

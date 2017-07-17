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
        <div class="col-md-5">
            <market-photo :market_id="{{$market->id}}"></market-photo>
        </div><!-- /.col -->

        <div class="col-md-7">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#detail" data-toggle="tab">Detail</a></li>
              <li><a href="#map" data-toggle="tab">Map</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="detail">
                <market-edit></market-edit>
              </div>
              <div class="tab-pane" id="map">
                <market-map :market="{{$market}}"></<market-map>>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
@stop

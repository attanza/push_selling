@extends('layouts.master')
@section('content')
  <stokiest-init :stokiest="{{$stokiest}}"></stokiest-init>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>{{$stokiest->name}}</h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/stokiest')}}"><i class="fa fa-building"></i> Stokiest</a></li>
        <li class="active">{{$stokiest->name}}</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-5">
            <stokiest-photo :stokiest_id="{{$stokiest->id}}"></stokiest-photo>
        </div><!-- /.col -->

        <div class="col-md-7">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#detail" data-toggle="tab">Detail</a></li>
              <li><a href="#map" data-toggle="tab">Map</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="detail">
                <stokiest-edit :area_data="{{$areas}}"></stokiest-edit>
              </div>
              <div class="tab-pane" id="map">
                {{-- <market-map :market="{{$stokiest}}"></<market-map> --}}
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

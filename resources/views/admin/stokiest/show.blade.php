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
        <div class="col-md-6">
            <stokiest-photo :stokiest_id="{{$stokiest->id}}"></stokiest-photo>
        </div><!-- /.col -->
        <div class="col-md-6">
          <stokiest-edit :area_data="{{$areas}}"></stokiest-edit>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <stokiest-map :stokiest="{{$stokiest}}"></stokiest-map>
        </div>
      </div>
    </section>
  </div>
@stop

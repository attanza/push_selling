@extends('layouts.master')
@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Create Outlet
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('stokiest.index')}}"><i class="fa fa-building-o"></i> Outlet</a></li>
        <li class="active"><a href="{{route('outlet.create')}}"><i class="fa fa-pencil"></i> Create</a></li>
      </ol>
    </section>
    <section class="content">
        <outlet-create :market_data="{{$markets}}"></outlet-create>
    </section>
  </div>
@endsection

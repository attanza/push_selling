@extends('layouts.master')
@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Create Stokiest
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('stokiest.index')}}"><i class="fa fa-building"></i> Stokiest</a></li>
        <li class="active"><a href="{{route('stokiest.create')}}"><i class="fa fa-pencil"></i> Create</a></li>
      </ol>
    </section>
    <section class="content">
        <stokiest-create :area_data="{{$areas}}"></stokiest-create>
    </section>
  </div>
@endsection

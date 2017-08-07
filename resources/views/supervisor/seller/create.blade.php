@extends('layouts.master')
@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Create Seller
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('seller.index')}}"><i class="fa fa-user"></i> Seller</a></li>
        <li class="active"><a href="{{route('seller.create')}}"><i class="fa fa-pencil"></i> Seller</a></li>
      </ol>
    </section>
    <section class="content">
        <seller-create></seller-create>
    </section>
  </div>
@endsection

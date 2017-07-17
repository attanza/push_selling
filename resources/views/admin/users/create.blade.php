@extends('layouts.master')
@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Create User
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('users.index')}}"><i class="fa fa-user"></i> Users</a></li>
        <li class="active"><a href="{{route('users.create')}}"><i class="fa fa-pencil"></i> Create</a></li>
      </ol>
    </section>
    <section class="content">
        <user-create :roles="{{$roles}}"></user-create>
    </section>
  </div>
@endsection

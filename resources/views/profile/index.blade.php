@extends('layouts.master')
@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User Profile
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Profile</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              @if(Auth::id() == $user->id)
                <avatar image_class="profile-user-img img-responsive img-circle"
                image_alt="{{$user->name}}"></avatar>
              @else
                <img class="profile-user-img img-responsive img-circle" src="{{$user->avatar}}" alt="{{$user->name}}">
              @endif
              <h3 class="profile-username text-center">{{$user->name}}</h3>

              <p class="text-muted text-center">{{$user->roles()->first()->name}}</p>

              {{-- <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Followers</b> <a class="pull-right">1,322</a>
                </li>
                <li class="list-group-item">
                  <b>Following</b> <a class="pull-right">543</a>
                </li>
                <li class="list-group-item">
                  <b>Friends</b> <a class="pull-right">13,287</a>
                </li>
              </ul> --}}

              {{-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> --}}
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Tasks</h3>
            </div>
            <div class="box-body">
              <strong><i class="fa fa-book margin-r-5"></i> Education</strong>

              <p class="text-muted">
                B.S. in Computer Science from the University of Tennessee at Knoxville
              </p>

              <hr>

              <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>

              <p class="text-muted">Malibu, California</p>

              <hr>

              <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>

              <p>
                <span class="label label-danger">UI Design</span>
                <span class="label label-success">Coding</span>
                <span class="label label-info">Javascript</span>
                <span class="label label-warning">PHP</span>
                <span class="label label-primary">Node.js</span>
              </p>

              <hr>

              <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>

              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab">Activity</a></li>
              <li><a href="#target" data-toggle="tab">Sell Target</a></li>
              <li><a href="#user_detail" data-toggle="tab">Setting</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                <activity :user_id="{{$user->id}}"><activity>
              </div>
              <div class="tab-pane" id="target">
                <h2>User Target</h2>
              </div>
              <div class="tab-pane" id="user_detail">
                @include('profile.user_detail')
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <div class="btn-group">
                <div class="btn-group">
                  <button class="btn btn-primary" data-toggle="collapse" data-target="#user_detail_data" aria-expanded="false" aria-controls="user_detail_data">
                    Edit Detail</button>
                  @if(Auth::id() == $user->id)
                  <button class="btn btn-primary" data-toggle="collapse" data-target="#upload_avatar" aria-expanded="false" aria-controls="upload_avatar">
                    Upload Avatar</button>
                  @endif
                  <button class="btn btn-primary" data-toggle="collapse" data-target="#change_password" aria-expanded="false" aria-controls="change_password">
                    Change Password</button>
                </div>
              </div>

              {{-- <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                  <i class="fa fa-times"></i></button>
              </div> --}}
            </div>
            <div class="box-body">
              <user-detail-edit :user="{{$user}}" :roles="{{$roles}}"></user-detail-edit>
              <upload-avatar :user="{{$user}}"></upload-avatar>

              <change-password :user_id="{{$user->id}}"></change-password>
            </div>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
@stop

@extends('layouts.master')
@section('content')
  <item-init :item="{{$item}}"></item-init>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>{{$item->name}}</h1>
      <ol class="breadcrumb">
        <li><a href="{{route('items.index')}}"><i class="fa fa-cubes"></i> Item</a></li>
        <li class="active">{{$item->name}}</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-12">
          @if (Auth::user()->roles()->first()->slug == 'admin')
            <item-edit></item-edit>
          @else
            @include('admin.item.detail')
          @endif
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="box box-danger box-solid">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-camera"></i> Item Gallery:</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-outline btn-sm"
                role="button" data-toggle="collapse" href="#add_item_photo" aria-expanded="false" aria-controls="add_item_photo">
                  <i class="fa fa-plus"></i> Add photo
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
              <add-item-photo :item_id="{{$item->id}}"></add-item-photo>
              <br>
              <item-gallery :item_id="{{$item->id}}"></item-gallery>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@stop

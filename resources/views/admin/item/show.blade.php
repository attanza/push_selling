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
          <item-edit></item-edit>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="box box-danger box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Item Gallery:</h3>
              <button class="btn btn-outline btn-sm pull-right"
              role="button" data-toggle="collapse" href="#add_item_photo" aria-expanded="false" aria-controls="add_item_photo">
                <i class="fa fa-plus"></i> Add photo
              </button>
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

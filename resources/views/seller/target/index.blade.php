@extends('layouts.master')
@section('title')
  Seller Target
@endsection
@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Your Target
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="{{route('target.index')}}"><i class="fa fa-bullseye"></i> Your target</a></li>
      </ol>
    </section>
    <section class="content">
      @if (count($targets) > 0)
        @foreach ($targets->chunk(2) as $chunk)
            <div class="row">
              @foreach ($chunk as $target)
                <div class="col-md-6">
                  <div class="box box-danger box-solid">
                    <div class="box-header with-border">
                      <h3 class="box-title">{{$target->name}}</h3>
                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="box-body">
                      <ul class="list-group">
                        <li class="list-group-item">Item <span class="pull-right">{{$target->item->name}}</span></li>
                      </ul>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
        @endforeach
      @endif
    </section>
  </div>
@endsection

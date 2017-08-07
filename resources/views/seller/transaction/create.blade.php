@extends('layouts.master')
@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Create Transaction
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('transaction.index')}}"><i class="fa fa-gg"></i> Transaction</a></li>
        <li class="active"><a href="javascript:void(0)"><i class="fa fa-pencil"></i> Create</a></li>
      </ol>
    </section>
    <section class="content">
        <transaction-form :item_data="{{$items}}" :outlet_data="{{$outlets}}"></transaction-form>
    </section>
  </div>
@endsection

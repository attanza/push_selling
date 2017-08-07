@extends('layouts.master')
@section('content')
  <transaction-init :transaction="{{$transaction}}"></transaction-init>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>Transaction Code: {{$transaction->code}}</h1>
      <ol class="breadcrumb">
        <li><a href="{{route('transaction.index')}}"><i class="fa fa-gg"></i> Transaction</a></li>
        <li class="active"><a href="javascrip:void(0)">{{$transaction->code}}</a></li>
      </ol>
    </section>
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> Push Selling System.
            <small class="pull-right">Date: {{$transaction->verified_at ? $transaction->verified_at->format('d M Y') : ''}}</small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          Stokiest
          <address>
            <strong>{{$stokiest->name}}</strong><br>
            {{wordwrap($stokiest->address)}}<br>
            Phone: {{$stokiest->phone1}}<br>
            Email: {{$stokiest->email}}
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          Outlet
          <address>
            <strong>{{$transaction->outlet->name}}</strong><br>
            {{wordwrap($transaction->outlet->address)}}<br>
            Phone: {{$transaction->outlet->phone1}}<br>
            Email: {{$transaction->outlet->email}}
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          Market
          <address>
            <strong>{{$market->name}}</strong><br>
            {{wordwrap($market->address)}}<br>
            Area: <strong>{{$market->area->name}}</strong><br>
          </address>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>Qty</th>
              <th>Product</th>
              <th>Code</th>
              <th>Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td>{{$transaction->qty}}</td>
              <td>{{$transaction->item->name}}</td>
              <td>{{$transaction->item->code}}</td>
              <td>{{wordwrap($transaction->description)}}</td>
            </tr>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
            <div class="btn-group pull-right" role="group" aria-label="...">
            <button class="btn btn-default" data-toggle="modal" data-target="#transaction_edit">
              <i class="fa fa-edit"></i> Edit
            </button>
            {{-- <button class="btn btn-default"><i class="fa fa-edit"></i> Download</button> --}}
          </div>
        </div>
      </div>
      <div class="row no-print">
        <div class="col-xs-12">
          <transaction-edit :transaction_data="{{$transaction}}" :item_data="{{$item_data}}" :outlet_data="{{$outlet_data}}"></transaction-edit>
        </div>
      </div>
    </section>

  </div>
@stop

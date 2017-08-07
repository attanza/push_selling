@extends('emails.mail_master_2')
@section('content')
  <div class="container">
    <div class="columns">
      <div class="column">
        <h1 class="title">
          Order #{{$transaction->code}}
        </h1>
      </div>
      <div class="column">
        <p class="subtitle is-pulled-right">
          Date: <strong>{{$today->format('d M Y')}}</strong>
        </p>
      </div>
    </div>
    <hr>
    <div class="columns">
      <div class="column">
        To
        <address>
          <strong>{{$stokiest->name}}</strong><br>
          {{wordwrap($stokiest->address)}}<br>
          Phone: {{$stokiest->phone1}}<br>
          Email: {{$stokiest->email}}
        </address>
      </div>
      <div class="column">
        Outlet
        <address>
          <strong>{{$transaction->outlet->name}}</strong><br>
          {{wordwrap($transaction->outlet->address)}}<br>
          Phone: {{$transaction->outlet->phone1}}<br>
          Email: {{$transaction->outlet->email}}
        </address>
      </div>
    </div>
    <br>
    <table class="table is-striped">
      <tr>
        <td><strong>Code</strong></td>
        <td>{{$transaction->item->code}}</td>
      </tr>
      <tr>
        <td><strong>Item</strong></td>
        <td>{{$transaction->item->name}}</td>
      </tr>
      <tr>
        <td><strong>Qty</strong></td>
        <td>{{$transaction->qty}}</td>
      </tr>
      <tr>
        <td><strong>Measurement</strong></td>
        <td>{{$transaction->item->measurement}}</td>
      </tr>
      <tr>
        <td><strong>Description</strong></td>
        <td>{{$transaction->description}}</td>
      </tr>
    </table>
    <p>
      For further info, please contact two one of these contacts:
    </p>
    <br>
    <div class="columns">
      <div class="column">
        <address>
          <strong>{{$transaction->seller->name}}</strong><br>
          Phone: {{$transaction->seller->phone1}}<br>
          Email: {{$transaction->seller->email}}
        </address>
      </div>
      <div class="column">
        <address>
          <strong>{{$transaction->supervisor->name}}</strong><br>
          Phone: {{$transaction->supervisor->phone1}}<br>
          Email: {{$transaction->supervisor->email}}
        </address>
      </div>
    </div>
    <p>
      Thank you
    </p>
  </div>
@endsection

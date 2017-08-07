@extends('emails.mail_master')
@section('content')
  <p>
    Dear {{$transaction->seller->name}},
  </p><br>
  <p>
    Transaction with code: <strong>{{$transaction->code}}</strong> has been verified by <strong>{{$transaction->supervisor->name}}</strong>
  </p>
  <p>
    See following detail for your reference:
  </p>
  <table style="width: 100%">
    <tr>
      <th width="20%" align="left">Transaction Code</th>
      <td width="80%">{{$transaction->code}}</td>
    </tr>
    <tr>
      <th width="20%" align="left">Product</th>
      <td width="80%">{{$transaction->item ? $transaction->item->name : '' }}</td>
    </tr>
    <tr>
      <th width="20%" align="left">Outlet</th>
      <td width="80%">{{$transaction->outlet ? $transaction->outlet->name : '' }}</td>
    </tr>
    <tr>
      <th width="20%" align="left">Quantity</th>
      <td width="80%">{{$transaction->qty}}</td>
    </tr>
    <tr>
      <th width="20%" align="left">Measurement</th>
      <td width="80%">{{$transaction->item ? $transaction->item->measurement : '' }}</td>
    </tr>
    <tr>
      <th width="20%" align="left">Submited at</th>
      <td width="80%">{{$transaction->created_at->format('d M Y')}}</td>
    </tr>
  </table>
  <br>
  <p>
    Please help to follow up this Transaction Request.
  </p>
@endsection

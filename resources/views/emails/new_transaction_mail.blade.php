@extends('emails.mail_master_2')
@section('content')
  <div class="container">
    <p>
      Dear Supervisors,
    </p><br>
    <p>
      One transaction has been submited by <strong>{{$transaction->seller->name}}</strong> with following detail for you to verify:
    </p>
    <table class="table">
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
    <p>
      Please log to <a href="{{route('transaction.index')}}">our system</a> to verify this transaction.
    </p>
  </div>
@endsection

@extends('emails.mail_master_2')
@section('content')
  <div class="container">
    @if ($type == 'register')
      <p>
        Dear Supervisors,
      </p><br>
      <p>
        An Outlet has been registered by <strong>{{$outlet->detail->seller->name}}</strong> for your verification.
      </p>
    @elseif ($type = 'verify')
      <p>
        Dear {{$outlet->detail->seller->name}},
      </p><br>
      <p>
        The Outlet <strong>{{$outlet->name}}</strong> that you have registered, has been verified by <strong>{{$outlet->detail->supervisor->name}}</strong>.
      </p>
    @endif
    <br>
    <p>
      Here are the Outlet Detail for your info:
    </p>
    <table class="table">
      <tr>
        <th width="20%" align="left">Code:</th>
        <td width="80%" align="left">{{$outlet->code}}</td>
      </tr>
      <tr>
        <th width="20%" align="left">Outlet Name:</th>
        <td width="80%" align="left">{{$outlet->name}}</td>
      </tr>
      <tr>
        <th width="20%" align="left">Owner Name:</th>
        <td width="80%" align="left">{{$outlet->owner}}</td>
      </tr>
      <tr>
        <th width="20%" align="left">PIC Name:</th>
        <td width="80%" align="left">{{$outlet->pic}}</td>
      </tr>
      <tr>
        <th width="20%" align="left">Phone Number:</th>
        <td width="80%" align="left">{{$outlet->phone1}}</td>
      </tr>
      <tr>
        <th width="20%" align="left">Email Address:</th>
        <td width="80%" align="left">{{$outlet->email}}</td>
      </tr>
      <tr>
        <th width="20%" align="left">Address:</th>
        <td width="80%" align="left">{{$outlet->address}}</td>
      </tr>
    </table>
  </div>
@endsection

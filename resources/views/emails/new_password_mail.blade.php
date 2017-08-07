@extends('emails.mail_master')
@section('content')
  <p>
    Dear {{$user->name}},
  </p><br>
  <p>
    You have been registered in our system with following credential:
  </p>
  <table style="width: 100%;">
    <tr>
      <th width="20%" align="left">Your Email</th>
      <td width="80%">{{$user->email}}</td>
    </tr>
    <tr>
      <th width="20%" align="left">Your Password</th>
      <td width="80%">{{$password}}</td>
    </tr>
  </table>
  <br>
  <p>
    Please use this credential to log in in our system. And please consider to change your password immediately after your first login.
  </p>
  <p>
    Click on following link to direct to our system: <a href="{{url('/')}}">{{url('/')}}</a>
  </p>
@endsection

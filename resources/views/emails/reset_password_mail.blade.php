@extends('emails.mail_master')
@section('content')
  <p>
    Dear {{$user->name}},
  </p><br>
  <p>
    Your password has been reset with following credential:
  </p>
  <table style="width=100%">
    <tr>
      <td width="40%">Your Email</td>
      <td width="60%">{{$user->email}}</td>
    </tr>
    <tr>
      <td>Your Password</td>
      <td>{{$password}}</td>
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

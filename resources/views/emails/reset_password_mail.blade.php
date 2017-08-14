@extends('emails.mail_master_2')
@section('content')
  <div class="container">
    <p>
      Dear {{$user->name}},
    </p><br>
    <p>
      Your password has been reset with following credential:
    </p>
    <table class="table">
      <tr>
        <td width="40%">Your Email</td>
        <td width="60%">{{$user->email}}</td>
      </tr>
      <tr>
        <td>Your Password</td>
        <td>{{$password}}</td>
      </tr>
    </table>
    <p>
      Please use this credential to log in in our system. And please consider to change your password immediately after your first login.
    </p>
    <p>
      Click on following link to redirect to our system: <a href="{{url('/')}}">{{url('/')}}</a>
    </p>
  </div>
@endsection

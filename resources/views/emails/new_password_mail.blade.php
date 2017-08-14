@extends('emails.mail_master_2')
@section('content')

  <div class="container">
    <p>
      Dear {{$user->name}},
    </p><br>
    <p>
      You have been registered in our system with following credential:
    </p>
    <table class="table">
      <tr>
        <th>Your Email</th>
        <td>{{$user->email}}</td>
      </tr>
      <tr>
        <th>Your Password</th>
        <td>{{$password}}</td>
      </tr>
    </table>
    <p>
      Please use this credential to log in in our system. And please consider to change your password immediately after your first login.
    </p>
    <p>
      Click on following link to direct to our system: <a href="{{url('/')}}">{{url('/')}}</a>
    </p>
  </div>
@endsection

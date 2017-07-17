<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Users</title>
  </head>
  <body>
<h3>Users</h3>
<table>
  <thead>
    <tr>
      <th>Username</th>
      <th>Fullname</th>
      <th>Email</th>
      <th>Status</th>
      <th>Level</th>
      <th>Last Login</th>
      <th>Registered</th>
  </tr>
  </thead>
  <tbody>
    @if(count($users)>0)
      @foreach($users as $user)
        <tr>
          <td>{{$user->username}}</td>
          <td>{{$user->name}}</td>
          <td>{{$user->email}}</td>
          <td>
              @if($user->is_active == 1)
                Active
              @else
                Disabled
              @endif
          </td>
          <td>{{$user->roles()->first()->name}}</td>
          <td>
            @if($user->last_login != null)
              {{$user->last_login}}
            @endif
          </td>
          <td>{{$user->created_at->format('d M Y')}}</td>
        </tr>
      @endforeach
    @endif
  </tbody>
</table>
  </body>
</html>

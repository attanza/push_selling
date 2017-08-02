<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Outlet</title>
  </head>
  <body>
<h3>Outlet</h3>
<table>
  <thead>
    <tr>
      <th>Code</th>
      <th>Name</th>
      <th>Market</th>
      <th>Owner</th>
      <th>PIC</th>
      <th>Phone Number</th>
      <th>Other Phone Number</th>
      <th>Email Address</th>
      <th>Address</th>
      <th>Latitude</th>
      <th>Longitude</th>
      <th>Registered</th>
  </tr>
  </thead>
  <tbody>
    @if(count($outlets)>0)
      @foreach($outlets as $outlet)
        <tr>
          <td>{{$outlet->code}}</td>
          <td>{{$outlet->name}}</td>
          <td>
            {{$outlet->market ? $outlet->market->name : ''}}
          </td>
          <td>{{$outlet->owner}}</td>
          <td>{{$outlet->pic}}</td>
          <td>{{$outlet->phone1}}</td>
          <td>{{$outlet->phone2}}</td>
          <td>{{$outlet->email}}</td>
          <td>{{$outlet->address}}</td>
          <td>{{$outlet->lat}}</td>
          <td>{{$outlet->lng}}</td>
          <td>{{$outlet->created_at->format('d M Y')}}</td>
        </tr>
      @endforeach
    @endif
  </tbody>
</table>
  </body>
</html>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Market</title>
  </head>
  <body>
<h3>Market</h3>
<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>Area</th>
      <th>Address</th>
      <th>Latitude</th>
      <th>Longitude</th>
      <th>Registered</th>
  </tr>
  </thead>
  <tbody>
    @if(count($markets)>0)
      @foreach($markets as $market)
        <tr>
          <td>{{$market->name}}</td>
          <td>{{$market->area ? $market->area->name : ''}}</td>
          <td>{{$market->address}}</td>
          <td>{{$market->lat}}</td>
          <td>{{$market->lng}}</td>
          <td>{{$market->created_at->format('d M Y')}}</td>
        </tr>
      @endforeach
    @endif
  </tbody>
</table>
  </body>
</html>

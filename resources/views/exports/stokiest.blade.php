<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Stokiest</title>
  </head>
  <body>
<h3>Stokiest</h3>
<table>
  <thead>
    <tr>
      <th>Code</th>
      <th>Name</th>
      <th>Areas</th>
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
    @if(count($stokiests)>0)
      @foreach($stokiests as $stokiest)
        <tr>
          <td>{{$stokiest->code}}</td>
          <td>{{$stokiest->name}}</td>
          <td>
            {{$stokiest->area ? $stokiest->area->name : ''}}
          </td>
          <td>{{$stokiest->owner}}</td>
          <td>{{$stokiest->pic}}</td>
          <td>{{$stokiest->phone1}}</td>
          <td>{{$stokiest->phone2}}</td>
          <td>{{$stokiest->email}}</td>
          <td>{{$stokiest->address}}</td>
          <td>{{$stokiest->lat}}</td>
          <td>{{$stokiest->lng}}</td>
          <td>{{$stokiest->created_at->format('d M Y')}}</td>
        </tr>
      @endforeach
    @endif
  </tbody>
</table>
  </body>
</html>

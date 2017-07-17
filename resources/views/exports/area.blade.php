<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Areas</title>
  </head>
  <body>
<h3>Areas</h3>
<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>Description</th>
      <th>Registered</th>
  </tr>
  </thead>
  <tbody>
    @if(count($areas)>0)
      @foreach($areas as $area)
        <tr>
          <td>{{$area->name}}</td>
          <td>{{$area->description}}</td>
          <td>{{$area->created_at->format('d M Y')}}</td>
        </tr>
      @endforeach
    @endif
  </tbody>
</table>
  </body>
</html>

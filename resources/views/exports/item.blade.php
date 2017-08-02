<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Items</title>
  </head>
  <body>
<h3>Items</h3>
<table>
  <thead>
    <tr>
      <th>Code</th>
      <th>Name</th>
      <th>Measurement</th>
      <th>Price</th>
      <th>Target By</th>
      <th>Target Count</th>
      <th>Start Date</th>
      <th>End Date</th>
      <th>Registered</th>
  </tr>
  </thead>
  <tbody>
    @if(count($items)>0)
      @foreach($items as $item)
        <tr>
          <td>{{$item->code}}</td>
          <td>{{$item->name}}</td>
          <td>{{$item->measurement}}</td>
          <td>{{number_format($item->price)}}</td>
          <td>
            @if ($item->target_by == 1)
              Quantity
            @elseif ($item->target_by == 2)
              Outlet
            @endif
          </td>
          <td>{{number_format($item->target_count)}}</td>
          <td>{{$item->start_date->format('d M Y')}}</td>
          <td>{{$item->end_date->format('d M Y')}}</td>
          <td>{{$item->created_at->format('d M Y')}}</td>
        </tr>
      @endforeach
    @endif
  </tbody>
</table>
  </body>
</html>

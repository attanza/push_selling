<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Seller Targets</title>
  </head>
  <body>
<h3>Seller Targets</h3>
<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>Item</th>
      <th>Seller</th>
      <th>Target Count</th>
      <th>Measurement</th>
      <th>Start Date</th>
      <th>End Date</th>
      <th>Creator</th>
      <th>Registered</th>
  </tr>
  </thead>
  <tbody>
    @if(count($seller_targets)>0)
      @foreach($seller_targets as $seller_target)
        <tr>
          <td>{{$seller_target->name}}</td>
          <td>
            @if ($seller_target->item)
              {{$seller_target->item->name}}
            @endif
          </td>
          <td>
            @if ($seller_target->seller)
              {{$seller_target->seller->name}}
            @endif
          </td>
          <td>{{number_format($seller_target->target_count)}}</td>
          <td>
            @if ($seller_target->item)
              {{$seller_target->item->measurement}}
            @endif
          </td>
          <td>{{$seller_target->start_date->format('d M Y')}}</td>
          <td>{{$seller_target->end_date->format('d M Y')}}</td>
          <td>
            @if ($seller_target->creator)
              {{$seller_target->creator->name}}
            @endif
          </td>
          <td>{{$seller_target->created_at->format('d M Y')}}</td>
        </tr>
      @endforeach
    @endif
  </tbody>
</table>
  </body>
</html>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Transactions</title>
  </head>
  <body>
<h3>Transactions</h3>
<table>
  <thead>
    <tr>
      <th>Code</th>
      <th>Item</th>
      <th>Outlet</th>
      <th>Quantity</th>
      <th>Measurement</th>
      <th>Created by</th>
      <th>Status</th>
      <th>Verified by</th>
      <th>Description</th>
      <th>Created_at</th>
  </tr>
  </thead>
  <tbody>
    @if(count($transactions)>0)
      @foreach($transactions as $t)
        <tr>
          <td>{{$t->code}}</td>
          <td>
            {{$t->item ? $t->item->name : ''}}
          </td>
          <td>
            {{$t->outlet ? $t->outlet->name : ''}}
          </td>
          <td>{{$t->qty}}</td>
          <td>
            {{$t->item ? $t->item->measurement : ''}}
          </td>
          <td>
            {{$t->seller ? $t->seller->name : ''}}
          </td>
          <td>
            {{$t->verified ? 'Verified' : 'Not Verified'}}
          </td>
          <td>
            {{$t->supervisor ? $t->supervisor->name : ''}}
          </td>
          <td>{{$t->description}}</td>
          <td>{{$t->created_at->format('d M Y')}}</td>
        </tr>
      @endforeach
    @endif
  </tbody>
</table>
  </body>
</html>

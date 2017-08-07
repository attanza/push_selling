<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Transaction</title>
    <style>
      body{
        font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
        font-size: 14px;
        line-height: 1.42857143;
        color: #333;
      }
      .container{
        margin: 0 auto;
        padding: 2% 10%;
        background-color: #fff;
      }
      .addres-wrapper{
        padding: 10px;
        margin: 5px auto;
        background-color: rgb(246, 246, 246);
      }
      .product-wrapper{
        padding: 10px;
        margin: 15px auto;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <table style="width: 100%">
        <td width="33.30%">
          <h1>Push Selling System</h1>
        </td>
        <td width="33.3%" align="center">
          <h3>Transaction Code: {{$transaction->code}}</h3>
        </td>
        <td width="33.3%" align="right">Date: {{$today->format('d M Y')}}</td>
      </table>
      <hr style="margin-top: 0px;">
      <div class="addres-wrapper">
        <table style="width: 100%">
          <td width="33.3%">
            Stokiest
            <address>
              <strong>{{$stokiest->name}}</strong><br>
              {{wordwrap($stokiest->address)}}<br>
              Phone: {{$stokiest->phone1}}<br>
              Email: {{$stokiest->email}}
            </address>
          </td>
          <td width="33.3%">
            Outlet
            <address>
              <strong>{{$transaction->outlet->name}}</strong><br>
              {{wordwrap($transaction->outlet->address)}}<br>
              Phone: {{$transaction->outlet->phone1}}<br>
              Email: {{$transaction->outlet->email}}
            </address>
          </td>
          <td width="33.3%">
            Market
            <address>
              <strong>{{$market->name}}</strong><br>
              {{wordwrap($market->address)}}<br>
              Area: <strong>{{$market->area->name}}</strong><br>
            </address>
          </td>
        </table>
      </div>
      <hr>
      <div class="product-wrapper">
        <table style="width: 100%">
          <thead>
            <tr>
              <th align="left">Qty</th>
              <th align="left">Product</th>
              <th align="left">Code</th>
              <th align="left">Description</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{$transaction->qty}}</td>
              <td>{{$transaction->item->name}}</td>
              <td>{{$transaction->item->code}}</td>
              <td>{{$transaction->description}}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </body>
</html>

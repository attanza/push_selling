@extends('emails.mail_master')
@section('content')
  <p>
    Dear {{$seller_target->seller->name}},
  </p><br>
  <p>
    You have been assigned for Sell Target with following detail:
  </p>
  <table style="width: 100%">
    <tr>
      <td width="30%">Name</td>
      <td width="70%">{{$seller_target->name}}</td>
    </tr>
    <tr>
      <td>Item</td>
      <td>
        @if ($seller_target->item)
          {{$seller_target->item->name}}
        @endif
      </td>
    </tr>
    <tr>
      <td>Target Count</td>
      <td>{{number_format($seller_target->target_count)}}</td>
    </tr>
    <tr>
      <td>Measurement</td>
      <td>
        @if ($seller_target->item)
          {{$seller_target->item->measurement}}
        @endif
      </td>
    </tr>
    <tr>
      <td>Start Date</td>
      <td>{{$seller_target->start_date->format('d M Y')}}</td>
    </tr>
    <tr>
      <td>End Date</td>
      <td>{{$seller_target->end_date->format('d M Y')}}</td>
    </tr>
    <tr>
      <td>Creator</td>
      <td>
        @if ($seller_target->creator)
          {{$seller_target->creator->name}}
        @endif
      </td>
    </tr>
    <tr>
      <td>Registered</td>
      <td>{{$seller_target->created_at->format('d M Y')}}</td>
    </tr>
  </table>
  <br>
  <p>
    Please complete this assignment accordingly.
  </p>
  <p>
  </p>
@endsection

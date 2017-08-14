@extends('emails.mail_master_2')
@section('content')
  <div class="container">
    <p>
      Dear {{$seller_target->seller->name}},
    </p><br>
    <p>
      You have been assigned for a new Selling target with following detail:
    </p>
    <table class="table">
      <tr>
        <td>Name</td>
        <td>{{$seller_target->name}}</td>
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
    <p>
      Please complete this assignment accordingly.
    </p>
  </div>
@endsection

<div class="row">
  <div class="col-sm-6">
    <div class="table-responsive">
      <table class="table table-bordered" style="width: 100%">
        <tr>
          <th>Name</th>
          <td>{{$user->name}}</td>
        </tr>
        <tr>
          <th>Email Address</th>
          <td>{{$user->email}}</td>
        </tr>
        <tr>
          <th>Register at</th>
          <td>{{$user->created_at->format('d M Y')}}</td>
        </tr>
        <tr>
          <th>Last Login</th>
          <td>{{$user->last_login}}</td>
        </tr>
        <tr>
          <th>Status</th>
          <td>
            @if($user->is_active)
              Active
            @else
              Not active
            @endif
          </td>
        </tr>
      </table>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="table-responsive">
      <table class="table table-bordered" style="width: 100%">
        <tr>
          <th>Citizen ID</th>
          <td>{{$user->detail->ktp}}</td>
        </tr>
        <tr>
          <th>Gender</th>
          <td>{{$user->detail->gender}}</td>
        </tr>
        <tr>
          <th>Date of Birth</th>
          <td>@if($user->detail->dob != null){{$user->detail->dob->format('d M Y')}}@endif</td>
        </tr>
        <tr>
          <th>Phone Number</th>
          <td>{{$user->detail->phone1}}</td>
        </tr>
        <tr>
          <th>Other Number</th>
          <td>{{$user->detail->phone2}}</td>
        </tr>
      </table>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <table class="table table-bordered" style="width: 100%">
      <tr>
        <th width="20%">Address</th>
        <td>{{$user->detail->address}}</td>
      </tr>
    </table>
  </div>
</div>

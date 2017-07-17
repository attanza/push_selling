<li class="dropdown user user-menu">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <avatar image_class="user-image"
    image_alt="{{Auth::user()->name}}"></avatar>
    {{-- <img src="{{Auth::user()->avatar}}" alt="{{Auth::user()->name}}" class="user-image"> --}}
    <span class="hidden-xs">{{Auth::user()->name}}</span>
  </a>
  <ul class="dropdown-menu">
    <!-- User image -->
    <li class="user-header">
      <avatar image_class="img-circle"
      image_alt="{{Auth::user()->name}}"></avatar>
      {{-- <img src="{{Auth::user()->avatar}}" alt="{{Auth::user()->name}}" class="img-circle"> --}}

      <p>
        {{Auth::user()->name}}
        <small>Register at {{Auth::user()->created_at->format('d M Y')}}</small>
      </p>
    </li>
    <!-- Menu Body -->
    {{-- <li class="user-body">
      <div class="row">
        <div class="col-xs-4 text-center">
          <a href="#">Followers</a>
        </div>
        <div class="col-xs-4 text-center">
          <a href="#">Sales</a>
        </div>
        <div class="col-xs-4 text-center">
          <a href="#">Friends</a>
        </div>
      </div>
      <!-- /.row -->
    </li> --}}
    <!-- Menu Footer-->
    <li class="user-footer">
      <div class="pull-left">
        <a href="{{route('profile.index',['username'=>Auth::user()->username])}}" class="btn btn-default btn-flat">Profile</a>
      </div>
      <div class="pull-right">
        {{-- <a href="#" class="btn btn-default btn-flat">Sign out</a> --}}
        <a href="{{ route('logout') }}"
            onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">
            Logout
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
      </div>
    </li>
  </ul>
</li>

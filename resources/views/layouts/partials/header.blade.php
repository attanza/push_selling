<header class="main-header">
  <a href="{{url('/')}}" class="logo">
    <span class="logo-mini">PSS</span>
    <span class="logo-lg">Push Selling System</span>
  </a>
  <nav class="navbar navbar-static-top">
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </a>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        {{-- @include('layouts.partials.messages_menu') --}}
        {{-- @include('layouts.partials.notifications_menu') --}}
        {{-- @include('layouts.partials.tasks_menu') --}}
        @include('layouts.partials.user_menu')
        {{-- @include('layouts.partials.control_sidebar_menu') --}}
      </ul>
    </div>
  </nav>
  @if(Auth::check())
    <init :user="{{Auth::user()}}"></init>
  @endif

</header>

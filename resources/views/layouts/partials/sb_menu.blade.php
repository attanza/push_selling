<ul class="sidebar-menu">
  <li class="header">
    {{Auth::user()->roles->first()->name}} Menu
  </li>
  <li @if(Request::is('dashboard') || Request::is('/')) class="active" @endif>
    <a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
  </li>
  <?php $role = Auth::user()->roles->first()->slug; ?>
  @if($role == 'admin')
    <li @if(Request::is('area*')) class="active" @endif>
      <a href="{{route('area.index')}}"><i class="fa fa-map-o"></i> <span>Area</span></a>
    </li>
    <li @if(Request::is('items*')) class="active" @endif>
      <a href="{{route('items.index')}}"><i class="fa fa-cubes"></i> <span>Items</span></a>
    </li>
    <li @if(Request::is('market*')) class="active" @endif>
      <a href="{{route('market.index')}}"><i class="fa fa-balance-scale"></i> <span>Market</span></a>
    </li>
    <li @if(Request::is('stokiest*')) class="active" @endif>
      <a href="{{route('stokiest.index')}}"><i class="fa fa-building"></i> <span>Stokiest</span></a>
    </li>
    <li @if(Request::is('users*')) class="active" @endif>
      <a href="{{route('users.index')}}"><i class="fa fa-user"></i> <span>Users</span></a>
    </li>
  @elseif ($role == 'supervisor')
    <li @if(Request::is('seller') || Request::is('seller/*')) class="active" @endif>
      <a href="{{route('seller.index')}}"><i class="fa fa-user"></i> <span>Seller</span></a>
    </li>
    <li @if(Request::is('items*')) class="active" @endif>
      <a href="{{route('items.index')}}"><i class="fa fa-cubes"></i> <span>Items</span></a>
    </li>
    <li @if(Request::is('outlet*')) class="active" @endif>
      <a href="{{route('outlet.index')}}"><i class="fa fa-building-o"></i> <span>Outlet</span></a>
    </li>
    <li @if(Request::is('seller-target') || Request::is('seller-target/*')) class="active" @endif>
      <a href="{{route('seller-target.index')}}"><i class="fa fa-bullseye"></i> <span>Seller Target</span></a>
    </li>
    <li @if(Request::is('transaction*')) class="active" @endif>
      <a href="{{route('transaction.index')}}"><i class="fa fa-gg"></i> <span>Transaction</span></a>
    </li>
  @elseif ($role == 'seller')
    <li @if(Request::is('outlet*')) class="active" @endif>
      <a href="{{route('outlet.index')}}"><i class="fa fa-building-o"></i> <span>Outlet</span></a>
    </li>
    <li @if(Request::is('transaction*')) class="active" @endif>
      <a href="{{route('transaction.index')}}"><i class="fa fa-gg"></i> <span>Transaction</span></a>
    </li>
    <li @if(Request::is('target*')) class="active" @endif>
      <a href="{{route('target.index')}}"><i class="fa fa-bullseye"></i> <span>Target</span></a>
    </li>
  @endif
  {{--
  <li class="treeview">
    <a href="#">
      <i class="fa fa-files-o"></i>
      <span>Layout Options</span>
      <span class="pull-right-container">
        <span class="label label-primary pull-right">4</span>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="../layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
      <li><a href="../layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
      <li><a href="../layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
      <li><a href="../layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
    </ul>
  </li>
  <li>
    <a href="../widgets.html">
      <i class="fa fa-th"></i> <span>Widgets</span>
      <span class="pull-right-container">
        <small class="label pull-right bg-green">Hot</small>
      </span>
    </a>
  </li>
  <li class="treeview">
    <a href="#">
      <i class="fa fa-pie-chart"></i>
      <span>Charts</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="../charts/chartjs.html"><i class="fa fa-circle-o"></i> ChartJS</a></li>
      <li><a href="../charts/morris.html"><i class="fa fa-circle-o"></i> Morris</a></li>
      <li><a href="../charts/flot.html"><i class="fa fa-circle-o"></i> Flot</a></li>
      <li><a href="../charts/inline.html"><i class="fa fa-circle-o"></i> Inline charts</a></li>
    </ul>
  </li>
  <li class="treeview">
    <a href="#">
      <i class="fa fa-laptop"></i>
      <span>UI Elements</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="../UI/general.html"><i class="fa fa-circle-o"></i> General</a></li>
      <li><a href="../UI/icons.html"><i class="fa fa-circle-o"></i> Icons</a></li>
      <li><a href="../UI/buttons.html"><i class="fa fa-circle-o"></i> Buttons</a></li>
      <li><a href="../UI/sliders.html"><i class="fa fa-circle-o"></i> Sliders</a></li>
      <li><a href="../UI/timeline.html"><i class="fa fa-circle-o"></i> Timeline</a></li>
      <li><a href="../UI/modals.html"><i class="fa fa-circle-o"></i> Modals</a></li>
    </ul>
  </li>
  <li class="treeview">
    <a href="#">
      <i class="fa fa-edit"></i> <span>Forms</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="../forms/general.html"><i class="fa fa-circle-o"></i> General Elements</a></li>
      <li><a href="../forms/advanced.html"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
      <li><a href="../forms/editors.html"><i class="fa fa-circle-o"></i> Editors</a></li>
    </ul>
  </li>
  <li class="treeview">
    <a href="#">
      <i class="fa fa-table"></i> <span>Tables</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="../tables/simple.html"><i class="fa fa-circle-o"></i> Simple tables</a></li>
      <li><a href="../tables/data.html"><i class="fa fa-circle-o"></i> Data tables</a></li>
    </ul>
  </li>
  <li>
    <a href="../calendar.html">
      <i class="fa fa-calendar"></i> <span>Calendar</span>
      <span class="pull-right-container">
        <small class="label pull-right bg-red">3</small>
        <small class="label pull-right bg-blue">17</small>
      </span>
    </a>
  </li>
  <li>
    <a href="../mailbox/mailbox.html">
      <i class="fa fa-envelope"></i> <span>Mailbox</span>
      <span class="pull-right-container">
        <small class="label pull-right bg-yellow">12</small>
        <small class="label pull-right bg-green">16</small>
        <small class="label pull-right bg-red">5</small>
      </span>
    </a>
  </li>
  <li class="treeview active">
    <a href="#">
      <i class="fa fa-folder"></i> <span>Examples</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="invoice.html"><i class="fa fa-circle-o"></i> Invoice</a></li>
      <li><a href="profile.html"><i class="fa fa-circle-o"></i> Profile</a></li>
      <li><a href="login.html"><i class="fa fa-circle-o"></i> Login</a></li>
      <li><a href="register.html"><i class="fa fa-circle-o"></i> Register</a></li>
      <li><a href="lockscreen.html"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
      <li><a href="404.html"><i class="fa fa-circle-o"></i> 404 Error</a></li>
      <li><a href="500.html"><i class="fa fa-circle-o"></i> 500 Error</a></li>
      <li class="active"><a href="blank.html"><i class="fa fa-circle-o"></i> Blank Page</a></li>
      <li><a href="pace.html"><i class="fa fa-circle-o"></i> Pace Page</a></li>
    </ul>
  </li>
  <li class="treeview">
    <a href="#">
      <i class="fa fa-share"></i> <span>Multilevel</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
      <li>
        <a href="#"><i class="fa fa-circle-o"></i> Level One
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
          <li>
            <a href="#"><i class="fa fa-circle-o"></i> Level Two
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
              <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
            </ul>
          </li>
        </ul>
      </li>
      <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
    </ul>
  </li>
  <li><a href="../../documentation/index.html"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
  <li class="header">LABELS</li>
  <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
  <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
  <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li> --}}
</ul>

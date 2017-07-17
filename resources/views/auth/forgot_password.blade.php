<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{config('app.name')}} @yield('title')</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{mix('css/all.css')}}">
  <link rel="stylesheet" href="{{asset('css/customes/login.css')}}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style>
  .nav-title{
    color: #fff;
    font-size: 2em;
    font-weight: bold;
    text-align: center;
  }
  </style>
</head>
<body>
<nav style="background-color: #dd4b39; min-height:40px; padding:8px; ">
  <div class="row">
    <div class="col-md-4 col-md-offset-4">
      <div class="nav-title">Push Selling System</div>
    </div>
  </div>
</nav>
<div class="container">
  <div class="row">
    <div class="col-md-4 col-md-offset-4">
      <div class="panel panel-danger" style="margin-top:20%;">
        <div class="panel-heading">
          <h3 class="panel-title">Log in</h3>
        </div>
        <div class="panel-body">

          <form action="{{ route('forgot-password') }}" method="POST" role="form" class="form-horizontal">
            {{csrf_field()}}
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <div class="col-sm-12">
                  <div class="input-group">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="Email Address" aria-describedby="addon_email" autofocus>
                    <span class="input-group-addon" id="addon_email"><i class="fa fa-envelope"></i></span>
                  </div>
                  @if ($errors->has('email'))
                      <span class="help-block">
                          <strong>{{ $errors->first('email') }}</strong>
                      </span>
                  @endif
                </div>
            </div>

            <div class="form-group">
              <div class="col-sm-12">
                <button type="submit" class="btn btn-danger btn-block">Submit</button>
              </div>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>

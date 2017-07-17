<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
*{
  margin: 0px;
  padding: 0px;
}
.mail-nav{
  background-color: #dd4b39;
  height: 40px;
  padding: 5px;
}
.nav-title{
  text-align: center;
  font-size: 1.5em;
  font-weight: bold;
  color: #fff;
  margin-top: 5px;
}
.container{
  margin: 10% 10%;
}
</style>
</head>
<body>
<nav class="mail-nav">
  <div class="nav-title">Push Selling System</div>
</nav>
<div class="container">
  @yield('content')
  <br>
  <p>
    Thank you.
  </p>
  <p>
    ~Push Selling System Team~
  </p><br>
  <hr>
  <p>
    <i>This email generated automaticaly by the system, do not reply to this email</i>
  </p>
</div>
</body>
</html>

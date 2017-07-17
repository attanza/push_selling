<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/fastclick.min.js')}}"></script>
<script src="{{asset('js/jquery.slimscroll.min.js')}}"></script>
<script src="{{asset('js/toastr.js')}}"></script>
<script src="{{asset('js/admin_lte.js')}}"></script>
<script src="{{asset('js/sortable.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-noty/2.4.1/packaged/jquery.noty.packaged.min.js"></script>
<script src="{{ mix('js/app.js')}}"></script>
@yield('scripts')
@if(Session::has('success'))
    <script>
        toastr.success("{{Session::get('success')}}")
    </script>
@endif
@if(Session::has('error'))
    <script>
        toastr.error("{{Session::get('error')}}")
    </script>
@endif
</body>
</html>

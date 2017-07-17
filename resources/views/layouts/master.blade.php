@include('layouts.partials.head')
<div class="wrapper" id="app">
@include('layouts.partials.header')
@include('layouts.partials.sidebar')
{{-- @include('layouts.partials.content_wrapper') --}}
@yield('content')
@include('layouts.partials.footer')
{{-- @include('layouts.partials.control_sidebar') --}}
</div>
@include('layouts.partials.scripts')

@include('layouts.header')

@include('layouts.navbar')

<div class="container-fluid page-body-wrapper">

@include('layouts.sidebar')

<div class="main-panel">
<div class="content-wrapper">

@yield('content')

</div>

@include('layouts.footer')

</div>
</div>

@include('layouts.scripts')

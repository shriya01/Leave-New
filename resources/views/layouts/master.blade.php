<!DOCTYPE html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ __('messages.project_name')}}</title>
    <meta name="description" content="">	
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('public/frontend/css/style.css') }}" rel="stylesheet">
    <!-- stylesheet inclusion to make datatable css work -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"/>
    <link href="{{ asset('public/frontend/css/font-awesome.min.css') }}" rel="stylesheet" />
        @yield('styles')

</head>
<body>
    <!--Header-part-->
    @include('includes.header')     
    <!--end-Header-part-->
    <!-- Dynamic content Section -->
    <main role="main" class="container">
        @yield('content')
    </main>
    <!-- end-dynamic content Section-->
    <!--Footer-part-->
    @include('includes.footer')        
    <!--end-Footer-part-->  
    @yield('scripts');
    <!-- script inclusion to make datatable work -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> 
    <script type="text/javascript">
        var table = $('#data-table').DataTable( {
            rowReorder: true
        } );
        var base_url = "{{ url('/') }}";
        var csrf_token = "<?php echo csrf_token();?>";
    </script>
</body>
</html>

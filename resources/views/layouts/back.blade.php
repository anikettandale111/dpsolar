<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title')</title>
  <!-- Favicon icon -->
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('backend/assets/images/favicon.png')}}">
  <!-- Pignose Calender -->
  <link href="{{ asset('backend/assets/plugins/pg-calendar/css/pignose.calendar.min.css')}}" rel="stylesheet">
  <!-- Chartist -->
  <link rel="stylesheet" href="{{ asset('backend/assets/plugins/chartist/css/chartist.min.css')}}">
  <link rel="stylesheet" href="{{ asset('backend/assets/plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css')}}">
  <!-- Custom Stylesheet -->
  <link href="{{ asset('backend/assets/css/style.css')}}" rel="stylesheet">
  @stack('styles')
</head>

<body>
  <div id="preloader">
    <div class="loader">
      <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
      </svg>
    </div>
  </div>
<<<<<<< HEAD
  <div id="main-wrapper">
    <div class="nav-header">
      <div class="brand-logo">
        <a href="index.html">
          <b class="logo-abbr"><img src="{{ asset('backend/assets/images/logo.png')}}" alt=""> </b>
          <span class="logo-compact"><img src="{{ asset('backend/assets/images/logo-compact.png')}}" alt=""></span>
          <span class="brand-title">
            <img src="{{ asset('backend/assets/images/logo-text.png')}}" alt="">
          </span>
        </a>
      </div>
    </div>
    @include('inc.topbar')
    @include('inc.sidebar')
    <div class="content-body">
    @yield('content')
    </div>
    <div class="footer">
      <div class="copyright">
        <p>Copyright &copy; Designed & Developed by <a href="https://themeforest.net/user/quixlab">Quixlab</a> 2018</p>
      </div>
    </div>
  </div>
  <script src="{{ asset('backend/assets/plugins/common/common.min.js')}}"></script>
  <script src="{{ asset('backend/assets/js/custom.min.js')}}"></script>
  <script src="{{ asset('backend/assets/js/settings.js')}}"></script>
  <script src="{{ asset('backend/assets/js/gleek.js')}}"></script>
  <script src="{{ asset('backend/assets/js/styleSwitcher.js')}}"></script>
  <!-- Chartjs -->
  <!-- <script src="{{ asset('backend/assets/plugins/chart.js/Chart.bundle.min.js')}}"></script> -->
  <!-- Circle progress -->
  <!-- <script src="{{ asset('backend/assets/plugins/circle-progress/circle-progress.min.js')}}"></script> -->
  <!-- Datamap -->
  <script src="{{ asset('backend/assets/plugins/d3v3/index.js')}}"></script>
  <script src="{{ asset('backend/assets/plugins/topojson/topojson.min.js')}}"></script>
  <script src="{{ asset('backend/assets/plugins/datamaps/datamaps.world.min.js')}}"></script>
  <!-- Morrisjs -->
  <!-- <script src="{{ asset('backend/assets/plugins/raphael/raphael.min.js')}}"></script> -->
  <!-- <script src="{{ asset('backend/assets/plugins/morris/morris.min.js')}}"></script> -->
  <!-- Pignose Calender -->
  <!-- <script src="{{ asset('backend/assets/plugins/moment/moment.min.js')}}"></script> -->
  <!-- <script src="{{ asset('backend/assets/plugins/pg-calendar/js/pignose.calendar.min.js')}}"></script> -->
  <!-- ChartistJS -->
  <script src="{{ asset('backend/assets/plugins/chartist/js/chartist.min.js')}}"></script>
  <script src="{{ asset('backend/assets/plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js')}}"></script>
  <script src="{{ asset('backend/assets/js/dashboard/dashboard-1.js')}}"></script>
=======

  <!-- General JS Scripts -->
  <script src="{{ asset('backend/assets/modules/jquery.min.js')}}"></script>
  <script src="{{ asset('backend/assets/modules/popper.js')}}"></script>
  <script src="{{ asset('backend/assets/modules/tooltip.js')}}"></script>
  <script src="{{ asset('backend/assets/modules/bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{ asset('backend/assets/modules/nicescroll/jquery.nicescroll.min.js')}}"></script>
  <script src="{{ asset('backend/assets/modules/moment.min.js')}}"></script>
  <script src="{{ asset('backend/assets/js/stisla.js')}}"></script>
  <script src="{{ asset('backend/assets/modules/sweetalert/sweetalert.min.js')}}"></script>

  <!-- JS Libraies -->
  <script src="{{ asset('assets/modules/jquery.sparkline.min.js')}}"></script>
  <script src="{{ asset('assets/modules/chart.min.js')}}"></script>
  <script src="{{ asset('assets/modules/owlcarousel2/dist/owl.carousel.min.js')}}"></script>
  <script src="{{ asset('assets/modules/summernote/summernote-bs4.js')}}"></script>
  <script src="{{ asset('assets/modules/chocolat/dist/js/jquery.chocolat.min.js')}}"></script>
  <!-- Page Specific JS File -->

  <!-- Template JS File -->
  <script src="{{ asset('backend/assets/js/scripts.js')}}"></script>
  <script src="{{ asset('backend/assets/js/custom.js')}}"></script>
  <script>
    @if (session('success'))
        swal("Success!", "{{ session('success') }}", "success");
    @endif
    @if (session('error'))
        swal("Error!", "{{ session('error') }}", "error");
    @endif
  </script>
   <script src="{{ asset('backend/assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
   <script>
       $(document).ready(function() {
           const addSelectAll = matches => {
               if (matches.length > 0) {
               // Insert a special "Select all matches" item at the start of the
               // list of matched items.
               return [
                   {id: 'selectAll', text: 'Select all matches', matchIds: matches.map(match => match.id)},
                   ...matches
               ];
               }
           };
           const handleSelection = event => {
               if (event.params.data.id === 'selectAll') {
               $('.select2').val(event.params.data.matchIds);
               $('.select2').trigger('change');
               };
           };
           $('.select2').select2({
               multiple: true,
               sorter: addSelectAll,
           });
           $('.select2').on('select2:select', handleSelection);
       });
   </script>
>>>>>>> e9c86bec46221be68b9eaceb2a158981149f1e5b
  @stack('scripts')
</body>

</html>
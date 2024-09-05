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
  @stack('scripts')
</body>

</html>
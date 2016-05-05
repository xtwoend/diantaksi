<!DOCTYPE html>
<html lang="en" class="app">
<head>
  <meta charset="utf-8" />
  <title>DIANTAKSI | Web Application</title>
  <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="/css/bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="/css/animate.css" type="text/css" />
  <link rel="stylesheet" href="/css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="/css/simple-line-icons.css" type="text/css" />
  <link rel="stylesheet" href="/css/font.css" type="text/css" />
  <link rel="stylesheet" href="/js/datepicker/datepicker.css" type="text/css" />
  <link rel="stylesheet" href="/css/app.css" type="text/css" />
    <!--[if lt IE 9]>
    <script src="/js/ie/html5shiv.js"></script>
    <script src="/js/ie/respond.min.js"></script>
    <script src="/js/ie/excanvas.js"></script>
  <![endif]-->
  <link rel="stylesheet" type="text/css" media="screen" href="/js/jquery-ui-themes-1.11.4/themes/black-tie/jquery-ui.min.css"/>
  <link rel="stylesheet" type="text/css" media="screen" href="/js/jquery-ui-themes-1.11.4/themes/black-tie/theme.css"/>
  <link rel="stylesheet" type="text/css" media="screen" href="/js/jqgrid/css/ui.jqgrid-bootstarp.css" />
  <link rel="stylesheet" type="text/css" media="screen" href="/js/jqgrid/css/ui.jqgrid.css" />

  @yield('css')

  <script type="text/javascript">
    var rootUrl = '{{ Request::url() }}';
    var crsf_token = '{{ csrf_token() }}';
  </script>

</head>
<body class="">

  @yield('body')

  <script src="/js/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="/js/bootstrap.js"></script>
  <!-- App -->
  <script src="/js/slimscroll/jquery.slimscroll.min.js"></script>
  <script src="/js/app.plugin.js"></script>
  <!-- datepicker -->
  <script src="/js/datepicker/bootstrap-datepicker.js"></script>
  <!-- jq grid -->
  <script src="/js/jqgrid/js/i18n/grid.locale-en.js" type="text/javascript"></script>
  <script src="/js/jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>
  <!-- Sparkline Chart -->
  <script src="/js/charts/sparkline/jquery.sparkline.min.js"></script>
  <!-- Easy Pie Chart -->
  <script src="/js/charts/easypiechart/jquery.easy-pie-chart.js"></script>
  <!-- Flot -->
  <script src="/js/charts/flot/jquery.flot.min.js"></script>
  <script src="/js/charts/flot/jquery.flot.tooltip.min.js"></script>
  <script src="/js/charts/flot/jquery.flot.resize.js"></script>
  <script src="/js/charts/flot/jquery.flot.orderBars.js"></script>
  <script src="/js/charts/flot/jquery.flot.pie.min.js"></script>
  <script src="/js/charts/flot/jquery.flot.grow.js"></script>

  <script src="/js/app.js"></script>
  <script type="text/javascript">
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  </script>
  @yield('js')

</body>
</html>

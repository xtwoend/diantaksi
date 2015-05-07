@section('head')
	<meta charset="utf-8">
    <title>PT. Dharma Indah Agung Metropolitan</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta name="description" content="">
    <meta name="author" content="">

    {{-- In case you want to add you own meta tags --}}
    @yield('meta')

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">

	{{-- ===== CSS ===== --}}
	@section('styles')
		@foreach ( Config::get('template.css') as $style )
			{{ HTML::style($style) }}
		@endforeach
	@yield_section


	{{-- Custom stylesheet --}}
	@yield('custom_style')
	{{-- The custom_style tag lets you add stylesheets that are specific to a webpage --}}

    <style type="text/css">
        #line-chart {
            height:300px;
            width:800px;
            margin: 0px auto;
            margin-top: 1em;
        }
        .brand { font-family: georgia, serif; }
        .brand .first {
            color: #ccc;
            font-style: italic;
        }
        .brand .second {
            color: #fff;
            font-weight: bold;
        }
        
    </style>



	{{-- More Javascript at the bottom for faster web performance --}}
    <script>var base_url = '{{ URL::base() }}'; </script>
        
    {{-- base url for javascript --}}
    {{-- Scripts concatenated and minified --}}
    
    @foreach ( Config::get('template.scripts') as $script )
            {{ HTML::script($script) }}
    @endforeach
    {{-- End scripts --}}

@yield_section
@section('script')
	<div id="embed"></div>
{{-- ===== Javascript ===== --}}
	{{-- Untuk Chat Room --}}
	@if(!Auth::guest())
	<script>

		var working = false;
		$('#chat').live('click', function() {
        	//alert('Doing Someting');
        	chatyuk();
        	return false;
      	});

		function chatyuk()
		{
			var url = 'http://118.91.130.222/chat/php/ajax.php?action=login&name={{ Auth::user()->username }}';
          	var thePopup = window.open( url, "Chat Bareng", "menubar=0,location=0,height=540,width=530" );
		}

	</script>
	@endif

	{{-- Scripts concatenated and minified --}}
	@section('more_scripts')

		@foreach ( Config::get('template.other_scripts') as $script )
			{{ HTML::script($script) }}
		@endforeach

		@yield('custom_scripts')

	@yield_section
	{{-- End scripts --}}

	{{-- Asynchronous Google Analytics --}}
	@if ( Config::get('template.analytics_on') )
	  <script>
	    var _gaq=[['_setAccount','{{ Config::get("template.analytics_id") }}'],['_trackPageview']];
	    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
	    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
	    s.parentNode.insertBefore(g,s)}(document,'script'));
	  </script>
	@endif
	
@yield_section
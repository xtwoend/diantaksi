<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Language
	|--------------------------------------------------------------------------	
	|
	| Set the language of your site here.
	| And remember, spanish is 'es', not 'sp'.
	|
	| Read more about the lang attribute:
	| http://tlt.its.psu.edu/suggestions/international/web/tips/langtag.html#why
	|
	*/

	'language' => 'id',


	/*
	|--------------------------------------------------------------------------
	| The author
	|--------------------------------------------------------------------------
	|
	| This is used for filling out the author meta tag.
	| Just write how you would like to be named here.
	|
	*/

	'author' => 'this author',


	/*
	|--------------------------------------------------------------------------
	| CSS Main file
	|--------------------------------------------------------------------------
	|
	|	Path to your main css file here.
	| Because you ARE concatenating and minifying your css files, aren't you?
	| Or at least using sass?
	| 
	| If not, you will need to go to the 'head.blade.php' file and add the css
	| files you are using in there.
	| 
	*/
	'css' => array(

			'bootstrap' => 'themes/lib/bootstrap/css/bootstrap.css',
			'bootstrap-responsive' => 'themes/lib/bootstrap/css/bootstrap-responsive.min.css',
			//'bootstrap' => 'themes/lib/jqGrid.bootstrap/bootstrap/css/bootstrap.min.css',

			'theme' => 'themes/stylesheets/theme.css',
			'font-awesome' => 'themes/lib/font-awesome/css/font-awesome.css',
			'datepicker' => 'themes/lib/bootstrap/css/datepicker.css',
			'timepicker' => 'themes/lib/bootstrap/css/timepicker.css',
			//'bootstrap.validate' => 'themes/lib/bootstrap/css/bootstrap.validate.css',
			//'jscrollpane' => 'themes/lib/jscroll/css/jquery.jscrollpane.css',
			//'grid-css' => 'themes/lib/grid/css/simplePagingGrid-0.4.css',
			//'jquery-ui-css' => 'themes/lib/jqGrid.bootstrap/jquery-ui/css/custom-theme/jquery-ui-1.8.22.custom.css',
			'jquery-ui-css' => 'themes/lib/jquery-ui/css/smoothness/jquery-ui-1.10.1.custom.min.css',
			'jqgrid-css' => 'themes/lib/jqGrid.bootstrap/jqGrid/css/ui.jqgrid.css',
			//'jqgridb-css' => 'themes/lib/jqGrid.bootstrap/jqGrid/jqGrid.bootstrap.css',


			),


	/*
	|--------------------------------------------------------------------------
	| jQuery
	|--------------------------------------------------------------------------
	|
	| jQuery configuration here:
	|
	| 	Choose the version of jQuery you want to work with.
	|		You should always provide a fallback in case something 
	|		doesn't work with the remote server.
	|
	| Modelo has some defaults for you :)
	|
	| You don't have to use jQuery, though.
	| Simply set 'jquery_on' to false if you don't care about jQuery.
	|
	*/

	'jquery_on'		  => false,
	'jquery_version'  => '1.8.1',
	'jquery_fallback' => 'themes/lib/jquery-1.8.1.min.js',


	/*
	|--------------------------------------------------------------------------
	| JS Files (In the <head>)
	|--------------------------------------------------------------------------
	|
	| Define the path to the script files that should be loaded
	| before anything else in the page.
	|
	| Add them as if you were starting from the root of your site.
	| Here is an example:
	|
	|		'scripts' => array(
	|			'polyfills'  => 'js/polyfills.min.js',
	|			'plugins' 	 => 'js/plugins.js'
	|		),
	|
	*/

	'scripts'	=> array(
				'jquery_fallback' => 'themes/lib/jquery-1.8.1.min.js',
				'bootstrap-js' => 'themes/lib/bootstrap/js/bootstrap.min.js',
				//'deployJava' => 'qzprint/js/deployJava.js',				
				),


	/*
	|--------------------------------------------------------------------------
	| Other JS files (at the bottom of the page)
	|--------------------------------------------------------------------------
	|
	| Define the path to your other javascript files here.
	| Because of the way Laravel works, the 'scripts' variable has to be
	| an associative array.
	|
	| Add them as if you were starting from the root of your site.
	| Here is an example:
	|
	|		'scripts' => array(
	|			'script'  => 'js/script.js',
	|			'plugins' => 'js/plugins.js'
	|		),
	|
	*/
	
	'other_scripts' => array(
			
			//'jquery-ui-js' => 'themes/lib/jquery-ui/js/jquery-ui-1.10.1.custom.min.js',
			//'jquery-ui-js' => 'themes/lib/jqGrid.bootstrap/jquery-ui/js/jquery-ui-1.9.2.custom.min.js',
			'liscroll' => 'themes/lib/liscroll.js',
			'i18n' => 'themes/lib/jqGrid.bootstrap/jqGrid/js/i18n/grid.locale-id.js',
			'jqgrid-js' => 'themes/lib/jqGrid.bootstrap/jqGrid/js/jquery.jqGrid.min.js',
			'jqgrid-cotume-js' => 'themes/lib/jqGrid.bootstrap/jqGrid/js/grid.custom.js',
			
			
			'app-js' => 'themes/lib/app.js',
			'bootstrap-datepicker' => 'themes/lib/bootstrap/js/bootstrap-datepicker.js',
			'bootstrap-timepicker' => 'themes/lib/bootstrap/js/bootstrap-timepicker.js',
			'html2canvas' => 'themes/lib/jzebra/js/html2canvas.js',
			'html2canvas-plugin' => 'themes/lib/jzebra/js/jquery.plugin.html2canvas.js',
			'bootstrap-money' => 'themes/lib/bootstrap/js/jquery.bootstrap-money-field.js',
			'accounting-format' => 'themes/lib/accounting.min.js',
			//'jsscroll' => 'themes/lib/jscroll/js/jquery.jscrollpane.min.js',
			'mousewheel' => 'themes/lib/jscroll/js/jquery.mousewheel.js',
			//'handlebars' => 'themes/lib/grid/js/handlebars-1.0.rc.1.js',
			//'grid-js' => 'themes/lib/grid/js/simplePagingGrid-0.4.js',
			'addrowjs' => 'themes/lib/jquery.table.addrow.js',
			'globalize' => 'themes/lib/globalize/globalize.js',
			'cultures' => 'themes/lib/globalize/cultures/globalize.culture.id-ID.js',
			
			//'rgraph' => 'themes/lib/rgraph/RGraph.common.core.js',
			//'rgraph-line' => 'themes/lib/rgraph/RGraph.line.js',

			'graph' => 'themes/lib/highcharts/highcharts.js',
			'graph-export' => 'themes/lib/highcharts/modules/exporting.js',
			'print-div'	=> 'js/print.js',

			//print qz-printer
			
		),


	/*
	|--------------------------------------------------------------------------
	| Google Analytics
	|--------------------------------------------------------------------------
	|
	| Set your google analytics site ID here.
	|
	| This is an asynchronous google analytics snippet, as found
	| on HTML5 Boilerplate.
	|
	| Read more about it here:
	| mathiasbynens.be/notes/async-analytics-snippet
	| 
	*/

	'analytics_on' => false,
	'analytics_id' => 'UA-XXXXX-X',


	/*
	|--------------------------------------------------------------------------
	| Common header and footer
	|--------------------------------------------------------------------------
	|
	| Having the same header and footer throughout the site is pretty
	| common these days.
	| Here you can activate this option and set the path to their view.
	|
	| Note: Take the 'application/views' folder as the starting point.
	|
	*/

	'header_on' => true,
	'footer_on' => true,
);
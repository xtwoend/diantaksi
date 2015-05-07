@section('body')

	{{-- Main section --}}
@section('main')

		@section('navbar')
			@include('themes.partials.navbar')
		@yield_section

@if(!Auth::guest())
		@section('sidebar')
			@include('themes.partials.sidebar')
		@yield_section

		<div class="content">
            <br><br>
					@yield('header')
			 <div class="container-fluid">
    			<div class="row-fluid">
					@yield('content')
					@section('footer')
							@include('themes.partials.footer')
					@yield_section
				</div>
			</div>
            @section('notes')
                            @include('themes.partials.notes')
            @yield_section
		</div>	
@else
		@yield('content')
@endif
				
	@yield_section
	{{-- Main section --}}

	{{-- The Tail --}}
		@section('script')
			@include('themes.partials.script')
		@yield_section

		@yield('otherscript')
	{{-- tail include javascript files --}}
<script type="text/javascript">
    
    date_time('date_time');
    
    function date_time(id)
    {
            date = new Date;
            year = date.getFullYear();
            month = date.getMonth();
            months = new Array('Januari', 'Febuari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
            d = date.getDate();
            day = date.getDay();
            days = new Array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
            h = date.getHours();
            if(h<10)
            {
                    h = "0"+h;
            }
            m = date.getMinutes();
            if(m<10)
            {
                    m = "0"+m;
            }
            s = date.getSeconds();
            if(s<10)
            {
                    s = "0"+s;
            }
            //result = ''+days[day]+', '+d+' '+months[month]+' '+year+' '+h+':'+m+':'+s;
            result = d+' '+months[month]+' '+year+' '+h+':'+m+':'+s;
            document.getElementById(id).innerHTML = result;
            setTimeout('date_time("'+id+'");','1000');
            return true;
    }
    </script>
	
@yield_section
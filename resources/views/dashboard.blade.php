@extends('main')

@section('content')
<section id="content">
	<section class="vbox" id="bjax-el">
		<section class="scrollable wrapper">
			<div class="row">
                <div class="col-md-4">
                  <section class="panel panel-default">
                    <header class="panel-heading font-bold">Pendapatan dan KS Bulan {{ date('M Y', strtotime($date)) }}</header>
                    <div class="panel-body">
                      	<div id="flot-pie"  style="height:240px"></div>
                    </div>                  
                  </section>
                </div>
            </div>
		</section>
	</section>
</section>
@endsection

@section('js')
<script type="text/javascript">
$(function(){
	
	var request = $.ajax({
		url: "{{ url('statistics/pendapatan') }}",
		method: "POST",
		data: { date: "{{ $date }}", _token: crsf_token },
		dataType: "json",
		success: function(data){
			$("#flot-pie").length && $.plot($("#flot-pie"), data, {
			    series: {
			      pie: {
			        combine: {
			              color: "#999",
			              threshold: 0.05
			            },
			        show: true
			      }
			    },    
			    colors: ["#19b39b", "#644688"],
			    legend: {
			      show: false
			    },
			    grid: {
			        hoverable: true,
			        clickable: false
			    }
			});

		}
	});

	
});
</script>
@endsection
@extends('main')

@section('content')
<section id="content">
	<section class="vbox">
        <section class="hbox stretch">
                <!-- side content -->
                <aside class="aside bg-light dk" id="sidebar">
                  <section class="vbox animated fadeInUp">
                    <section class="scrollable hover">
                      <div class="list-group no-radius no-border no-bg m-t-n-xxs m-b-none auto">
                        @foreach ($ksos as $x) 
                            <a href="{{ url('reports/armada', [$x->id]) }}" class="list-group-item">
                              {{ $x->taxi_number }}
                            </a>
                        @endforeach
                      </div>
                    </section>
                  </section>
                </aside>
                <!-- / side content -->
                <section>
                  <section class="vbox">
                    <section class="scrollable padder-lg">
                      <h2 class="font-thin m-b">Nomor Body {{ $fleet->taxi_number }}</h2>
                      	<div class="row">
                      		<div class="col-md-6">
                      			<section class="panel panel-default">
			                        <header class="panel-heading bg-light no-border">
			                          <div class="clearfix">
			                            <a href="#" class="pull-left thumb-md avatar b-3x m-r">
			                              <img src="/images/a1.png" alt="...">
			                            </a>
			                            <div class="clear">
			                              <div class="h3 m-t-xs m-b-xs">
			                                {{ $kso->bravo->name }}
			                              </div>
			                              <small class="text-muted">Bravo</small>
			                            </div>
			                          </div>
			                        </header>
			                        <div class="list-group no-radius alt">
			                          <a class="list-group-item" href="#">
			                          	 <i class="fa fa-calendar icon-muted"></i> 
			                            Tanggal KSO <span class="pull-right">{{ $kso->ops_start }}</span>
			                          </a>
			                          <a class="list-group-item" href="#">
			                            <i class="fa fa-bar-chart-o icon-muted"></i> 
			                            Laporan Setoran Pengemudi
			                          </a>
			                          <a class="list-group-item" href="#">
			                            <span class="badge bg-info">16</span>
			                            <i class="fa fa-gavel icon-muted"></i> 
			                            Rekap BAP Pengemudi
			                          </a>
			                        </div>
			                    </section>
                      		</div>
                      		<div class="col-md-6">
                      			@if($kso->charlie)
                      			<section class="panel panel-default">
			                        <header class="panel-heading bg-light no-border">
			                          <div class="clearfix">
			                            <a href="#" class="pull-left thumb-md avatar b-3x m-r">
			                              <img src="/images/a1.png" alt="...">
			                            </a>
			                            <div class="clear">
			                              <div class="h3 m-t-xs m-b-xs">
			                                {{ $kso->charlie->name }}
			                              </div>
			                              <small class="text-muted">Charlie</small>
			                            </div>
			                          </div>
			                        </header>
			                        <div class="list-group no-radius alt">
			                          <a class="list-group-item" href="#">
			                          	 <i class="fa fa-calendar icon-muted"></i> 
			                            Tanggal KSO <span class="pull-right">{{ $kso->ops_start }}</span>
			                          </a>
			                          <a class="list-group-item" href="#">
			                            <i class="fa fa-bar-chart-o icon-muted"></i> 
			                            Laporan Setoran Pengemudi
			                          </a>
			                          <a class="list-group-item" href="#">
			                            <span class="badge bg-info">16</span>
			                            <i class="fa fa-gavel icon-muted"></i> 
			                            Rekap BAP Pengemudi
			                          </a>
			                        </div>
			                    </section>
			                    @endif
                      		</div>
                      	</div>
                    	<section class="panel panel-default">
			                <header class="panel-heading font-bold">Peningkatan hutang dalam 10 hari terakhir</header>
			                <div class="panel-body">
			                  <div id="flot-1ine" style="height:250px"></div>
			                </div>
		            	</section>
                    </section>                    
                  </section>
                </section>
        </section>        
	</section>
</section>
@endsection


@section('js')

<script type="text/javascript">
$(function(){
	
	var request = $.ajax({
	  url: "{{ url('reports/armada/hutang') }}",
	  method: "POST",
	  data: { id : "{{ $kso->id }}", limit: 10, _token: crsf_token },
	  dataType: "json",
	  success: onDataReceived
	});
	
	var options = { grid: {
			            hoverable: true,
			            clickable: true,
			            tickColor: "#f0f0f0",
			            borderWidth: 1,
			            color: '#f0f0f0'
			        },
			        colors: ["#1bb399"],
			        xaxis:{
			        },
			        yaxis: {
			          ticks: 5
			        },
			        tooltip: true,
			        tooltipOpts: {
			          content: "hutang: %y",
			          defaultTheme: false,
			          shifts: {
			            x: 0,
			            y: 20
			          }
			        }
			      };

	function onDataReceived (data) {
		$.plot($("#flot-1ine"), [{
          data: data
      	}], options);
	}

	$("#flot-1ine").length && $.plot($("#flot-1ine"), [{
          data: []
      }], options
  	);

});
</script>
@endsection
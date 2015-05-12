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
                      	<div class="row m-t">
                      		<div class="col-md-6">
                      			<section class="panel panel-default">
			                        <header class="panel-heading bg-light no-border">
			                          <div class="clearfix">
			                            <div class="clear">
			                              <div class="h3 m-t-xs m-b-xs">
			                                BODY <span class="pull-right">{{ $fleet->taxi_number }}</span>
			                              </div>			                            
			                            </div>
			                          </div>
			                        </header>
			                        <div class="list-group no-radius alt">
			                          <a class="list-group-item" href="#">
			                            Nomor Polisi <span class="pull-right font-bold">{{ $kso->fleet->police_number }}</span>
			                          </a>
			                          <a class="list-group-item" href="#"> 
			                            Nomor Engine <span class="pull-right font-bold">{{ $kso->fleet->engine_number }}</span>
			                          </a>
			                          <a class="list-group-item" href="#">
			                            Nomor Chassis <span class="pull-right font-bold">{{ $kso->fleet->chassis_number }}</span>
			                          </a>
			                          <a class="list-group-item" href="#">
			                            Status Armada <span class="pull-right font-bold">{{ ($kso->fleet->fg_blocked == 1 || $kso->fleet->fg_bengkel == 1) ? 'Blocked' : 'Ready' }}</span>
			                          </a>
			                          <a class="list-group-item" href="#">
			                            Saldo Armada 
			                            <span class="pull-right font-bold">
			                            	@if($total)
			                            	<?php $saldo =  ($total->cicilan_ks - $total->ks) + ($total->tabungan_sparepart + $total->cicilan_sparepart + $total->hutang_dp_sparepart) - $total_pemakaian_part ?>
			                            	{{ number_format($saldo, 0,',','.') }}
			                            	@endif
			                            </span>
			                          </a>
			                          
			                        </div>
			                    </section>
                      		</div>

                      		<div class="col-md-6">
                      			@if($total)
                      			<section class="panel panel-default">
				                    <header class="panel-heading bg-light no-border">
				                    	<div class="clearfix">
					                      <ul class="nav nav-tabs nav-justified">
					                        <li class="active h3 m-t-xs m-b-xs"><a href="#saldo" data-toggle="tab">Saldo</a></li>
					                        <li class="h3 m-t-xs m-b-xs"><a href="#dp" data-toggle="tab">DP KSO</a></li>
					                      </ul>
					                    </div>
				                    </header>
				                    <div class="tab-content">
				                        <div class="tab-pane active list-group no-radius alt m-b-none" id="saldo">
					                          <a class="list-group-item" href="#">
					                            Total KS <span class="pull-right font-bold">{{ number_format($total->ks, 0,',','.') }}</span>
					                          </a>
					                          <a class="list-group-item" href="#"> 
					                            Pembayaran KS <span class="pull-right font-bold">{{ number_format($total->cicilan_ks, 0,',','.') }}</span>
					                          </a>
					                          <a class="list-group-item" href="#">
					                            Tabungan Sparepart <span class="pull-right font-bold">{{ number_format($total->tabungan_sparepart, 0,',','.') }}</span>
					                          </a>
					                          <a class="list-group-item" href="#">
					                            Pemakaian Sparepart <span class="pull-right font-bold">{{ number_format($total_pemakaian_part, 0,',','.') }}</span>
					                          </a>
					                          <a class="list-group-item" href="#">
					                            Pembayaran Sparepart <span class="pull-right font-bold">{{ number_format(($total->cicilan_sparepart + $total->hutang_dp_sparepart), 0,',','.') }}</span>
					                          </a>
				                        </div>
				                        <div class="tab-pane list-group no-radius alt m-b-none" id="dp">
				                        	<a class="list-group-item" href="#">
					                            DP KSO <span class="pull-right font-bold">{{ number_format($kso->dp, 0,',','.') }}</span>
					                          </a>
					                          <a class="list-group-item" href="#"> 
					                            Hutang DP KSO <span class="pull-right font-bold">{{ number_format($kso->sisa_dp, 0,',','.') }}</span>
					                          </a>
					                          <a class="list-group-item" href="#">
					                            Pembayaran DP KSO <span class="pull-right font-bold">{{ number_format($total->cicilan_dp_kso, 0,',','.') }}</span>
					                          </a>
					                          <a class="list-group-item" href="#">
					                            Saldo DP KSO <span class="pull-right font-bold">{{ number_format(($kso->sisa_dp - $total->cicilan_dp_kso), 0,',','.') }}</span>
					                          </a>
					                         
				                        </div>
				                    </div>
				                  </section>
				                  @endif
                      		</div>
                      	</div>
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
			                <header class="panel-heading font-bold">Peningkatan hutang armada dalam 10 hari terakhir</header>
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
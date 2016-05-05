@extends('main')

@section('css')
<link rel="stylesheet" href="/js/easyautocomplete/easy-autocomplete.css" type="text/css" />
<link rel="stylesheet" href="/js/easyautocomplete/easy-autocomplete.themes.css" type="text/css" />
@endsection

@section('content')
<section id="content">
	<section class="vbox" id="bjax-el">
		<section class="scrollable wrapper">
			<section class="panel panel-default">
                <header class="panel-heading font-bold"> Form Penerimaan Sparepart / Barang </header>
                <div class="panel-body">
                	<form class="bs-example form-horizontal">
                		<div class="row">
                			<div class="col-md-6">
                				<div class="form-group">
		                          	<label class="col-lg-3 control-label">Suppiler</label>
		                          	<div class="col-lg-9">
		                            	<input type="text" class="form-control" placeholder="Suppiler" id="supplier">
		                            </div>
		                        </div>
		                        <div class="form-group">
		                          	<label class="col-lg-3 control-label">Tanggal</label>
		                          	<div class="col-lg-9">
		                            	<input class="input datepicker-input form-control" size="16" type="text" value="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd" name="date" id="date">
		                            </div>
		                        </div>
                			</div>
                			<div class="col-md-6">
                				<div class="form-group">
		                          	<label class="col-lg-3 control-label">Nomor Bukti</label>
		                          	<div class="col-lg-9">
		                            	<div class="input-group">
				                          <span class="input-group-addon">BPS/</span>
				                          <input type="text" class="form-control" placeholder="xxxx">
				                          <span class="input-group-addon">/{{ date('m') }}/{{ date('Y') }}</span>
				                        </div>
		                            </div>
		                        </div>
		                        <div class="form-group">
		                          	<label class="col-lg-3 control-label">Penerima</label>
		                          	<div class="col-lg-9">
		                            	<input type="text" class="form-control" placeholder="Suppiler" readonly="true" value="{{ Auth::user()->pool->pool_name }}">
		                            </div>
		                        </div>

		                        <div class="form-group">
		                        	<label class="col-lg-3 control-label">&nbsp;</label>
		                        	<div class="col-lg-9">
			                          	<button class="btn btn-primary">SIMPAN</button>
			                          	<button class="btn">BATAL</button>
		                        	</div>
		                        </div>
                			</div>
                		</div>
                	</form>
                </div>
            </section>
            <section class="panel panel-default">
				<div class="panel-body">
					<form action="" class="form-horizontal">
						<div class="row">
                			<div class="col-md-6">
                				<div class="form-group">
                					<label for="" class="col-lg-3 control-label">No. Sparepart</label>
		                          	<div class="col-lg-9">
				                        <input type="text" class="form-control" placeholder="Part Number...">
		                            </div>
		                        </div>
                			</div>
                			<div class="col-md-2">
								<div class="form-group">
		                          	<div class="col-lg-12">
		                            	<input type="text" class="form-control" placeholder="Qty..">
		                            </div>
		                        </div>
                			</div>
                			<div class="col-md-3">
								<div class="form-group">
		                          	<div class="col-lg-12">
		                            	<input type="text" class="form-control" placeholder="Harga..">
		                            </div>
		                        </div>
                			</div>
                			<div class="col-md-1">
								<button class="btn btn-primary" type="submit">ADD</button>
                			</div>
                		</div>
                	</form>
                		<div class="row">
                			<div class="col-lg-12 table-responsive">
				                <table id="item-penerimaan" class="table table-striped m-b-none" data-ride="datatables">
				                    <thead>
				                      	<tr>
				                      		<th  style="width:5%">No.</th>
					                        <th  style="width:15%">Nomor Sparepart</th>
					                        <th  style="width:25%">Nama Sparepart</th>
					                        <th  style="width:8%">Qty</th>
					                        <th  style="width:10%">@Harga</th>
					                        <!-- <th  style="width:12%">Sub Total</th> -->
					                        <th  style="width:25%">Keterangan</th>
					                        <th  style="width:5%"></th>
				                      	</tr>
				                    </thead>
				                    <tbody>
				                    	@for($i=1; $i <= 20; $i++)
				                    	<tr id="row-{{ $i }}">
				                    		<td>{{ $i }}</td>
				                    		<td>001.006</td>
				                    		<td>BAUT 12                          UM</td>
				                    		<td contenteditable="true" id="{{ $i }}" field="qty">10</td>
				                    		<td contenteditable="true" id="{{ $i }}" field="price">20000</td>
				                    		<!-- <td>200000</td> -->
				                    		<td contenteditable="true" id="{{ $i }}" field="description"></td>
				                    		<td><div class="btn btn-default btn-xs"><i class="fa fa-trash-o text-muted"></i></div></td>
				                    	</tr>
				                    	@endfor
				                    </tbody>
				                    <tfoot>
				                    	<tr>
				                    		<th></th>
				                    		<th></th>
				                    		<th>TOTAL</th>
				                    		<th></th>
				                    		<th></th>
				                    		<th>2000000000</th>
				                    		<th></th>
				                    		<th></th>
				                    	</tr>
				                    </tfoot>
								</table>
                			</div>
                		</div>
				</div>
            </section>
		</section>
	</section>
</section>
@endsection

@section('js')
<script src="/js/easyautocomplete/jquery.easy-autocomplete.js"></script>
<script type="text/javascript">
$(function(){

	var options = {

		url: function(phrase) {
			return '{{ route('gudang.penerimaan.supplier') }}';
		},

		getValue: function(element) {
			return element.name;
		},

		ajaxSettings: {
		    dataType: "json",
		    method: "POST",
		    data: {
		      	dataType: "json"
		    }
		},

		preparePostData: function(data) {
		    data.phrase = $("#supplier").val();
		    return data;
		},

		requestDelay: 400
	};

	$("#supplier").easyAutocomplete(options);

	$("table#item-penerimaan td[contenteditable=true]").blur(function(e){
		e.preventDefault();
        var id = $(this).attr("id");
        var field = $(this).attr("field");
        var value = $(this).text();
        if(value !== ""){
        	$.post('{{ route('gudang.penerimaan.item.update') }}' , {id: id, field: field, value: value}, function(res){
	        	console.log(res);
	        });
        }
    });
    $('input').on("keypress", function(e) {
        /* ENTER PRESSED*/
        if (e.keyCode == 13) {
            /* FOCUS ELEMENT */
            var inputs = $(this).parents("form").eq(0).find(":input");
            var idx = inputs.index(this);

            if (idx == inputs.length - 1) {
                inputs[0].select()
            } else {
                inputs[idx + 1].focus(); //  handles submit buttons
                inputs[idx + 1].select();
            }
            return false;
        }
    });
});
</script>
@endsection

@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Persetujuan Permintaan Barang</h1>
  </div>
        
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li><a href="{{URL::to('werehouses')}}">Warehouse</a> <span class="divider">/</span></li>
        <li class="active">persetujuan permintaan barang</a></li>
    </ul>
@endsection
  
  
@section('content')

@if(Session::has('status'))
<div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{ Session::get('status'); }}
</div>
@endif

{{ Form::open(URL::current(), 'POST', array('class'=>'form-horizontal')) }}
<div class="block">
        <div class="block-heading">
             <span class="block-icon pull-right">
              <input type="submit" class="btn btn-info" value="Simpan">
            </span>
            <a href="#widget-preview" data-toggle="collapse">SPK Nomor : <strong>{{ $wo->wo_number }} </strong></a>
        </div>
        <div class="block-body collapse in" id="widget-preview">
          <br>
          <div class="row-fluid"> <!-- Start pembagian kolom -->
            <form class="form-horizontal">
              <div class="span6">
                
                  <div class="control-group">
                    <label class="control-label" for="body">Nomor Body</label>
                    <div class="controls"> <input type="hidden" id="wo_id" value="{{ $wo->id }}">
                      : <strong>{{ Fleet::find($wo->fleet_id)->taxi_number }}</strong> <button type="button" id="fleetinfo" class="btn btn-mini btn-info">Informasi Saldo</button>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="name">Nama Bravo</label>
                    <div class="controls">
                      : <strong>{{ Driver::find($wo->driver_id)->name }}</strong>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="inputtext">NIP </label>
                    <div class="controls">
                      : <strong>{{ Driver::find($wo->driver_id)->nip }}</strong>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="pool">Pool</label>
                    <div class="controls">
                      : <strong>{{ Pool::find($wo->pool_id)->pool_name }}</strong>
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="pool">Status Persetujuan</label>
                    <div class="controls">
                      : <strong>{{ Form::select('fg_part_approved', array('Menunggu Persetujuan', 'Telah disetujui') , $wo->fg_part_approved) }}</strong>
                    </div>
                  </div>

                   <div class="control-group">
                    <label class="control-label" for="pool">DP Sparepart</label>
                    <div class="controls">
                      : {{ Form::text('dp_sparepart', $wo->dp_sparepart, array( 'class' => 'span11  money')); }}
                    </div>
                  </div>
              </div>
              <div class="span6">
                  <div class="control-group">
                    <label class="control-label" for="woNumber">Nomor SPK</label>
                    <div class="controls">
                      : <strong>{{ $wo->wo_number }}</strong>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="date">Tanggal</label>
                    <div class="controls">
                      : <strong> {{ myFungsi::fulldate(strtotime($wo->inserted_date_set)) }}</strong>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="jam">Jam</label>
                    <div class="controls">
                        : <strong>{{ date('H:i:s', strtotime($wo->inserted_date_set)) }}</strong>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="kmMasuk">KM Masuk</label>
                    <div class="controls">
                        : <strong>{{ $wo->km }}</strong>
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="kmMasuk">Status Perbaikan</label>
                    <div class="controls">
                        : <strong>{{ Statusperbaikan::find($wo->status)->status }}</strong>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="woNumber">Oleh Mekanik</label>
                    <div class="controls">
                      : <strong>{{  $wo->mechanic }}</strong>
                    </div>
                  </div>

              </div>
             
               </form>
          </div>  <!-- end pembagian kolom -->
            <div class="row-fluid">
                <div class="span6">
                    <div class="block">
                        <div class="block-heading">
                            <a>Keluhan Kerusakan</a>
                        </div>
                        <div class="block-body">
                          {{ $wo->complaint }}
                        </div>
                    </div>
                     <div class="block">
                        <div class="block-heading">
                            <a>Keterangan</a>
                        </div>
                        <div class="block-body">
                          {{ $wo->information_complaint }}
                        </div>
                    </div>
                </div>
                <div class="span6">
                   <div class="block">
                        <div class="block-heading">
                            <a>Analisa Kerusakan</a>
                        </div>
                        <div class="block-body">

                          <table class="table table-condensed table-hover">
                            <tbody>
                            
                            @if($analisas)
                              <?php $no =1; ?>
                              @foreach($analisas as $analisa)
                              <tr id="row_{{ $analisa->id }}">
                                  <td>{{ $no }}</td>
                                  <td>{{ $analisa->analisa }}</td>
                              </tr>
                              <?php $no++ ?>
                              @endforeach
                            @else
                              <tr>
                                <td colspan="2">Analisa is empty</td>
                              </tr>
                            @endif
                            </tbody>
                          </table>
                        </div>
                    </div>
                </div>
            </div>
          <br>
        </div>
</div>
{{ Form::close() }}
<div class="row-fluid">
    <div class="block span12">
        <a href="#tablewidget" class="block-heading" data-toggle="collapse">Permintaan Sparepart dari WO</a>
        <div id="tablewidget" class="block-body collapse in">

                          <table class="table table-condensed table-hover">
                            <thead>
                              <tr> 
                                  <th class="span1">No. </th>
                                  <th class="span2">Nomor Part </th>
                                  <th class="span3">Nama </th>
                                  <th class="span1">Qty </th>
                                  <th class="span2" style="text-align: right; padding-right:50px;">Harga Satuan </th>
                                  <th class="span2" style="text-align: right; padding-right:50px;">Sub Total </th>
                                  <th class="span1"></th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php $no =1; $tot = 0;?>
                            @if($partitems)
                             
                              @foreach($partitems as $item)
                              <?php $partdetail = Sparepart::find($item->sparepart_id); ?>
                              <tr id="row_{{ $item->id }}">
                                  <td>{{ $no }}</td>
                                  <td>{{ $partdetail->part_number }}</td>
                                  <td>{{ $partdetail->name_sparepart }}</td>
                                  <td>{{ $item->qty }}</td>
                                  <td style="text-align: right; padding-right:50px;">{{ number_format($item->price, 2, ',', '.') }}</td>
                                  <td style="text-align: right; padding-right:50px;">{{ number_format(($item->price * $item->qty), 2, ',', '.') }}</td>
                                  <td><a rel="{{ $item->id }}" class="delete_toggler btn btn-mini btn-danger"><i class="icon icon-white icon-remove"></i></a></td>
                              </tr>
                              <?php $no++;  $tot = $tot + ($item->price * $item->qty); ?>
                              @endforeach
                            @else
                              <tr>
                                <td colspan="7">Part item is empty.</td>
                              </tr>
                            @endif
                            </tbody>
                            <tfoot style="border-top: double 2px;">
                              <tr> 
                                  <th class="span1"></th>
                                  <th class="span2"></th>
                                  <th class="span3"></th>
                                  <th class="span1"></th>
                                  <th class="span2" style="text-align: right; padding-right:50px;">Grand Total :</th>
                                  <th class="span2" style="text-align: right; padding-right:50px;">{{ number_format($tot, 2, ',', '.') }}</th>
                                  <th class="span1"></th>
                              </tr>
                            </tfoot>
                          </table>
        </div>
    </div>
    
</div>	
	

@endsection

@section('otherscript')
<script type="text/javascript">
var rootURL = '{{ URL::base().'/warehouses' }}';

$(function () {
  $('.money').money_field({width: 120});
});

$('#fleetinfo').click(function() {
  var url = rootURL + '/fleetinfo/'+ {{ $wo->fleet_id }};
  window.open( url, "Detail Info Fleet", "width=500,toolbar=1,resizable=1,scrollbars=yes,height=430,top=100,left=100" );
  return false;
});


var wo_id_inpart = '{{ $wo_id_initem }}';
 $('.delete_toggler').each(function(index,elem) {
          $(elem).click(function(){
            var id = $(elem).attr('rel');
            
            var r=confirm("Anda yakin akan menghapus item ini?")
            if (r==true)
              {
                $.get( rootURL + '/part_item_remove/' + id + '/' + wo_id_inpart);
                $("#row_" + id).remove();
              }
            
          });
      });
</script>
@endsection

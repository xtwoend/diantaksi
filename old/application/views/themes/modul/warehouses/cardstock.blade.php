@layout('themes.layouts.common')

@section('header')
  {{ HTML::style('themes/lib/jquerytable/css/demo_table.css'); }}
  <div class="header">
        <h1 class="page-title">Kartu Kontrol Sparepart</h1>
  </div>
        
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span  class="divider">/</span></li>
        <li class="active">Kartu Kontrol Sparepart</a></li>
    </ul>
@endsection
  
  
@section('content')

	<div class="block">
        <div class="block-heading">
            <a href="#widgetGroup1" data-toggle="collapse">Sparepart Info</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup1">
         <br>

      <div class="form-horizontal">
        <div class="control-group">
          <label class="control-label" for="part_number">Nomor Sparepart</label>
          <div class="controls">
              <div class="input-append span12">
                  <input id="part_number" name="part_number" type="text" placeholder="Ketikan Nomor Part" >
                  <button class="btn" type="button" id="cari">Cari</button>
              </div>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="name_sparepart">Nama Sparepart</label>
          <div class="controls">
            <input type="text" readonly="readonly"  id="name_sparepart">
          </div>
        </div>
        
        <div class="control-group">
          <label class="control-label" for="sale_price">Harga Jual</label>
          <div class="controls">
            <input type="text" readonly="readonly"  id="sale_price">
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="qty">Stock Awal</label>
          <div class="controls">
            <input type="text" readonly="readonly"  id="qty">
          </div>
        </div>
      
        <div class="control-group">
          <label class="control-label" for="isi_satuan">Isi Satuan</label>
          <div class="controls">
            <input type="text" readonly="readonly"  id="isi_satuan">
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="satuan">Satuan</label>
          <div class="controls">
            <input type="text" readonly="readonly"  id="satuan">
          </div>
        </div>

      </div>
          <br>
        </div>
</div>
<div class="block">
        <div class="block-heading">
            <a href="#widgetGroup2" data-toggle="collapse">Sparepart Info</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup2">
         
         <br>

            <table class="table table-condensed table-striped" id="example">
                        <thead>
                          <tr>
                            <th class="span1">No.</th>
                            <th>Tanggal</th>
                            <th>Nomor WO</th>
                            <th>Body</th>
                            <th>Qty</th>
                            <th>Satuan</th>
                          </tr>
                        </thead>
                        <tbody >

                        </tbody>
            </table>
            <br>
        </div>
</div>

@endsection

@section('otherscript')
{{ HTML::script('themes/lib/jquerytable/js/jquery.dataTables.min.js'); }}
<script type="text/javascript">
$(function() {
  $('#name_sparepart').val();
})

$('#cari').click(function(){
  searchdata($('#part_number').val());
  return false;
});

function searchdata(part){
  $.ajax({
    type: 'POST',
    url: '{{ URL::to('warehouses/stockspart') }}',
    dataType: "json",
    data: {part_number: part},
    success: function(data){
      //console.log(data);
      if(data.status===0) alert('nomor part tidak di ada di catalog gudang pool');
      renderinfo(data.data);
        $('#example').dataTable( {
           "aaData": data.aaData,
           "bDestroy": true
        });
    }
  });

  function renderinfo(data){
    $('#name_sparepart').val(data.name_sparepart);
    $('#sale_price').val(data.sale_price);
    $('#qty').val(data.qty);
    $('#isi_satuan').val(data.isi_satuan);
    $('#satuan').val(data.satuan);
  }
}

</script>
@endsection

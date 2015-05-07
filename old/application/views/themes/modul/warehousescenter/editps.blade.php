@layout('themes.layouts.common')

@section('header')
	<div class="header">
   			<h1 class="page-title">Penerimaan Barang dari suplier</h1>
    </div>
        
    <ul class="breadcrumb">
        <li><a href="">Home</a> <span class="divider">/</span></li>
        <li class="active">Penerimaan Barang</li>
    </ul>
@endsection

@section('content')

<div class="block" id="formspk">
        <div class="block-heading">
            <span class="block-icon pull-right">
              <a href="{{ URL::to('warehousescenter/pppreview/'.$pp->id); }}" id="cetak"><i class="icon-print"></i> Cetak PP</a>
            </span>
            <a href="#widget-info" data-toggle="collapse">Form Penerimaan Barang</a>
        </div>
        <div class="block-body collapse in" id="widget-info">
          <br>
          <div class="row-fluid"> <!-- Start pembagian kolom -->
            <form action="POST" class="form-horizontal">
              <div class="span6">
                
                  <div class="control-group">
                    <label class="control-label" for="pp_number">Nomor RR</label>
                    <div class="controls">
                      <input type="hidden" id="pp_id" readonly value="{{ $pp->id }}">
                      <input type="text" id="pp_number" placeholder="No PP" value="{{ $pp->no_doc }}">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="date">Terima Dari</label>
                    <div class="controls">
                      <input type="text" placeholder="No RR" value="{{ Pool::find(Auth::user()->pool_id)->pool_name }}" readonly>
                    </div>
                  </div>
                
                  <div class="control-group">
                    <label class="control-label" for="date">Tanggal Terima</label>
                    <div class="controls">
                      <div class="input-append date" id="startdate" data-date="{{ $pp->tanggal_order }}" data-date-format="yyyy-mm-dd">
                        <input name="tanggal_order" class="input-small" id="tanggal_order" type="text" value="{{ $pp->tanggal_order }}">
                        <span class="add-on"><i class="icon-calendar"></i></span>
                      </div>
                    </div>
                  </div>

              </div>
              <div class="span6">
                 
                    Catatan: <br>
                      <textarea rows="4" style="width:97%;" id="catatan">{{ $pp->catatan }}</textarea>
                  <button id="savepp" class="btn btn-primary">Simpan</button>
              </div>               
              </form>
          </div>  <!-- end pembagian kolom -->
          <br>
        </div>
      </div>
</div>

<div id="formadd">
   	  <div class="block">
                        <div class="block-heading">
                            
                            <a>Input Sparepart </a>
                        </div><form class="form-horizontal">
                        <div class="block-body">
                          <div class="control-group">
                            <label class="control-label" for="part_number">Nomor Part</label>
                            <div class="controls">
                              <input id="part_id" type="hidden" autocomplete="off">
                              <div class="input-append">
                                <input class="span3" tabindex="1" id="part_number" type="text" autocomplete="off" placeholder="Ketikan Nomor Part Disini">
                                <button class="btn" type="button" id="cari">Cari</button>
                              </div>
                              
                              - <input class="span4" id="part_name" type="text" readonly>
                            </div>
                          </div>

                          <div class="control-group">
                            <label class="control-label" for="qty">Jumlah</label>
                            <div class="controls">
                              <input class="span3" tabindex="2" id="qty" type="text" placeholder="Qty" value="1">
                            </div>
                          </div>

                          <div class="control-group">
                            <label class="control-label" for="ket">Keterangan</label>
                            <div class="controls">
                              <input style="width:97%;" tabindex="3" id="ket" type="text" placeholder="Keterangan" value="">
                            
                            </div>
                          </div>

                          <div class="control-group">
                            <label class="control-label" for="part_number"></label>
                            <div class="controls">
                              <button class="btn" tabindex="4" type="button" id="addpart">Add</button>
                            </div>
                          </div>

                          </form>

                          <div id="partitemlist"></div>
                          
                        </div>
                    </div>
</div>

@endsection

@section('otherscript')
<script type="text/javascript">
  var rootURL = '{{ URL::base().'/warehousescenter' }}';
  var pp_id = $('#pp_id').val();
  
  refreshitem();
  
  $(function () { 
        //$('#formadd').css("display","none");
        $('#startdate').datepicker({
              format: 'yyyy-mm-dd'
          });
        $('#enddate').datepicker({
              format: 'yyyy-mm-dd'
          });
        $('#part_number').typeahead({
                             
                source: 
                    function (query, process) {
                        $.getJSON( rootURL + "/sparepart", { query: query }, function(json) {    
                              objects = [];
                              map = {};
                              $.each(json, function(i, object){
                                map[object.part_number] = object;
                                objects.push(object.part_number);
                              });
                              process(objects);
                        });
                    },
                    updater: function(item){
                      $('#part_id').val(map[item].id);
                      $('#part_name').val(map[item].name_sparepart);
                      return item; 
                    }, 
                    highlighter: function (item) {
                      var desc = map[item].name_sparepart;
                      var query = this.query.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, '\\$&');
                      var value = item.replace(new RegExp('(' + query + ')', 'ig'), function ($1, match) {
                        return '<strong>' + match + '</strong>'
                      });
                      return value + '  ( ' + desc + ' )' ;
                    },
                   
                    minLength: 2
            });

        // fungsi tab index & default payment
        $('input').bind('keypress', function(eInner) {
            if (eInner.keyCode == 13) //if its a enter key
            {   
                var tabindex = $(this).attr('tabindex');
                
                tabindex++; //increment tabindex
                $('[tabindex=' + tabindex + ']').focus();            
                
                return false;
            }
        });       
  });
  
  
  $('#savepp').click(function(){
    savepp();
    return false;
  });
  
  function savepp() {
    var dataJSON = JSON.stringify({
          "id": $('#pp_id').val(),
          "pp_number": $('#pp_number').val(),
          "tanggal_order": $('#tanggal_order').val(),
          "tanggal_terima": $('#tanggal_terima').val(),
          "supplier_id": $('#supplier_id').val(),
          "status": $('#status').val(),
          "catatan": $('#catatan').val(),
          });

        console.log('Update PP');
        $.ajax({
          type: 'POST',
          contentType: 'application/json',
          url: rootURL + '/editpp',
          dataType: "json",
          data: dataJSON,
          success: function(data){
             alert(data.msg);
          },
          error: function(jqXHR, textStatus, errorThrown){
               alert(textStatus);
          } 
        });
  }
  //add sparepart button click 
 
  $('#addpart').click(function(){
    addPartCart();
    return false;
  });

  
  function refreshitem(){
    $('#partitemlist').load( rootURL + '/partitemps/' + rr_id);
  }

  function addPartCart(){
        var dataJSON = JSON.stringify({
          "part_number": $('#part_number').val(),
          "rr_id": $('#rr_id').val(),
          "qty": $('#qty').val(),
          "ket": $('#ket').val(),
          });

        console.log('Add sparepart number: ' + $('#part_number').val());
        $.ajax({
          type: 'POST',
          contentType: 'application/json',
          url: rootURL + '/addpartps',
          dataType: "json",
          data: dataJSON,
          success: function(data){
             if(data.status == 'ok')
             {
                $('#partitemlist').load( rootURL + '/partitemps/' + rr_id);
             }else{
                alert('data tidak temukan');
             }

             $('#part_id').val('');
             $('#part_number').val('').focus();
             $('#part_name').val('');
             $('#ket').val('');
          },
          error: function(jqXHR, textStatus, errorThrown){
               alert(textStatus);
          } 
        });
  }


  $('#cari').click(function(){
    var url = rootURL + '/searchpart';
    window.open( url, "Search Sparepart", "width=500,toolbar=1,resizable=1,scrollbars=yes,height=430,top=100,left=100" );
    return false;
  });



</script>
@endsection
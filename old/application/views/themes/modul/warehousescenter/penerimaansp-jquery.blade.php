@layout('themes.layouts.common')

@section('header')
	<div class="header">
   			<h1 class="page-title">Penerimaan Barang</h1>
    </div>
        
    <ul class="breadcrumb">
        <li><a href="">Home</a> <span class="divider">/</span></li>
        <li class="active">Penerimaan Barang</li>
    </ul>
@endsection

@section('content')
      <div class="block" id="formspk" >
          <div class="block-heading">
              <a href="#widget-info" data-toggle="collapse">Form Penerimaan Spare Part</a>
          </div>
          <div class="block-body collapse in" id="widget-info">
            <br>
            <div class="row-fluid"> <!-- Start pembagian kolom -->
              <form class="form-horizontal">
                <div class="span6">
                    
                     <div class="control-group">
                      <label class="control-label" for="pp_number">Nomor PP</label>
                      <div class="controls">
                        <div class="input-append">
                          <input class="span11" id="pp_number" type="text">
                          <input type="hidden" id="pp_id" readonly>
                          <button class="btn" id="btnSearch" type="button"><i class="icon-search"></i></button> 
                        </div> 
                      </div>
                    </div>

                    <div class="control-group">
                      <label class="control-label" for="rr_number">Nomor RR</label>
                      <div class="controls">
                        <input type="hidden" id="rr_id" readonly>
                        <input type="text" id="rr_number" placeholder="No RR" readonly>
                      </div>
                    </div>

                     <div class="control-group">
                      <label class="control-label" for="date">Nomor Nota </label>
                      <div class="controls">
                        <input type="text" id="nota_number" placeholder="Nomor Nota" >
                      </div>
                    </div>

                    <div class="control-group">
                      <label class="control-label" for="date">Tanggal Terima</label>
                      <div class="controls">
                        <div class="input-append date" id="startdate" data-date="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd">
                          <input name="tanggal_terima" class="input-small" id="tanggal_terima" type="text" value="{{ date('Y-m-d') }}">
                          <span class="add-on"><i class="icon-calendar"></i></span>
                        </div>
                      </div>
                    </div>

                    <div class="control-group">
                      <label class="control-label" for="date">Terima Dari </label>
                      <div class="controls">
                      	{{ Form::select('id_supplier', $suppliers, '', array('id'=>'supplier_id')) }}
                      </div>
                    </div>
                    
                    <div class="control-group">
                      <label class="control-label" for="date">Yang Menerima</label>
                      <div class="controls">
                        <input type="text" id="pool_id" placeholder="Pool" value="{{ Pool::find(Auth::user()->pool_id)->pool_name }}">
                      </div>
                    </div>
              
                </div>
                <div class="span6">
                  
                      Catatan: <br>
                      <textarea rows="4" style="width:97%;" id="catatan"></textarea>
                      <button id="createrr" class="btn btn-primary">Buat</button>
                </div>  

                </form>
                
            </div>  <!-- end pembagian kolom -->

            <br>
          </div>
        </div>
                    <div class="block hide">
                          <div class="block-heading">
                              <span class="block-icon pull-right">
                                <button class="btn btn-primary" id="preview"><i class="icon-print"></i> PP Priview </button>
                              </span>
                              <a>Input Sparepart </a>
                          </div><form class="form-horizontal">
                          <div class="block-body">
                            <div class="control-group">
                              <label class="control-label" for="part_number">Nomor Part</label>
                              <div class="controls">
                                <input id="part_id" type="hidden" autocomplete="off">
                                <div class="input-append">
                                  <input class="span9" tabindex="1" id="part_number" type="text" autocomplete="off" placeholder="Ketikan Nomor Part Disini">
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
                                <input class="span7" tabindex="3" id="ket" type="text" placeholder="Keterangan" value="">
                              
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

@endsection


@section('otherscript')
<script type="text/javascript">
	var rootURL = '{{ URL::base().'/warehousescenter' }}';
  var rr_id = $('#rr_id').val();

  $(function () { 
        $('.hide').css("display","none");
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

    function generadenumber(){
      console.log('Get Number PP');
          $.ajax({
            type: 'GET',
            url: rootURL + '/NumberRR',
            dataType: "json", // data type of response
            success: function(data){
              $('#rr_number').val(data.number);
            }
          });
    }

    
    $('#createrr').click(function(){
      createrr();
      return false;
    });
    
    $('#btnSearch').click(function(){
      caripp();
      return false;
    });

    $('#preview').click(function(){
      var url = rootURL + '/rrpreview/' + rr_id ;
      window.open( url );
      return false;
    });

    function caripp() {
      var nomorpp = $('#pp_number').val();
      console.log('pencarian nomor pp dengan nomor pp');
      console.log(nomorpp);

      $.ajax({
            type: 'GET',
            contentType: 'application/json',
            url: rootURL + '/infopp',
            dataType: "json",
            data: {nomorpp: nomorpp},
            success: function(data){
               if(data.status){
                  console.log(data);
                  generadenumber();
                  $('#pp_id').val(data.data.id);
               }else{
                alert('nomor pp tidak di temukan');
               }
            },
            error: function(jqXHR, textStatus, errorThrown){
                 alert(textStatus);
            } 
      });

    }

    function createrr() {
      var dataJSON = JSON.stringify({
            "rr_number": $('#rr_number').val(),
            "reguest_sparepart_id": $('#pp_id').val(),
            "nota_number": $('#nota_number').val(),
            "tanggal_terima": $('#tanggal_terima').val(),
            "supplier_id": $('#supplier_id').val(),
            //"status": $('#status').val(),
            "catatan": $('#catatan').val(),
            });

          console.log('Create PP');
          $.ajax({
            type: 'POST',
            contentType: 'application/json',
            url: rootURL + '/ps',
            dataType: "json",
            data: dataJSON,
            success: function(data){
               console.log(data);
               if(data.status)
               {
                  $('.hide').css("display","block");
                  $('#rr_id').val(data.id);
                  rr_id = $('#rr_id').val();
               }
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


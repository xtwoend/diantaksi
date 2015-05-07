@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Analisa Bengkel</h1>
  </div>
        
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li><a href="{{URL::to('workshops')}}">workshops</a> <span class="divider">/</span></li>
        <li class="active">analisa kerusakan</a></li>
    </ul>
@endsection
  
  
@section('content')

@if(Session::has('status'))
<div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{ Session::get('status'); }}
</div>
@endif
{{ Form::open('workshops/analisasave', 'POST', array('class'=>'form-horizontal')) }}
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
              <div class="span6">

                   <div class="control-group">
                    <label class="control-label" for="body">Nomor Body</label>
                    <div class="controls"> <input type="hidden" id="wo_id" name="wo_id" value="{{ $wo->id }}">
                      <input type="hidden" id="part_id">
                      : <strong>{{ Fleet::find($wo->fleet_id)->taxi_number }}</strong>
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
                    <label class="control-label" for="pool"></label>
                    <div class="controls">
                      
                    </div>
                  </div>

              </div>
              <div class="span6">
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
                    <label class="control-label" for="woNumber">Status Perbaikan</label>
                    <div class="controls">
                      : {{ Form::select('status', $statusoptions , $wo->status) }}
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="woNumber">Oleh Mekanik</label>
                    <div class="controls">
                      : {{ Form::text('mechanic', $wo->mechanic); }}
                    </div>
                  </div>

              </div>
          </div>  <!-- end pembagian kolom -->
            <div class="row-fluid">
                <div class="span6">
                    <div class="block">
                        <div class="block-heading">
                            <a>Keluhan Kerusakan</a>
                        </div>
                        <div class="block-body">
                         	<textarea rows="10" style="width:97%;" id="complaint" name="compalaint">{{ $wo->complaint }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="span6">
                    <div class="block">
                        <div class="block-heading">
                            <a>Keterangan</a>
                        </div>
                        <div class="block-body">
                         	<textarea rows="10" style="width:97%;" id="information_complaint" name="information">{{ $wo->information_complaint }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid"><!-- add item part -->
              <div class="span6">
                    <div class="block">
                        <div class="block-heading">
                            <a>Analisa Perbaikan</a>
                        </div>
                        <div class="block-body">
                          <div class="input-append span12">
                            <input class="input-xlarge" id="analisa" type="text" placeholder="Masukan Analisa Kerusakan">
                            <button class="btn" type="button" id="addanalis">Add</button>
                          </div>

                          <div id="analisitemlist"></div>
                          <!--
                          <table class="table table-condensed table-hover"> 
                            <tr> 
                             <td><input type="text" name="analisa[]" class="span12" value=""/></td>  
                             <td><a class="delRow btn btn-mini btn-danger" href="javascript:void(0)"><i class="icon-minus icon-white"></i></a></td> 
                            </tr> 
                            <tr> 
                             <td colspan="2">
                             <a class="addRow btn btn-mini btn-info" href="javascript:void(0)" id="1"><i class="icon-plus icon-white"></i></a>  
                             </td> 
                            </tr> 
                          </table> 
                          --><br><br>
                        </div>
                    </div>
                </div>
                <div class="span6">
                    <div class="block">
                        <div class="block-heading">
                            <span class="block-icon pull-right">
                              <!-- <button class="btn btn-mini btn-info" id=""><i class="icon-check icon-white"></i></button>-->
                              <!--  <button class="btn btn-mini btn-info" id="clearitem"><i class="icon-trash icon-white"></i></button> -->
                            </span>
                            <a>Sparepart </a>
                        </div>
                        <div class="block-body">
                          
                          <div class="input-append">
                            <input class="span7" id="part_number" type="text" placeholder="Ketikan Nomor Part Disini">
                            <input class="span2" id="qty" type="text" placeholder="Qty" value="1">
                            <button class="btn" type="button" id="addpart">Add</button>
                            <button class="btn" type="button" id="cari">Cari</button>
                          </div>
                          Harga Satuan : <input class="span8" id="price" type="text" placeholder="price" value="">
                          <div id="partitemlist"></div>
                          
                        </div>
                    </div>
                </div>

            </div>
          <br>
        </div>
</div>
{{ Form::close() }}
@endsection

@section('otherscript')
<script type="text/javascript">
  var rootURL = '{{ URL::base().'/workshops' }}';
  var wo_id = $('#wo_id').val();
  refreshitem();
  $(function () { 
       // $(".addRow").btnAddRow();   
        //$(".delRow").btnDelRow();
         /* 
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
                      //alert('Your Selected ID' + map[item].id );
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

            });*/
        $('#part_number').bind('keypress', function(eInner) {
            if (eInner.keyCode == 13) //if its a enter key
            {         
                addPartCart();
                return false;
            }
        });

        $('#analisa').bind('keypress', function(eInner) {
            if (eInner.keyCode == 13) //if its a enter key
            {         
                addAnalisa();
                return false;
            }
        });
  });

  
  //add sparepart button click 
  $('#addanalis').click(function(){
    addAnalisa();
    return false;
  });
  $('#addpart').click(function(){
    addPartCart();
    return false;
  });

  $('#cari').click(function(){
    var url = rootURL + '/searchpart';
    window.open( url, "Search Sparepart", "width=500,toolbar=1,resizable=1,scrollbars=yes,height=430,top=100,left=100" );
    return false;
  });

  function refreshitem(){
    $('#partitemlist').load( rootURL + '/partitem/' + wo_id);
    $('#analisitemlist').load( rootURL + '/analisitem/' + wo_id);
  }

  function addPartCart(){
        var dataJSON = JSON.stringify({
          "part_number": $('#part_number').val(),
          "wo_id": $('#wo_id').val(),
          "qty": $('#qty').val(),
          "price": $('#price').val(),
          });

        console.log('Add sparepart number: ' + $('#part_number').val());
        $.ajax({
          type: 'POST',
          contentType: 'application/json',
          url: rootURL + '/addpart',
          dataType: "json",
          data: dataJSON,
          success: function(data){
             if(data.status == 'ok')
             {
              $('#partitemlist').load( rootURL + '/partitem/' + wo_id);
             }else{
              alert('part tidak temukan');
             }
             $('#part_id').val('');
             $('#part_number').val('').focus();
          },
          error: function(jqXHR, textStatus, errorThrown){
               alert(textStatus);
          } 
        });
  }

  function addAnalisa()
  {
    var dataJSON = JSON.stringify({
          "analisa": $('#analisa').val(),
          "wo_id": $('#wo_id').val(),
          });

        console.log('Add sparepart number: ' + $('#part_number').val());
        $.ajax({
          type: 'POST',
          contentType: 'application/json',
          url: rootURL + '/addanalis',
          dataType: "json",
          data: dataJSON,
          success: function(data){
             if(data.status == 'ok')
             {
                $('#analisitemlist').load( rootURL + '/analisitem/' + wo_id);
                $('#analisa').val('').focus();
             }else{
                alert('error');
             }
          },
          error: function(jqXHR, textStatus, errorThrown){
               alert(textStatus);
          } 
        });
  }

</script>
@endsection
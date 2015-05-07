@layout('themes.layouts.common')

@section('header')
    <div class="header">
          <h1 class="page-title">Pemeriksaan Check-In</h1>
    </div>
    
    
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li class="active">Check In</a> 
    </ul>

@endsection
  
  
@section('content')

<div class="block">
        <div class="block-heading">
            <a href="#widgetGroup1" data-toggle="collapse">Tanggal Operasi</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup1">
         <br>
              <div class="form-inline">
                <div class="input-append date" id="datepicker" data-date="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd">
                      <input name="date" id="date" class="input-small" id="tanggal" type="text" value="{{ date('Y-m-d') }}">
                      <span class="add-on"><i class="icon-calendar"></i></span>
                </div>
                  <button class="btn btn-info" id="viewsfleetCheckouts"><i class="icon-search"></i></button>
              </div>
          <br>
        </div>
</div>

<div class="row-fluid">
  <div class="span3">
    <div class="block">
        <span class="block-heading">
          <a>
            <div class="input-append">
              <input class="span6" id="searchKey" type="text">
              <button class="btn" id="btnSearch" type="button"><i class="icon-search"></i></button>
            </div> 
          </a>
        </span>
        <div class="block-body collapse in" id="widget-listArmada">
            <div class="leftArea">
              <ul id="armadaOnCheckins" class="nav nav-list"></ul>
            </div>
        </div>
    </div>

  </div>
  <div class="span9">
    <div class="block">
        <div class="block-heading">
            <span class="block-icon pull-right" id="checkinstep2">
              <button  class="btn btn-info" id="btnSave" >Simpan <i class="icon-hdd"></i></button>
            </span>
            <a href="#widget-info" data-toggle="collapse">Fleet Check In Status </a>
        </div>
        <div class="block-body collapse in" id="widget-info">
          <br>
          <div class="tabbable">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab1" data-toggle="tab">Check in Fleet</a></li>
              <li><a href="#tab2" data-toggle="tab">Dokumen</a></li>
              <li><a href="#tab3" data-toggle="tab">Kerapihan</a></li>
              <li><a href="#tab4" data-toggle="tab">Perlengkapan</a></li>
              <li><a href="#tab5" data-toggle="tab">Pemeriksaan</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab1">
                <input type="hidden" id="id" name="id">
                <input type="hidden" id="checkinid" name="checkinid">
                <table class="table table-condensed table-striped">
                  <tr>
                    <td>Pool </td>
                    <td><input type="text" id="pool" name="pool" disabled></td>
                  </tr>
                  <tr>
                    <td>Nomor Body</td>
                    <td><input type="text" id="taxi_number" name="taxi_number" disabled></td>
                  </tr>
                  <tr>
                    <td>Pengemudi</td>
                    <td><input type="text" id="name" name="name" disabled></td>
                  </tr>
                  <tr>
                    <td>Status</td>
                    <td><input type="text" id="status" name="status" disabled></td>
                  </tr>
                  <!--
                  <tr>
                    <td>Status</td>
                    <td>
                        <div class="btn-group" data-toggle="buttons-radio">
                          <button type="button" class="btn btn-warning" name="statusops" id="ok" value="1">OK</button>
                          <button type="button" class="btn btn-warning" name="statusops" id="bl" value="7">BL</button>
                          <button type="button" class="btn btn-warning" name="statusops" id="bp" value="3">BP</button>
                          <button type="button" class="btn btn-warning" name="statusops" id="tl" value="4">TL</button>
                          <button type="button" class="btn btn-warning" name="statusops" id="tp" value="2">TP</button>
                          <button type="button" class="btn btn-warning" name="statusops" id="ll" value="6">LL</button>
                        </div> 
                    </td>
                  </tr>
                -->
                  <tr>
                    <td>Ordo Meter Fleet</td>
                    <td><input type="text" id="kmfleet" name="kmfleet" required></td>
                  </tr>
                  <tr>
                    <td>RIT</td>
                    <td><input type="text" id="rit" name="rit" required></td>
                  </tr>
                  <tr>
                    <td>Income KM</td>
                    <td><input type="text" id="incomekm" name="incomekm" required></td>
                  </tr>
                  <tr>
                    <td>Check In Time</td>
                    <td><input type="text" id="checkin_time" name="checkin_time" disabled></td>
                  </tr>
               </table>
               <div id="checkinstep1"><button class="btn btn-info pull-right" id="checkinstep1">Chekin Fleet <i class="icon-chevron-right"></i></button></div>
              <br>
              <br>
              </div>
               {{-- Check document --}}
              <div class="tab-pane" id="tab2">
                <form id="docsForm">
                <table class="table table-condensed table-striped">
                  @foreach($docs as $doc)
                  <tr>
                    <td>
                      <label class="checkbox inline span10">
                          <input type="checkbox" name="std_docs[]" id="doc_{{$doc->id}}" onclick='changeClass(this.checked,{{$doc->id}});' value="{{$doc->id}}"> {{ $doc->std_doc }}
                      </label>
                    </td>
                    <td><input type="text" name="doc_ket[]" id="doc_ket_{{$doc->id}}"></td>
                  </tr>
                  @endforeach
                </table>
                </form>
              </div>
              {{-- end document --}}
              {{-- Check pengemudi --}}
              <div class="tab-pane" id="tab3">
                <form id="neatsForm">
                <table class="table table-condensed table-striped">
                  @foreach($neats as $neat)
                  <tr>
                    <td>
                      <label class="checkbox inline span4">
                          <input type="checkbox" name="std_neats[]" id="neat_{{$neat->id}}" data-rel="{{$neat->id}}"> {{ $neat->std_neat }}
                      </label>
                    </td>
                  </tr>
                  @endforeach
                </table>
                </form>
              </div>
              {{-- end pengemudi --}}

              {{-- Check armada --}}
              <div class="tab-pane" id="tab4">
                <form id="equipsForm">
                <table class="table table-condensed table-striped">
                  @foreach($equips as $equip)
                  <tr>
                    <td>
                      <label class="checkbox inline span4">
                          <input type="checkbox" name="std_equips[]" id="equip_{{$equip->id}}" data-rel="{{$equip->id}}"> {{ $equip->std_equip }}
                      </label>
                    </td>
                  </tr>
                  @endforeach
                </table>
                </form>
              </div>
              {{-- end Fisik --}}

              {{-- Check fisik armada --}}
              <div class="tab-pane" id="tab5">
                <div class="tabbable tabs-left">
                  <ul class="nav nav-tabs">
                      <li><a href="#subhasil" data-toggle="tab">Keputusan Hasil</a></li>
                      @foreach($categories as $categorie)
                      <li><a href="#subtab{{$categorie->id}}" data-toggle="tab">{{ $categorie->sp_category}}</a></li>
                      @endforeach
                  </ul>
                  <div class="tab-content">
                        <div class="tab-pane" id="subhasil">
                          <div class="btn-group" data-toggle="buttons-radio">
                            <button type="button" class="btn btn-warning" name="hasilcheckfisik" id="kondisi_ok" value="1">KONDISI BAIK</button>
                            <button type="button" class="btn btn-warning" name="hasilcheckfisik" id="butuh_perbaikan" value="2">PERLU PERBAIKAN</button>
                          </div> 
                        </div>
                        <p>&nbsp;</p> 
                        <button class="btn btn-primary" id="checkall"> Check All</button>
                        <button class="btn btn-primary" id="uncheckall"> UnCheck All</button>
                      @foreach($categories as $categorie)
                        <div class="tab-pane" id="subtab{{$categorie->id}}">
                          <form id="spForm">
                                <table class="table table-condensed table-striped">
                                  @foreach( Stdfleet::where_sp_categories_id($categorie->id)->get() as $sp)
                                  <tr>
                                    <td>
                                      <label class="checkbox inline span10">
                                          <input type="checkbox" name="check_sp[]" id="sp_{{$sp->id}}" onclick='changeSp(this.checked,{{$sp->id}});' value="{{$sp->id}}"> {{ $sp->name_sparepart }}
                                      </label>
                                    </td>
                                    <td><input type="text" name="ket_sp[]" id="ket_{{$sp->id}}"></td>
                                  </tr>
                                  @endforeach
                                </table>
                          </form>
                        </div>
                      @endforeach  
                              
                  </div>
                </div>
              </div>
              {{-- end check Fisik --}}
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
<!--

-->
@endsection

@section('otherscript')
<script type="text/javascript">
      var rootURL = '{{ URL::base().'/checkins' }}';
     
      var currentFleet;

      $(function () {
              $('#datepicker').datepicker({
                    format: 'yyyy-mm-dd'
                });
              
              $('#ok').button('toggle');
              $('#kondisi_ok').button('toggle');
      });

      function changeClass(checkbox,i){
            if(checkbox){
              $('#doc_ket_' + i).val('Ada');
            }else{
              $('#doc_ket_' + i).val('');
            }
      }

      function changeSp(checkbox,i) {
            if(checkbox){
              $('#ket_' + i).val('Baik');
            }else{
              $('#ket_' + i).val('');
            }
      }

      function checkall()
      {
          $('form#spForm :input').attr('checked','checked');
          $('form#spForm :input').val('Baik');
      }

      function uncheckall()
      {
          $('form#spForm :input').removeAttr('checked');
          $('form#spForm :input').val('');
      }

      findAll($('#date').val());

      $('#viewsfleetCheckouts').click(function(){
        findAll($('#date').val());
        return false;
      });

      $('#checkall').click(function(){
        checkall();
        return false;
      });

      $('#uncheckall').click(function(){
        uncheckall();
        return false;
      });

      $('#armadaOnCheckins a').live('click', function() {
        findById($(this).data('identity'));
      });

      $('#btnSearch').click(function() {
        search($('#searchKey').val());
        return false;
      });

      $('#btnSave').click(function() {
        if($('#id').val() == '')
        {
          alert('Pilih armada lebih dahulu');
        }else{
          saveCheckinStatus();
        }
        return false;
      });

      $('#checkinstep1').click(function(){
        if($('#kmfleet').val() == '') {
          alert ('Km Kendaraan tidak boleh kosong');
        }else{
          checkinfleet();
        }
        return false;
      });

      function search(searchKey) {
        if (searchKey == '') 
          findAll($('#date').val());
        else
          findByName(searchKey);
      }

      function findAll(dateSchedule) {
        console.log('findAll');
        $.ajax({
          type: 'GET',
          url: rootURL + '/allfleetCheckin/' + dateSchedule,
          dataType: "json", // data type of response
          success: renderList
        });
      }

      function findByName(searchKey) {

        var dataJSON = JSON.stringify({
          "taxi_number": searchKey, 
          "date": $('#date').val(), 
          });

        console.log('findByName: ' + searchKey);
        $.ajax({
          type: 'POST',
          contentType: 'application/json',
          url: rootURL + '/searchChekins',
          dataType: "json",
          data: dataJSON,
          success: renderList 
        });
      }

      function findById(id) {
        console.log('findById: ' + id);
        $.ajax({
          type: 'GET',
          url: rootURL + '/findbyidCheckins/' + id,
          dataType: "json",
          success: function(data){
            $('#btnSimpan').show();
            console.log('findById success: ' + data.taxi_number);
            currentInfo = data;
            renderDetails(currentInfo);
          }
        });
      }

      function renderList(data) {
        // JAX-RS serializes an empty list as null, and a 'collection of one' as an object (not an 'array of one')
        var list = data == null ? [] : (data.fleets instanceof Array ? data.fleets : [data.fleets]);
        $('#armadaOnCheckins li').remove();
        $.each(list, function(index, fleet) {
          $('#armadaOnCheckins').append('<li><a href="#" data-identity="' + fleet.id + '">'+fleet.taxi_number+'</a></li>');
        });
      }

      function renderDetails(info) {
        var driver = info.name + ' ( ' + info.nip + ' ) ';
        var fleet  = info.taxi_number + ' ( ' + info.police_number + ' ) ';
        
        if(info.checkin){
          $('#kmfleet').attr('disabled','disabled');
          $('#checkinstep1').css("display","none");
          $('#checkinstep2').removeAttr( 'style' );
          $('#inputcheckinstep1').css("display","none");
          $('form#docsForm :input').removeAttr('checked');
          $('form#docsForm :input').val('');

          $.each(info.std_doc_id, function(index, value) {
              if(value.replace(' ','') === 'Ada'){
                $('#doc_' + index).attr('checked','checked');
                $('#doc_ket_' + index).val(value);
              }else{
                $('#doc_ket_' + index).val(value);
              }
          });

          $('form#spForm :input').removeAttr('checked');
          $('form#spForm :input').val('');

          
          $.each(info.psy_check, function(index, value) {
              if(value.replace(' ','') === 'Baik'){
                $('#sp_' + index).attr('checked','checked');
                $('#ket_' + index).val(value);
              }else{
                $('#ket_' + index).val(value);
              }
          });
          

          $('form#equipsForm :input').removeAttr('checked');
          $.each(info.std_equip_id, function(index, value) {
              $('#equip_' + index).attr('checked','checked');
          });

          $('form#neatsForm :input').removeAttr('checked');
          $.each(info.std_neat_id, function(index, value) {
              $('#neat_' + index).attr('checked','checked');
          });

          $('#checkinid').val(info.checkinid);
          $('#kmfleet').val(info.km_fleet);
          $('#checkin_time').val(info.checkin_time);
          $('#rit').val(info.rit);
          $('#incomekm').val(info.incomekm);
        
          var statusops = {"1":"ok","2":"tp","3":"bp","4":"tl","6":"ll","7":"bl"};
          $.each(statusops, function(i , v) {
            if(info.operasi_status_id == i) 
            { $('#'+v).button('toggle');  }
          })

          if(info.fg_bengkel == 1) {  $('#butuh_perbaikan').button('toggle') }else{ $('#kondisi_ok').button('toggle') };
          
          
        }else{
          $('#kmfleet').removeAttr('disabled');
          $('#rit').removeAttr('disabled');
          $('#incomekm').removeAttr('disabled');
          $('#checkinstep1').removeAttr( 'style' );
          $('#checkinstep2').css("display","none");
          $('#kmfleet').focus();
          $('#kmfleet').val('');
          $('#rit').val('');
          $('#incomekm').val('');
          $('#checkin_time').val('');
        }

        $('#id').val(info.id);
        $('#pool').val(info.pool);
        $('#taxi_number').val(fleet);
        $('#name').val(driver);
        $('#status').val(info.status);

      }

      function saveCheckinStatus()
      { 
        var neatsForm = new Array();
        $("form#neatsForm input:checkbox[name='std_neats\\[\\]']:checked").each(function () {
          neatsForm.push($(this).attr('data-rel'));
        });
        var equipsForm = new Array();
        $("form#equipsForm input:checkbox[name='std_equips\\[\\]']:checked").each(function () {
          equipsForm.push($(this).attr('data-rel'));
        });
        var docsForm = new Array();
        $("form#docsForm input:text[name='doc_ket\\[\\]']").each(function () {
          docsForm.push($(this).attr('value'));
        });
        var spForm = new Array();
        $("form#spForm input:text[name='ket_sp\\[\\]']").each(function () {
          spForm.push($(this).attr('value'));
        });

        var status_ops = $('button[name="statusops"].active').val();
        
        var data = JSON.stringify({
          "id": $('#checkinid').val(), 
          "hasilcheckfisik": $('button[name="hasilcheckfisik"].active').val(),
          "status_ops": status_ops,
          "std_docs": docsForm, 
          "std_neats": neatsForm,
          "std_equips": equipsForm,
          "ket_sp": spForm,
          });

        console.log('saveCheckoutStatus');
        $.ajax({
            type: 'POST',
            contentType: 'application/json',
            url: rootURL + '/saveCheckFisik',
            dataType: "json",
            data: data,
            success: function(data, textStatus, jqXHR){
                alert(data.message);
            },
            error: function(jqXHR, textStatus, errorThrown){
               
            }
        });
      }

      function checkinfleet() {
        var status_ops = $('button[name="statusops"].active').val();
        var data = JSON.stringify({
          "id": $('#id').val(), 
          "km_fleet": $('#kmfleet').val(),
          "rit": $('#rit').val(),
          "incomekm": $('#incomekm').val(),
          "status_ops": status_ops, 
          });
        console.log('Checkin Step 1');
        $.ajax({
            type: 'POST',
            contentType: 'application/json',
            url: rootURL + '/checkinstep1',
            dataType: "json",
            data: data,
            success: function(data, textStatus, jqXHR){
                var data = data.checkin; 
                alert(data.message);
                findById(data.checkoutid);
                console.log(data.message);
            },
            error: function(jqXHR, textStatus, errorThrown){
               
            }
        });
      }
</script>
@endsection

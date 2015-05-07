@layout('themes.layouts.common')

@section('header')
    <div class="header">
          <h1 class="page-title">Pemeriksaan Check-Out</h1>
    </div>    
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li class="active">Check Out</a> 
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
              <ul id="armadaOnCheckouts" class="nav nav-list"></ul>
            </div>
        </div>
    </div>

  </div>
  <div class="span9">
    <div class="block">
        <div class="block-heading">
            <span class="block-icon pull-right">
              <button  class="btn btn-info" id="btnSave">Simpan <i class="icon-hdd"></i></button>
            </span>
            <a href="#widget-info" data-toggle="collapse">Fleet Check Out Status </a>
        </div>
        <div class="block-body collapse in" id="widget-info">
          <br>
          <div class="tabbable">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab1" data-toggle="tab">Info Jadwal</a></li>
              <li><a href="#tab2" data-toggle="tab">Kelengkapan Dokumen</a></li>
              <li><a href="#tab3" data-toggle="tab">Kerapihan Pengemudi</a></li>
              <li><a href="#tab4" data-toggle="tab">Perlengkapan</a></li>
            </ul>
            <div class="tab-content">
              <button class="btn btn-primary" id="checkall"> Check All</button>
                        <button class="btn btn-primary" id="uncheckall"> UnCheck All</button>
              <div class="tab-pane active" id="tab1">
                <table class="table table-condensed table-striped">
                  <input type="hidden" id="id" name="id">
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
                  <tr>
                    <td>Waktu Keluar</td>
                    <td><input type="text" id="checkout_time" name="checkout_time"></td>
                  </tr>
               </table>
              </div>
               {{-- Check document --}}
              <div class="tab-pane" id="tab2">
                <form id="docsForm">
                <table class="table table-condensed table-striped">
                  @foreach($docs as $doc)
                  <tr>
                    <td>
                      <label class="checkbox inline span12">
                          <input type="checkbox" name="std_docs[]" id="doc_{{$doc->id}}" onclick='changeClass(this.checked,{{$doc->id}});' value="{{$doc->id}}"> {{ $doc->std_doc }}
                      </label>
                    </td>
                    <td><input type="text" name="doc_ket[]" id="doc_ket_{{$doc->id}}"></td>
                  </tr>
                  @endforeach
                </table>
                </form>
              </div>
              {{-- Check pengemudi --}}
              <div class="tab-pane" id="tab3">
                <form id="neatsForm">
                <table class="table table-condensed table-striped">
                  @foreach($neats as $neat)
                  <tr>
                    <td>
                      <label class="checkbox inline span4">
                          <input type="checkbox" name="std_neats[]" id="neat_{{$neat->id}}" data-rel="{{$neat->id}}" > {{ $neat->std_neat }}
                      </label>
                    </td>
                  </tr>
                  @endforeach
                </table>
                </form>
              </div>
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
            </div>
          </div>
        </div>
      </div>
    </div>
</div>



@endsection

@section('otherscript')
<script type="text/javascript">
      var rootURL = '{{ URL::base().'/checkouts' }}';
      var currentFleet;

      $(function () {
              $('#datepicker').datepicker({
                    format: 'yyyy-mm-dd'
                });
      });

      function changeClass(checkbox,i){
            if(checkbox){
              $('#doc_ket_' + i).val('Ada');
            }else{
              $('#doc_ket_' + i).val('');
            }
      }

      findAll($('#date').val());

      $('#viewsfleetCheckouts').click(function(){
        findAll($('#date').val());
        return false;
      });

      $('#armadaOnCheckouts a').live('click', function() {
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
          saveCheckoutStatus();
          findAll($('#date').val());
        }
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
      function checkall()
      {
          $('form :input').attr('checked','checked');
          $('form :input').val('Ada');
      }

      function uncheckall()
      {
          $('form :input').removeAttr('checked');
          $('form :input').val('');
      }
      
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
          url: rootURL + '/allfleetCheckouts/' + dateSchedule,
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
          url: rootURL + '/searchChekouts',
          dataType: "json",
          data: dataJSON,
          success: renderList 
        });
      }

      function findById(id) {
        console.log('findById: ' + id);
        $.ajax({
          type: 'GET',
          url: rootURL + '/findbyidCheckouts/' + id,
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
        $('#armadaOnCheckouts li').remove();
        $.each(list, function(index, fleet) {
          $('#armadaOnCheckouts').append('<li><a href="#" data-identity="' + fleet.id + '">'+fleet.taxi_number+'</a></li>');
        });
      }

      function renderDetails(info) {
        var driver = info.name + ' ( ' + info.nip + ' ) ';
        var fleet  = info.taxi_number + ' ( ' + info.police_number + ' ) ';
      
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

        $('form#equipsForm :input').removeAttr('checked');
        $.each(info.std_equip_id, function(index, value) {
            $('#equip_' + index).attr('checked','checked');
        });

        $('form#neatsForm :input').removeAttr('checked');
        $.each(info.std_neat_id, function(index, value) {
            $('#neat_' + index).attr('checked','checked');
        });
      
        $('#id').val(info.id);
        $('#pool').val(info.pool);
        $('#taxi_number').val(fleet);
        $('#name').val(driver);
        $('#status').val(info.status);
        $('#checkout_time').val(info.checkout_time);
      }

      function saveCheckoutStatus()
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

        var data = JSON.stringify({
          "id": $('#id').val(), 
          "std_docs": docsForm, 
          "std_neats": neatsForm,
          "std_equips": equipsForm,
          "checkout_time": $('#checkout_time').val(),
          });

        console.log('saveCheckoutStatus');
        $.ajax({
            type: 'POST',
            contentType: 'application/json',
            url: rootURL + '/saveCheck',
            dataType: "json",
            data: data,
            success: function(data, textStatus, jqXHR){
                var msg = data.message
                alert(msg.message);
                findById(msg.id);
            },
            error: function(jqXHR, textStatus, errorThrown){
               
            }
        });
      }


</script>
@endsection

@layout('themes.layouts.common')

@section('header')
    <div class="header">
          <h1 class="page-title">Schedule</h1>
    </div>
    
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li><a href="{{URL::to('checkouts')}}">Checkouts</a> <span class="divider">/</span></li>
        <li class="active">SPJ</li> 
    </ul>

@endsection
  
  
@section('content')

<div class="block">
        <div class="block-heading">
            <a href="#widgetGroup1" data-toggle="collapse">Print Surat Perintah Jalan</a>       
            <span class="block-icon pull-right ">
                 <div id="statusprinter">Status </div>
            </span> 
        </div>

        <div class="block-body collapse in" id="widgetGroup1">
         <br>
              <div class="form-inline">
                <div class="input-append date" id="datepicker" data-date="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd">
                      <input name="date" id="date" class="input-small" id="tanggal" type="text" value="{{ date('Y-m-d') }}">
                      <span class="add-on"><i class="icon-calendar"></i></span>
                </div>
                 {{ Form::select('shift_id', $shifts, 1, array('id'=>'shift_id')); }}
                <button class="btn btn-info" id="viewsfleetchedule"><i class="icon-search"></i></button>
              </div>

              <input type="button" onClick="findPrinter()" value="Detect Printer"><br />
              <input id="printer" type="text" value="EpsonMini" size="15"><br />

          <br>
        </div>
</div>

<div class="row-fluid">
  <div class="span3">
    <div class="block">
        <span class="block-heading">
          <a>
            <div class="input-append">
              <input class="span9" id="searchKey" type="text">
              <button class="btn" id="btnSearch" type="button"><i class="icon-search"></i></button>
            </div> 
          </a>
        </span>
        <div class="block-body collapse in" id="widget-listArmada">
            <div class="leftArea">
              <ul id="armadaOnSchedule" class="nav nav-list"></ul>
            </div>
        </div>
    </div>

  </div>
  <div class="span9">
    <div class="block">
        <div class="block-heading">
            <span class="block-icon pull-right">
              <button class="btn btn-info" id="printSPJ" type="button">Cetak SPJ <i class="icon-print"></i></button>
            </span>
            <a href="#widget-info" data-toggle="collapse">Fleet Schedule Information </a>
        </div>
        <div class="block-body collapse in" id="widget-info">
        
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
                <td><input type="text" id="name" name="name" disabled> <input id="driver_id" type="hidden"><button class="btn btn-mini btn-info" type="button" id="reportks">Kartu Kontrol</button></td>
              </tr>
              <tr>
                    <td>Status Operasi</td>
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
              <tr>
                <td>Status Pengemudi</td>
                <td><input type="text" id="status" name="status" disabled></td>
              </tr>
      
              <tr>
                <td>Keterangan</td>
                <td><textarea name="keterangan" id="keterangan"></textarea></td>
              </tr>
              <tr>
                <td></td>
                <td><a href="#myModal" role="button" class="btn" data-toggle="modal">Otorisasi Cetak SPJ Diluar Jam Cetak</a></td>
              </tr>
           </table>
        </div>
      </div>
    </div>
</div>

{{-- applet jZebra printer --}}
<applet id="qz" archive="{{ URL::base() }}/qzprint/qz-print.jar" name="QZ Print Plugin" code="qz.PrintApplet.class" width="55" height="55">
  <param name="jnlp_href" value="{{ URL::base() }}/qzprint/qz-print_jnlp.jnlp">
  <param name="cache_option" value="plugin">
  <param name="disable_logging" value="false">
  <param name="initial_focus" value="false">
</applet>

<!-- Button to trigger modal -->

 
<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Otorisasi User</h3>
  </div>
  <div class="modal-body">
    <p>
      Username : <input name="username" id="username" type="text"><br>
      Password : <input name="password" id="password" type="password">
    </p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary" id="printouttime">Cetak SPJ</button>
  </div>
</div>

@endsection

@section('otherscript')

  <script type="text/javascript">
      var rootURL = '{{ URL::base().'/checkouts' }}';
      var currentFleet;
      var time_print;
      var warningblock;
     
      $(function () {
            
        $('#ok').button('toggle');

             
      });

      $('#reportks').click(function(){
        var driver_id = $('#driver_id').val();
        //$('#reportks').load(rootURL + '/kartukontrolpengemudi/' + driver_id );
        if(driver_id == ''){
          alert('pilih pengemudi dahulu');
        }else{
          var url = '{{ URL::base().'/cardcontrols' }}' + '/kartukontrolpengemudi/' + driver_id;
          window.open( url, "Kartu Kontrol Pengemudi", "menubar=0,location=0,height=760,width=1000" );
        }
        return false;

      });


      findAll( $('#date').val(), $('#shift_id').val() );
      
      $(function () {
        $('#datepicker').datepicker({
              format: 'yyyy-mm-dd'
          });
      });

      $('#btnSearch').click(function() {
        search($('#searchKey').val());
        return false;
      });

      $('#viewsfleetchedule').click(function(){
        findAll( $('#date').val(), $('#shift_id').val() );
        return false;
      });

      $('#printouttime').click(function(){
        
        var dataJSON = JSON.stringify({
                "id": $('#id').val(), 
                "statusops": $('button[name="statusops"].active').val(),
                "keterangan": $('#keterangan').val(),
                "username": $('#username').val(),
                "password": $('#password').val(),
              });

              console.log('Print SPJ: ' + id);
              $.ajax({
                type: 'POST',
                contentType: 'application/json',
                url: rootURL + '/qzotorisasicetak',
                dataType: "json",
                data: dataJSON,
                success: function(data){

                   if(data.status === 1) {
                    if (notReady()) { return; }  
                    qz.appendFile('{{ URL::base() }}/qzprint/templatedata/'+ data.urlfile + '?' + new Date().getTime());
                    window['qzDoneAppending'] = function() {
                      qz.print();   
                      window['qzDoneAppending'] = null;
                    };
                   }

                  $('#password').val('');
                  
                },
                error: function(){

                },
              });

        return false;
      });

      $('#armadaOnSchedule a').live('click', function() {
        findById($(this).data('identity'));
      });

      $('#printSPJ').click(function() {
         if($('#id').val() === '') 
          { 
            alert('pilih armada terlebih dahulu');
            return false;
          }else{
            //printSPJZebra($('#id').val()); 
            printSPJ($('#id').val());
          }

          return false;
      });

      function search(searchKey) {
        if (searchKey == '') 
          findAll( $('#date').val(), $('#shift_id').val() );
        else
          findByName(searchKey);
      }

      function findAll(dateSchedule, shift_id) {
        console.log('findAll');
        $.ajax({
          type: 'GET',
          url: rootURL + '/allfleetsOnSchedule/' + dateSchedule + '/' + shift_id,
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
          url: rootURL + '/search',
          dataType: "json",
          data: dataJSON,
          success: renderList 
        });
      }

      function findById(id) {
        console.log('findById: ' + id);
        $.ajax({
          type: 'GET',
          url: rootURL + '/findbyid/' + id,
          dataType: "json",
          success: function(data){
            $('#btnSimpan').show();
            console.log('findById success: ' + data.taxi_number);
            currentInfo = data;
            renderDetails(currentInfo);
          }
        });
      }

      

      //print standar web
      function printSPJ(id)
      {   if(! time_print){
            alert('Bukan waktu print SPJ untuk armada ini');
          }else{
           
            if(warningblock){
              alert('Pengemudi terkena block di harapkan untuk menghadap bapak asuh');
            }

             var dataJSON = JSON.stringify({
                "id": id, 
                "statusops": $('button[name="statusops"].active').val(),
                "keterangan": $('#keterangan').val(), 
              });

             console.log('Print SPJ: ' + id);
              $.ajax({
                type: 'POST',
                contentType: 'application/json',
                url: rootURL + '/qzprintspj',
                dataType: "json",
                data: dataJSON,
                success: function(data){
                  if(data.status === 1) {
                    if (notReady()) { return; }  
                    qz.appendFile('{{ URL::base() }}/qzprint/templatedata/'+ data.urlfile + '?' + new Date().getTime());
                    window['qzDoneAppending'] = function() {
                      qz.print();   
                      window['qzDoneAppending'] = null;
                    };
                   }
                },
                error: function(){

                },
              });
           }
      }

      function renderList(data) {
        // JAX-RS serializes an empty list as null, and a 'collection of one' as an object (not an 'array of one')
        var list = data == null ? [] : (data.fleet instanceof Array ? data.fleet : [data.fleet]);
        $('#armadaOnSchedule li').remove();
        $.each(list, function(index, fleet) {
          $('#armadaOnSchedule').append('<li><a href="#" data-identity="' + fleet.id + '">'+fleet.taxi_number+'</a></li>');
        });
      }

      function renderDetails(info) {
        var driver = info.name + ' ( ' + info.nip + ' ) ';
        var fleet  = info.taxi_number + ' ( ' + info.police_number + ' ) ';
        $('#id').val(info.id);
        $('#pool').val(info.pool);
        $('#taxi_number').val(fleet);
        $('#name').val(driver);
        $('#driver_id').val(info.driver_id);
        $('#status').val(info.status);
        
        time_print = info.print;
        warningblock = info.blocked;

        if(info.blocked)
        {
          $('#bl').button('toggle');
        }else{
          $('#ok').button('toggle');
        }

      }


      //print with qz printer //ECS/P EPSON

      /**
      * Automatically gets called when applet has loaded.
      */
      function qzReady() {
        // Setup our global qz object
        window["qz"] = document.getElementById('qz');
        var title = document.getElementById("statusprinter");
        if (qz) {
          try {
            title.innerHTML = title.innerHTML + " Ready " + qz.getVersion();
            document.getElementById("statusprinter").style.background = "#F0F0F0";
          } catch(err) { // LiveConnect error, display a detailed meesage
            document.getElementById("statusprinter").style.background = "#F5A9A9";
            alert("ERROR:  \nThe applet did not load correctly.  Communication to the " + 
              "applet has failed, likely caused by Java Security Settings.  \n\n" + 
              "CAUSE:  \nJava 7 update 25 and higher block LiveConnect calls " + 
              "once Oracle has marked that version as outdated, which " + 
              "is likely the cause.  \n\nSOLUTION:  \n  1. Update Java to the latest " + 
              "Java version \n          (or)\n  2. Lower the security " + 
              "settings from the Java Control Panel.");
          }
        }
      }
      
      /**
      * Returns whether or not the applet is not ready to print.
      * Displays an alert if not ready.
      */
      function notReady() {
        // If applet is not loaded, display an error.
        if (!qz) {
          alert('Error:\n\n\tApplet is not loaded!');
          return true;
        } 
          // If a printer hasn't been selected, display a message.
        else if (!qz.getPrinter()) {
          alert('Please select a printer first by using the "Detect Printer" button.');
          return true;
        }
        return false;
      }

      /**
      * Automatically gets called when "qz.print()" is finished.
      */
      function qzDonePrinting() {
        // Alert error, if any
        if (qz.getException()) {
          alert('Error printing:\n\n\t' + qz.getException().getLocalizedMessage());
          qz.clearException();
          return; 
        }
        
        // Alert success message
        alert('Successfully sent print data to "' + qz.getPrinter() + '" queue.');
      }
      

      function findPrinter(name) {
        // Get printer name from input box
        var p = document.getElementById('printer');
        if (name) {
          p.value = name;
        }
        if (qz) {
          // Searches for locally installed printer with specified name
          qz.findPrinter(p.value);
        } else {
          // If applet is not loaded, display an error.
          return alert('Error:\n\n\tApplet is not loaded!');
        }
         
        // Automatically gets called when "qz.findPrinter()" is finished.
        window['qzDoneFinding'] = function() {
            var p = document.getElementById('printer');
          var printer = qz.getPrinter();
          
          // Alert the printer name to user
            alert(printer !== null ? 'Printer found: "' + printer + 
            '" after searching for "' + p.value + '"' : 'Printer "' + 
            p.value + '" not found.');
          
          // Remove reference to this function
          window['qzDoneFinding'] = null;
        };
      }

  </script>
@endsection
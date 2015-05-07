@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Setoran Armada</h1>
  </div>
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li><a href="{{URL::to('financials')}}">financial dashboard</a> <span class="divider">/</span></li>
        <li class="active">Setoran</li>
    </ul>
@endsection
  
  
@section('content')

  <div class="block">
        <div class="block-heading">
            <a href="#widgetGroup1" data-toggle="collapse">Setting Parameter Setoran Armada</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup1">
          <br>
          <div class="form-inline">
              <div class="input-append date" id="datepicker" data-date="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd">
                  <input name="date" id="date" class="input-small" type="text" value="{{ date('Y-m-d') }}">
                  <span class="add-on"><i class="icon-calendar"></i></span>
              </div>
              <div class="btn-group" data-toggle="buttons-radio">
                <button type="button" class="btn btn-warning" name="dayof" id="normal" value="normal">Hari Normal</button>
                <button type="button" class="btn btn-warning" name="dayof" id="minggu" value="minggu">Hari Minggu</button>
                <button type="button" class="btn btn-warning" name="dayof" id="nasional" value="nasional">Hari Libur Nasional</button>
              </div>   
              <button class="btn btn-info" id="settingSave"><i class="icon-wrench"></i></button>
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
              <input class="span9" id="searchKey" type="text">
              <button class="btn" id="btnSearch" type="button"><i class="icon-search"></i></button>
            </div> 
          </a>
        </span>
        <div class="block-body collapse in" id="widget-liststr">
            <div class="leftArea">
              <ul id="armadaList" class="nav nav-list"></ul>
            </div>
        </div>
    </div>

  </div>
  <div class="span9">
    <div class="block">
        <div class="block-heading">
            <span class="block-icon pull-right">
              <button class="btn btn-info" id="btnSave" tabindex="14">Simpan <i class="icon-hdd"></i></button>
            </span>
            <a href="#widget-formstr" data-toggle="collapse">Form Setoran Armada <span id="infoFleet"></span> - <span id="infoDriver"></span> | KM Tempuh ( <span id="km_tempuh" style="color:red;"></span> )</a>
        </div>
        <div class="block-body collapse in" id="widget-formstr">
        {{-- ID Checkin --}}
        <input type="hidden" id="checkin_id">
        <div class="row-fluid">
          <div class="tabbable">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab1" data-toggle="tab">Form Setoran</a></li>
              <li><a href="#tab2" data-toggle="tab">Informasi Armada</a></li>
              <li><a href="#tab3" data-toggle="tab">Informasi Pengemudi</a></li>
              <li class="active"><a>In time : <span id="in_time" style="color:red;"></span></a></li>
            </ul>
            <div class="tab-content">
               <div class="tab-pane active" id="tab1">
                   <div class="row-fluid">
                    <div class="span12">
                      <form id="formSetoran">
                        <div class="row-fluid">
                          <div class="span6"><h5>Pembayaran Wajib</h5></div>
                          <div class="span6"><h5>Pembayaran Hutang</h5></div>
                        </div>
                        <div class="row-fluid">
                          <div class="span3">Setoran Murni</div>
                          <div class="span3"><input type="text" id="setoran_wajib" class="span11 money" tabindex="1"  readonly="readonly"></div>
                          <div class="span3">Kurang Setor</div>
                          <div class="span3"><input type="text" id="tag_ks" class="span11  money" tabindex="7"></div>
                        </div>

                        <div class="row-fluid">
                          <div class="span3">Tabungan Spare-part</div>
                          <div class="span3"><input type="text" id="tab_sp" class="span11  money" tabindex="2"  readonly="readonly" ></div>
                          <div class="span3">Cicilan DP KSO</div>
                          <div class="span3"><input type="text" id="tag_cicilan_dp" class="span11  money" tabindex="8"></div>
                        </div>

                        <div class="row-fluid">
                          <div class="span3">Denda</div>
                          <div class="span3"><input type="text" id="denda" class="span11  money" tabindex="3" ></div>
                          <div class="span3">Cicilan Sparepart</div>
                          <div class="span3"><input type="text" id="tag_spart" class="span11  money" tabindex="9" ></div> 
                        </div>

                        <div class="row-fluid">
                          <div class="span3">Potongan</div>
                          <div class="span3"><input type="text" id="pot" class="span11  money" tabindex="4"  readonly="readonly"></div>
                          <div class="span3">DP Sparepart</div>
                          <div class="span3"><input type="text" id="tag_dp_spart" class="span11  money" tabindex="10"></div>
                        </div>

                        <div class="row-fluid">
                          <div class="span6"><h5>Pembayaran Lain-Lain</h5></div>
                          <div class="span3">Hutang Lama</div>
                          <div class="span3"><input type="text" id="tag_hut_lama" class="span11  money" tabindex="11"></div>
                        </div>

                        

                        <div class="row-fluid">
                          <div class="span3">Biaya Cuci</div>
                          <div class="span3"><input type="text" id="biaya_tc" class="span11  money" tabindex="5"></div>
                          <div class="span3">Stkr. Bandara & Keamanan</div>
                          <div class="span3"><input type="text" id="tag_other" class="span11 money" tabindex="12"></div>
                        </div>

                        <div class="row-fluid">
                          <div class="span3">Iuran LAKA</div>
                          <div class="span3"><input type="text" id="iuran_laka" class="span11 money" tabindex="6"></div>
                          <div class="span3">Buka Blocking</div>
                          <div class="span3"><input type="text" id="tagihanopenblock" class="span11 money" readonly="readonly"></div>
                        </div>

                        <div class="row-fluid">
                          <div class="span3"></div>
                          <div class="span3"></div>
                          <div class="span6">
                            <div class="input-prepend">
                              <span class="add-on span3">Total </span>
                              <input style="width:235px; text-align: right;" id="total" type="text" >
                            </div>
                          </div>
                        </div>
                        <div class="row-fluid">
                          <div class="span6">
                            <div class="input-prepend">
                              <span class="add-on span5">Sisa Pembayaran </span>
                              <input style="width:180px; text-align: right;" id="ks" type="text" placeholder="Kurang Stor"  readonly="readonly">
                            </div>
                          </div>
                          <div class="span6"><input class="span12 moneypembayaran" required id="pay_cash" type="text" placeholder="Pembayaran" tabindex="13"></div>
                        </div>
                      </form>
                      </div>
                    </div>
                </div>
                {{--end setoran form--}}

                <div class="tab-pane" id="tab2">

                </div>
                {{--end informasi armada--}}
                <div class="tab-pane" id="tab3">

                </div>
                {{--end informasi pengemudi--}}
            </div>
        
          
          </div>
          </div>
        </div>
      </div>
    </div>
</div>
{{-- applet jZebra printer --}}
<!--
              <applet name="jzebra" code="jzebra.PrintApplet.class" archive="{{ URL::base().'/themes/lib/jzebra/' }}jzebra.jar" width="1" height="1">
                    <param name="printer" value="zebra">
              </applet>
-->
@endsection

@section('otherscript')
  <script type="text/javascript">
      var rootURL = '{{ URL::base().'/financials' }}';
      var currentFleet;
      /*
      $(document).keydown(function (e) {
        if (e.charCode || e.keyCode == 9) { 
            e.preventDefault();
        }
      });  
      */
      $(function () {
        Globalize.culture( "id-ID" );
        $('#datepicker').datepicker({
              format: 'yyyy-mm-dd'
          });
        $('#normal').button('toggle');
        $('.money').money_field({width: 120});
        $('.moneypembayaran').money_field({width: 290});

        $('#pay_cash').keyup(function() {
          
           var total = Globalize.parseFloat($('#total').val());
           var cash = Globalize.parseFloat($(this).val());
           var ks = cash - total;
           $('#ks').val(Globalize.format(ks,"n0"));
        });
        /*
        $('input').focusout(function () {
                var tabindex = $(this).attr('tabindex');
                var att_id = $(this).attr('id');
                var defPay = 0;

                $.each( currentFleet, function( key, value ) {
                  if(key === att_id){
                    defPay = parseInt(value);
                  }
                });
                

                var val = Math.abs(Globalize.parseFloat($('#' + att_id).val()) || 0);
                var defaultPay = val < defPay ? defPay : val; 

                if(att_id === 'tag_hut_lama' || att_id === 'tag_other' ){
                  defaultPay = val;
                }
                // set default payment
                
                var valueformat = Globalize.format(defaultPay,"n0");

                $('#' + att_id).val(valueformat); 
                totalPayment();

                tabindex++; //increment tabindex
                //$('[tabindex=' + tabindex + ']').focus();            
                
                return false;

        });
        */
        // fungsi tab index & default payment
        $('input').bind('keypress', function(eInner) {
            if (eInner.keyCode == 13) //if its a enter key
            {   
                var tabindex = $(this).attr('tabindex');
                var att_id = $(this).attr('id');
                var defPay = 0;

                $.each( currentFleet, function( key, value ) {
                  if(key === att_id){
                    defPay = parseInt(value);
                  }
                });
                

                var val = Math.abs(Globalize.parseFloat($('#' + att_id).val()) || 0);
                var defaultPay = val < defPay ? defPay : val; 

                if(att_id === 'tag_hut_lama' || att_id === 'tag_other' ){
                  defaultPay = val;
                }
                // set default payment
                
                var valueformat = Globalize.format(defaultPay,"n0");

                $('#' + att_id).val(valueformat); 
                totalPayment();

                tabindex++; //increment tabindex
                $('[tabindex=' + tabindex + ']').focus();            
                
                return false;
            }
        });

      });
      
      function totalPayment()
      { 
        var a,b,pot,d,e,f,g,h,i,j,k,l,m;
        a = Globalize.parseFloat($('#setoran_wajib').val());
        b = Globalize.parseFloat($('#tab_sp').val());
        pot = Globalize.parseFloat($('#pot').val());
        d = Globalize.parseFloat($('#denda').val());
        e = Globalize.parseFloat($('#iuran_laka').val());
        f = Globalize.parseFloat($('#biaya_tc').val());
        //tagihan
        h = Globalize.parseFloat($('#tag_spart').val());
        i = Globalize.parseFloat($('#tag_ks').val());
        j = Globalize.parseFloat($('#tag_cicilan_dp').val());
        k = Globalize.parseFloat($('#tag_dp_spart').val());
        l = Globalize.parseFloat($('#tag_hut_lama').val());
        m = Globalize.parseFloat($('#tag_other').val());
        n = Globalize.parseFloat($('#tagihanopenblock').val());

        var tot = ( a + b + d + e + f + h + i + j + k + l + m  + n) - pot ;

        var total = Globalize.format(tot,"n0");
        $('#total').val(total);
      }

      findAll($('#date').val());
      
      $('#btnSearch').click(function() {
        search($('#searchKey').val());
        return false;
      });

      $('#armadaList a').live('click', function() {
        findById($(this).data('identity'));
      });

      $("#armadaList a").keypress(function(e) {
        if (e.keyCode == 13) {
          findById($(this).data('identity'));
        }
      });

      $('#settingSave').click(function() {
        var dayof = $('button[name="dayof"].active').val();
        var message = confirm('Tanggal Operasi : ' + $('#date').val() + '\n' + 'Hari : ' + dayof );
        if(message==true) { findAll($('#date').val()); }        
        return false;
      });

      $('#btnSave').click(function(){
        var id = $('#checkin_id').val();
        if( id =='') return alert('Pilih armada yang akan setoran');

        var cash = Globalize.parseFloat($('#pay_cash').val());
        cash =  Globalize.format(cash,"c");
        
        var r=confirm("Setoran yang anda masukan : " + cash );
        if (r==true)
        {
          addsetoran();
          //cetak(id);
          findAll($('#date').val());
        }
        else
        {
          $('#pay_cash').focus();
        }
        return false;
      });

      $('#searchKey').bind('keypress', function(eInner) {
            if (eInner.keyCode == 13) //if its a enter key
            { 
              findByName($('#searchKey').val()); 
            }
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
          url: rootURL + '/allfleets/' + dateSchedule,
          dataType: "json", // data type of response
          success: renderList
        });
      }

      //print standar web
      function cetak(id)
      {   
          var url = rootURL + '/cetak/' + id;
          var thePopup = window.open( url, "cetak", "menubar=0,location=0,height=600,width=500" );
          thePopup.print();        
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

          var dayof = $('button[name="dayof"].active').val();
          var total = Globalize.parseFloat($('#total').val());
          var cash = Globalize.parseFloat($('#pay_cash').val());
          var ks = cash - total;
          
          $('#ks').val(Globalize.format(ks,"n0"));
          $('#pay_cash').val('');
          $('#tag_ks').focus();
          var dataJSON = JSON.stringify({
            "id": id, 
            "dayof": dayof, 
          });

        console.log('findById: ' + id);
        $.ajax({
          type: 'POST',
          url: rootURL + '/findbyid',
          dataType: "json",
          data: dataJSON,
          success: function(data){
            $('#btnSimpan').show();
            console.log('findById success: ' + data.taxi_number);
            currentFleet = data;
            renderDetails(currentFleet);
          }
        });
      }

      function addsetoran() {
        console.log('addFinancials');
        $.ajax({
            type: 'POST',
            contentType: 'application/json',
            url: rootURL + '/savePayment',
            dataType: "json",
            data: dataSetoran(),
            success: function(data, textStatus, jqXHR){
                alert(data.msg); 
                cetak(data.id);
                $('#searchKey').focus(); 
            },
            error: function(jqXHR, textStatus, errorThrown){
                alert('Payment error: ' + textStatus);
            }
        });
      }

      function dataSetoran() {
        return JSON.stringify({
            "checkin_id" : $('#checkin_id').val(),
            "setoran_wajib" : Globalize.parseFloat($('#setoran_wajib').val()),
            "tab_sp" : Globalize.parseFloat($('#tab_sp').val()),
            "pot" : Globalize.parseFloat($('#pot').val()),
            "denda" : Globalize.parseFloat($('#denda').val()),
            "iuran_laka" : Globalize.parseFloat($('#iuran_laka').val()),
            "biaya_tc" : Globalize.parseFloat($('#biaya_tc').val()),
            "tag_spart" : Globalize.parseFloat($('#tag_spart').val()),
            "tag_ks" : Globalize.parseFloat($('#tag_ks').val()),
            "tag_cicilan_dp" : Globalize.parseFloat($('#tag_cicilan_dp').val()),
            "tag_dp_spart" : Globalize.parseFloat($('#tag_dp_spart').val()),
            "tag_hut_lama" : Globalize.parseFloat($('#tag_hut_lama').val()),
            "tag_other" : Globalize.parseFloat($('#tag_other').val()),
            "ks" : Globalize.parseFloat($('#ks').val()),
            "setoran_cash" : Globalize.parseFloat($('#pay_cash').val()),
            "tagihanopenblock" : Globalize.parseFloat($('#tagihanopenblock').val()),
          });
      }

      function renderList(data) {
        // JAX-RS serializes an empty list as null, and a 'collection of one' as an object (not an 'array of one')
        var list = data == null ? [] : (data.fleet instanceof Array ? data.fleet : [data.fleet]);
        var tb = 100;
        $('#armadaList li').remove();
        $.each(list, function(index, fleet) {
          tb = tb + index;
          $('#armadaList').append('<li><a href="#" data-identity="' + fleet.id + '"  tabindex="'+ tb +'" >'+fleet.taxi_number+'</a></li>');
        });

         $('[tabindex=100]').focus();   
      }

      function renderDetails(data) {
        var driver = data.name + ' ( ' + data.nip + ' ) ';
        var fleet  = data.taxi_number + ' ( ' + data.police_number + ' ) ';        
        $('#infoFleet').text(fleet);
        $('#infoDriver').text(driver);
        $('#checkin_id').val(data.id);
        //tagihan perorangan
        $('#setoran_wajib').val(Globalize.format(parseInt(data.setoran_wajib),"n0"));
        $('#tab_sp').val(Globalize.format(parseInt(data.tab_sp),"n0"));
        $('#pot').val(Globalize.format(parseInt(data.pot),"n0"));
        $('#denda').val(Globalize.format(parseInt(data.denda),"n0"));
        $('#iuran_laka').val(Globalize.format(parseInt(data.iuran_laka),"n0"));
        $('#biaya_tc').val(Globalize.format(parseInt(data.biaya_tc),"n0"));
        $('#total').val(Globalize.format(parseInt(data.total),"n0"));

        //tagihan
        $('#tag_spart').val(Globalize.format(parseInt(data.tag_spart),"n0"));
        $('#tag_ks').val(Globalize.format(parseInt(data.tag_ks),"n0"));
        $('#tag_cicilan_dp').val(Globalize.format(parseInt(data.tag_cicilan_dp),"n0"));
        $('#tag_dp_spart').val(Globalize.format(parseInt(data.tag_dp_spart),"n0"));
        $('#tag_hut_lama').val(Globalize.format(parseInt(data.tag_hut_lama),"n0"));
        $('#tag_other').val(Globalize.format(parseInt(data.tag_other),"n0"));
        $('#tagihanopenblock').val(Globalize.format(parseInt(data.tagihanopenblock),"n0"));
        //set ks otomatis
        //$('#ks').val(parseInt(data.total) * -1);


        //in-out time
        $('#in_time').text(data.in_time);

        //km tempuh
        $('#km_tempuh').text(data.km_tempuh);
      }
  </script>
  
@endsection
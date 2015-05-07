@include('themes.partials.head')
<div class="row-fluid">

    <div class="block">
        <div class="block-heading">
            <span class="block-icon pull-right">
              <button class="btn btn-primary" type="button" id="reportks">Detail Setoran</button>
            </span>
            <a href="#widget-info" data-toggle="collapse">Information </a>
        </div>
        <div class="block-body collapse in" id="widget-info">
          
          <div class="row-fluid">
          <div class="tabbable">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab3" data-toggle="tab">Armada</a></li>
            </ul>
            <div class="tab-content">
                
                {{-- end status bap --}}
                <div class="tab-pane active" id="tab3">
                  <table class="table table-condensed table-striped">
                  <tr>
                    <td>Nomor Body</td>
                    <td><input type="hidden" id="fleet_id" name="fleet_id"><input type="text" id="taxi_number" name="taxi_number" disabled></td>
                  </tr>
                  <tr>
                    <td>Bravo</td>
                    <td><input type="text" id="bravo" name="bravo" disabled></td>
                  </tr>
                  <tr>
                    <td>Nomor Polisi</td>
                    <td><input type="text" id="police_number" name="police_number" disabled></td>
                  </tr>
                  <tr>
                    <td>Total KS</td>
                    <td><input type="text" id="total_ks" name="total_ks" class="money" disabled></td>
                  </tr>
                  <tr>
                    <td>Pembayaran KS</td>
                    <td><input type="text" id="pembayaran_ks" name="pembayaran_ks" class="money" disabled></td>
                  </tr>
                  <tr>
                    <td>Tabungan Sparepart</td>
                    <td><input type="text" id="tab_sparepart" name="tab_sparepart" class="money" disabled></td>
                  </tr>
                  <tr>
                    <td>Pemakaian Sparepart</td>
                    <td><input type="text" id="pem_sparepart" name="pem_sparepart" class="money" disabled></td>
                  </tr>
                  <tr>
                    <td>Pembayaran Sparepart</td>
                    <td><input type="text" id="pembayaran_sparepart" name="pembayaran_sparepart" class="money" disabled></td>
                  </tr>
                  <tr>
                    <td>DP KSO</td>
                    <td><input type="text" id="dp_kso" name="dp_kso" class="money" disabled></td>
                  </tr>
                  <tr>
                    <td>Hutang DP KSO</td>
                    <td><input type="text" id="hutang_dp_kso" name="hutang_dp_kso" class="money" disabled></td>
                  </tr>
                  <tr>
                    <td>Pembayaran DP KSO</td>
                    <td><input type="text" id="pem_hutang_dp_kso" name="pem_hutang_dp_kso" class="money" disabled></td>
                  </tr>
                  <tr>
                    <td>Saldo Unit</td>
                    <td><input type="text" id="saldo_unit" name="saldo_unit" class="money" disabled></td>
                  </tr>
                  <tr>
                    <td>Status</td>
                    <td><input type="text" id="fleet_status" name="fleet_status" disabled></td>
                  </tr>
               </table>
                </div>
                
              
                {{--end informasi pengemudi--}}
            </div>
          
        </div>
      </div>
    </div>

</div>

{{-- Modal Proses APP --}}

@include('themes.partials.script')
<script type="text/javascript">
var rootURL = '{{ URL::base().'/cardcontrols' }}';
var currentInfo;
$(function () {
        $('.money').money_field({width: 120});

});

findById({{ $fleet_id }});
     

     

      
      $('#reportks').click(function(){
        var fleet_id = $('#fleet_id').val();
        //$('#reportks').load(rootURL + '/kartukontrolpengemudi/' + driver_id );
        if(fleet_id == ''){
          alert('pilih Armada dahulu');
        }else{
          var url = rootURL + '/kartukontrolarmada/' + fleet_id;
          window.open( url, "Kartu Kontrol Armada", "menubar=0,location=0,height=700,width=1100" );
        }
        return false;

      });


      
      

      function findById(id) {
        console.log('findById: ' + id);
        $.ajax({
          type: 'GET',
          url: rootURL + '/findbyIdFleet/' + id,
          dataType: "json",
          success: function(data){
            
            var fleetinfo = data.fleetinfo;
            console.log('findById success: ' + fleetinfo.taxi_number);
            currentInfo = data;
            renderDetails(currentInfo);
          }
        });
      }

      function renderList(data) {
        // JAX-RS serializes an empty list as null, and a 'collection of one' as an object (not an 'array of one')
        var list = data == null ? [] : (data.fleets instanceof Array ? data.fleets : [data.fleets]);
        $('#driverLists li').remove();
        $.each(list, function(index, fleet) {
          $('#driverLists').append('<li><a href="#" data-identity="' + fleet.id + '">'+fleet.taxi_number+'</a></li>');
        });
      }

      function renderDetails(data) {
        var fleetinfo = data.fleetinfo;
        //fleet info
        $('#fleet_id').val(fleetinfo.id);
        $('#taxi_number').val(fleetinfo.taxi_number);
        $('#bravo').val(fleetinfo.bravo);
        $('#police_number').val(fleetinfo.police_number);
        $('#total_ks').val(fleetinfo.total_ks);
        $('#pembayaran_ks').val(fleetinfo.pembayaran_ks);
        $('#tab_sparepart').val(fleetinfo.tab_sparepart);
        $('#pem_sparepart').val(fleetinfo.pem_sparepart);
        $('#fleet_status').val(fleetinfo.status);
        $('#saldo_unit').val(fleetinfo.saldo_unit);
        $('#pembayaran_sparepart').val(fleetinfo.pembayaran_sparepart);
        $('#dp_kso').val(fleetinfo.dp_kso);
        $('#hutang_dp_kso').val(fleetinfo.hutang_dp_kso);
        $('#pem_hutang_dp_kso').val(fleetinfo.pem_hutang_dp_kso);

        return false;
      }
</script>
  

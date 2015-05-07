<div class="block">
        <div class="block-heading">
            <span class="block-icon pull-right">
              <button class="btn btn-info" id="printWo" tabindex="8">Cetak <i class="icon-print icon-white"></i></button>
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
                </div>
                <div class="span6">
                    <div class="block">
                        <div class="block-heading">
                            <a>Keterangan</a>
                        </div>
                        <div class="block-body">
                         	{{ $wo->information_complaint }}
                        </div>
                    </div>
                </div>
            </div>
          <br>
        </div>
</div>

<script type="text/javascript">
var rootURL = '{{ URL::base().'/workshops' }}';
var wo_id = $('#wo_id').val();
$('#printWo').click(function(){
   
    //alert('clicked');
    cetak(wo_id);
    return false;
  });

 //print standar web
      function cetak(id)
      {   
          var url = rootURL + '/cetakwo/' + id;
          var thePopup = window.open( url, "cetak", "menubar=0,location=0,height=400,width=500" );
          thePopup.print();        
      }
  
</script>
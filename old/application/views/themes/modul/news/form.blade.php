@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Tambah Pesan</h1>
  </div>
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li><a href="{{URL::to('news')}}">Manage Pesan</a> <span class="divider">/</span></li>
        <li class="active">Tambah Pesan</li>
    </ul>
@endsection
  
@section('content')

 <div class="block">
        <div class="block-heading">
            <span class="block-icon pull-right">
              <button class="btn btn-info" id="btnSave" tabindex="14">Kirim <i class="icon-hdd"></i></button>
            </span>
            <a href="#widgetGroup1" data-toggle="collapse">Form Pesan</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup1">
         
         <br>
          <div class="row-fluid"> <!-- Start pembagian kolom -->
            <form class="form-horizontal">
              <div class="span6">
                
                  <div class="control-group">
                    <label class="control-label" for="body">Tipe Pesan</label>
                    <div class="controls">
                      <div class="span12">
                            <div class="btn-group" data-toggle="buttons-radio">
                              <button type="button" class="btn btn-info" name="msg_type" id="broadcast" value="1">Broadcast</button>
                              <button type="button" class="btn btn-info" name="msg_type" id="to-pool" value="2">To Pool</button>
                              <button type="button" class="btn btn-info" name="msg_type" id="to-user" value="3">To User</button>
                            </div> 
                      </div>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="name">Prioritas Pesan</label>
                    <div class="controls">
                      <div class="btn-group" data-toggle="buttons-radio">
                              <button type="button" class="btn btn-danger" name="priority" id="urgent" value="label-important">urgent</button>
                              <button type="button" class="btn btn-warning" name="priority" id="warning" value="label-warning">important</button>
                              <button type="button" class="btn btn-success" name="priority" id="info" value="label-info">normal</button>
                            </div> 
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="inputtext">To Pool</label>
                    <div class="controls">
                      {{ Form::select('pool_id', $pools , 0 ,array('id'=>'topoolid')) }}
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="pool">To User</label>
                    <div class="controls">
                     {{ Form::select('to_user_id', $users , 0 ,array('id'=>'touserid')) }}
                    </div>
                  </div>

              </div>
              <div class="span6">
                  <div class="control-group">
                    <label class="control-label" for="woNumber">Pesan Berakhir</label>
                    <div class="controls">
                      
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="date">Tanggal</label>
                    <div class="controls">
                      <div class="input-append date" id="datepicker" data-date="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd">
                        <input name="date" class="input-small" id="tanggal" type="text" value="{{ date('Y-m-d') }}">
                        <span class="add-on"><i class="icon-calendar"></i></span>
                      </div>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="jam">Jam</label>
                    <div class="controls">
                      <div class="input-append bootstrap-timepicker-component">
                          <input name="jam" type="text" id="jam" class="timepicker input-small" value="{{ date('H:i:s') }}">
                          <span class="add-on">
                              <i class="icon-time"></i>
                          </span>
                      </div>
                    </div>
                  </div>

              </div>

          </div>  <!-- end pembagian kolom -->
            <div class="row-fluid">
                <div class="span12">
                    <div class="block">
                        <div class="block-heading">
                            <a>Pesan text</a>
                        </div>
                        <div class="block-body">
                         <textarea rows="10" style="width:97%;" id="message" name="message"></textarea>
                        </div>
                    </div>
                </div>
            </div>
          <br>
        </div>
      </div>

        </div>
    </div>

@endsection
@section('otherscript')
<script type="text/javascript">
 var rootURL = '{{ URL::base().'/news' }}';
$(function () {
        $('#datepicker').datepicker({
              format: 'yyyy-mm-dd'
          });

        $('.timepicker').timepicker({
          showMeridian: false,
          showSeconds: true
        });
        $('#broadcast').button('toggle');
        $('#info').button('toggle');

         $('#touserid').attr("disabled", true); 
         $('#topoolid').attr("disabled", true); 
  });
  
        $('button[name="msg_type"]').click( function() {
            var typem = $(this).val();
            typemsg(parseInt(typem));
        });

        $('#btnSave').click(function() {
          addmessage();
          return false;
        });


        function typemsg(e){
          switch(e)
            {
              case 1:
                $('#touserid').attr("disabled", true); 
                $('#topoolid').attr("disabled", true); 
              break;
              case 2:
                $('#touserid').attr("disabled", true); 
                $('#topoolid').prop('disabled',false);
              break;
              case 3:
                $('#touserid').prop('disabled',false); 
                $('#topoolid').attr("disabled", true); 
              break;
              default:
                $('#touserid').attr("disabled", true); 
                $('#topoolid').attr("disabled", true); 
            }
        }

        function data() {
          return JSON.stringify({
              "pool_id" : $('#topoolid').val(),
              "to_user_id" : $('#touserid').val(),
              "tanggal" : $('#tanggal').val(),
              "jam" : $('#jam').val(),
              "message" : $('#message').val(),
              "msg_type": $('button[name="msg_type"].active').val(),
              "priority": $('button[name="priority"].active').val(),
            });
        }

        function addmessage() {
          console.log('addmessage');
          $.ajax({
              type: 'POST',
              contentType: 'application/json',
              url: rootURL + '/add',
              dataType: "json",
              data: data(),
              success: function(data, textStatus, jqXHR){
                  alert(data.msg); 
              },
              error: function(jqXHR, textStatus, errorThrown){
                  alert('Simpan Error: ' + textStatus);
              }
          });
        }
</script>
@endsection


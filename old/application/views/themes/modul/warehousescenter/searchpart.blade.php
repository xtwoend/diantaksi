{{ HTML::style('themes/lib/jquerytable/css/demo_table.css'); }}
{{ HTML::script('themes/lib/jquerytable/js/jquery.js'); }}
{{ HTML::script('themes/lib/jquerytable/js/jquery.dataTables.min.js'); }}

<div class="container-fluid">
  <table cellpadding="0" cellspacing="0" border="0" class="display" id="partlists">
  <thead>
    <tr>
      <th width="30%">Part Number</th>
      <th width="60%">Nama Part</th>
      <th width="10%">Qty</th>
    </tr>
  </thead>
  <tbody>
    
  </tbody>
</table>

</div>

<script type="text/javascript" charset="utf-8">

      var rootURL = '{{ URL::base().'/sparepart' }}';
      var partform = window.opener.$("#part_number");
     
      $('#partlists td a').live('click', function() {
        var partnumber = $(this).data('identity');
        partform.val(partnumber);
        return false;
      });

      $('#partlists td a').live('dblclick',function(){
        window.opener.addPartCart();
        return false;
      });
     
      $(document).ready(function() {
        var oTable = $('#partlists').dataTable( {
          "bProcessing": true,
          "sAjaxSource": rootURL+"/jsonsparepart"
        });
      } );
</script>
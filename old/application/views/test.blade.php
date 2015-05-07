@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Halaman Khusus Testing</h1>
  </div>
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li class="active">Halaman Khusus Testing</li>
    </ul>
@endsection
  
 
@section('content')
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<form  method="get">
  <input type="text" value="" id="num" name="number" /><br />
</form>
@endsection

@section('otherscript')
<script type="text/javascript">
$(function(){
  Globalize.culture( "id-ID" );
  var defval = 100000; 
  $('#num').val(defval);

  $('input').change(function() {    
      var value = Globalize.parseInt($(this).val());
      value = Globalize.format(value,"n0");
      (defval > $(this).val()) ? value = defval : value = $(this).val();
      $(this).val(value);    
      changeof(value);
  });
});
function changeof(val)
{
   var value = Globalize.parseFloat(val);
   alert(value);
}


</script>
  
@endsection
@layout('themes.layouts.common')

@section('header')
	<div class="header">
   			<h1 class="page-title">Upload Setoran</h1>
    </div>
        
    <ul class="breadcrumb">
        <li><a href="">Home</a> <span class="divider">/</span></li>
        <li class="active">Upload Setoran</li>
    </ul>
@endsection

@section('content')
  <div class="block">
        <div class="block-heading">
            <a href="#widgetGroup1" data-toggle="collapse">Form Upload Setoran</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup1">
          <br>
          {{ Form::open_for_files(URL::current()) }}
              <div class="input-append" >
                  {{ Form::file('datasetoran') }}   
              </div>
              <button class="btn btn-info">Upload Data</button>
            </form>
            <br> 
        </div>
    </div> 
    
    
@endsection


@section('otherscript') 	
   <script type="text/javascript">

  

</script>
@endsection
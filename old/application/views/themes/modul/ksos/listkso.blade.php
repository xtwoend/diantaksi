@layout('themes.layouts.common')

@section('header')
	<div class="header">
   			<h1 class="page-title">Master Spare Part </h1>
    </div>
        
    <ul class="breadcrumb">
        <li><a href="">Home</a> <span class="divider">/</span></li>
        <li class="active">Master Spare Part</li>
    </ul>
@endsection

@section('content')
    
    <div class="block">
        <div class="block-heading">
            <a href="#widgetGroup1" data-toggle="collapse">Search</a>       
        </div>
        
        <div class="block-body collapse" id="widgetGroup1"><br>
            <form action="" method="get" id="filter">
              {{ Form::select('search', array('taxi_number' => 'Nomor Body', 'kso_number' => 'Nomor KSO'), $searchby) }}
              <div class="input-append">
                
                {{ Form::text('q', $q , array('class'=>'span12')) }}
                <button class="btn" type="submit"><i class="icon-search"></i></button>
              </div>
            </form>
        </div>
    </div>
    <a class="btn btn-success btn-mini" href="{{ URL::to('ksos/downloadksoactive') }}"><i class="icon-plus icon-white"></i> Download</a>  
	  <div class="block">
        <div class="block-heading">
            <span class="block-icon pull-right">
              <a class="btn btn-success btn-mini" href="{{ URL::to('ksos/formkso') }}"><i class="icon-plus icon-white"></i> Tambah KSO</a> 
            </span>
            <a href="#widgetGroup2" data-toggle="collapse">Spare Part List</a>       
        </div>
        
        <div class="block-body collapse in" id="widgetGroup2">
         	<table class="table table-condensed table-striped">
         		<thead>
         			<tr>
         				<th class="span1">No.</th>
         				<th><a href="{{ URL::to('ksos/listkso?sort=taxi_number'.$querystr) }}">Nomor Body</a></th>
         				<th><a href="{{ URL::to('ksos/listkso?sort=kso_number'.$querystr) }}">Nomor KSO</a></th>
                <th>Nomor Polisi</th>
         				<th><a href="{{ URL::to('ksos/listkso?sort=ops_start'.$querystr) }}">Tanggal Mulai KSO</a></th>
         				<th><a href="{{ URL::to('ksos/listkso?sort=ops_end'.$querystr) }}">Tanggal Akhir KSO</a></th>
         				<th>Jenis KSO</th>
                <th>Action</th>
         			</tr>
         		</thead>
	            <tbody>
	            	<?php $no=((Input::get('page',1) * 20) - 20) + 1; ?>
                @foreach($ksos->results as $kso)
	            	<tr>
	            		<td>{{ $no }}</td>
	            		<td>{{ $kso->taxi_number }}</td>
	            		<td>{{ $kso->kso_number }}</td>
                  <td>{{ $kso->police_number }}</td>
	            		<td>{{ $kso->ops_start }}</td>
	            		<td>{{ $kso->ops_end }} </td>
	            		<td>{{ Ksotype::find($kso->kso_type_id)->type }}</td>
	            		<td>
	            			<a class="btn btn-success btn-mini" href="{{ URL::to('ksos/editkso/'.$kso->id) }}"><i class="icon-edit icon-white"></i></a>  
                  </td>
	            	</tr>
                <?php $no++; ?>
	           		@endforeach
	            </tbody>
            </table>
            {{ $pagination }}
        </div>
	</div>

<div id="editkso"></div>
@endsection

@section('otherscript') 	
   	<script>
      // var rootURL = '{{ URL::base().'/ksos' }}';
      // Populate the field with the right data for the modal when clicked
      /*
      $('.edit_toggler').each(function(index,elem) {
          $(elem).click(function(){
            var id = $(elem).attr('rel');
            //$('#editkso').load(rootURL + '/editksolist/' + id );
            
          });
      });

     $('#btnNew').click(function() {
        $('#editkso').load(rootURL + '/formkso' );
        return false;
      });
      */
    </script>
@endsection
@layout('themes.layouts.common')

@section('header')
	<div class="header">
   			<h1 class="page-title">List Work Order </h1>
    </div>
        
    <ul class="breadcrumb">
        <li><a href="">Home</a> <span class="divider">/</span></li>
        <li class="active">List Work Order</li>
    </ul>
@endsection

@section('content')
    
    <div class="block">
        <div class="block-heading">
            <a href="#widgetGroup1" data-toggle="collapse">Search</a>       
        </div>
        
        <div class="block-body collapse" id="widgetGroup1"><br>
            <form action="" method="get" id="filter">
              {{ Form::select('search', array('taxi_number' => 'Nomor Body', 'mechanic' => 'Mekanik','inserted_date_set'=>'Tanggal WO'), $searchby) }}
              <div class="input-append">
                
                {{ Form::text('q', $q , array('class'=>'span12')) }}
                <button class="btn" type="submit"><i class="icon-search"></i></button>
              </div>
            </form>
        </div>
    </div>

	 <div class="block">
        <div class="block-heading">
            <a href="#widgetGroup2" data-toggle="collapse">Work Order List</a>       
        </div>
        
        <div class="block-body collapse in" id="widgetGroup2">

         	<table class="table table-condensed table-striped">
         		<thead>
         			<tr>
         				<th class="span1">No.</th>
         				<th><a href="{{ URL::to('warehouses/wolist/'.$status_id.'?sort=taxi_number'.$querystr) }}">Nomor Body</a></th>
         				<th><a href="{{ URL::to('warehouses/wolist/'.$status_id.'?sort=inserted_date_set'.$querystr) }}">Tanggal</a></th>
                <th><a href="{{ URL::to('warehouses/wolist/'.$status_id.'?sort=mechanic'.$querystr) }}">Mekanik</a></th>
                <th>Komplain</th>
         				<th>KM Masuk</th>
                <th>Action</th>
         			</tr>
         		</thead>
	            <tbody>
	            	<?php $no=((Input::get('page',1) * 20) - 20) + 1; ?>
                @foreach($wos->results as $wo)
	            	<tr>
	            		<td>{{ $no }}</td>
	            		<td>{{ $wo->taxi_number }}</td>
                  <td>{{ $wo->inserted_date_set }}</td>
	            		<td>{{ $wo->mechanic }}</td>
                  <td>{{ $wo->complaint }}</td>
	            		<td>{{ $wo->km }}</td>
	            		<td>
	            			<a class="btn btn-success btn-mini" href="{{ URL::to('warehouses/partrequest/'.$wo->id) }}"><i class="icon-edit icon-white"></i></a>  
                  </td>
	            	</tr>
                <?php $no++; ?>
	           		@endforeach
	            </tbody>
            </table>
            {{ $pagination }}
        </div>
	</div>

@endsection


@section('otherscript') 	
   	
@endsection
@layout('themes.layouts.common')

@section('header')
	<div class="header">
   			<h1 class="page-title">Catalog Spare Part </h1>
    </div>
        
    <ul class="breadcrumb">
        <li><a href="">Home</a> <span class="divider">/</span></li>
        <li class="active">Catalog Spare Part</li>
    </ul>
@endsection

@section('content')
    
    <div class="block">
        <div class="block-heading">
            <a href="#widgetGroup1" data-toggle="collapse">Search</a>       
        </div>
        
        <div class="block-body collapse" id="widgetGroup1"><br>
            <form action="" method="get" id="filter">
              {{ Form::select('search', array('name_sparepart' => 'Nama Part', 'part_number' => 'Nomor Part', 'sp_category' => 'Kategori', 'sp_group' => 'Group'), $searchby) }}
              <div class="input-append">
                
                {{ Form::text('q', $q , array('class'=>'span12')) }}
                <button class="btn" type="submit"><i class="icon-search"></i></button>
              </div>
            </form>
        </div>
    </div>

	 <div class="block">
        <div class="block-heading">
            <a href="#widgetGroup2" data-toggle="collapse">Spare Part List</a>       
        </div>
        
        <div class="block-body collapse in" id="widgetGroup2">

         	<table class="table table-condensed table-striped">
         		<thead>
         			<tr>
         				<th class="span1">No.</th>
         				<th><a href="{{ URL::to('sparepart/catalog?sort=name_sparepart'.$querystr) }}">Nama Part</a></th>
         				<th><a href="{{ URL::to('sparepart/catalog?sort=part_number'.$querystr) }}">Nomor Part</a></th>
                <th>Part ID</th>
         				<th>Moving Part</th>
         				<th><a href="{{ URL::to('sparepart/catalog?sort=sp_categories_id'.$querystr) }}">Category</a></th>
         				<th style="text-align: center;"><a href="{{ URL::to('sparepart/catalog?sort=price'.$querystr) }}">Harga Beli </a></th>
         				<th>Satuan</th>
         			</tr>
         		</thead>
	            <tbody>
	            	<?php $no=((Input::get('page',1) * 20) - 20) + 1; ?>
                @foreach($spareparts->results as $sp)
	            	<tr>
	            		<td>{{ $no }}</td>
	            		<td>{{ $sp->name_sparepart }}</td>
	            		<td>{{ $sp->part_number }}</td>
                  <td>{{ $sp->id }}</td>
	            		<td>
	            			@if($sp->moving == 1) 
	            				Normal 
	            			@elseif($sp->moving == 2) 
	            				Fast 
	            			@else 
	            				Slow 
	            			@endif 
	            		</td>
	            		<td>{{ Spcategorie::find($sp->sp_categories_id)->sp_category }} </td>
	            		<td style="text-align: right;">{{ number_format($sp->price, 0, ',', '.') }}</td>
	            		<td>{{ $sp->satuan }}</td>
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
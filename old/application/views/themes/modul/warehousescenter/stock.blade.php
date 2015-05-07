@layout('themes.layouts.common')

@section('header')
	<div class="header">
   			<h1 class="page-title">Stock Gudang Pusat</h1>
    </div>
        
    <ul class="breadcrumb">
        <li><a href="">Home</a> <span class="divider">/</span></li>
        <li class="active">Stock Gudang Pusat</li>
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
            <span class="block-icon pull-right">
              <button class="btn btn-info" id="btnNew" tabindex="8"><i class="icon-plus"></i></button>
            </span>
            <a href="#widgetGroup2" data-toggle="collapse">Spare Part List</a>       
        </div>
        
        <div class="block-body collapse in" id="widgetGroup2">

         	<table class="table table-condensed table-striped">
         		<thead>
         			<tr>
         				<th class="span1">No.</th>
         				<th><a href="{{ URL::to('warehousescenter/stock?sort=name_sparepart'.$querystr) }}">Nama Part</a></th>
         				<th><a href="{{ URL::to('warehousescenter/stock?sort=part_number'.$querystr) }}">Nomor Part</a></th>
         				<th>Moving Part</th>
         				<th><a href="{{ URL::to('warehousescenter/stock?sort=sp_categories_id'.$querystr) }}">Category</a></th>
         				<th style="text-align: center;"><a href="{{ URL::to('warehousescenter/stock?sort=base_price'.$querystr) }}">Harga Beli</a></th>
         				<th style="text-align: center;"><a href="{{ URL::to('warehousescenter/stock?sort=price'.$querystr) }}">Harga Jual</a></th>
         				<th style="text-align: center;"><a href="{{ URL::to('warehousescenter/stock?sort=qty'.$querystr) }}">Stock</a></th>
                <th style="text-align: center;"><a href="{{ URL::to('warehousescenter/stock?sort=min_qty'.$querystr) }}">Min Stock</a></th>
                <th>Satuan</th>
         				<th>Action</th>
         			</tr>
         		</thead>
	            <tbody>
	            	<?php $no=((Input::get('page',1) * 20) - 20) + 1; ?>
                @foreach($spareparts->results as $sp)
	            	<tr>
	            		<td>{{ $no }}</td>
	            		<td>{{ $sp->name_sparepart }}</td>
	            		<td>{{ $sp->part_number }}</td>
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
	            		<td style="text-align: right;">{{ number_format($sp->base_price, 2, ',', '.') }}</td>
	            		<td style="text-align: right;">{{ number_format($sp->price, 0, ',', '.') }}</td>
                  <td style="text-align: center;">{{ $sp->qty }}</td>
                  <td style="text-align: center;">{{ $sp->min_qty }}</td>
	            		<td>{{ $sp->satuan }}</td>
	            		<td>
	            			<a class="edit_toggler btn btn-success btn-mini" rel="{{ $sp->id }}"><i class="icon-edit icon-white"></i></a>  
                    <a class="delete_toggler btn btn-danger btn-mini" rel="{{ $sp->id }}"><i class="icon-remove-sign icon-white"></i></a>
	            		</td>
	            	</tr>
                <?php $no++; ?>
	           		@endforeach
	            </tbody>
            </table>
            {{ $pagination }}
        </div>
	</div>

<div class="modal hide fade" id="delete_sparepart">
      <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3>Are You Sure?</h3>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this sparepart?</p>
      </div>
      <div class="modal-footer">
        {{ Form::open('sparepart/delsparepart', 'POST') }}
        <a data-toggle="modal" href="#delete_sparepart" class="btn">Keep</a>
        <input type="hidden" name="id" id="postvalue" value="" />
        <input type="submit" class="btn btn-danger" value="Delete" />
        {{ Form::close() }}
      </div>
</div>

<div id="editsparepart"></div>
@endsection


@section('otherscript') 	
   	<script>
      var rootURL = '{{ URL::base().'/sparepart' }}';
      // Populate the field with the right data for the modal when clicked
      $('.delete_toggler').each(function(index,elem) {
          $(elem).click(function(){
            $('#postvalue').attr('value',$(elem).attr('rel'));
            $('#delete_sparepart').modal('show');
          });
      });

      $('.edit_toggler').each(function(index,elem) {
          $(elem).click(function(){
            var id = $(elem).attr('rel');
            $('#editsparepart').load(rootURL + '/detilsparepart/' + id );
           
          });
      });

     $('#btnNew').click(function() {
        $('#editsparepart').load(rootURL + '/newsparepart' );
        return false;
      });

    </script>
@endsection
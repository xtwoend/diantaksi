@layout('themes.layouts.common')

@section('header')
	<div class="header">
   			<h1 class="page-title">Kategori Spare Part </h1>
    </div>
        
    <ul class="breadcrumb">
        <li><a href="">Home</a> <span class="divider">/</span></li>
        <li class="active">Kategori Spare Part</li>
    </ul>
@endsection

@section('content')
	<div class="block">
        <div class="block-heading">
            <a href="#widgetGroup" data-toggle="collapse">Form Kategori Sparpart</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup"><br>
         	{{ Form::open('sparepart/category','POST',array('class'=>'form-horizontal')) }}
         		<input type="hidden" name="id" id="id" value="">
         		<input type="text" name="sp_category" id="sp_category" value="">
         		<input type="submit" value="Simpan" class="btn btn-primary">
         	{{ Form::close() }}
        </div>
	</div>


   	  <div class="block">
        <div class="block-heading">
            <a href="#widgetGroup1" data-toggle="collapse">Kategori Sparepart</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup1">
         	<table class="table table-condensed">
         		<thead>
         			<tr>
         				<th>No.</th>
         				<th>Kategori</th>
         				<th>Action</th>
         			</tr>
         		</thead>
	            <tbody>
	            @foreach($categories->results as $cat)
	            	<tr>
	            		<td class="span1">{{ $cat->id }}</td>
	            		<td>{{ $cat->sp_category }}</td>
	            		<td class="span2">
                    <a class="edit_toggler btn btn-success btn-mini" rel="{{ $cat->id }}" data-sp="{{ $cat->sp_category }}" ><i class="icon-edit icon-white"></i></a> 
                    <a class="delete_toggler btn btn-danger btn-mini" rel="{{ $cat->id }}"><i class="icon-remove-sign icon-white"></i></a>
                  </td>
	            	</tr>
	            @endforeach
	            </tbody>
            </table>
            {{ $categories->links() }}
        </div>
</div>

  <div class="modal hide fade" id="delete_category">
      <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3>Are You Sure?</h3>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this sparepart category?</p>
      </div>
      <div class="modal-footer">
        {{ Form::open('sparepart/delcategory', 'POST') }}
        <a data-toggle="modal" href="#delete_category" class="btn">Keep</a>
        <input type="hidden" name="id" id="postvalue" value="" />
        <input type="submit" class="btn btn-danger" value="Delete" />
        {{ Form::close() }}
      </div>
    </div>

@endsection

@section('otherscript') 	
   	<script>
      // Populate the field with the right data for the modal when clicked
      $('.delete_toggler').each(function(index,elem) {
          $(elem).click(function(){
            $('#postvalue').attr('value',$(elem).attr('rel'));
            $('#delete_category').modal('show');
          });
      });

      $('.edit_toggler').each(function(index,elem) {
          $(elem).click(function(){
            $('#id').attr('value',$(elem).attr('rel'));
            $('#sp_category').attr('value',$(elem).attr('data-sp'));
          });
      });
    </script>
@endsection
<div class="modal hide fade" id="edit_sparepart">
      <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3>Edit Form Spare Part</h3>
      </div>
      {{ Form::open('sparepart/save', 'POST', array('class'=>'form-horizontal')) }}
      <div class="modal-body">
        <div class="control-group">
          <label class="control-label" for="part_number">Nomor Sparepart</label>
          <div class="controls">
            {{ Form::text('part_number', ($create)? '': $sp->part_number) }}
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="name_sparepart">Nama Sparepart</label>
          <div class="controls">
            {{ Form::text('name_sparepart', ($create)? '': $sp->name_sparepart) }}
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="barcode">Barcode</label>
          <div class="controls">
            {{ Form::text('barcode', ($create)? '': $sp->barcode) }}
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="sp_categories_id">Kategori</label>
          <div class="controls">
              {{ Form::select('sp_categories_id', $categoriesoption , ($create)? '': $sp->sp_categories_id ) }}
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="sp_group_id">Group</label>
          <div class="controls">
              {{ Form::select('sp_group_id', $groupsoption , ($create)? '': $sp->sp_group_id ) }}
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="moving">Kategori Penjualan</label>
          <div class="controls">
            <?php 
              $x = ($create)? 1 : $sp->moving ; 
            ?>

            @for ($i = 2; $i <= 3; $i++)
                {{ Form::radio('moving', $i, ($i == $x )? true : false) }} 

                @if($i == 2)
                  Fast
                @else
                  Slow
                @endif

            @endfor
            
            
          </div>
        </div>
        
        <div class="control-group">
          <label class="control-label" for="base_price">Harga Beli</label>
          <div class="controls">
            {{ Form::text('base_price', ($create)? '': $sp->base_price,array('class'=>'money')) }}
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="price">Harga Jual</label>
          <div class="controls">
            {{ Form::text('price', ($create)? '': $sp->price ,array('class'=>'money')) }}
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="qty">Stock</label>
          <div class="controls">
            {{ Form::text('qty', ($create)? '': $sp->qty) }}
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="min_qty">Minimal Stock</label>
          <div class="controls">
            {{ Form::text('min_qty', ($create)? '': $sp->min_qty) }}
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="satuan">Satuan</label>
          <div class="controls">
            {{ Form::text('satuan', ($create)? '': $sp->satuan) }}
          </div>
        </div>

         <div class="control-group">
          <label class="control-label" for="isi_satuan">Isi Satuan</label>
          <div class="controls">
            {{ Form::text('isi_satuan', ($create)? '': $sp->isi_satuan) }}
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="lokasi">Tempat Penyimpanan</label>
          <div class="controls">
            {{ Form::text('lokasi', ($create)? '': $sp->lokasi) }}
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <a data-toggle="modal" href="#edit_sparepart" class="btn">Cancel</a>
        {{ Form::hidden('id', ($create)? '': $sp->id) }}
        <input type="submit" class="btn btn-warning" value="Save" />
      </div>
       {{ Form::close() }}
</div>

<script type="text/javascript">

$(function () {
  $('.money').money_field({width: 120});
   $('#edit_sparepart').modal('show');
});

</script>
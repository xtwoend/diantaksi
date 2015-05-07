@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Permintaan Barang</h1>
  </div>
        
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li><a href="{{URL::to('werehouses')}}">Warehouse</a> <span class="divider">/</span></li>
        <li class="active">permintaan barang</a></li>
    </ul>
@endsection
  
  
@section('content')<div class="row-fluid">
    <div class="block span8">
        <a href="#tablewidget" class="block-heading" data-toggle="collapse">Permintaan Sparepart dari WO</a>
        <div id="tablewidget" class="block-body collapse in">
            <table class="table">
              <thead>
                <tr>
                  <th>Nomor WO</th>
                  <th>Body</th>
                  <th>Tanggal</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach($wos  as $wo)
                <tr>
                  <td>{{ HTML::link('warehouses/approvedpartdetail/'.$wo->id, $wo->wo_number) }}</td>
                  <td>{{ Fleet::find($wo->fleet_id)->taxi_number }}</td>
                  <td>{{ $wo->inserted_date_set }}</td>
                  <td>{{ Statusperbaikan::find($wo->status)->status }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <!--<p><a href="#">More...</a></p>-->
        </div>
    </div>
    
</div>  

@endsection

@section('otherscript')

@endsection

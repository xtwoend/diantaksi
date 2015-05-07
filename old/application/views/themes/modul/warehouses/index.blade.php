@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Dashboard</h1>
  </div>
        
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li class="active">Warehouse</a></li>
    </ul>
@endsection
  
  
@section('content')
<div class="row-fluid">
  <!--
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
                  <td>{{ HTML::link('warehouses/partrequest/'.$wo->id, $wo->wo_number) }}</td>
                  <td>{{ Fleet::find($wo->fleet_id)->taxi_number }}</td>
                  <td>{{ $wo->inserted_date_set }}</td>
                  <td>{{ Statusperbaikan::find($wo->status)->status }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <p><a href="#">More...</a></p>
        </div>
    </div>
    
</div>	
	-->
<div class="row-fluid">
    <div class="block span6">
        <a href="#tablewidget" class="block-heading" data-toggle="collapse">Permintaan WO</a>
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
                  <td>{{ HTML::link('warehouses/partrequest/'.$wo->id, $wo->wo_number) }}</td>
                  <td>{{ Fleet::find($wo->fleet_id)->taxi_number }}</td>
                  <td>{{ $wo->inserted_date_set }}</td>
                  <td>{{ $wo->status }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <p><a href="{{ URL::to('warehouses/wolist/1') }}">More...</a></p>
        </div>
    </div>
    <div class="block span6">
        <a href="#widget1container" class="block-heading" data-toggle="collapse">Armada dalam perbaikan</a>
        <div id="widget1container" class="block-body collapse in">
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
                @foreach($wosonworkings  as $woon)
                <tr>
                  <td>{{ HTML::link('warehouses/partrequest/'.$woon->id, $woon->wo_number) }}</td>
                  <td>{{ Fleet::find($woon->fleet_id)->taxi_number }}</td>
                  <td>{{ $woon->inserted_date_set }}</td>
                  <td>{{ $woon->status }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <p><a href="{{ URL::to('warehouses/wolist/2') }}">More...</a></p>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="block span6">
        <a href="#tablewidget" class="block-heading" data-toggle="collapse">WO yang di tunda</a>
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
                @foreach($wosonpanding  as $wp)
                <tr>
                  <td>{{ HTML::link('warehouses/partrequest/'.$wp->id, $wp->wo_number) }}</td>
                  <td>{{ Fleet::find($wp->fleet_id)->taxi_number }}</td>
                  <td>{{ $wp->inserted_date_set }}</td>
                  <td>{{ $wp->status }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <p><a href="{{ URL::to('warehouses/wolist/4') }}">More...</a></p>
        </div>
    </div>
    <div class="block span6">
        <a href="#widget1container" class="block-heading" data-toggle="collapse">Armada selesai perbaikan</a>
        <div id="widget1container" class="block-body collapse in">
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
                @foreach($wosonfinish  as $wf)
                <tr>
                  <td>{{ HTML::link('warehouses/partrequest/'.$wf->id, $wf->wo_number) }}</td>
                  <td>{{ Fleet::find($wf->fleet_id)->taxi_number }}</td>
                  <td>{{ $wf->inserted_date_set }}</td>
                  <td>{{ $wf->status }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <p><a href="{{ URL::to('warehouses/wolist/3') }}">More...</a></p>
        </div>
    </div>
</div>
@endsection

@section('otherscript')

@endsection

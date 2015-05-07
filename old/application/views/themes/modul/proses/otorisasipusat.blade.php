@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Daftar Pengemudi</h1>
  </div>
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li><a href="{{URL::to('drivers')}}">Proses Open Block Pengemudi</a> <span class="divider">/</span></li>
        <li class="active">Otorisasi Pusat</li>
    </ul>
@endsection
  
@section('content')


<?php $status = Session::get('status'); ?>
@if($status)
<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    {{ $status }}
</div>
@endif


<div class="block">
        <div class="block-heading">
            <a href="#ss" data-toggle="collapse">Pencarian Pengemudi</a>       
        </div>
        <div class="block-body collapse" id="ss">
          <br>
            <form class="form-inline" action="{{ URL::current() }}" method="POST">
                <input name="nip" id="nip" class="input-normal" type="text" placeholder="Ketikan NIP Pengemudi"><input type="submit" class="btn btn-info" value="Cari">
            </form>
            <br> 
        </div>
  </div>

<div class="block">
        <div class="block-heading">
            <a href="#widgetGroup1" data-toggle="collapse">Daftar Pengemudi Terkena Block</a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup1">
            
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Id </th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>No Telp / HP</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($drivers->results as $driver)
                    <tr>
                        <td> {{ $driver->id }}</td>
                        <td> {{ $driver->nip }}</td>
                        <td> {{ $driver->name }}</td>
                        <td> {{ $driver->phone }}</td>
                        <td> <a class="otorisasi_toggler btn btn-success btn-mini" rel="{{ $driver->id }}">Open Blocking</a>  
                            
                           @if( Auth::user()->admin == 1 ) 
                            <a class="btn btn-success btn-mini" href="{{ URL::to('proses/openlangsung/'.$driver->id) }}">Open Langsung</a> 
                           @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $drivers->links() }}
        </div>
    </div>
 
<div id="formotorisasi"></div>

@endsection
@section('otherscript')
<script type="text/javascript">

var rootURL = '{{ URL::base().'/proses' }}';
$('.otorisasi_toggler').each(function(index,elem) {
          $(elem).click(function(){
            var id = $(elem).attr('rel');
            $('#formotorisasi').load(rootURL + '/ototisasiform/' + id );
          });
});

</script>
@endsection

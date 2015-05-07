@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">News </h1>
  </div>
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li><a href="{{URL::to('news')}}">Management News</a></li>
    </ul>
@endsection
  
@section('content')

<div class="block">
        <div class="block-heading">
             <span class="block-icon pull-right">
              <a href="{{ URL::to('news/add') }}" class="btn btn-info" >Tambah Pesan</a>
            </span>
            <a href="#widgetGroup2" data-toggle="collapse">List Pesan </a>       
        </div>
        <div class="block-body collapse in" id="widgetGroup2">
          <br>

            <table class="table table-condensed table-striped">
            <thead>

              <tr>
                <th class="span1">No.</th>
                <th>Msg Type</th>
                <th>Message</th>
                <th>Create At</th>
                <th>Expired</th>
                <th>By.</th>
                <th></th>
              </tr>
            
            </thead>
            <?php $no=1; ?>
              <tbody>
               @foreach($messages as $news)
                <tr>
                    <td>{{ $no }}</td>
                    <td>
                        @if($news->msg_type == 1)
                           <span class="label {{ $news->priority }}">Broadcast </span>
                        @elseif($news->msg_type == 2)
                            <span class="label {{ $news->priority }}">To : {{ Pool::find($news->pool_id)->pool_name }}</span>
                        @else
                            <span class="label {{ $news->priority }}">To : {{ User::find($news->user_id)->fullname }}</span>
                        @endif
                    </td>
                    <td>{{ $news->message }}</td>
                    <td>{{ $news->created_at }}</td>
                    <td>{{ $news->expired }}</td>
                    <td>{{ User::find($news->user_id)->fullname }}</td>
                    <td><a href="{{ URL::to('news/delete/'.$news->id)  }}" class="btn btn-mini btn-danger">Hapus</a></td>
                </tr>
                <?php $no++ ?>
               @endforeach
              </tbody>
            
            </table>
            
          <br> 
        </div>
    </div>


@endsection
@section('otherscript')
<script type="text/javascript">


</script>
@endsection

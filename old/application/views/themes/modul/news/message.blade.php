@layout('themes.layouts.common')

@section('header')
  <div class="header">
        <h1 class="page-title">Pesan </h1>
  </div>
    <ul class="breadcrumb">
        <li><a href="{{URL::to('admin/dashboard')}}">Home</a> <span class="divider">/</span></li>
        <li>Pesan</li>
    </ul>
@endsection
  
@section('content')


<?php 
                    $news = News::where('msg_type','=',1)->where('expired','>',date('Y-m-d H:i:s'))->get(); 
                    $msgforpool = News::where('msg_type','=',2)->where('expired','>',date('Y-m-d H:i:s'))->where('pool_id','=',Auth::user()->pool_id)->get();
                    $msgforuser = News::where('msg_type','=',3)->where('expired','>',date('Y-m-d H:i:s'))->where('to_user_id','=',Auth::user()->id)->get();
                ?> 

                    @foreach($msgforuser as $msguser)
                        <?php  
                            $x = $msguser->priority; 
                            if($x == 'label-important')
                            {
                                $c = 'alert-error';
                            }else if($x == 'label-info')
                            {
                                 $c = 'alert-info';
                            }else {
                                $c='';
                            }
                        ?>
                        <div class="alert alert-block {{ $c }}">
                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                          <h5>{{ $msguser->created_at }}</h5>
                         <span class="label">To: {{ User::find($msguser->to_user_id)->fullname }} </span> {{ $msguser->message }}
                        </div>
                    @endforeach
                    @foreach($msgforpool as $msgpool)
                        <?php  
                            $z = $msgpool->priority; 
                            if($z == 'label-important')
                            {
                                $ca = 'alert-error';
                            }else if($z == 'label-info')
                            {
                                 $ca = 'alert-info';
                            }else {
                                $ca='';
                            }
                        ?>
                        <div class="alert alert-block {{ $ca }}">
                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                          <h5>{{ $msguser->created_at }}</h5>
                         <span class="label">To: {{ Pool::find($msgpool->pool_id)->pool_name }}  </span> {{ $msgpool->message }}
                        </div>
                    @endforeach
                    @foreach($news as $new)
                        <?php  
                            $o = $new->priority; 
                            if($o == 'label-important')
                            {
                                $cx = 'alert-error';
                            }else if($o == 'label-info')
                            {
                                 $cx = 'alert-info';
                            }else {
                                $cx='';
                            }
                        ?>
                        <div class="alert alert-block {{ $cx }}">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <h5>{{ $new->created_at }}</h5>
                            {{ $new->message }}
                        </div>
                    @endforeach


@endsection
@section('otherscript')
<script type="text/javascript">


</script>
@endsection

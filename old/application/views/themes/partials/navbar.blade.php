<div class="navbar">
    <div class="navbar-shadow">
        <div class="navbar-inner">

            @if(!Auth::guest())
            <a class="changtogle brand" href="#"><span class="second"><i class="icon-th-list"></i></span></a>
                <ul class="nav pull-right">
                    <li id="fat-menu" class="dropdown">
                        <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-user"></i> {{ $user->fullname }} in {{  Pool::find($user->pool_id)->pool_name }} 
                            <i class="icon-caret-down"></i>
                        </a>
                        
                        <ul class="dropdown-menu">
                            <li>{{ HTML::link('users/changepassword', 'Change Password'); }}</li>
                            <li>{{ HTML::link('admin/logout', 'Logout'); }}</li>
                        </ul>
                    </li>       
                </ul>
            @endif
            <a class="brand" href="#"><span class="first">Operasi</span> <span class="second">Program</span></a>
        </div>
        </div>
         @if(!Auth::guest())
            <span class="notes-navbar">
                {{-- Pesan Broadcast --}}
                <?php 
                    $news = News::where('msg_type','=',1)->where('expired','>',date('Y-m-d H:i:s'))->get(); 
                    $msgforpool = News::where('msg_type','=',2)->where('expired','>',date('Y-m-d H:i:s'))->where('pool_id','=',Auth::user()->pool_id)->get();
                    $msgforuser = News::where('msg_type','=',3)->where('expired','>',date('Y-m-d H:i:s'))->where('to_user_id','=',Auth::user()->id)->get();
                ?> 
                
                <ul id="ticker01">
                    @foreach($msgforuser as $msguser)
                        <li><span class="label {{ $msguser->priority }}">{{ $msguser->created_at }}</span><span class="label">To: {{ User::find($msguser->to_user_id)->fullname }} </span> <a href="{{  URL::to('news/message') }}">{{ Str::limit($msguser->message,100) }}</a></li>
                    @endforeach
                    @foreach($msgforpool as $msgpool)
                        <li><span class="label {{ $msgpool->priority }}">{{ $msgpool->created_at }}</span><span class="label">To: {{ Pool::find($msgpool->pool_id)->pool_name }} </span><a href="{{  URL::to('news/message') }}">{{ Str::limit($msgpool->message,100) }}</a></li>
                    @endforeach
                    @foreach($news as $new)
                        <li><span class="label {{ $new->priority }}">{{ $new->created_at }}</span><a href="{{  URL::to('news/message') }}">{{ Str::limit($new->message,100) }}</a></li>
                    @endforeach

                </ul>
            </span>
             @endif
</div>

<!-- .aside -->
        <aside class="bg-black dk aside hidden-print" id="nav">          
          <section class="vbox">
            <section class="w-f-md scrollable">
              <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="10px" data-railOpacity="0.2">
                <!-- nav -->                 
                <nav class="nav-primary hidden-xs">
                  <ul class="nav bg clearfix" data-ride="collapse">
                    <li class="hidden-nav-xs padder m-t m-b-sm text-xs text-muted">
                      Laporan Operasi 
                    </li>
                    <li>
                      <a href="{{ url('reports/daily') }}">
                        <i class="icon-layers icon"></i>
                        <span class="font-bold">Laporan Harian</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{ url('reports/range') }}">
                        <i class="icon-layers icon"></i>
                        <span class="font-bold">Laporan Kas Harian</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{ url('reports/armada') }}">
                        <i class="icon-layers icon"></i>
                        <span class="font-bold">Lap. Finan. Armda</span>
                      </a>
                    </li>
                    {{-- 
                    <li>
                      <a href="{{ url('reports/driver') }}">
                        <i class="icon-layers icon"></i>
                        <span class="font-bold">Lap. Finan. Driver</span>
                      </a>
                    </li>
                    --}}
                    <li class="m-b hidden-nav-xs"></li>
                  </ul>
                  @if(Auth::user()->can('kasir'))
                  <ul class="nav bg clearfix" data-ride="collapse">
                    <li class="hidden-nav-xs padder m-t m-b-sm text-xs text-muted">
                      Financial menu
                    </li>
                     <li>
                      <a href="{{ url('financials') }}">
                        <i class="icon-layers icon"></i>
                        <span class="font-bold">Setoran Operasi</span>
                      </a>
                    </li>
                  </ul>
                  @endif
                  @if(Auth::user()->can('kontrol-pool'))
                  <ul class="nav" data-ride="collapse">
                    <li class="hidden-nav-xs padder m-t m-b-sm text-xs text-muted">
                      Menu Controll 
                    </li>
                    <li >
                      <a href="#" class="auto">
                        <span class="pull-right text-muted">
                          <i class="fa fa-angle-left text"></i>
                          <i class="fa fa-angle-down text-active"></i>
                        </span>
                        <i class="icon-screen-desktop icon">
                        </i>
                        <span>Kontrol Pool</span>
                      </a>
                      <ul class="nav dk text-sm">
                        @foreach(App\Diantaksi\Eloquent\Pool::orderBy('pool_name','asc')->get() as $pool )
                          <li >
                            <a href="{{ url('change', ['pool_id'=> $pool->id]) }}" class="auto">                                                        
                              <i class="fa fa-angle-right text-xs"></i>

                              <span>{{ $pool->pool_name }}</span>
                            </a>
                          </li>
                        @endforeach
                      </ul>
                    </li>
                  </ul>
                  @endif
                </nav>
                <!-- / nav -->
              </div>
            </section>
            
            <footer class="footer hidden-xs no-padder text-center-nav-xs">
              <div class="bg hidden-xs ">
                  <div class="dropdown dropup wrapper-sm clearfix">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <span class="thumb-sm avatar pull-left m-l-xs">                        
                        <img src="/images/a3.png" class="dker" alt="...">
                        <i class="on b-black"></i>
                      </span>
                      <span class="hidden-nav-xs clear">
                        <span class="block m-l">
                          <strong class="font-bold text-lt">{{ Auth::user()->fullname }}</strong> 
                          <b class="caret"></b>
                        </span>
                        <span class="text-muted text-xs block m-l">{{ Auth::user()->pool->pool_name }}</span>
                      </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight aside text-left">                      
                      <li>
                        <span class="arrow bottom hidden-nav-xs"></span>
                        <a href="#">Settings</a>
                      </li>
                      <li class="divider"></li>
                      <li>
                        <a href="{{ url('auth/logout') }}">Logout</a>
                      </li>
                    </ul>
                  </div>
                </div>            
              </footer>
          </section>
        </aside>
        <!-- /.aside -->
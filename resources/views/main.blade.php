@extends('layout')

@section('body')

    <section class="vbox">
      <section class="hbox stretch">
          @include('partials.sidebar')
            <section>
              <section class="vbox"> 
                <div class="navbar-header aside bg-info nav-xs visible-xs">
                    <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen,open" data-target="#nav,html">
                      <i class="icon-list"></i>
                    </a>
                    <a href="#" class="navbar-brand text-lt">
                      <span class="hidden-nav-xs m-l-sm">Dian Taksi</span>
                    </a>
                    <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".user">
                      <i class="icon-settings"></i>
                    </a>
                    <ul class="nav navbar-nav m-n hidden-xs nav-user user">
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle bg clear" data-toggle="dropdown">
                          <span class="thumb-sm avatar pull-right m-t-n-sm m-b-n-sm m-l-sm">
                            <img src="/images/a0.png" alt="...">
                          </span>
                          {{ Auth::user()->fullname }}
                          <span class="text-muted block">{{ Auth::user()->pool->pool_name }}</span>
                          <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight">            
                          <li>
                            <span class="arrow top"></span>
                            <a href="#">Settings</a>
                          </li>
                          <li class="divider"></li>
                          <li>
                            <a href="{{ url('auth/logout') }}">Logout</a>
                          </li>
                        </ul>
                      </li>
                    </ul>
                </div>     
                @yield('content')
              </section>
            </section>          
          </section>
            <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
          </section>
      </section>

    </section>    
@stop
@extends('layout')

@section('body')

    <section class="vbox">
      {{-- 
      @include('partials.header')
      --}}  
      <section class="hbox stretch">
          @include('partials.sidebar')
            <section>
              <section class="vbox">             
                @yield('content')
              </section>
            </section>          
          </section>
            <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
          </section>
      </section>

    </section>    
@stop
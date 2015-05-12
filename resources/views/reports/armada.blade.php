@extends('main')

@section('content')
<section id="content">
	<section class="vbox">
        <section class="hbox stretch">
                <!-- side content -->
                <aside class="aside-sm bg-light dk" id="sidebar">
                  <section class="vbox animated fadeInUp">
                    <section class="scrollable hover">
                      <div class="list-group no-radius no-border no-bg m-t-n-xxs m-b-none auto">
                        @foreach ($ksos as $kso) 
                            <a href="{{ url('reports/armada', [$kso->id]) }}" class="list-group-item">
                              {{ $kso->taxi_number }}
                            </a>
                        @endforeach
                      </div>
                    </section>
                  </section>
                </aside>
                <!-- / side content -->
                <section>
                  <section class="vbox">
                    <section class="scrollable padder-lg">
                      
                    </section>                    
                  </section>
                </section>
        </section>        
	</section>
</section>
@endsection


@section('js')
<script type="text/javascript">

</script>

@endsection
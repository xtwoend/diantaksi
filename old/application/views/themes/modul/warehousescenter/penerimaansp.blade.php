@layout('themes.layouts.common')

@section('header')
	<div class="header">
   			<h1 class="page-title">Penerimaan Barang</h1>
    </div>
        
    <ul class="breadcrumb">
        <li><a href="">Home</a> <span class="divider">/</span></li>
        <li class="active">Penerimaan Barang</li>
    </ul>
@endsection

@section('content')
<app ng-app="penerimaanbarang" ng-controller="penerimaanCtrl">
      <div class="block" id="formspk" >
          <div class="block-heading">
              <a href="#widget-info" data-toggle="collapse">Form Penerimaan Spare Part</a>
          </div>
          <div class="block-body collapse in" id="widget-info">
            <br>
            <div class="row-fluid"> <!-- Start pembagian kolom -->
              <form action="" method="POST" class="form-horizontal">
                <div class="span6">
                    
                     <div class="control-group">
                      <label class="control-label" for="pp_number">Nomor PP</label>
                      <div class="controls">
                        <div class="input-append">
                          <input class="span11" id="pp_number" type="text" ng-model="nomorpp">
                          <button class="btn" id="btnSearch" type="button" ng-click="caripp()"><i class="icon-search"></i></button> 
                        </div> 
                      </div>
                    </div>

                    <div class="control-group">
                      <label class="control-label" for="rr_number">Nomor RR</label>
                      <div class="controls">
                        <input type="hidden" id="rr_id" readonly>
                        <input type="text" id="rr_number" ng-model="rrdata.no_doc" placeholder="No RR" readonly>
                      </div>
                    </div>

                     <div class="control-group">
                      <label class="control-label" for="date">Nomor Nota </label>
                      <div class="controls">
                        <input type="text" id="pool_id" ng-model="rrdata.nota_number" placeholder="Nomor Nota" >
                      </div>
                    </div>

                    <div class="control-group">
                      <label class="control-label" for="date">Tanggal Terima</label>
                      <div class="controls">
                        
                          <input name="tanggal_terima" class="input-small" data-date-format="yyyy-mm-dd" id="tanggalterima" type="text" ng-model="rrdata.tanggal_terima" b-datepicker >
                          
                      </div>
                    </div>

                    <div class="control-group">
                      <label class="control-label" for="date">Terima Dari </label>
                      <div class="controls">
                      	{{ Form::select('id_supplier', $suppliers, '', array('ng-model'=>'rrdata.supplier_id')) }}
                      </div>
                    </div>
                    
                    <div class="control-group">
                      <label class="control-label" for="date">Yang Menerima</label>
                      <div class="controls">
                        <input type="text" id="pool_id" placeholder="Pool" value="{{ Pool::find(Auth::user()->pool_id)->pool_name }}">
                      </div>
                    </div>
              
                </div>
                <div class="span6">
                  
                      Catatan: <br>
                        <textarea rows="4" style="width:97%;" id="catatan" ng-model="rrdata.catatan"></textarea>
                    <button id="createrr" class="btn btn-primary" ng-click="simpanrr()">Buat</button>
                    [[ rrdata ]]
                </div>  

                </form>
                
            </div>  <!-- end pembagian kolom -->

            <br>
          </div>
        </div>
                    <div class="block">
                          <div class="block-heading">
                              <span class="block-icon pull-right">
                                <button class="btn btn-primary" id="preview"><i class="icon-print"></i> PP Priview </button>
                              </span>
                              <a>Input Sparepart </a>
                          </div><form class="form-horizontal">
                          <div class="block-body">
                            <div class="control-group">
                              <label class="control-label" for="part_number">Nomor Part</label>
                              <div class="controls">
                                <input id="part_id" type="hidden" autocomplete="off">
                                <div class="input-append">
                                  <input class="span9" tabindex="1" id="part_number" type="text" autocomplete="off" placeholder="Ketikan Nomor Part Disini">
                                  <button class="btn" type="button" id="cari">Cari</button>
                                </div>
                                
                                - <input class="span4" id="part_name" type="text" readonly>
                              </div>
                              <input type="text" class="form-control" filter="onFilter(parsedResponse)" selected-item="selectedItem" url="api/person/?name=%QUERY" value-key="name" ng-typeahead>
                            </div>

                            <div class="control-group">
                              <label class="control-label" for="qty">Jumlah</label>
                              <div class="controls">
                                <input class="span3" tabindex="2" id="qty" type="text" placeholder="Qty" value="1">
                              </div>
                            </div>

                            <div class="control-group">
                              <label class="control-label" for="ket">Keterangan</label>
                              <div class="controls">
                                <input class="span7" tabindex="3" id="ket" type="text" placeholder="Keterangan" value="">
                              
                              </div>
                            </div>

                            <div class="control-group">
                              <label class="control-label" for="part_number"></label>
                              <div class="controls">
                                <button class="btn" tabindex="4" type="button" id="addpart">Add</button>
                              </div>
                            </div>

                            </form>

                            <table class="table table-condensed table-hover">
                              <thead>
                                <tr> 
                                    <th class="span1">No. </th>
                                    <th class="span3">Nomor Part </th>
                                    <th class="span3">Nama </th>
                                    <th class="span1">Request Qty </th>
                                    <th class="span1">Real Qty </th>
                                    <th class="span1">Keterangan</th>
                                    <th class="span1"></th>
                                </tr>
                              </thead>
                              <tbody>
                                
                              
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><input type="text"></td>
                                    <td></td>
                                    <td><a rel="" class="delete_part btn btn-mini btn-danger"><i class="icon icon-white icon-remove"></i></a></td>
                                </tr>
                                
                                <tr>
                                  <td colspan="5" ng-show="partlists.lengt > 0">Part item is empty.</td>
                                </tr>
                              
                              </tbody>
                            </table>
                            
                          </div>
                      </div>
</app>
@endsection


@section('otherscript')
<script src="{{asset('js/underscore-min.js')}}"></script>
<script src="{{asset('lib/angularjs/angular.min.js')}}"></script>
<script src="{{asset('lib/angularjs/angular-resource.min.js')}}"></script>
<script src="{{asset('lib/angularjs.directive/bDatepicker.js')}}"></script>
<script src="{{asset('lib/angularjs.typeahead/angular-typeahead.js')}}"></script>
<script type="text/javascript">
	$(function () {  
        $('#tanggalterima').datepicker({
              format: 'yyyy-mm-dd'
        });
    });
  var app = angular.module('penerimaanbarang', ['ngResource','bDatepicker'])
        .config(['$interpolateProvider', function ($interpolateProvider) {
            $interpolateProvider.startSymbol('[[');
            $interpolateProvider.endSymbol(']]');
        }]);
  app.controller('penerimaanCtrl',function($scope, $filter, Penerimaan){
    $scope.nomorpp = '';
    
    $scope.rrdata = {}
   
    $scope.caripp = function(){
      Penerimaan.ppinfo({ nomorpp: $scope.nomorpp }, function(res){
        if(res.status){
            Penerimaan.generatenumber({}, function(res){
              $scope.rrdata.no_doc = res.number;
            });
            $scope.rrdata.pool_id = '{{ Auth::user()->pool_id }}';
            $scope.rrdata.reguest_sparepart_id = res.data.id;
        }
      });
    }

    $scope.simpanrr = function(){
      Penerimaan.simpan($scope.rrdata,function(res){
        console.log(res);
      });
    }


    $scope.people = Person.query();
  });

  app.factory('Penerimaan', ['$resource', function($resource) {
          return $resource( base_url + '/warehousescenter/:action/:query',null, 
            { 
              ppinfo: {
                  method: 'GET',
                  params: {
                        action: 'infopp',
                        query: '@query',
                    },
                  isArray:false,
              },
              generatenumber: {
                  method: 'GET',
                  params: {
                        action: 'NumberRR',
                        query: '@query',
                    },
              },

              simpan: {
                  method: 'POST',
                  params: {
                        action: 'ps',
                        query: '@query',
                    },
                  isArray:false,
              },

              
            }); 
  }]);
</script>
@endsection


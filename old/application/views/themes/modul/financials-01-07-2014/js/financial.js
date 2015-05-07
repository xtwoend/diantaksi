var currentFleet;
      
       $(function () {
        $('#datepicker').datepicker({
              format: 'yyyy-mm-dd'
          });
        $('#normal').button('toggle');
        $('.money').money_field({width: 120});
        $('.moneypembayaran').money_field({width: 290});

        $('#pay_cash').keyup(function() {
           var total = $('#total').val();
           var cash = $(this).val();
           var ks = cash - total;
           $('#ks').val(ks);
        });

        // fungsi tab index & default payment
        $('input').bind('keypress', function(eInner) {
            if (eInner.keyCode == 13) //if its a enter key
            {   
                var tabindex = $(this).attr('tabindex');
                var att_id = $(this).attr('id');
                var defPay = 0;
                $.each( currentFleet, function( key, value ) {
                  if(key === att_id){
                    defPay = parseInt(value);
                  }
                });
                var val = Math.abs(parseInt($('#' + att_id).val()) || 0);
                var defaultPay = val < defPay ? defPay : val; 
                if(att_id === 'tag_hut_lama' || att_id === 'tag_other' ){
                  defaultPay = val;
                }
                // set default payment
                $('#' + att_id).val(defaultPay); 
                totalPayment();

                tabindex++; //increment tabindex
                $('[tabindex=' + tabindex + ']').focus();            
                
                return false;
            }
        });
      });
      
      function totalPayment()
      { 
        var a,b,pot,d,e,f,g,h,i,j,k,l,m;
        a = parseInt($('#setoran_wajib').val());
        b = parseInt($('#tab_sp').val());
        pot = parseInt($('#pot').val());
        d = parseInt($('#denda').val());
        e = parseInt($('#iuran_laka').val());
        f = parseInt($('#biaya_tc').val());
        //tagihan
        h = parseInt($('#tag_spart').val());
        i = parseInt($('#tag_ks').val());
        j = parseInt($('#tag_cicilan_dp').val());
        k = parseInt($('#tag_dp_spart').val());
        l = parseInt($('#tag_hut_lama').val());
        m = parseInt($('#tag_other').val());

        var tot = ( a + b + d + e + f + h + i + j + k + l + m ) - pot ;
        $('#total').val(tot);
      }

      findAll($('#date').val());
      
      $('#btnSearch').click(function() {
        search($('#searchKey').val());
        return false;
      });

      $('#armadaList a').live('click', function() {
        findById($(this).data('identity'));
      });

      $('#settingSave').click(function() {
        var dayof = $('button[name="dayof"].active').val();
        findAll($('#date').val());
        return false;
      });

      function search(searchKey) {
        if (searchKey == '') 
          findAll($('#date').val());
        else
          findByName(searchKey);
      }

      function findAll(dateSchedule) {
        console.log('findAll');
        $.ajax({
          type: 'GET',
          url: rootURL + '/allfleets/' + dateSchedule,
          dataType: "json", // data type of response
          success: renderList
        });
      }

      function findByName(searchKey) {
        var dataJSON = JSON.stringify({
          "taxi_number": searchKey, 
          "date": $('#date').val(), 
          });

        console.log('findByName: ' + searchKey);
        $.ajax({
          type: 'POST',
          contentType: 'application/json',
          url: rootURL + '/search',
          dataType: "json",
          data: dataJSON,
          success: renderList 
        });
      }

      function findById(id) {

          var dayof = $('button[name="dayof"].active').val();
          var total = $('#total').val();
          var cash = $('#pay_cash').val();
          var ks = cash - total;
          $('#ks').val(ks);
          $('#pay_cash').val('');
          $('#tag_ks').focus();
          var dataJSON = JSON.stringify({
            "id": id, 
            "dayof": dayof, 
          });

        console.log('findById: ' + id);
        $.ajax({
          type: 'POST',
          url: rootURL + '/findbyid',
          dataType: "json",
          data: dataJSON,
          success: function(data){
            $('#btnSimpan').show();
            console.log('findById success: ' + data.taxi_number);
            currentFleet = data;
            renderDetails(currentFleet);

          }
        });
      }

      function addsetoran() {
        console.log('addFinancials');
        $.ajax({
            type: 'POST',
            contentType: 'application/json',
            url: rootURL,
            dataType: "json",
            data: formToJSON(),
            success: function(data, textStatus, jqXHR){
                alert('Wine created successfully');
                $('#btnSimpan').show();
                $('#wineId').val(data.id);
            },
            error: function(jqXHR, textStatus, errorThrown){
                alert('addWine error: ' + textStatus);
            }
        });
      }


      function renderList(data) {
        // JAX-RS serializes an empty list as null, and a 'collection of one' as an object (not an 'array of one')
        var list = data == null ? [] : (data.fleet instanceof Array ? data.fleet : [data.fleet]);
        $('#armadaList li').remove();
        $.each(list, function(index, fleet) {
          $('#armadaList').append('<li><a href="#" data-identity="' + fleet.id + '">'+fleet.taxi_number+'</a></li>');
        });
      }

      function renderDetails(data) {
        var driver = data.name + ' ( ' + data.nip + ' ) ';
        var fleet  = data.taxi_number + ' ( ' + data.police_number + ' ) ';        
        $('#infoFleet').text(fleet);
        $('#infoDriver').text(driver);

        //tagihan perorangan
        $('#setoran_wajib').val(parseInt(data.setoran_wajib));
        $('#tab_sp').val(parseInt(data.tab_sp));
        $('#pot').val(parseInt(data.pot));
        $('#denda').val(parseInt(data.denda));
        $('#iuran_laka').val(parseInt(data.iuran_laka));
        $('#biaya_tc').val(parseInt(data.biaya_tc));
        $('#total').val(parseInt(data.total));

        //tagihan
        $('#tag_spart').val(parseInt(data.tag_spart));
        $('#tag_ks').val(parseInt(data.tag_ks));
        $('#tag_cicilan_dp').val(parseInt(data.tag_cicilan_dp));
        $('#tag_dp_spart').val(parseInt(data.tag_dp_spart));
        $('#tag_hut_lama').val(parseInt(data.tag_hut_lama));
        $('#tag_other').val(parseInt(data.tag_other));

        //in-out time
        $('#in_time').text(data.in_time);
      }
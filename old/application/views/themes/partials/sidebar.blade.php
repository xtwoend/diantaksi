  
    <div class="sidebar-nav">
        <a href="#jam-menu" class="nav-header" data-toggle="collapse"><i class="icon-calendar icon-large"></i><span id="date_time"></span></a>
        <a href="#" id="chat" class="nav-header" data-toggle="collapse"><i class="icon-comments icon-large"></i>Mulai Ngobrol</a>
        @if(in_array(10, $user_roles))
        <a href="#kontrolmenu" class="nav-header" data-toggle="collapse"><i class="icon-sitemap icon-large"></i>Kontrol Pool</a>
        <ul id="kontrolmenu" class="nav nav-list collapse">
            @foreach(Pool::order_by('pool_name','asc')->get() as $pool )
                <li>{{ Html::link('users/swichpool/'.$pool->id,$pool->pool_name) }}</li>
            @endforeach
        </ul>
        @endif
        
        @if (in_array(6, $user_roles))
        <a href="#dashboard-menu" class="nav-header" data-toggle="collapse"><i class="icon-truck icon-large"></i>Operasi menu</a>
        <ul id="dashboard-menu" class="nav nav-list collapse">
            <li>{{ Html::link('/','Dashboard') }}</li>
            <!--
            <li>{{ Html::link('/checkouts','Armada Keluar') }}</li>
            <li>{{ Html::link('/checkins','Armada Masuk') }}</li>
            -->
            <li>{{ Html::link('/checkins/checkfisik','Check Fisik Armada') }}</li> 
            <li>{{ Html::link('/checkouts/spj','Cetak SPJ') }}</li>
            <li>{{ Html::link('/checkouts/qzspj','Cetak SPJ Trial') }}</li>
            <li>{{ Html::link('/workshops/wo','Pembuatan SPK') }}</li>
            <li>{{ Html::link('/workshops/woonoperasi','Daftar WO Bengkel') }}</li>
            <li>{{ Html::link('/warehouses/approvedpart','Pesetujuan Sparepart') }}</li>
            <li>{{ Html::link('/proses','Proses Pengemudi') }}</li>
            <li>{{ Html::link('/proses/openblock','Buka Block Pengemudi') }}</li>
            <li>{{ Html::link('/drivers/pengemudiactive','Daftar Pengemudi Aktif') }}</li>
        </ul>
        @endif

        @if (in_array(6, $user_roles))
        <a href="#schedule-menu" class="nav-header" data-toggle="collapse"><i class="icon-calendar icon-large"></i>Schedule menu</a>
        <ul id="schedule-menu" class="nav nav-list collapse">
            <li>{{ Html::link('/schedule/groups','Kelompok Armada') }}</li>
            <li>{{ Html::link('/schedule','Jadwal Armada') }}</li>
            <li>{{ Html::link('/schedule/report','Report') }}</li>
            <li>{{ Html::link('/schedule/mastersch','Master Jadwal Armada') }}</li>
        </ul>
        @endif
        
        @if (in_array(13, $user_roles))
        <a href="#pemberdayaan-menu" class="nav-header" data-toggle="collapse"><i class="icon-group icon-large"></i>Pemberdayaan Pengemudi</a>
        <ul id="pemberdayaan-menu" class="nav nav-list collapse">
            <li>{{ Html::link('/','Dashboard') }}</li>
            <li>{{ Html::link('/cardcontrols/fleets','Kartu Kontrol Armada') }}</li>
            <li>{{ Html::link('/cardcontrols/drivers','Kartu Kontrol Pengemudi') }}</li>
            <li>{{ Html::link('/drivers','Manage Pengemudi') }}</li>
            <li>{{ Html::link('/pemberdayaan','Daftar Perserta Pelatihan') }}</li>
        </ul>
        @endif


        @if (in_array(8, $user_roles))
        <a href="#security-menu" class="nav-header" data-toggle="collapse"><i class="icon-dashboard icon-large"></i>Security menu</a>
        <ul id="security-menu" class="nav nav-list collapse">
            <li>{{ Html::link('/','Dashboard') }}</li>
            <li>{{ Html::link('/checkouts','Armada Keluar') }}</li>
            <li>{{ Html::link('/checkins','Armada Masuk') }}</li>
            <li>{{ Html::link('/fleets/bp','Armada BP') }}</li>
            <li>{{ Html::link('/reports/checkinout','Report Check In & Out') }}</li>
        </ul>
        @endif

        @if (in_array(2, $user_roles))
        <a href="#financials-menu" class="nav-header" data-toggle="collapse"><i class="icon-money icon-large"></i>Financials menu</a>
        <ul id="financials-menu" class="nav nav-list collapse">
            <li>{{ Html::link('/','Dashboard') }}</li>
            <li>{{ Html::link('/financials','Setoran Operasi') }}</li>
            <li>{{ Html::link('/financials/qzfinancial','Setoran Operasi Trial') }}</li>
        </ul>
        @endif

        @if (in_array(9, $user_roles))
        <a href="#statistik-menu" class="nav-header" data-toggle="collapse"><i class="icon-bar-chart icon-large"></i>Statistik Pool</a>
        <ul id="statistik-menu" class="nav nav-list collapse">
            <li>{{ Html::link('/reports/daily','Statistik Pendapatan Harian') }}</li>
            <li>{{ Html::link('/reportsnew/monthly','Statistik Pendapatan Bulanan') }}</li>
            <li>{{ Html::link('/reports/downdaily','Statistik Ketekoran Harian') }}</li>
            <!--<li>{{ Html::link('/reports/downmonthly','Statistik Ketekoran Bulanan') }}</li>-->
            <li>{{ Html::link('/reports/ksmurni','Statistik KS Murni') }}</li>

        </ul>
        @endif
        @if (in_array(9, $user_roles))
        <a href="#reportops-menu" class="nav-header" data-toggle="collapse"><i class="icon-list-alt icon-large"></i>Report Operasi</a>
        <ul id="reportops-menu" class="nav nav-list collapse">
            <li><a href="http://118.91.130.220" target="_blank">Report Harian</a> </li>
            <!--
            <li>{{ Html::link('/financials/reportdaily','Report Harian') }}</li>
            <li>{{ Html::link('/financials/reportmonthly','Report Kas Harian') }}</li>
             -->
            <li>{{ Html::link('/reports/checkinoutreport','Laporan Waktu') }}</li>
            <li>{{ Html::link('/reports/baparchive','Berkas BAP Harian') }}</li>
            <li>{{ Html::link('/reports/checkinout','Report Check In & Out') }}</li>
           
            <!--
            <li>{{ Html::link('/reportops/rekapsetoran','Rekap Setoran Armda Bulanan') }}</li>
            -->
             <!-- RENCANA BS BULANAN -->
            
            <li>{{ Html::link('/reportops','Report Hutang Armada') }}</li>
            <li>{{ Html::link('/financials/reportbs','Report Armada BS') }}</li>
            <!--
            <li>{{ Html::link('/cardcontrols/fleets','Kartu Kontrol Armada') }}</li>
            -->
            <li>{{ Html::link('/warehouses/pemakaianunit','Pemakain Sparepart Armada') }}</li>
            <li>{{ Html::link('/cardcontrols/drivers','Kartu Kontrol Pengemudi') }}</li>
            
        </ul>
        @endif

        @if (in_array(3, $user_roles))
        <a href="#management-menu" class="nav-header" data-toggle="collapse"><i class="icon-copy icon-large"></i>Management KSO</a>
        <ul id="management-menu" class="nav nav-list collapse">
            <li>{{ Html::link('/ksos','Perjanjian KSO') }}</li>
            <li>{{ Html::link('/ksos/listkso','List KSO Per POOL') }}</li>
            <li>{{ Html::link('/financials/editpay','Edit Setoran Manual') }}</li>
            <li>{{ Html::link('/drivers','Manage Pengemudi') }}</li>
            <li>{{ Html::link('/fleets','Manage Armada') }}</li>
            <!--<li>{{ Html::link('/settingcicilan','Setting Kewajiban Cicilan') }}</li>-->
            <li>{{ Html::link('/cardcontrols/fleetskso','Kartu Kontrol Armada KSO') }}</li>
            <li>{{ Html::link('/cardcontrols/reportdaily','Report Harian Detail') }}</li>
            <li>{{ Html::link('/proses/otorisasipusat','Otorisasi Open Block') }}</li>
            
        </ul>
        <a href="#message-menu" class="nav-header" data-toggle="collapse"><i class="icon-envelope icon-large"></i>Message</a>
        <ul id="message-menu" class="nav nav-list collapse">
            <li>{{ Html::link('/news','Manage Pesan') }}</li>
            <li>{{ Html::link('/news/message','Baca Pesan') }}</li>
        </ul>
        @endif
       
        @if (in_array(11, $user_roles))
        <a href="#management-anak-asuh" class="nav-header" data-toggle="collapse"><i class="icon-user icon-large"></i>Management Bapak Asuh</a>
        <ul id="management-anak-asuh" class="nav nav-list collapse">
            <li>{{ Html::link('/anakasuh','Dashboard Report') }}</li>
            <li>{{ Html::link('/anakasuh/manage','Manage Bapak Asuh') }}</li>
            <li>{{ Html::link('/anakasuh/report','Report Bapak Asuh') }}</li>
        </ul>
        @endif

        @if (in_array(12, $user_roles))
        <a href="#report-anak-asuh" class="nav-header" data-toggle="collapse"><i class="icon-group icon-large"></i>Report Anak Asuh</a>
        <ul id="report-anak-asuh" class="nav nav-list collapse">
            <li>{{ Html::link('/anakasuh/financialreport','Setoran Anak Asuh') }}</li>
            <li>{{ Html::link('/anakasuh/financialreportcard','Kartu Setoran Anak Asuh') }}</li>
        </ul>
        @endif

        @if (in_array(4, $user_roles))
        <a href="#invetory-menu" class="nav-header" data-toggle="collapse"><i class="icon-home icon-large"></i>Gudang Pool</a>
        <ul id="invetory-menu" class="nav nav-list collapse">
            <li>{{ Html::link('/warehouses','Dashborad') }}</li>
            <li>{{ Html::link('/warehouses/pemakaianunit','Pemakaian Sparepart Unit') }}</li>
            <li>{{ Html::link('/warehouses/bkb','Daftar Pengeluaran Barang') }}</li>
            
            <li>{{ Html::link('/warehousescenter/pplist','Permintaan Sparepart') }}</li>
            <li>{{ Html::link('/warehousescenter/ps','Penerimaan Sparepart') }}</li>

            <li>{{ Html::link('/warehouses/stockspart','Kartu Stock Barang') }}</li>
            <li>{{ Html::link('/warehouses/stock','Stock Gudang Pool') }}</li>
            <li>{{ Html::link('/sparepart/catalog','Catalog Sparepart') }}</li>

            <!--
            <li>{{ Html::link('/warehouses/partrequest','Permintaan Barang') }}</li>
            <li>{{ Html::link('/warehouses/receiptpart','Penerimaan Barang') }}</li>
            <li>{{ Html::link('/warehouses/partouts','Pengeluaran Barang') }}</li>
            -->
            <li>{{ Html::link('/warehousescenter/pemakaianunit','Kartu Pemakaian Unit Ber Body') }}</li>
        </ul>
        @endif
        @if (in_array(5, $user_roles))
        <a href="#workshop-menu" class="nav-header" data-toggle="collapse"><i class="icon-wrench icon-large"></i>Bengkel menu</a>
        <ul id="workshop-menu" class="nav nav-list collapse">
            <li>{{ Html::link('/workshops','Dashboard') }}</li>
            <!--
            <li>{{ Html::link('/workshops/maintenance','Jadwal Perawatan') }}</li>-->
            <li>{{ Html::link('/workshops/wo','Pembuatan SPK') }}</li>
            <li>{{ Html::link('/sparepart/catalog','Catalog Sparepart') }}</li>
            
        </ul>
        @endif

        @if (in_array(7,$user_roles)) 
        <a href="#gudang-pusatmenu" class="nav-header" data-toggle="collapse"><i class="icon-home icon-large"></i>Gudang Pusat</a>
        <ul id="gudang-pusatmenu" class="nav nav-list collapse">
            <li>{{ Html::link('/warehousescenter','Dashboard') }}</li>
            <li>{{ Html::link('/sparepart/catalog','Catalog Sparepart') }}</li>
            <li>{{ Html::link('/warehousescenter/stock','Stock Gudang Pusat') }}</li>
            <!--
            <li>{{ Html::link('/warehousescenter/partrequest','Permintaan Part dari Pool') }}</li>
            <li>{{ Html::link('/warehousescenter/partrequest','Pengeluaran Part ke Pool') }}</li>
            -->
            <li>{{ Html::link('/warehousescenter/pplist','Permintaan Sparepart') }}</li>
            <li>{{ Html::link('/warehousescenter/rrlist','Penerimaan Sparepart') }}</li>


            <li>{{ Html::link('/warehousescenter/pemakaianunit','Kartu Pemakaian Unit All') }}</li>
        </ul>

        <a href="#gudang-pusatmenu2" class="nav-header" data-toggle="collapse"><i class="icon-cogs icon-large"></i>Master Spare Part</a>
        <ul id="gudang-pusatmenu2" class="nav nav-list collapse">
            <li>{{ Html::link('/sparepart','Spare Part') }}</li>
            <li>{{ Html::link('/sparepart/category','Category Spare Part') }}</li>
            <li>{{ Html::link('/sparepart/groups','Groups Spare Part') }}</li>
        </ul>
        @endif

        @if (Auth::user()->is_admin || in_array(1, $user_roles))
        <a href="#tools-menu" class="nav-header" data-toggle="collapse"><i class="icon-cog icon-large"></i>Tools</a>
        <ul id="tools-menu" class="nav nav-list collapse">
            <li >{{ Html::link('tools/exportcheckin','Export Checkin Format') }} </li>
            <li >{{ Html::link('tools/uploadsetoran','Upload Setoran') }} </li>
            <li >{{ Html::link('logviewer','Log Program') }} </li>
            <li >{{ Html::link('tools/toolspj','Print SPJ ALL') }} </li>
            <li >{{ Html::link('tools/printest','Test RAW Printer') }} </li>
        </ul>
        @endif

        @if (Auth::user()->is_admin || in_array(1, $user_roles))
        <a href="#accounts-menu" class="nav-header" data-toggle="collapse"><i class="icon-briefcase icon-large"></i>Account</a>
        <ul id="accounts-menu" class="nav nav-list collapse">
            <li >{{ Html::link('users','Users') }} </li>
            <li >{{ Html::link('roles','Roles') }} </li>
        </ul>
        @endif
    </div>
DROP VIEW IF EXISTS `financial_report_daily`;
CREATE  VIEW `financial_report_daily` AS select 
cin.*,
d.nip,
d.name,
f.taxi_number,
f.fleet_model_id,
cf.checkin_id,
o.kode,
s.shift,
max(if( cf.financial_type_id = 1, cf.amount, 0)) as setoran_wajib,
max(if( cf.financial_type_id = 2, cf.amount, 0)) as tabungan_sparepart,
max(if( cf.financial_type_id = 3, cf.amount, 0)) as denda,
max(if( cf.financial_type_id = 4, cf.amount, 0)) as potongan,
max(if( cf.financial_type_id = 5, cf.amount, 0)) as cicilan_sparepart,
max(if( cf.financial_type_id = 6, cf.amount, 0)) as cicilan_ks,
max(if( cf.financial_type_id = 7, cf.amount, 0)) as biaya_cuci,
max(if( cf.financial_type_id = 8, cf.amount, 0)) as iuran_laka,
max(if( cf.financial_type_id = 9, cf.amount, 0)) as cicilan_dp_kso,
max(if( cf.financial_type_id = 10, cf.amount, 0)) as cicilan_hutang_lama,
max(if( cf.financial_type_id = 11, cf.amount, 0)) as ks,
max(if( cf.financial_type_id = 12, cf.amount, 0)) as cicilan_lain,
max(if( cf.financial_type_id = 13, cf.amount, 0)) as hutang_dp_sparepart,
max(if( cf.financial_type_id = 20, cf.amount, 0)) as setoran_cash,
max(if( cf.financial_type_id = 21, cf.amount, 0)) as tabungan
from checkins cin left join checkin_financials cf on ( cin.id = cf.checkin_id ) 
join drivers d on (cin.driver_id = d.id) 
join fleets f on (cin.fleet_id = f.id)
join operasi_status o on (cin.operasi_status_id = o.id)
join shifts s on (cin.shift_id = s.id)
group by cin.id ;

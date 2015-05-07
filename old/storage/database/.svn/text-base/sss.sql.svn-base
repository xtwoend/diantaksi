
DROP VIEW IF EXISTS `bapak_asuh_financial_month`;
CREATE  VIEW `bapak_asuh_financial_month` AS 
select 
cin.*,
f.taxi_number,
cf.checkin_id,
MONTHNAME(cin.operasi_time) as monthname,
month(cin.operasi_time) as month,
year(cin.operasi_time) as year,
( select user_id from anak_asuh asu where cin.fleet_id = asu.fleet_id and asu.status = 1 limit 0,1) as bapak_asuh ,
(select count(id) from anak_asuh asus where asus.user_id = bapak_asuh and asus.status = 1  ) as total_anakasuh,
sum(if( cf.financial_type_id = 1, cf.amount, 0)) as setoran_wajib,
sum(if( cf.financial_type_id = 2, cf.amount, 0)) as tabungan_sparepart,
sum(if( cf.financial_type_id = 3, cf.amount, 0)) as denda,
sum(if( cf.financial_type_id = 4, cf.amount, 0)) as potongan,
sum(if( cf.financial_type_id = 5, cf.amount, 0)) as cicilan_sparepart,
sum(if( cf.financial_type_id = 6, cf.amount, 0)) as cicilan_ks,
sum(if( cf.financial_type_id = 7, cf.amount, 0)) as biaya_cuci,
sum(if( cf.financial_type_id = 8, cf.amount, 0)) as iuran_laka,
sum(if( cf.financial_type_id = 9, cf.amount, 0)) as cicilan_dp_kso,
sum(if( cf.financial_type_id = 10, cf.amount, 0)) as cicilan_hutang_lama,
sum(if( cf.financial_type_id = 11, cf.amount, 0)) as ks,
sum(if( cf.financial_type_id = 12, cf.amount, 0)) as cicilan_lain,
sum(if( cf.financial_type_id = 13, cf.amount, 0)) as hutang_dp_sparepart,
sum(if( cf.financial_type_id = 20, cf.amount, 0)) as setoran_cash,
sum(if( cf.financial_type_id = 21, cf.amount, 0)) as tabungan,
(sum(if( cf.financial_type_id = 6, cf.amount, 0))- sum(if( cf.financial_type_id = 11, cf.amount, 0))) as selisi_ks
from checkins cin left join checkin_financials cf on ( cin.id = cf.checkin_id ) 
join fleets f on (cin.fleet_id = f.id)
group by YEAR(cin.operasi_time), MONTH(cin.operasi_time),  bapak_asuh;


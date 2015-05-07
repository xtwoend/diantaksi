SELECT 
cin.*,
cf.checkin_id,
MAX(if( cf.financial_type_id = 1, cf.amount, 0)) as 'setoran_wajib',
MAX(if( cf.financial_type_id = 2, cf.amount, 0)) as 'tabungan_sparepart',
MAX(if( cf.financial_type_id = 3, cf.amount, 0)) as 'denda',
MAX(if( cf.financial_type_id = 4, cf.amount, 0)) as 'potongan',
MAX(if( cf.financial_type_id = 5, cf.amount, 0)) as 'cicilan_sparepart',
MAX(if( cf.financial_type_id = 6, cf.amount, 0)) as 'cicilan_ks',
MAX(if( cf.financial_type_id = 7, cf.amount, 0)) as 'biaya_cuci',
MAX(if( cf.financial_type_id = 8, cf.amount, 0)) as 'iuran_laka',
MAX(if( cf.financial_type_id = 9, cf.amount, 0)) as 'cicilan_dp_kso',
MAX(if( cf.financial_type_id = 10, cf.amount, 0)) as 'cicilan_hutang_lama',
MAX(if( cf.financial_type_id = 11, cf.amount, 0)) as 'ks',
MAX(if( cf.financial_type_id = 12, cf.amount, 0)) as 'cicilan_lain',
MAX(if( cf.financial_type_id = 13, cf.amount, 0)) as 'hutang_dp_sparepart'
FROM checkins cin left join checkin_financials cf on ( cin.id = cf.checkin_id ) 
group by cin.id


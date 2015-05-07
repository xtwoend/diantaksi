<?php
class Myfungsi {


	public static function bulan($id)
  {
      $months = array(
                          '1' => 'Januari',
                          '2' => 'Februari',
                          '3' => 'Maret',
                          '4' => 'April',
                          '5' => 'Mei',
                          '6' => 'Juni',
                          '7' => 'Juli',
                          '8' => 'Agustus',
                          '9' => 'September',
                          '10' => 'Oktober',
                          '11' => 'November',
                          '12' => 'Desember', 
                      );
      return $months[$id];
  }

  public static function fulldate($strtime)
  {   
      $day = date('d', $strtime );
      $month = date('n', $strtime); 
      $year = date('Y', $strtime);

      return  $day . ' ' . Myfungsi::bulan($month) . ' ' . $year;
  }

  public static function periode($strtime)
  {
      $day = date('d', $strtime );
      $month = date('n', $strtime); 
      $year = date('Y', $strtime);

      return Myfungsi::bulan($month) . ' ' . $year;
  }
  public static function hari($id)
  {
    $day =  array(
                    '1' => 'Senin',
                    '2' => 'Selasa',
                    '3' => 'Rabu',
                    '4' => 'Kamis',
                    '5' => 'Jum\'at',
                    '6' => 'Sabtu',
                    '7' => 'Minggu',
    );

    return $day[$id];
  }

  public static function numberComplate($in,$max)
  {
      $len = $max;
      $len_in = strlen($in);
      $zero_len = $len - $len_in;
      $zero = "";
      for($i=1;$i<=$zero_len;$i++)
      {
        $zero .= '0';
      }
      return $zero.$in;
  }

  public static function sysdate($date = false)
    {   
        if(!$date) $date = date('Y-m-d H:i:s');
        $timestamp = strtotime($date);
        if(Auth::user()->pool_id == 2)
        {
            $timestamp = strtotime($date ." + 1 hours");
        }
        
        return $timestamp;
    }

  public static function duit($val=0, $sparator='.',$digitakhir=0)
  {
    return number_format($val, $digitakhir, ',', $sparator);
  }
}
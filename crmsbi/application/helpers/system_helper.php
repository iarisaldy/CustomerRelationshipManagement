<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function numIndo($number, $precision=2)
{
  return number_format($number, $precision, ',', '.');
}
function dateToIndo($date="",$day=false,$time=false){

  $bulan=get_bulan_all();
  $hari=get_hari_all();
  $d=date('d',  strtotime($date));
  $m=date('m',  strtotime($date));
  $y=date('Y',  strtotime($date));
  $n=date('N',  strtotime($date));
  $t=date('H:i', strtotime($date));
  if($day)
      $date = $hari[$n].", ".$d." ".$bulan[$m]." ".$y." ";
  else
      $date = $d." ".$bulan[$m]." ".$y." ";

  if($time)
      $date .= $t;

  return $date;
}

function get_hari_all(){
  return array(
      '1'=>'Senin',
      '2'=>'Selasa',
      '3'=>'Rabu',
      '4'=>'Kamis',
      '5'=>"Jum'at",
      '6'=>'Sabtu',
      '7'=>'Minggu'
      );
}

function get_bulan_all($getBulan=null){
  $bulan=array(
      '01'=>'Januari',
      '02'=>'Februari',
      '03'=>'Maret',
      '04'=>'April',
      '05'=>'Mei',
      '06'=>'Juni',
      '07'=>'Juli',
      '08'=>'Agustus',
      '09'=>'September',
      '10'=>'Oktober',
      '11'=>'November',
      '12'=>'Desember'
  );
  if($getBulan == null){
      return $bulan;
  }else{
      $i = $getBulan;
      if($getBulan < 10) $i = $getBulan;
      return $bulan[$i];
  }
}
function demandPlStatusPersen($value='')
{
  if($value < 30)
    return "style='color:red'";
  if($value >= 30 and $value <= 80)
    return "style='color:blue'";
  if($value > 80)
    return "style='color:green'";
}
function demandPlStatusVol($value='')
{
  if($value > 100)
    return "style='color:green'";
  else
    return "style='color:red'";
}

function sort_by_order($a, $b) {
    return $a['urut'] - $b['urut'];
}
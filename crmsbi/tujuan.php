<?php 	
$dtk=explode(',', 'PELABUHAN TANJUNG PRIOK,PELABUHAN CIWANDAN,PELABUHAN TANJUNG PRIOK,PELABUHAN TANJUNG PRIOK,PELABUHAN TANJUNG PRIOK');
$hasil = array_unique($dtk);
$hasil_str='';
if(count($hasil)==1){
	$hasil_str = $hasil[0];
}
else if(count($hasil)==2){
	$hasil_str = $hasil[0]. ', '. $hasil[1];
}
else if(count($hasil)==3){
	$hasil_str = $hasil[0]. ', '. $hasil[1]. ', '. $hasil[2];
}
else if(count($hasil)==4){
	$hasil_str = $hasil[0]. ', '. $hasil[1]. ', '. $hasil[2]. ', '. $hasil[3];
}


echo $hasil_str;
 ?>

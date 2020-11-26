<?php
//chmod("dtjson.txt",0777);
//Get Result From *.txt
$arr = '';
$file = fopen("dtjson.txt", "r") or exit("Unable to open file!");

while (!feof($file)) {
    $arr .= fgetc($file);
}
fclose($file);

$RESULTS = json_decode($arr, true);
//End


$myImage = imagecreatefromjpeg("peta_ter1.jpg");

//echo "<pre>";
//print_r($RESULTS);
//echo "</pre>";
foreach ($RESULTS as $key => $value) {
    $lv_type = explode('_', $key);
    if ($lv_type[0] == 'PP') {
        imagefilledellipse($myImage, $value['X1'], $value['Y1'], $value['X2'], $value['Y2'], $value['Warna']);
    } else {
        imagefilledrectangle($myImage, $value['X1'], $value['Y1'], $value['X2'], $value['Y2'], $value['Warna']);
    }
	
	
    //imagefilledrectangle($myImage, $value['GLADAK']['X1'], $value['GLADAK']['Y1'], $value['GLADAK']['X2'], $value['GLADAK']['Y2'], $value['GLADAK']['Warna']);
    //for ($i = 0; $i < count($value['DATA']); $i++) {
    //    imagefilledellipse($myImage, $value['DATA'][$i]['X1'], $value['DATA'][$i]['Y1'], $value['DATA'][$i]['X2'], $value['DATA'][$i]['Y2'], $value['DATA'][$i]['Warna']);
    //}
	
}

header("Content-type: image/jpeg");
imagejpeg($myImage);
imagedestroy($myImage);

?>
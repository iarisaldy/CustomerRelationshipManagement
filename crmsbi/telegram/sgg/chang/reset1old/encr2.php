<?php
function encode($string,$key) {
    $key = sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
    for ($i = 0; $i < $strLen; $i++) {
        $ordStr = ord(substr($string,$i,1));
        if ($j == $keyLen) { $j = 0; }
        $ordKey = ord(substr($key,$j,1));
        $j++;
        $hash .= strrev(base_convert(dechex($ordStr + $ordKey),16,36));
    }
    return $hash;
}

function decode($string,$key) {
    $key = sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
    for ($i = 0; $i < $strLen; $i+=2) {
        $ordStr = hexdec(base_convert(strrev(substr($string,$i,2)),36,16));
        if ($j == $keyLen) { $j = 0; }
        $ordKey = ord(substr($key,$j,1));
        $j++;
        $hash .= chr($ordStr - $ordKey);
    }
    return $hash;
}

//echo encode("Please Encode Me!","This is a key 4");?><br><?php
//$hasil = decode("f464r5x203x254t2r263","This is a key 4");
//echo decode("f464r5x203x254t2r263a3d4u2a4j5s2h5c434j4p2","This is a key 4")."<br>";
//$hsl = decode("f464r5x203x254t2r263a3b4k3v294l37594d355","This is a key 4");
//list($nama, $pass) = split('[=]',$hsl);
//echo $nama."<br>";
//echo $pass
?>
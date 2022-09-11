<?php
error_reporting(-1);
define("KM_TO_MILES",1.60934);
$numOfDistance=rand(5,20);
$arrDistance=array();
for ($i=0; $i <$numOfDistance ; $i++) { 
    array_push($arrDistance,rand(0,10));
}
print_r($arrDistance);
print("\n");
asort($arrDistance);
print_r($arrDistance);
print("\n");
$arrMiles=[];
$arrAlphabet=array("A","B","C","D","E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
$cc=0;
$prevVal=0;
foreach ($arrDistance as $distance) {
    print_r($arrAlphabet);
    if ($prevVal!=$distance) {
      $arrMiles[$distance]=$distance/KM_TO_MILES;
    }else {
        $duplicate=strval($distance);
        $arrMiles[$duplicate]=$distance/KM_TO_MILES;
        $cc=$cc+1;
    }
    $prevVal=$distance;
}
print_r($arrMiles);
print("\n");
print("Km\tMiles\n");
foreach ($arrMiles as $key => $value) {
     printf("%d \t %0.3f\n",$key,$value);
}

?>
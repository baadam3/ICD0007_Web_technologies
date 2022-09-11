<?php
error_reporting(-1);
KM_TO_MILES=1.60934;
$numOfDistance=rand(5,20);
$arrDistance=array();
for ($i=0; $i <$numOfDistance ; $i++) { 
    array_push($arrDistance,rand(0,100));
}
print_r($arrDistance);


?>
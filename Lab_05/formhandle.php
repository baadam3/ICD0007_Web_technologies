<?php
function clean($value){
    $value=trim($value);
    $value=stripslashes($value);
    $value=strip_tags($value);
    $value=str_replace(",","",$value);
    return $value;
}

if($_SERVER['REQUEST_METHOD']=='POST'){
    $Fname=clean($_POST['Fname']);
    $Fname=preg_replace("/[^a-zA-Z]/", "", $Fname);
    $Mname=clean($_POST['Mname']);
    $Mname= preg_replace("/[^a-zA-Z]/", "", $Mname);
    $Lname=clean($_POST['Lname']);
    $Lname=preg_replace("/[^a-zA-Z]/", "", $Lname);
    $age=clean($_POST['age']);
    $email=clean($_POST['email']);
    $email=filter_var($email,FILTER_SANITIZE_EMAIL);
    $phone=clean($_POST['phone']);
    $phone=preg_replace("/[^0-9]/","",$phone);
    $ref=clean($_POST['ref']);
    $ref=preg_replace("/[^a-zA-Z-0-9]/", "", $ref);
    $salutation=clean($_POST['salutation']);
    $date=clean($_POST['arrival']);
    $dataArray=array("salutation"=>$salutation,"Fname"=>$Fname,"Mname"=>$Mname,"Lname"=>$Lname,"age"=>$age,"email"=>$email,"phone"=>$phone,"ref"=>$ref,"date"=>$date);
    $notAllowed=array("#", "'", ";", ",");
    for ($i=0; $i <strlen($notAllowed) ; $i++) { 
        for ($j=0; $j < strlen($Fname); $j++) { 
            if ($Fname[$j]==$notAllowed[$i]) {
                echo "Invalid character";
                exit;
            }
        }
    }
    for ($i=0; $i <strlen($notAllowed) ; $i++) { 
        for ($j=0; $j < strlen($Mname); $j++) { 
            if ($Mname[$j]==$notAllowed[$i]) {
                echo "Invalid character";
                exit;
            }
        }
    }
    for ($i=0; $i <strlen($notAllowed) ; $i++) { 
        for ($j=0; $j < strlen($Lname); $j++) { 
            if ($Lname[$j]==$notAllowed[$i]) {
                echo "Invalid character";
                exit;
            }
        }
    }
    for ($i=0; $i <strlen($notAllowed) ; $i++) { 
        for ($j=0; $j < strlen($ref); $j++) { 
            if ($ref[$j]==$notAllowed[$i]) {
                echo "Invalid character";
                exit;
            }
        }
    }
    for ($i=0; $i <strlen($notAllowed) ; $i++) { 
        for ($j=0; $j < strlen($phone); $j++) { 
            if ($phone[$j]==$notAllowed[$i]) {
                echo "Invalid character";
                exit;
            }
        }
    }
    $dateArray=explode("-",$date);
   
    if (!checkdate($dateArray[1],$dateArray[2],$dateArray[0])) {
        echo 'Invalid date';
        exit;
    }

    if (empty($date)) {
        echo 'Empty date';
        exit;
    }
    if (empty($Lname)||empty($Fname)) {
        echo 'A required field is missing';
        exit;
    }
    if (empty($ref)) {
        echo 'Reference number is required';
        exit;
    }
    if ($date<=date("Y-m-d")) {
        echo 'Invalid date';
        exit;
    }
    if(empty($_POST)){
        echo 'Empty input';
    }else if($age<17) {
        echo 'Invalid age';
    }else {
        if (file_exists("register.csv")) {
            $handle=fopen("register.csv","a")
                or die("Unable to open file!");
            fputcsv ( $handle , $dataArray,","); 
            fclose($handle);    
        }else {
            $handle=fopen("register.csv","w+")
                or die("Unable to open file!");
            fputcsv ( $handle , $dataArray,","); 
           fclose($handle); 
        }
        echo $salutation.";".$Fname.";".$Mname.";".$Lname.";".$age.";".$email.";".$phone.";".$ref.";".$date.";";
        echo "Succesfull registration!";
    }
}

?>

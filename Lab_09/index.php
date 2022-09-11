<!DOCTYPE html>
<html lang="en">
<head>
<title>Lab 9</title>
</head>
<body>
<?php
include_once "connect.php";
// START of opening and error handleing of connection 
$link = mysqli_connect($server, $user, $password, $database);
if(!$link){
    die("Connection to database failed: ".mysqli_connect_error());
}
else echo "Connection to database was succesfull";
// END of opening and error handleing of connection 
$semesterID = intval(cleanInput($link,$_GET['semester_ID']));

//$courseQuerry = "SELECT  FROM courses_baadam;";
//$semesterQuerry = "SELECT ID, semester_name FROM semester_baadam WHERE Semesters_ID = '".$semesterID."';";
$semesterQuerry = "SELECT * FROM semesters_baadam;";



function listCourses($link,$semesterID){
    if (isset($_GET['order'])) {
        $order = cleanInput($link, $_GET['order']);
    }else {
        $order = 'course_code';
    }
    if (isset($_GET['sort'])) {
        $sort = cleanInput($link, $_GET['sort']);
    }else {
        $sort = 'ASC';
    }

    if (isset($_POST['search']) && !empty($_POST['search'])) {
        $search = "%{$_POST['search']}%";
        if ($semesterID == 1 || $semesterID == 2 || $semesterID == 3) {
            $querry = mysqli_prepare($link, "SELECT C.course_code, C.course_name, C.ects_credits, C.Semesters_ID, C.ID, S.semester_name FROM courses_baadam AS C, semesters_baadam AS S WHERE C.Semesters_ID = S.ID AND C.Semesters_ID = ? AND (course_name LIKE ? OR course_code LIKE ?) ORDER BY $order $sort;");
            mysqli_stmt_bind_param($querry, "iss", $semesterID, $search, $search);
            mysqli_stmt_execute($querry);
            mysqli_stmt_bind_result($querry, $course_code, $course_name, $ects_credits, $Semesters_ID, $ID, $semester_name);
    
        } else {
            $querry =  mysqli_prepare($link, "SELECT C.course_code, C.course_name, C.ects_credits, C.Semesters_ID, C.ID, S.semester_name FROM courses_baadam AS C, semesters_baadam AS S WHERE C.Semesters_ID = S.ID AND (course_name LIKE ? OR course_code LIKE ?) ORDER BY $order $sort;");
            mysqli_stmt_bind_param($querry, "ss", $search, $search);
            mysqli_stmt_execute($querry);
            mysqli_stmt_bind_result($querry, $course_code, $course_name, $ects_credits, $Semesters_ID, $ID, $semester_name);
    
        }
    }else {
        if ($semesterID == 1 || $semesterID == 2 || $semesterID == 3) {
            $querry = mysqli_prepare($link, "SELECT C.course_code, C.course_name, C.ects_credits, C.Semesters_ID, C.ID, S.semester_name FROM courses_baadam AS C, semesters_baadam AS S WHERE C.Semesters_ID = S.ID AND C.Semesters_ID = ? ORDER BY $order $sort;");
            mysqli_stmt_bind_param($querry, "i", $semesterID);
            mysqli_stmt_execute($querry);
            mysqli_stmt_bind_result($querry, $course_code, $course_name, $ects_credits, $Semesters_ID, $ID, $semester_name);
    
        } else {
            $querry = mysqli_prepare($link, "SELECT C.course_code, C.course_name, C.ects_credits, C.Semesters_ID, C.ID, S.semester_name FROM courses_baadam AS C, semesters_baadam AS S WHERE C.Semesters_ID = S.ID ORDER BY $order $sort;");
            mysqli_stmt_execute($querry);
            mysqli_stmt_bind_result($querry, $course_code, $course_name, $ects_credits, $Semesters_ID, $ID, $semester_name);
        }
    }

        $sort == 'DESC' ? $sort = 'ASC' : $sort = 'DESC';
       echo "<table>
       <tr>
         <th><a href='index.php?order=course_code&&sort=$sort&&semester_ID=$semesterID'>Course code</a></th>
         <th><a href='index.php?order=course_name&&sort=$sort&&semester_ID=$semesterID'>Course name</a></th>
         <th><a href='index.php?order=ects_credits&&sort=$sort&&semester_ID=$semesterID'>ECTS</a></th>
         <th>\t<a href='index.php?order=semester_name&&sort=$sort&&semester_ID=$semesterID'>Semester</a></th>
       </tr>";
       if ($order == 'semester_name') {
         
         while (mysqli_stmt_fetch($querry)) {
             echo "
             <tr>
                <td>$course_code</td>
                <td>$course_name</td>
                <td>$ects_credits</td>
                <td style=background-color:#00FF00>\t\t$semester_name</td>
             </tr>";
            } 
        }
       elseif ($order == 'course_name') {
         
          while (mysqli_stmt_fetch($querry)) {
             echo "
             <tr>
              <td>$course_code</td>
             <td style=background-color:#00FF00>$course_name</td>
             <td>$ects_credits</td>
             <td>\t\t$semester_name</td>
             </tr>";
            } 
        }
    elseif ($order == 'ects_credits') {
        
        while (mysqli_stmt_fetch($querry)) {
        echo "
        <tr>
          <td>$course_code</td>
          <td>$course_name</td>
          <td style=background-color:#00FF00>$ects_credits</td>
          <td>\t\t$semester_name</td>
        </tr>";
    } 
    
    
       }else {
        
        while (mysqli_stmt_fetch($querry)) {
        echo "
        <tr>
          <td style=background-color:#00FF00>$course_code</td>
          <td>$course_name</td>
          <td>$ects_credits</td>
          <td>\t\t$semester_name</td>
        </tr>";
    } 
     echo "</table>";
    
    
       }
    
}

function semesters($link, $semesterQuerry){
	$result = $link -> query($semesterQuerry);
	echo "<ul>";
	while($row = $result -> fetch_assoc()){
		echo "<li>";
		echo "<a href=\"index.php?semester_ID=".$row['ID']."\">";
		echo $row["semester_name"];
		echo "</a>";
		echo "</li>";
	}
    echo "<li>";
    echo "<a href='index.php?semester_ID=4'>";
    echo "All</a>";
	echo "</ul>";
}

function cleanInput($link, $var){
    $var = stripslashes($var);
    $var = htmlentities($var);
    $var = strip_tags($var);
    $var = mysqli_real_escape_string($link, $var);
    return $var;
}


echo "<form action='index.php' target='_self' method='POST'>
<input type='text' id='search' name='search' placeholder = 'Search'>
<input type='submit' value='submit'>
</form>";

semesters($link,$semesterQuerry);

listCourses($link,$semesterID);



$querry -> close();
$link -> close();
?>
</body>
</html>
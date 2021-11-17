<?php
$dbuser="root";
$dbpass="";
$host="localhost";
$dbname = "schoolmanagement";
$mysqli = new mysqli($host, $dbuser, $dbpass, $dbname);
if(!empty($_POST['cshort'])){
$cshort=$_POST['cshort'];
$result ="SELECT count(*) FROM tbl_course WHERE cshort=?";
$stmt = $mysqli->prepare($result);
$stmt->bind_param('s',$cshort);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();
if($count>0)
	echo "<span style='color:red'> Course Short Name Already Exist .</span>";
}
if(!empty($_POST['cshort1'])){
$cshort=$_POST['cshort1'];
$result ="SELECT count(*) FROM  subject WHERE cshort=?";
$stmt = $mysqli->prepare($result);
$stmt->bind_param('i',$cshort);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();
if($count>0)
	echo "<span style='color:red'> Course Short Name Already Exist .</span>";
}

if(!empty($_POST['cfull'])){
	$cfull=$_POST['cfull'];
	$result ="SELECT count(*) FROM tbl_course WHERE cfull=?";
	$stmt = $mysqli->prepare($result);
	$stmt->bind_param('s',$cfull);
	$stmt->execute();
	$stmt->bind_result($count);
	$stmt->fetch();
	$stmt->close();
	if($count>0)
		echo "<span style='color:red'> Course Full Name Already Exist .</span>";
}

if(!empty($_POST['cfull1'])){
	$cfull=$_POST['cfull1'];
	$result ="SELECT count(*) FROM subject WHERE cfull=?";
	$stmt = $mysqli->prepare($result);
	$stmt->bind_param('s',$cfull);
	$stmt->execute();
	$stmt->bind_result($count);
	$stmt->fetch();
	$stmt->close();
	if($count>0)
		echo "<span style='color:red'> Course Full Name Already Exist .</span>";
}
?>


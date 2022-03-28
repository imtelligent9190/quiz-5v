<?php
include_once '../db/connect.php';
include_once '../includes/header.php';
session_start();
$query = "SELECT * FROM questions WHERE id_quiz='".$_SESSION['id_quiz_gra']."'";

$result= $mysqli->query($query) or die($mysqli_error.__LINE__);
$total=$result->num_rows;
$ile=$_GET['sciagal'];
$koniec=date('H:i:s',time());



if(!isset($_SESSION['id_sesji']) and !isset($_SESSION['user']) and !isset($_SESSION['user-id']) and $total==0){
	header('Location: ../');
}else{
	$slect_wyniki="SELECT * FROM wyniki WHERE id_u='".$_SESSION['user-id']."' AND id_sesji='".$_SESSION['id_sesji']."'";
	$slect_wyniki2=$mysqli->query($slect_wyniki);
	$selec_wyniki=$slect_wyniki2->num_rows;
	if ($selec_wyniki==0){
		$insert="INSERT INTO wyniki VALUES('".$_SESSION['id_sesji']."','".$_SESSION['user']."','".$_SESSION['user-id']."','".$_SESSION['score']."','".serialize($_SESSION['zle'])."','".$total."','".$ile."','".$_SESSION['start']."','".$koniec."')";
		$result2= $mysqli->query($insert) or die($mysqli_error.__LINE__);
		$total=$result->num_rows;
	}
header("Location: ../final.php");
}

?>

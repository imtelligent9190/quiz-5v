<?php
include_once '../db/connect.php';
include_once '../includes/header.php';
session_start();
echo $_GET['n'];
$sql="DELETE FROM `kolejka` WHERE `id_sesji`='". $_GET['n']."'";
$rezultat=$mysqli->query($sql);
header("Location: dashboard-zaplanowane.php");
?>
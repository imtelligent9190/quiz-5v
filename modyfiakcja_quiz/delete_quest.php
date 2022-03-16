<?php
include_once '../db/connect.php';
include_once '../includes/header.php';
session_start();

$id_quiz=$_GET['id_quiz'];
$quest=$_GET['n'];
if(!isset($_GET['n'])){
    header("location: index.php");
}
$select="SELECT * FROM questions WHERE id_quiz='".$id_quiz."' ";
$selectquest=$mysqli->query($select) or die(" coś poszło nie tak");

$delete="DELETE FROM choices WHERE id_quiz='".$id_quiz."' AND questionNumber='".$quest."'";
echo $delete;
$deletechoice=$mysqli->query($delete) or die(" coś poszło nie tak");
$delete="DELETE FROM questions WHERE id_quiz='".$id_quiz."' AND questionNumber='".$quest."'";
$deletequest=$mysqli->query($delete) or die(" coś poszło nie tak");
echo $delete;
$ile=$selectquest->num_rows;
for ($i=$quest; $i <= $ile+1; $i++) { 
    $jedenwprzod=$i+1;
    $update="UPDATE `choices` SET `questionNumber`='".$i."' WHERE questionNumber='".$jedenwprzod."'";
    $update2=$mysqli->query($update);
    echo $update;
}

for ($i=$quest; $i <= $ile+1; $i++) { 
    $jedenwprzod=$i+1;
    $update="UPDATE questions SET `questionNumber`='".$i."' WHERE questionNumber='".$jedenwprzod."'";
    $update2=$mysqli->query($update);
    echo $update;
}

header("Location: change_question.php?n=$id_quiz");

?>
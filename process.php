<?php

use function PHPSTORM_META\type;

include_once 'includes/header.php'; ?>
<?php include_once 'db/connect.php'; ?>


<?php session_start(); ?>

<?php



if (!isset($_SESSION['zle'])){
   $_SESSION['zle']=array(); 
   array_pop($_SESSION['zle']);
} 


if (!isset($_SESSION['score'])) {
    $_SESSION['$score'] = 0;

}

$wybrany = $_POST["choice"]; 


// get correct
$query = 'SELECT choiceText FROM choices WHERE id_quiz='.$_SESSION['id_quiz_gra'].' AND isCorrect = 1 AND  QuestionNumber='.$_SESSION["oper"]+1;
$run =  $mysqli->query($query);
$poprawna = mysqli_fetch_row($run);
$poprawna = $poprawna[0];


$end = $poprawna == $wybrany;

if($end){

    $_SESSION['score']++;

}else{
    $zle=array($_SESSION["oper"]+1,$wybrany);
    array_push($_SESSION['zle'],$zle);
}


if($_SESSION["total"] == $_SESSION["oper"]+1){

    unset($_SESSION["pytania"]);
    unset($_SESSION["odp"]);
    unset($_SESSION["oper"]);
    unset($_SESSION["total"]);
    unset($_SESSION["wyb"]);

    header("Location: wyniki/save_score.php?sciagal=".$_POST['sciagal']);
}

else{
    $_SESSION["oper"]+=1;
    header("Location: question.php");

}


?>
<main>
    <div class="container">
    <h1>Process PHP</h1>
    </div>
</main>
<?php 
include_once 'includes/footer.php'; 
?>
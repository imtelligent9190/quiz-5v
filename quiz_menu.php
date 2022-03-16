<?php
    include_once 'db/connect.php';
    include_once 'includes/header.php';
    session_start();
    unset ($_SESSION['ile']);
    unset($_SESSION['start']);
    $_SESSION['id_sesji']=$_POST['quiz_id'];//tu

    $_SESSION['id_quiz_gra']=$_POST['quiz_id'];//tu

    unset($_SESSION['blad_add']);
    unset($_SESSION['score']);
    unset($_SESSION['id']);
    // print_r($_SESSION);
    
    
    $_SESSION["oper"]=0;
    $_SESSION["total"]=0;
    $_SESSION["wyb"]=array();

?>





<?php
$query="SELECT * FROM kolejka Where id_sesji='".$_POST['quiz_id']."'";
$results= $mysqli->query($query) or die($mysqli_error.__LINE__);
$quiz=$results->fetch_assoc();
$_SESSION['id_quiz_gra']=$quiz['id_quiz'];

$selectquiz="SELECT * FROM quizy WHERE id='".$quiz['id_quiz']."'";
$results2= $mysqli->query($query) or die($mysqli_error.__LINE__);
$quiz2=$results2->fetch_assoc();
$select="SELECT * FROM questions WHERE id_quiz='".$quiz['id_quiz']."'";
$rezultat=$mysqli->query($select);
$total=$rezultat->num_rows;
$_SESSION["total"]=$total;
?>

<div class="container">
<header>
    <div class="container">
        <h1 id="demo"><?php echo $quiz2['name']; ?></h1>
    </div>
</header>



<main>
    <div class="container">
        <!-- <h2> Test your PHP Knowlege</h2> -->
<p> This is quiz to test your knowledge</p>
<ul>
    <li><strong> Number of Questions: </strong><?php echo $total;?> </li>
    <li><strong> Type Of Quiz: </strong> Multiple Choice</li>
    <li><strong> Estimated time: </strong><?php echo $total * 0.5; ?> Minutes </li>

</ul>
<a onclick="StartTimer()" href="question.php" class="btn btn-primary">Start Quiz</a>
<!-- Needed -->
</div>
<?php
// include_once 'includes/footer.php';
?>
</div>
</main>



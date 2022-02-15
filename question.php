<?php
if(!isset($_SESSION['id_sesji']) and !isset($_SESSION['user']) and !isset($_SESSION['user-id'])){
include_once 'includes/header.php';
include_once 'db/connect.php';
session_start();
// print_r($_SESSION);

if(!isset($_SESSION['start'])){
    $_SESSION['start']=gmdate('H:i:s',time()+3600);
}

if(!isset($_SESSION['test'])){
    $_SESSION['test']=0;
}

if($_SESSION["oper"]==0){
    ($_SESSION)['score']=0;
}
    

$choices=array();

//Furtka na wybór timera zależnie od typu Quizu
$decy = 0;
if ($decy == 0) 
{
    echo('<script src="js/QuizTimer.js"></script>');
}
elseif ($decy == 1) 
{
    echo('<script src="js/QuestionTimer.js"></script>');
}
<<<<<<< HEAD
$oper=$_SESSION["oper"]+1;
$query = "SELECT QuestionText FROM questions WHERE id_quiz='".$_SESSION['id_quiz_gra']."' AND QuestionNumber='".$oper."'";
// echo $query;
=======

$query = "SELECT QuestionText, img FROM questions WHERE id_quiz=".$_SESSION['id_quiz_gra']." AND QuestionNumber=".$_SESSION["oper"]+1;
>>>>>>> 4d23d5110528bc9fd4ad55f89b19f0bdcea58803
$run = $mysqli->query($query) or die($mysqli_error.__LINE__);
$pytanie = mysqli_fetch_row($run);
$x =$oper;

$query = "SELECT choiceText FROM choices WHERE id_quiz='".$_SESSION['id_quiz_gra']."' AND QuestionNumber='".$oper."'";
$run = $mysqli->query($query) or die($mysqli_error.__LINE__);
$odp = array();
while($row = $run->fetch_assoc()){
    array_push($odp, $row["choiceText"]);
};


$size = sizeof($odp);
$_SESSION["size"] = $size;




?>
<!-- wyświetlanie na stronie -->
<header>
    <div class="container">
        <h1> PHP Quizer</h1>
        <p id="timer">00:00</p>
    </div>
</header>

<main>
    <div class="container">
        <div class="current">Question <?php echo $oper //nr pyt;?> of <?php echo $_SESSION["total"] ;?> </div>
        <p class="question"><?php echo $pytanie[0];?> </p>
        <?php
        if($pytanie[1]!=NULL){
            $src = substr($pytanie[1],3);
            echo "<div><img src='".$src."'></div>";
        }
        ?>
        <?php
        if($size!=0){
        ?>
        <form action="process.php" method="post">
            <ul class="choices">
                <?php
                    foreach ($odp as $key){?>
                        <li><input type="radio" name="choice" value="<?php  echo $key;?>"><?php  echo $key;?></li>
                <?php }; ?>
            </ul>
            <input id="NextQuest" type="submit" value="submit" class="btn btn-success"/>
            <input type="hidden" name="number" value="<?php echo $oper;?>" />
            <input type="hidden" id='sciagal' name="sciagal" value="<?php echo $oper;?>" />
            <input type="hidden" name="QuestionText" value="<?php echo $qtext["QuestionText"];?>" />
        </form>
        <?php }
        else{?>
            <form action="process.php" method="post" id="otwarte">
            <ul class="choices">
                <textarea rows = "4" cols = "40"  	name="otwarta" form_id="otwarte"></textarea>
            </ul>
            <input id="NextQuest" type="submit" value="submit" class="btn btn-success"/>
            <input type="hidden" name="number" value="<?php echo $oper;?>" />
            <input type="hidden" id='sciagal' name="sciagal" value="<?php echo $oper;?>" />
            <input type="hidden" name="QuestionText" value="<?php echo $qtext["QuestionText"];?>" />
        </form>
        <?php
        }
        ?>
    </div>
</main>
</div>

<?php

//   Ktoś niech to ogranie bo potrzebne w tabeli z wynikami ucznia miejsce na "Próby ściągania" = Tak/Nie

//   $host = 'localhost';
//   $user = 'root';
//   $pass = '';
//   $dbname = 'Cheating';
//   $conn = new mysqli($host, $user, $pass, $dbname) or die("nie połączono");
//   $sql = "INSERT INTO Wyniki (Proby) VALUES ('Tak');";

?>

<script>
  var controller = 0;
  var sciagal=0;
  let button=document.getElementById('sciagal');
  $( "html" )
    .mouseenter(function() 
    {})
    .mouseleave(function() 
    {
      controller = controller+1;
      if (controller >= 3) 
      {
          sciagal++;
            
        button.value=sciagal;
          // alert("Jebać kapusi");
          controller = 0;            
      }
    });
</script> 

<?php include_once 'includes/footer.php'; 
}
else
{
    header("logowanie/logowanie.php");
}
?>
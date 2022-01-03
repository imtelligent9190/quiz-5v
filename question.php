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

$qtext = $_SESSION["pytania"][$_SESSION["oper"]];

foreach($_SESSION["odp"] as $key){
    $x = $_SESSION["oper"]+1;
    if($key["questionNumber"]==$x){
        array_push($choices,$key);
        array_shift($_SESSION["odp"]);
    }
    if($key["questionNumber"]>$x){
        break;
    }
    
}
$_SESSION["wyb"]=$choices;
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
        <div class="current">Question <?php echo $_SESSION["oper"]+1 //nr pyt;?> of <?php echo $_SESSION["total"] ;?> </div>
        <p class="question"><?php echo $qtext["QuestionText"];?> </p>

        <div><?php //tu będzie kiedyś zdjęcie?></div>

        <form action="process.php" method="post">
            <ul class="choices">
                <?php
                    foreach($choices as $key){?>
                        <li><input type="radio" name="choice" value="<?php echo $key['choiceText'];?>"><?php echo $key['choiceText'];?></li>
                <?php }; ?>
            </ul>
            <input id="NextQuest" type="submit" value="submit" class="btn btn-success"/>
            <input type="hidden" name="number" value="<?php echo $_SESSION["oper"]+1;?>" />
            <input type="hidden" id='sciagal' name="sciagal" value="<?php echo $_SESSION["oper"]+1;?>" />
            <input type="hidden" name="QuestionText" value="<?php echo $qtext["QuestionText"];?>" />
        </form>
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
else{
    header("logowanie/logowanie.php");
}?>
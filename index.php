<?php
    include_once 'db/connect.php';

    session_start();
    unset ($_SESSION['ile']);
    unset($_SESSION['blad_add']);
    unset($_SESSION['score']);
    unset($_SESSION['id']);
    unset($_SESSION['id_sesji']);
    unset($_SESSION['id_quiz_gra']);
    unset($_SESSION['zle']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit-no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href='css/sldiebar.css'>
    <link rel="stylesheet" href='css/main.css'>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="js/slide_menu.js"></script>

    <title>Quiz</title>
</head>
<body>





<div class="container">

<div class='header'><h1>QUIZZ</h1></div>
<div class="sidebar">
  <ul>
<?php

  if (!isset($_SESSION['user-id'])){
    header("Location: logowanie/logowanie.php");
    if (isset($_SESSION['klasa'])){
      unset($_SESSION['klasa']);
    }
    if (isset($_SESSION['user'])){
      unset($_SESSION['user']);
    }
    if (isset($_SESSION['grupa'])){
      unset($_SESSION['grupa']);
    }
    if (isset($_SESSION['uprawinienia'])){
      unset($_SESSION['uprawinienia']);
    }

  }
  else {
    $getinfo="SELECT * FROM konta WHERE id='".$_SESSION['user-id']."'";
    $rezultat=$mysqli->query($getinfo);
    $wiersz=$rezultat->fetch_assoc();
    $_SESSION['user']=$wiersz['imie']." ".$wiersz['nazwisko'];
    $_SESSION['uprawinienia']=$wiersz['admin'];
    $_SESSION['klasa']=$wiersz['klasa'];
    $_SESSION['grupa']=$wiersz['grupa'];
    echo '<li><a href="user_control/user_options.php">Moje konto</a></li><li class="przerwa"></li> ';
      
      if(isset($_SESSION['uprawinienia'])){
        if($_SESSION['uprawinienia']=='1'){
          echo '<li><h1> Narzędzia administratora </h1><li><li class="przerwa"></li>';
          echo '<li><span class="echo"><a href="admin/paneladmin.php">Zarządzaj Użytkownikami</a></li> ';
          echo '<li><a href="quizy/add_quiz.php">Dodaj quiz</a></li> ';
          echo '<li><a href="quizy/set_quiz.php">Zaplanuj quiz</a></li> ';
          echo '<li><a href="modyfiakcja_quiz/modify_quiz.php">Modyfikuj quizy</a></li> ';
          echo '<li><a href="zaplanowane/dashboard-zaplanowane.php">Zaplanowane quizy</a></li> ';
          echo '<li><a href="wyniki/wyniki.php">Wyniki quizów</a></span></li> ';
            }
        }
      }
?>
<button class="sidebar-buton"><div class="buton" id='1'></div><div class="buton" id='2'></div><div class="buton" id='3'></div></button>
</div>

<div class='grid'>
  <h1>Zaplanowane quizy</h1>
  <!-- <button class="quizy" type="submit" name="quiz_id" value="22">quiztako</button>
  <button class="quizy" type="submit" name="quiz_id" value="23">php</button>
  <button class="quizy" type="submit" name="quiz_id" value="22">quiztako</button>
  <button class="quizy" type="submit" name="quiz_id" value="23">php</button>
  <button class="quizy" type="submit" name="quiz_id" value="22">quiztako</button>
  <button class="quizy" type="submit" name="quiz_id" value="23">php</button>
  <button class="quizy" type="submit" name="quiz_id" value="22">quiztako</button>
  <button class="quizy" type="submit" name="quiz_id" value="23">php</button>
  <button class="quizy" type="submit" name="quiz_id" value="22">quiztako</button>
  <button class="quizy" type="submit" name="quiz_id" value="23">php</button> -->
  <form method='post' action='quiz_menu.php'>


<?php

if (isset($_SESSION['grupa']) && isset($_SESSION['klasa'])){
  $ile=0;
  $date=date('Y-m-d H:i:s',time());
  // echo $date;
  $aktualny = strtotime($date);
  $query="SELECT * FROM kolejka WHERE klasa='".$_SESSION['klasa']."' AND grupa='3' OR klasa='".$_SESSION['klasa']."' AND grupa LIKE'".$_SESSION['grupa']."'";
  $results= $mysqli->query($query) or die($mysqli_error.__LINE__);
  if($results->num_rows!=0){
    while($row=$results->fetch_assoc()){
      $query2="SELECT * FROM `wyniki` WHERE `imie_i_nazwisko`='".$_SESSION['user']."' AND `id_sesji`='".$row['id_sesji']."'";
      $results2= $mysqli->query($query2) or die($mysqli_error.__LINE__);
      if ($results2->num_rows==0){
        
        $start= strtotime($row['data_start']);
        $koniec= strtotime($row['data_koniec']);
        if($start<$aktualny && $aktualny<$koniec){
          echo "<button class='quizy' type='submit' name='quiz_id' value='".$row['id_sesji']."'>".$row['name']."</button>";
          $ile++;
        }else{
          
        }
      }
  }
  }if ($ile==0){
    echo "<div style='text-align:center; width:100%;'><p>Nie masz żadnych zaplanowanych quizów</p></div>";
  }
}




?></form></div>
</div>
</main>
<?php
// include_once 'includes/footer.php';
?>




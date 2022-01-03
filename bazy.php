<?php
$dbHostName= "localhost";
$dbHostUser="root";
$dbHostPasswd="";
$dbName="";
$mysqli = mysqli_connect($dbHostName,$dbHostUser,$dbHostPasswd,$dbName) or die("nie działa");
$query="CREATE DATABASE IF NOT EXISTS quiz DEFAULT CHARACTER SET utf8 COLLATE utf8_polish_ci;";
$run = $mysqli->query($query);

$query="USE quiz;";
$run = $mysqli->query($query);

$query="CREATE TABLE choices (
    id_quiz int(100) NOT NULL,
    questionNumber int(11) NOT NULL,
    isCorrect int(11) NOT NULL,
    choiceText text NOT NULL
);";
$run = $mysqli->query($query);

$query="CREATE TABLE questions(
    id_quiz int(100) NOT NULL,
    QuestionNumber int(11)NOT NULL,
    QuestionText text NOT NULL,
    img text

);";
$run = $mysqli->query($query);

$query="CREATE TABLE konta(    
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `login` text NOT NULL,
    `haslo` text NOT NULL,
    `klasa` varchar(2) NOT NULL,
    `grupa` int(11) NOT NULL,
    `imie` text NOT NULL,
    `nazwisko` text NOT NULL,
    `admin` int(1) NOT NULL
);";
$run = $mysqli->query($query);


$run = $mysqli->query($query);

$query = "CREATE TABLE quizy(
    id int(100) PRIMARY KEY AUTO_INCREMENT,
    `name` varchar(200) NOT NULL,
    id_n int(100) NOT NULL

)";
$run = $mysqli->query($query);

$query = "CREATE TABLE kolejka(
    id_sesji int(100) PRIMARY KEY AUTO_INCREMENT,
    `name` varchar(200) NOT NULL,
    id_quiz int(100) NOT NULL,
    data_start datetime NOT NULL,
    data_koniec datetime NOT NULL,
    klasa varchar(2) NOT NULL,
    grupa int(1) NOT NULL 
)";
$run = $mysqli->query($query);


$query = "CREATE TABLE `wyniki` (
    `id_sesji` int(11) NOT NULL,
    `imie_i_nazwisko` text NOT NULL,
    `id_u` int(11) NOT NULL,
    `poprawne` int(11) NOT NULL,
    `niepoprawne` text NOT NULL,
    `total_question` int(11) NOT NULL,
    `sciągał` int(11) NOT NULL,
    `data_start` time NOT NULL,
    `data_koniec` time NOT NULL
  )";
  $run = $mysqli->query($query);



  //klasy
  $query = "CREATE TABLE `klasa` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `klasa` varchar(2) NOT NULL 
  )";
  $run = $mysqli->query($query);
  $zakres=array();
  $zakres[0]='G';
  $zakres[1]='G';
  $zakres[2]='N';
  $zakres[3]='G';
  for ($i=0; $i < sizeof($zakres); $i++) { 
        for ($j=65; $j < ord($zakres[$i])+1; $j++) {
            $x=$i+1..chr($j);
            $select="SELECT * FROM klasa WHERE `klasa`='".$x."'";
            echo $select;
            $check=$mysqli->query($select);
            if ($check->num_rows==0){
                $insert="INSERT INTO klasa VALUES('null','".$x."')";
                $insertt=$mysqli->query($insert);
            }
        }
  }
  
  
?>
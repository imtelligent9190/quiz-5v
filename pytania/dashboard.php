<?php
include_once '../includes/header.php';
include_once '../db/connect.php';
session_start();

if (isset($_POST['id_quiz'])){
    $_SESSION['id']=$_POST['id_quiz'];
    unset($_POST['id_quiz']);
}
if(isset($_POST['submit_mul'])){
    $file = $_FILES['img'];
    if($file["name"]){
        
        $fileTmpName = $_FILES['img']['tmp_name'];
        $fileName = $_FILES["img"]["name"];
        $fileExt = explode(".",$fileName);
        $ext = strtolower(end($fileExt));
        $fileName = uniqid("",true).".".$ext;
        
        $upload = '../foto/'.$fileName;
    
        move_uploaded_file($fileTmpName,$upload);
    
        $questionNumber=$_POST['questionNumber'];
        $questiontext=$_POST['questionText'];
        $corectChoice=$_POST['correctChoice'];

        $choice=array();
        $choice[1]=$_POST['choice1'];
        $choice[2]=$_POST['choice2'];
        $choice[3]=$_POST['choice3'];
        $choice[4]=$_POST['choice4'];
        $choice[5]=$_POST['choice5'];

        $sql="INSERT INTO `questions`(`id_quiz`, `QuestionNumber`, `QuestionText`, `img`) VALUES('".$_SESSION['id']."','".$questionNumber."','".$questiontext."','".$upload."')";

        $insertrow=$mysqli->query($sql) or die($mysqli->error.__LINE__);

        if($insertrow){
            foreach ($choice as $choice => $value) {
                if ($value!=''){
                    if($corectChoice==$choice){
                        $isCorect=1;
                    }
                    else{
                        $isCorect=0;
                    }

                    $sql2="INSERT INTO `choices`(`id_quiz`, `questionNumber`, `isCorrect`, `choiceText`) VALUES('".$_SESSION['id']."','".$questionNumber."','".$isCorect."','$value')";
                    $inserrow2=$mysqli->query($sql2) or die($mysqli->error.__LINE__);

                    if($inserrow2){
                        continue;
                    }
                    else{
                        die ('Error: ('.$mysqli->errno.') '.$mysqli->error);
                    }
                }
            }
            $msg='Question has been added';
        }
    }
    else{
        $questionNumber=$_POST['questionNumber'];
        $questiontext=$_POST['questionText'];
        $corectChoice=$_POST['correctChoice'];

        $choice=array();
        $choice[1]=$_POST['choice1'];
        $choice[2]=$_POST['choice2'];
        $choice[3]=$_POST['choice3'];
        $choice[4]=$_POST['choice4'];
        $choice[5]=$_POST['choice5'];

        $sql="INSERT INTO `questions`(`id_quiz`, `QuestionNumber`, `QuestionText`, `img`) VALUES('".$_SESSION['id']."','".$questionNumber."','".$questiontext."',null)";

        $insertrow=$mysqli->query($sql) or die($mysqli->error.__LINE__);

        if($insertrow){
            foreach ($choice as $choice => $value) {
                if ($value!=''){
                    if($corectChoice==$choice){
                        $isCorect=1;
                    }
                    else{
                        $isCorect=0;
                    }

                    $sql2="INSERT INTO `choices`(`id_quiz`, `questionNumber`, `isCorrect`, `choiceText`) VALUES('".$_SESSION['id']."','".$questionNumber."','".$isCorect."','$value')";
                    $inserrow2=$mysqli->query($sql2) or die($mysqli->error.__LINE__);

                    if($inserrow2){
                        continue;
                    }
                    else{
                        die ('Error: ('.$mysqli->errno.') '.$mysqli->error);
                    }
                }
            }
            $msg='Question has been added';
        }
    }
}
if(isset($_POST['submit_op'])){
    $file = $_FILES['img'];
    if($file["name"]){
        
        $fileTmpName = $_FILES['img']['tmp_name'];
        $fileName = $_FILES["img"]["name"];
        $fileExt = explode(".",$fileName);
        $ext = strtolower(end($fileExt));
        $fileName = uniqid("",true).".".$ext;
        
        $upload = '../foto/'.$fileName;
    
        move_uploaded_file($fileTmpName,$upload);
    
        $questionNumber=$_POST['questionNumber'];
        $questiontext=$_POST['questionText'];

        $sql="INSERT INTO `questions`(`id_quiz`, `QuestionNumber`, `QuestionText`, `img`) VALUES('".$_SESSION['id']."','".$questionNumber."','".$questiontext."','".$upload."')";
        $insertrow=$mysqli->query($sql) or die($mysqli->error.__LINE__);
    }
    else{
        $questionNumber=$_POST['questionNumber'];
        $questiontext=$_POST['questionText'];

        $sql="INSERT INTO `questions`(`id_quiz`, `QuestionNumber`, `QuestionText`, `img`) VALUES('".$_SESSION['id']."','".$questionNumber."','".$questiontext."',null)";
        $insertrow=$mysqli->query($sql) or die($mysqli->error.__LINE__);
    }
}
$sql3 = "SELECT * FROM questions WHERE id_quiz='".$_SESSION['id']."'";
$questions = $mysqli->query($sql3) or die($mysqli->error.__LINE__);
$total = $questions->num_rows;
$next = $total+1;
?>

<mian>
    <div class = "container">
        <h2>Add A Question</h2>
        <?php 
        if(isset($msg)){
            echo '<p>'.$msg.'</php>';
        }

        ?>
        <h3>Multiple Choice Questions</h3>
        <form action="dashboard.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id-quiz" value=<?php echo $_SESSION['id'];  ?>>
            <p>
                <label for="questionNumber">Question Number</label>
                <input type="number" value="<?php echo $next;?>" name="questionNumber">
            </p>
            <p>
                <label for="questionText">Question Text</label>
                <input type="text" name="questionText">
            </p>
            <p>
                <label for="choice1">Choice #1</label>
                <input type="text" name="choice1">
            </p>
            <p>
                <label for="choice2">Choice #2</label>
                <input type="text" name="choice2">
            </p>
            <p>
                <label for="choice3">Choice #3</label>
                <input type="text" name="choice3">
            </p>
            <p>
                <label for="choice4">Choice #4</label>
                <input type="text" name="choice4">
            </p>
            <p>
                <label for="choice5">Choice #5</label>
                <input type="text" name="choice5">
            </p>
            <p>
                <label for="correctChoice">Correct Choice Number:</label>
                <input type="number" name="correctChoice">
            </p>
            <p>
            <label for="img" class="form-label" >Zdjęcie do Pytania</label>
            <input id="img" class="form-control" type="file" name="img">
            </p>
            <input type="submit" class="btn btn-primary" name="submit_mul" value="Submit">
            
        </form>
        <h3>Open-ended question</h3>
        <form action="dashboard.php" method="POST" enctype="multipart/form-data">
            <p>
                <label for="questionNumber">Question Number</label>
                <input type="number" value="<?php echo $next;?>" name="questionNumber">
            </p>
            <p>
                <label for="questionText">Question Text</label>
                <input type="text" name="questionText">
            </p>
            <p>
            <label for="img" class="form-label" >Zdjęcie do Pytania</label>
            <input id="img" class="form-control" type="file" name="img">
            </p>
            <input type="submit" class="btn btn-primary" name="submit_op" value="Submit">
        </form>
        <a href="../index.php" class="btn btn-primary">Back</a>
        <a href="gettxt.php" class="btn btn-primary">to txt</a>
    </div>
</mian>

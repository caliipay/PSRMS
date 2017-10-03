<?php
session_start();
require_once("dbcontroller.php");
$id = $_POST['itemID'];
$old = $_POST['oldItem'];
//$question = addslashes($_POST['textInput']);
$db_handle = new DBController();
$previous = $_SERVER['HTTP_REFERER'];
$question = "";

//get the concatenated string for the question
//question format in db should be => 'originalTranslation'['language2']'translation2'...['languageN']'translationN'
foreach($_POST as $key => $item) {
    if($key === "itemID" || $key === "oldItem") {
        //do nothing
    } else {
        if($key === "Original") {
            $question .= $item;
        } else {
            $question .= "[".$key."]".$item;
        }
    }
}
//sanitize string
$question = addslashes($question);
//echo($question);

if (empty($question)) {
    
     echo "<script type='text/javascript'>alert('empty field!');
     location='".$previous."';</script>";
} else {
    $db_handle->runUpdate("UPDATE `questions` SET `Question` = '".$question."' WHERE `questions`.`QuestionsID` = ".$id);
    $db_handle->runUpdate("INSERT INTO `edit_history`(`EditHistoryID`, `USER_UserID`, `LastEdit`, `FORM_FormID`, `QUESTIONS_QuestionsID`, `INTAKE_IntakeID`, `Remark`) VALUES (NULL,".$_SESSION["userID"].",now(),NULL,".$id.",NULL, 'edited this question')");
    if($db_handle->getUpdateStatus()) {
        echo "<script type='text/javascript'>alert('Changed from:\\n ".json_encode($old)."\\n\\nChanged to:\\n ".json_encode($question)."');
        </script>";
        echo "<script type='text/javascript'> location='".$previous."'; </script>";
    } else {
        echo "<script type='text/javascript'>alert('Error! Please take note of what happened and then report it to the system admin.');
        location='".$previous."';
        </script>";
    }
}
?>
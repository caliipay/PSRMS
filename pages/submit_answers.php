<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
$post = $_POST;
$query = "";
$question_ids = array();
$answeredQuestions = array();
$unansweredQuestion = array();
$formIDs = array();
$idp_form_answers_id = array();

foreach($post as $key => $result) {
    echo($key.": ".$result."<br>");
    //if $key has 'q-' prefix (which is for questions), add to $question_ids array
    if (strpos($key, 'q-') !== false) {
        $keys1 = explode('-',$key);
        //question key format => q-(formID)-(answerType)-(questionID) ex: q-17-1-397
        $question_ids[$keys1[1]."-".$keys1[3]] = $result; //set question id as array index for easier finding later
    } else {
        $keys2 = explode('-',$key);

        //add query for idp_form_answers table which is an fk for answers_quali and answers_quanti
        if(!in_array($keys2[0], $formIDs, true)) {
            $formIDs[$keys2[0]] = $keys2[0];
            $db_handle->runUpdate("INSERT INTO `form_answers` (`FORM_ANSWERS_ID`, `USER_UserID`, `FORM_FormID`, `DateTaken`, `IDP_IDP_ID`, `UnansweredItems`) VALUES (NULL, '".$_SESSION['userID']."', '".$keys2[0]."', CURRENT_TIMESTAMP, ".$_SESSION['idpID'].", NULL);");
            //store the auto-incremented id for use in update. Unanswered questions will be updated after this foreach
            $tempID = $db_handle->getLastInsertID();
            $idp_form_answers_id[$keys2[0]."-".$tempID] = $tempID;
        }
        //add query for answers_quali and answers_quanti
        $answeredQuestions[$keys2[2]] = $keys2[2]; //set question id as array index for easier finding later
        if($keys2[1] == 1) {
           // echo($keys2[2]." is quantitative<br>");
            $query .= "INSERT INTO `answers_quanti` (`ANSWERS_QUANTI_ID`, `Answer`, `QUESTIONS_QuestionsID`, `FORM_ANWERS_FORM_ANSWERS_ID`, `INTAKE_ANSWERS_INTAKE_ANSWERS_ID`) VALUES ( NULL, '".$result."', '".$keys2[2]."', '".$idp_form_answers_id[$keys2[0]."-".$tempID]."', NULL);";
        } else if(!empty($result)) {
           // echo($keys2[2]." is qualitative<br>");
            $query .= "INSERT INTO `answers_quali` (`ANSWERS_QUALI_ID`, `Answer`, `QUESTIONS_QuestionsID`, `FORM_ANSWERS_FORM_ANSWERS_ID`, `INTAKE_ANSWERS_INTAKE_ANSWERS_ID`) VALUES ( NULL, '".$result."', '".$keys2[2]."', '".$idp_form_answers_id[$keys2[0]."-".$tempID]."', NULL);";
        } else {
            $unansweredQuestion[$keys1[1]."-".$keys1[3]] = $keys1[3];
        }
    }
}
/*echo("<br>------<br>");
echo(json_encode($answeredQuestions));
echo("<br>------<br>");
echo(json_encode($question_ids));
echo("<br>------<br>");
echo(json_encode($question_ids));
echo("<br>------<br>");*/
foreach($question_ids as $key => $qID) {
    $keys3 = explode('-',$key);
    if(!in_array($keys3[1], $answeredQuestions, true)) {
        $unansweredQuestion[$key] = $keys3[1];
    }
}
asort($unansweredQuestion);
/*echo("<br>------<br>");
echo(json_encode($unansweredQuestion));*/

foreach($idp_form_answers_id as $key1 => $item1) {
    $arr1 =  explode('-',$key1);
    $query .= "UPDATE `form_answers` SET `UnansweredItems` = '";
    foreach($unansweredQuestion as $key2 => $item2) {
        $arr2 = explode('-',$key2);
        if($arr1[0] == $arr2[0]) {
            $query .= $item2.",";
        }
    }
    $query .= "' WHERE `form_answers`.`FORM_ANSWERS_ID` = ".$arr1[1].";";
}
$db_handle->runUpdate($query);
if($db_handle->getUpdateStatus()) {
    echo "<script type='text/javascript'>alert('Answers submitted!');
    location='apply_form.php?id=".$_SESSION['idpID']."';
    </script>";
}
unset($_SESSION['idpID']);
/*foreach($question_ids as $key => $qid) {
    if(empty($answeredQuestions[$qid]) || $question_answers[$qid] == '') {

    } else {
        echo("<br>------<br>".$answeredQuestions[$qid]);
    }
}*/

//foreach()

/*foreach($post as $key => $results) {
    //if $key has 'q-' prefix (which is for questions), add to $question_ids array
    if (strpos($key, 'q-') !== false) {
        $question_ids[$key] = $results;
    //else if $key has '1-' prefix (which is for answers), add to $question_answers array
    } else if (strpos($key, '1-') !== false) {
        $question_answers[$key] = $results;
    //else if $key has '2-' prefix (which is for answers) and answer is not blank, add to $question_answers array
    } else if (strpos($key, '2-') !== false && $results !== '') {
        $question_answers[$key] = $results;
    }
}

echo(json_encode($question_answers));

foreach($question_ids as $result) {
    //if a key ('1-xx' where xx is the questionID) in question_answers exists, do nothing.
    if(isset($question_answers['1-'.$result]) || isset($question_answers['2-'.$result])) {

    //else, add as unanswered question
    } else {
        $unansweredQuestion[] = $result;
    }
}

echo("<br>------------------------------------------<br>");
echo(json_encode($unansweredQuestion));
echo("<br>------------------------------------------<br>");

foreach($question_ids as $key => $qid) {
echo($key.": ".$qid."<br>");
}
echo("<br>------------------------------------------<br>");
echo(json_encode($question_ids));*/


/*if(empty($unansweredQuestion)) {
    $db_handle->runUpdate("INSERT INTO `form_answers` (`FORM_ANSWERS_ID`, `USER_UserID`, `FORM_FormID`, `DateTaken`, `IDP_IDP_ID`, `UnansweredItems`) VALUES (NULL, '".$_SESSION['userID']."', '".$_SESSION['assessment_tool_ID']."', CURRENT_TIMESTAMP, ".$_SESSION['idpID'].", NULL);");
} else {
    $db_handle->runUpdate("INSERT INTO `form_answers` (`FORM_ANSWERS_ID`, `USER_UserID`, `FORM_FormID`, `DateTaken`, `IDP_IDP_ID`, `UnansweredItems`) VALUES (NULL, '".$_SESSION['userID']."', '".$_SESSION['assessment_tool_ID']."', CURRENT_TIMESTAMP, ".$_SESSION['idpID'].", '".implode(',', $unansweredQuestion)."');"); //implode format => id,id,id,...,id
}
//get last insert ID for next query
$idp_form_answers_id = $db_handle->getLastInsertID();

foreach($question_answers as $key => $qa) {
    $tempAnsType = substr($key, 0, 1); //remove string after index 1; ex key: '1-199' where 1 is the answer type
    $tempID = substr($key, 2); //remove first two chars of key. ex key: '1-199' where 199 is the question id
    if($tempAnsType === '1') {
        $query .= "INSERT INTO `answers_quanti` (`ANSWERS_QUANTI_ID`, `Answer`, `QUESTIONS_QuestionsID`, `FORM_ANWERS_FORM_ANSWERS_ID`, `INTAKE_ANSWERS_INTAKE_ANSWERS_ID`) VALUES ( NULL, '".$qa."', '".$tempID."', '".$idp_form_answers_id."', NULL);";
    } else if($tempAnsType === '2') {
        $query .= "INSERT INTO `answers_quali` (`ANSWERS_QUALI_ID`, `Answer`, `QUESTIONS_QuestionsID`, `FORM_ANSWERS_FORM_ANSWERS_ID`, `INTAKE_ANSWERS_INTAKE_ANSWERS_ID`) VALUES ( NULL, '".$qa."', '".$tempID."', '".$idp_form_answers_id."', NULL);";
    }
}
$db_handle->runUpdate($query);
if($db_handle->getUpdateStatus()) {
    echo "<script type='text/javascript'>alert('Answers submitted!');
    location='apply_form.php?id=".$_SESSION['idpID']."';
    </script>";
}*/
//unset($_SESSION['idpID']);
?>
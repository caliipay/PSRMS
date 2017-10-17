<?php
require_once("dbcontroller.php");
$db_handle = new DBController();
$previous = $_SERVER['HTTP_REFERER'];
$post = $_POST;
$lang = $_POST['transLang'];
$query = "";
foreach($post as $key => $value) {
    if(($key !== "transLang" && substr($key,0,11) !== "oldQuestion") && $value !== '') {
        $query.=htmlspecialchars("UPDATE `questions` SET `Question` = '".$_POST["oldQuestion-".substr($key,9)]."[".$lang."]".$value."' WHERE `questions`.`QuestionsID` = ".substr($key,9).";");
    }
}
$db_handle->runUpdate($query);

if($db_handle->getUpdateStatus()) {
    echo "<script type='text/javascript'>alert('Translations submitted!');
    </script>";
    echo "<script type='text/javascript'> location='".$previous."'; </script>";
} else {
    echo "<script type='text/javascript'>alert('Error! Please take note of what happened and then report it to the system admin.');
    location='".$previous."';
    </script>";
}

?>
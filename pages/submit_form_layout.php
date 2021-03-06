<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
$previous = $_SERVER['HTTP_REFERER'];
$post_values = $_POST;
$html_forms = $db_handle->runFetch("SELECT * FROM `html_form` WHERE 1");
$post =  array_values($_POST);  //$_POST assoc to numeric array; contains form type, quantity alternately
$post_len = count($post);
$q_ids = array();               //array of question ids
//extract ids from $_POST
foreach($post_values as $key => $value) {
    //$key is in the form of 1-xx or 2-xx (1 = quanti question, 2 = quali question)
    //if key starts with 1 or 2, it is a key for a question
    //if key starts with 1 or 2, add 1 to length
    if(substr($key,0,1) == '1' || substr($key,0,1) == '2') {
       $q_ids[] = substr($key,2);
    }
}

$q_ids_len = count($q_ids);     //q_ids entry count/ array length
$q_html_form = array();         //array for html_form ids to be used in query
$query = "";                    //sql query
$outputArray = array();         //SPL** entry search output (contains form_id, form type, quantity from HTML_FORMS table)



//converting $post array to a 2d array that contains [form type, quantity] per entry
//last entry is the form id, thus, $post_len-1
for($i = 0; $i < $post_len-1; $i += 2) {
    $q_html_form[] = array($post[$i], $post[$i+1]);
}

//**SPL method for searching associative array by $key => $value. Not sure how it works but it works. lol------------------------
//method found here: https://stackoverflow.com/questions/1019076/how-to-search-by-key-value-in-a-multidimensional-array-in-php
$array_iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($html_forms));
for($j = 0; $j < $q_ids_len; $j++) {
    foreach ($array_iterator as $sub) {
        $subArray = $array_iterator->getSubIterator();
        if (($subArray['HTML_FORM_TYPE'] === $q_html_form[$j][0]) && ($subArray['HTML_FORM_INPUT_QUANTITY'] === $q_html_form[$j][1] || $subArray['HTML_FORM_INPUT_QUANTITY'] === null) ) {
            //$outputArray[] = iterator_to_array($subArray);
            $outputArray[] = array_values(iterator_to_array($subArray));
        }
    }
}
//----------------------------------------------------------------------------------------------------------------------------

for($k = 0; $k < $q_ids_len; $k++) {
    $query .= "UPDATE `questions` SET `HTML_FORM_HTML_FORM_ID` = '".$outputArray[$k][0]."' WHERE `questions`.`QuestionsID` = '".$q_ids[$k]."';";
}

$db_handle->runUpdate($query);

if($db_handle->getUpdateStatus()) {
    echo "<script type='text/javascript'>alert('Layout saved!');
    location='".$previous."';
    </script>";
}
?>
<?php
include ('check_credentials.php');
include ('head.php');
require_once("dbcontroller.php");
$db_handle = new DBController();
include("css_include.php");
include("core_include.php");
$toolIDs = json_decode($_POST["toolID"]);
$idpName = $_POST['idpName'];
$_SESSION['idpID'] = $_POST['idpID'];
$idString = "";
//convert array to string for query
foreach($toolIDs as $id) {
    $idString .= $id.", ";
}
//trimmed $idString because of the extra ", "
$formQuery = "SELECT * FROM `form` WHERE FormID IN (".substr($idString,0,-2).")";
$questionQuery = "SELECT FORM_FormID, QuestionsID, Question, html_form.HTML_FORM_TYPE as FormType, html_form.HTML_FORM_INPUT_QUANTITY as InputRange FROM `questions` JOIN html_form ON questions.HTML_FORM_HTML_FORM_ID = html_form.HTML_FORM_ID WHERE FORM_FormID IN (".substr($idString,0,-2).") ORDER BY FIELD(FORM_FormID, ".substr($idString,0,-2).")";
$form_info = $db_handle->runFetch($formQuery);
$questionsResult = $db_handle->runFetch($questionQuery);
$questions = array();
$itemStart = 0;

$questTranslations = array();   //associative array of tokenized questions and translations
$languages = array();           //array of available translation languages
?>
<style>
    .container-fluid {
        margin-left: 10%;
        margin-right: 10%;
    }
</style>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <form action="submit_answers.php" method="post">
                <div class="col-md-12 accordion" id="myAccordion">
                    <?php
                    if(!empty($form_info)) {                
                        foreach($form_info as $form) {
                            foreach($questionsResult as $result) {
                                if($result["FORM_FormID"] == $form["FormID"]) {
                                    $questions[] = $result;
                                }
                            }
                            //tokenize a sample question to get the existing translations
                            if(!empty($questions[0]["Question"])) {
                                $arr = explode("[", $questions[0]["Question"]);
                                foreach($arr as $translation) {
                                    //extract first language token which will not have ']'
                                    if (!(strpos($translation, ']') !== false)) {
                                        //to avoid duplicates, check if the language is already in the array
                                        if(!in_array("Original", $languages, true)) {
                                            //add "Original" as a language in $languages
                                            array_push($languages, "Original");
                                        }
                                    } else {
                                        //succeeding tokens will have a language followed by ']'. ie. "English]This is a sample"
                                        //tokenize string. ie "English]This is a sample" --> $translation[0] = "English"; $translation[1] = "This is a sample"
                                        $translation = explode("]", $translation, 2);
                                        //to avoid duplicates, check if the language is already in the array
                                        if(!in_array($translation[0], $languages, true)) {
                                            //add $translation[0] as a language in $languages
                                            array_push($languages, $translation[0]);
                                        }
                                    }
                                }

                                unset($arr);
                            }
                    ?>
                    <div class="panel panel-info">
                        <div class="panel-heading text-left">
                            <div class="row">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#myAccordion" href="#collapsible-<?php echo($form['FormID']) ?>">
                                <div class="col-md-9">
                                    <h4>
                                        <?php
                            echo($form['FormType']);
                            if(isset($form['ItemStart'])) $itemStart = $form['ItemStart'];
                                        ?>
                                    </h4>
                                    <h4 style="margin: 10px 40px;">
                                        Name: <b><?php echo ($idpName); ?></b><br>
                                    </h4>
                                </div>
                                </a>
                                <div class="col-md-3">
                                    <label for="languageSelect">Translation:</label>
                                    <div id="languageSelect">
                                        <select id="languages" class="form-control" onchange='showDiv(this,<?php echo($form['FormID']) ?>,<?php echo(json_encode($languages)); ?>)'>
                                    <?php
                                    foreach($languages as $language) {
                                    ?>
                                        <option value='<?php echo($language); ?>'><?php echo($language); ?></option>
                                    <?php
                                    }
                                    ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body panel-collapse collapse in" id="collapsible-<?php echo($form['FormID']) ?>">
                            <div class="col-md-9">
                            </div>
                            <h4 style="margin: 20px 40px;"><?php echo($form['Instructions']); ?></h4>
                                <?php
                            if(!empty($questions)) {
                                ?>
                                <?php
                                foreach ($questions as $result) {
                                    //-----Tokenization of questions and translations------
                                    //use "id"+(questionID) as a key for the initial-nested-associative array for translation storage XD
                                    //each translation will be saved in $questTranslations["id".(questionID)]["translations"][(Language)]
                                    $questTranslations = array_merge($questTranslations, array("id".$result['QuestionsID'] => array("translations" => array())));
                                    //tokenize string, use '[' as the basis of division
                                    $arr = explode("[", $result['Question']);
                                    foreach($arr as $translation) {
                                        //extract first token which will not have ']'
                                        if (!(strpos($translation, ']') !== false)) {
                                            //include it to our nested-associative array for questions and its translations, setting 'Original' as the first language
                                            $questTranslations["id".$result['QuestionsID']]["translations"] = array_merge($questTranslations["id".$result['QuestionsID']]["translations"], array("Original" => $translation));
                                        } else {
                                            //succeeding tokens will have a language followed by ']'. ie. "English]This is a sample"
                                            //tokenize string. ie "English]This is a sample" --> $translation[0] = "English"; $translation[1] = "This is a sample"
                                            $translation = explode("]", $translation, 2);
                                            ////include it to our nested-associative array setting $translation[0] as the language
                                            $questTranslations["id".$result['QuestionsID']]["translations"] = array_merge($questTranslations["id".$result['QuestionsID']]["translations"], array($translation[0] => $translation[1]));
                                        }
                                    }
                                    //sample translation associative array entry:
                                    //$questTranslations["id25"]["translations"]["English"] = "This is a sample"
                                    //$questTranslations["id25"]["translations"]["Filipino"] = "Ito ay isang halimbawa"
                                    //-----Tokenization End------
                                ?>
                                <table align="center" cellspacing="3" cellpadding="3" width="90%" class=" table-responsive">
                                    <tr>
                                        <td align="left" style="width:90%" name="no">
                                            <h4>
                                                <?php
                                    foreach($questTranslations["id".$result['QuestionsID']]["translations"] as $key => $translation) {
                                        //echo($key.": ".$translation."<br>");
                                        echo('<div name="'.$key.'-'.$form['FormID'].'">'.htmlspecialchars($translation)."</div>");
                                    }
                                                ?>
                                            </h4>
                                        </td>
                                    </tr>
                                    <tr name="preview-wrapper" style="margin-bottom: 30px;">
                                        <td id="preview-wrapper<?php echo($result['QuestionsID']); ?>" >
                                            <?php 
                                    //if $result['FormType'] exists; it means the question is already assigned an html_form
                                    if(isset($result['FormType'])) {
                                        echo '<fieldset id="q-a-'.$result['QuestionsID'].'">';
                                        echo '<input type="hidden" name="q-'.$form['FormID'].'-1-'.$result['QuestionsID'].'" value="'.$result['QuestionsID'].'">';
                                        if(isset($result['InputRange'])) { //if AnswerRange is not null. It means html form is either checkbox or radio
                                            //html_form inline echo loop
                                            for($i = $itemStart; $i < $result['InputRange'] + $itemStart; $i++) {
                                                echo'<label class="'.$result['FormType'].'-inline"><input type="'.$result['FormType'].'" name="'.$form['FormID'].'-1-'.$result['QuestionsID'].'" value="'.$i.'">'.$i.'</label>';
                                            }
                                        } else {
                                            if($result['FormType'] === "textarea") {
                                                echo '<textarea class="form-control" rows="5" id="comment" name="'.$form['FormID'].'-2-'.$result['QuestionsID'].'"></textarea>';
                                            } else if($result['FormType'] === "text") {
                                                echo '<input class="form-control" id="inputdefault" type="'.$result['FormType'].'" name="'.$form['FormID'].'-2-'.$result['QuestionsID'].'">';
                                            }
                                        }
                                        echo '</fieldset>';
                                    }
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                                <?php
                                }
                            } else { ?>
                                <table align="center" cellspacing="3" cellpadding="3" width="90%" class="table-responsive">
                                    <tr>

                                        <td align="left">
                                            <h4>No questions for this form yet!</h4>
                                        </td>

                                    </tr>
                                </table>
                                <?php
                            }
                                ?>
                            <div class="row">
                                <br>
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="collapse" data-target="#collapsible-<?php echo($form['FormID']) ?>" data-parent="#myAccordion"><i class="fa fa-eye-slash"></i>&nbsp;Hide</button>
                                </div>   
                            </div>
                        </div>
                    </div>
                    <?php   
                            //unset array for next iteration
                            unset($questions);
                            unset($questTranslations);
                            unset($languages);
                            //instantiate array for next iteration
                            $questions = array();
                            $questTranslations = array();
                            $languages = array(); 
                        }
                    }
                    ?>
                </div>
                <div class="col-md-12">
                    <button id="btn-submit-form" class="btn btn-primary btn-md" type="submit"><i class="fa fa-check"></i>&nbsp;Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    //show first translation as default
    $('div[name*="Original"]').show().siblings().hide();
    //function for changing question display based on selected option
    function showDiv(elem, fID, arr){
        var languages = arr;
        for(var i = 0; i < languages.length; i++) {
            //if selected option value is the same as language[i]
            if(elem.value == languages[i])
                //display <div> with a name languages[i]-fID. Hide others
                $('div[name='+languages[i]+'-'+fID+']').show().siblings().hide();
        }
    }
</script>
<?php 
include ('check_credentials.php');
unset($_SESSION['form_id']);
unset($_SESSION['form_name']);
$ul_forms = "active";
include ('sidebar.php');
include ('head.php');
include ('core_include.php');
?>
<style type="text/css">
    .modal {
        padding-top: 2%; /* Location of the box */
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
    }

    /* Modal Content */
    .modal-content {
        position: relative;
        top: 0%;
        background-color: #fefefe;
        margin: auto;
        padding: 0;
        border: 1px solid #888;
        width: 100%;
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
    }
    /* The Close Button */
    .close {
        color: white;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }

    .modal-header {
        padding: 2px 16px;
        background-color: #9368E9;
        color: white;
    }

    .modal-body {padding: 2px 16px;}

    .modal-footer {
        padding: 2px 16px;
        background-color: #9368E9;
        color: white;
    }
</style>
<div class="main-panel">
    <?php 
        include ('navbar.php');
        require_once("dbcontroller.php");
        $db_handle = new DBController();
        $forms = $db_handle->runFetch("SELECT * FROM `form` WHERE 1");
    ?>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                        <h4 class="title"><b>Forms</b></h4> <br>
                        </div>
                        <div class="content">
                            <div id="formPreferences" class="ct-forms ct-perfect-fourth">
                                <table align="left" cellspacing="3" cellpadding="3" width="75%" class="table table-bordered table-advance table-hover ">
                                    <tr>
                                        <?php //<td align="left"><b>NGO Form ID</b></td> ?>
                                        <th align="left"><h6><b>Assessment form Name <button class="btn btn-success btn-fill btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i>Add Assessment Tool</button></b></h6></th>
                                        <th align="left"><h6><b>Action</b></h6></th>

                                    </tr>
                                    <?php if(!empty($forms)) {
                                        foreach ($forms as $form) {
                                            echo '<tr>
                                            <td align="left"><h6>' . $form['FormType'] . '</h6></td>
                                            <td align="left"><button class="btn btn-warning btn-fill btn-sm center-block"><a href="edit_form.php?form_id=' . $form['FormID'] . '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Tool</a></button></td>
                                            </tr>
                                            ';
                                        }
                                    } else { ?>
                                    <tr>
                                        <td>No forms available!</td>
                                    </tr>;
                                    <?php } ?>
                                </table>
                                <br>
                                <table align="left" cellspacing="3" cellpadding="3" width="75%" class="table table-bordered table-advance table-hover ">
                                    <tr>
                                        <?php //<td align="left"><b>NGO Form ID</b></td> ?>
                                        <th align="left"><h6><b>Intake form [Disaster - Age group] <button class="btn btn-success btn-fill btn-sm" onClick ="show_modal()" role="button"><i class="fa fa-plus"></i>Create Intake Form</button></b></h6></th>
                                        <th align="left"><h6><b>Action</b></h6></th>

                                    </tr>
                                    <?php if(!empty($intakes)) {
                                        foreach ($intakes as $intake) {
                                        //<td align="left">' . $form['NGO_FORM_ID'] . '</td>
                                        echo '<tr>
                                        <td align="left">' . $intake['DisasterName'] . ' - ';
                                        if($intake['AgeGroup'] === '1') {
                                            echo ("Intake for adults");
                                        } else if ($intake['AgeGroup'] === '2') {
                                            echo ("Intake for children");
                                        }
                                        echo '</td>
                                        <td align="left"><h6><button class="btn btn-warning btn-fill btn-sm center-block"><a href="edit_intake.php?form_id=' . $form['FormID'] . '&form_name='.$form['FormType'].'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Form</a></button></h6></td>
                                        </tr>
                                        ';
                                        }
                                    } else {
                                        echo '<tr>
                                            <td><h6>No forms available!<h6></td>
                                        </tr>';
                                    }?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal content -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2>
                    Add Form
                    <span><h5><sup>This section is for adding a new form to the database.</sup></h5></span>
                </h2>
            </div>
            <div class="modal-body">
                <table align="center" cellspacing="3" cellpadding="3" width="95%">
                    <form action="submit_add_form.php" method="post">
                        <tr>
                            <td>
                                <br><label for="formType">Form name:</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text"  class="form-control" name="formType" id="formType">
                                <input type="hidden" name="previous_page" value="<?php echo($_SERVER['HTTP_REFERER']); ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <br><label for="formInstructions">Form Instructions:</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <textarea class="form-control" rows="5" name="formInstructions" id="formInstructions"></textarea>
                                <?php //<input type="text"  class="form-control" name="formInstructions" id="formInstructions"> ?>
                            </td>
                        </tr>
                        <tr>
                            <!-- ITEM START | YES OR NO? -->
                            <td>
                                <br>
                                Choices start at:
                                <label class="radio-inline"><input type="radio" name="itemStart" value='0'>0</label>
                                <label class="radio-inline"><input type="radio" name="itemStart" value='1'>1</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <br><input type="submit" class="btn btn-info" value="Submit">
                            </td>
                        </tr>
                    </form>
                </table>
            </div>
            <div class='modal-footer'>
                <a> &nbsp; <br>
                    &nbsp;
                </a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../js/jquery-1.12.4.js"></script>
<script type="text/javascript" src="../js/edit_form-functions.js"></script>
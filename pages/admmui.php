<?php session_start();
$ul_muser = "active"; $ul_forms = ""; $ul_idp =""; include ('sidebar.php');
unset($_SESSION['form_id']);
unset($_SESSION['form_name']);
?>
<?php include ('head.php'); ?>

<div class="main-panel">

    <?php
    include ('navbar.php');
    include ('footer.php');
    include_once("dbcontrollerPDO.php");
    $db_handle = new DBController();
    $_SESSION['loc']=$_SERVER['PHP_SELF'];
    
    $db_handle->prepareStatement("SELECT * FROM `agency` ORDER BY AgencyName");
    $agencies = $db_handle->runFetch();
    ?>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h3>Account Enrollment</h3>
                        </div>
                        <div class="col-md-6">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                <div class="panel-heading"><h6><b>Enroll Account</b></h6></div>
                            </a>
                        </div>
                        <div class="panel-body">
                            <form method="POST" action="enroll_account.php">
                                <div  id = "personal_info_div" class="col-lg-12">
                                    <div class="panel">
                                        <div class="panel-body panel-collapse collapse" id="collapseOne">
                                            <div class="form-group col-md-4">
                                                <!--<label for="Lname">Last Name<span class="required">*</span></label>-->
                                                <input class="form-control" id = 'Lname' name='Lname' placeholder="Last name" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <!--<label for="Fname">First Name<span class="required">*</span></label>-->
                                                <input class="form-control" id="Fname" name='Fname' placeholder="First name" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <!--<label for="Mname">Middle Name<span class="required">*</span></label>-->
                                                <input class="form-control" id='Mname' name='Mname' placeholder="Middle Name" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <!--<label for="Bdate">Date of birth<span class="required">*</span></label>-->
                                                <input type="date" id="Bdate" name='Bdate' class="form-control" required>

                                            </div>

                                            <div class="form-group col-md-4">
                                                <!--<label for="Age">Age<span class="required">*</span></label>-->
                                                <input class="form-control" id="Age" name='Age' placeholder="Age" type="number" min="0" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <!--<label for="Gender">Gender<span class="required">*</span></label>-->
                                                <select id="Gender" name='Gender' class="form-control" required>
                                                    <option value="1">Male</option>
                                                    <option value="2">Female</option>
                                                </select>             
                                            </div>
                                            <div class="form-group col-md-6">
                                                <!--<label for="PhoneNum">Phone Number<span class="required">*</span></label>-->
                                                <input class="form-control" id="PhoneNum" name='PhoneNum' placeholder="Phone Number" id = "PhoneNum">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <!--<label for="Email">Email<span class="required">*</span></label>-->
                                                <input type="email" class="form-control" id='Email' name='Email' placeholder="your@mail.com">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <!--<label for="pwd1">Password<span class="required">*</span></label>-->
                                                <input type="password" class="form-control" id="pwd1" name="pwd1" placeholder="Enter password" pattern="(?=^.{10,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" oninvalid="this.setCustomValidity('Atleast 10 chars. 1 uppercase, 1 lowercase, 1 special char')" oninput="setCustomValidity('')">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <!--<label for="pwd2">Verify password<span class="required">*</span></label>-->
                                                <input type="password" class="form-control" id="pwd2" name="pwd2" placeholder="Verify password" pattern="(?=^.{10,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" oninvalid="this.setCustomValidity('Atleast 10 chars. 1 uppercase, 1 lowercase, 1 special char')" oninput="setCustomValidity('')">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label class="text-warning"><sup>Please note: Passwords should be at least 10 characters with atleast one letter and atleast one number or one special character</sup></label>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="Agency">Agency<span class="required">*</span></label>
                                                <select id="Agency" name='Agency' class="form-control" required>
                                                    <?php
                                                    foreach($agencies as $agency) {
                                                    ?>
                                                    <option value="<?php echo($agency["AgencyID"]) ?>"><?php echo($agency["AgencyName"]) ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                    <option value="specify">Other(specify)</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4" id="specifyAgency" style="display:none">
                                                <label for="Lname">Specify Agency<span class="required">*</span></label>
                                                <input class="form-control" id="specAgency" name="specAgency" placeholder="Enter Your Agency">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="UserGroup">User Group<span class="required">*</span></label>
                                                <select id="UserGroup" name='UserGroup' class="form-control" required>
                                                    <option value="1">MSU-IIT Psych Dept</option>
                                                    <option value="2">MSU-IIT GCC</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <input type="submit" class="btn btn-info btn-fill btn-sm">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h3>Account Management</h3>
                        </div>
                        <div class="col-md-6">
                            <div class="panel-heading"><h6><b>Enrolled Accounts</b></h6></div>
                        </div>
                        <div class="panel-body">
                            *populate
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container-fluid">
            <p class="copyright pull-right">
                &copy; <script>document.write(new Date().getFullYear())</script> <a href="http://www.msuiit.edu.ph">MSU-IIT</a>, PSRMS Mindanao Center for Resiliency
            </p>
        </div>
    </footer>

</div>
<script type='text/javascript'>
  $(document).ready(function(){
       $('#Agency').change(function(){
           if ($(this).val() == 'specify') {
               $('#specifyAgency').show();       
           } else {
               $('#specifyAgency').hide(); 
           }
        });
  });
</script>
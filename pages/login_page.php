<html>
    <head>
        <?php
        session_start();
        include("head.php");
        if(isset($_SESSION["userID"])) {
            header( "Location: dashboard.php" );
        }
        require_once("dbcontroller.php");
        include("css_include.php");
        $db_handle = new DBController();
        ?>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-default panel-info" id="login-panel">
                        <div class="panel-heading">
                            <h4 class="text-center">PSRMS</h4>
                        </div>
                        <div class="panel-body">
                            <form action="login.php" method="post">
                                <div class="form-group">
                                    <!--<label for="email">Email address:</label>-->
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <!--<label for="pwd">Password:</label>-->
                                    <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Password">
                                </div>
                                <input type="submit" class="btn btn-info btn-fill btn-lg center-block" id="login-btn" value="Login">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </body>
</html>
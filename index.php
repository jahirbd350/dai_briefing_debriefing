<?php
session_start();
$message = '';

if (isset($_SESSION['user_id'])) {
    $user_role = $_SESSION['user_role'];
    if ($user_role == "super_admin") {
        header('Location: super_admin/manage_briefing_super_admin.php');
    }
    if ($user_role == "admin") {
        header('Location: admin/manage_briefing.php');
    }
    if ($user_role == "user") {
        header('Location: forms/homepage.php');
    }
}

if (isset($_POST['btn_signIn'])) {
    require_once('Login.php');
    $login = new Login();
    $message = $login->adminLoginCheck($_POST);
}

if (isset($_POST['btn_password_reset_request'])) {
    require_once('Login.php');
    $login = new Login();
    $message = $login->passwordResetRequest();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DAI Briefing/De-Briefing</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel = "icon" href ="icon.png" type = "image/x-icon">
</head>
<style>
    .left-panel {
        height: 315px;
        background: url(dai_logo.jpg);
        background-repeat: no-repeat;
        background-size: 555px 315px
    }
</style>
<body>
<div class="container" style="margin-top: 60px">
    <div class="row">
        <!--<div class="col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center text-primary">Welcome to Directorate of Air Intelligence</h3>
                </div>
                <div class="panel-body left-panel">
                    <h2 class="text-center bg-primary" style="opacity: 0.6">
                        If you can't login please contact<br>
                        Dte AI @ 3050 or 01769993050
                    </h2>
                </div>
            </div>
        </div>-->
        <marquee behavior="scroll" direction="left"><h3 style="display: inline" class="bg-primary">If you can't login please contact Dte AI @ 3050 or 01769993050</h3></marquee>
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center text-primary">User Login</h3>
                </div>
                <div class="panel-body">
                    <h4 class="text-center text-danger bg-info"><?php echo $message; ?></h4>
                    <h4 class="text-center text-success bg-info">
                        <?php if (isset($_SESSION['message'])) {
                            echo $_SESSION['message'];
                        };
                        unset($_SESSION['message']);
                        ?>
                    </h4>
                    <form class="form-horizontal" method="post" action="" data-toggle="validator">
                        <div class="row">
                            <label class="col-md-4 control-label">Svc No</label>
                            <div class="col-md-8 form-group has-feedback">
                                <input type="text" pattern="[A-z0-9_ ]{1,}$"
                                       data-pattern-error="No special character is allowed!" class="form-control"
                                       placeholder="Svc No" name="bd_no" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 control-label">Date of Birth</label>
                            <div class="col-md-8 form-group has-feedback">
                                <input type="date" data-error="Pl enter a valid date!" class="form-control" name="date_of_birth" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 control-label">Password</label>
                            <div class="col-md-8 form-group has-feedback">
                                <input type="password" id="password" data-minlength="4"
                                       data-error="Password minimum 4 character !" class="form-control"
                                       placeholder="Password" name="user_password" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-8 form-group">
                                <button type="submit" class="btn btn-success btn-block" name="btn_signIn">Sign in</button>
                            </div>
                        </div>
                        <h5 class="text-center text-success">Forgot your password?
                            <button type="submit" name="btn_password_reset_request" class="btn btn-sm btn-danger">Request to Reset your Password</button>
                        </h5>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--<div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <div class="well">
                <h4 class="text-center text-success">Not a User? Please <a class="btn btn-info" href="register.php">Register</a>
                </h4>

            </div>
        </div>
    </div>-->

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <footer class='footer'>
                <p>Copyright <?php echo date('Y');?> @ <a href="http://www.baf.org" target="_blank">Bangladesh Air Force</a></p>
                <p><span>Developed by : <a href="#">Directorate of Air Intelligence</a></span></p>
            </footer>
        </div>
    </div>
</div>

<script src="js/jquery-1.12.4.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/validator.js"></script>
</body>
</html>
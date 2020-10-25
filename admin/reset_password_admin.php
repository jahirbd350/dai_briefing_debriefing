<?php
session_start();
$message = '';

if (!isset($_SESSION['user_id'])) {
    header('location: ../index.php');
}
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'logout') {
        require_once('../Login.php');
        $logout = new Login();
        $message = $logout->adminLogout();
        $_SESSION['message'] = $message;
    }
}

if (isset($_POST['btn_reset_password'])) {
    require_once('../Login.php');
    $register = new Login();
    $message = $register->userResetPassword($_POST);
}
include('header.php');
?>

<div class="container" style="margin-top: 60px">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="well">
                <h3 class="text-center text-danger">Change your Password!</h3>
                <hr/>
                <h4 class="text-center text-danger"><?php echo $message; ?></h4>
                <form class="form-horizontal" method="POST" action="" data-toggle="validator">
                    <div class="row">
                        <label class="col-md-4 control-label">Svc No</label>
                        <div class="col-md-8 form-group has-feedback">
                            <input type="text" class="form-control" name="bd_no" value="<?php echo $_SESSION['bd_no'].' ('.$_SESSION['name'].')'; ?>" disabled>
                        </div>

                        <label class="col-md-4 control-label">New Password</label>
                        <div class="col-md-8 form-group has-feedback">
                            <input type="password" id="password" data-minlength="4"
                                   data-error="Password minimum 4 character !" class="form-control"
                                   placeholder="Password" name="user_password" required>
                            <div class="help-block with-errors"></div>
                        </div>

                        <label class="col-md-4 control-label">Confirm New Password</label>
                        <div class="col-md-8 form-group has-feedback">
                            <input type="password" data-match="#password"
                                   data-error="Password and Confirm password does not match !" class="form-control"
                                   placeholder="Confirm Password" name="cf_user_password" required>
                            <div class="help-block with-errors"></div>
                        </div>

                        <label class="col-md-4 control-label"></label>
                        <div class="col-md-8 form-group">
                            <div class="">
                                <button type="submit" class="btn btn-success btn-block" name="btn_reset_password">Change your Password</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-sm-3"></div>
    </div>
</div>
</div>
<script src="../js/jquery-1.12.4.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/validator.js"></script>
</body>
</html>
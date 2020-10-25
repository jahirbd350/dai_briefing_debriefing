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
        //$_SESSION['message'] = $message;
    }
}

if (isset($_POST['btn_update_user_info'])){
    include_once '../Briefing.php';
    $briefing = new Briefing();
    $message = $briefing->updateUserData();
    //$_SESSION['message'] = $message;
    //header('Location: new_user.php');
}

if (isset($_POST['btn_insert_new_user'])){
    include_once '../Briefing.php';
    $briefing = new Briefing();
    $message = $briefing->insertUserData();
    //header('Location: new_user.php');
    $_SESSION['message'] = $message;
}

include('header.php');
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h4 class="text-center text-success bg-info">
            <?php if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
            };
            unset($_SESSION['message']);
            echo $message;
            ?>
        </h4>
        <div class="panel panel-default">
            <div class="panel-heading">Create/ Update Personnel Data</div>
            <div class="panel-body">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#1" data-toggle="tab">Update User Data</a>
                    </li>
                    <li><a href="#2" data-toggle="tab">Create User</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="1">
                        <h3 class="text-center text-primary">Search User Data</h3>
                        <div class="col-md-6 col-md-offset-3">
                            <form class="form" method="POST" action="" data-toggle="validator" role="form">
                                <div class="form-group row has-feedback">
                                    <input type="text" name="svc_no" class="form-control" pattern="^[0-9]{1,}$"
                                           data-pattern-error="Please provide only Character!" required placeholder="Enter Svc No" minlength="4" maxlength="6">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <button type="submit" class="btn btn-default" name="btnSearch">Search</button>
                            </form>
                        </div>
                        <div class="col-md-12">

                            <?php
                            if (isset($_POST['btnSearch'])) {
                                include_once '../Briefing.php';
                                $briefing = new Briefing();
                                $user = $briefing->selectIndividualUsers();

                            if (mysqli_num_rows($user) > 0) {
                                $userInfo = mysqli_fetch_assoc($user);
                                ?>
                                <form class="form" method="POST" action="" data-toggle="validator" role="form">
                                    <input type="hidden" name="type_of_visit" value="briefing">
                                    <div class="form-group row has-feedback">
                                        <label>1. Full Name</label>
                                        <input name="full_name" value="<?php echo $userInfo['name'] ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                               data-pattern-error="Special Character (&,$,# etc) not allowed"
                                               class="form-control"
                                               placeholder="Full Name">
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group row has-feedback">
                                        <label>2. Rank</label>
                                        <input name="rank" value="<?php echo $userInfo['rank'] ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                               data-pattern-error="Special Character (&,$,# etc) not allowed"
                                               class="form-control"
                                               placeholder="Rank">
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group row has-feedback">
                                        <label>3. Svc No</label>
                                        <input value="<?php echo $userInfo['bd_no'] ?>" pattern="^[0-9 ]{1,}$"
                                               data-pattern-error="Special Character (&,$,# etc) not allowed"
                                               class="form-control"
                                               placeholder="BD No" disabled>
                                        <input type="hidden" name="svc_no" value="<?php echo $userInfo['bd_no']; ?>">
                                    </div>

                                    <div class="form-group row has-feedback">
                                        <label>4. Branch/ Trade</label>
                                        <input name="br_trade" value="<?php echo $userInfo['br_trade'] ?>" pattern="^[_A-z0-9-.,() ]{1,}$"
                                               data-pattern-error="Special Character (&,$,# etc) not allowed"
                                               class="form-control"
                                               placeholder="Branch/ Trade">
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group row">
                                        <label>5. Date of Birth</label>
                                        <input type="date" value="<?php echo $userInfo['date_of_birth'] ?>" class="form-control" name="dob">
                                    </div>

                                    <div class="form-group row has-feedback">
                                        <label>6. Present Password</label>
                                        <input name="password" value="<?php echo $userInfo['password'] ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                               data-pattern-error="Special Character (&,$,# etc) not allowed"
                                               class="form-control"
                                               placeholder="Enter New PAssword">
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <button style="margin-left: 280px" type="submit" class="btn btn-success"
                                            name="btn_update_user_info">Update User Info
                                    </button>
                                </form>
                            <?php } else { ?>
                                <h3 class="text-center text-primary">No User found with the svc no!</h3>
                            <?php }}?>
                        </div>
                    </div>
                    <div class="tab-pane" id="2">
                        <h3 class="text-center text-primary">Create New User</h3>
                        <div class="col-md-12">
                            <form class="form2" method="POST" action="" data-toggle="validator" role="form">
                                <input type="hidden" name="type_of_visit" value="briefing">
                                <div class="form-group row has-feedback">
                                    <label>1. Full Name</label>
                                    <input name="full_name" pattern="^[_A-z0-9-., ]{1,}$"
                                           data-pattern-error="Special Character (&,$,# etc) not allowed"
                                           class="form-control"
                                           placeholder="Full Name" required>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group row has-feedback">
                                    <label>2. Rank</label>
                                    <input name="rank" pattern="^[_A-z0-9-., ]{1,}$"
                                           data-pattern-error="Special Character (&,$,# etc) not allowed"
                                           class="form-control"
                                           placeholder="Rank" required>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group row has-feedback">
                                    <label>3. BD/No</label>
                                    <input name="svc_no" pattern="^[0-9 ]{1,}$"
                                           data-pattern-error="Special Character (&,$,# etc) not allowed"
                                           class="form-control"
                                           placeholder="BD No" required minlength="4">
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group row has-feedback">
                                    <label>4. Branch/Trade</label>
                                    <input name="br_trade" pattern="^[_A-z0-9-., ]{1,}$"
                                           data-pattern-error="Special Character (&,$,# etc) not allowed"
                                           class="form-control"
                                           placeholder="Branch/ Trade" required>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group row">
                                    <label>5. Date of Birth</label>
                                    <input type="date" class="form-control" name="dob" required>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <button style="margin-left: 280px" type="submit" class="btn btn-success"
                                        name="btn_insert_new_user">Create new User
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="../js/jquery-1.12.4.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/validator.js"></script>
</body>
</html>
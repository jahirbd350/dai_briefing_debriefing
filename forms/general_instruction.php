<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location: index.php');
}
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'logout') {
        require_once('Login.php');
        $logout = new Login();
        $message = $logout->adminLogout();
        $_SESSION['message'] = $message;
    }
}
$message = '';
if (isset($_POST['btn-submit'])) {
    header('Location: homepage.php');
}
include 'f_header.php';

include '../Briefing.php';
$gen_inst = new Briefing();
$gen_inst_info = $gen_inst->updateGenInst();

?>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="well">
                <h4 class="text-center text-danger bg-info"><?php echo $message; ?></h4>
                <h5 class="text-center">CONFIDENTIAL</h5>
                <h5 class="text-right"><u>ANNEX 'A' TO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></h5>
                <h5 class="text-right"><u>INT BRIEF &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></h5>
                <h5 class="text-right"><u>DATED : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></h5>
                <p style="font-family: Arial; font-size: 22px" class="text-center text-default"><b><u>GENERAL INSTRUCTION FOR BAF PERSONNEL WHILE PROCEEDING ABROAD</u></b></p></br>
                <h5><b>1. &nbsp;&nbsp;&nbsp;&nbsp; The following general instruction are to be followed by BAF personnel during their stay abroad:</b></h5>
                <div class="form-group">
                    <?php while ($gen_inst_info2 = mysqli_fetch_assoc($gen_inst_info)) {?>
                        <textarea class="form-control" name="gen_inst" id="" rows="25" readonly><?php echo $gen_inst_info2['gen_inst']?>
                </textarea>
                        <input type="hidden" name="id" value="<?php $gen_inst_info2['id']; ?>">
                    <?php } ?>
                </div>
                <h5 class="text-center">CONFIDENTIAL</h5>
                <form class="form" method="POST" action="" data-toggle="validator">
                    <div class="form-group row">
                        <h5 class="text-center text-warning">
                            <input type="checkbox" name="terms" required>
                            <b><i>
                                    * I have read and understood AFO 200-2 dated 22 Apr 1990, AFO 113-13 dated 12 March 1996 and
                                    <br>
                                    above mentioned instructions & will comply with these. Any violation of this order will render me
                                    <br>
                                    liable to disciplinary action. I am also aware of the points for debrief. </i></b>
                        </h5>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success" name="btn-submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="../js/jquery-1.12.4.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/validator.js"></script>
</body>
</html>
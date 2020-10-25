<?php
include 'header_super_admin.php';

require_once '../Briefing.php';
$gen_inst = new Briefing();
$gen_inst_info = $gen_inst->updateGenInst();

if(isset($_POST['btn-update-gen-inst'])){
    $briefing = new Briefing();
    $message = $briefing->updateGenInstData();
    header('Location: update_gen_instruction.php');
}
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
                <form class="form" method="POST" action="" data-toggle="validator">
                    <h5><b>1. &nbsp;&nbsp;&nbsp;&nbsp; The following general instruction are to be followed by BAF personnel during their stay abroad:</b></h5>
                    <div class="form-group">
                        <?php while ($gen_inst_info2 = mysqli_fetch_assoc($gen_inst_info)) {?>
                        <textarea class="form-control" name="gen_inst" id="" rows="25"><?php echo $gen_inst_info2['gen_inst']?>
                        </textarea>
                        <input type="hidden" name="id" value="<?php $gen_inst_info2['id']; ?>">
                        <?php } ?>
                    </div>
                    <h5 class="text-center">CONFIDENTIAL</h5>
                    <div class="form-group row">
                        <div class="text-center">
                            <button type="submit" class="btn btn-success" name="btn-update-gen-inst">Update</button>
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
<?php
include 'header_super_admin.php';

require_once('../Briefing.php');
$briefing = new Briefing();
$deBriefTraining = $briefing->viewDeBriefTrainingHistory();

//Pagination code start here
$limit = isset($_POST["limit-records"]) ? $_POST["limit-records"] : 50;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;
$briefing = new Briefing();
$deBriefTrainingPagination = $briefing->deBriefTrainingPagination($limit,$start);

$totalRecord = mysqli_num_rows($deBriefTraining);
$pages = ceil( $totalRecord / $limit );

$Previous = $page - 1;
$Next = $page + 1;
//Pagination code end here

?>

    <div class="row">
        <div class="col-md-12">
            <div class="well">
                <h3 class="text-center text-primary">De-Briefing Training History</h3>
                <table class="table table-hover table-striped table-bordered">
                    <tr>
                        <th class="text-center">Ser No</th>
                        <th class="text-center">BD No</th>
                        <th class="text-center">Rank</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Br/Trade</th>
                        <th class="text-center">Forms</th>
                        <th class="text-center">Action</th>
                    </tr>
                    <?php $serial_number = $start+1;
                    while ($deBriefTrainingList = mysqli_fetch_assoc($deBriefTrainingPagination)) { ?>
                        <tr>
                            <td class="text-center"><?php echo $serial_number++; ?></td>
                            <td class="text-center"><?php echo $deBriefTrainingList['bd_no']; ?></td>
                            <?php
                                $data = $briefing->viewPersonalData($deBriefTrainingList['bd_no']);
                                $personalData = mysqli_fetch_assoc($data);
                            ?>
                            <td class="text-center"><?php echo $personalData['rank']; ?></td>
                            <td class="text-center"><?php echo $personalData['name']; ?></td>
                            <td class="text-center"><?php echo $personalData['br_trade']; ?></td>
                            <td class="text-center">
                                <a href="../pdf_generator_files/generate_f_20389_pdf.php?bd_no=<?php echo $deBriefTrainingList['bd_no']; ?>&&visit_info_id=<?php echo $deBriefTrainingList['visit_info_id']; ?>"
                                   target="_blank" class="btn btn-primary">View F-20389 </a>
                                <a href="../pdf_generator_files/generate_f_20386_pdf_with_20389.php?bd_no=<?php echo $deBriefTrainingList['bd_no']; ?>&&visit_info_id=<?php echo $deBriefTrainingList['visit_info_id']; ?>"
                                   target="_blank" class="btn btn-primary">View F-20386 </a>
                                <!--<a href="?id=<?php /*echo $briefingInfo['user_id'];*/ ?>&deletestatus=delete" class="btn btn-danger">Delete </a>-->
                            </td>
                            <td class="text-center">
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination Code Start here -->
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-8 col-md-offset-2">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li>
                            <?php if ($page > 1) { ?>
                                <a href="../super_admin/history_debrief_training_super_admin.php?page=<?php echo $Previous; ?>">&laquo; Previous</a>
                            <?php } ?>
                        </li>
                        <li>
                            <a href="../super_admin/history_debrief_training_super_admin.php?page=1">First Page</a>
                        </li>
                        <li>
                            <?php for ($i = 1; $i <= $pages; $i++) { ?>
                                <a href="../super_admin/history_debrief_training_super_admin.php?page=<?php echo $i; ?>"><?php echo '<b>' . $i . '</b>'; ?></a>
                            <?php } ?>
                        </li>
                        <li>
                            <a href="../super_admin/history_debrief_training_super_admin.php?page=<?php echo $pages; ?>">Last Page</a>
                        </li>
                        <li>
                            <?php if ($page < $pages) { ?>
                                <a href="../super_admin/history_debrief_training_super_admin.php?page=<?php echo $Next; ?>">Next &raquo;</a>
                            <?php } ?>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <!-- Pagination Code End here -->
</div>
<script src="../js/jquery-1.12.4.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/validator.js"></script>
</body>
</html>

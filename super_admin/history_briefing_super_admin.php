<?php
include 'header_super_admin.php';

require_once('../Briefing.php');
$briefing = new Briefing();
$briefingInfo = $briefing->viewBriefingHistory();

//Pagination code start here
$limit = isset($_POST["limit-records"]) ? $_POST["limit-records"] : 50;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;
$briefing = new Briefing();
$briefingPagination = $briefing->briefingPagination($limit,$start);


$totalRecord = mysqli_num_rows($briefingInfo);
$pages = ceil( $totalRecord / $limit );

$Previous = $page - 1;
$Next = $page + 1;
//Pagination code end here

?>

    <div class="row">
        <div class="col-md-12">
            <div class="well">
                <h3 class="text-center text-primary">Briefing History</h3>
                <table class="table table-hover table-striped table-bordered">
                    <tr>
                        <th class="text-center">Ser No</th>
                        <th class="text-center">BD No</th>
                        <th class="text-center">Rank</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Br/Trade</th>
                        <th class="text-center">Ex BD Lv</th>
                        <th class="text-center">Forms</th>
                        <th class="text-center">Action</th>
                    </tr>
                    <?php $serial_number = $start+1;
                    while ($briefingList = mysqli_fetch_assoc($briefingPagination)) { ?>
                        <tr>
                            <td class="text-center"><?php echo $serial_number++; ?></td>
                            <td class="text-center"><?php echo $briefingList['bd_no']; ?></td>
                            <?php
                                $data = $briefing->viewPersonalData($briefingList['bd_no']);
                                $personalData = mysqli_fetch_assoc($data);
                            ?>
                            <td class="text-center"><?php echo $personalData['rank']; ?></td>
                            <td class="text-center"><?php echo $personalData['name']; ?></td>
                            <td class="text-center"><?php echo $personalData['br_trade']; ?></td>
                            <td class="text-center">
                                <?php
                                $lv_start_dt = $briefingList['ex_bd_lv_start'];
                                $lv_finish_dt = $briefingList['ex_bd_lv_finish'];

                                if($lv_start_dt != '1970-01-01' OR $lv_finish_dt != '1970-01-01'){
                                    $lv_start_dt = date('d-M-y', strtotime($briefingList['ex_bd_lv_start']));
                                    $lv_finish_dt = date('d-M-y', strtotime($briefingList['ex_bd_lv_finish']));
                                }else{
                                    $lv_start_dt='';
                                    $lv_finish_dt='';
                                }
                                echo 'Start : '.'<br>'.$lv_start_dt.'<br>';
                                echo 'Finish : '.'<br>'.$lv_finish_dt.'<br>';
                                if($briefingList['ex_bd_lv_doc'] != '') { ?>
                                    <label for="">Uploaded Doc : </label>
                                    <a href="../forms/ex_bd_lv_docs/<?php echo $briefingList['ex_bd_lv_doc'] ?>" target="_blank">Download</a>
                                <?php } else { ?>
                                    <label for="">No Doc Uploaded!</label>
                                <?php } ?>
                            </td>
                            <td class="text-center">
                                <a href="../pdf_generator_files/generate_f_20387_pdf.php?bd_no=<?php echo $briefingList['bd_no']; ?>&&visit_info_id=<?php echo $briefingList['visit_info_id']; ?>"
                                   target="_blank" class="btn btn-primary">View F-20387 </a>
                                <a href="../pdf_generator_files/generate_f_20385_pdf.php?bd_no=<?php echo $briefingList['bd_no']; ?>&&visit_info_id=<?php echo $briefingList['visit_info_id']; ?>"
                                   target="_blank" class="btn btn-primary">View F-20385 </a>
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
                                <a href="../super_admin/history_briefing_super_admin.php?page=<?php echo $Previous; ?>">&laquo; Previous</a>
                            <?php } ?>
                        </li>
                        <li>
                            <a href="../super_admin/history_briefing_super_admin.php?page=1">First Page</a>
                        </li>
                        <li>
                            <?php for ($i = 1; $i <= $pages; $i++) { ?>
                                <a href="../super_admin/history_briefing_super_admin.php?page=<?php echo $i; ?>"><?php echo '<b>' . $i . '</b>'; ?></a>
                            <?php } ?>
                        </li>
                        <li>
                            <a href="../super_admin/history_briefing_super_admin.php?page=<?php echo $pages; ?>">Last Page</a>
                        </li>
                        <li>
                            <?php if ($page < $pages) { ?>
                                <a href="../super_admin/history_briefing_super_admin.php?page=<?php echo $Next; ?>">Next &raquo;</a>
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
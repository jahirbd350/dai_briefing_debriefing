<?php
session_start();

include_once('../../config.php');

if (isset($_POST["lost_ser_no"])) {
    $lost_ser_no = $_POST["lost_ser_no"];
    $lost_type_of_docu = $_POST["lost_type_of_docu"];
    $lost_place = $_POST["lost_place"];
    $lost_remarks = $_POST["lost_remarks"];
    $query = '';
    for ($count = 0; $count < count($lost_ser_no); $count++) {
        $lost_ser_no_clean = mysqli_real_escape_string($link, $lost_ser_no[$count]);
        $lost_type_of_docu_clean = mysqli_real_escape_string($link, $lost_type_of_docu[$count]);
        $lost_place_clean = mysqli_real_escape_string($link, $lost_place[$count]);
        $lost_remarks_clean = mysqli_real_escape_string($link, $lost_remarks[$count]);
        if ($lost_ser_no_clean != '') {
            $query .= '
       INSERT INTO debrief_20389_lose_service_property(bd_no,visit_info_id,ser_no, type_of_docu, place_of_lost, remarks) 
       VALUES("' . $_SESSION['bd_no'] . '","' . $_SESSION['visitId'] . '","' . $lost_ser_no_clean . '", "' . $lost_type_of_docu_clean . '", "' . $lost_place_clean . '", "' . $lost_remarks_clean . '"); 
       ';
        }
    }

    if ($query != '') {
        if (mysqli_multi_query($link, $query)) {
            //echo 'Transit Info Inserted Successfully';
        } else {
            echo 'Error';
        }
    } else {
        echo 'Transit Info All Fields are Required';
    }
}

?>
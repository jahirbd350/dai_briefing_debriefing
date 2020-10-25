<?php
session_start();

include_once('../../config.php');

if (isset($_POST["mil_site_ser_no"])) {
    $mil_site_ser_no = $_POST["mil_site_ser_no"];
    $mil_site_place = $_POST["mil_site_place"];
    $mil_site_importance = $_POST["mil_site_importance"];
    $query = '';
    for ($count = 0; $count < count($mil_site_ser_no); $count++) {
        $mil_site_ser_no_clean = mysqli_real_escape_string($link, $mil_site_ser_no[$count]);
        $mil_site_place_clean = mysqli_real_escape_string($link, $mil_site_place[$count]);
        $mil_site_importance_clean = mysqli_real_escape_string($link, $mil_site_importance[$count]);
        if ($mil_site_ser_no_clean != '') {
            $query .= '
       INSERT INTO debrief_20389_military_site_visited(bd_no,visit_info_id,ser_no, place, importance) 
       VALUES("' . $_SESSION['bd_no'] . '","' . $_SESSION['visitId'] . '","' . $mil_site_ser_no_clean . '", "' . $mil_site_place_clean . '", "' . $mil_site_importance_clean . '"); 
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
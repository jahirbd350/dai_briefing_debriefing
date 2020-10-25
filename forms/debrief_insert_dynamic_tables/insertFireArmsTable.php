<?php
session_start();

include_once('../../config.php');

if (isset($_POST["arms_ser_no"])) {
    $arms_ser_no = $_POST["arms_ser_no"];
    $arms_type = $_POST["arms_type"];
    $arms_price = $_POST["arms_price"];
    $arms_permission = $_POST["arms_permission"];
    $arms_remarks = $_POST["arms_remarks"];
    $query = '';
    for ($count = 0; $count < count($arms_ser_no); $count++) {
        $arms_ser_no_clean = mysqli_real_escape_string($link, $arms_ser_no[$count]);
        $arms_type_clean = mysqli_real_escape_string($link, $arms_type[$count]);
        $arms_price_clean = mysqli_real_escape_string($link, $arms_price[$count]);
        $arms_permission_clean = mysqli_real_escape_string($link, $arms_permission[$count]);
        $arms_remarks_clean = mysqli_real_escape_string($link, $arms_remarks[$count]);
        if ($arms_ser_no_clean != '') {
            $query .= '
       INSERT INTO debrief_20389_fire_arms(bd_no,visit_info_id,ser_no, type_of_arm, price, permission_taken_from, remarks) 
       VALUES("' . $_SESSION['bd_no'] . '","' . $_SESSION['visitId'] . '","' . $arms_ser_no_clean . '", "' . $arms_type_clean . '", "' . $arms_price_clean . '", "' . $arms_permission_clean . '", "' . $arms_remarks_clean . '"); 
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
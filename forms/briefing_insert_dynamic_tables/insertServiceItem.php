<?php
session_start();

include_once('../../config.php');

if (isset($_POST["service_item_ser_no"])) {
    $service_item_ser_no = $_POST["service_item_ser_no"];
    $service_item_details = $_POST["service_item_details"];
    $query = '';
    for ($count = 0; $count < count($service_item_ser_no); $count++) {
        $service_item_ser_no_clean = mysqli_real_escape_string($link, $service_item_ser_no[$count]);
        $service_item_details_clean = mysqli_real_escape_string($link, $service_item_details[$count]);
        if ($service_item_ser_no_clean != '' && $service_item_details_clean != '') {
            $query .= '
       INSERT INTO briefing_20387_service_item_info(bd_no,visit_info_id,ser_no,details) 
       VALUES("' . $_SESSION['bd_no'] . '","' . $_SESSION['visitId'] . '","' . $service_item_ser_no_clean . '", "' . $service_item_details_clean . '"); 
       ';
        }
    }

    if ($query != '') {
        if (mysqli_multi_query($link, $query)) {
            echo 'Service Item Info Inserted Successfully';
        } else {
            echo 'Error' . mysqli_error($link);
        }
    } else {
        echo 'Service Item Info All Fields are Required';
    }
}

?>
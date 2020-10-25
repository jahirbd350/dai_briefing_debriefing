<?php
session_start();

include_once('../../config.php');

if (isset($_POST["kind_foreigner_ser_no"])) {
    $kind_foreigner_ser_no = $_POST["kind_foreigner_ser_no"];
    $kind_foreigner_name_address = $_POST["kind_foreigner_name_address"];
    $kind_foreigner_occupation = $_POST["kind_foreigner_occupation"];
    $kind_foreigner_remarks = $_POST["kind_foreigner_remarks"];
    $query = '';
    for ($count = 0; $count < count($kind_foreigner_ser_no); $count++) {
        $kind_foreigner_ser_no_clean = mysqli_real_escape_string($link, $kind_foreigner_ser_no[$count]);
        $kind_foreigner_name_address_clean = mysqli_real_escape_string($link, $kind_foreigner_name_address[$count]);
        $kind_foreigner_occupation_clean = mysqli_real_escape_string($link, $kind_foreigner_occupation[$count]);
        $kind_foreigner_remarks_clean = mysqli_real_escape_string($link, $kind_foreigner_remarks[$count]);
        if ($kind_foreigner_ser_no_clean != '') {
            $query .= '
       INSERT INTO debrief_20389_help_by_foreigner(bd_no,visit_info_id,ser_no, name_address, occupation, remarks) 
       VALUES("' . $_SESSION['bd_no'] . '","' . $_SESSION['visitId'] . '","' . $kind_foreigner_ser_no_clean . '", "' . $kind_foreigner_name_address_clean . '", "' . $kind_foreigner_occupation_clean . '", "' . $kind_foreigner_remarks_clean . '"); 
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
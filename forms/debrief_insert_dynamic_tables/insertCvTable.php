<?php
session_start();

include_once('../../config.php');

if (isset($_POST["cv_ser_no"])) {
    $cv_ser_no = $_POST["cv_ser_no"];
    $cv_name_of_institution = $_POST["cv_name_of_institution"];
    $cv_remarks = $_POST["cv_remarks"];
    $query = '';
    for ($count = 0; $count < count($cv_ser_no); $count++) {
        $cv_ser_no_clean = mysqli_real_escape_string($link, $cv_ser_no[$count]);
        $cv_name_of_institution_clean = mysqli_real_escape_string($link, $cv_name_of_institution[$count]);
        $cv_remarks_clean = mysqli_real_escape_string($link, $cv_remarks[$count]);
        if ($cv_ser_no_clean != '') {
            $query .= '
       INSERT INTO debrief_20389_institution(bd_no,visit_info_id,ser_no, name_of_institution, remarks) 
       VALUES("' . $_SESSION['bd_no'] . '","' . $_SESSION['visitId'] . '","' . $cv_ser_no_clean . '", "' . $cv_name_of_institution_clean . '", "' . $cv_remarks_clean . '"); 
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
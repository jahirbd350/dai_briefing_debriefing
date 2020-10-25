<?php
session_start();

include_once('../../config.php');

if (isset($_POST["meeting_ser_no"])) {
    $meeting_ser_no = $_POST["meeting_ser_no"];
    $meeting_particulars = $_POST["meeting_particulars"];
    $meeting_appointment = $_POST["meeting_appointment"];
    $meeting_purpose = $_POST["meeting_purpose"];
    $query = '';
    for ($count = 0; $count < count($meeting_ser_no); $count++) {
        $meeting_ser_no_clean = mysqli_real_escape_string($link, $meeting_ser_no[$count]);
        $meeting_particulars_clean = mysqli_real_escape_string($link, $meeting_particulars[$count]);
        $meeting_appointment_clean = mysqli_real_escape_string($link, $meeting_appointment[$count]);
        $meeting_purpose_clean = mysqli_real_escape_string($link, $meeting_purpose[$count]);
        if ($meeting_ser_no_clean != '') {
            $query .= '
       INSERT INTO debrief_20388_meeting(bd_no,visit_info_id,ser_no, particulars, appointment, purpose_of_meeting) 
       VALUES("' . $_SESSION['bd_no'] . '","' . $_SESSION['visitId'] . '","' . $meeting_ser_no_clean . '", "' . $meeting_particulars_clean . '", "' . $meeting_appointment_clean . '", "' . $meeting_purpose_clean . '"); 
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
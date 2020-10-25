<?php
session_start();

include_once('../../config.php');

if (isset($_POST["foreign_student_ser_no"])) {
    $foreign_student_ser_no = $_POST["foreign_student_ser_no"];
    $foreign_student_nationality = $_POST["foreign_student_nationality"];
    $foreign_student_ranks_particulars = $_POST["foreign_student_ranks_particulars"];
    $foreign_student_remarks = $_POST["foreign_student_remarks"];
    $query = '';
    for ($count = 0; $count < count($foreign_student_ser_no); $count++) {
        $foreign_student_ser_no_clean = mysqli_real_escape_string($link, $foreign_student_ser_no[$count]);
        $foreign_student_nationality_clean = mysqli_real_escape_string($link, $foreign_student_nationality[$count]);
        $foreign_student_ranks_particulars_clean = mysqli_real_escape_string($link, $foreign_student_ranks_particulars[$count]);
        $foreign_student_remarks_clean = mysqli_real_escape_string($link, $foreign_student_remarks[$count]);
        if ($foreign_student_ser_no_clean != '') {
            $query .= '
       INSERT INTO debrief_20389_summary_of_students(bd_no,visit_info_id,ser_no, nationality, ranks_particulars, remarks) 
       VALUES("' . $_SESSION['bd_no'] . '","' . $_SESSION['visitId'] . '","' . $foreign_student_ser_no_clean . '", "' . $foreign_student_nationality_clean . '", "' . $foreign_student_ranks_particulars_clean . '", "' . $foreign_student_remarks_clean . '"); 
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
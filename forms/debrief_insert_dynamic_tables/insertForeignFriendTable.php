<?php
session_start();

include_once('../../config.php');

if (isset($_POST["foreign_friends_ser_no"])) {
    $foreign_friends_ser_no = $_POST["foreign_friends_ser_no"];
    $foreign_friends_name_address = $_POST["foreign_friends_name_address"];
    $foreign_friends_occupation = $_POST["foreign_friends_occupation"];
    $foreign_friends_remarks = $_POST["foreign_friends_remarks"];
    $query = '';
    for ($count = 0; $count < count($foreign_friends_ser_no); $count++) {
        $foreign_friends_ser_no_clean = mysqli_real_escape_string($link, $foreign_friends_ser_no[$count]);
        $foreign_friends_name_address_clean = mysqli_real_escape_string($link, $foreign_friends_name_address[$count]);
        $foreign_friends_occupation_clean = mysqli_real_escape_string($link, $foreign_friends_occupation[$count]);
        $foreign_friends_remarks_clean = mysqli_real_escape_string($link, $foreign_friends_remarks[$count]);
        if ($foreign_friends_ser_no_clean != '') {
            $query .= '
       INSERT INTO debrief_20389_friends_in_abroad(bd_no,visit_info_id,ser_no, name_address, occupation, remarks) 
       VALUES("' . $_SESSION['bd_no'] . '","' . $_SESSION['visitId'] . '","' . $foreign_friends_ser_no_clean . '", "' . $foreign_friends_name_address_clean . '", "' . $foreign_friends_occupation_clean . '", "' . $foreign_friends_remarks_clean . '"); 
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
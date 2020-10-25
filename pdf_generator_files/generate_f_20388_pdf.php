<?php
//include connection file
include_once("../config.php");
include_once('libs/fpdfphp');
$bd_no = $_GET['bd_no'];
$visit_id = $_GET['visit_info_id'];

class PDF extends FPDF
{
// Page header
    function Header()
    {
        // Logo
        //$this->Image('logo.png',10,-1,70);

        $this->SetY(15);

        $this->SetFont('Arial', '', 12);
        // Title
        $this->Ln(1);
        $this->Cell(0, 0, 'CONFIDENTIAL', 0, 0, 'C');
    }

// Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-25);
        // Arial italic 8
        $this->SetFont('Arial', '', 12);
        // Page number
        $this->Cell(0, 10, $this->PageNo(), 0, 0, 'C');
        $this->Ln(0);
        $this->Cell(0, 20, 'CONFIDENTIAL', 0, 0, 'C');
    }
}

$personelInfo = mysqli_query($link, "SELECT * FROM new_users WHERE bd_no='$bd_no'") or die("database error:" . mysqli_error($link));
$personelInfo = mysqli_fetch_assoc($personelInfo);

$visitInfo = mysqli_query($link, "SELECT * FROM debrief_20388_visit_info WHERE bd_no='$bd_no'&&visit_info_id='$visit_id'") or die("database error:" . mysqli_error($link));
$visitInfo = mysqli_fetch_assoc($visitInfo);

$transitInfo = mysqli_query($link, "SELECT ser_no,country,duration,purpose FROM debrief_20388_transit_info WHERE bd_no='$bd_no'&&visit_info_id='$visit_id'") or die("database error:" . mysqli_error($link));

$lostSvcItem = mysqli_query($link, "SELECT ser_no,type_of_docu,place_of_lost,remarks FROM debrief_20388_lose_service_property WHERE bd_no='$bd_no'&&visit_info_id='$visit_id'") or die("database error:" . mysqli_error($link));

$milSiteInfo = mysqli_query($link, "SELECT ser_no,place,importance FROM debrief_20388_military_site_visited WHERE bd_no='$bd_no'&&visit_info_id='$visit_id'") or die("database error:" . mysqli_error($link));

$milMeetInfo = mysqli_query($link, "SELECT ser_no,particulars,appointment,purpose_of_meeting FROM debrief_20388_meeting WHERE bd_no='$bd_no'&&visit_info_id='$visit_id'") or die("database error:" . mysqli_error($link));

$clubMemberInfo = mysqli_query($link, "SELECT ser_no,name_of_club,remarks FROM debrief_20388_club_membership WHERE bd_no='$bd_no'&&visit_info_id='$visit_id'") or die("database error:" . mysqli_error($link));

$giftInfo = mysqli_query($link, "SELECT ser_no,details_of_gift_received,gift_date,approx_value,dignitary_name,remarks FROM debrief_20388_gift WHERE bd_no='$bd_no'&&visit_info_id='$visit_id'") or die("database error:" . mysqli_error($link));

$armsInfo = mysqli_query($link, "SELECT ser_no,type_of_arm,price,permission_taken_from,remarks FROM debrief_20388_fire_arms WHERE bd_no='$bd_no'&&visit_info_id='$visit_id'") or die("database error:" . mysqli_error($link));

$pdf = new PDF('P', 'mm', 'A4');
//header
$pdf->AddPage();
//foter page
$pdf->AliasNbPages();
$pdf->SetFont('Arial', '', 12);
$pdf->SetMargins(20, 0, 20);
$pdf->Ln(1);
$pdf->Cell(0, 10, '(When filled in)', 0, 0, 'C');
$pdf->Ln(0);
$pdf->Cell(180, 10, 'F-20388', 0, 0, 'R');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'BU', 12);
$pdf->Cell(0, 25, 'DIRECTORATE OF AIR INTELLIGENCE', 0, 0, 'C');
$pdf->Ln(1);
$pdf->Cell(0, 32, 'INTELLIGENCE DE-BRIEFING ON RETURN FROM VISIT/UN MISSION ABROAD', 0, 0, 'C');
$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(0, 45, '(This form is prepared in accordance with AFO 200-2 dated 22 April 1990.  Following  info  are  to', 0, 0, '');
$pdf->Ln(1);
$pdf->Cell(0, 55, 'be  furnished  by  all  BAF  personnel   returning   from   abroad.   You   may   add   extra   papers,', 0, 0, '');
$pdf->Ln(1);
$pdf->Cell(0, 65, 'documents, photos and maps to furnish your report.)', 0, 0, '');
// Line break
$pdf->Ln(1);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(25, 80, '1.    Name:', '', '');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 80, $personelInfo['name'].'                                                                                                     ');
$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 80, '                  ___________________________________________________________________');
$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(40, 80, '2.    Rank:');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(75, 80, $personelInfo['rank'].'                                                                    ');

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(25, 80, '3.    BD No:');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(20, 80, $personelInfo['bd_no'].'                ');
$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 80, '                 _______________________________________                       _________________');

$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(40, 100, '4.    Branch/Trade:');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(75, 100, $personelInfo['br_trade'].'                                                   ');

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(25, 100, '5.    Unit:');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(20, 100, $visitInfo['unit'].'                  ');
$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 100, '                              _________________________________                  ___________________');

$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(40, 120, '6.    Purpose of visit:');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(20, 120, $visitInfo['visit_purpose'].'                                                                                                  ');
$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 120, '                                  ___________________________________________________________');
$pdf->Ln(0);

$pdf->Cell(20, 120);
$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(80, 140, '7.    Total duration of stay abroad : From ');
$pdf->SetFont('Arial', 'B', 12);
$fromDate = date('d M y',strtotime($visitInfo['duration_of_stay_from']));
$pdf->Cell(25, 140, $fromDate.'         ');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(20, 140, '        To ');
$pdf->SetFont('Arial', 'B', 12);
$toDate = date('d M y',strtotime($visitInfo['duration_of_stay_to']));
$pdf->Cell(20, 140, $toDate.'                      ');
$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 140, '                                                                 _______________         ________________________');

$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 160, '8.    Destination Country: ');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(20, 160, $visitInfo['destination_country'].'                                                                                        ');
$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 160, '                                        ________________________________________________________');


//Transit Table Data
$pdf->Ln(90);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(120, 0, '9.    Transit country/countries(other than ser no 8):');

//Transit Table Data Start
$pdf->SetFont('Arial', 'B', 12);
$pdf->Ln(5);
$pdf->SetFillColor(240, 240, 240);
$pdf->Cell(10, 5, '', 0, 0);
$pdf->Cell(15, 5, 'Ser', 1, 0, 'C', 'true');
$pdf->Cell(50, 5, 'Country', 1, 0, 'C', 'true');
$pdf->Cell(50, 5, 'Duration', 1, 0, 'C', 'true');//end of line
$pdf->Cell(55, 5, 'Purpose', 1, 1, 'C', 'true');//end of line

while ($item = mysqli_fetch_assoc($transitInfo)) {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(10, 5, '', 0, 0);
    $pdf->Cell(15, 5, $item['ser_no'], 1, 0, 'C');
    $pdf->Cell(50, 5, $item['country'], 1, 0, '');
    $pdf->Cell(50, 5, $item['duration'], 1, 0, '');//end of line
    $pdf->Cell(55, 5, $item['purpose'], 1, 1, '');//end of line
}
// Transit Table Data End

//$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 20, '10.    Details of Visit:');
$pdf->Ln(0);
$pdf->Cell(150, 35, '         a.    Name of the local agency/company/institute sponsoring the visit (If applicable):');

$pdf->Ln(0);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Ln(20);
$pdf->Cell(19, 10, '');
$pdf->MultiCell(160, 5, $visitInfo['name_of_sponsor']);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(160, -3, '                ___________________________________________________________________','','1');
$pdf->Cell(160, 15, '                ___________________________________________________________________');

$pdf->Ln(15);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, 5, '         b.    Name and address of the foreign company/institution/agency sponsoring the visit:');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(19, 10, '');
$pdf->MultiCell(160, 5, $visitInfo['name_address_of_foreign_company']);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(160, -3, '                ___________________________________________________________________','','1');
$pdf->Cell(160, 15, '                ___________________________________________________________________');

$pdf->Ln(15);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, 0, '         c.    Your observation and comments about the visit for future implications:');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(19, 0, '');
$pdf->MultiCell(160, 5, $visitInfo['observation_for_future']);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(160, -3, '                ___________________________________________________________________','','1');
$pdf->Cell(160, 15, '                ___________________________________________________________________');

$pdf->Ln(15);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 0, '11.    Amount of money received from bangladesh Govt. in foreign currency:');
$pdf->Ln(0);
$pdf->Cell(45, 15, '         a.    Daily Rate:');
$pdf->SetFont('Arial', 'B', 12);

$pdf->Cell(60, 15, $visitInfo['daily_rate']);
$pdf->SetFont('Arial', '', 12);

$pdf->Cell(25, 15, 'b.    Total:');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 15, $visitInfo['total_amount']);
$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(160, 15, '                                  ___________________________                  ______________________');

$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetFont('Arial', '', 12);

$pdf->Ln(0);
$pdf->Cell(80, 20, '12.    Facilities provided by the visiting country/agency/company/institution:');
$pdf->Ln(10);
$pdf->Cell(157, 20, '         a.    Were you given any cash by the host? If yes, state reasons and amount:');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Ln(13);
$pdf->Cell(19, 0, '');
$pdf->MultiCell(160, 5, $visitInfo['cash_by_host']);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(160, -3, '                ___________________________________________________________________','','1');
$pdf->Cell(160, 15, '                ___________________________________________________________________');

$pdf->Ln(5);
$pdf->SetFont('Arial', '', 12);

$pdf->Cell(90, 20, '         b.    Was food & accommodation free?');
$pdf->SetFont('Arial', 'B', 12);

$pdf->Cell(0, 20, $visitInfo['food_accommodation']);
$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(82, 20, '');
$pdf->Cell(0, 20, '________________________________________');

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(70, 20, '         c.    Was transportation free?');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 20, $visitInfo['transportation']);
$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(65, 20, '');
$pdf->Cell(0, 20, '_______________________________________________');

$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(120, 40, '13.    Foreign currency carried at your own arrangement :');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 40, $visitInfo['own_currency']);
$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(108, 40, '');
$pdf->Cell(0, 40, '_____________________________');

$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(165, 60, '14.    Did you lose any of your personal items or money during your stay or on the way?');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Ln(35);
$pdf->Cell(11, 0, '');
$pdf->MultiCell(160, 0, $visitInfo['lose_personnel_item']);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, 0, '         ______________________________________________________________________','','1');
$pdf->Cell(150, 12, '         ______________________________________________________________________');

$pdf->Ln(17);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(120, 0, '15.    Have you cleared all bills from all concerned against you?');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 0, $visitInfo['bill_cleared']);
$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(118, 0, '');
$pdf->Cell(0, 0, '________________________');

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 0, '16.    Have you made any financial transaction with any foreigner or Bangladeshi national');
$pdf->Ln(0);
$pdf->Cell(70, 10, '         residing there? If yes, give details ');
$pdf->Ln(0);
$pdf->Cell(12, 20, '');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Ln(8);
$pdf->Cell(11, 0, '');
$pdf->MultiCell(167, 5, $visitInfo['financial_transaction']);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, -3, '         ______________________________________________________________________','','1');
$pdf->Cell(150, 15, '         ______________________________________________________________________');

$pdf->Ln(20);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(130, 0, '17.    Total amount of foreign currency brought back to Bangladesh:');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 0, $visitInfo['currency_back']);
$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(127, 0, '');
$pdf->Cell(0, 0, '_____________________');

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(200, 0, '18.    Do you know if  any of your fellow members made friendship or any agreement with any');
$pdf->Ln(5);
$pdf->Cell(40, 0, '         If yes, give details');
$pdf->Ln(0);
$pdf->Cell(12, 10, '');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Ln(3);
$pdf->Cell(11, 0, '');
$pdf->MultiCell(167, 5, $visitInfo['fellow_member']);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, -3, '         ______________________________________________________________________','','1');
$pdf->Cell(150, 15, '         ______________________________________________________________________');

$pdf->Ln(15);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, 0, '19.    Have you discussed any classified information with any foreigner? If yes, give details');
$pdf->Ln(0);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(12, 10, '');
$pdf->Ln(3);
$pdf->Cell(11, 0, '');
$pdf->MultiCell(167, 5, $visitInfo['classified_info']);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, -3, '         ______________________________________________________________________','','1');
$pdf->Cell(150, 15, '         ______________________________________________________________________');

$pdf->Ln(15);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, 0, '20.    During your stay abroad did you lose any service property or documents? If yes, list them:  ');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Ln(5);
$pdf->SetFillColor(240, 240, 240);
$pdf->Cell(12, 5, '', 0, 0);
$pdf->Cell(15, 5, 'Ser', 1, 0, 'C', 'true');
$pdf->Cell(50, 5, 'Type of Doc', 1, 0, 'C', 'true');
$pdf->Cell(50, 5, 'Place', 1, 0, 'C', 'true');//end of line
$pdf->Cell(50, 5, 'Remarks', 1, 1, 'C', 'true');//end of line

while ($item = mysqli_fetch_assoc($lostSvcItem)) {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(12, 5, '', 0, 0);
    $pdf->Cell(15, 5, $item['ser_no'], 1, 0, 'C');
    $pdf->Cell(50, 5, $item['type_of_docu'], 1, 0, '');
    $pdf->Cell(50, 5, $item['place_of_lost'], 1, 0, '');
    $pdf->Cell(50, 5, $item['remarks'], 1, 1, '');//end of line
}
//Lose svc property Table Data End

$pdf->Ln(7);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 0, '21.    Have you or any member of your team encountered any difficulty or got involved in any');
$pdf->Ln(0);
$pdf->Cell(0, 10, '         problem/trouble? Give details');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(12, 10, '');
$pdf->Ln(3);
$pdf->Cell(11, 0, '');
$pdf->MultiCell(167, 5, $visitInfo['difficulty']);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, -3, '         ______________________________________________________________________','','1');
$pdf->Cell(150, 15, '         ______________________________________________________________________');

$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetFont('Arial', '', 12);

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 0, '22.     Have you ever suspected any member of your team of having secret understanding with');
$pdf->Ln(0);
$pdf->Cell(0, 10, '          any foreigner? Write details');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(12, 10, '');
$pdf->Ln(3);
$pdf->Cell(12, 0, '');
$pdf->MultiCell(167, 5, $visitInfo['secret_understanding']);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, -3, '          ______________________________________________________________________','','1');
$pdf->Cell(150, 15, '          ______________________________________________________________________');

$pdf->Ln(15);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 0, '23.     Details of the foreign intelligence network or spy if you could observe them');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(12, 10, '');
$pdf->Ln(3);
$pdf->Cell(12, 0, '');
$pdf->MultiCell(167, 5, $visitInfo['foreign_spy']);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, -3, '          ______________________________________________________________________','','1');
$pdf->Cell(150, 15, '          ______________________________________________________________________');

$pdf->Ln(15);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 0, '24.     General impression of the foreigner and thier Govt. about Bangladesh (to include views,');
$pdf->Ln(0);
$pdf->Cell(0, 10, '          opinions, expressed by high officials/published in thier media)');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(12, 10, '');
$pdf->Ln(3);
$pdf->Cell(12, 0, '');
$pdf->MultiCell(167, 5, $visitInfo['gen_impression']);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, -3, '          ______________________________________________________________________','','1');
$pdf->Cell(150, 15, '          ______________________________________________________________________');

$pdf->Ln(20);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 0, '25.     Details of the military/industrial sites visited/stayed: (you may add map/photo to furnish');
$pdf->Ln(0);
$pdf->Cell(0, 10, '          this column)');

//Mil Site Visit Table Data Start
$pdf->SetFont('Arial', 'B', 12);
$pdf->Ln(10);
$pdf->Cell(12, 5, '', 0, 0);
$pdf->Cell(15, 5, 'Ser', 1, 0, 'C', 'true');
$pdf->Cell(50, 5, 'Place', 1, 0, 'C', 'true');
$pdf->Cell(100, 5, 'Importance', 1, 1, 'C', 'true');//end of line

while ($item = mysqli_fetch_assoc($milSiteInfo)) {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(12, 5, '', 0, 0);
    $pdf->Cell(15, 5, $item['ser_no'], 1, 0, 'C');
    $pdf->Cell(50, 5, $item['place'], 1, 0, '');
    $pdf->Cell(100, 5, $item['importance'], 1, 1, '');//end of line
}
// Mil Site visit Table Data End

$pdf->Ln(15);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 0, '26.     Details of the meeting with military and civil high officials:');

//Mil Meeting Table Data Start
$pdf->SetFont('Arial', 'B', 12);
$pdf->Ln(5);
$pdf->Cell(12, 5, '', 0, 0);
$pdf->Cell(15, 5, 'Ser', 1, 0, 'C', 'true');
$pdf->Cell(50, 5, 'Particulars', 1, 0, 'C', 'true');
$pdf->Cell(50, 5, 'Appointment', 1, 0, 'C', 'true');
$pdf->Cell(50, 5, 'Purpose', 1, 1, 'C', 'true');//end of line

while ($item = mysqli_fetch_assoc($milMeetInfo)) {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(12, 5, '', 0, 0);
    $pdf->Cell(15, 5, $item['ser_no'], 1, 0, 'C');
    $pdf->Cell(50, 5, $item['particulars'], 1, 0, '');
    $pdf->Cell(50, 5, $item['appointment'], 1, 0, '');
    $pdf->Cell(50, 5, $item['purpose_of_meeting'], 1, 1, '');//end of line
}
// Mil Meeting Table Data End

$pdf->Ln(20);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 0, '27.     Did you become a member of any foreign organization/club/association? Give details:');

//Club Table Data Start
$pdf->SetFont('Arial', 'B', 12);
$pdf->Ln(5);
$pdf->Cell(12, 5, '', 0, 0);
$pdf->Cell(15, 5, 'Ser', 1, 0, 'C', 'true');
$pdf->Cell(100, 5, 'Name of Club/Org', 1, 0, 'C', 'true');
$pdf->Cell(50, 5, 'Remarks', 1, 1, 'C', 'true');//end of line

while ($item = mysqli_fetch_assoc($clubMemberInfo)) {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(12, 5, '', 0, 0);
    $pdf->Cell(15, 5, $item['ser_no'], 1, 0, 'C');
    $pdf->Cell(100, 5, $item['name_of_club'], 1, 0, '');
    $pdf->Cell(50, 5, $item['remarks'], 1, 1, '');//end of line
}
//Club Table Data End

$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetFont('Arial', '', 12);

$pdf->Ln(20);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 0, '28.     Any other info/suggestion/opinion that you feel will be  valuable  for  the  future  visits  of');
$pdf->Ln(0);
$pdf->Cell(0, 10, '          such kind:');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(12, 10, '');
$pdf->Ln(3);
$pdf->Cell(12, 0, '');
$pdf->MultiCell(167, 5, $visitInfo['valuable_info']);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, -3, '          ______________________________________________________________________','','1');
$pdf->Cell(150, 15, '          ______________________________________________________________________');

$pdf->Ln(30);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 0, '29.     Particulars of gift received from foreign nationals: (you may incl the gift items for nec');
$pdf->Ln(0);
$pdf->Cell(0, 10, 'clearance as per AFO 113-13 dated 12 March 1996)');


//Gift Table Data Start
$pdf->SetFont('Arial', 'B', 12);
$pdf->Ln(10);
$pdf->Cell(12, 5, 'Ser', 1, 0, 'C', 'true');
$pdf->Cell(37, 5, 'Gift Details', 1, 0, 'C', 'true');
$pdf->Cell(20, 5, 'Date', 1, 0, 'C', 'true');
$pdf->Cell(30, 5, 'Gift Value', 1, 0, 'C', 'true');
$pdf->Cell(60, 5, 'Name of Dignitary/Institute', 1, 0, 'C', 'true');
$pdf->Cell(20, 5, 'Remarks', 1, 1, 'C', 'true');//end of line

while ($item = mysqli_fetch_assoc($giftInfo)) {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(12, 5, $item['ser_no'], 1, 0, 'C');
    $pdf->Cell(37, 5, $item['details_of_gift_received'], 1, 0, '');
    $pdf->Cell(20, 5, $item['gift_date'], 1, 0, '');
    $pdf->Cell(30, 5, $item['approx_value'], 1, 0, '');
    $pdf->Cell(60, 5, $item['dignitary_name'], 1, 0, '');
    $pdf->Cell(20, 5, $item['remarks'], 1, 1, '');//end of line
}
//Gift Table Data End

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);

$pdf->Cell(100, 20, '30.    a.     Have you purchased any fire arms?');
$pdf->SetFont('Arial', 'B', 12);

$pdf->Cell(20, 20, $visitInfo['fire_arm']);
$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(87, 20, '');
$pdf->Cell(0, 20, '______________________________________');

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);

$pdf->Cell(80, 20, '         b.     If yes, fill up the boxes:');
$header = array('Ser No', 'Arms Type', 'Price', 'Permission', 'Remarks');

//Arms Table Data Start
$pdf->SetFont('Arial', 'B', 12);
$pdf->Ln(15);
$pdf->Cell(12, 5, '', 0, 0);
$pdf->Cell(15, 5, 'Ser', 1, 0, 'C', 'true');
$pdf->Cell(40, 5, 'Arms Type', 1, 0, 'C', 'true');
$pdf->Cell(30, 5, 'Price', 1, 0, 'C', 'true');
$pdf->Cell(52, 5, 'Permission Taken From', 1, 0, 'C', 'true');
$pdf->Cell(30, 5, 'Remarks', 1, 1, 'C', 'true');//end of line

while ($item = mysqli_fetch_assoc($armsInfo)) {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(12, 5, '', 0, 0);
    $pdf->Cell(15, 5, $item['ser_no'], 1, 0, '');
    $pdf->Cell(40, 5, $item['type_of_arm'], 1, 0, '');
    $pdf->Cell(30, 5, $item['price'], 1, 0, '');
    $pdf->Cell(52, 5, $item['permission_taken_from'], 1, 0, '');
    $pdf->Cell(30, 5, $item['remarks'], 1, 1, '');//end of line
}
//Arms Table Data End

$pdf->Ln(20);
$pdf->SetFont('Arial', 'BI', 11);
$pdf->Cell(150, 0, ' *  I hereby certified that the information given above are correct  to  the  best  of  my  knowledge');
$pdf->Ln(5);
$pdf->Cell(150, 0, 'and belief and I shall be liable of disciplinary actions for giving any wrong statement.');

$pdf->Ln(20);
$pdf->SetFont('Arial','',12);
$pdf->Cell(100,0,'    ');
$pdf->SetFont('Arial','B'.'U',12);
$pdf->Cell(0,0,'Submitted By');
$pdf->Ln(10);
$pdf->SetFont('Arial','',12);
$pdf->Cell(100,0,'    ');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(17,0,'Name  : ');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,0,$personelInfo['name']);
$pdf->Ln(0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(116,0,'    ');
$pdf->Cell(0,0,'___________________________');
$pdf->Ln(5);
$pdf->SetFont('Arial','',12);
$pdf->Cell(100,0,'    ');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(17,0,'Rank   : ');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,0,$personelInfo['rank']);
$pdf->Ln(0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(116,0,'    ');
$pdf->Cell(0,0,'___________________________');

$date = date('d M y',strtotime($visitInfo['submit_date']));
$pdf->Ln(5);
$pdf->SetFont('Arial','',12);
$pdf->Cell(13,0,'Date : ');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(20,0,$date);
$pdf->SetFont('Arial','',12);
$pdf->Cell(67,0,'    ');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(17,0,'BD No :');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,0,$personelInfo['bd_no']);
$pdf->Ln(0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(116,0,'    ');
$pdf->Cell(0,0,'___________________________');
ob_clean();
$pdf->Output('I', $personelInfo['bd_no'] . '_f_20388' . '.pdf');
?>

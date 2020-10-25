<?php
//include connection file
include_once("../config.php");
include_once('libs/mpdf.php');
$bd_no = $_GET['bd_no'];
$visit_id = $_GET['visit_info_id'];

mysqli_set_charset($link, 'utf8');
$personelInfo = mysqli_query($link, "SELECT * FROM new_users WHERE bd_no='$bd_no'") or die("database error:" . mysqli_error($link));
$personelInfo = mysqli_fetch_assoc($personelInfo);
$visitInfo = mysqli_query($link, "SELECT * FROM debrief_20388_visit_info WHERE bd_no='$bd_no'&&visit_info_id='$visit_id'") or die("database error:" . mysqli_error($link));
$visitInfo = mysqli_fetch_assoc($visitInfo);

$mpdf = new mPDF('', 'A4', 14, 'nikosh');
$mpdf->WriteHTML('');

$mpdf->MultiCell(0, 10, 'গোপনীয়', 0, 'C', 0);

$mpdf->MultiCell(0, 10, 'বি বা ফরম-২০৩৮৬', 0, 'R');

$mpdf->SetFont('', 'B'.'U', 18);
$mpdf->MultiCell(0, 0, 'বিদেশ হতে প্রত্যাবর্তনের পর গোয়েন্দা ডি-ব্রীফিং', 0, 'C');
$mpdf->MultiCell(0, 0, '______________________________________', 0, 'C');

$mpdf->SetFont('', '', 13);
$mpdf->MultiCell(0, 12, '(ক্রমিক নং ১ হতে ৯ পর্যন্ত প্রত্যাবর্তনকারী কর্তৃক পূরণীয়)', 0, 'C');
// Line break
$mpdf->Ln(10);
$mpdf->SetFont('', '', 14);
$mpdf->MultiCell(0, 0, '১ ।    বিডি নং                                                                 ২ ।     পদবী');
$mpdf->SetFont('', 'B', 12);
$mpdf->MultiCell(0, 0, '                           ' . $personelInfo['bd_no']);
$mpdf->MultiCell(0, 0, '                                                                                                                         ' . $personelInfo['rank']);
$mpdf->MultiCell(0, 0, '                        _____________________________________________                      ___________________________________');

$mpdf->Ln(10);
$mpdf->SetFont('', '', 14);
$mpdf->MultiCell(0, 0, '৩ ।   নাম       ');
$mpdf->SetFont('', 'B', 12);
$mpdf->MultiCell(0, 0, '                           ' . $personelInfo['name']);
$mpdf->MultiCell(0, 0, '                   _________________________________________________________________________________________________');

$mpdf->Ln(10);
$mpdf->SetFont('', '', 14);
$mpdf->MultiCell(0, 0, '৪ ।    ব্রাঞ্চ/ট্রেড                                                                ৫ ।    ইউনিট     ');
$mpdf->SetFont('', 'B', 12);
$mpdf->MultiCell(0, 0, '                           ' . $personelInfo['br_trade'] );
$mpdf->MultiCell(0, 0, '                                                                                                                          ' . $personelInfo['unit']);
$mpdf->MultiCell(0, 0, '                        _____________________________________________                      ___________________________________');

$mpdf->Ln(10);
$mpdf->SetFont('', '', 14);
$mpdf->MultiCell(0, 0, '৬ ।    ভ্রমনের উদ্দেশ্য    ');
$mpdf->SetFont('', 'B', 12);
$mpdf->MultiCell(0, 0, '                                       ' . $visitInfo['visit_purpose']);
$mpdf->MultiCell(0, 0, '                                  _______________________________________________________________________________________');

$mpdf->Ln(10);
$mpdf->SetFont('', '', 14);
$mpdf->MultiCell(0, 0, '৭ ।    ভ্রমন করতে ইচ্ছুক দেশের নাম    ');
$mpdf->SetFont('', 'B', 12);
$mpdf->MultiCell(0, 0, '                                                               ' . $visitInfo['destination_country']);
$mpdf->MultiCell(0, 0, '                                                        _________________________________________________________________________');

$fromDate = date('d M y',strtotime($visitInfo['duration_of_stay_from']));
$toDate = date('d M y',strtotime($visitInfo['duration_of_stay_to']));
$mpdf->Ln(10);
$mpdf->SetFont('', '', 14);
$mpdf->MultiCell(0, 0, '৮ ।    বিদেশে অবস্থানের মেয়াদ                                             হতে                                                   পর্যন্ত');
$mpdf->SetFont('', 'B', 12);
$mpdf->MultiCell(0, 0, '                                                               ' . $fromDate . '                                       ' .$toDate );
$mpdf->MultiCell(0, 0, '                                                 _____________________________             ___________________________________');

$mpdf->Ln(10);
$mpdf->SetFont('', '', 14);
$mpdf->MultiCell(0, 0, '৯ ।    বিদেশে হতে প্রত্যাবর্তনের তারিখ     ');
$mpdf->SetFont('', 'B', 12);
$mpdf->MultiCell(0, 0, '                                                               ' . $toDate);
$mpdf->MultiCell(0, 0, '                                                           _______________________________________________________________________');

$mpdf->Ln(20);
$mpdf->SetFont('', '', 14);
$mpdf->MultiCell(0, 0, '                                                                                          স্বাক্ষর');
$mpdf->SetFont('', 'B', 14);
$mpdf->MultiCell(0, 0, '                                                                                                  _______________________________');
$mpdf->Ln(6);
$mpdf->SetFont('', '', 14);
$mpdf->MultiCell(0, 0, '                                                                                          নাম      ');
$mpdf->SetFont('', 'B', 12);
$mpdf->MultiCell(0, 0, '                                                                                                                    ' . $personelInfo['name']);
$mpdf->MultiCell(0, 0, '                                                                                                                  ____________________________________');

$date = date('d M y',strtotime($visitInfo['submit_date']));
$mpdf->Ln(6);
$mpdf->SetFont('', '', 14);
$mpdf->MultiCell(0, 0, 'তারিখঃ                                                                                পদবী    ');
$mpdf->SetFont('', 'B', 12);
$mpdf->MultiCell(0, 0, '                 ' . $date);
$mpdf->SetFont('', 'B', 12);
$mpdf->MultiCell(0, 0, '                                                                                                                    ' . $personelInfo['rank']);
$mpdf->MultiCell(0, 0, '            ___________________                                                                        ____________________________________');

$mpdf->Ln(15);
$mpdf->SetFont('', '', 14);
$mpdf->MultiCell(0, 0, '১০ ।    বিমান গোয়েন্দা পরিদপ্তরের মন্তব্য    ');
$mpdf->SetFont('', 'B', 14);
$mpdf->MultiCell(0, 0, '                                                                 প্রয়োজনীয় ডি-ব্রীফিং দেয়া হয়েছে ।');
$mpdf->MultiCell(0, 0, '                                                     ____________________________________________________________');

$mpdf->Ln(20);
$mpdf->SetFont('', '', 14);
$mpdf->MultiCell(0, 0, '                                                                                                 স্বাক্ষর');
$mpdf->Ln(6);
$mpdf->MultiCell(0, 0, '                                                                                                 নাম      ');
$mpdf->Ln(6);
$mpdf->MultiCell(0, 0, '                                                                                                 পদবী      ');
$mpdf->Ln(6);
$mpdf->MultiCell(0, 0, '                                                                                                 পদমর্যাদা     ');
$mpdf->Ln(6);
$mpdf->MultiCell(0, 0, 'স্থানঃ   বিমান সদর                                                                         তারিখ    ');
$mpdf->SetFont('', 'B', 14);

$mpdf->Ln(15);
$mpdf->SetFont('', '', 14);
$mpdf->MultiCell(0, 0, '১১ ।    প্রতিরক্ষা গোয়েন্দা মহাপরিদপ্তরের মন্তব্য    ');
$mpdf->SetFont('', 'B', 14);
$mpdf->MultiCell(0, 0, '                                                           ________________________________________________________');

$mpdf->Ln(20);
$mpdf->SetFont('', '', 14);
$mpdf->MultiCell(0, 0, '                                                                                                 স্বাক্ষর');
$mpdf->Ln(6);
$mpdf->MultiCell(0, 0, '                                                                                                 নাম      ');
$mpdf->Ln(6);
$mpdf->MultiCell(0, 0, '                                                                                                 পদবী      ');
$mpdf->Ln(6);
$mpdf->MultiCell(0, 0, '                                                                                                 পদমর্যাদা     ');
$mpdf->Ln(6);
$mpdf->MultiCell(0, 0, 'স্থানঃ                                                                                          তারিখ    ');
$mpdf->SetFont('', 'B', 14);
$mpdf->MultiCell(0, 0, '       _________________________');
$mpdf->Ln(10);
$mpdf->SetFont('', '', 14);
$mpdf->MultiCell(0, 0, 'গোপনীয়', 0, 'C', 0);
ob_clean();
$mpdf->Output($personelInfo['bd_no'] . '_f_20386' . '.pdf', 'I');
?>

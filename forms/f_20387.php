<?php
date_default_timezone_set('UTC');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location: ../index.php');
} else {
    //Visit id increase code start
    include('../config.php');
    $sql = "SELECT visit_info_id FROM briefing_20387_visit_info WHERE bd_no='$_SESSION[bd_no]' ORDER BY visit_info_id DESC LIMIT 1";
    if (mysqli_query($link, $sql)) {
        $visitData = mysqli_query($link, $sql);
        $visitData = mysqli_fetch_assoc($visitData);
        $visitId = $visitData['visit_info_id'];
        $_SESSION['visitId'] = ++$visitId;
    } else {
        $_SESSION['visitId'] = 1;
    }
    //Visit id increase code finish
}
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'logout') {
        require_once('../Login.php');
        $logout = new Login();
        $message = $logout->adminLogout();
        $_SESSION['message'] = $message;
    }
}

$message = '';
if (isset($_POST['btn_submit'])) {
    require_once '../Briefing.php';
    $breifing = new Briefing();
    $message = $breifing->makeUserActive();
    $message = $breifing->saveVisitData();
    header('location: general_instruction.php');
}
include('f_header.php');
?>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h3 class="text-center text-warning"><?php // echo "Visit ID :". $_SESSION['visitId']." Group ID :". $_SESSION['groupId'] ?></h3>
            <div class="well">
                <h3 class="text-center text-default"><b><u>DIRECTORATE OF AIR INTELLIGENCE <br> INTELLIGENCE BRIEFING
                            WHILE PROCEEDING ABROAD</u></b></h3>
                <h4 class="text-center text-default">(All BAF personnel are to fill up this form prior to their
                    departure abroad. All are to go
                    through the instructions given in annex "A" and related AFO's and comply accordingly during their
                    stay abroad.) </h4>
                <form class="form" name="Form_20387" id="Form_20387" method="POST" action="" enctype="multipart/form-data" data-toggle="validator" role="form">
                    <input type="hidden" name="type_of_visit" value="briefing">

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>1. Name</label>
                            <input value="<?php echo $_SESSION['name'] ?>" class="form-control" disabled>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4 has-feedback">
                            <label>2. Rank</label>
                            <input value="<?php echo $_SESSION['rank'] ?>" class="form-control" name="rank">
                            <h6>Update Rank if neccessary.</h6>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-4 has-feedback">
                            <label>3. BD/No</label>
                            <input value="<?php echo $_SESSION['bd_no'] ?>" class="form-control" disabled>
                        </div>
                        <div class="form-group col-md-4 has-feedback">
                            <label>4. Branch/Trade</label>
                            <input value="<?php echo $_SESSION['br_trade'] ?>" class="form-control" disabled>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6 has-feedback">
                            <label class="required">5. Unit </label>
                            <input type="text" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
                                   id="unit" name="unit" placeholder="Unit">
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>6. Passport No</label>
                            <input type="text" pattern="^[A-z0-9/ ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
                                   id="passport_no" name="passport_no" placeholder="Passport">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="required">7. Purpose of visit </label>
                            <input type="text" required pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
                                   id="purpose" name="purpose_of_visit" placeholder="Purpose of Visit">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 has-feedback">
                            <label>8. Destination country: Airport </label>
                            <input type="text" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
                                   id="destination_airport" name="destination_airport" placeholder="Airport">

                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-6 has-feedback">
                            <label class="required" for="destination_country">Country </label>
                            <select id="destination_country" name="destination_country" class="form-control" required data-error="Select your Destination Country!">
                                <option value="">--Select Country--</option>
                                <option value="Afghanistan">Afghanistan</option>
                                <option value="Åland Islands">Åland Islands</option>
                                <option value="Albania">Albania</option>
                                <option value="Algeria">Algeria</option>
                                <option value="American Samoa">American Samoa</option>
                                <option value="Andorra">Andorra</option>
                                <option value="Angola">Angola</option>
                                <option value="Anguilla">Anguilla</option>
                                <option value="Antarctica">Antarctica</option>
                                <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                <option value="Argentina">Argentina</option>
                                <option value="Armenia">Armenia</option>
                                <option value="Aruba">Aruba</option>
                                <option value="Australia">Australia</option>
                                <option value="Austria">Austria</option>
                                <option value="Azerbaijan">Azerbaijan</option>
                                <option value="Bahamas">Bahamas</option>
                                <option value="Bahrain">Bahrain</option>
                                <option value="Bangladesh">Bangladesh</option>
                                <option value="Barbados">Barbados</option>
                                <option value="Belarus">Belarus</option>
                                <option value="Belgium">Belgium</option>
                                <option value="Belize">Belize</option>
                                <option value="Benin">Benin</option>
                                <option value="Bermuda">Bermuda</option>
                                <option value="Bhutan">Bhutan</option>
                                <option value="Bolivia">Bolivia</option>
                                <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                <option value="Botswana">Botswana</option>
                                <option value="Bouvet Island">Bouvet Island</option>
                                <option value="Brazil">Brazil</option>
                                <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                                <option value="Brunei Darussalam">Brunei Darussalam</option>
                                <option value="Bulgaria">Bulgaria</option>
                                <option value="Burkina Faso">Burkina Faso</option>
                                <option value="Burundi">Burundi</option>
                                <option value="Cambodia">Cambodia</option>
                                <option value="Cameroon">Cameroon</option>
                                <option value="Canada">Canada</option>
                                <option value="Cape Verde">Cape Verde</option>
                                <option value="Cayman Islands">Cayman Islands</option>
                                <option value="Central African Republic">Central African Republic</option>
                                <option value="Chad">Chad</option>
                                <option value="Chile">Chile</option>
                                <option value="China">China</option>
                                <option value="Christmas Island">Christmas Island</option>
                                <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                                <option value="Colombia">Colombia</option>
                                <option value="Comoros">Comoros</option>
                                <option value="Congo">Congo</option>
                                <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
                                <option value="Cook Islands">Cook Islands</option>
                                <option value="Costa Rica">Costa Rica</option>
                                <option value="Cote D'ivoire">Cote D'ivoire</option>
                                <option value="Croatia">Croatia</option>
                                <option value="Cuba">Cuba</option>
                                <option value="Cyprus">Cyprus</option>
                                <option value="Czech Republic">Czech Republic</option>
                                <option value="Denmark">Denmark</option>
                                <option value="Djibouti">Djibouti</option>
                                <option value="Dominica">Dominica</option>
                                <option value="Dominican Republic">Dominican Republic</option>
                                <option value="Ecuador">Ecuador</option>
                                <option value="Egypt">Egypt</option>
                                <option value="El Salvador">El Salvador</option>
                                <option value="Equatorial Guinea">Equatorial Guinea</option>
                                <option value="Eritrea">Eritrea</option>
                                <option value="Estonia">Estonia</option>
                                <option value="Ethiopia">Ethiopia</option>
                                <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                                <option value="Faroe Islands">Faroe Islands</option>
                                <option value="Fiji">Fiji</option>
                                <option value="Finland">Finland</option>
                                <option value="France">France</option>
                                <option value="French Guiana">French Guiana</option>
                                <option value="French Polynesia">French Polynesia</option>
                                <option value="French Southern Territories">French Southern Territories</option>
                                <option value="Gabon">Gabon</option>
                                <option value="Gambia">Gambia</option>
                                <option value="Georgia">Georgia</option>
                                <option value="Germany">Germany</option>
                                <option value="Ghana">Ghana</option>
                                <option value="Gibraltar">Gibraltar</option>
                                <option value="Greece">Greece</option>
                                <option value="Greenland">Greenland</option>
                                <option value="Grenada">Grenada</option>
                                <option value="Guadeloupe">Guadeloupe</option>
                                <option value="Guam">Guam</option>
                                <option value="Guatemala">Guatemala</option>
                                <option value="Guernsey">Guernsey</option>
                                <option value="Guinea">Guinea</option>
                                <option value="Guinea-bissau">Guinea-bissau</option>
                                <option value="Guyana">Guyana</option>
                                <option value="Haiti">Haiti</option>
                                <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                                <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                                <option value="Honduras">Honduras</option>
                                <option value="Hong Kong">Hong Kong</option>
                                <option value="Hungary">Hungary</option>
                                <option value="Iceland">Iceland</option>
                                <option value="India">India</option>
                                <option value="Indonesia">Indonesia</option>
                                <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                                <option value="Iraq">Iraq</option>
                                <option value="Ireland">Ireland</option>
                                <option value="Isle of Man">Isle of Man</option>
                                <option value="Israel">Israel</option>
                                <option value="Italy">Italy</option>
                                <option value="Jamaica">Jamaica</option>
                                <option value="Japan">Japan</option>
                                <option value="Jersey">Jersey</option>
                                <option value="Jordan">Jordan</option>
                                <option value="Kazakhstan">Kazakhstan</option>
                                <option value="Kenya">Kenya</option>
                                <option value="Kiribati">Kiribati</option>
                                <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                                <option value="Korea, Republic of">Korea, Republic of</option>
                                <option value="Kuwait">Kuwait</option>
                                <option value="Kyrgyzstan">Kyrgyzstan</option>
                                <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                                <option value="Latvia">Latvia</option>
                                <option value="Lebanon">Lebanon</option>
                                <option value="Lesotho">Lesotho</option>
                                <option value="Liberia">Liberia</option>
                                <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                                <option value="Liechtenstein">Liechtenstein</option>
                                <option value="Lithuania">Lithuania</option>
                                <option value="Luxembourg">Luxembourg</option>
                                <option value="Macao">Macao</option>
                                <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
                                <option value="Madagascar">Madagascar</option>
                                <option value="Malawi">Malawi</option>
                                <option value="Malaysia">Malaysia</option>
                                <option value="Maldives">Maldives</option>
                                <option value="Mali">Mali</option>
                                <option value="Malta">Malta</option>
                                <option value="Marshall Islands">Marshall Islands</option>
                                <option value="Martinique">Martinique</option>
                                <option value="Mauritania">Mauritania</option>
                                <option value="Mauritius">Mauritius</option>
                                <option value="Mayotte">Mayotte</option>
                                <option value="Mexico">Mexico</option>
                                <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                                <option value="Moldova, Republic of">Moldova, Republic of</option>
                                <option value="Monaco">Monaco</option>
                                <option value="Mongolia">Mongolia</option>
                                <option value="Montenegro">Montenegro</option>
                                <option value="Montserrat">Montserrat</option>
                                <option value="Morocco">Morocco</option>
                                <option value="Mozambique">Mozambique</option>
                                <option value="Myanmar">Myanmar</option>
                                <option value="Namibia">Namibia</option>
                                <option value="Nauru">Nauru</option>
                                <option value="Nepal">Nepal</option>
                                <option value="Netherlands">Netherlands</option>
                                <option value="Netherlands Antilles">Netherlands Antilles</option>
                                <option value="New Caledonia">New Caledonia</option>
                                <option value="New Zealand">New Zealand</option>
                                <option value="Nicaragua">Nicaragua</option>
                                <option value="Niger">Niger</option>
                                <option value="Nigeria">Nigeria</option>
                                <option value="Niue">Niue</option>
                                <option value="Norfolk Island">Norfolk Island</option>
                                <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                <option value="Norway">Norway</option>
                                <option value="Oman">Oman</option>
                                <option value="Pakistan">Pakistan</option>
                                <option value="Palau">Palau</option>
                                <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                                <option value="Panama">Panama</option>
                                <option value="Papua New Guinea">Papua New Guinea</option>
                                <option value="Paraguay">Paraguay</option>
                                <option value="Peru">Peru</option>
                                <option value="Philippines">Philippines</option>
                                <option value="Pitcairn">Pitcairn</option>
                                <option value="Poland">Poland</option>
                                <option value="Portugal">Portugal</option>
                                <option value="Puerto Rico">Puerto Rico</option>
                                <option value="Qatar">Qatar</option>
                                <option value="Reunion">Reunion</option>
                                <option value="Romania">Romania</option>
                                <option value="Russian Federation">Russian Federation</option>
                                <option value="Rwanda">Rwanda</option>
                                <option value="Saint Helena">Saint Helena</option>
                                <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                <option value="Saint Lucia">Saint Lucia</option>
                                <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                                <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                                <option value="Samoa">Samoa</option>
                                <option value="San Marino">San Marino</option>
                                <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                <option value="Saudi Arabia">Saudi Arabia</option>
                                <option value="Senegal">Senegal</option>
                                <option value="Serbia">Serbia</option>
                                <option value="Seychelles">Seychelles</option>
                                <option value="Sierra Leone">Sierra Leone</option>
                                <option value="Singapore">Singapore</option>
                                <option value="Slovakia">Slovakia</option>
                                <option value="Slovenia">Slovenia</option>
                                <option value="Solomon Islands">Solomon Islands</option>
                                <option value="Somalia">Somalia</option>
                                <option value="South Africa">South Africa</option>
                                <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
                                <option value="Spain">Spain</option>
                                <option value="Sri Lanka">Sri Lanka</option>
                                <option value="Sudan">Sudan</option>
                                <option value="Suriname">Suriname</option>
                                <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                                <option value="Swaziland">Swaziland</option>
                                <option value="Sweden">Sweden</option>
                                <option value="Switzerland">Switzerland</option>
                                <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                                <option value="Taiwan, Province of China">Taiwan, Province of China</option>
                                <option value="Tajikistan">Tajikistan</option>
                                <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                                <option value="Thailand">Thailand</option>
                                <option value="Timor-leste">Timor-leste</option>
                                <option value="Togo">Togo</option>
                                <option value="Tokelau">Tokelau</option>
                                <option value="Tonga">Tonga</option>
                                <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                <option value="Tunisia">Tunisia</option>
                                <option value="Turkey">Turkey</option>
                                <option value="Turkmenistan">Turkmenistan</option>
                                <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                                <option value="Tuvalu">Tuvalu</option>
                                <option value="Uganda">Uganda</option>
                                <option value="Ukraine">Ukraine</option>
                                <option value="United Arab Emirates">United Arab Emirates</option>
                                <option value="United Kingdom">United Kingdom</option>
                                <option value="United States">United States</option>
                                <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                                <option value="Uruguay">Uruguay</option>
                                <option value="Uzbekistan">Uzbekistan</option>
                                <option value="Vanuatu">Vanuatu</option>
                                <option value="Venezuela">Venezuela</option>
                                <option value="Viet Nam">Viet Nam</option>
                                <option value="Virgin Islands, British">Virgin Islands, British</option>
                                <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                                <option value="Wallis and Futuna">Wallis and Futuna</option>
                                <option value="Western Sahara">Western Sahara</option>
                                <option value="Yemen">Yemen</option>
                                <option value="Zambia">Zambia</option>
                                <option value="Zimbabwe">Zimbabwe</option>
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div style="border: 1px solid forestgreen;" class="table-responsive">
                        <label>9. Transit country/ countries (other than ser no 8): </label>
                        <table class="table table-bordered" id="transit_table">
                            <tr>
                                <th width="10%">Ser No</th>
                                <th width="25%">Country</th>
                                <th width="25%">Duration of Stay</th>
                                <th width="30%">Purpose</th>
                                <th width="10%">Action</th>
                            </tr>
                            <tr>
                                <td style="background-color: white" contenteditable="true" class="transit_ser_no"></td>
                                <td style="background-color: white" contenteditable="true" class="transit_country"></td>
                                <td style="background-color: white" contenteditable="true" class="transit_stay"></td>
                                <td style="background-color: white" contenteditable="true" class="transit_purpose"></td>
                                <td>
                                    <button type="button" id="addBriefingTransit" class="btn btn-success btn-xs">Add
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="row" style="margin-top: 10px">
                        <div class="form-group col-md-6">
                            <label class="required">10. Date of departure </label>
                            <input type="date" required class="form-control" id="departure_date" name="departure_date"
                                   placeholder="date">
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-6 has-feedback">
                            <label>11. Place of departure</label>
                            <input type="text" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
                                   id="departure_place" name="departure_place" placeholder="Place of departure">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>12. Name of the carrier with flight no: </label>
                            <input type="text" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
                                   id="name_of_airlines" name="name_of_airlines"
                                   placeholder="Name of Airlines with Flight No">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 has-feedback">
                            <label class="required">13. Date of reaching destination : </label>
                            <input type="date" required class="form-control" name="date_of_reaching_destination">
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-6 has-feedback">
                            <label class="required">Estimated Date of Return from destination : </label>
                            <input type="date" required class="form-control" name="date_of_leaving_destination">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>Do you have Ex-BD lv with the tour? If yes, give date</label>
                            <input class="btn btn-info" type="button" value="Yes" name="btnExBdLv" required/>
                            <input class="btn btn-info" type="button" value="No" name="btnExBdLv" required/>
                            <div class="row"  id="ExBdLv" style="display: none">
                                <div class="form-group col-md-6 has-feedback">
                                    <label  class="required">Date of lv start : </label>
                                    <input type="date" class="form-control" name="ex_bd_lv_start">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group col-md-6 has-feedback">
                                    <label  class="required">Date of lv finish : </label>
                                    <input type="date" class="form-control" name="ex_bd_lv_finish">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Upload your ex-bd leave Permission document</label>
                                    <input class="form-control" type="file" name="myfile">
                                    <h6 class="text-danger">File type Must be .jpg, .png, .pdf  and size not exceed 5MB !</h6>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>14. Duration of stay abroad : </label>
                            <input type="text" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
                                   id="duration_of_stay_abroad" name="duration_of_stay_abroad"
                                   placeholder="Duration of stay abroad">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div style="border: 1px solid forestgreen;" class="table-responsive">
                        <label>15. Details visit abroad in the past (in the last 05 years): </label>
                        <table class="table table-bordered" id="past_table">
                            <tr>
                                <th width="5%">Ser</th>
                                <th width="20%">Country</th>
                                <th width="25%">Purpose</th>
                                <th width="25%">Duration of Stay</th>
                                <th width="20%">Remarks</th>
                                <th width="10%">Action</th>
                            </tr>
                            <tr>
                                <td style="background-color: white" contenteditable="true"
                                    class="past_visit_ser_no"></td>
                                <td style="background-color: white" contenteditable="true" class="past_country"></td>
                                <td style="background-color: white" contenteditable="true" class="past_purpose"></td>
                                <td style="background-color: white" contenteditable="true"
                                    class="past_duration_of_stay"></td>
                                <td style="background-color: white" contenteditable="true" class="past_remarks"></td>
                                <td>
                                    <button type="button" id="addBriefingPastTable" class="btn btn-success btn-xs">Add
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div style="border: 1px solid forestgreen; margin-top: 10px" class="table-responsive">
                        <label>16. Particulars of the family members traveling with you or likely to accompany
                            later: </label>
                        <table class="table table-bordered" id="family_table">
                            <tr>
                                <th width="10%">Ser</th>
                                <th width="30%">Name</th>
                                <th width="30%">Relation</th>
                                <th width="25%">Date of Departure</th>
                                <th width="5%">Action</th>
                            </tr>
                            <tr>
                                <td style="background-color: white" contenteditable="true" class="family_ser_no"></td>
                                <td style="background-color: white" contenteditable="true"
                                    class="family_member_name"></td>
                                <td style="background-color: white" contenteditable="true" class="family_relation"></td>
                                <td style="background-color: white" contenteditable="true"
                                    class="family_date_of_departure"></td>
                                <td>
                                    <button type="button" id="addFamilyTable" class="btn btn-success btn-xs">Add
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div style="border: 1px solid forestgreen; margin-top: 10px" class="table-responsive">
                        <label>17. Particulars of the sponsor/ relative friends in the visiting country who may help you
                            in an emergency: </label>
                        <table class="table table-bordered" id="sponsor_table">
                            <tr>
                                <th width="5%">Ser</th>
                                <th width="20%">Name</th>
                                <th width="20%">Occupation</th>
                                <th width="20%">Relation</th>
                                <th width="30%">Address</th>
                                <th width="10%">Action</th>
                            </tr>
                            <tr>
                                <td style="background-color: white" contenteditable="true" class="sponsor_ser_no"></td>
                                <td style="background-color: white" contenteditable="true" class="sponsor_name"></td>
                                <td style="background-color: white" contenteditable="true"
                                    class="sponsor_occupation"></td>
                                <td style="background-color: white" contenteditable="true"
                                    class="sponsor_relation"></td>
                                <td style="background-color: white" contenteditable="true" class="sponsor_address"></td>
                                <td>
                                    <button type="button" id="addBriefingSponsorTable" class="btn btn-success btn-xs">
                                        Add
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div style="border: 1px solid forestgreen; margin-top: 10px" class="table-responsive">
                        <label>18. List of the service items/ documents(if any) being carried by you: </label>
                        <table class="table table-bordered" id="service_item_table">
                            <tr>
                                <th width="10%">Ser No</th>
                                <th width="85%">Item Details</th>
                                <th width="5%">Action</th>
                            </tr>
                            <tr>
                                <td style="background-color: white" contenteditable="true"
                                    class="service_item_ser_no"></td>
                                <td style="background-color: white" contenteditable="true"
                                    class="service_item_details"></td>
                                <td>
                                    <button type="button" id="addServiceItem" class="btn btn-success btn-xs">Add
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="form-group row has-feedback">
                        <div class="col-md-12" style="margin-top: 10px">
                            <label>19. Total amount of money being credited to you for the course/ visit: </label>
                            <input type="text" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
                                   id="total_money" name="total_money" placeholder="Money Credited">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>20. Are you taking any personal money with you? If yes, state the amount</label>
                            <input type="text" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
                                   id="inputEmail4" name="personal_money" placeholder="Personal Money">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>Is there any other BAF personnel traveling with you? If yes, give their svc number</label>
                            <input class="btn btn-info" type="button" value="Yes" name="btnpersonTravelingWith" required/>
                            <input class="btn btn-info" type="button" value="No" name="btnpersonTravelingWith" required/>
                            <div class="col-md-5 col-md-offset-4">
                                <table style="display: none" class="table table-bordered" id="personTravelingWith">
                                    <tr>
                                        <th width="5%" style="text-align: center">Ser No</th>
                                        <th width="15%" style="text-align: center">Svc No</th>
                                        <th width="5%" style="text-align: center">Action</th>
                                    </tr>
                                    <tr>
                                        <td style="background-color: white; text-align: center" contenteditable="true" class="ser_no"></td>
                                        <td>
                                            <div class="form-group has-feedback">
                                                <input class="svc_no form-control" type="number" data-error="Svc No minimum 4 Character !" pattern="^[0-9]{1,}$" placeholder="Svc No" data-minlength="4">
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </td>
                                        <td><button type="button" id="add" class="btn btn-success btn-sm">Add</button></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <h4 class="text-center text-warning">
                        <input id="agreement" required type="checkbox" name="agreement" value="1"> * I hereby certified
                        that the information given above are correct to the best of my knowledge
                        belief and I shall be liable of disciplinary action for giving any wrong statement.
                    </h4>

                    <div class="form-group row">
                        <div class="col-md-offset-5 col-md-7">
                            <button type="submit" class="btn btn-success" id="save" name="btn_submit">Submit</button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <h5>Annex:</h5>
                        <h5>A. General instruction for BAF personal while proceeding abroad. </h5>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="../js/jquery-1.12.4.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/validator.js"></script>
</body>
</html>
<script type="text/javascript">
    $(function () {
        $("input[name=btnpersonTravelingWith]").click(function () {
            if ($(this).val() == "Yes") {
                $("#personTravelingWith").show();
            } else {
                $("#personTravelingWith").hide();
            }
        });
        $("input[name=btnExBdLv]").click(function () {
            if ($(this).val() == "Yes") {
                $("#ExBdLv").show();
            } else {
                $("#ExBdLv").hide();
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        var count = 1;
        // Persons Traveling with info add function
        $('#add').click(function () {
            count = count + 1;
            var html_code = "<tr id='row" + count + "'>";
            html_code += "<td style='background-color: white; text-align: center' contenteditable='true' class='ser_no'></td>";
            html_code += "<td style=\"background-color: white\">\n" +
                "                        <div class=\"form-group has-feedback\">\n" +
                "                            <input class=\"svc_no form-control\" type=\"text\" data-pattern-error=\"Only Number Allowed\" pattern=\"^[0-9]{1,}$\" placeholder=\"Svc No\" required>\n" +
                "                            <div class=\"help-block with-errors\"></div>\n" +
                "                        </div>\n" +
                "                    </td>";
            html_code += "<td><button type='button' name='remove' data-row='row" + count + "' class='btn btn-danger btn-sm remove'>Del</button></td>";
            html_code += "</tr>";
            $('#personTravelingWith').append(html_code);
        });

        // 09. Transit table add function
        $('#addBriefingTransit').click(function () {
            count = count + 1;
            var html_code = "<tr id='row" + count + "'>";
            html_code += "<td style='background-color: white' contenteditable='true' class='transit_ser_no'></td>";
            html_code += "<td style='background-color: white'  contenteditable='true' class='transit_country'></td>";
            html_code += "<td style='background-color: white'  contenteditable='true' class='transit_stay'></td>";
            html_code += "<td style='background-color: white'  contenteditable='true' class='transit_purpose' ></td>";
            html_code += "<td><button type='button' name='remove' data-row='row" + count + "' class='btn btn-danger btn-xs remove'>Del</button></td>";
            html_code += "</tr>";
            $('#transit_table').append(html_code);
        });

        // 15. Past visit info add function
        $('#addBriefingPastTable').click(function () {
            count = count + 1;
            var html_code = "<tr id='row" + count + "'>";
            html_code += "<td style='background-color: white' contenteditable='true' class='past_visit_ser_no'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='past_country'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='past_purpose'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='past_duration_of_stay'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='past_remarks' ></td>";
            html_code += "<td><button type='button' name='remove' data-row='row" + count + "' class='btn btn-danger btn-xs remove'>Del</button></td>";
            html_code += "</tr>";
            $('#past_table').append(html_code);
        });

        // 16. Family members info add function
        $('#addFamilyTable').click(function () {
            count = count + 1;
            var html_code = "<tr id='row" + count + "'>";
            html_code += "<td style='background-color: white' contenteditable='true' class='family_ser_no'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='family_member_name'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='family_relation'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='family_date_of_departure'></td>";
            html_code += "<td><button type='button' name='remove' data-row='row" + count + "' class='btn btn-danger btn-xs remove'>Del</button></td>";
            html_code += "</tr>";
            $('#family_table').append(html_code);
        });

        // 17. Sponsor/relative info add function
        $('#addBriefingSponsorTable').click(function () {
            count = count + 1;
            var html_code = "<tr id='row" + count + "'>";
            html_code += "<td style='background-color: white' contenteditable='true' class='sponsor_ser_no'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='sponsor_name'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='sponsor_occupation'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='sponsor_relation'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='sponsor_address' ></td>";
            html_code += "<td><button type='button' name='remove' data-row='row" + count + "' class='btn btn-danger btn-xs remove'>Del</button></td>";
            html_code += "</tr>";
            $('#sponsor_table').append(html_code);
        });

        // 18. Service Item info add function
        $('#addServiceItem').click(function () {
            count = count + 1;
            var html_code = "<tr id='row" + count + "'>";
            html_code += "<td style='background-color: white' contenteditable='true' class='service_item_ser_no'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='service_item_details'></td>";
            html_code += "<td><button type='button' name='remove' data-row='row" + count + "' class='btn btn-danger btn-xs remove'>Del</button></td>";
            html_code += "</tr>";
            $('#service_item_table').append(html_code);
        });

        // Destination Country Session Create function
        $('#destination_country').change(function () {
            var destination_country = $(this).val();

            $.ajax({
                url: "../session_create.php",
                method: "POST",
                data: {destination_country: destination_country},
                success: function (data) {
                    //alert(data);
                }
            });
        });

        $(document).on('click', '.remove', function () {
            var delete_row = $(this).data("row");
            $('#' + delete_row).remove();
        });

        $('#Form_20387').validator().on('submit', function (e) {
            if (e.isDefaultPrevented()) {
                // handle the invalid form...
                alert("Please Fill the form correctly.");
            } else {
                // everything looks good!

                var svc_no = [];

                $('.svc_no').each(function () {
                    svc_no.push($(this).val());
                });

                $.ajax({
                    url: "briefing_insert_dynamic_tables/groupMemberInsert.php",
                    method: "POST",
                    data: {svc_no: svc_no},
                    success: function (data) {
                        //alert(data);
                        $("td[contentEditable='true']").text("");
                        for (var i = 2; i <= count; i++) {
                            $('tr#' + i + '').remove();
                        }
                        //fetch_item_data();
                    }
                });

                var transit_ser_no = [];
                var transit_country = [];
                var transit_stay = [];
                var transit_purpose = [];
                $('.transit_ser_no').each(function () {
                    transit_ser_no.push($(this).text());
                });
                $('.transit_country').each(function () {
                    transit_country.push($(this).text());
                });
                $('.transit_stay').each(function () {
                    transit_stay.push($(this).text());
                });
                $('.transit_purpose').each(function () {
                    transit_purpose.push($(this).text());
                });

                $.ajax({
                    url: "briefing_insert_dynamic_tables/insertTransit.php",
                    method: "POST",
                    data: {
                        transit_ser_no: transit_ser_no,
                        transit_country: transit_country,
                        transit_stay: transit_stay,
                        transit_purpose: transit_purpose
                    },
                    success: function (data) {
                        //alert(data);
                        $("td[contentEditable='true']").text("");
                        for (var i = 2; i <= count; i++) {
                            $('tr#' + i + '').remove();
                        }
                        //fetch_item_data();
                    }
                });

                var past_visit_ser_no = [];
                var past_country = [];
                var past_duration_of_stay = [];
                var past_purpose = [];
                var past_remarks = [];
                $('.past_visit_ser_no').each(function () {
                    past_visit_ser_no.push($(this).text());
                });
                $('.past_country').each(function () {
                    past_country.push($(this).text());
                });
                $('.past_duration_of_stay').each(function () {
                    past_duration_of_stay.push($(this).text());
                });
                $('.past_purpose').each(function () {
                    past_purpose.push($(this).text());
                });
                $('.past_remarks').each(function () {
                    past_remarks.push($(this).text());
                });

                $.ajax({
                    url: "briefing_insert_dynamic_tables/insertPastVisit.php",
                    method: "POST",
                    data: {
                        past_visit_ser_no: past_visit_ser_no,
                        past_country: past_country,
                        past_duration_of_stay: past_duration_of_stay,
                        past_purpose: past_purpose,
                        past_remarks: past_remarks
                    },
                    success: function (data) {
                        //alert(data);
                        $("td[contentEditable='true']").text("");
                        for (var i = 2; i <= count; i++) {
                            $('tr#' + i + '').remove();
                        }
                        //fetch_item_data();
                    }
                });

                var family_ser_no = [];
                var family_member_name = [];
                var family_relation = [];
                var family_date_of_departure = [];

                $('.family_ser_no').each(function () {
                    family_ser_no.push($(this).text());
                });
                $('.family_member_name').each(function () {
                    family_member_name.push($(this).text());
                });
                $('.family_relation').each(function () {
                    family_relation.push($(this).text());
                });
                $('.family_date_of_departure').each(function () {
                    family_date_of_departure.push($(this).text());
                });

                $.ajax({
                    url: "briefing_insert_dynamic_tables/insertFamily.php",
                    method: "POST",
                    data: {
                        family_ser_no: family_ser_no,
                        family_member_name: family_member_name,
                        family_relation: family_relation,
                        family_date_of_departure: family_date_of_departure
                    },
                    success: function (data) {
                        //alert(data);
                        $("td[contentEditable='true']").text("");
                        for (var i = 2; i <= count; i++) {
                            $('tr#' + i + '').remove();
                        }
                        //fetch_item_data();
                    }
                });

                var sponsor_ser_no = [];
                var sponsor_name = [];
                var sponsor_occupation = [];
                var sponsor_relation = [];
                var sponsor_address = [];

                $('.sponsor_ser_no').each(function () {
                    sponsor_ser_no.push($(this).text());
                });
                $('.sponsor_name').each(function () {
                    sponsor_name.push($(this).text());
                });
                $('.sponsor_occupation').each(function () {
                    sponsor_occupation.push($(this).text());
                });
                $('.sponsor_relation').each(function () {
                    sponsor_relation.push($(this).text());
                });
                $('.sponsor_address').each(function () {
                    sponsor_address.push($(this).text());
                });

                $.ajax({
                    url: "briefing_insert_dynamic_tables/insertSponsor.php",
                    method: "POST",
                    data: {
                        sponsor_ser_no: sponsor_ser_no,
                        sponsor_name: sponsor_name,
                        sponsor_occupation: sponsor_occupation,
                        sponsor_relation: sponsor_relation,
                        sponsor_address: sponsor_address
                    },
                    success: function (data) {
                        //alert(data);
                        $("td[contentEditable='true']").text("");
                        for (var i = 2; i <= count; i++) {
                            $('tr#' + i + '').remove();
                        }
                        //fetch_item_data();
                    }
                });

                var service_item_ser_no = [];
                var service_item_details = [];

                $('.service_item_ser_no').each(function () {
                    service_item_ser_no.push($(this).text());
                });
                $('.service_item_details').each(function () {
                    service_item_details.push($(this).text());
                });

                $.ajax({
                    url: "briefing_insert_dynamic_tables/insertServiceItem.php",
                    method: "POST",
                    data: {service_item_ser_no: service_item_ser_no, service_item_details: service_item_details},
                    success: function (data) {
                        //alert(data);
                        $("td[contentEditable='true']").text("");
                        for (var i = 2; i <= count; i++) {
                            $('tr#' + i + '').remove();
                        }
                        //fetch_item_data();
                    }
                });

            }
        });

        /*$("#save").click(function (){
            var svc_no = [];

            $('.svc_no').each(function () {
                svc_no.push($(this).val());
            });

            $.ajax({
                url: "briefing_insert_dynamic_tables/groupMemberInsert.php",
                method: "POST",
                data: {svc_no: svc_no},
                success: function (data) {
                    //alert(data);
                    $("td[contentEditable='true']").text("");
                    for (var i = 2; i <= count; i++) {
                        $('tr#' + i + '').remove();
                    }
                    //fetch_item_data();
                }
            });

            var transit_ser_no = [];
            var transit_country = [];
            var transit_stay = [];
            var transit_purpose = [];
            $('.transit_ser_no').each(function () {
                transit_ser_no.push($(this).text());
            });
            $('.transit_country').each(function () {
                transit_country.push($(this).text());
            });
            $('.transit_stay').each(function () {
                transit_stay.push($(this).text());
            });
            $('.transit_purpose').each(function () {
                transit_purpose.push($(this).text());
            });

            $.ajax({
                url: "briefing_insert_dynamic_tables/insertTransit.php",
                method: "POST",
                data: {
                    transit_ser_no: transit_ser_no,
                    transit_country: transit_country,
                    transit_stay: transit_stay,
                    transit_purpose: transit_purpose
                },
                success: function (data) {
                    //alert(data);
                    $("td[contentEditable='true']").text("");
                    for (var i = 2; i <= count; i++) {
                        $('tr#' + i + '').remove();
                    }
                    //fetch_item_data();
                }
            });

            var past_visit_ser_no = [];
            var past_country = [];
            var past_duration_of_stay = [];
            var past_purpose = [];
            var past_remarks = [];
            $('.past_visit_ser_no').each(function () {
                past_visit_ser_no.push($(this).text());
            });
            $('.past_country').each(function () {
                past_country.push($(this).text());
            });
            $('.past_duration_of_stay').each(function () {
                past_duration_of_stay.push($(this).text());
            });
            $('.past_purpose').each(function () {
                past_purpose.push($(this).text());
            });
            $('.past_remarks').each(function () {
                past_remarks.push($(this).text());
            });

            $.ajax({
                url: "briefing_insert_dynamic_tables/insertPastVisit.php",
                method: "POST",
                data: {
                    past_visit_ser_no: past_visit_ser_no,
                    past_country: past_country,
                    past_duration_of_stay: past_duration_of_stay,
                    past_purpose: past_purpose,
                    past_remarks: past_remarks
                },
                success: function (data) {
                    //alert(data);
                    $("td[contentEditable='true']").text("");
                    for (var i = 2; i <= count; i++) {
                        $('tr#' + i + '').remove();
                    }
                    //fetch_item_data();
                }
            });

            var family_ser_no = [];
            var family_member_name = [];
            var family_relation = [];
            var family_date_of_departure = [];

            $('.family_ser_no').each(function () {
                family_ser_no.push($(this).text());
            });
            $('.family_member_name').each(function () {
                family_member_name.push($(this).text());
            });
            $('.family_relation').each(function () {
                family_relation.push($(this).text());
            });
            $('.family_date_of_departure').each(function () {
                family_date_of_departure.push($(this).text());
            });

            $.ajax({
                url: "briefing_insert_dynamic_tables/insertFamily.php",
                method: "POST",
                data: {
                    family_ser_no: family_ser_no,
                    family_member_name: family_member_name,
                    family_relation: family_relation,
                    family_date_of_departure: family_date_of_departure
                },
                success: function (data) {
                    //alert(data);
                    $("td[contentEditable='true']").text("");
                    for (var i = 2; i <= count; i++) {
                        $('tr#' + i + '').remove();
                    }
                    //fetch_item_data();
                }
            });

            var sponsor_ser_no = [];
            var sponsor_name = [];
            var sponsor_occupation = [];
            var sponsor_relation = [];
            var sponsor_address = [];

            $('.sponsor_ser_no').each(function () {
                sponsor_ser_no.push($(this).text());
            });
            $('.sponsor_name').each(function () {
                sponsor_name.push($(this).text());
            });
            $('.sponsor_occupation').each(function () {
                sponsor_occupation.push($(this).text());
            });
            $('.sponsor_relation').each(function () {
                sponsor_relation.push($(this).text());
            });
            $('.sponsor_address').each(function () {
                sponsor_address.push($(this).text());
            });

            $.ajax({
                url: "briefing_insert_dynamic_tables/insertSponsor.php",
                method: "POST",
                data: {
                    sponsor_ser_no: sponsor_ser_no,
                    sponsor_name: sponsor_name,
                    sponsor_occupation: sponsor_occupation,
                    sponsor_relation: sponsor_relation,
                    sponsor_address: sponsor_address
                },
                success: function (data) {
                    //alert(data);
                    $("td[contentEditable='true']").text("");
                    for (var i = 2; i <= count; i++) {
                        $('tr#' + i + '').remove();
                    }
                    //fetch_item_data();
                }
            });

            var service_item_ser_no = [];
            var service_item_details = [];

            $('.service_item_ser_no').each(function () {
                service_item_ser_no.push($(this).text());
            });
            $('.service_item_details').each(function () {
                service_item_details.push($(this).text());
            });

            $.ajax({
                url: "briefing_insert_dynamic_tables/insertServiceItem.php",
                method: "POST",
                data: {service_item_ser_no: service_item_ser_no, service_item_details: service_item_details},
                success: function (data) {
                    //alert(data);
                    $("td[contentEditable='true']").text("");
                    for (var i = 2; i <= count; i++) {
                        $('tr#' + i + '').remove();
                    }
                    //fetch_item_data();
                }
            });
        });*/
    });
</script>
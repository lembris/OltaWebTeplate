
    
    <div class="widget mb_40 gray-bg p_40">
        <h4 class="mb_20">Your Reservation</h4>
        <form action="<?php echo base_url('packages/book_package'); ?>" method="POST">
            <div class="row g-3">
                <div class="col-md-12">
                    <div class="form-floating">
                        <input type="text" class="form-control bg-transparent" value="<?php echo str_replace('-', ' ', $current_page_name); ?>" disabled required>
                        <input name="package" value="<?php echo str_replace('-', ' ', $current_page_name); ?>" hidden>
                        <input name="current_page" value="<?php echo current_url(); ?>" hidden>
                        <label for="name">Package</label>
                    </div> 
                </div>
                <div class="col-md-12">
                    <div class="form-floating">
                        <input type="text" class="form-control bg-transparent" name="fullname" placeholder="Your Full Name" required>
                        <label for="name">Your Full Name</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating">
                        <input type="email" class="form-control bg-transparent" name="email_address" placeholder="Your Email" required>
                        <label for="name">Your Email</label>
                    </div>
                </div>
                <?php  

                    $ggggg = '<div class="col-md-12">
                    <div class="form-floating">
                        <select class="form-select bg-transparent" id="select1">
                        <option value="">Country Code</option>
                        <option value="213" data-countrycode="DZ">Algeria (+213)</option>
                        <option value="376" data-countrycode="AD">Andorra (+376)</option>
                        <option value="244" data-countrycode="AO">Angola (+244)</option>
                        <option value="1264" data-countrycode="AI">Anguilla (+1264)</option>
                        <option value="1268" data-countrycode="AG">Antigua &amp; Barbuda (+1268)</option>
                        <option value="54" data-countrycode="AR">Argentina (+54)</option>
                        <option value="374" data-countrycode="AM">Armenia (+374)</option>
                        <option value="297" data-countrycode="AW">Aruba (+297)</option>
                        <option value="61" data-countrycode="AU">Australia (+61)</option>
                        <option value="43" data-countrycode="AT">Austria (+43)</option>
                        <option value="994" data-countrycode="AZ">Azerbaijan (+994)</option>
                        <option value="1242" data-countrycode="BS">Bahamas (+1242)</option>
                        <option value="973" data-countrycode="BH">Bahrain (+973)</option>
                        <option value="880" data-countrycode="BD">Bangladesh (+880)</option>
                        <option value="1246" data-countrycode="BB">Barbados (+1246)</option>
                        <option value="375" data-countrycode="BY">Belarus (+375)</option>
                        <option value="32" data-countrycode="BE">Belgium (+32)</option>
                        <option value="501" data-countrycode="BZ">Belize (+501)</option>
                        <option value="229" data-countrycode="BJ">Benin (+229)</option>
                        <option value="1441" data-countrycode="BM">Bermuda (+1441)</option>
                        <option value="975" data-countrycode="BT">Bhutan (+975)</option>
                        <option value="591" data-countrycode="BO">Bolivia (+591)</option>
                        <option value="387" data-countrycode="BA">Bosnia Herzegovina (+387)</option>
                        <option value="267" data-countrycode="BW">Botswana (+267)</option>
                        <option value="55" data-countrycode="BR">Brazil (+55)</option>
                        <option value="673" data-countrycode="BN">Brunei (+673)</option>
                        <option value="359" data-countrycode="BG">Bulgaria (+359)</option>
                        <option value="226" data-countrycode="BF">Burkina Faso (+226)</option>
                        <option value="257" data-countrycode="BI">Burundi (+257)</option>
                        <option value="855" data-countrycode="KH">Cambodia (+855)</option>
                        <option value="237" data-countrycode="CM">Cameroon (+237)</option>
                        <option value="1" data-countrycode="CA">Canada (+1)</option>
                        <option value="238" data-countrycode="CV">Cape Verde Islands (+238)</option>
                        <option value="1345" data-countrycode="KY">Cayman Islands (+1345)</option>
                        <option value="236" data-countrycode="CF">Central African Republic (+236)</option>
                        <option value="56" data-countrycode="CL">Chile (+56)</option>
                        <option value="86" data-countrycode="CN">China (+86)</option>
                        <option value="57" data-countrycode="CO">Colombia (+57)</option>
                        <option value="269" data-countrycode="KM">Comoros (+269)</option>
                        <option value="242" data-countrycode="CG">Congo (+242)</option>
                        <option value="682" data-countrycode="CK">Cook Islands (+682)</option>
                        <option value="506" data-countrycode="CR">Costa Rica (+506)</option>
                        <option value="385" data-countrycode="HR">Croatia (+385)</option>
                        <option value="53" data-countrycode="CU">Cuba (+53)</option>
                        <option value="90392" data-countrycode="CY">Cyprus North (+90392)</option>
                        <option value="357" data-countrycode="CY">Cyprus South (+357)</option>
                        <option value="42" data-countrycode="CZ">Czech Republic (+42)</option>
                        <option value="45" data-countrycode="DK">Denmark (+45)</option>
                        <option value="253" data-countrycode="DJ">Djibouti (+253)</option>
                        <option value="1809" data-countrycode="DM">Dominica (+1809)</option>
                        <option value="1809" data-countrycode="DO">Dominican Republic (+1809)</option>
                        <option value="593" data-countrycode="EC">Ecuador (+593)</option>
                        <option value="20" data-countrycode="EG">Egypt (+20)</option>
                        <option value="503" data-countrycode="SV">El Salvador (+503)</option>
                        <option value="240" data-countrycode="GQ">Equatorial Guinea (+240)</option>
                        <option value="291" data-countrycode="ER">Eritrea (+291)</option>
                        <option value="372" data-countrycode="EE">Estonia (+372)</option>
                        <option value="251" data-countrycode="ET">Ethiopia (+251)</option>
                        <option value="500" data-countrycode="FK">Falkland Islands (+500)</option>
                        <option value="298" data-countrycode="FO">Faroe Islands (+298)</option>
                        <option value="679" data-countrycode="FJ">Fiji (+679)</option>
                        <option value="358" data-countrycode="FI">Finland (+358)</option>
                        <option value="33" data-countrycode="FR">France (+33)</option>
                        <option value="594" data-countrycode="GF">French Guiana (+594)</option>
                        <option value="689" data-countrycode="PF">French Polynesia (+689)</option>
                        <option value="241" data-countrycode="GA">Gabon (+241)</option>
                        <option value="220" data-countrycode="GM">Gambia (+220)</option>
                        <option value="7880" data-countrycode="GE">Georgia (+7880)</option>
                        <option value="49" data-countrycode="DE">Germany (+49)</option>
                        <option value="233" data-countrycode="GH">Ghana (+233)</option>
                        <option value="350" data-countrycode="GI">Gibraltar (+350)</option>
                        <option value="30" data-countrycode="GR">Greece (+30)</option>
                        <option value="299" data-countrycode="GL">Greenland (+299)</option>
                        <option value="1473" data-countrycode="GD">Grenada (+1473)</option>
                        <option value="590" data-countrycode="GP">Guadeloupe (+590)</option>
                        <option value="671" data-countrycode="GU">Guam (+671)</option>
                        <option value="502" data-countrycode="GT">Guatemala (+502)</option>
                        <option value="224" data-countrycode="GN">Guinea (+224)</option>
                        <option value="245" data-countrycode="GW">Guinea – Bissau (+245)</option>
                        <option value="592" data-countrycode="GY">Guyana (+592)</option>
                        <option value="509" data-countrycode="HT">Haiti (+509)</option>
                        <option value="504" data-countrycode="HN">Honduras (+504)</option>
                        <option value="852" data-countrycode="HK">Hong Kong (+852)</option>
                        <option value="36" data-countrycode="HU">Hungary (+36)</option>
                        <option value="354" data-countrycode="IS">Iceland (+354)</option>
                        <option value="91" data-countrycode="IN">India (+91)</option>
                        <option value="62" data-countrycode="ID">Indonesia (+62)</option>
                        <option value="98" data-countrycode="IR">Iran (+98)</option>
                        <option value="964" data-countrycode="IQ">Iraq (+964)</option>
                        <option value="353" data-countrycode="IE">Ireland (+353)</option>
                        <option value="972" data-countrycode="IL">Israel (+972)</option>
                        <option value="39" data-countrycode="IT">Italy (+39)</option>
                        <option value="1876" data-countrycode="JM">Jamaica (+1876)</option>
                        <option value="81" data-countrycode="JP">Japan (+81)</option>
                        <option value="962" data-countrycode="JO">Jordan (+962)</option>
                        <option value="7" data-countrycode="KZ">Kazakhstan (+7)</option>
                        <option value="254" data-countrycode="KE">Kenya (+254)</option>
                        <option value="686" data-countrycode="KI">Kiribati (+686)</option>
                        <option value="850" data-countrycode="KP">Korea North (+850)</option>
                        <option value="82" data-countrycode="KR">Korea South (+82)</option>
                        <option value="965" data-countrycode="KW">Kuwait (+965)</option>
                        <option value="996" data-countrycode="KG">Kyrgyzstan (+996)</option>
                        <option value="856" data-countrycode="LA">Laos (+856)</option>
                        <option value="371" data-countrycode="LV">Latvia (+371)</option>
                        <option value="961" data-countrycode="LB">Lebanon (+961)</option>
                        <option value="266" data-countrycode="LS">Lesotho (+266)</option>
                        <option value="231" data-countrycode="LR">Liberia (+231)</option>
                        <option value="218" data-countrycode="LY">Libya (+218)</option>
                        <option value="417" data-countrycode="LI">Liechtenstein (+417)</option>
                        <option value="370" data-countrycode="LT">Lithuania (+370)</option>
                        <option value="352" data-countrycode="LU">Luxembourg (+352)</option>
                        <option value="853" data-countrycode="MO">Macao (+853)</option>
                        <option value="389" data-countrycode="MK">Macedonia (+389)</option>
                        <option value="261" data-countrycode="MG">Madagascar (+261)</option>
                        <option value="265" data-countrycode="MW">Malawi (+265)</option>
                        <option value="60" data-countrycode="MY">Malaysia (+60)</option>
                        <option value="960" data-countrycode="MV">Maldives (+960)</option>
                        <option value="223" data-countrycode="ML">Mali (+223)</option>
                        <option value="356" data-countrycode="MT">Malta (+356)</option>
                        <option value="692" data-countrycode="MH">Marshall Islands (+692)</option>
                        <option value="596" data-countrycode="MQ">Martinique (+596)</option>
                        <option value="222" data-countrycode="MR">Mauritania (+222)</option>
                        <option value="269" data-countrycode="YT">Mayotte (+269)</option>
                        <option value="52" data-countrycode="MX">Mexico (+52)</option>
                        <option value="691" data-countrycode="FM">Micronesia (+691)</option>
                        <option value="373" data-countrycode="MD">Moldova (+373)</option>
                        <option value="377" data-countrycode="MC">Monaco (+377)</option>
                        <option value="976" data-countrycode="MN">Mongolia (+976)</option>
                        <option value="1664" data-countrycode="MS">Montserrat (+1664)</option>
                        <option value="212" data-countrycode="MA">Morocco (+212)</option>
                        <option value="258" data-countrycode="MZ">Mozambique (+258)</option>
                        <option value="95" data-countrycode="MN">Myanmar (+95)</option>
                        <option value="264" data-countrycode="NA">Namibia (+264)</option>
                        <option value="674" data-countrycode="NR">Nauru (+674)</option>
                        <option value="977" data-countrycode="NP">Nepal (+977)</option>
                        <option value="31" data-countrycode="NL">Netherlands (+31)</option>
                        <option value="687" data-countrycode="NC">New Caledonia (+687)</option>
                        <option value="64" data-countrycode="NZ">New Zealand (+64)</option>
                        <option value="505" data-countrycode="NI">Nicaragua (+505)</option>
                        <option value="227" data-countrycode="NE">Niger (+227)</option>
                        <option value="234" data-countrycode="NG">Nigeria (+234)</option>
                        <option value="683" data-countrycode="NU">Niue (+683)</option>
                        <option value="672" data-countrycode="NF">Norfolk Islands (+672)</option>
                        <option value="670" data-countrycode="NP">Northern Marianas (+670)</option>
                        <option value="47" data-countrycode="NO">Norway (+47)</option>
                        <option value="968" data-countrycode="OM">Oman (+968)</option>
                        <option value="680" data-countrycode="PW">Palau (+680)</option>
                        <option value="507" data-countrycode="PA">Panama (+507)</option>
                        <option value="675" data-countrycode="PG">Papua New Guinea (+675)</option>
                        <option value="595" data-countrycode="PY">Paraguay (+595)</option>
                        <option value="51" data-countrycode="PE">Peru (+51)</option>
                        <option value="63" data-countrycode="PH">Philippines (+63)</option>
                        <option value="48" data-countrycode="PL">Poland (+48)</option>
                        <option value="351" data-countrycode="PT">Portugal (+351)</option>
                        <option value="1787" data-countrycode="PR">Puerto Rico (+1787)</option>
                        <option value="974" data-countrycode="QA">Qatar (+974)</option>
                        <option value="262" data-countrycode="RE">Reunion (+262)</option>
                        <option value="40" data-countrycode="RO">Romania (+40)</option>
                        <option value="7" data-countrycode="RU">Russia (+7)</option>
                        <option value="250" data-countrycode="RW">Rwanda (+250)</option>
                        <option value="378" data-countrycode="SM">San Marino (+378)</option>
                        <option value="239" data-countrycode="ST">Sao Tome &amp; Principe (+239)</option>
                        <option value="966" data-countrycode="SA">Saudi Arabia (+966)</option>
                        <option value="221" data-countrycode="SN">Senegal (+221)</option>
                        <option value="381" data-countrycode="CS">Serbia (+381)</option>
                        <option value="248" data-countrycode="SC">Seychelles (+248)</option>
                        <option value="232" data-countrycode="SL">Sierra Leone (+232)</option>
                        <option value="65" data-countrycode="SG">Singapore (+65)</option>
                        <option value="421" data-countrycode="SK">Slovak Republic (+421)</option>
                        <option value="386" data-countrycode="SI">Slovenia (+386)</option>
                        <option value="677" data-countrycode="SB">Solomon Islands (+677)</option>
                        <option value="252" data-countrycode="SO">Somalia (+252)</option>
                        <option value="27" data-countrycode="ZA">South Africa (+27)</option>
                        <option value="34" data-countrycode="ES">Spain (+34)</option>
                        <option value="94" data-countrycode="LK">Sri Lanka (+94)</option>
                        <option value="290" data-countrycode="SH">St. Helena (+290)</option>
                        <option value="1869" data-countrycode="KN">St. Kitts (+1869)</option>
                        <option value="1758" data-countrycode="SC">St. Lucia (+1758)</option>
                        <option value="249" data-countrycode="SD">Sudan (+249)</option>
                        <option value="597" data-countrycode="SR">Suriname (+597)</option>
                        <option value="268" data-countrycode="SZ">Swaziland (+268)</option>
                        <option value="46" data-countrycode="SE">Sweden (+46)</option>
                        <option value="41" data-countrycode="CH">Switzerland (+41)</option>
                        <option value="963" data-countrycode="SI">Syria (+963)</option>
                        <option value="886" data-countrycode="TW">Taiwan (+886)</option>
                        <option value="7" data-countrycode="TJ">Tajikstan (+7)</option>
                        <option value="255" data-countrycode="TZ">Tanzania (+255)</option>
                        <option value="66" data-countrycode="TH">Thailand (+66)</option>
                        <option value="228" data-countrycode="TG">Togo (+228)</option>
                        <option value="676" data-countrycode="TO">Tonga (+676)</option>
                        <option value="1868" data-countrycode="TT">Trinidad &amp; Tobago (+1868)</option>
                        <option value="216" data-countrycode="TN">Tunisia (+216)</option>
                        <option value="90" data-countrycode="TR">Turkey (+90)</option>
                        <option value="7" data-countrycode="TM">Turkmenistan (+7)</option>
                        <option value="993" data-countrycode="TM">Turkmenistan (+993)</option>
                        <option value="1649" data-countrycode="TC">Turks &amp; Caicos Islands (+1649)</option>
                        <option value="688" data-countrycode="TV">Tuvalu (+688)</option>
                        <option value="256" data-countrycode="UG">Uganda (+256)</option>
                        <option value="44" data-countrycode="GB">UK (+44)</option>
                        <option value="380" data-countrycode="UA">Ukraine (+380)</option>
                        <option value="971" data-countrycode="AE">United Arab Emirates (+971)</option>
                        <option value="598" data-countrycode="UY">Uruguay (+598)</option>
                        <option value="1" data-countrycode="US">USA (+1)</option>
                        <option value="7" data-countrycode="UZ">Uzbekistan (+7)</option>
                        <option value="678" data-countrycode="VU">Vanuatu (+678)</option>
                        <option value="379" data-countrycode="VA">Vatican City (+379)</option>
                        <option value="58" data-countrycode="VE">Venezuela (+58)</option>
                        <option value="84" data-countrycode="VN">Vietnam (+84)</option>
                        <option value="84" data-countrycode="VG">Virgin Islands – British (+1284)</option>
                        <option value="84" data-countrycode="VI">Virgin Islands – US (+1340)</option>
                        <option value="681" data-countrycode="WF">Wallis &amp; Futuna (+681)</option>
                        <option value="969" data-countrycode="YE">Yemen (North)(+969)</option>
                        <option value="967" data-countrycode="YE">Yemen (South)(+967)</option>
                        <option value="260" data-countrycode="ZM">Zambia (+260)</option>
                        <option value="263" data-countrycode="ZW">Zimbabwe (+263)</option>
                        </select>
                        <label for="select1">Country Code</label>
                    </div>
                </div>';
                ?>
                
                <div class="col-md-12">
                    <div class="form-floating date" id="date3" data-target-input="nearest">
                        <input type="date" class="form-control bg-transparent datepicker-input" name="arrival" placeholder="Start Date" data-target="#date3" data-toggle="datepicker" required/>
                        <label for="datetime">Arrival Date</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating date" id="date4" data-target-input="nearest">
                        <input type="date" class="form-control bg-transparent datepicker-input" name="departure" placeholder="Start Date" data-target="#date4" data-toggle="datepicker" required/>
                        <label for="datetime">Departure Date</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating">
                        <select class="form-select bg-transparent" id="select1" name="adult" required>
                           <option value="0"> --Pick-- </option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="More than 10">More than 10</option>
                        </select>
                        <label for="select1">Number of Adult</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating">
                        <select class="form-select bg-transparent" id="select" name="children" required>
                            <option value="0"> --Pick-- </option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="More than 10">More than 10</option>
                        </select>
                        <label for="select1">Number of Children</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <textarea class="form-control bg-transparent" placeholder="Special Request" id="message" name="message" style="height: 100px"></textarea>
                        <label for="message">Special Request</label>
                    </div>
                </div>
                <div class="col-12">
                    <button  type="submit" name="enquire_package" class="btn btn-primary w-100 py-3">Book Now</button>
                </div>
        </form>                       
    </div>
</div>
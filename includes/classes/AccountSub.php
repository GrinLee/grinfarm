<?php
require_once("includes/config.php");


class AccountSub{

    public static function getAccountInfoBox(){




    }

    public static function getAddressContainer($data){

        $username = $data['username'];
        $phone = $data['phone'];
        $address = $data['address'];
        $address2 = $data['address2'];
        $city = $data['city'];
        $postal = $data['postal'];
        $country = $data['country'];
        $prov = $data['prov'];
        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $email = $data['email'];


        $html ='';
        $html .='<div class="div">
                    <p class="row pt r_f"><span>User Name:</span>&nbsp;&nbsp;</p>
                    <p class="row pv r_e"><span>'.$username.'</span></p>
                </div>
                <div>
                    <p class="row pt l_f"><span>phone:</span>&nbsp;&nbsp;</p>
                    <p class="row pv l_e"><span>'.$phone.'</span></p>
                </div>
                <div>
                    <p class="row pt l_f"><span>address:</span>&nbsp;&nbsp;</p>
                    <p class="row pv l_e"><span>'.$address.'</span></p>
                </div>
                <div>
                    <p class="row pt l_f"><span>address2:</span>&nbsp;&nbsp;</p>
                    <p class="row pv l_e"><span>'.$address2.'</span></p>
                </div>
                <div class="div">
                    <p class="row pt l_f"><span>city:</span>&nbsp;&nbsp;</p>
                    <p class="row pv l_s"><span>'.$city.'</span></p>
                </div>
                <div class="div">
                    <p class="row pt r_f"><span>postal:</span>&nbsp;&nbsp;</p>
                    <p class="row pv r_e"><span>'.$postal.'</span></p>
                </div>
                <div class="div">
                    <p class="row pt l_f"><span>country:</span>&nbsp;&nbsp;</p>
                    <p class="row pv l_s"><span>'.$country.'</span></p>
                </div>
                <div class="div">
                    <p class="row pt r_f"><span>province:</span>&nbsp;&nbsp;</p>
                    <p class="row pv r_e"><span>'.$prov.'</span></p>
                </div>';

        return $html;
    }



    public static function dobContainer(){

        $html ='';
        
        $year_start  = 1920;
        $year_end = date('Y'); // current Year
        $user_selected_year = 2000; // user date of birth year
        $html .= '<select class="form-input acc" id="year" name="year">'."\n";
        for ($i_year = $year_start; $i_year <= $year_end; $i_year++) {
            $selected = ($user_selected_year == $i_year ? ' selected' : '');
            $html .= '<option value="'.$i_year.'"'.$selected.'>'.$i_year.'</option>'."\n";
        }
        $html .= '</select>'."\n";


        $selected_day = 1; //current day
        $html .= '<select class="form-input acc" id="day" name="day">'."\n";
        for ($i_day = 1; $i_day <= 31; $i_day++) { 
            $selected = ($selected_day == $i_day ? ' selected' : '');
            $html .= '<option value="'.$i_day.'"'.$selected.'>'.$i_day.'</option>'."\n";
        }
        $html .= '</select>'."\n";

        $selected_month = date('m'); //current month
        $html .= '<select class="form-input acc" id="month" name="month">'."\n";
        for ($i_month = 1; $i_month <= 12; $i_month++) { 
            $selected = ($selected_month == $i_month ? ' selected' : '');
            $html .= '<option value="'.$i_month.'"'.$selected.'>'. date('M', mktime(0,0,0,$i_month)).'</option>'."\n";
        }
        $html .= '</select>'."\n";

        return $html;
    }



    public static function changePassword($data){

        $user = isset($data['username']) ? $data['username'] : '';

        $html ='';
        $html .='<div class="form-div acc">
                    <label>User Name</label>
                    <input type="text" class="form-input acc" value="'.$user.'" name="username" placeholder="Username" required />
                </div>

                <div class="form-div acc">
                    <label>Old Password</label>
                    <input type="password" class="form-input acc" name="oldpassword" placeholder="Old Password" required />
                </div>

                <div class="form-div acc">
                    <label>Password</label>

                    <input type="password" class="form-input acc" name="password" placeholder="Password" required />
                </div>

                <div class="form-div acc">
                    <label>Password Confirm</label>
                    <input type="password" class="form-input acc" name="password2" placeholder="Password Confirm" required />
                </div>
                
                <div class="form-div acc">
                    <input type="submit" class="btn" id="login-btn-pw" name="submitAcc" value="Change Password" />
                </div>';

        return $html;
    }


    public static function accountInfoCont($data){

        $username = $data['username'];
        $phone = $data['phone'];
        $address = $data['address'];
        $address2 = $data['address2'];
        $city = $data['city'];
        $postal = $data['postal'];
        $country = $data['country'];
        $prov = $data['prov'];
        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $email = $data['email'];

        $html ='';
        $html .='<table>
                <tbody>
                    <tr>
                        <td class="tbl pt l_f"><span>First Name:</span></td>
                        <td class="tbl pv l_s">'.$firstName.'</span></td>
                        <td class="tbl pt r_f"><span>Last Name:</span></td>
                        <td class="tbl pv r_e">'.$lastName.'</span></td>
                    </tr>
                    <tr>
                        <td class="tbl pt l_f"><span>Phone:</span></td>
                        <td class="tbl pv l_s"><span>'.$phone.'</span></td>
                        <td class="tbl pt r_f"><span>Email:</span></td>
                        <td class="tbl pv r_e"><span>'.$email.'</span></td>
                    </tr>
                    <tr>
                        <td class="tbl pt l_f"><span>Address:</span></td>
                        <td class="tbl pv l_e"><span>'.$address.'</span></td>
                    </tr>
                    <tr>
                        <td class="tbl pt l_f"><span>Address2:</span></td>
                        <td class="tbl pv l_e"><span>'.$address2.'</span></td>
                    </tr>
                    <tr>
                        <td class="tbl pt l_f"><span>City:</span></td>
                        <td class="tbl pv l_s"><span>'.$city.'</span></td>
                        <td class="tbl pt r_f"><span>Postal:</span></td>
                        <td class="tbl pv r_e"><span>'.$postal.'</span></td>
                    </tr>
                    <tr>
                        <td class="tbl pt l_f"><span>Country:</span></td>
                        <td class="tbl pv l_s"><span>'.$country.'</span></td>
                        <td class="tbl pt r_f"><span>Province:</span></td>
                        <td class="tbl pv r_e"><span>'.$prov.'</span></td>
                    </tr>
                </tbody>
            </table>';

        return $html;
    }


}

?>
<?php
include('outputjson.php');
include 'timezone.inc.php';
include_once 'AppManager.php';
$pm = AppManager::getPM();
$last_update = date("Y-m-d H:i:s", time());

ini_set("auto_detect_line_endings", true);

$unique = $_POST['UNIQ'];
$similar = $_POST['SIMILAR'];
$import = $_POST['IMPORTFILE'];
$foo = $_POST['FOO'];
$sum_leven = $_POST['SUM_LEVEN'];

$array_unique = array();
foreach ($unique as $uniq) {
    $array_unique[] = $uniq;
}
foreach ($similar as $similarr) {
    
}
$sensitivity = array();
foreach ($foo as $fo) {
    list($key, $value) = explode('=', $fo);
    $sensitivity[$key] = $value;
}

function t1($val, $min, $max) {
    return ($val >= $min && $val <= $max);
}

$count = array("contacts" => 0, "thrash" => 0, "dups" => 0, "manual_check" => 0, "manual_fix" => 0);

//$sensivity = (isset($_POST['SENSIVITY'])) ? $_POST['SENSIVITY'] : 0;
$data = (isset($_POST['DATA'])) ? $_POST['DATA'] : '';

for ($i = 0; $i < count($data); $i++) {
    $name = trim(strtoupper($data[$i]['name']));
    if ($name == '') {
        $name = NULL;
    }
    $surname = trim(strtoupper($data[$i]['surname']));
    if ($surname == '') {
        $surname = NULL;
    }
    $address = trim(strtoupper($data[$i]['address']));
    if ($address == '') {
        $address = NULL;
    }
    $suburb = trim(strtoupper($data[$i]['suburb']));
    if ($suburb == '') {
        $suburb = NULL;
    }
    $state = trim(strtoupper($data[$i]['state']));
    if ($state == '') {
        $state = NULL;
    }
    $zip = trim(strtoupper($data[$i]['zip']));
    if ($zip == '') {
        $zip = NULL;
    }
    $mobile = trim(strtoupper($data[$i]['mobile']));
//    if ($mobile == '') {
//        $mobile = NULL;
//    }
    $mobile2 = trim(strtoupper($data[$i]['mobile2']));
    if ($mobile2 == '') {
        $mobile2 = NULL;
    }
    $home_phone = trim(strtoupper($data[$i]['home_phone']));
    if ($home_phone == '') {
        $home_phone = NULL;
    }
    $home_phone2 = trim(strtoupper($data[$i]['home_phone2']));
    if ($home_phone2 == '') {
        $home_phone2 = NULL;
    }
    $business_phone = trim(strtoupper($data[$i]['business_phone']));
    if ($business_phone == '') {
        $business_phone = NULL;
    }
    $alt_phone = trim(strtoupper($data[$i]['alt_phone']));
    if ($alt_phone == '') {
        $alt_phone = NULL;
    }
    $business_name = trim(strtoupper($data[$i]['business_name']));
    if ($business_name == '') {
        $business_name = NULL;
    }
    $business_address = trim(strtoupper($data[$i]['business_address']));
    if ($business_address == '') {
        $business_address = NULL;
    }
    $business_zip = trim(strtoupper($data[$i]['bsuiness_zip']));
    if ($business_zip == '') {
        $business_zip = NULL;
    }
    $import = trim(strtoupper($import));
    if ($import == '') {
        $import = NULL;
    }
    //$import = strtoupper($data[$i]['import']);
    $output = trim(strtoupper($data[$i]['output']));
    if ($output == '') {
        $output = NULL;
    }
    $last_update = $last_update;
    //strtoupper($data[$i]['last_update']);
    $status = @trim(strtoupper($data[$i]['status']));
    if ($status == '') {
        $status = NULL;
    }
    $comments = @trim(strtoupper($data[$i]['comments']));
    if ($comments == '') {
        $comments = NULL;
    }
    $constultant = @trim(strtoupper($data[$i]['constultant']));
    if ($constultant == '') {
        $constultant = NULL;
    }
    $active = @trim(strtoupper($data[$i]['active']));
    if ($active == '') {
        $active = NULL;
    }

    $array_field['name'] = $name;
    $array_field['surname'] = $surname;
    $array_field['address'] = $address;
    $array_field['suburb'] = $suburb;
    $array_field['state'] = $state;
    $array_field['zip'] = $zip;
    $array_field['mobile'] = $mobile;
    $array_field['mobile2'] = $mobile2;
    $array_field['home_phone'] = $home_phone;
    $array_field['home_phone2'] = $home_phone2;
    $array_field['business_phone'] = $business_phone;
    $array_field['alt_phone'] = $alt_phone;

    // check for insert thrash

    function is_phone($mobile) {
        $mobile = trim($mobile);
        $findDigit = '/^\d{9}$/';
        if (preg_match($findDigit, $mobile)) {
            return true;
        } else {
            return false;
        }
    }

    function least_phone($mobile, $home_phone, $business_phone, $alt_phone) {
        $findDigit = '/^\d{9}$/';

        if (!preg_match($findDigit, $mobile) && !preg_match($findDigit, $home_phone) && !preg_match($findDigit, $business_phone) && !preg_match($findDigit, $alt_phone)) {
            return false;
        } else {
            return true;
        }
    }

    function least_name($name, $surname) {

        if ($name == '' || $surname == '') {
            return true;
        } else {
            return false;
        }
    }

    if (least_name($name, $surname) || !least_phone($mobile, $home_phone, $business_phone, $alt_phone)) {
        // insert into thrash table
//        $query = "INSERT INTO thrash (`name`, `surname`, `address`, `suburb`, `state`, `zip`, `mobile`, `mobile2`, `home_phone`, `home_phone2`, `business_phone`, `alt_phone`, `business_name`, `business_address`, `business_zip`, `import`, `output`, `last_update`, `status`, `comments`, `constultant`, `active`)";
//        $query .= " VALUES ('".$name."','".$surname."', '".$address."', '".$suburb."', '";
//        $query .= $state ."', '".$zip."', '".$mobile."','".$mobile2."','".$home_phone."','".$home_phone2."','".$business_phone."','" .$alt_phone."', '".$business_name."', '".$business_address."','".$business_zip."','".$import."','".$output."','".$last_update."','" .$status."','".$comments."','".$constultant."','".$active."')";
//        $result = mysql_query($query) or die("Insert Thrash Error 1: " . mysql_error());
        $param = array(":name" => $name, ":surname" => $surname, ":address" => $address, ":suburb" => $suburb, ":state" => $state, ":zip" => $zip, ":mobile" => $mobile, ":mobile2" => $mobile2, ":home_phone" => $home_phone, ":home_phone2" => $home_phone2, ":business_phone" => $business_phone, ":alt_phone" => $alt_phone, ":business_name" => $business_name, ":business_address" => $business_address, ":business_zip" => $business_zip, ":import" => $import, ":output" => $output, ":last_update" => $last_update, ":status" => $status, ":comments" => $comments, ":constultant" => $constultant, ":active" => $active);
        $pm->run("INSERT INTO thrash(`name`, `surname`, `address`, `suburb`, `state`, `zip`, `mobile`, `mobile2`, `home_phone`, `home_phone2`, `business_phone`, `alt_phone`, `business_name`, `business_address`, `business_zip`, `import`, `output`, `last_update`, `status`, `comments`, `constultant`, `active`) 
                VALUES(:name, :surname , :address, :suburb, :state, :zip, :mobile, :mobile2, :home_phone, :home_phone2, :business_phone, :alt_phone, :business_name, :business_address, :business_zip, :import, :output, :last_update, :status, :comments, :constultant, :active)", $param);
        $count['thrash']++;
    } else {
        if (($mobile < 400000000 || $mobile > 499999999) && (is_phone($mobile))) {
            if (trim($home_phone) == '') {
                $home_phone = $mobile;
                $mobile = '';
                $array_field['mobile'] = '';
            } elseif (trim($home_phone2) == '') {
                $home_phone2 = $mobile;
                $mobile = '';
                $array_field['mobile'] = '';
            } elseif (trim($alt_phone) == '') {
                $alt_phone = $mobile;
                $mobile = '';
                $array_field['mobile'] = '';
            } else {

//                $query = "INSERT INTO manual_fix (`name`, `surname`, `address`, `suburb`, `state`, `zip`, `mobile`, `mobile2`, `home_phone`, `home_phone2`, `business_phone`, `alt_phone`, `business_name`, `business_address`, `business_zip`, `import`, `output`, `last_update`, `status`, `comments`, `constultant`, `active`)";
//        $query .= " VALUES ('".$name."','".$surname."', '".$address."', '".$suburb."', '";
//        $query .= $state ."', '".$zip."', '".$mobile."','".$mobile2."','".$home_phone."','".$home_phone2."','".$business_phone."','" .$alt_phone."', '".$business_name."', '".$business_address."','".$business_zip."','".$import."','".$output."','".$last_update."','" .$status."','".$comments."','".$constultant."','".$active."')";
//        $result = mysql_query($query) or die("Insert Thrash Error 1: " . mysql_error());
                $param = array(":name" => $name, ":surname" => $surname, ":address" => $address, ":suburb" => $suburb, ":state" => $state, ":zip" => $zip, ":mobile" => $mobile, ":mobile2" => $mobile2, ":home_phone" => $home_phone, ":home_phone2" => $home_phone2, ":business_phone" => $business_phone, ":alt_phone" => $alt_phone, ":business_name" => $business_name, ":business_address" => $business_address, ":business_zip" => $business_zip, ":import" => $import, ":output" => $output, ":last_update" => $last_update, ":status" => $status, ":comments" => $comments, ":constultant" => $constultant, ":active" => $active);
                $pm->run("INSERT INTO manual_fix(`name`, `surname`, `address`, `suburb`, `state`, `zip`, `mobile`, `mobile2`, `home_phone`, `home_phone2`, `business_phone`, `alt_phone`, `business_name`, `business_address`, `business_zip`, `import`, `output`, `last_update`, `status`, `comments`, `constultant`, `active`) 
                VALUES(:name, :surname , :address, :suburb, :state, :zip, :mobile, :mobile2, :home_phone, :home_phone2, :business_phone, :alt_phone, :business_name, :business_address, :business_zip, :import, :output, :last_update, :status, :comments, :constultant, :active)", $param);
                $count['manual_fix']++;
                continue;
            }
        }
        if (($home_phone > 400000000 && $home_phone < 499999999) && (is_phone($home_phone))) {
            if (trim($mobile) == '') {
                $mobile = $home_phone;
                $home_phone = NULL;
                $array_field['home_phone'] = NULL;
            } elseif (trim($mobile2) == '') {
                $mobile2 = $home_phone;
                $home_phone = NULL;
                $array_field['home_phone'] = NULL;
            } elseif (trim($alt_phone) == '') {
                $alt_phone = $home_phone;
                $home_phone = NULL;
                $array_field['home_phone'] = NULL;
            } else {

                $param = array(":name" => $name, ":surname" => $surname, ":address" => $address, ":suburb" => $suburb, ":state" => $state, ":zip" => $zip, ":mobile" => $mobile, ":mobile2" => $mobile2, ":home_phone" => $home_phone, ":home_phone2" => $home_phone2, ":business_phone" => $business_phone, ":alt_phone" => $alt_phone, ":business_name" => $business_name, ":business_address" => $business_address, ":business_zip" => $business_zip, ":import" => $import, ":output" => $output, ":last_update" => $last_update, ":status" => $status, ":comments" => $comments, ":constultant" => $constultant, ":active" => $active);
                $pm->run("INSERT INTO manual_fix(`name`, `surname`, `address`, `suburb`, `state`, `zip`, `mobile`, `mobile2`, `home_phone`, `home_phone2`, `business_phone`, `alt_phone`, `business_name`, `business_address`, `business_zip`, `import`, `output`, `last_update`, `status`, `comments`, `constultant`, `active`) 
                VALUES(:name, :surname , :address, :suburb, :state, :zip, :mobile, :mobile2, :home_phone, :home_phone2, :business_phone, :alt_phone, :business_name, :business_address, :business_zip, :import, :output, :last_update, :status, :comments, :constultant, :active)", $param);
                $count['manual_fix']++;
                continue;
            }
        }

        $loop_count = 0;
        foreach ($array_unique as $arr_uniq) {

            if ($loop_count == 0) {
                $uniqstr = ' (' . $arr_uniq . '="' . addslashes($array_field[$arr_uniq]) . '" or ' . $arr_uniq . '="" or ' . $arr_uniq . ' IS NULL) and';
            } else {
                $uniqstr .= ' (' . $arr_uniq . '="' . addslashes($array_field[$arr_uniq]) . '" or ' . $arr_uniq . '="" or ' . $arr_uniq . ' IS NULL) and';
            }
            $loop_count++;
        }

        // insert into thrash table
        // insert contacts, manual_check or dups table
        // search for identical records in the contacts table so insert into the dups table
//        $query = "SELECT id FROM contacts WHERE name='" . $name . "' AND surname='"
//                . $surname . "' AND address='" . $address . "' AND mobile=" . $mobile;
        $query = 'select id from contacts where ' . $uniqstr . ' 1=1';
        $count_id = $pm->num_row($query);

        if ($count_id > 0) {
            $param = array(":name" => $name, ":surname" => $surname, ":address" => $address, ":suburb" => $suburb, ":state" => $state, ":zip" => $zip, ":mobile" => $mobile, ":mobile2" => $mobile2, ":home_phone" => $home_phone, ":home_phone2" => $home_phone2, ":business_phone" => $business_phone, ":alt_phone" => $alt_phone, ":business_name" => $business_name, ":business_address" => $business_address, ":business_zip" => $business_zip, ":import" => $import, ":output" => $output, ":last_update" => $last_update, ":status" => $status, ":comments" => $comments, ":constultant" => $constultant, ":active" => $active);
            $pm->run("INSERT INTO dups(`name`, `surname`, `address`, `suburb`, `state`, `zip`, `mobile`, `mobile2`, `home_phone`, `home_phone2`, `business_phone`, `alt_phone`, `business_name`, `business_address`, `business_zip`, `import`, `output`, `last_update`, `status`, `comments`, `constultant`, `active`) 
                VALUES(:name, :surname , :address, :suburb, :state, :zip, :mobile, :mobile2, :home_phone, :home_phone2, :business_phone, :alt_phone, :business_name, :business_address, :business_zip, :import, :output, :last_update, :status, :comments, :constultant, :active)", $param);

            $count['dups']++;
        } // dups table
        else {
            // search similar records in the contacts table so insert into the manual_check
            // create a function levenshtein which calculates the distances between two strings.
            $query = "SHOW FUNCTION STATUS like 'levenshtein'";
            //$result = mysql_query($query) or die("Mysql error:" . mysql_error());
            $count_func = $pm->num_row($query);
            if ($count_func == 0) {
                // the function doesn't exists
                $query = "CREATE FUNCTION levenshtein( s1 VARCHAR(255), s2 VARCHAR(255) ) \n"
                        . "RETURNS INT \n"
                        . "DETERMINISTIC \n"
                        . "BEGIN \n"
                        . "DECLARE s1_len, s2_len, i, j, c, c_temp, cost INT; \n"
                        . "DECLARE s1_char CHAR; \n"
                        . "-- max strlen=255 \n"
                        . "DECLARE cv0, cv1 VARBINARY(256); \n"
                        . "SET s1_len = CHAR_LENGTH(s1), s2_len = CHAR_LENGTH(s2), cv1 = 0x00, j = 1, i = 1, c = 0; \n"
                        . "IF s1 = s2 THEN \n"
                        . "  RETURN 0; \n"
                        . "ELSEIF s1_len = 0 THEN \n"
                        . "RETURN s2_len; \n"
                        . "ELSEIF s2_len = 0 THEN \n"
                        . "RETURN s1_len; \n"
                        . "ELSE \n"
                        . "WHILE j <= s2_len DO \n"
                        . "SET cv1 = CONCAT(cv1, UNHEX(HEX(j))), j = j + 1; \n"
                        . "END WHILE; \n"
                        . "WHILE i <= s1_len DO \n"
                        . "SET s1_char = SUBSTRING(s1, i, 1), c = i, cv0 = UNHEX(HEX(i)), j = 1; \n"
                        . "WHILE j <= s2_len DO \n"
                        . "SET c = c + 1; \n"
                        . "IF s1_char = SUBSTRING(s2, j, 1) THEN  \n"
                        . "SET cost = 0; ELSE SET cost = 1; \n"
                        . "END IF; \n"
                        . "SET c_temp = CONV(HEX(SUBSTRING(cv1, j, 1)), 16, 10) + cost; \n"
                        . "IF c > c_temp THEN SET c = c_temp; END IF; \n"
                        . "SET c_temp = CONV(HEX(SUBSTRING(cv1, j+1, 1)), 16, 10) + 1; \n"
                        . "IF c > c_temp THEN  \n"
                        . "SET c = c_temp;  \n"
                        . "END IF; \n"
                        . "SET cv0 = CONCAT(cv0, UNHEX(HEX(c))), j = j + 1; \n"
                        . "END WHILE; \n"
                        . "SET cv1 = cv0, i = i + 1; \n"
                        . "END WHILE; \n"
                        . "END IF; \n"
                        . "	RETURN c; \n"
                        . "END";
                $pm->run_other($query);
            }

//            $query = "SELECT id FROM contacts WHERE ";
//
//            $query .="((((name='" . $name . "') + (surname='" . $surname . "') + "
//                    . "(address = '" . $address . "') + (mobile='" . $mobile . "')) >= 2) && ";
//
//            $query .="(((levenshtein(name, '" . $name . "') <= " . $sensivity . ") + ";
//            $query .="(levenshtein(surname, '" . $surname . "') <= " . $sensivity . ") + ";
//            $query .="(levenshtein(address, '" . $address . "') <= " . $sensivity . ") + ";
//            $query .="(levenshtein(mobile, '" . $mobile . "') <= " . $sensivity . ")) > 2)) = 1 ";
//            $sql1 = "SELECT id FROM contacts WHERE (((";
//            $que1 = "((";
            $sql1 = "SELECT id, (";
            $que1 = "((";
            foreach ($similar as $simi) {
                if($array_field[$simi]=="" || $array_field[$simi]==NULL){continue;}
                $que1 .="($simi='" . $array_field[$simi] . "' AND $simi!='0') +";
                $sql1 .="IF((levenshtein($simi, '" . $array_field[$simi] . "') <= " . $sensitivity[$simi] . " AND $simi !=0 AND $simi is not null AND $simi!=''),levenshtein($simi, '" . $array_field[$simi] . "'),'0') +";
            }


            $sql2 = "(1=2)) as leven from contacts where";
            $que2 = "(1=2)) >= 2)=1 ";
            $que3 = "having leven>0 and leven<=$sum_leven";


            $query = $sql1 . $sql2 . $que1 . $que2 . $que3;
            
            $result = $pm->num_row($query);
            if ($result > 0) {
                // found similar records in the contacts table
                // Ok. Insert into manual_check
//                $query = "INSERT INTO manual_check (name, surname, address, suburb, state, zip, mobile, alt_phone, home_phone)";
//                $query .= " VALUES ('" . $name . "', '" . $surname . "', '" . $address . "', '" . $suburb . "', '";
//                $query .= $state . "', '" . $zip . "', '" . $mobile . "', '" . $alt_phone . "', '" . $home_phone . "');";
//                $result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
                $param = array(":name" => $name, ":surname" => $surname, ":address" => $address, ":suburb" => $suburb, ":state" => $state, ":zip" => $zip, ":mobile" => $mobile, ":mobile2" => $mobile2, ":home_phone" => $home_phone, ":home_phone2" => $home_phone2, ":business_phone" => $business_phone, ":alt_phone" => $alt_phone, ":business_name" => $business_name, ":business_address" => $business_address, ":business_zip" => $business_zip, ":import" => $import, ":output" => $output, ":last_update" => $last_update, ":status" => $status, ":comments" => $comments, ":constultant" => $constultant, ":active" => $active);
                $pm->run("INSERT INTO manual_check(`name`, `surname`, `address`, `suburb`, `state`, `zip`, `mobile`, `mobile2`, `home_phone`, `home_phone2`, `business_phone`, `alt_phone`, `business_name`, `business_address`, `business_zip`, `import`, `output`, `last_update`, `status`, `comments`, `constultant`, `active`) 
                VALUES(:name, :surname , :address, :suburb, :state, :zip, :mobile, :mobile2, :home_phone, :home_phone2, :business_phone, :alt_phone, :business_name, :business_address, :business_zip, :import, :output, :last_update, :status, :comments, :constultant, :active)", $param);
                $count['manual_check']++;
            } //manual_check table
            else {
                // Insert into the contacts table
//                $query = "INSERT INTO contacts (name, surname, address, suburb, state, zip, mobile, alt_phone, home_phone)";
//                $query .= " VALUES ('" . $name . "', '" . $surname . "', '" . $address . "', '" . $suburb . "', '";
//                $query .= $state . "', '" . $zip . "', '" . $mobile . "', '" . $alt_phone . "', '" . $home_phone . "');";
//                $result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
                $param = array(":name" => $name, ":surname" => $surname, ":address" => $address, ":suburb" => $suburb, ":state" => $state, ":zip" => $zip, ":mobile" => $mobile, ":mobile2" => $mobile2, ":home_phone" => $home_phone, ":home_phone2" => $home_phone2, ":business_phone" => $business_phone, ":alt_phone" => $alt_phone, ":business_name" => $business_name, ":business_address" => $business_address, ":business_zip" => $business_zip, ":import" => $import, ":output" => $output, ":last_update" => $last_update, ":status" => $status, ":comments" => $comments, ":constultant" => $constultant, ":active" => $active);
                $pm->run("INSERT INTO contacts(`name`, `surname`, `address`, `suburb`, `state`, `zip`, `mobile`, `mobile2`, `home_phone`, `home_phone2`, `business_phone`, `alt_phone`, `business_name`, `business_address`, `business_zip`, `import`, `output`, `last_update`, `status`, `comments`, `constultant`, `active`) 
                VALUES(:name, :surname , :address, :suburb, :state, :zip, :mobile, :mobile2, :home_phone, :home_phone2, :business_phone, :alt_phone, :business_name, :business_address, :business_zip, :import, :output, :last_update, :status, :comments, :constultant, :active)", $param);
                $count['contacts']++;
            }
        } // thrash table
    }
}
outputJSON($count, "success")
?>
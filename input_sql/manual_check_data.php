<?php

set_time_limit(0);
session_start();
include 'timezone.inc.php';
$user = $_SESSION['username'];
$date = date("Y-m-d H:i:s", time());
include_once 'AppManager.php';
$pm = AppManager::getPM();

// get data and store in a json array
$method = $_POST['method'];


switch ($method) {
    case "getsimilar":
        // pop from the manual_check table and insert into contacts table
        if (isset($_POST['id'])) {
            // add function levenshtein if doesn't exist
            $query = "SHOW FUNCTION STATUS like 'levenshtein'";
            $count_func = $pm->num_row($query);
            if ($count_func == 0) {
//                        
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

            // get item from the manual_check table
            $id = $_POST['id'];
            if (!array_key_exists($id, $_SESSION['session_data'])) {
                $query = "SELECT * FROM manual_check WHERE id = $id";
                $rows = $pm->run($query);

                // select similars records from the contacts table.

                $sql = "SELECT * , IF(name != ''  AND name is not null,levenshtein(name, '" . $rows[0]['name'] . "'),'0') + IF(surname !='' AND surname is not null,levenshtein(surname, '" . $rows[0]['surname'] . "'),'0') + IF(address !='' AND address is not null,levenshtein(address, '" . $rows[0]['address'] . "'),'0') + IF(mobile !=0 AND mobile is not null,levenshtein(mobile, '" . $rows[0]['mobile'] . "'),'0') as diff ";
               
                $sql .= "FROM contacts ";
                $sql.="where ((name='" .  $rows[0]['name'] . "' AND name !='' AND name is not null) + (surname='" . $rows[0]['surname'] . "' AND surname !='' AND surname is not null) + (address = '" . $rows[0]['address'] . "' AND address !='' AND address is not null)+(suburb = '" . $rows[0]['suburb'] . "' AND suburb !='' AND suburb is not null) +(zip = '" . $rows[0]['zip'] . "' AND zip !='' AND zip is not null )+(state  = '" . $rows[0]['state'] . "' AND state !='' AND state is not null)+ (mobile='" .$rows[0]['mobile'] . "' AND mobile!='0' ) >= 2)";
                $sql .= "ORDER BY diff ";
                $sql .= "LIMIT 10";

                $result = $pm->run($sql);

                $total_rows = 0;
                foreach ($result as $row) {

                    $persons[] = array(
                        'id' => $row['id'],
                        'name' => $row['name'],
                        'surname' => $row['surname'],
                        'address' => $row['address'],
                        'suburb' => $row['suburb'],
                        'state' => $row['state'],
                        'zip' => $row['zip'],
                        'mobile' => $row['mobile'],
                        'alt_phone' => $row['alt_phone'],
                        'home_phone' => $row['home_phone'],
                        'diff' => $row['diff'],
                        'par_id' => $id,
                    );
                    $total_rows++;
                }

                $data[] = array(
                    'TotalRows' => $total_rows,
                    'Rows' => $persons
                );
            } else {

                $persons = $_SESSION['session_data'][$id];
                // print_r($persons);
                $total_rows = count($persons);
                $data[] = array(
                    'TotalRows' => $total_rows,
                    'Rows' => $persons
                );
            }


            header('Content-Type: application/json');
            echo json_encode($data);
        }
        break;
//    case "totalrows":
//        $sql = "SELECT FOUND_ROWS() AS `found_rows`;";
//        $rows = mysql_query($sql);
//        $rows = mysql_fetch_assoc($rows);
//        $total_rows = $rows['found_rows'];
//        break;

    case "acceptrow":

        // pop from the manual_check table and insert into contacts table
        if (isset($_POST['id'])) {
            $id = $_POST['id'];

            $query = "SELECT * FROM manual_check WHERE id = $id";
            $result = $pm->run($query);
            $value = $result[0];

            $history_data = serialize($result);


            $param = array(":name" => $value['name'], ":surname" => $value['surname'], ":address" => $value['address'], ":suburb" => $value['suburb'], ":state" => $value['state'], ":zip" => $value['zip'], ":mobile" => $value['mobile'], ":mobile2" => $value['mobile2'], ":home_phone" => $value['home_phone'], ":home_phone2" => $value['home_phone2'], ":business_phone" => $value['business_phone'], ":alt_phone" => $value['alt_phone'], ":business_name" => $value['business_name'], ":business_address" => $value['business_address'], ":business_zip" => $value['business_zip'], ":import" => $value['import'], ":output" => $value['output'], ":last_update" => $date, ":status" => $value['status'], ":comments" => $value['comments'], ":constultant" => $value['constultant'], ":active" => $value['active']);
            $last_insert_id = $pm->insertAndGetLastRowId("INSERT INTO contacts(`name`, `surname`, `address`, `suburb`, `state`, `zip`, `mobile`, `mobile2`, `home_phone`, `home_phone2`, `business_phone`, `alt_phone`, `business_name`, `business_address`, `business_zip`, `import`, `output`, `last_update`, `status`, `comments`, `constultant`, `active`) 
                VALUES(:name, :surname , :address, :suburb, :state, :zip, :mobile, :mobile2, :home_phone, :home_phone2, :business_phone, :alt_phone, :business_name, :business_address, :business_zip, :import, :output, :last_update, :status, :comments, :constultant, :active)", $param);

            $sql = "DELETE FROM manual_check where id=$id";
            $pm->run($sql);

            $sql2 = "INSERT INTO history(`from_table`, `type`, `data`, `user`, `update_date`,last_insert_id)
                VALUES('manual','accept','$history_data','$user','$date','$last_insert_id')";
            $pm->run($sql2);
            $data[] = array(
                "result" => "success"
            );
            header('Content-Type: application/json');
            echo json_encode($data);
        }
        break;
    case "rejectrow":
        // pop from the manual_check table and insert into dups table
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $query = "SELECT * FROM manual_check WHERE id = $id";

            $result = $pm->run($query);
            $value = $result[0];
            $history_data = serialize($result);


            $param = array(":name" => $value['name'], ":surname" => $value['surname'], ":address" => $value['address'], ":suburb" => $value['suburb'], ":state" => $value['state'], ":zip" => $value['zip'], ":mobile" => $value['mobile'], ":mobile2" => $value['mobile2'], ":home_phone" => $value['home_phone'], ":home_phone2" => $value['home_phone2'], ":business_phone" => $value['business_phone'], ":alt_phone" => $value['alt_phone'], ":business_name" => $value['business_name'], ":business_address" => $value['business_address'], ":business_zip" => $value['business_zip'], ":import" => $value['import'], ":output" => $value['output'], ":last_update" => $date, ":status" => $value['status'], ":comments" => $value['comments'], ":constultant" => $value['constultant'], ":active" => $value['active']);
            $last_insert_id = $pm->insertAndGetLastRowId("INSERT INTO dups(`name`, `surname`, `address`, `suburb`, `state`, `zip`, `mobile`, `mobile2`, `home_phone`, `home_phone2`, `business_phone`, `alt_phone`, `business_name`, `business_address`, `business_zip`, `import`, `output`, `last_update`, `status`, `comments`, `constultant`, `active`) 
                VALUES(:name, :surname , :address, :suburb, :state, :zip, :mobile, :mobile2, :home_phone, :home_phone2, :business_phone, :alt_phone, :business_name, :business_address, :business_zip, :import, :output, :last_update, :status, :comments, :constultant, :active)", $param);


            $sql = "DELETE FROM manual_check where id=$id";
            $pm->run($sql);

            $sql2 = "INSERT INTO history(`from_table`, `type`, `data`, `user`, `update_date`,last_insert_id)
                VALUES('manual','reject','$history_data','$user','$date','$last_insert_id')";
            $pm->run($sql2);

            $data[] = array(
                "result" => "success"
            );
            header('Content-Type: application/json');
            echo json_encode($data);
        }
        break;
    case "deleterow":
        // pop from the manual_check
        if (isset($_POST['id'])) {
            $id = $_POST['id'];

            $query = "SELECT * FROM manual_check WHERE id = $id";
            $result = $pm->run($query);
            $history_data = serialize($result);

            $sql = "DELETE FROM manual_check where id=$id";
            $result = $pm->run($sql);

            $sql2 = "INSERT INTO history(`from_table`, `type`, `data`, `user`, `update_date`)
                VALUES('manual','delete','$history_data','$user','$date')";
            $result = $pm->run($sql2);
            $data[] = array(
                "result" => "success"
            );
            header('Content-Type: application/json');
            echo json_encode($data);
        }
        break;
    case "getdata":

        if (isset($_POST['start']) && isset($_POST['count'])) {
            $start = $_POST['start'];
            $count = $_POST['count'];

            $query = "SELECT  * FROM manual_check LIMIT $start, $count";
            $result = $pm->run($query);


            $sql = "SELECT count(id) as grandtotal from manual_check";
            // echo $sql2 = "SELECT count(1) AS found_rows from manual_check LIMIT $start,$count;";
            //$rows = mysql_query($sql);
            $rows = $pm->run($sql);
            $grandtotal = $rows[0]['grandtotal'];
            //$rows = mysql_fetch_assoc($rows);
            $total_rows = count($result);

            $persons = null;

            foreach ($result as $row) {

                $persons[] = array(
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'surname' => $row['surname'],
                    'address' => $row['address'],
                    'suburb' => $row['suburb'],
                    'state' => $row['state'],
                    'zip' => $row['zip'],
                    'mobile' => $row['mobile'],
                    'alt_phone' => $row['alt_phone'],
                    'home_phone' => $row['home_phone'],
                );
            }

            $data[] = array(
                'TotalRows' => $total_rows,
                'GrandTotal' => $grandtotal,
                'Rows' => $persons
            );
            header('Content-Type: application/json');
            echo json_encode($data);
        }
        break;
}
?>
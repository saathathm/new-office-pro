<?php
session_start();
include_once 'AppManager.php';
$pm = AppManager::getPM();

// get data and store in a json array
$method = $_POST['method'];


switch ($method) {

    case "getdata":
        $_SESSION['session_data'] = array();
        if (isset($_POST['start']) && isset($_POST['count'])) {
            $start = $_POST['start'];
            $count = $_POST['count'];
            $query = "SELECT SQL_CALC_FOUND_ROWS * FROM manual_check LIMIT $start, $count";
            $result_can = $pm->run($query);
           
            $sql = "SELECT FOUND_ROWS() AS 'found_rows';";
            $rows = $pm->run($sql);
            $total_rows = $rows[0]['found_rows'];

            foreach ($result_can as $row_can) {

                $id = $row_can['id'];

                $query = "SELECT * FROM manual_check WHERE id = $id";
                $rows = $pm->run($query);

                // select similars records from the contacts table.
//                $sql = "SELECT * , (levenshtein(name, '" . $rows[0]['name'] . "') + levenshtein(surname, '" . $rows[0]['surname'] . "') + "
//                        . "levenshtein(address, '" . $rows[0]['address'] . "') + IF(mobile='0' ,levenshtein(mobile,'0'),levenshtein(mobile, '" . $rows[0]['mobile'] . "'))) as diff ";
                $sql = "SELECT * , IF(name != ''  AND name is not null,levenshtein(name, '" . $rows[0]['name'] . "'),'0') + IF(surname !='' AND surname is not null,levenshtein(surname, '" . $rows[0]['surname'] . "'),'0') + IF(address !='' AND address is not null,levenshtein(address, '" . $rows[0]['address'] . "'),'0') + IF(mobile !=0 AND mobile is not null,levenshtein(mobile, '" . $rows[0]['mobile'] . "'),'0') as diff ";
                $sql .= "FROM contacts ";
                $sql.="where ((name='" .  $rows[0]['name'] . "' AND name !='' AND name is not null) + (surname='" . $rows[0]['surname'] . "' AND surname !='' AND surname is not null) + (address = '" . $rows[0]['address'] . "' AND address !='' AND address is not null)+(suburb = '" . $rows[0]['suburb'] . "' AND suburb !='' AND suburb is not null) +(zip = '" . $rows[0]['zip'] . "' AND zip !='' AND zip is not null )+(state  = '" . $rows[0]['state'] . "' AND state !='' AND state is not null)+ (mobile='" .$rows[0]['mobile'] . "' AND mobile!='0' ) >= 2)";
                $sql .= "ORDER BY diff ";
                $sql .= "LIMIT 10";
                echo $sql;
                $result = $pm->run($sql);

                $total_rows = 0;

                $person = null;
                foreach ($result as $row) {

                    $person[] = array(
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
                $_SESSION['session_data'][$id] = $person;
            }

            
            $data[] = array(
                'TotalRows' => count($_SESSION['session_data'][$id]),
                'Rows' => $_SESSION['session_data']
            );
            header('Content-Type: application/json');
            echo json_encode($data);
        }
        break;
}
?>
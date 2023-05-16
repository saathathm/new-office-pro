<?php
session_start();
include_once 'AppManager.php';
$pm = AppManager::getPM();

// get data and store in a json array
$method = $_POST['method'];


switch ($method) {
    
    case "getdata":
$_SESSION['session_data2'] = array();
        if (isset($_POST['start']) && isset($_POST['count'])) {
            $start = $_POST['start'];
            $count = $_POST['count'];
            
            $query = "SELECT SQL_CALC_FOUND_ROWS * FROM manual_check2 LIMIT $start, $count";
            $result_can = $pm->run($query);
            $sql = "SELECT FOUND_ROWS() AS 'found_rows';";
            $rows = $pm->run($sql);
            $total_rows = $rows[0]['found_rows'];
 
        
 
            foreach ($result_can as $row_can) {
   
                $id = $row_can['id'];
               
                $query = "SELECT * FROM manual_check2 WHERE id = $id";
            $rows = $pm->run($query);
            
//            $sql = "SELECT * , (levenshtein(name, '" . $rows[0]['name'] . "') + levenshtein(surname, '" . $rows[0]['surname'] . "') + "
//                    . "levenshtein(address, '" . $rows[0]['address'] . "') + levenshtein(mobile, '" . $rows[0]['mobile'] . "')) as diff ";
//            $sql .= "FROM contacts ";
//              $sql.="where ((name='" .  $rows[0]['name'] . "') + (surname='" . $rows[0]['surname'] . "') + (address = '" . $rows[0]['address'] . "')+(suburb = '" . $rows[0]['suburb'] . "') +(zip = '" . $rows[0]['zip'] . "')+(state  = '" . $rows[0]['state'] . "')+ (mobile='" .$rows[0]['mobile'] . "' AND mobile!='0') >= 2)";
//            $sql .= "ORDER BY diff ";
//            $sql .= "LIMIT 10";
//              
//            $result = $pm->run($sql);
             $sql = "SELECT * FROM rec_move WHERE from_table='contacts' AND `to`='$id'";
                $result = $pm->run($sql);
                $contact_id = $result[0]['from'];
                $sql = "SELECT * FROM contacts WHERE id='$contact_id'";
                $result = $pm->run($sql);
            $total_rows = 0;
         
           $person =null;
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
                    'business_phone' => $row['business_phone'],
                        'status' => $row['status'],
                        'comments' => $row['comments'],
                        'constultant' => $row['constultant'],
                    //'diff' => $row['diff'],
                    'par_id' => $id,
                );
                $total_rows++;
                
            }
            $_SESSION['session_data2'][$id] = $person;
            
            }
              
            $data[] = array(
                'TotalRows' => $total_rows,
                'Rows' => $_SESSION['session_data2']
            );
            header('Content-Type: application/json');
            echo json_encode($data);
        }
        break;
}
?>
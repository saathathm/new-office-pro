<?php
session_start();
set_time_limit(0);
include 'timezone.inc.php';
$date = date("Y-m-d H:i:s", time());
$user = $_SESSION['username'];
include_once 'AppManager.php';
$pm = AppManager::getPM();
if (isset($_POST['method']) && $_POST['method'] == 'undo') {
    $sql = "SELECT * FROM history WHERE user='$user' AND from_table='manual2' ORDER BY id  DESC LIMIT 1";
    $result = $pm->run($sql);
    if (count($result) != 0) {

        $value = unserialize($result[0]['data']);
        $value = $value[0];
        $type = $result[0]['type'];
        $id = $result[0]['id'];
        $last_insert_id = $result[0]['last_insert_id'];
        $manual2_id = $result[0]['manual2_id'];
        if ($type == 'update') {
            $move_result = $pm->run("SELECT * FROM rec_move WHERE `to` ='$manual2_id'");
            $count_move = count($move_result);
            if ($count_move > 0) {
                $move_data = unserialize($move_result[0]['original_data']);

                $move_data = $move_data[0];
                $move_data['name'];
                $move_id = $move_result[0]['id'];
                $move_from = $move_result[0]['from'];
                $param = array(":name" => $move_data['name'], ":surname" => $move_data['surname'], ":address" => $move_data['address'], ":suburb" => $move_data['suburb'], ":state" => $move_data['state'], ":zip" => $move_data['zip'], ":home_phone" => $move_data['home_phone'], ":business_phone" => $move_data['business_phone'], ":alt_phone" => $move_data['alt_phone'], ":status" => $move_data['status'], ":comments" => $move_data['comments'], ":constultant" => $move_data['constultant'], ":rid" => $move_result[0]['from']);
                $pm->run("UPDATE  contacts set name =:name,surname =:surname,address =:address,suburb=:suburb,state=:state,zip=:zip,home_phone=:home_phone,business_phone=:business_phone,alt_phone=:alt_phone,status=:status,comments=:comments,constultant=:constultant where id=:rid", $param);


                $param = array(":name" => $value['name'], ":surname" => $value['surname'], ":address" => $value['address'], ":suburb" => $value['suburb'], ":state" => $value['state'], ":zip" => $value['zip'], ":mobile" => $value['mobile'], ":mobile2" => $value['mobile2'], ":home_phone" => $value['home_phone'], ":home_phone2" => $value['home_phone2'], ":business_phone" => $value['business_phone'], ":alt_phone" => $value['alt_phone'], ":business_name" => $value['business_name'], ":business_address" => $value['business_address'], ":business_zip" => $value['business_zip'], ":import" => $value['import'], ":output" => $value['output'], ":last_update" => $value['last_update'], ":status" => $value['status'], ":comments" => $value['comments'], ":constultant" => $value['constultant'], ":active" => $value['active']);
                $last_manual = $pm->insertAndGetLastRowId("INSERT INTO manual_check2(`name`, `surname`, `address`, `suburb`, `state`, `zip`, `mobile`, `mobile2`, `home_phone`, `home_phone2`, `business_phone`, `alt_phone`, `business_name`, `business_address`, `business_zip`, `import`, `output`, `last_update`, `status`, `comments`, `constultant`, `active`) 
                VALUES(:name, :surname , :address, :suburb, :state, :zip, :mobile, :mobile2, :home_phone, :home_phone2, :business_phone, :alt_phone, :business_name, :business_address, :business_zip, :import, :output, :last_update, :status, :comments, :constultant, :active)", $param);
                $pm->run("UPDATE rec_move set `to`='$last_manual'  where id='$move_id'");
                $pm->run("DELETE  from history  where id='$id'");
                $status = "Undo status : (ID  : $move_from) updated in contacts table  (ID : $last_manual) inserted in manual_check2 table";
                $data[] = array(
                    "result" => $status,
                );
                echo json_encode($data);
            } else {
                $status = 'Undo status :failed';
                $data[] = array(
                    "result" => $status,
                );
                echo json_encode($data);
            }
        } elseif ($type == 'reject') {
            $rec = $pm->run("SELECT id from reject_table where id='$last_insert_id'");
            $count = count($rec);
            if ($count > 0) {
                $pm->run("DELETE  from reject_table where id='$last_insert_id'");
                $param = array(":name" => $value['name'], ":surname" => $value['surname'], ":address" => $value['address'], ":suburb" => $value['suburb'], ":state" => $value['state'], ":zip" => $value['zip'], ":mobile" => $value['mobile'], ":mobile2" => $value['mobile2'], ":home_phone" => $value['home_phone'], ":home_phone2" => $value['home_phone2'], ":business_phone" => $value['business_phone'], ":alt_phone" => $value['alt_phone'], ":business_name" => $value['business_name'], ":business_address" => $value['business_address'], ":business_zip" => $value['business_zip'], ":import" => $value['import'], ":output" => $value['output'], ":last_update" => $date, ":status" => $value['status'], ":comments" => $value['comments'], ":constultant" => $value['constultant'], ":active" => $value['active']);
                $last_manual2 =$pm->insertAndGetLastRowId("INSERT INTO manual_check2(`name`, `surname`, `address`, `suburb`, `state`, `zip`, `mobile`, `mobile2`, `home_phone`, `home_phone2`, `business_phone`, `alt_phone`, `business_name`, `business_address`, `business_zip`, `import`, `output`, `last_update`, `status`, `comments`, `constultant`, `active`) 
                VALUES(:name, :surname , :address, :suburb, :state, :zip, :mobile, :mobile2, :home_phone, :home_phone2, :business_phone, :alt_phone, :business_name, :business_address, :business_zip, :import, :output, :last_update, :status, :comments, :constultant, :active)", $param);
                $pm->run("DELETE  from history  where id='$id'");
                 
                 $pm->run("UPDATE rec_move set `to`='$last_manual2'  where `to`='$manual2_id'");
                $status = "Undo status : (ID : $last_insert_id) deleted from reject_table  (ID : $last_manual2) inserted into manual_check2 table";
                $data[] = array(
                    "result" => $status,
                );
                echo json_encode($data);
            } else {

                $status = 'undo unsuccessful';
                $data[] = array(
                    "result" => $status,
                );
                echo json_encode($data);
            }
        } else {
            
            $status = 'no history data';
            $data[] = array(
                "result" => $status,
            );
            echo json_encode($data);
        }
    } else {

        $status = 'no history data';
        $data[] = array(
            "result" => $status,
        );
        echo json_encode($data);
    }
}
?>

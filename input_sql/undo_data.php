<?php

session_start();
set_time_limit(0);
include 'timezone.inc.php';
$date = date("Y-m-d H:i:s", time());
$user = $_SESSION['username'];
include_once 'AppManager.php';
$pm = AppManager::getPM();
if (isset($_POST['method']) && $_POST['method'] == 'undo') {
    $sql = "SELECT * FROM history WHERE user='$user' AND from_table='manual' ORDER BY id  DESC LIMIT 1";
    $result = $pm->run($sql);
    if (count($result) != 0) {

        $value = unserialize($result[0]['data']);
        $value = $value[0];
        $type = $result[0]['type'];
        $id = $result[0]['id'];
        $last_insert_id = $result[0]['last_insert_id'];

        if ($type == 'delete') {
            $param = array(":name" => $value['name'], ":surname" => $value['surname'], ":address" => $value['address'], ":suburb" => $value['suburb'], ":state" => $value['state'], ":zip" => $value['zip'], ":mobile" => $value['mobile'], ":mobile2" => $value['mobile2'], ":home_phone" => $value['home_phone'], ":home_phone2" => $value['home_phone2'], ":business_phone" => $value['business_phone'], ":alt_phone" => $value['alt_phone'], ":business_name" => $value['business_name'], ":business_address" => $value['business_address'], ":business_zip" => $value['business_zip'], ":import" => $value['import'], ":output" => $value['output'], ":last_update" => $date, ":status" => $value['status'], ":comments" => $value['comments'], ":constultant" => $value['constultant'], ":active" => $value['active']);
            $manual_id = $pm->insertAndGetLastRowId("INSERT INTO manual_check(`name`, `surname`, `address`, `suburb`, `state`, `zip`, `mobile`, `mobile2`, `home_phone`, `home_phone2`, `business_phone`, `alt_phone`, `business_name`, `business_address`, `business_zip`, `import`, `output`, `last_update`, `status`, `comments`, `constultant`, `active`) 
                VALUES(:name, :surname , :address, :suburb, :state, :zip, :mobile, :mobile2, :home_phone, :home_phone2, :business_phone, :alt_phone, :business_name, :business_address, :business_zip, :import, :output, :last_update, :status, :comments, :constultant, :active)", $param);
            $pm->run("DELETE  from history  where id='$id'");
            $status = "Undo status :  deleted record backed to (ID : $manual_id) manual_check";
            $data[] = array(
                "result" => $status,
            );
            echo json_encode($data);
        }

        if ($type == 'accept') {
            $rec = $pm->run("SELECT id from contacts where id='$last_insert_id'");
            $count = count($rec);
            if ($count > 0) {
                $pm->run("DELETE  from contacts where id='$last_insert_id'");
                $param = array(":name" => $value['name'], ":surname" => $value['surname'], ":address" => $value['address'], ":suburb" => $value['suburb'], ":state" => $value['state'], ":zip" => $value['zip'], ":mobile" => $value['mobile'], ":mobile2" => $value['mobile2'], ":home_phone" => $value['home_phone'], ":home_phone2" => $value['home_phone2'], ":business_phone" => $value['business_phone'], ":alt_phone" => $value['alt_phone'], ":business_name" => $value['business_name'], ":business_address" => $value['business_address'], ":business_zip" => $value['business_zip'], ":import" => $value['import'], ":output" => $value['output'], ":last_update" => $date, ":status" => $value['status'], ":comments" => $value['comments'], ":constultant" => $value['constultant'], ":active" => $value['active']);
                $manual_id = $pm->insertAndGetLastRowId("INSERT INTO manual_check(`name`, `surname`, `address`, `suburb`, `state`, `zip`, `mobile`, `mobile2`, `home_phone`, `home_phone2`, `business_phone`, `alt_phone`, `business_name`, `business_address`, `business_zip`, `import`, `output`, `last_update`, `status`, `comments`, `constultant`, `active`) 
                VALUES(:name, :surname , :address, :suburb, :state, :zip, :mobile, :mobile2, :home_phone, :home_phone2, :business_phone, :alt_phone, :business_name, :business_address, :business_zip, :import, :output, :last_update, :status, :comments, :constultant, :active)", $param);
                $pm->run("DELETE  from history  where id='$id'");

                $status = "Undo status : (ID : $last_insert_id) deleted from contacts and (ID : $manual_id) inserted into manual_check";
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
        }
        if ($type == 'reject') {
            $rec = $pm->run("SELECT id from dups where id='$last_insert_id'");
            $count = count($rec);
            if ($count > 0) {
                $pm->run("DELETE  from dups where id='$last_insert_id'");
                $param = array(":name" => $value['name'], ":surname" => $value['surname'], ":address" => $value['address'], ":suburb" => $value['suburb'], ":state" => $value['state'], ":zip" => $value['zip'], ":mobile" => $value['mobile'], ":mobile2" => $value['mobile2'], ":home_phone" => $value['home_phone'], ":home_phone2" => $value['home_phone2'], ":business_phone" => $value['business_phone'], ":alt_phone" => $value['alt_phone'], ":business_name" => $value['business_name'], ":business_address" => $value['business_address'], ":business_zip" => $value['business_zip'], ":import" => $value['import'], ":output" => $value['output'], ":last_update" => $date, ":status" => $value['status'], ":comments" => $value['comments'], ":constultant" => $value['constultant'], ":active" => $value['active']);
                $manula_id = $pm->insertAndGetLastRowId("INSERT INTO manual_check(`name`, `surname`, `address`, `suburb`, `state`, `zip`, `mobile`, `mobile2`, `home_phone`, `home_phone2`, `business_phone`, `alt_phone`, `business_name`, `business_address`, `business_zip`, `import`, `output`, `last_update`, `status`, `comments`, `constultant`, `active`) 
                VALUES(:name, :surname , :address, :suburb, :state, :zip, :mobile, :mobile2, :home_phone, :home_phone2, :business_phone, :alt_phone, :business_name, :business_address, :business_zip, :import, :output, :last_update, :status, :comments, :constultant, :active)", $param);
                $pm->run("DELETE  from history  where id='$id'");

                $status = "Undo status : (ID : $last_insert_id) deleted from dups and (ID : $manula_id) inserted into manual_check";
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

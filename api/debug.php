<?php
require_once 'config.php';
require_once 'query.php';
$request = json_decode(file_get_contents('php://input'));






$sql = "";
$sql = "SELECT * FROM `data` where phone_1 is not null";


$response = array();

$res = smm_db::query($sql);
if (mysqli_num_rows($res) > 0) {
    while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
        $row['phone_type_1'] = strtolower($row['phone_type_1']);
        if (strlen($row['phone_type_1']) <= 0) {
            $row['phone_type_1'] = 'home';
        }
        $row['phone_1'] = $string = preg_replace('/\s+/', '', $row['phone_1']);
        $phone_id = 0;
        echo "<pre>";
        print_r($row);
        echo "</pre>";
        $sql = 'INSERT IGNORE INTO `phone_numbers` (`phone`) VALUES ("' . $row['phone_1'] . '")';

        $res1 = smm_db::query($sql);
        $phone_id = smm_db::insert_id();

        if ($phone_id > 0) {
            $sql = 'INSERT INTO `data_phone_numbers` (`phone_number_id`,`data_id`,`phone_type`) VALUES ("' . $phone_id . '","' . $row['data_id'] . '","' . $row['phone_type_1'] . '")';
            $res2 = smm_db::query($sql);
        }
    }
}

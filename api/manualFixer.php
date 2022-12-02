<?php
require_once 'config.php';
require_once 'query.php';
$request = json_decode(file_get_contents('php://input'));




function isUTF8($string)
{
    return (utf8_encode(utf8_decode($string)) == $string);
}

$sql = "";
$sql = "SELECT 
dod.*,
d.email_lkp_id as d_email_lkp_id,
doo.data_other_organization_lkp_id,
doo.organization_title_id,
del.data_email_lkp_id,
dda.linkedin_account_persona_id,
doh.data_organization_history_id 
FROM `data_other_details` as dod 
INNER JOIN `data` as d USING (data_id) 
INNER JOIN data_date_added as dda ON dda.data_id = dod.data_id 
LEFT OUTER JOIN data_other_organization_lkp as doo ON doo.data_id = dod.data_id 


LEFT OUTER JOIN data_email_lkp as del ON del.data_id = dod.data_id AND del.email_lkp_id = d.email_lkp_id AND del.linkedin_account_persona_id = dda.linkedin_account_persona_id 
LEFT OUTER JOIN data_organization_history as doh ON doh.data_other_organization_lkp_id = doo.data_other_organization_lkp_id AND doh.organization_title_id = doo.organization_title_id 
GROUP BY data_id
";


$response = array();
$count = 0;
$res = smm_db::query($sql);
if (mysqli_num_rows($res) > 0) {
    while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
        $row['companies'] = json_decode($row['companies'], true);
        $data_email_lkp_id = 0;

        if (!$row['data_email_lkp_id'] > 0) {
            $sql = 'INSERT INTO `data_email_lkp` 
            (
                `data_id`,
                `email_lkp_id`,
                `linkedin_account_persona_id`,
                `email_src_id`
                ) VALUES 
                (
                    ' . $row['data_id']  . ',
                    ' . $row['d_email_lkp_id'] . ',
                    ' . $row['linkedin_account_persona_id'] . ',
                    1
                )';
            $res2 = smm_db::query($sql);
            $data_email_lkp_id = smm_db::insert_id();


            echo "data_email_lkp";
        } elseif ((!$row['data_other_organization_lkp_id'] > 0 || !$row['data_organization_history_id'] > 0)  && $row['data_email_lkp_id'] > 0) {

            $org_arr_fields = array(
                "organization_",

                "organization_id_",

                "organization_url_",

                "organization_title_",

                "organization_start_",

                "organization_end_",

                "organization_description_",

                "organization_location_",

                "organization_website_",

                "organization_domain_"

            );
            $i = 0;
            $counter_i = 0;
            while ($i == 0) {
                $counter_i++;

                if ($counter_i == 20) {
                    $i = 1;
                }


                $key = "organization_" . $counter_i;
                $arr = array();
                if (isset($row['companies'][$key])) {

                    foreach ($org_arr_fields as $val) {
                        $key_org = substr_replace($val, "", -1);
                        $orig_key = $val;
                        $val = $val . $counter_i;
                        $arr[$key_org] = $row['companies'][$val];
                    }

                    $organization_titles = array();
                    if (isset($arr["organization_title"]) && strlen($arr["organization_title"]) > 0) {
                        // echo $exploded_loc[0]."==".strlen($exploded_loc[0])."<br>";
                        // if (isUTF8($arr['organization_title'])) {
                        //     echo  "zzzzzzzzzzzzzz<br>";
                        //     $arr['organization_title'] = utf8_encode(addslashes($arr['organization_title']));
                        // } else {
                        //     echo  "xxxxxxxxxx<br>";
                        //     $arr['organization_title'] = addslashes($arr['organization_title']);
                        // }


                        $arr['organization_title'] = str_replace("|", ",", $arr['organization_title']);
                        $arr['organization_title'] = str_replace("│", ",", $arr['organization_title']);
                        $arr['organization_title'] = str_replace("–", ",", $arr['organization_title']);
                        $arr['organization_title'] = str_replace("➤", ",", $arr['organization_title']);
                        // echo $arr['organization_title'] . "<br>";



                        $sql = "";
                        $sql = "SELECT * FROM organization_titles WHERE organization_title = \"" .  addslashes(utf8_encode($arr['organization_title']))  . "\" LIMIT 1";
                        $res_organization_title_info = smm_db::query($sql)->fetch_array(MYSQLI_ASSOC);
                        $organization_titles = $res_organization_title_info;

                        // if (mysqli_num_rows($res_org_info) > 0) {
                        if (isset($res_organization_title_info['organization_title_id']) && $res_organization_title_info['organization_title_id'] > 0) {
                        } else {


                            $sql = '';
                            $sql = 'INSERT INTO `organization_titles` 
                                (
                                    `organization_title`
                                ) VALUES 
                                (
                                    "' .  addslashes(utf8_encode($arr['organization_title']))   . '"
                                )';
                            $res_insert_organization_title = smm_db::query($sql);
                            echo "organization_titles<br>";
                        }

                        // }
                    }



                    $sql = "";

                    if (isset($arr['organization_id']) && $arr['organization_id'] > 0) {
                        $sql = "SELECT * FROM organizations_lkp WHERE linkedin_organization_id = " . $arr['organization_id'] . " LIMIT 1";
                    } elseif (isset($arr['organization']) && strlen($arr['organization']) > 0) {
                        $sql = "SELECT * FROM organizations_lkp WHERE organization_name = \"" .  addslashes(utf8_encode($arr['organization'])) . "\" AND organization_location_1 = \"" . $arr['organization_location'] . "\" LIMIT 1";
                    }


                    if ($sql != "") {
                        $res_org_info = smm_db::query($sql);

                        if (mysqli_num_rows($res_org_info) > 0) {

                            $row_org_info = $res_org_info->fetch_array(MYSQLI_ASSOC); //mysqli_fetch_row($res_org_info);
                            if (!$row['data_organization_history_id'] > 0 && $row["data_other_organization_lkp_id"] > 0 && $row["organization_title_id"] > 0) {
                            }
                            if (
                                $row['data_id'] > 0 &&
                                $row_org_info['organization_lkp_id'] > 0 &&
                                $organization_titles['organization_title_id'] > 0 &&
                                $row['d_email_lkp_id'] > 0
                            ) {
                                $sql = '';
                                $sql = 'SELECT * FROM `data_other_organization_lkp` WHERE 
                                data_type = "contact" AND 
                                data_id = ' . $row['data_id'] . ' AND 
                                organization_lkp_id = ' . $row_org_info['organization_lkp_id'] . ' AND 
                                organization_title_id = ' . $organization_titles['organization_title_id'] . ' AND 
                                data_email_lkp_id = ' . $row['d_email_lkp_id'];
                                // echo $sql . "<br>";
                                $res_data_other_organization_lkp = smm_db::query($sql);
                                $row_data_other_organization_lkp = $res_data_other_organization_lkp->fetch_array(MYSQLI_ASSOC);
                                if (isset($row_data_other_organization_lkp['data_other_organization_lkp_id']) && $row_data_other_organization_lkp['data_other_organization_lkp_id'] > 0) {

                                    $date_start = "0000-00-00";
                                    $date_end = "0000-00-00";

                                    if (isset($arr["organization_start"]) && strlen($arr["organization_start"]) > 0) {
                                        $date_start = str_replace(".", "-", $arr["organization_start"]) . "-01";
                                    }
                                    if (isset($arr["organization_end"]) && strlen($arr["organization_end"]) > 0) {
                                        $date_end = str_replace(".", "-", $arr["organization_end"]) . "-01";
                                    }

                                    if (isset($arr["organization_start"]) && strlen($arr["organization_start"]) == 4) {
                                        $date_start = str_replace(".", "-", $arr["organization_start"]) . "-00-00";
                                    }
                                    if (isset($arr["organization_end"]) && strlen($arr["organization_end"]) == 4) {
                                        $date_end = str_replace(".", "-", $arr["organization_end"]) . "-00-00";
                                    }


                                    $sql = "";
                                    $sql = "SELECT * FROM data_organization_history WHERE 
                                                    data_other_organization_lkp_id = " . $row_data_other_organization_lkp['data_other_organization_lkp_id'] . " AND 
                                                    organization_start = \"" . $date_start  . "\" AND 
                                                    organization_end = \"" . $date_end . "\"  AND 
                                                    organization_title_id = " . $row_data_other_organization_lkp["organization_title_id"]  . " LIMIT 1";
                                    // echo $sql . "<br>";
                                    $res_data_organization_history = smm_db::query($sql)->fetch_array(MYSQLI_ASSOC);
                                    if (isset($res_data_organization_history['data_organization_history_id']) && $res_data_organization_history['data_organization_history_id'] > 0) {
                                        // $country_id = $res_data_organization_history['country_id'];

                                    } else {

                                        $sql = 'INSERT INTO `data_organization_history` 
                                        (
                                            `data_other_organization_lkp_id`,
                                            `organization_start`,
                                            `organization_end`,
                                            `organization_title_id`
                                        ) VALUES 
                                        (
                                            ' . $row_data_other_organization_lkp['data_other_organization_lkp_id']  . ',
                                            "' . $date_start . '",
                                            "' . $date_end .  '",
                                            ' . $row_data_other_organization_lkp["organization_title_id"]  . '
                                        )';
                                        echo strlen($arr["organization_start"]) . "<br>";
                                        echo strlen($arr["organization_end"]) . "<br>";
                                        echo $sql;
                                        echo "<pre>";
                                        print_r($row);
                                        echo "</pre>";

                                        $res3 = smm_db::query($sql);
                                        $data_organization_history_id = smm_db::insert_id();
                                        // echo "data_organization_history<br>";
                                        $count++;
                                    }
                                } else {
                                    echo "not exist <br>";
                                    // echo "<pre>";
                                    // print_r($row);
                                    // print_r($row_org_info);
                                    // print_r($row_data_other_organization_lkp);
                                    // echo "</pre>";
                                    if ($counter_i == 1) {
                                        $sql = 'INSERT INTO `data_other_organization_lkp` 
                                        (
                                            `data_type`,
                                            `data_id`,
                                            `organization_lkp_id`,
                                            `sort`,
                                            `primary_organization`,
                                            `organization_title_id`,
                                            `data_email_lkp_id`
                                        ) VALUES 
                                        (
                                            "contact",
                                            ' . $row['data_id']  . ',
                                            ' . $row_org_info['organization_lkp_id']  . ',
                                            ' . $counter_i . ',
                                            1,
                                            ' . $organization_titles['organization_title_id'] . ',
                                            ' . $row['d_email_lkp_id'] . '
                                        )';
                                    } else {
                                        $sql = 'INSERT INTO `data_other_organization_lkp` 
                                        (
                                            `data_type`,
                                            `data_id`,
                                            `organization_lkp_id`,
                                            `sort`,
                                            `primary_organization`,
                                            `organization_title_id`,
                                            `data_email_lkp_id`
                                        ) VALUES 
                                        (
                                            "contact",
                                            ' . $row['data_id']  . ',
                                            ' . $row_org_info['organization_lkp_id']  . ',
                                            ' . $counter_i . ',
                                            0,
                                            ' . $organization_titles['organization_title_id'] . ',
                                            ' . $row['d_email_lkp_id'] . '
                                        )';
                                    }

                                    $res2 = smm_db::query($sql);
                                    $data_other_organization_lkp_id = smm_db::insert_id();

                                    // echo "<pre>";
                                    // print_r($row);
                                    // echo "</pre>";

                                }
                            }






                            // $count++;
                        } else {


                            $country_id = 0;
                            $exploded_loc = explode(",", $arr['organization_location']);
                            if (count($exploded_loc) == 1) {
                                $exploded_loc[0] = trim($exploded_loc[0]);

                                if (strlen($exploded_loc[0]) > 0) {
                                    // echo $exploded_loc[0]."==".strlen($exploded_loc[0])."<br>";
                                    $sql = "";
                                    $sql = "SELECT * FROM countries_lkp WHERE country = \"" . $exploded_loc[0] . "\" AND `x` = 'active' LIMIT 1";
                                    $res_country_info = smm_db::query($sql)->fetch_array(MYSQLI_ASSOC);
                                    // if (mysqli_num_rows($res_org_info) > 0) {
                                    if (isset($res_country_info['country_id']) && $res_country_info['country_id'] > 0) {

                                        $country_id = $res_country_info['country_id'];
                                    }

                                    // }
                                } else {
                                    // echo "empty loc";
                                }
                            } else {
                                $country_key = count($exploded_loc) - 1;
                                $exploded_loc[$country_key] = trim($exploded_loc[$country_key]);

                                // echo $exploded_loc[$country_key]."==".strlen($exploded_loc[$country_key])."<br>";

                                $sql = "";
                                $sql = "SELECT * FROM countries_lkp WHERE country = \"" . $exploded_loc[$country_key] . "\" AND `x` = 'active' LIMIT 1";
                                $res_country_info = smm_db::query($sql)->fetch_array(MYSQLI_ASSOC);
                                if (isset($res_country_info['country_id']) && $res_country_info['country_id'] > 0) {
                                    $country_id = $res_country_info['country_id'];
                                }
                            }
                            if (!$arr['organization_id'] > 0) {
                                $arr['organization_id'] = 0;
                            }

                            $sql = '';
                            $sql = 'INSERT IGNORE INTO `organizations_lkp` 
                                (
                                    `linkedin_organization_id`,
                                    `organization_name`,
                                    `organization_url`,
                                    `organization_website`,
                                    `organization_location_1`,
                                    `organization_description`,
                                    `country_id`
                                ) VALUES 
                                (
                                    ' . $arr['organization_id']  . ',
                                    "' . addslashes(utf8_encode($arr['organization']))  . '",
                                    "' . $arr['organization_url'] . '",
                                    "' . $arr['organization_website'] . '",
                                    "' . $arr['organization_location'] . '",
                                    "' . addslashes(utf8_encode($arr['organization_description'])) . '",
                                    ' . $country_id . '
                                )';

                            $res2 = smm_db::query($sql);
                            $organization_lkp_id = smm_db::insert_id();
                        }
                    }
                } else {


                    $i = 1;
                }
            }
        } else {
            echo "chow";
        }






        // if ($row['data_other_organization_lkp_id'] > 0) {
        // } else {

        //     echo "<pre>";
        //     print_r($row);
        //     echo "</pre>";
        // }
    }
}
echo "Total: " . $count;

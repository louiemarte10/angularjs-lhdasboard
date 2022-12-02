<?php
// $files = scandir('/var/www/html/playground/jpdamasco-new/linkedinFixer/webhook');
// ini_set('display_errors', 0);

require_once '/var/www/html/pipeline/linkedin-dashboard/api/config.php';








$sql = "";
$sql = 'SELECT *,el.status as email_status FROM `linkedin_account_persona` as lap 
        INNER JOIN data_date_added as dda ON dda.linkedin_account_persona_id = lap.linkedin_account_persona_id 
        INNER JOIN data_email_lkp as del ON del.data_id = dda.data_id 
        INNER JOIN emails_lkp as el ON el.email_id = del.email_lkp_id  
        INNER JOIN email_src_lkp as esl ON esl.email_src_id = del.email_src_id WHERE lap.linkedin_account_persona_id NOT IN (6,7,8,9,10,16,17,18,20,22,23,86) ORDER BY my_fullname ASC';
$res = smm_db::query($sql);
// $count = 0;
// $linkedIn_emails = 0;
// $snov_emails = 0;
// $snov_emails_valid = 0;
// $snov_emails_not_valid = 0;
$arr = array();
$arr_unique = array();
if (mysqli_num_rows($res) > 0) {
    // echo mysqli_num_rows($res);
    // echo "<br><Br>";
    while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
        $count++;
        $info_arr = array();
        $info_arr['Total Contacts'] = $linkedIn_emails;

        $row['agent_name'] = array();
        $sql1 = "";
        $sql1 = "SELECT * FROM employees WHERE `user_id` IN (" . $row['assigned_to'] . ") AND `x` = 'active'";
        $res1 = pipe_db::query($sql1);

        if (mysqli_num_rows($res1) > 0) {
            // echo mysqli_num_rows($res);
            // echo "<br><Br>";
            while ($row1 = $res1->fetch_array(MYSQLI_ASSOC)) {
                // if ($count == 1) {
                //     echo "<pre>";
                //     print_r($row1);
                //     echo "</pre>";
                // }
                // echo $row1['first_name']." ".$row1['last_name']."<br>";
                $row['agent_name'][] = $row1['first_name'] . " " . $row1['last_name'];
                // $row['agent_name'] = $row1[''];
            }
        }
        // $row['email']
        if ($row['email'] != "") {
            $arr[$row['my_fullname']]['contacts'][] = $row;
            $arr[$row['my_fullname']]["agents"] = $row['agent_name'];


            if ($row['email_src_id'] == 2) {
                $arr_unique[$row['source_name']][$row['status']][$row['email']] = $row['email'];
            } else {
                $arr_unique["LH Email Finder"][$row['status']][$row['email']] = $row['email'];
            }
        }
    }
}
?>
<style>
    #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    h1 {
        font-size: 1em !important;
    }

    #customers td,
    #customers th {
        border: 1px solid #ddd;
        padding: 8px;
        font-size: 0.7em !important;
        width: auto !important;
    }

    #customers tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #customers tr:hover {
        background-color: #ddd;
    }

    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #04AA6D;
        color: white;
    }

    .ng-scope {
        height: 100% !important;
        background-color: white;
    }
</style>


<div align="left" style="margin: 5% !important">
    <h1 style="font-size: 2em !important;">Linked Helper Email Report</h1>
    <br>
    <table id="customers">
        <tr>
            <th colspan="15">
                <h1>Emails By Persona</h1>
            </th>
        </tr>
        <tr>
            <th>
                Agents
            </th>
            <th>
                Persona
            </th>
            <th>
                Total Emails
            </th>
            <th>
                Total LinkedIn Emails
            </th>
            <th>
                LinkedIn Emails %
            </th>
            <th>
                Total Valid<br>LinkedIn Emails
            </th>
            <th>
                Valid<br>LinkedIn Emails %
            </th>
            <th>
                Total Unverifiable<br>LinkedIn Emails
            </th>
            <th>
                Unverifiable<br>LinkedIn Emails %
            </th>







            <th>
                Total Snov.IO Emails
            </th>
            <th>
                Snov.IO Emails %
            </th>
            <th>
                Total Valid<br>Snov.IO Emails
            </th>
            <th>
                Valid<br>Snov.IO Emails %
            </th>
            <th>
                Total Unverifiable<br>Snov.IO Emails
            </th>
            <th>
                Unverifiable<br>Snov.IO Emails %
            </th>
        </tr>

        <?php
        $total_count = 0;
        $overall_linkedIn_emails = 0;
        $overall_linkedIn_emails_valid = 0;
        $overall_linkedIn_emails_not_valid = 0;


        $overall_snov_emails = 0;
        $overall_snov_emails_valid = 0;
        $overall_snov_emails_not_valid = 0;

        foreach ($arr as $persona => $data) {
            $persona_total_contacts_count = 0;
            $linkedIn_emails = 0;
            $linkedIn_emails_valid = 0;
            $linkedIn_emails_not_valid = 0;



            $snov_emails = 0;
            $snov_emails_valid = 0;
            $snov_emails_not_valid = 0;

            foreach ($data['contacts'] as $key => $data_info) {
                $total_count++;
                $persona_total_contacts_count++;
                if ($data_info['email_status'] == "") {
                    $data_info['email_status'] = "unverifiable";
                }
                if ($data_info['email_src_id'] == 2) {
                    $snov_emails++;
                    $overall_snov_emails++;

                    if ($data_info['email_status'] == "valid") {
                        $snov_emails_valid++;
                        $overall_snov_emails_valid++;
                    } else {
                        $snov_emails_not_valid++;
                        $overall_snov_emails_not_valid++;
                    }
                    // (($snov_emails - actual price) / (list price)) * 100%
                } else {
                    // if ($data_info['email_src_id'] == 4 || $data_info['email_src_id'] == 1) {
                    $linkedIn_emails++;
                    $overall_linkedIn_emails++;
                    if ($data_info['email_status'] == "valid") {
                        $linkedIn_emails_valid++;
                        $overall_linkedIn_emails_valid++;
                    } else {
                        $linkedIn_emails_not_valid++;
                        $overall_linkedIn_emails_not_valid++;
                    }
                    // }
                }
            }




            // if ($snov_emails > 0) {
        ?>

            <tr>
                <td>

                    <?php
                    // echo "<pre>";
                    // print_r($data);
                    // echo "</pre>";
                    if (!empty($data['agents'])) {
                        $agent_names = "";
                        $count_agents = 0;
                        $max_agents_count =  count($data['agents']);

                        foreach ($data['agents'] as $agent) {
                            $count_agents++;
                            if ($count_agents == $max_agents_count) {
                                $agent_names .= $agent;
                            } else {
                                $agent_names .= $agent . ",<br>";
                            }
                        }

                        echo "<b>".$agent_names."</b>";
                    }


                    ?>
                </td>
                <td>
                    <?php echo $persona; ?>
                </td>
                <td>
                    <?php echo $persona_total_contacts_count; ?>

                </td>
                <td>
                    <?php echo $linkedIn_emails; ?>

                </td>
                <td>
                    <?php
                    if ($persona_total_contacts_count > 0 && $snov_emails > 0) {
                        echo round((($persona_total_contacts_count - $snov_emails) / ($persona_total_contacts_count)) * 100, 2);
                    } else {
                        echo 0;
                    }
                    ?>
                    %

                </td>
                <td>
                    <?php echo $linkedIn_emails_valid; ?>

                </td>
                <td>
                    <?php
                    if ($linkedIn_emails > 0 && $linkedIn_emails_not_valid > 0) {
                        echo round((($linkedIn_emails - $linkedIn_emails_not_valid) / ($linkedIn_emails)) * 100, 2);
                    } else {
                        echo 0;
                    }
                    ?>
                    %

                </td>
                <td>
                    <?php echo $linkedIn_emails_not_valid; ?>

                </td>
                <td>
                    <?php
                    if ($linkedIn_emails > 0 && $linkedIn_emails_valid > 0) {
                        echo round((($linkedIn_emails - $linkedIn_emails_valid) / ($linkedIn_emails)) * 100, 2);
                    } else {
                        echo 0;
                    }
                    ?>
                    %

                </td>











                <td>
                    <?php echo $snov_emails; ?>
                </td>
                <td>
                    <?php
                    if ($persona_total_contacts_count > 0 && $linkedIn_emails > 0) {
                        echo round((($persona_total_contacts_count - $linkedIn_emails) / ($persona_total_contacts_count)) * 100, 2);
                    } else {
                        echo 0;
                    }
                    ?>
                    %
                </td>
                <td>
                    <?php echo $snov_emails_valid; ?>
                </td>
                <td>
                    <?php
                    if ($snov_emails > 0 && $snov_emails_not_valid > 0) {
                        echo round((($snov_emails - $snov_emails_not_valid) / ($snov_emails)) * 100, 2);
                    } else {
                        echo 0;
                    }

                    ?>%
                </td>
                <td>
                    <?php echo $snov_emails_not_valid; ?>
                </td>
                <td>
                    <?php
                    if ($snov_emails > 0 && $snov_emails_valid > 0) {
                        echo round((($snov_emails - $snov_emails_valid) / ($snov_emails)) * 100, 2);
                    } else {
                        echo 0;
                    }

                    ?>%
                </td>
            </tr>

        <?php
            // echo "<span style='font-size: 2em'><b>" . $persona . "</b></span><br>";
            // echo "<b>Total Contacts</b>: " . count($data) . "<br>";
            // echo "<b>Total LinkedIn Emails</b>: " . $linkedIn_emails . "<br><br>";
            // echo "<b>Total Snov.IO Emails</b>: " . $snov_emails . "<br>";
            // echo "<b>Total Valid Snov.IO Emails</b>: " . $snov_emails_valid . "<br>";
            // echo "<b>Total Unverifiable Snov.IO Emails</b>: " . $snov_emails_not_valid . "<br><br>";



            // echo "<b>Percetage of Valid Snov.IO Emails</b>:" . round((($snov_emails - $snov_emails_not_valid) / ($snov_emails)) * 100,2);
            // echo "%<br>";
            // echo "<b>Percetage of Unverifiable Snov.IO Emails</b>:" . round((($snov_emails - $snov_emails_valid) / ($snov_emails)) * 100,2);
            // echo "%<br>";
            // echo "<br><br><br><br><br><br>";
            // }
        }
        ?>
        <tr>
            <td>

            </td>
            <td>
                <b>
                    Overall :
                </b>
            </td>
            <td>
                <b>
                    <?php echo $total_count; ?>
                </b>

            </td>
            <td>
                <b>
                    <?php echo $overall_linkedIn_emails; ?>
                </b>

            </td>
            <td>
                <b>
                    <?php
                    if ($total_count > 0 && $overall_snov_emails > 0) {
                        echo round((($total_count - $overall_snov_emails) / ($total_count)) * 100, 2);
                    } else {
                        echo 0;
                    }

                    ?>%
                </b>

            </td>

            <!-- $overall_linkedIn_emails = 0;
        $overall_linkedIn_emails_valid = 0;
        $overall_linkedIn_emails_not_valid = 0; -->

            <td>
                <b>
                    <?php echo $overall_linkedIn_emails_valid; ?>
                </b>

            </td>
            <td>
                <b>
                    <?php
                    if ($overall_linkedIn_emails > 0 && $overall_linkedIn_emails_not_valid) {
                        echo round((($overall_linkedIn_emails - $overall_linkedIn_emails_not_valid) / ($overall_linkedIn_emails)) * 100, 2);
                    } else {
                        echo 0;
                    }

                    ?>%
                </b>

            </td>
            <td>
                <b>
                    <?php echo $overall_linkedIn_emails_not_valid; ?>
                </b>

            </td>
            <td>
                <b>
                    <?php
                    if ($overall_linkedIn_emails > 0 && $overall_linkedIn_emails_valid) {
                        echo round((($overall_linkedIn_emails - $overall_linkedIn_emails_valid) / ($overall_linkedIn_emails)) * 100, 2);
                    } else {
                        echo 0;
                    }

                    ?>%

                </b>

            </td>












            <td>
                <b>
                    <?php echo $overall_snov_emails; ?>
                </b>

            </td>
            <td>
                <b>
                    <?php
                    if ($total_count > 0 && $overall_linkedIn_emails > 0) {
                        echo round((($total_count - $overall_linkedIn_emails) / ($total_count)) * 100, 2);
                    } else {
                        echo 0;
                    }

                    ?>%
                </b>


            </td>
            <td>
                <b>
                    <?php echo $overall_snov_emails_valid; ?>
                </b>

            </td>
            <td>
                <b>
                    <?php
                    if ($overall_snov_emails > 0 && $overall_snov_emails_not_valid) {
                        echo round((($overall_snov_emails - $overall_snov_emails_not_valid) / ($overall_snov_emails)) * 100, 2);
                    } else {
                        echo 0;
                    }

                    ?>%
                </b>

            </td>
            <td>
                <b>
                    <?php echo $overall_snov_emails_not_valid; ?>
                </b>

            </td>
            <td>
                <b>
                    <?php
                    if ($overall_snov_emails > 0 && $overall_snov_emails_valid) {
                        echo round((($overall_snov_emails - $overall_snov_emails_valid) / ($overall_snov_emails)) * 100, 2);
                    } else {
                        echo 0;
                    }

                    ?>%

                </b>

            </td>
            <!-- $overall_linkedIn_emails = 0;
        $overall_snov_emails = 0;
        $overall_snov_emails_valid = 0;
        $overall_snov_emails_not_valid = 0; -->

        </tr>
        <tr>
            <th>
                Agents
            </th>
            <th>

            </th>
            <th>
                Total Emails
            </th>
            <th>
                Total LinkedIn Emails
            </th>
            <th>
                LinkedIn Emails %
            </th>
            <th>
                Total Valid<br>LinkedIn Emails
            </th>
            <th>
                Valid<br>LinkedIn Emails %
            </th>
            <th>
                Total Unverifiable<br>LinkedIn Emails
            </th>
            <th>
                Unverifiable<br>LinkedIn Emails %
            </th>







            <th>
                Total Snov.IO Emails
            </th>
            <th>
                Snov.IO Emails %
            </th>
            <th>
                Total Valid<br>Snov.IO Emails
            </th>
            <th>
                Valid<br>Snov.IO Emails %
            </th>
            <th>
                Total Unverifiable<br>Snov.IO Emails
            </th>
            <th>
                Unverifiable<br>Snov.IO Emails %
            </th>
        </tr>




    </table>




    <table id="customers">
        <tr>
            <th style="border:none;background-color: transparent !important">
                <div style="height: 100px"></div>
            </th>
        </tr>

    </table>




















    <table id="customers">
        <tr>
            <th colspan="5">
                <h1>Unique Emails</h1>
            </th>
        </tr>

        <?php
        $arr_unique_counts = array();
        // echo "<pre>";
        // print_r($arr_unique);
        // echo "</pre>";

        foreach ($arr_unique as $source_name => $emails) {
            // echo $source_name . "<br>";

            $arr_unique_counts[$source_name]['counts'] = 0;
            foreach ($emails as $status => $email_list) {
                // echo $status . "<br>";
                $count_emails = 0;
                $arr_unique_counts[$source_name][$status]['counts'] = 0;
                foreach ($email_list as $email) {
                    // if ($status == "valid") {
                    //     echo $email . "<br>";
                    // }

                    $count_emails++;
                    $arr_unique_counts[$source_name][$status]['counts']++;
                    $arr_unique_counts[$source_name]['counts']++;
                }
                // $arr_unique_counts[$source_name][$status]['counts'] = $count_emails;
                // echo $email;
                // echo "<pre>";
                // print_r($email);
                // echo "</pre>";
            }
        }
        ?>

        <?php
        // echo "<pre>";
        // print_r($arr_unique_counts);
        // echo "</pre>";
        foreach ($arr_unique_counts as $source_name => $emails_counts) {
        ?>
            <tr>
                <td colspan="5">
                    <h1><?php echo $source_name; ?></h1>
                </td>
            </tr>
            <tr>
                <?php
                if ($source_name == "snov.io") {
                ?>

                    <th>
                        Total Snov.IO Emails
                    </th>
                    <th>
                        Total Valid Snov.IO Emails
                    </th>
                    <th>
                        Valid Snov.IO Emails %
                    </th>
                    <th>
                        Total Unverifiable Snov.IO Emails
                    </th>
                    <th>
                        Unverifiable Snov.IO Emails %
                    </th>

                <?php
                } else {
                ?>
                    <th>
                        Total LinkedIn Emails
                    </th>
                    <th>
                        Total Valid LinkedIn Emails
                    </th>
                    <th>
                        Valid LinkedIn Emails %
                    </th>
                    <th>
                        Total Unverifiable LinkedIn Emails
                    </th>
                    <th>
                        Unverifiable LinkedIn Emails %
                    </th>
                <?php

                }
                ?>

            </tr>
            <tr>



                <td>
                    <?php echo $emails_counts['counts']; ?>
                </td>
                <td>
                    <?php echo $emails_counts['valid']['counts']; ?>
                </td>
                <td>
                    <?php
                    if ($emails_counts['counts'] > 0 && $emails_counts['unverifiable']['counts'] > 0) {
                        echo round((($emails_counts['counts'] - $emails_counts['unverifiable']['counts']) / ($emails_counts['counts'])) * 100, 2);
                    } else {
                        echo 0;
                    }

                    ?>%
                </td>
                <td>
                    <?php echo $emails_counts['unverifiable']['counts']; ?>
                </td>
                <td>
                    <?php
                    if ($emails_counts['counts'] > 0 && $emails_counts['valid']['counts'] > 0) {
                        echo round((($emails_counts['counts'] - $emails_counts['valid']['counts']) / ($emails_counts['counts'])) * 100, 2);
                    } else {
                        echo 0;
                    }

                    ?>%
                </td>




            </tr>
            <?php
            ?>

        <?php } ?>
    </table>
</div>
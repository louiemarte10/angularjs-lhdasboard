<?php

extract($_REQUEST, EXTR_OVERWRITE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/config/pipeline-x.php");

$database = new px_dbase();
config::connect_db($database, "pipe", "callbox_misc");

$sql = "SELECT
         *
        FROM
         email_campaign_stats
        WHERE
         department_id = $hid
        AND
         date_from = '$date_from'
        AND
         date_to = '$date_to'
        AND
         type = '$type'";

$database->query($sql);

$result = array();

$total = array();

$blast = array();

while ($row = $database->fetch_assoc())
   $result[] = $row;

$r_array = array();

$department = get_node($hid);

$date_string = "(" . date('F d',strtotime($date_from)) . ' - ' . date('F d', strtotime($date_to)) . ")";

$title = "$department $date_string";

$k = array(
   'sent', 
   'delivered', 
   'opened', 
   'soft_bounce', 
   'hard_bounce', 
   'clicks', 
   'conversions', 
   'opens_in_conversions', 
   'appointment_set', 
   'lead_completed', 
   'webinar_registration'
);


foreach ($result as $res) {

   $inactive = get_inactive_clients($date_from, $date_to);

   if (!empty($inactive) && in_array($res['client_id'], $inactive))
      continue;

   foreach ($k as $key) {
      $r_array[$res['team_id']][$res['client_id']][$key] += $res[$key];
      $total[$key] += $res[$key];
      $blast[$res['client_id']][$res['reference_id']][$key] += $res[$key];
   }      
      
   $r_array[$res['team_id']][$res['client_id']]['workflows']++;
   $total['workflows']++;
   $blast[$res['client_id']][$res['reference_id']]['workflows']++;

   if ($res['dialer_workflow'] == 'yes') {
      $r_array[$res['team_id']][$res['client_id']]['dialer_workflow']++;
      $total['dialer_workflow']++;
      $blast[$res['client_id']][$res['reference_id']]['dialer_workflow']++;
   }      

}

$per_client = array();
$final_result = array();
$final_total = array();
$final_blast = array();

foreach ($r_array as $dept_id => $res) {
   
   $node = get_node($dept_id);
   
   $row = array('dept'                 => $node, 
                'campaigns'            => 0,
                'dialer_workflow'      => 0, 
                'workflows'            => 0, 
                'sent'                 => 0, 
                'delivered'            => 0,
                'opened'               => 0,
                'clicks'               => 0,
                'soft_bounce'          => 0,
                'hard_bounce'          => 0,
                'conversions'          => 0,
                'opens_in_conversions' => 0,
                'appointment_set'      => 0,
                'lead_completed'       => 0,
                'webinar_registration' => 0,
               );

   foreach ($res as $client_id => $r) {

      $row['campaigns']++;
      $total['campaigns']++;
      
      foreach ($row as $key => $val) {

         if (!in_array($key, array('dept', 'campaigns')))
            $row[$key] += $r[$key];
         
      }

      $client_name = get_client_name($client_id);
      $r['client'] = " <span class='span-arrow'>&#10141;</span> " . $client_name;
      $r['campaigns'] = 1;
      $r['dialer_workflow'] = isset($r['dialer_workflow']) ? $r['dialer_workflow'] : 0;      
      $per_client[$node][$client_name] = $r;
   }
   
   $final_result[$node][] = $row;

}

if (!isset($total['dialer_workflow']))
   $total['dialer_workflow'] = 0;

$total['dept'] = 'Total';

$final_total = array_map('compute_rate', array($total));

foreach ($final_result as $node => $rows) {

   $final_result[$node] = array_map('compute_rate', $rows);   

}

foreach ($blast as $client => $val) {

   $client_name = get_client_name($client);

   $final_blast[$client_name] = array_map('compute_rate', $val);

   foreach ($val as $id => $v) {
      $final_blast[$client_name][$id]['dept'] = get_blast($id, $type);
      $final_blast[$client_name][$id]['dialer_workflow'] = "";
      $final_blast[$client_name][$id]['campaigns'] = "";
      $final_blast[$client_name][$id]['workflows'] = "";
      $final_blast[$client_name][$id]['avg_workflow'] = "";
      $final_blast[$client_name][$id]['avg_sent'] = $v['sent'];
   }

}

foreach ($per_client as $node => $value) {   
   foreach ($value as $client_id => $row) {
      
      $per_client[$node][$client_id]['campaigns']                   = "";
      $per_client[$node][$client_id]['ctr']                         = get_rate($row['clicks'], $row['opened'], 'rate') . '%';
      $per_client[$node][$client_id]['avg_sent']                    = get_rate($row['sent'], $row['campaigns'], 'avg');   
      $per_client[$node][$client_id]['avg_workflow']                = get_rate($row['workflows'], $row['campaigns'], 'avg');   
      $per_client[$node][$client_id]['click_rate']                  = get_rate($row['clicks'], $row['delivered'], 'rate') . '%';
      $per_client[$node][$client_id]['opened_rate']                 = get_rate($row['opened'], $row['delivered'], 'rate');
      $per_client[$node][$client_id]['total_bounce']                = $row['soft_bounce'] + $row['hard_bounce'];
      $per_client[$node][$client_id]['total_bounce_rate']           = get_rate($row['soft_bounce'] + $row['hard_bounce'], $row['sent'], 'rate') . '%';
      $per_client[$node][$client_id]['delivered_rate']              = get_rate($row['delivered'], $row['sent'], 'rate') . '%';
      $per_client[$node][$client_id]['soft_bounce_rate']            = get_rate($row['soft_bounce'], $row['sent'], 'rate') . '%';
      $per_client[$node][$client_id]['hard_bounce_rate']            = get_rate($row['hard_bounce'], $row['delivered'], 'rate') . '%';   
      $per_client[$node][$client_id]['conversions_opened_rate']     = get_rate($row['conversions'], $row['opened'], 'rate') . '%';   
      $per_client[$node][$client_id]['opens_in_conversions_rate']   = get_rate($row['opens_in_conversions'], $row['conversions'], 'rate') . '%';
      $per_client[$node][$client_id]['conversions_delivered_rate']  = get_rate($row['conversions'], $row['delivered'], 'rate') . '%';      

      $per_client[$node][$client_id]['sent']                        = number_format($row['sent']);
      $per_client[$node][$client_id]['opened']                      = number_format($row['opened']);
      $per_client[$node][$client_id]['delivered']                   = number_format($row['delivered']);
      $per_client[$node][$client_id]['soft_bounce']                 = number_format($row['soft_bounce']);
      $per_client[$node][$client_id]['hard_bounce']                 = number_format($row['hard_bounce']);
      $per_client[$node][$client_id]['clicks']                      = number_format($row['clicks']);
   }
}

echo json_encode(
   array(
      'team'   => $final_result, 
      'client' => $per_client, 
      'total'  => $final_total, 
      'title'  => $title,
      'blast'  => $final_blast
   )
);

function compute_rate ($row) {
   
   $row['ctr']                         = get_rate($row['clicks'], $row['opened'], 'rate') . '%';
   $row['avg_sent']                    = get_rate($row['sent'], $row['campaigns'], 'avg');   
   $row['avg_workflow']                = get_rate($row['workflows'], $row['campaigns'], 'avg');   
   $row['click_rate']                  = get_rate($row['clicks'], $row['delivered'], 'rate') . '%';
   $row['opened_rate']                 = get_rate($row['opened'], $row['delivered'], 'rate');
   $row['total_bounce']                = number_format($row['soft_bounce'] + $row['hard_bounce']);
   $row['total_bounce_rate']           = get_rate($row['soft_bounce'] + $row['hard_bounce'], $row['sent'], 'rate') . '%';
   $row['delivered_rate']              = get_rate($row['delivered'], $row['sent'], 'rate') . '%';
   $row['soft_bounce_rate']            = get_rate($row['soft_bounce'], $row['sent'], 'rate') . '%';
   $row['hard_bounce_rate']            = get_rate($row['hard_bounce'], $row['delivered'], 'rate') . '%';   
   $row['conversions_opened_rate']     = get_rate($row['conversions'], $row['opened'], 'rate') . '%';   
   $row['opens_in_conversions_rate']   = get_rate($row['opens_in_conversions'], $row['conversions'], 'rate') . '%';
   $row['conversions_delivered_rate']  = get_rate($row['conversions'], $row['delivered'], 'rate') . '%';

   $row['sent']                        = number_format($row['sent']);
   $row['opened']                      = number_format($row['opened']);
   $row['delivered']                   = number_format($row['delivered']);
   $row['soft_bounce']                 = number_format($row['soft_bounce']);
   $row['hard_bounce']                 = number_format($row['hard_bounce']);
   $row['clicks']                      = number_format($row['clicks']);

   return $row;
   
}

function get_rate($a, $b, $type) {

   $avg_rate = 0;

   if ($b == 0)
      return 0;

   switch ($type) {
      case 'avg':
         $avg_rate = round($a / $b, 2);
         break;
      case 'rate':
         $avg_rate = round(($a / $b) * 100, 2);
         break;
   }

   return $avg_rate;
   
}

function get_blast($id, $type) {

   global $database;

   $sql = "SELECT
            *
           FROM
            callbox_mailing_system.mailing_list_blasts
           WHERE
            mailing_list_blast_id = $id";

   if ($type == 'ln_mail') {

      $sql = "SELECT
               *
              FROM
               callbox_pipeline2.ln_projects
              WHERE
               ln_project_id = $id";
   // echo $sql;
   }   

   $database->query($sql);
   $res = $database->fetch_assoc();
   // echo print_r($res, true);
   return $type == 'ln_mail' ? $res['project_name'] : $res['blast_name'];

}

function get_node($dept_id) {

   global $database;

   $sql = "SELECT
            node 
           FROM
            callbox_pipeline2.hierarchy_tree
           WHERE
            hierarchy_tree_id = $dept_id";
   
   $database->query($sql);
   $res = $database->fetch_assoc();

   return empty($res) ? "No Team" : $res['node'];

}

function get_client_name($client_id) {

   global $database;

   $sql = "SELECT
            com.company 
           FROM
            callbox_pipeline2.clients 
           INNER JOIN
            callbox_pipeline2.target_details td USING (target_detail_id) 
           INNER JOIN
            callbox_pipeline2.contacts c USING (contact_id) 
           INNER JOIN
            callbox_pipeline2.targets USING (target_id) 
           INNER JOIN
            callbox_pipeline2.comp_details USING (comp_detail_id) 
           INNER JOIN
            callbox_pipeline2.companies com USING (company_id)    
           WHERE
            clients.client_id = $client_id";

   $database->query($sql);
   $res = $database->fetch_assoc();

   return $res['company'];

}

function get_inactive_clients ($date_from, $date_to) {

   global $database;

   $sql = "SELECT 
            client_id 
           FROM
            production_campaigns 
           WHERE
            x = 'inactive'
           AND
            date_from = '$date_from'
           AND
            date_to = '$date_to'";

   $database->query($sql);
   $result = array();
   
   while ($row = $database->fetch_assoc())
      $result[] = $row['client_id'];

   return $result;

}

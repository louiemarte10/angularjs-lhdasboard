<?php

require_once("{$_SERVER['DOCUMENT_ROOT']}/config/pipeline-x.php");
require("functions.php");

$database = new px_dbase();
config::connect_db($database, "pipe", "callbox_misc");

$date_start = date('Y-m-d', strtotime('-6weeks'));
$date_end = date('Y-m-d', strtotime('today'));
$type = 'weekly';

$final_result = array();
$final_total = array();   

$weekly_report = new WeeklyReport($database);

if (isset($_REQUEST['last_year'])) {
   $weekly_report->last_year = true;
   $date_start = '2021-01-01';
   $date_end = '2021-12-31';
}

$weekly = $weekly_report->get_weekly($date_start, $date_end, $type);

$cols = $weekly_report->columns;

if (!empty($weekly)) {   

   $weekly_report->get_results($weekly);
   $result = $weekly_report->get_result();
   $total = $weekly_report->get_total();

}

$result = $weekly_report->sort_dept($result);

foreach ($result as $date_key => $value) {

   foreach ($value as $dept_id => $res) {

      if (empty($res)) {
         unset($result[$date_key][$dept_id]);
         continue;
      }
   
      if (in_array($dept_id, array(43, 124)))
         $node['node'] = $dept_id == 43 ? 'MKTG APAC' : 'MKTG NAM';
      else
         $node = $weekly_report->get_node($dept_id);
      
      $param = "{$dept_id}_{$weekly_report->date_range[$date_key][$dept_id]}";
      $row = $cols;      
      $row['dept'] = "<a href='#' onclick='clientBreakdown(\"$param\")'>{$node['node']}</a>";
   
      foreach ($res as $client_id => $r) {
         $row['campaigns']++;
         $total[$date_key]['campaigns']++;
         foreach ($row as $key => $val) {
   
            if (!in_array($key, array('dept', 'campaigns')))
               $row[$key] += $r[$key];
            
         }      
      }
   
      $final_result[$date_key][] = $row;
   }
   
}

foreach ($total as $date_key => $r) {

   $row = $cols;      
   $row['dept'] = "TOTAL";

   foreach ($row as $key => $val) {

      if (!in_array($key, array('dept')))
         $row[$key] += $r[$key];

   } 

   $final_total[$date_key][] = $row;

}

foreach ($final_result as $date_key => $fin_res) {

   $final_result[$date_key] = array_map('WeeklyReport::compute_rate', $fin_res);

}

foreach ($final_total as $date_key => $fin_tot) {

   $final_total[$date_key] = array_map('WeeklyReport::compute_rate', $fin_tot);

}

echo json_encode(array('breakdown' => $final_result, 'total' => $final_total, 'test' => $weekly_report->get_inactive_clients('2022-02-21', '2022-02-26')));


<?php

/**
 * WeeklyReport Class
 */

class WeeklyReport {

   private $result = array();
   private $total = array();
   private $database = null;
   public $last_year = false;
   public $date_range = array();

   public $columns = array('campaigns'            => 0,
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

   public function __construct($db) {
      $this->database = $db;
   }

   public function get_result() {
      return $this->result;
   }

   public function get_total() {
      return $this->total;
   }

   public function get_weekly($date_start, $date_end, $type) {

      $order = $this->last_year ? 'ASC' : 'DESC';
   
      $sql = "SELECT DISTINCT 
               date_from, date_to
              FROM
               email_campaign_stats 
              WHERE
               date_from 
              BETWEEN
               '{$date_start}' AND '{$date_end}'
              AND
               report_type = '{$type}'
              ORDER BY
               date_from $order";
   
      $res = $this->database->query($sql);
   
      $data = array();
   
      while ($row = $this->database->fetch_assoc())
         $data[] = $row;
   
      return $data;
   
   }

   public function get_inactive_clients ($date_from, $date_to) {

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

      $this->database->query($sql);
      $result = array();
      
      while ($row = $this->database->fetch_assoc())
         $result[] = $row['client_id'];

      return $result;

   }

   public function get_results($weekly) {

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

      foreach ($weekly as $date) {
         extract($date, EXTR_OVERWRITE);

         $inactive = $this->get_inactive_clients($date_from, $date_to);
         
         $sql = "SELECT
                  *
                 FROM
                  callbox_misc.email_campaign_stats
                 WHERE
                  date_from = '$date_from'
                 AND
                  date_to = '$date_to'
                 /* AND
                  type = 'ln_mail' */";
   
         $this->database->query($sql);
         $date_key = "{$date_from}_{$ddate_to}";
         $date_key = date('F d', strtotime($date_from)) . ' - ' . date('F d', strtotime($date_to));
         while ($rq = $this->database->fetch_assoc()) {

            if (!empty($inactive) && in_array($rq['client_id'], $inactive))
               continue;
   
            $this->date_range[$date_key][$rq['department_id']] = "{$date_from}_{$date_to}";
   
            if (!empty($rq)) {
   
               foreach ($k as $v) {
                  $this->result[$date_key][$rq['department_id']][$rq['client_id']][$v] += $rq[$v];
                  $this->total[$date_key][$v] += $rq[$v];
               }               
   
               $this->result[$date_key][$rq['department_id']][$rq['client_id']]['workflows']++;
               $this->total[$date_key]['workflows']++;            
   
               if ($rq['dialer_workflow'] == 'yes') {
                  $this->result[$date_key][$rq['department_id']][$rq['client_id']]['dialer_workflow']++;
                  $this->total[$date_key]['dialer_workflow']++;
               }            
   
            }
   
         }
      }
   }

   public function sort_dept($arr) {

      $order = array(126, 28, 23, 18, 11, 123, 128, 284, 424);
      $diff = array_diff(array_keys($arr), $order);   
      
      $sorted = array();
   
      foreach ($order as $dept_id) {
         foreach ($arr as $date_key => $res) {
            $sorted[$date_key][$dept_id] = $arr[$date_key][$dept_id];
         }   
      }       
   
      foreach ($arr as $val) {
         $diff = array_diff(array_keys($val), $order); 
         if (!empty($diff)) {
            foreach ($diff as $dept_id) {
               foreach ($arr as $date_key => $res) {
                  $sorted[$date_key][$dept_id] = $arr[$date_key][$dept_id];
               }
            }
         }
      }
   
      return $sorted;
   
   }

   public static function compute_rate ($row) {

      $row['ctr']                         = self::get_rate($row['clicks'], $row['opened'], 'rate') . '%';
      $row['avg_sent']                    = self::get_rate($row['sent'], $row['campaigns'], 'avg');   
      $row['avg_workflow']                = self::get_rate($row['workflows'], $row['campaigns'], 'avg');   
      $row['click_rate']                  = self::get_rate($row['clicks'], $row['delivered'], 'rate') . '%';
      $row['opened_rate']                 = self::get_rate($row['opened'], $row['delivered'], 'rate');
      $row['total_bounce']                = $row['soft_bounce'] + $row['hard_bounce'];
      $row['total_bounce_rate']           = self::get_rate($row['soft_bounce'] + $row['hard_bounce'], $row['sent'], 'rate') . '%';
      $row['delivered_rate']              = self::get_rate($row['delivered'], $row['sent'], 'rate') . '%';
      $row['soft_bounce_rate']            = self::get_rate($row['soft_bounce'], $row['sent'], 'rate') . '%';
      $row['hard_bounce_rate']            = self::get_rate($row['hard_bounce'], $row['delivered'], 'rate') . '%';   
      $row['conversions_opened_rate']     = self::get_rate($row['conversions'], $row['opened'], 'rate') . '%';   
      $row['opens_in_conversions_rate']   = self::get_rate($row['opens_in_conversions'], $row['conversions'], 'rate') . '%';
      $row['conversions_delivered_rate']  = self::get_rate($row['conversions'], $row['delivered'], 'rate') . '%';

      return $row;
      
   }

   public function get_node($dept_id) {
   
      $sql = "SELECT
               node 
              FROM
               callbox_pipeline2.hierarchy_tree
              WHERE
               hierarchy_tree_id = $dept_id";
      
      $this->database->query($sql);
   
      return $this->database->fetch_assoc();
   
   }

   public function get_rate($a, $b, $type) {

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

}
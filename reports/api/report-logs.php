<?php
require("api-config.php");
require("../core/ln_report.php");
$params->required("proj_id");
$params->load("report_type");
$params->load("limit","");
$params->load("display","");
$params->load("tz","");
$params->load("dt_defined","");
$params->load("date_end","");
$params->load("date_start","");
$params->load("search_filter","");
$params->load("dataonly",false);

$ln_report = new ln_report();

if(empty($user_settings['timezone'])) $tz="UTC";
else $tz=$user_settings['timezone'];
$ln_report->tz = $tz;

date_default_timezone_set($tz);

$dt = new px_date_time;


if ($params->dt_defined) {
    switch($params->dt_defined):
        case "Today":
            $params->date_start = date("Y-m-d");
            $params->date_end = date("Y-m-d");
            break;
        case "Yesterday":
            $params->date_start = date("Y-m-d",strtotime("yesterday"));
            $params->date_end = date("Y-m-d",strtotime("yesterday"));
            break;
        case "This Week":
            $params->date_start = date('w')=='0'?date("Y-m-d"):date("Y-m-d",strtotime("last sunday"));
            $params->date_end = date("Y-m-d");//date("Y-m-d",strtotime("this saturday"));
            break;
        case "Last Week":
            $params->date_start = date('w',strtotime("-1 week"))=='0'?date("Y-m-d",strtotime("-1 week")):date("Y-m-d",strtotime("last sunday",strtotime("-1 weeks")));
            $params->date_end = date("Y-m-d",strtotime("this saturday",strtotime("-1 weeks")));
            break;
        case "This Month":
            $params->date_start = date("Y-m-")."1";
            $params->date_end = date("Y-m-d");
            break;
        case "Last Month":
            $params->date_start = date("Y-m-d", strtotime("first day of previous month") );
            $params->date_end = date("Y-m-t", strtotime("first day of previous month") );
            break;
        case "This Quarter":
            $t_q = ceil(date('m')/3);
            $t_y = date("Y");
            $params->date_start = date("Y-").(($t_q*3)-2)."-01";
            $params->date_end = date("Y-").($t_q*3)."-".date("t",strtotime($t_y.'-'.($t_q*3).'-1'));
            break;
        case "Last Quarter":
            $t_q = ceil(date('m')/3);
            $t_y = ($t_q == 1)?date("Y")-1:date("Y");
            $t_q = ($t_q == 1)?4:$t_q-1;
            $params->date_start = $t_y."-".(($t_q*3)-2)."-01";
            $params->date_end = $t_y."-".($t_q*3)."-".date("t",strtotime($t_y .'-'.($t_q*3).'-1'));
            break;
        case "This Month Last Year":
            $params->date_start = date("Y-m-d", strtotime("first day of previous month last year") );
            $params->date_end = date("Y-m-t", strtotime("first day of previous month last year") );
            break;
        case "This Year":
            $params->date_start = date("Y-")."01-01";
            $params->date_end = date("Y-m-d");
            break;
        case "Last Year":
            $params->date_start = date("Y-",strtotime("last year"))."01-01";
            $params->date_end = date("Y-",strtotime("last year"))."12-31";
            break;
        case "Date Range":
            $dts=date("M j, Y",strtotime($params->date_start));
            $dte=date("M j, Y",strtotime($params->date_end));
            $xml->add_payload("#cln_misc_dt","$dts - $dte","html");
            break;
        default: //default is month-to-date
            $params->date_start = date("Y-m-")."1";
            $params->date_end = date("Y-m-d");
            break;
    endswitch;
}
if ($params->search_filter) 
    $ln_report->search_filter = $params->search_filter;

if ($params->date_start)
     $ln_report->date_start = $params->date_start." 00:00:00";

if ($params->date_end)  
    $ln_report->date_end = $params->date_end." 23:59:59";


if ($params->report_type) 
    $ln_report->report_type = $params->report_type;

if ($params->limit) {
    $ln_report->limit = $params->limit;
    list($start,$limit) = explode(",",$params->limit);
}

$q = ln_db::query("select user_id from ln_projects where ln_project_id = ".$params->proj_id);
$rq = $q->fetch_assoc();
$ln_report->os_id = $rq['user_id'];

$report= array();
$total = 0;

/** get total contacts */
$ln_report->group_by = "lead";
$ln_report->report_type='batch_of_leads';
$ln_report->limit = 0;
//$leads = $ln_report->get_history($params->proj_id);
//$total = count($leads);
//$xml->add_payload("#cln_con_total", $total." ", 'text');
/* */

if ($params->report_type=='summary') {
    $params->load("group_by","action");
    $ln_report->report_type='batch_of_leads';
    $ln_report->group_by='action';
    $ln_report->time_grouping = "daily";
    //$ln_report->group_by =$params->group_by;
    $ln_report->limit = 0;
    if ($_GET['debug']) 
        $ln_report->debug = TRUE;

    $r = $ln_report->get_summary($params->proj_id);

    $results = $r['results'];
    $grouped = $r['grouped'];
    $lead_details = $r['lead_details'];
    $counters = $r['counters'];
    //for all sum:
    /*$txt = "Summary: <br />";
    foreach($results as $action => $data){
        $a_action=action_txt($action,count($data));
        $txt.= count($data) ." $a_action <br />";
    }*/
    if ($ln_report->group_by=="lead") {
        $txt.="<div id='ln_report_summary'>";
        if ($params->display=="by_lead") {
            $txt.="<ul>";
            foreach ($results as $lead_id=>$res) {
                $txt2 = "";
                $txt.="<li class='log'>";
                $txt2.="<dl><dt class='ln_s_contact' data-lkp-id='{$lead_id}'>".$lead_details[$lead_id]['first_name'].' '.$lead_details[$lead_id]['last_name'].
                    "</dt></dl>";
                $txt2.="<dl><dt>".$lead_details[$lead_id]['company']."</span><span class='tabLeft'>".$lead_details[$lead_id]['email']."</dt></dl>";


                foreach ($res as $null=>$det) {
                    $dt->set($det['action_date']);

                    $txt2.="<dl><dt>Last Action: ".action_title($det['action'],$det) ." ". $dt->dt("M j g:iA") ." </dt></dl>";
                    $icon = $det['action'];

                    if ($action=='send_mail' && $count[0]['action_val'] == '0000-00-00 00:00:00') 
                        $icon = "on_queue";

                    $txt .= "<div class='icon ic_{$icon}'></div><dl><dt> ";

                    if (count($count) > 1) 
                        $txt .= count($count)." ";

                    $action_txt = action_txt($action,count($count));
                    if ($action=='send_mail' && count($count) == 1 ) 
                        $action_txt = '';

                    $txt .= $action_txt;
                    if ($action=="update_status") { 
                        $exp= explode("__",$count[0]['action_val']); 
                        $txt .= ": " . $exp[1]; 
                    }

                    if ($action=="dynamic_list") 
                        $txt .= ": " . $count[0]['action_val'];

                    $txt.="</dt></dl>";
                    $txt.=$txt2;
                    break;
                }
                $txt .= "</li>";
            }
            $txt .= "</ul>";
        } else {
            foreach ($grouped as $date=>$d) {

                $txt .= "<fieldset class='ln_report_summary_f'>  <legend>$date</legend> <ul>";

                foreach($d as $lead_id => $data_a) {

                    $txt .= "<li class='log'>";
                    $actions = $counters["by_action"][$date][$lead_id];

                    foreach($actions as $action => $count) {

                        $icon = $action;

                        if ($action=='send_mail' && $count[0]['action_val'] == '0000-00-00 00:00:00') 
                            $icon = "on_queue";

                        $txt .= "<div class='icon ic_{$icon}'></div><dl><dt> ";
                        if (count($count)>1) 
                            $txt .= count($count)." ";

                        $action_txt = action_txt($action,count($count));
                        if ($action=='send_mail' && count($count) == 1 ) 
                            $action_txt = '';

                        $txt .= $action_txt;
                        if ($action=="update_status") { 
                            $exp = explode("__",$count[0]['action_val']); 
                            $txt .= ": " . $exp[1]; 
                        }
                        if ($action=="dynamic_list") 
                            $txt .= ": " . $count[0]['action_val'];

                        $txt .= "</dt></dl>";

                        break;
                    }
                    $txt .= "<dl><dt class='ln_s_contact' data-lkp-id='{$lead_id}'>".$lead_details[$lead_id]['first_name'].' '.$lead_details[$lead_id]['last_name'].
                        "</dt></dl>";
                    $txt .= "<dl><dt>".$lead_details[$lead_id]['company']."</span><span class='tabLeft'>".$lead_details[$lead_id]['email']."</dt></dl>";

                    $txt .= "</li>";
                }
                $txt .= "</fieldset>";
            }
        }
        $txt .= "</div>";
    } elseif ($ln_report->group_by=="action") {
        if ($params->display=='logs') {
            $icons_actions = "../lead-nurturing/lead-nurturing-pardot/assets/icons/actions/";
            $icons_triggers = "../lead-nurturing/lead-nurturing-pardot/assets/icons/triggers/";
            $logs = $r['logs'];
            $lead_details = $r['lead_details'];

            $converted=array();
            if ($ln_report->scheme['project_type']=='cs' && !empty($lead_details) && !empty($ln_report->scheme['client_lists'])) {
                $lists = implode(",",$ln_report->scheme['client_lists']);

                $leadsids = array_chunk(array_keys($lead_details), 200);
                foreach ($leadsids as $lids) {
                    $sql=$ln_report->conversion_sql($lids,$lists);
                    $ra = pipe_db::query($sql);
                    while ($row=$ra->fetch_assoc()) {
                        $converted[$row['target_detail_id']] = $row;
                    }

                }



                if ($_GET['debug']) 
                    lib::debug($converted,0);
            }

            $xml->add_payload("#cln_con_total", count($lead_details)." ", 'text');
            if (empty($logs)) {
                $xml->add_payload("#cln_activity_log", "&nbsp;&nbsp;&nbsp;&nbsp;No Logs", 'html');
                $xml->add_payload("#rf_activity_log", "", 'html');
                api::send_response($xml);
            }

            $total = count($lead_details);
            $xml->add_payload("#cln_con_total", $total." ", 'text');
            $txt.="<div id='ln_report_summary' class='ln_report_logs'>";
            $txt.="<ul>";
            $scount=0;
            $opens = 0;
            $clicks=0;
            $delivered = 0;

            foreach ($logs as $n => $det) {

                $scount++;
                $lead_id = $det['lead_id'];

                $lead_txt="";
                $misc_txt = "";

                if ($det['client_stream_id']) 
                    $stream = "data-stream-id='".$det['client_stream_id']."'";
                else 
                    $stream =  "";

                $lead_txt.="<dl><dt class='ln_contact' data-lkp-id='{$lead_id}' {$stream}><b>".$det['first_name'].' '.$det['last_name']."
				&nbsp &nbsp &nbsp ".pipe::format_phone_num($det['target'])."</b></dt></dl>";
                $lead_txt.="<dl><dt>".$det['company']."</dt></dl>
				<dl><dt>".$det['email']."</dt></dl>";

                $log_class="log_".$det['action'];

                $icon = $det['action'];
                $misc_det = "";
                $been_opened = 0;
                $bounced = 0;
                switch ($det['action']):
                    case 'send_mail':

                        if ($count[0]['action_val']== '0000-00-00 00:00:00') 
                            $icon = "on_queue";

                        if (strlen($det['event_receipts'])>2) {

                            $x= explode("||", $det['event_receipts']);

                            if ($x[0]=='open') {
                                $been_opened = 1;
                                $dt->set($x[1]);
                                $opened_date = $dt->dt("M j, Y g:iA");
                                $opdate = $x[1];
                                $opens++;
                            } elseif($x[0]=='bounce') {
                                $bounced = 1;
                                $log_class .= " log_bounced_mail";
                            }

                            if (!$bounced) {
                                $log_class .= " log_delivered_mail";
                                $delivered++;
                            }

                            if ($_GET['debug']) 
                                echo $x[0]."<br />";

                        }
                        if ($det['misc']) {
                            $misc_m = explode("__",$det['misc']);
                            $misc_txt ="<dl><dt>Subject: ". $misc_m[1]."</dt></dl>";
                        }
                        break;
                    /*case 'rem_to_am':
                        $icon = "reminder";
                    break;*/

                endswitch;

                if ($been_opened) { //add another li if opened
                    $txt.="<li class='log trigger_log log_opened_mail' data-dt='{$opdate}'>";
                    $txt.="<div class='icon'><img src='{$icons_triggers}icon-opened-mail.png' /></div>";
                    $txt.="<div class='actvt_log_col'>";
                    $txt.=$lead_txt;
                    $txt.="</div>";
                    $txt.="<div class='actvt_log_col'>";
                    $txt.="<dl><dt><b>Opened Email <br /></b>$opened_date</dt></dl>";
                    $txt.="</div>";
                    $txt.="</li>";
                    $actions_filter['opened_mail']="Email Opened";
                }

                $txt.="<li class='log action_log {$log_class}' dt-log-id='".$det['ln_log_id']."' dt-count='{$scount}' data-dt='{$det['action_date']}'>";

                $img= str_replace("_","-",$det['action']);
                $txt.="<div class='icon'><img src='{$icons_actions}icon-{$img}.png' /></div>";
                //$txt.="<div class='icon ic_{$icon}'></div>";
                $txt.="<div class='actvt_log_col'>";
                $txt.=$lead_txt;
                $txt.="</div>";
                $txt.="<div class='actvt_log_col'>";
                $dt->set($det['action_date']);
                $action_title = ucwords(action_title($det['action'],$det));
                $txt.="<dl><dt><b>".$action_title;

                if ($det['action']!='update_status') 
                    $actions_filter[$det['action']]=$action_title;

                if ($det['action']=="update_status") {
                    $exp= explode("__",$det['action_val']); $txt.= ": ".$exp[1];
                    $actions_filter[$det['action']]=$action_title.": ".$exp[1];
                }

                if ($det['action']=="dynamic_list") 
                    $txt.=": ".$det['action_val'];

                $txt.=" </b><br />". $dt->dt("M j, Y g:iA") ." </dt></dl>";

                if ($misc_txt) 
                    $txt.=$misc_txt;

                $txt.="</div>";
                $txt.="</li>";


                if (!empty($det['clicks'])) {
                    foreach ($det['clicks'] as $cl)	{
                        $clicks++;
                        $dt->set($cl['date_time']);
                        $txt.="<li class='log trigger_log log_clicked_link' dt-log-id='' dt-count='' data-dt='{$cl['date_time']}'>";
                        $txt.="<div class='icon'><img src='{$icons_triggers}icon-clicker.png' /></div>";		 /*ic_clicked_link*/
                        $txt.="<div class='actvt_log_col'>";
                        $txt.=$lead_txt;
                        $txt.="</div>";
                        $txt.="<div class='actvt_log_col'>";
                        $txt.="<dl><dt><b>Clicked Link</b><br />".$cl['url']." <br />". $dt->dt("M j, Y g:iA") ."</dt></dl>";
                        $txt.="</div>";
                        $txt.="</li>";
                        $actions_filter['clicked_link']="Clicked Link";
                    }
                }

            }


            if (!empty($converted)) {
                foreach ($converted as $tdid=>$det) {
                    $info = $lead_details[$tdid];

                    if ($info['client_stream_id']) 
                        $stream = "data-stream-id='".$info['client_stream_id']."'";
                    else 
                        $stream =  "";

                    $dt->set($det['date_called']);
                    $txt.="<li class='log action_log log_converted' dt-log-id='' data-dt='".$dt->dt("Y-m-d H:i:s")."'>";
                    $txt.="<div class='icon'><img src='{$icons_actions}icon-make-call.png' /></div>";
                    $txt.="<div class='actvt_log_col'>";
                    $txt.="<dl><dt class='ln_contact' {$stream}><b>".$info['first_name'].' '.$info['last_name']."&nbsp &nbsp &nbsp ".pipe::format_phone_num($info['target'])."</b></dt></dl>";
                    $txt.="<dl><dt>".$info['company']."</dt></dl> <dl><dt>".$info['email']."</dt></dl>";
                    $txt.="</div>";
                    $txt.="<div class='actvt_log_col'>";
                    $txt.="<dl><dt><b>".$det['event_state']."</b><br />". $dt->dt("M j, Y g:iA") ."</dt></dl>";
                    $txt.="</div>";
                    $txt.="</li>";
                }
            }
            /*if(in_array($lead_id,array_keys($converted))){
                $dt->set($converted[$lead_id]['date_called']);
                $txt.="<li class='log action_log log_converted' dt-log-id='' dt-count=''>";
                    $txt.="<div class='icon'><img src='{$icons_actions}icon-make-call.png' /></div>";
                    $txt.="<div class='actvt_log_col'>";
                    $txt.=$lead_txt;
                    $txt.="</div>";
                    $txt.="<div class='actvt_log_col'>";
                    $txt.="<dl><dt><b>".$converted[$lead_id]['event_state']."</b><br />".$cl['url']." <br />". $dt->dt("M j, Y g:iA") ."</dt></dl>";
                    $txt.="</div>";
                $txt.="</li>";
            }*/

            $txt.="</ul>
			</div>";
            $misc="";
            $summary = $r['results'];

            if ($opens) 
                $summary['opened emails']=$opens;
            if ($clicks) 
                $summary['clicks']=$clicks;

            $action_array = array('send_mail','opened_emails','clicks','dynamic_list', 'update_status', 'reminder', 'rem_to_am', 'make_call', 'call_priority', /*'delivered mail'*/);
            $aclass = array('opened_emails'=>'num_opened_mail','clicks'=>'num_clicked_link');
            $total_actions = 0;
            foreach ($action_array as $a) {

                if (!empty($summary[$a])) {
                    $atitle = ucwords(action_title($a,array('count'=>2)));
                    $count_a = count($summary[$a]);
                    if($a=='opened emails' || $a=='clicks') $count_a = $summary[$a];
                    if($a=='delivered mail') $count_a = $delivered;
                    $clas = isset($aclass[$a])?$aclass[$a] : "num_".$a;
                    $misc .= "<div class='rf-2 {$clas}'>".
                        "<span>$atitle</span>
					<b class='num'>".$count_a."</b>
					</div>";

                    if ($a=='opened emails' || $a=='clicks') 
                        continue;

                    $total_actions+=$count_a;
                }

                /* added by aL 2015-07-08 */

                $xml->add_payload("#".$a, $count_a, 'text');


            }

            if ($params->dataonly) 
                api::send_response($xml);

            if ($_GET['debug']) 
                lib::debug($r['results'],0);

            $misc .= "<div class='rf-2' id='log_total_actions'>".
                "<span>Total No. of Actions</span>
					<b class='num'>".$total_actions."</b>
					</div>";
            $filters = "<option value='all'>All</option>";

            if (!empty($actions_filter)) {
                asort($actions_filter);

                foreach ($actions_filter as $v => $filter) 
                    $filters .= "<option value='log_{$v}'>$filter</option>";
                
            }

            if (!empty($converted)) 
                $filters .= "<option value='log_converted'>Converted</option>";

            if ($_GET['debug']) {
                echo "_______"; 
                lib::debug($actions_filter);
            }

            $xml->add_payload("#cln_activity_log", $txt, 'html');
            $xml->add_payload("#rf_activity_log", $misc, 'html');
            $xml->add_payload("#log_filters", $filters, 'html');
            api::send_response($xml);

        }

        //by hour
        $txt .= "<div id='ln_report_summary'>";

        if ($params->display=='minimal') {

            foreach ($grouped as $date=>$d) {

                $dt_count= $counters["by_date"][$date];
                $txt.= "<fieldset class='ln_report_summary_f'>  <legend>$date</legend> <ul>";
                $scount=0;
                $txt.= "<li><dl>";

                foreach ($d as $action=>$data_a) {
                    $count = $data_a['count'];
                    $data = $data_a['data'];
                    $a_action = action_txt($action,$count);
                    $icon = $action;
                    $txt .= "<dt>$count  $a_action</dt>";
                }

                $txt .= "</dl></li>";
                $txt .= "</ul></fieldset>";

            }

        } else {

            foreach ($grouped as $date=>$d) {
                $dt_count= $counters["by_date"][$date];
                $txt.= "<fieldset class='ln_report_summary_f'>  <legend>$date</legend> <ul>";
                $scount=0;

                foreach ($d as $action=>$data_a) {

                    $count = $data_a['count'];
                    $data = $data_a['data'];
                    $a_action = action_txt($action,$count);
                    $icon = $action;
                    $txt .= "<li class='ln_summary_action_text'>$count  $a_action</li>";
                    foreach ($data as $lead_id=>$d) {

                        $scount++;

                        if ($scount==$dt_count) 
                            $sc="";
                        else 
                            $sc="log";

                        $misc_label="";
                        $det = $d[0];
                        $txt.= "
						<li class='{$sc}' data-stream-id='{$det['client_stream_id']}' data-log-id='{$det['ln_log_id']}'>";
                        $icon = $action;
                        if ($action=="send_mail") {

                            $misc_label = action_txt("check sent",$d);
                            //$txt.= "<dl><dt>".$misc_label."</dt></dl>" ;
                            if (preg_match("/queue/",$misc_label)) 
                                $icon = "on_queue";

                        }
                        $txt .= "<div class='icon ic_{$icon}'>";

                        if (count($d) > 1) 
                            $txt.="<span class='action_count'> ".count($d)."</span>";
                        else 
                            $txt .= "&nbsp;";

                        $txt.="</div>";
                        //				if(count($d)>1) $txt .= "<div class='icon2'></div>";

                        //$txt .= "<div class='icon ic_{$action}'>&nbsp;</div>";
                        $txt .= "<dl><dt class='ln_s_contact' data-lkp-id='{$lead_id}'>".$d['first_name'] ." ". $d['last_name']. "
						<span class='s_misc_detail' >" . $d['email']."</span></dt></dl>";
                        $txt .= "<dl><dt>". $d['company']."</dt></dl>";

                        if ($action == "dynamic_list") 
                            $txt.= "<dl><dt> List: ". $det["action_val"] . "</dt></dl>";

                        $txt .= "</li>";
                        //$txt.="<br />";
                    }
                }
                $txt.="</ul></fieldset>";
            }
        }

        $txt.="</div>";
    }
    $xml->add_payload("#ln_report_stream", $txt, 'html');
    $xml->add_ln_leads_count("",$total);

}

api::send_response($xml);

function display_num($num) {

    if (empty($num)) 
        return 0;

    return number_format($num);
}

function action_title($action,$det) {
    switch($action):
        case "dynamic_list":
            $a_action="added to list";
            break;
        case "send_mail":  $a_action="email sent";
            if(isset($det['action_val']) && $det['action_val']== "0000-00-00 00:00:00") $a_action="email queued";
            if($det['count']>1) $a_action ="emails sent";
            break;
        case "update_status": $a_action="updated status";
            break;
        case "reminder":
            $a_action=$action;
            if($det['count']>1) $a_action ="reminders";
            break;
        case "rem_to_am":
            $a_action="remind Account Manager";
            break;
        case "make_call":
            $a_action="reminder to make a call";
            break;
        default: $a_action = str_replace("_"," ",$action);
            break;

    endswitch;
    return $a_action;
}

function action_txt($action, $c = 0) {
    switch($action):
        case "dynamic_list": $a_action="added to list";
            break;
        case "send_mail":
            $a_action="emails";
            if($c < 2) $a_action = "email";
            break;
        case "reminder":
            $a_action="reminders";
            if($c < 2) $a_action = "reminder";
            break;
        case "update_status":
            $a_action="status updates";
            if($c < 2) $a_action ="status update";
            break;
        case "check sent":
            $sent = 0;
            $queued = 0;
            foreach($c as $emails){
                if($emails['mail_event_details']['sent']!='0000-00-00 00:00:00') $sent++;
                else $queued++;
            }
            if($sent>0) $a_action[] = $sent."sent";
            if($queued>0) $a_action[] = $queued."on queue";
            $a_action = implode(", ",$a_action);
            break;
        default: $a_action = $action;
            break;
    endswitch;

    return $a_action;
}
?>


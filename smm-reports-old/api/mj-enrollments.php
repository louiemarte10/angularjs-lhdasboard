<?php
require "{$_SERVER['DOCUMENT_ROOT']}/config/pipeline-x.php";

px_login::init();

$params = new px_params();
$db = new mysqli(config::get_server_by_user('pipe'), 'app_pipe', config::get_db_user_password('pipe'), 'callbox_pipeline2');

$params->required('schemes');
$params->load("dt_defined");
$params->load("dt_from");
$params->load("dt_to");

if($params->dt_defined){
    switch($params->dt_defined){
        case "Today":
            $params->dt_from = date("Y-m-d");
            $params->dt_to = date("Y-m-d");
            break;
        case "Yesterday":
            $params->dt_from = date("Y-m-d",strtotime("yesterday"));
            $params->dt_to = date("Y-m-d",strtotime("yesterday"));
            break;
        case "This Week":
            $params->dt_from = date('w')=='0'?date("Y-m-d"):date("Y-m-d",strtotime("last sunday"));
            $params->dt_to = date("Y-m-d");
            break;
        case "Last Week":
            $params->dt_from = date('w',strtotime("-1 week"))=='0'?date("Y-m-d",strtotime("-1 week")):date("Y-m-d",strtotime("last sunday",strtotime("-1 weeks")));
            $params->dt_to = date("Y-m-d",strtotime("this saturday",strtotime("-1 weeks")));
            break;
        case "This Month":
            $params->dt_from = date("Y-m-")."1";
            $params->dt_to = date("Y-m-d");
            break;
        case "Last Month":
            $params->dt_from = date("Y-m-d", strtotime("first day of previous month") );
            $params->dt_to = date("Y-m-t", strtotime("first day of previous month") );
            break;
        case "This Quarter":
            $t_q = ceil(date('m')/3);
            $t_y = date("Y");
            $params->dt_from = date("Y-").(($t_q*3)-2)."-01";
            $params->dt_to = date("Y-").($t_q*3)."-".date("t",strtotime($t_y.'-'.($t_q*3).'-1'));
            break;
        case "Last Quarter":
            $t_q = ceil(date('m')/3);
            $t_y = ($t_q == 1)?date("Y")-1:date("Y");
            $t_q = ($t_q == 1)?4:$t_q-1;
            $params->dt_from = $t_y."-".(($t_q*3)-2)."-01";
            $params->dt_to = $t_y."-".($t_q*3)."-".date("t",strtotime($t_y .'-'.($t_q*3).'-1'));
            break;
        case "This Month Last Year":
            $params->dt_from = date("Y-m-d", strtotime("first day of previous month last year") );
            $params->dt_to = date("Y-m-t", strtotime("first day of previous month last year") );
            break;
        case "This Year":
            $params->dt_from = date("Y-")."01-01";
            $params->dt_to = date("Y-m-d");
            break;
        case "Last Year":
            $params->dt_from = date("Y-",strtotime("last year"))."01-01";
            $params->dt_to = date("Y-",strtotime("last year"))."12-31";
            break;
        case "Date Range":
            $dts=date("M j, Y",strtotime($params->dt_from));
            $dte=date("M j, Y",strtotime($params->dt_to));
            break;
        default: //default is month-to-date
            $params->dt_from = date("Y-m-")."1";
            $params->dt_to = date("Y-m-d");
            break;
	}
}

$res = $db->query(
	$sql = "SELECT CONCAT(company, ': ', project_name) AS scheme, COUNT(*) AS cnt
	 FROM mailjet_workflows wf
	 INNER JOIN mailjet_list_subscriptions sub ON sub.mj_workflow_id = wf.mailjet_workflow_id
	 INNER JOIN ln_projects USING (ln_project_id)
	 INNER JOIN clients cl ON cl.client_id = wf.client_id
	 INNER JOIN target_details td ON td.target_detail_id = cl.target_detail_id
	 INNER JOIN comp_details USING (comp_detail_id)
	 INNER JOIN companies USING (company_id)
	 WHERE ln_project_id IN (" . implode(',', $params->schemes) . ")
		AND date_added BETWEEN '{$params->dt_from} 00:00:00' AND '{$params->dt_to} 23:59:59'
	 GROUP BY ln_project_id
	 ORDER BY scheme"
);

echo "<pre>Under Construction</pre>";
echo "<table>";
echo "<tr><th>Scheme</th><th>Enrolled</th></tr>";
while ($row = $res->fetch_assoc()){
	echo "<tr><td>{$row['scheme']}</td><td>{$row['cnt']}</td></tr>";
}
echo "</table>";

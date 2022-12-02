<?php
require("config.php");
$date_from = date("Y-m-d H:i:s");

//to do: get min ln_log_id for this day
/*for($x=0 ; $x<=40; $x++){
	
	
	$x
	if($x2 > 5) break;	
}*/

$sql = "SELECT count(*) c, action 
	FROM  `ln_logs` 
	INNER JOIN ln_actions
	USING (  `ln_action_id` ) 
	WHERE  `ln_log_id` >=81400195
	AND date_inserted >  '2015-10-02 09:00:00'
	AND  `ln_action_id` !=0
	AND ACTION !=  'go_to' group by action";
	
db::query($sql);
$json_array = array();
while ($row = db::fetch_assoc()):	
	if($row['action'] == 'make_call') $row['action'] = 'reminder';	
	if(isset($json_array[$row['action']])) $json_array[$row['action']]['c'] += $row['c'];
	else $json_array[$row['action']] = $row;	
endwhile;

if ( !empty($json_array))
{
	echo json_encode($json_array);	
}	
?>
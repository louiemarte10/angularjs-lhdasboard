<?php 
require_once("{$_SERVER['DOCUMENT_ROOT']}/config/pipeline-x.php");
 $getParentID = $_REQUEST['no'] ?: 0;
 $date_from = $_REQUEST['from'];
  $date_to = $_REQUEST['to'];



 $getDept = mysqli_fetch_array(mysqli_query($conn, "
SELECT   team.node as team_name, ht2.node as htnodess, team.parent_id
FROM `hierarchy_tree` as team 
inner join hierarchy_tree ht2 on (team.parent_id = ht2.hierarchy_tree_id)
where  team.parent_id = '$getParentID' "));
 

$getDepartment = mysqli_query($conn, "SELECT DISTINCT  team.parent_id , ht2.node as htnodes
FROM `social_media_report` 
inner join employees e using (user_id)
inner join role_details using (user_id)
inner join hierarchy_tree_details htd using (user_id)
inner join hierarchy_tree as team using (hierarchy_tree_id)
inner join hierarchy_tree ht2 on (team.parent_id = ht2.hierarchy_tree_id)

where date_from > '2022-06-01' AND role_lkp_id = 154 and htd.x='active'  
group by e.user_id order by htnodes asc");

$getAll = "SELECT DISTINCT  team.parent_id , ht2.node as htnodes
FROM `social_media_report` 
inner join employees e using (user_id)
inner join role_details using (user_id)
inner join hierarchy_tree_details htd using (user_id)
inner join hierarchy_tree as team using (hierarchy_tree_id)
inner join hierarchy_tree ht2 on (team.parent_id = ht2.hierarchy_tree_id)

where date_from > '2022-06-01' AND role_lkp_id = 154 and htd.x='active'  
group by e.user_id order by htnodes asc";

$all_dept = array();

$res = $conn->query($getAll);

while ($row = $res->fetch_assoc()) {
	$all_dept[] = $row['parent_id'];
}


$getPersona = @mysqli_query($conn, "
	SELECT  user_id , first_name , last_name, team.node as team_name, ht2.node, team.parent_id
	FROM `social_media_report` 
	inner join employees e using (user_id)
	inner join role_details using (user_id)
	inner join hierarchy_tree_details htd using (user_id)
	inner join hierarchy_tree as team using (hierarchy_tree_id)
	inner join hierarchy_tree ht2 on (team.parent_id = ht2.hierarchy_tree_id)
	where htd.x='active' and team.parent_id IN ($getParentID) AND e.x = 'active' AND  htd.hierarchy_tree_id NOT IN (5,88)
	group by e.user_id order by first_name desc
		");


$getPersona2 = mysqli_query($conn, "
SELECT  user_id , first_name , last_name, team.node as team_name, ht2.node, team.parent_id
FROM `social_media_report` 
inner join employees e using (user_id)
inner join role_details using (user_id)
inner join hierarchy_tree_details htd using (user_id)
inner join hierarchy_tree as team using (hierarchy_tree_id)
inner join hierarchy_tree ht2 on (team.parent_id = ht2.hierarchy_tree_id)
where  htd.x='active' and team.parent_id = '$getParentID' AND e.x = 'active' AND  htd.hierarchy_tree_id NOT IN (5,88)
group by e.user_id order by first_name desc
	");



$countWeeklyBranded = mysqli_fetch_assoc(mysqli_query($conn, "
	SELECT  user_id , first_name , last_name, team.node as team_name, ht2.node, team.parent_id
FROM `social_media_report` 
inner join employees e using (user_id)
inner join role_details using (user_id)
inner join hierarchy_tree_details htd using (user_id)
inner join hierarchy_tree as team using (hierarchy_tree_id)
inner join hierarchy_tree ht2 on (team.parent_id = ht2.hierarchy_tree_id)
where htd.x='active' and team.parent_id = '$getParentID'  AND  htd.hierarchy_tree_id NOT IN (5,88)
group by e.user_id order by ht2.branch_type,  parent_id, team.node
"));



function get_last_day_of_the_week ($date_from) {
	
	$month = date("n", strtotime($date_from));
	$time = strtotime($date_from);
	$next = strtotime('next friday, 11:59am', $time);
	$friday =  date('Y-m-d', $next);
	$x = date("n", strtotime($friday));

	while ($month != $x) {
		$friday = date('Y-m-d', strtotime("-1 day", strtotime($friday)));
		$x = date("n", strtotime($friday));
	}
	
	return $friday;

}

function get_monday_of_the_week($date = null)
{
    if ($date instanceof \DateTime) {
        $date = clone $date;
    } else if (!$date) {
        $date = new \DateTime();
    } else {
        $date = new \DateTime($date);
    }
    
    $date->setTime(0, 0, 0);
    
    if ($date->format('N') == 1) {        
        return $date->format('Y-m-d');
    } else {
			$date->modify('last monday');
        return $date->format('Y-m-d');
    }
}

function get_points ($user_id, $date_from, $date_to) {
	global $conn;

	$sql = "SELECT 
	  			SUM(txn.points) AS points, etxn.event_state_lkp_id
			  FROM
			   events_incentive_lkp lkp
			  INNER JOIN
			   events_incentive_txn txn USING(event_incentive_lkp_id)
			  INNER JOIN
				events_tm_ob_txn etxn USING(event_tm_ob_txn_id)
			  WHERE
			   lkp.user_id = $user_id
			  AND
			   CONVERT_TZ( CONCAT_WS( ' ', lkp.date_event, txn.time_event ) , 'utc', 'asia/manila' ) BETWEEN '$date_from 00:00:00' AND '$date_to 23:59:59' AND etxn.event_state_lkp_id != 25
			  GROUP BY lkp.user_id, etxn.event_state_lkp_id";

	$res = $conn->query($sql);
	$result = array();

	while ($row = $res->fetch_assoc()) {
		$result[$row['event_state_lkp_id']] = $row;
	}

	return $result;
}

 
 ?>
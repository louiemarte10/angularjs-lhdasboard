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
 
 
$all_owner = array();
$getOwnerPersona =  "SELECT pipe_user_id FROM `linkedin_account_persona` where pipe_user_id != '0' ";
$resOwnerPersona = $conn_lh->query($getOwnerPersona);
while($rowOwner = $resOwnerPersona->fetch_array()) { 
	$all_owner[] = $rowOwner['pipe_user_id'];
}

   $smmOwner = json_encode($all_owner);
   $phrase1 = array('[', ']');
   $phrase2   = array(" ", " ");
   $smmOwnerID = str_replace($phrase1, $phrase2, $smmOwner);



// $getAll = "SELECT DISTINCT  team.parent_id , ht2.node as htnodes
// FROM `social_media_report` 
// inner join employees e using (user_id)
// inner join role_details using (user_id)
// inner join hierarchy_tree_details htd using (user_id)
// inner join hierarchy_tree as team using (hierarchy_tree_id)
// inner join hierarchy_tree ht2 on (team.parent_id = ht2.hierarchy_tree_id)
// where date_from > '2022-06-01' AND role_lkp_id = 154 and htd.x='active'  
// group by e.user_id order by htnodes asc";


   $getAll = "SELECT DISTINCT  team.parent_id , ht2.node as htnodes, ht2.report_grp as report_grp
			FROM `employees`  as e
			inner join hierarchy_tree_details htd using (user_id)
			inner join hierarchy_tree as team using (hierarchy_tree_id)
			inner join hierarchy_tree ht2 on (team.parent_id = ht2.hierarchy_tree_id)
			where e.user_id IN ($smmOwnerID) and htd.x='active'  
			group by e.user_id order by  report_grp ASC, htnodes ASC";

$all_dept = array();

$res = $conn->query($getAll);
$resDepartment = $conn->query($getAll);
while ($row = $res->fetch_assoc()) {
	$all_dept[] = $row['parent_id'];
}
 $personas2 = array();

$personas = array();

// $getPersona =    "
// 	SELECT  user_id , first_name , last_name, team.node as team_name, ht2.node, team.parent_id
// 	FROM `social_media_report` 
// 	inner join employees e using (user_id)
// 	inner join role_details using (user_id)
// 	inner join hierarchy_tree_details htd using (user_id)
// 	inner join hierarchy_tree as team using (hierarchy_tree_id)
// 	inner join hierarchy_tree ht2 on (team.parent_id = ht2.hierarchy_tree_id)
// 	where htd.x='active' and team.parent_id IN ($getParentID) AND e.x = 'active' AND  htd.hierarchy_tree_id NOT IN (5,88)
// 	group by e.user_id order by first_name desc
// 		" ;

$getPersona = "
			SELECT  user_id , first_name , last_name, team.node as team_name, ht2.node, team.parent_id
			FROM `employees` as e 
			inner join hierarchy_tree_details htd using (user_id)
			inner join hierarchy_tree as team using (hierarchy_tree_id)
			inner join hierarchy_tree ht2 on (team.parent_id = ht2.hierarchy_tree_id)
			where htd.x='active' and team.parent_id IN ($getParentID) AND e.x = 'active' AND  htd.hierarchy_tree_id NOT IN (5,88)
			group by e.user_id order by first_name desc;
			";

 
$result_persona = $conn->query($getPersona);
$result_persona2 = $conn->query($getPersona);
 while($rowPersonaid = $result_persona->fetch_array()) { 
$personas[$rowPersonaid['user_id']] = $rowPersonaid;

 }
 
 
// foreach ($personas as $per) {


//  $getpersonaLH = "SELECT * FROM linkedin_account_persona where pipe_user_id = '".$per['user_id']."' ";
 

//   }
// $result2 = $conn_lh->query($getpersonaLH);
 
 
// while($row = $result2->fetch_array()){

// $personas[$row['pipe_user_id']] = $row;
// }
 

// $countWeeklyBranded = mysqli_fetch_assoc(mysqli_query($conn, "
// 	SELECT  user_id , first_name , last_name, team.node as team_name, ht2.node, team.parent_id
// FROM `social_media_report` 
// inner join employees e using (user_id)
// inner join role_details using (user_id)
// inner join hierarchy_tree_details htd using (user_id)
// inner join hierarchy_tree as team using (hierarchy_tree_id)
// inner join hierarchy_tree ht2 on (team.parent_id = ht2.hierarchy_tree_id)
// where htd.x='active' and team.parent_id = '$getParentID'  AND  htd.hierarchy_tree_id NOT IN (5,88)
// group by e.user_id order by ht2.branch_type,  parent_id, team.node
// "));

 
function get_last_day_of_the_week ($date_from) {
	
	  $dates = $_REQUEST['to'];
	  $getDates = date("n", $dates);
	  $getMonth = $getDates;

	$month = date($getMonth, strtotime($date_from));
	$time = strtotime($date_from);
	 $next = strtotime('next saturday, 11:59am', $time);

	$friday =  date('Y-m-d', $next);
	$x = date($getMonth, strtotime($friday));

	while ($month != $x) {
		$friday = date('Y-m-d', strtotime("-1 day", strtotime($friday)));
		$x = date($getMonth, strtotime($friday));
	}
	
	return $friday;

}


function get_first_week ($date_from) {
	
	  $dates = $_REQUEST['to'];
	  $getDates = date("n", $dates);
	  $getMonth = $getDates;

	$month = date($getMonth, strtotime($date_from));
	$time = strtotime($date_from);

	// if ($date_from->format('N') == 7) {  
	// 	 $next = strtotime('last monday, 12:00am', $time);
	// }else{
		 $next = strtotime('last sunday, 11:59pm', $time);
	// }

	

	$sun =  date('Y-m-d', $next);
	$x = date($getMonth, strtotime($sun));

	while ($month != $x) {
		$sun = date('Y-m-d', strtotime("-1 day", strtotime($sun)));
		$x = date($getMonth, strtotime($sun));
	}
	
	return $sun;

}


 

// function get_first_week($date = null)
// {
//     if ($date instanceof \DateTime) {
//         $date = clone $date;
//     } else if (!$date) {
//         $date = new \DateTime();
//     } else {
//         $date = new \DateTime($date);
//     }
    
//     $date->setTime(0, 0, 0);
    
//     if ($date->format('N') == 1) {        
//         return $date->format('Y-m-d');
//     }
//     // else if($date->format('N') == 7){
//     // 	$date->modify('this sunday');
//     //     return $date->format('Y-m-d');
//     // } 
//     else {
// 			$date->modify('last monday');
//         return $date->format('Y-m-d');
//     }
// }


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


function get_inviteLH ($user_id,$date_from, $date_to) {
	global $conn_lh;

 

	$query_LHinvite = "SELECT COUNT(*) AS cnt_invitesLH,  di.contact_date_added as cda, lap.pipe_user_id  
			 FROM `data_info` di 
             INNER JOIN linkedin_account_persona as lap USING(linkedin_account_persona_id) 
             WHERE contact_date_added BETWEEN CONVERT_TZ('$date_from 00:00:00', 'Asia/Manila','UTC') 
             AND CONVERT_TZ('$date_to 23:59:00', 'Asia/Manila','UTC') 
             AND pipe_user_id = $user_id
             GROUP BY WEEK(contact_date_added)";


          

	$res = $conn_lh->query($query_LHinvite);
	$resultLH_invite = array();
 
		 while($rowLH_invite = $res->fetch_assoc()){
		$resultLH_invite[$rowLH_invite['pipe_user_id']] = $rowLH_invite;
		 
	}

	return $resultLH_invite;
}



function get_connectionLH ($user_id, $date_from, $date_to) {
	global $conn_lh;
 

	$query_LHconnected = "SELECT COUNT(*) AS cnt_connectedLH,  di.contact_date_added as cda, lap.pipe_user_id, di.date_connected as date_connected  
			 FROM `data_info` di 
             INNER JOIN linkedin_account_persona as lap USING(linkedin_account_persona_id) 
             WHERE contact_date_added BETWEEN CONVERT_TZ('$date_from 00:00:00', 'Asia/Manila','UTC') 
             AND CONVERT_TZ('$date_to 23:59:00', 'Asia/Manila','UTC') 
             AND pipe_user_id = $user_id
             AND date_connected is NOT NULL
             GROUP BY WEEK(contact_date_added)";

	$res = $conn_lh->query($query_LHconnected);
	$resultLH_connected = array();
 
		 while($rowLH_connected = $res->fetch_assoc()){
		$resultLH_connected[$rowLH_connected['pipe_user_id']] = $rowLH_connected;
		 
	}

	return $resultLH_connected;
}

 
 ?>
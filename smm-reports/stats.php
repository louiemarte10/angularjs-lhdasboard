<?php
 
require('api/config.php');
   require('api/query.php');
   // require('includes/timezone.php');
 
$total_points = array();


?>
 
 
  <link rel="stylesheet" type="text/css" href="/framework/js/3rd-party/jquery/css/ui-smoothness/smoothness.css">

  <link rel="stylesheet" type="text/css" href="res/style.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
  <link href="https://raw.githack.com/ttskch/select2-bootstrap4-theme/master/dist/select2-bootstrap4.css" rel="stylesheet">  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script>
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
   <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
 
   <script>
  $( function() {
    // $( "#datepickerSaveSend" ).datepicker();
      // $(".dateRanges").html("<b style = \'margin-right:3%;\'>Date And Time Range</b>From: <input type='text' id='from_datepicker' class='datepicker'/>&nbsp; <input type='time' id='from_timepicker' class='timepickerpicker' value = '<?php echo $date_from; ?>' style = \'margin-right:5%;\'/>" +
      //           " To: <input type='text' class='datepicker' id='to_datepicker'/>&nbsp; <input type='time' id='to_timepicker' class='timepickerpicker'/>  ");
      //       $(".datepicker").datepicker({ dateFormat: "yy-mm-dd" });
  } );

  function showHideBreakdown() {

    const tables = document.getElementsByClassName('hidden-table')

    for (let i = 0; i < tables.length; i++) {
      tables[i].classList.toggle('display-table')
    }

  }

  function selects(){  
                var ele=document.getElementsByName('chk');  
                for(var i=0; i<ele.length; i++){  
                    if(ele[i].type=='checkbox')  
                        ele[i].checked=true;  
                }  
            }  
            function deSelect(){  
                var ele=document.getElementsByName('chk');  
                for(var i=0; i<ele.length; i++){  
                    if(ele[i].type=='checkbox')  
                        ele[i].checked=false;  
                      
                }  
            }        


  </script>
    <style>
.datepicker{

    padding: 2px !important;

  }
 #get_deptID{
  height: 35px;
  
 } 
 #th1{
  padding: 2% 0 1px 0 !important;
}

 #btn_toggle_display_mode, #cb_subheader{
  display: none!important;
}
.header-fixed.subheader-fixed.subheader-enabled .wrapper {
  padding-top: 50px;
}
.inner-container{
  background: #dddddd;
  margin: 5px 2% 0 2%;

  padding: 15px 15px;

}


.inner-container2{

  margin: 0px 2% 0 2%;

}



.companies-scheme{ 

  max-height: 500px;
  white-space: nowrap;
  overflow-x: auto;
  border: solid 1px #F5F1F1;
  background-color: #FDFDFD;
/*display: grid;*/


}

.nav-tabs>li.active>a{
  color:#235A81 !important;
  background:  #E8EAED !important;
}

.nav-tabs {
/*border-bottom: 1px solid #cfcfcf;*/
  background: #ffffff;
}

.nav-tabs>li>a {
  color:black ;
}
.nav-tabs>li>a:hover {
  color:black !important;
  background-color: #EEEEEE !important;
}

#avgname, .avgTD{
  color: white;
}

    </style>
    <script>
     function SMM(){


        var get_parentID = $('#get_deptID').val();
        var date_from = $('#from_datepicker').val();
        var date_to = $('#to_datepicker').val();

        if(date_from == "" || date_to == ""){
          alert('Please Select Date Between' );
        } else{

          window.location.href = "stats.php?no=" + get_parentID + "&from="+ date_from +"&to="+ date_to +"";
        }
 // alert(get_parentID);
     }
    </script>
 

 
  

    <div class="inner-container"   >
 
 
 

<div class="row">
    <div class="col-sm-4">
      <span style="margin-right: 2%;">Select Department:</span>
       <!-- <select name="get_dept" id="get_deptID"> -->
      <select   placeholder="Choose Department"   name="get_dept" class="form-control" id="get_deptID" style="width: 70%;">
              
        <?php 
              $getAllDept = implode(",", $all_dept);
                if($getParentID == $getAllDept){
              ?>
              <option value="<?php echo $getAllDept; ?>" selected  >All</option>      
        <?php }else{ ?>
                <option value="<?php echo $getAllDept; ?>">All</option>
                <?php if($getParentID < 1){ echo ""; }else{?>
                  <option value="<?php echo $getParentID; ?>" selected  ><?php echo $getDept['htnodess']; ?> </option>
                <?php } ?>
        <?php } ?>
                <?php while($row = $resDepartment->fetch_array()) { ?>
                  <option value="<?php echo $row['parent_id'] ?>"><?php echo $row['htnodes']; ?></option>
                <?php } ?>
    </select>
    </div>
    <div class="col-sm-6">
       <span style="margin-right: 2%;">Select Date Range:</span>
       From: <input type='date' id='from_datepicker' class='datepicker'value = '<?php echo $date_from; ?>' required/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       To: <input type='date' class='datepicker' value = '<?php echo $date_to; ?>' id='to_datepicker'required/>&nbsp;&nbsp;&nbsp;&nbsp;
       <input type="button" class="btn btn-success" value="Go" onclick="SMM()">
       
    </div>
   

</div>
  
    

    </div>
  
 
 <div class="inner-container2" >
 
 
 
 <?php if($getParentID < 1){ echo ""; }else{?>
  <!-- <div style="display: flex; justify-content: space-between; align-items: center;"> -->
  <!-- <div> -->
  
 <!--  <?php echo json_encode($all_dept); ?> <?php echo $getParentID; ?> -->

 
    <button class="btn btn-primary" onclick="showHideBreakdown()" hidden>Show / Hide Breakdown</button>
  <!-- </div> -->
  <?php } ?>


 
 <?php 


  foreach ($personas  as $rowPersona) {

 $total_result = array();
 $total_result2 = array();

 $date_from_sents = get_first_week($date_from);
 $date_to_sents = get_last_day_of_the_week($date_to);

$LH_query = "SELECT  di.contact_date_added  , lap.pipe_user_id, di.date_connected as date_connected, DATE_FORMAT(contact_date_added, '%b') as M, 
                   ceiling((day(contact_date_added) - (6 - weekday(date_format(contact_date_added,'%Y-%m-01'))))/7) + case when 6 - weekday(date_format(contact_date_added,'%Y-%m-01'))> 0 then 1 else 0 end week_of_month, WEEK(contact_date_added) AS WEEK_LH 
                   FROM `data_info` di 
                   INNER JOIN linkedin_account_persona as lap USING(linkedin_account_persona_id) 
                   WHERE contact_date_added BETWEEN CONVERT_TZ('$date_from 00:00:00', 'Asia/Manila','UTC') 
                   AND CONVERT_TZ('$date_to 23:59:00', 'Asia/Manila','UTC') 
                   AND pipe_user_id = '".$rowPersona['user_id']."'
                   GROUP BY WEEK(contact_date_added)";

 
 
$query_branded =  "SELECT date_from, DATE_FORMAT(date_from, '%b') as M, ceiling((day(date_from) - (6 - weekday(date_format(date_from,'%Y-%m-01'))))/7) + case 
                    when 6 - weekday(date_format(date_from,'%Y-%m-01')) > 0 then 1 else 0 end week_of_month, 
                    WEEK(date_from) AS WEEK,  SUM(invite_sent) AS INVITE_SENT, SUM(inmail_sent) AS INMAIL_SENT, SUM(connections) AS CONNECTIONS  
                    FROM `social_media_report` 
                    INNER JOIN employees USING (user_id) 
                    WHERE `user_id` = '".$rowPersona['user_id']."' 
                    AND date_from BETWEEN '$date_from_sents' 
                    AND '$date_to_sents' GROUP BY WEEK(date_from)";

                  

  $query_generic = "SELECT date_from, DATE_FORMAT(date_from, '%b') as M, ceiling((day(date_from) - (6 - weekday(date_format(date_from,'%Y-%m-01'))))/7) + case 
                    when 6 - weekday(date_format(date_from,'%Y-%m-01'))> 0 then 1 else 0 end week_of_month, 
                    WEEK(date_from) AS WEEK, SUM(invite_sent) AS INVITE_SENT, SUM(inmail_sent) AS INMAIL_SENT, SUM(connections) AS CONNECTIONS  
                    FROM social_media_report_generic
                    INNER JOIN employees  USING (user_id) 
                    WHERE `user_id` = '".$rowPersona['user_id']."' 
                    AND date_from BETWEEN '$date_from_sents' 
                    AND '$date_to_sents' GROUP BY WEEK(date_from)";


  $res_LH = $conn_lh->query($LH_query);
  $res_branded = $conn->query($query_branded);  
  $res_generic = $conn->query($query_generic);  

  while ($row = $res_LH->fetch_assoc()) {



  	// if ($row['contact_date_added']->format('N') == 7) {  
  	// 	$getContactDate = date('Y-m-d', strtotime($row['contact_date_added']. '+1days'));;
  	// }else{
  	  $getContactDate = $row['contact_date_added'];
  	// }

       $row['date_to'] = get_last_day_of_the_week($row['contact_date_added']);
        $row['date_fromLH'] = get_first_week($getContactDate);
       $total_result[$row['WEEK_LH']][$row['WEEK_LH']] = $row;
	$tes = date('D', strtotime($row['contact_date_added']));
        if($rowPersona['user_id'] == 52128 ){
       $debug[] = $row['date_fromLH']." - ".$row['date_to']." LH- ".$row['WEEK_LH']." - ".$tes ;
       }
  }
 
  while ($row = $res_branded->fetch_assoc()) {
    $row['date_to'] = get_last_day_of_the_week($row['date_from']);
      // $row['date_fromPnts'] = get_monday_of_the_week($row['date_from']);
        $row['date_from'] = get_first_week($row['date_from']);
    $total_result[$row['WEEK']][$row['WEEK']] = $row;

     if($rowPersona['user_id'] == 52128){
       $debug[] = $row['date_from']." - ".$row['date_to']." b- ".$row['WEEK']." - ".$row['week_of_month'] ;
       }
  }

  while ($row = $res_generic->fetch_assoc()) {
    $row['date_to'] = get_last_day_of_the_week($row['date_from']);
   // $row['date_fromPnts'] = get_monday_of_the_week($row['date_from']);
      $row['date_from'] = get_first_week($row['date_from']);

        if($rowPersona['user_id'] == 52128){
       $debug[] = $row['date_from']." - ".$row['date_to']." g- ".$row['WEEK']." - ".$row['week_of_month'] ;
       }

    // if (!isset($total_result[$row['M']][$row['week_of_month']]['date_from'])) {
    $total_result[$row['WEEK']][$row['WEEK']]['date_from'] = $row['date_from'];
    $total_result[$row['WEEK']][$row['WEEK']]['date_to'] = $row['date_to'];
    // }
    // $total_result[$row['M']][$row['WEEK']]['M'] = $row['M'];
    // $total_result[$row['M']][$row['WEEK']]['week_of_month'] = $row['week_of_month'];
    $total_result[$row['WEEK']][$row['WEEK']]['WEEK'] = $row['WEEK'];
    $total_result[$row['WEEK']][$row['WEEK']]['INVITE_SENT'] += $row['INVITE_SENT'];
    $total_result[$row['WEEK']][$row['WEEK']]['INMAIL_SENT'] += $row['INMAIL_SENT'];
    $total_result[$row['WEEK']][$row['WEEK']]['CONNECTIONS'] += $row['CONNECTIONS'];
  }

    $summary_total_connected_lh = 0;
    $summary_total_invite_lh = 0;
    $summary_total_invite = 0;
    $summary_total_inmail = 0;
    $summary_total_connections = 0;
    $summary_total_sql = 0;
    $summary_total_mql = 0;
    $summary_total_webinar = 0;
    $summary_total_points = 0;
    $weeks = 0;
 
    foreach ($total_result as $month => $res) {
      foreach ($res as $key => $result) {
        $weeks++;

if(empty($result['date_from'])){
  $fromDates = $result['date_fromLH'];
}else{
  $fromDates = $result['date_from'];
}
        
           $points = get_points($rowPersona['user_id'], $result['date_from'], $result['date_to']);
            $get_inviteLH = get_inviteLH($rowPersona['user_id'],$fromDates, $result['date_to']);
            $get_connectionLH = get_connectionLH($rowPersona['user_id'], $fromDates, $result['date_to']);

 


        foreach ($points as $e => $p) {
          $total_result[$month][$key]['points'] += $p['points'];
          $total_result[$month][$key][$e] += $p['points'];

        }
 

        foreach ($get_inviteLH as $lhi => $inv) {
          $total_result[$month][$key]['cnt_invitesLH'] += $inv['cnt_invitesLH'];
          $total_result[$month][$key][$lhi] += $inv['cnt_invitesLH'];

        }

         foreach ($get_connectionLH as $lhcon => $con) {
          $total_result[$month][$key]['cnt_connectedLH'] += $con['cnt_connectedLH'];
          $total_result[$month][$key][$lhcon] += $con['cnt_connectedLH'];
 
      }


      }    
    }


   // foreach ($total_result as $month => $res) {
   //    foreach ($res as $key => $resultlh_invite) {
   //      $weeks++;
   //      $get_inviteLH = get_inviteLH($rowPersona['user_id'], $resultlh_invite['date_fromLH'],$resultlh_invite['date_from'], $resultlh_invite['date_to']);
   //      foreach ($get_inviteLH as $lhi => $inv) {
   //        $total_result[$month][$key]['cnt_invitesLH'] += $inv['cnt_invitesLH'];
   //        $total_result[$month][$key][$lhi] += $inv['cnt_invitesLH'];

   //      }
        
   //    }    
   //  }


   //   foreach ($total_result as $month => $res) {
   //    foreach ($res as $key => $resultlh_connected) {
   //      $weeks++;
   //      $get_connectionLH = get_connectionLH($rowPersona['user_id'], $resultlh_connected['date_fromLH'],$resultlh_connected['date_from'], $resultlh_connected['date_to']);
   //      foreach ($get_connectionLH as $lhcon => $con) {
   //        $total_result[$month][$key]['cnt_connectedLH'] += $con['cnt_connectedLH'];
   //        $total_result[$month][$key][$lhcon] += $con['cnt_connectedLH'];

   //      }
        
   //    }    
   //  }

 ?>
<table>
 <?php 

// echo "First day of this week: ", $firstday;
//  echo "<pre>'".print_r($debug, 2)."'</pre>";
  ?>
</table>
<table id="weekly-summary<?echo $rowPersona['user_id'];?>" class="table table-bordered"  style="width:100%;margin-bottom: 0%; margin-top: 0">
  <tr>
    <th colspan="12" id="th1" ><?php echo $rowPersona['first_name']." ".$rowPersona['last_name']." - ".$rowPersona['team_name']." <span style = \"float:right; margin-right:5px;\">".$rowPersona['dept_node']."</span>";  ?></th>
  </tr>
  <tr style="background: #235A81; "><th style="color: white; "  colspan="12">Weekly Summary</th></tr>
  <tr>
    <th>Week</th>
    <th>Invite Sent</th>
    <th>Inmail Sent</th>
    <th>Connections</th>
    <th>Connection Rate</th>
    <th>LH Actions</th>
    <th>LH Connection</th>
    <th>LH Connection Rate</th>
    <th>SQLs</th>
    <th>MQLs</th>
    <th>Webinars</th>
    <th title="Social Media Channel Points">Points</th>
  </tr>


 


  <?php 
 
    if (empty($total_result) ) {
      echo "<tr>";
      echo "<td colspan='12' style='text-align: center'>No Data Available!";
      echo "</tr>";
  
    } else {
      foreach ($total_result as $res) {
        foreach ($res as $result) {

   

           if(empty($result['date_from'])){

         	 // $firstDayofWeek = date('Y-m-d', strtotime($result['date_fromLH']. '+1days'));
            $dateTo = date('Y-m-d', strtotime($result['date_to']));
            $firstDayofWeek = date('Y-m-d', strtotime($dateTo. '-5days'));
            $dateFrom = date_format(date_create($firstDayofWeek), "M d, Y")." - ";
            $res19 = 0;
            $res18= 0;
            $res645= 0;
            $respoints= 0;
            $summary_total_sql += 0;
            $summary_total_mql += 0;
            $summary_total_webinar += 0;
            $summary_total_points += 0;
  
          }else  {
            $dateTo = date('Y-m-d', strtotime($result['date_to']));
            $firstDayofWeek = date('Y-m-d', strtotime($dateTo. '-5days'));
            $dateFrom = date_format(date_create($firstDayofWeek), "M d, Y")." - ";
            $res19 = $result[19];
            $res18= $result[18];
            $res645= $result[645];
            $respoints= $result['points'];
            $summary_total_sql += $result[19];
            $summary_total_mql += $result[18];
            $summary_total_webinar += $result[645];
            $summary_total_points += $result['points'];
 
          }
 
   			
   	 
          

 	  $summary_total_invite_lh += $result['cnt_invitesLH'];
          $summary_total_connected_lh += $result['cnt_connectedLH'];
            $lh_connection_rate = $result['cnt_invitesLH'] != 0 ? number_format($result['cnt_connectedLH']/$result['cnt_invitesLH']*100, 2) : 0;
          $summary_total_invite += $result['INVITE_SENT'];
          $summary_total_inmail += $result['INMAIL_SENT'];
          $summary_total_connections += $result['CONNECTIONS'];
          $connection_rate = $result['INVITE_SENT'] != 0 ? number_format($result['CONNECTIONS']/$result['INVITE_SENT']*100, 2) : 0;
        

         

          echo "<tr>";
          // echo "<td>{$result['week_of_month']}</td>";
          // echo "<td>".$dateFrom." - ".date_format(date_create($dateTo), "M d, Y")." - ".$result['WEEK_LH']."</td>";
          //echo "<td>".$dateFrom." ".date_format(date_create($dateTo), "M d, Y")." / ".$wek." - ".$result['week_of_month']." - ".$tests."</td>";
          echo "<td>".$dateFrom." ".date_format(date_create($dateTo), "M d, Y")."</td>";
          echo "<td>" .number_format($result['INVITE_SENT']) ?: 0 . "</td>";
          echo "<td>" .number_format($result['INMAIL_SENT']) ?: 0 . "</td>";
          echo "<td>" .number_format($result['CONNECTIONS']) ?: 0 . "</td>";
          echo "<td>" .$connection_rate."%" . "</td>";
          echo "<td>".number_format($result['cnt_invitesLH']) ?: 0 ."</td>";
          echo "<td>".number_format($result['cnt_connectedLH']) ?: 0 ."</td>";  
          echo "<td>".$lh_connection_rate."%</td>";
          echo "<td>" . round($res19, 2) . "</td>";
          echo "<td>" . round($res18, 2) . "</td>";
          echo "<td>" . round($res645, 2) . "</td>";
          echo "<td>" . round($respoints, 2) . "</td>";
          echo "</tr>";
        }
      }
      $total_points[$rowPersona['user_id']]['invite'] = $summary_total_invite;
      $total_points[$rowPersona['user_id']]['inmail'] = $summary_total_inmail;
      $total_points[$rowPersona['user_id']]['connections'] = $summary_total_connections;
      $total_points[$rowPersona['user_id']]['points'] = $summary_total_points;
      $total_points[$rowPersona['user_id']]['cnt_invitesLH'] = $summary_total_invite_lh;
      $total_points[$rowPersona['user_id']]['cnt_connectedLH'] = $summary_total_connected_lh;
      $summary_connection_rate = $summary_total_invite != 0 ? number_format($summary_total_connections / $summary_total_invite*100, 2) : 0;
      $summary_lh_connection_rate = $summary_total_invite_lh != 0 ? number_format($summary_total_connected_lh / $summary_total_invite_lh*100, 2) : 0;
   }        
  ?>
  <tfoot id="tfoot<?php echo $rowPersona['user_id']; ?>">
    <tr style="background: #666666">
      <td class="avgTD">Total  </td>
      <td class ="avgTD"><?= !empty($total_result) ? number_format($summary_total_invite) : 0 ?></td>
      <td class ="avgTD"><?= !empty($total_result) ? number_format($summary_total_inmail) : 0 ?></td>
      <td class ="avgTD"><?= !empty($total_result) ? number_format($summary_total_connections) : 0 ?></td>
      <td class ="avgTD"><?= !empty($total_result) ? $summary_connection_rate ."%" : 0 ?></td>
      <td class ="avgTD"><?= !empty($total_result) ? number_format($summary_total_invite_lh) : 0 ?></td>
      <td class ="avgTD"><?= !empty($total_result) ? number_format($summary_total_connected_lh) : 0 ?></td>
      <td class ="avgTD"><?= !empty($total_result) ? $summary_lh_connection_rate ."%" : 0 ?></td>
      <td class ="avgTD"><?= !empty($total_result) ? round($summary_total_sql, 2) : 0 ?></td>
      <td class ="avgTD"><?= !empty($total_result) ? round($summary_total_mql, 2) : 0 ?></td>
      <td class ="avgTD"><?= !empty($total_result) ? round($summary_total_webinar, 2) : 0 ?></td>
      <td class ="avgTD"><?= !empty($total_result) ? round($summary_total_points, 2) : 0 ?></td>
    </tr>
    <tr style="background: #666666">
      <td class="avgTD">Weekly Average  </td>
      <td class ="avgTD"><?= !empty($total_result) ? number_format($summary_total_invite /  $weeks, 2) : 0 ?></td>
      <td class ="avgTD"><?= !empty($total_result) ? number_format($summary_total_inmail / $weeks, 2) : 0 ?></td>
      <td class ="avgTD"><?= !empty($total_result) ? number_format($summary_total_connections /  $weeks, 2) : 0 ?></td>
      <td class ="avgTD"><?= !empty($total_result) ? $summary_connection_rate."%" : 0 ?></td>
       <td class ="avgTD"><?= !empty($total_result) ? number_format($summary_total_invite_lh / $weeks, 2) : 0 ?></td>
      <td class ="avgTD"><?= !empty($total_result) ? number_format($summary_total_connected_lh / $weeks, 2) : 0 ?></td>
      <td class ="avgTD"><?= !empty($total_result) ? $summary_lh_connection_rate ."%" : 0 ?></td>
      <td class ="avgTD"><?= !empty($total_result) ? number_format($summary_total_sql / $weeks, 2) : 0 ?></td>
      <td class ="avgTD"><?= !empty($total_result) ? number_format($summary_total_mql / $weeks, 2) : 0 ?></td>
      <td class ="avgTD"><?= !empty($total_result) ? number_format($summary_total_webinar / $weeks, 2) : 0 ?></td>
      <td class ="avgTD"><?= !empty($total_result) ? number_format($summary_total_points / $weeks, 2) : 0 ?></td>
    </tr>
  </tfoot>
</table>

</tr>
  <table id="BrandedTblWeekly<?echo $rowPersona['user_id'];?>" class="table table-bordered hidden-table"  style="width:100%;margin-bottom: 0%; margin-top: 0;display: none">
     
 
    
            <!-- </tr> -->
              <tr><th colspan="6"><?php echo $rowPersona['first_name']." ".$rowPersona['last_name']." - ".$rowPersona['team_name']; ?></th></tr>

             
           
 
            <?php 
 
 $query_WeeklyBranded = "SELECT  DATE_FORMAT(date_from, '%b') as M, ceiling((day(date_from) - (6 - weekday(date_format(date_from,'%Y-%m-01'))))/7) + case 
                         when 6 - weekday(date_format(date_from,'%Y-%m-01'))> 0 then 1 else 0 end week_of_month, WEEK(date_from) AS WEEK, SUM(invite_sent) AS INVITE_SENT, 
                         SUM(inmail_sent) AS INMAIL_SENT, SUM(connections) AS CONNECTIONS  
                         FROM `social_media_report` INNER JOIN employees USING (user_id) 
                         WHERE `user_id` = '".$rowPersona['user_id']."' 
                         AND date_from >= '$date_from' 
                         AND date_from <= '$date_to' 
                         GROUP BY WEEK(date_from)";
 
 
 $query_WeeklyGeneric =  "SELECT DATE_FORMAT(date_from, '%b') as M, ceiling((day(date_from) - (6 - weekday(date_format(date_from,'%Y-%m-01'))))/7) + case 
                          when 6 - weekday(date_format(date_from,'%Y-%m-01'))> 0 then 1 else 0 end week_of_month, WEEK(date_from) AS WEEK, SUM(invite_sent) AS INVITE_SENT, 
                          SUM(inmail_sent) AS INMAIL_SENT, SUM(connections) AS CONNECTIONS  
                          FROM `social_media_report_generic` INNER JOIN employees USING (user_id) 
                          WHERE `user_id` = '".$rowPersona['user_id']."' 
                          AND date_from >= '$date_from' 
                          AND date_from <= '$date_to' 
                          GROUP BY WEEK(date_from)";

 
  $res_weeklybranded = $conn->query($query_WeeklyBranded); 
  $res_weeklygeneric = $conn->query($query_WeeklyGeneric); 
 ?>

<tr style="background: #235A81; "><th style="color: white; "  colspan="6">Weekly Branded Persona</th></tr>
   
  <tr>
       <th>Month</th>
       <th>Week</th>
       <th>Invite Sent</th>
       <th>Inmail Sent</th>
       <th>Connections</th>
       <th>Connection Rate</th>
  </tr>

<?php    
  if (mysqli_num_rows($res_weeklybranded) > 0){
     while($rowWeekBranded = $res_weeklybranded->fetch_array()){
?>


    <tr> 
        <td><?php echo $rowWeekBranded['M']; ?></td>
        <td><?php echo $rowWeekBranded['week_of_month']; ?></td>
        <td><?php echo $rowWeekBranded['INVITE_SENT']; ?></td>
        <td><?php echo $rowWeekBranded['INMAIL_SENT']; ?></td>
        <td><?php echo $rowWeekBranded['CONNECTIONS']; ?></td>
        <td id="totalCon_rate<?php echo $rowPersona['user_id']; ?>">
<?php 
      if($rowWeekBranded['CONNECTIONS'] == 0 || $rowWeekBranded['INVITE_SENT'] == 0  ){
        echo "0.00%";
      }else{
        echo number_format($rowWeekBranded['CONNECTIONS']/$rowWeekBranded['INVITE_SENT']*100, 2)."%";
      }
?>
        </td>
    </tr>
<?php  
      }
  }else{
        echo "<tr><td colspan = \"6\" style = \"text-align:center;\">No Data Available</td></tr>";
  }
?>
          

<?php if (mysqli_num_rows($res_weeklybranded) > 0){ ?>
 
<tfoot id="tfoot<?php echo $rowPersona['user_id']; ?>">
          <tr style="background: #666666">
            <td class="avgTD">Total  </td>
            <td></td>
              <td id="total_invitesentB<?php echo $rowPersona['user_id']; ?>" class ="avgTD" ></td>
            <td id="total_inmailB<?php echo $rowPersona['user_id']; ?>" class ="avgTD" ></td>
            <td id="total_connectionsB<?php echo $rowPersona['user_id']; ?>" class ="avgTD"></td>
             <td id="total_connections_rate<?php echo $rowPersona['user_id']; ?>" class ="avgTD"></td>
           
          </tr>




           <tr style="background: #666666;"><td class="avgTD">Average  </td>
            <td> 
           

            </td>
          

            <td id="avg_invitesent<?php echo $rowPersona['user_id']; ?>" class ="avgTD"> </td>
            <td id="avg_inmail<?php echo $rowPersona['user_id']; ?>" class ="avgTD"></td>
            <td id="avg_connections<?php echo $rowPersona['user_id']; ?>" class ="avgTD"></td>
            <td id="avg_connections_rate<?php echo $rowPersona['user_id']; ?>" class ="avgTD"></td>
           </tr>
</tfoot>
 <?php }else{?>
  
<tfoot id="tfoot<?php echo $rowPersona['user_id']; ?>" hidden>
          <tr style="background: #666666">
            <td class="avgTD">Total</td>
            <td></td>
            <td id="total_invitesentB<?php echo $rowPersona['user_id']; ?>" class ="avgTD" ></td>
            <td id="total_inmailB<?php echo $rowPersona['user_id']; ?>" class ="avgTD" ></td>
            <td id="total_connectionsB<?php echo $rowPersona['user_id']; ?>" class ="avgTD"></td>
            <td id="total_connections_rate<?php echo $rowPersona['user_id']; ?>" class ="avgTD"></td>
          </tr>

           <tr style="background: #666666;"><td class="avgTD">Average  </td>
            <td></td>
            <td id="avg_invitesent<?php echo $rowPersona['user_id']; ?>" class ="avgTD"> </td>
            <td id="avg_inmail<?php echo $rowPersona['user_id']; ?>" class ="avgTD"></td>
            <td id="avg_connections<?php echo $rowPersona['user_id']; ?>" class ="avgTD"></td>
            <td id="avg_connections_rate<?php echo $rowPersona['user_id']; ?>" class ="avgTD"></td>
           </tr>
</tfoot>





 <?php } ?>
 
 

</table>

<table id="GenericTblWeekly<?echo $rowPersona['user_id'];?>" class="table table-bordered hidden-table"  style="width:100%; margin-bottom: 0%;  margin-top: 0;display: none">
 
 <tr style="background: #235A81; "><th style="color: white; "  colspan="6">Weekly Generic Persona</th></tr>
   
  <tr>
      <th>Month</th>
      <th>Week</th>
      <th>Invite Sent</th>
      <th>Inmail Sent</th>
      <th>Connections</th>
      <th>Connection Rate</th>
  </tr>
 

<?php   
      if (mysqli_num_rows($res_weeklygeneric) > 0){
         while($rowWeekGeneric = $res_weeklygeneric->fetch_array()){ ?>


    <tr> 
      <td><?php echo $rowWeekGeneric['M']; ?></td>
      <td><?php echo $rowWeekGeneric['week_of_month']; ?></td>
      <td><?php echo $rowWeekGeneric['INVITE_SENT']; ?></td>
      <td><?php echo $rowWeekGeneric['INMAIL_SENT']; ?></td>
      <td><?php echo $rowWeekGeneric['CONNECTIONS']; ?></td>
      <td id="totalCon_rate<?php echo $rowPersona['user_id']; ?>">
        <?php 
          if($rowWeekGeneric['CONNECTIONS'] == 0 || $rowWeekGeneric['INVITE_SENT'] == 0  ){
            echo "0.00%";
          }else{
            echo number_format($rowWeekGeneric['CONNECTIONS']/$rowWeekGeneric['INVITE_SENT']*100, 2)."%";
          }
        ?>
      </td>
    </tr>
        <?php
        } 
         }else{ 
            echo "<tr><td colspan = \"6\" style = \"text-align:center;\">No Data Available</td></tr>";
         }
         ?>

<?php  if (mysqli_num_rows($res_weeklygeneric) > 0){ ?>
<tfoot>

     <tr style="background: #666666;"><td class="avgTD">Total</td>
      <td></td>
            <td id="total_invitesentG<?php echo $rowPersona['user_id']; ?>" class ="avgTD" ></td>
            <td id="total_inmailG<?php echo $rowPersona['user_id']; ?>" class ="avgTD" ></td>
            <td id="total_connectionsG<?php echo $rowPersona['user_id']; ?>"class ="avgTD" ></td>
             <td id="total_connections_rateG<?php echo $rowPersona['user_id']; ?>" class ="avgTD"></td>
     </tr>
 
           <tr style="background: #666666;"><td class="avgTD">Average  </td>
            <td>  
            </td>
            <td id="avg_invitesentG<?php echo $rowPersona['user_id']; ?>" class ="avgTD"> </td>
            <td id="avg_inmailG<?php echo $rowPersona['user_id']; ?>" class ="avgTD"></td>
            <td id="avg_connectionsG<?php echo $rowPersona['user_id']; ?>" class ="avgTD"></td>
            <td id="avg_connections_rateG<?php echo $rowPersona['user_id']; ?>" class ="avgTD"></td>
           </tr>
 
</tfoot>

<?php }else{ ?>
<tfoot hidden>

     <tr style="background: #666666;"><td class="avgTD">Total</td>
      <td></td>
            <td id="total_invitesentG<?php echo $rowPersona['user_id']; ?>" class ="avgTD" ></td>
            <td id="total_inmailG<?php echo $rowPersona['user_id']; ?>" class ="avgTD" ></td>
            <td id="total_connectionsG<?php echo $rowPersona['user_id']; ?>" class ="avgTD"></td>
             <td id="total_connections_rateG<?php echo $rowPersona['user_id']; ?>" class ="avgTD"></td>
     </tr>
 
           <tr style="background: #666666;"><td class="avgTD">Average  </td>
            <td>  
            </td>
            <td id="avg_invitesentG<?php echo $rowPersona['user_id']; ?>" class ="avgTD"> </td>
            <td id="avg_inmailG<?php echo $rowPersona['user_id']; ?>" class ="avgTD"></td>
            <td id="avg_connectionsG<?php echo $rowPersona['user_id']; ?>" class ="avgTD"></td>
            <td id="avg_connections_rateG<?php echo $rowPersona['user_id']; ?>" class ="avgTD"></td>
           </tr>
 
</tfoot>

  <?php } ?>

<?php include 'includes/calculate_average.php' ?>
 


            </table>

 

          <?php   }?>
      





  </div>

  <script type="text/javascript">

  $(document).ready(function() {
    $('select').each(function () {
        $(this).select2({
          theme: 'bootstrap4',
          width: 'style',
          placeholder: $(this).attr('placeholder'),
          allowClear: Boolean($(this).data('allow-clear')),
        });
      });
   });
  </script>



 

 
 
 
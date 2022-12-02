 <?php  $date_from = $_REQUEST['from'];
  $date_to = $_REQUEST['to']; 
  $date_count = array();
  
  ?>
  
 <table id="BrandedTblDaily<?echo $rowPersona2['user_id'];?>" class="table table-bordered"  style="width:100%;margin-bottom: 0%; margin-top: 0">
     
 
    
            </tr>
              <tr><th colspan="6"><?php echo $rowPersona2['first_name']." ".$rowPersona2['last_name']." - ".$rowPersona2['team_name']; ?>  </th></tr>

             
           
 
         <?php 
            


  $getDailyBranded = mysqli_query($conn, "SELECT Concat(first_name,' ',last_name) as 'SMM', DATE_FORMAT(date_from, '%b') as M, DATE_FORMAT(date_from, '%b %e, %Y') as dt, SUM(invite_sent) AS INVITE_SENT, SUM(inmail_sent) AS INMAIL_SENT, SUM(connections) AS CONNECTIONS FROM `social_media_report` inner join employees using (user_id) WHERE `user_id` = '".$rowPersona2['user_id']."' AND date_from >= '".$date_from."' AND date_from <= '".$date_to."' GROUP BY date_from");


 

 $getDailyGeneric = mysqli_query($conn, "
  SELECT Concat(first_name,' ',last_name) as 'SMM', DATE_FORMAT(date_from, '%b') as M, DATE_FORMAT(date_from, '%b %e, %Y') as dt, SUM(invite_sent) AS INVITE_SENT, SUM(inmail_sent) AS INMAIL_SENT, SUM(connections) AS CONNECTIONS FROM `social_media_report_generic` inner join employees using (user_id) WHERE `user_id` = '".$rowPersona2['user_id']."' AND date_from >= '$date_from' AND date_from <= '$date_to' GROUP BY date_from

  ");

 
             ?>

<tr style="background: #235A81; "><th style="color: white; "  colspan="6">Daily Branded Persona</th></tr>
   
  <tr>
                 <th>Month</th>
                 <th>Date</th>
                   <th>Invite Sent</th>
                 <th>Inmail Sent</th>
                   <th>Connections</th>
                 <th>Connection Rate</th>
               </tr>
 

      <?php    
      if (mysqli_num_rows($getDailyBranded) > 0){

        while($rowDailyBranded = mysqli_fetch_array($getDailyBranded)){
       
          $date_count[$rowDailyGeneric['dt']]++;
         ?>


              <tr > 
                 <td><?php echo $rowDailyBranded['M']; ?></td>
                 <td><?php echo $rowDailyBranded['dt']; ?></td>
                  <td  ><?php echo $rowDailyBranded['INVITE_SENT']; ?></td>
                 <td><?php echo $rowDailyBranded['INMAIL_SENT']; ?></td>
                  <td  ><?php echo $rowDailyBranded['CONNECTIONS']; ?></td>
                 <td id="totalCon_rate<?php echo $rowPersona2['user_id']; ?>">
                   <?php 
               if($rowDailyBranded['CONNECTIONS'] == 0 || $rowDailyBranded['INVITE_SENT'] == 0  ){
                    echo "0.00%";
                   }else{ 
echo number_format($rowDailyBranded['CONNECTIONS']/$rowDailyBranded['INVITE_SENT']*100, 2)."%";
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


 <?php if (mysqli_num_rows($getDailyBranded) > 0){ ?>
<tfoot id="tfoot<?php echo $rowPersona2['user_id']; ?>">
            <tr style="background: #666666"><td class ="avgTD">Total  </td>
              <td></td>
               <td id="total_invitesentBDaily<?php echo $rowPersona2['user_id']; ?>" class ="avgTD"  ></td>
            <td id="total_inmailBDaily<?php echo $rowPersona2['user_id']; ?>" class ="avgTD" ></td>
            <td id="total_connectionsBDaily<?php echo $rowPersona2['user_id']; ?>" class ="avgTD"></td>
            <td id="total_connections_rateDaily<?php echo $rowPersona2['user_id']; ?>" class ="avgTD"></td>
            </tr>

           <tr style="background: #666666;"><td class="avgTD">Average  </td>
            <td> 
            </td>
            <td id="avg_invitesentDaily<?php echo $rowPersona2['user_id']; ?>" class ="avgTD"> </td>
            <td id="avg_inmailDaily<?php echo $rowPersona2['user_id']; ?>" class ="avgTD"></td>
            <td id="avg_connectionsDaily<?php echo $rowPersona2['user_id']; ?>" class ="avgTD"></td>
            <td id="avg_connections_rateDaily<?php echo $rowPersona2['user_id']; ?>" class ="avgTD"></td>
           </tr>
</tfoot>

 <?php }else{?>
<tfoot id="tfoot<?php echo $rowPersona2['user_id']; ?>" hidden>
            <tr style="background: #666666"><td class ="avgTD">Total  </td>
              <td></td>
               <td id="total_invitesentBDaily<?php echo $rowPersona2['user_id']; ?>" class ="avgTD"  ></td>
            <td id="total_inmailBDaily<?php echo $rowPersona2['user_id']; ?>" class ="avgTD" ></td>
            <td id="total_connectionsBDaily<?php echo $rowPersona2['user_id']; ?>" class ="avgTD"></td>
            <td id="total_connections_rateDaily<?php echo $rowPersona2['user_id']; ?>" class ="avgTD"></td>
            </tr>

           <tr style="background: #666666;"><td class="avgTD">Average  </td>
            <td> 
            </td>
            <td id="avg_invitesentDaily<?php echo $rowPersona2['user_id']; ?>" class ="avgTD"> </td>
            <td id="avg_inmailDaily<?php echo $rowPersona2['user_id']; ?>" class ="avgTD"></td>
            <td id="avg_connectionsDaily<?php echo $rowPersona2['user_id']; ?>" class ="avgTD"></td>
            <td id="avg_connections_rateDaily<?php echo $rowPersona2['user_id']; ?>" class ="avgTD"></td>
           </tr>
</tfoot>

<?php } ?>

 
 

</table>

<table id="GenericTblDaily<?echo $rowPersona2['user_id'];?>" class="table table-bordered"  style="width:100%; margin-bottom: 0%; margin-top: 0;">
 
 <tr style="background: #235A81; "><th style="color: white; "  colspan="6">Daily Generic Persona</th></tr>
   
  <tr>
                 <th>Month</th>
                 <th>Date</th>
                   <th>Invite Sent</th>
                 <th>Inmail Sent</th>
                   <th>Connections</th>
                 <th>Connection Rate</th>
               </tr>
 

      <?php     

         if (mysqli_num_rows($getDailyGeneric) > 0){

       while($rowDailyGeneric = mysqli_fetch_array($getDailyGeneric)){ 
        $date_count[$rowDailyGeneric['dt']]++;
        ?>


              <tr  > 
                  <td><?php echo $rowDailyGeneric['M']; ?></td>
                 <td><?php echo $rowDailyGeneric['dt']; ?></td>
                  <td  ><?php echo $rowDailyGeneric['INVITE_SENT']; ?></td>
                 <td><?php echo $rowDailyGeneric['INMAIL_SENT']; ?></td>
                  <td  ><?php echo $rowDailyGeneric['CONNECTIONS']; ?></td>
                 <td id="totalCon_rate<?php echo $rowPersona2['user_id']; ?>">
                   <?php 
              if($rowDailyGeneric['CONNECTIONS'] == 0 || $rowDailyGeneric['INVITE_SENT'] == 0  ){
                    echo "0.00%";
                   }else{ 
echo number_format($rowDailyGeneric['CONNECTIONS']/$rowDailyGeneric['INVITE_SENT']*100, 2)."%";
        }
                    ?>

                 </td>
               </tr>
           <?php } }else{ echo "<tr><td colspan = \"6\" style = \"text-align:center;\">No Data Available</td></tr>";}?>

<?php  if (mysqli_num_rows($getDailyGeneric) > 0){ ?>
<tfoot>
  <tr style="background: #666666"><td class ="avgTD">Total  </td>
              <td></td>
               <td id="total_invitesentGDaily<?php echo $rowPersona2['user_id']; ?>" class ="avgTD"  ></td>
            <td id="total_inmailGDaily<?php echo $rowPersona2['user_id']; ?>" class ="avgTD" ></td>
            <td id="total_connectionsGDaily<?php echo $rowPersona2['user_id']; ?>" class ="avgTD"></td>
            <td id="total_connections_rateGDaily<?php echo $rowPersona2['user_id']; ?>" class ="avgTD"></td>
            </tr>
 

           <tr style="background: #666666;"><td class="avgTD">Average  </td>
            <td>  
            </td>
            <td id="avg_invitesentAVGDaily<?php echo $rowPersona2['user_id']; ?>" hidden ></td>
            <td id="avg_inmailAVGDaily<?php echo $rowPersona2['user_id']; ?>" hidden ></td>
            <td id="avg_connectionsAVGDaily<?php echo $rowPersona2['user_id']; ?>"hidden ></td>

            <td id="avg_invitesentGDaily<?php echo $rowPersona2['user_id']; ?>" class ="avgTD"> </td>
            <td id="avg_inmailGDaily<?php echo $rowPersona2['user_id']; ?>" class ="avgTD"></td>
            <td id="avg_connectionsGDaily<?php echo $rowPersona2['user_id']; ?>" class ="avgTD"></td>
            <td id="avg_connections_rateGDaily<?php echo $rowPersona2['user_id']; ?>" class ="avgTD"></td>
           </tr>
</tfoot>
<?php }else{ ?>
<tfoot hidden>
  <tr style="background: #666666"><td class ="avgTD">Total  </td>
              <td></td>
               <td id="total_invitesentGDaily<?php echo $rowPersona2['user_id']; ?>" class ="avgTD"  ></td>
            <td id="total_inmailGDaily<?php echo $rowPersona2['user_id']; ?>" class ="avgTD" ></td>
            <td id="total_connectionsGDaily<?php echo $rowPersona2['user_id']; ?>" class ="avgTD"></td>
            <td id="total_connections_rateGDaily<?php echo $rowPersona2['user_id']; ?>" class ="avgTD"></td>
            </tr>
 

           <tr style="background: #666666;"><td class="avgTD">Average  </td>
            <td>  
            </td>
            <td id="avg_invitesentAVGDaily<?php echo $rowPersona2['user_id']; ?>" hidden ></td>
            <td id="avg_inmailAVGDaily<?php echo $rowPersona2['user_id']; ?>" hidden ></td>
            <td id="avg_connectionsAVGDaily<?php echo $rowPersona2['user_id']; ?>"hidden ></td>

            <td id="avg_invitesentGDaily<?php echo $rowPersona2['user_id']; ?>" class ="avgTD"> </td>
            <td id="avg_inmailGDaily<?php echo $rowPersona2['user_id']; ?>" class ="avgTD"></td>
            <td id="avg_connectionsGDaily<?php echo $rowPersona2['user_id']; ?>" class ="avgTD"></td>
            <td id="avg_connections_rateGDaily<?php echo $rowPersona2['user_id']; ?>" class ="avgTD"></td>
           </tr>
</tfoot>
<?php } ?>

 <?php include 'includes/calculate_average_daily.php' ?>


</table>
<table id="TotalDaily<?echo $rowPersona2['user_id'];?>" class="table table-bordered"  style="width:100%;margin-bottom: 2%; margin-top: 0;">
  <tr>
    <th>Total Invite Sent</th>
    <th>Invite Sent Avg Per Day</th>
    <th>Total Inmail Sent</th>
    <th>Inmail Sent Avg Per Day</th>
    <th>Total Connections</th>
    <th>Connections Avg Per Day</th>
    <th>Total Connection Rate</th>
    <th>Total Points</th>
    <th>Points Avg Per Day</th>
  </tr>
 
  <tfoot>
    <tr style="background: #666666; ">
      <td class="avgTD"><?= number_format($total_points[$rowPersona2['user_id']]['invite']) ?></td>
      <td title="<?= "{$total_points[$rowPersona2['user_id']]['invite']} / ".count($date_count)." days" ?>" class="avgTD"><?= round($total_points[$rowPersona2['user_id']]['invite'] / count($date_count), 2) ?></td>
      <td class="avgTD"><?= number_format($total_points[$rowPersona2['user_id']]['inmail']) ?></td>
      <td title="<?= "{$total_points[$rowPersona2['user_id']]['inmail']} / ".count($date_count)." days" ?>" class="avgTD"><?= round($total_points[$rowPersona2['user_id']]['inmail'] / count($date_count), 2) ?></td>
      <td class="avgTD"><?= number_format($total_points[$rowPersona2['user_id']]['connections']) ?></td>
      <td title="<?= "{$total_points[$rowPersona2['user_id']]['connections']} / " . count($date_count) . " days" ?>" class="avgTD"><?= round($total_points[$rowPersona2['user_id']]['connections'] / count($date_count), 2) ?></td>
      <td class="avgTD"><?= round($total_points[$rowPersona2['user_id']]['connections'] / $total_points[$rowPersona2['user_id']]['invite'] * 100, 2) ."%"?></td>
      <td class="avgTD"><?= $total_points[$rowPersona2['user_id']]['points'] ?></td>
      <td title="<?= "{$total_points[$rowPersona2['user_id']]['points']} / ".count($date_count) ." days" ?>" class="avgTD"><?= round($total_points[$rowPersona2['user_id']]['points'] / count($date_count), 2) ?></td>
    </tr>
  </tfoot>
</table>


 <?php  if (mysqli_num_rows($getDailyGeneric) > 0 || mysqli_num_rows($getDailyBranded) > 0){ ?>

            <!-- <table id="TotalDaily<?echo $rowPersona2['user_id'];?>" class="table table-bordered"  style="width:100%;margin-bottom: 2%; margin-top: 0;">
    <tr>
                   <th>Total Invite Sent</th>
                 <th>Total Inmail Sent</th>
                   <th>Total Connections</th>
                 <th>Total Connection Rate Average</th>
                 <th>Total Points</th>
               </tr>
 
  <tfoot>
     <tr style="background: #666666; ">
           <td class="avgTD"><?= $total_points[$rowPersona2['user_id']]['invite'] ?></td>
           <td class="avgTD"><?= $total_points[$rowPersona2['user_id']]['inmail'] ?></td>
           <td class="avgTD"><?= $total_points[$rowPersona2['user_id']]['connections'] ?></td>
           <td class="avgTD">0</td>
           <td class="avgTD"><?= $total_points[$rowPersona2['user_id']]['points'] ?></td>
           </tr>
  </tfoot>
</table>
<?php }else{ ?>
<table id="TotalDaily<?echo $rowPersona2['user_id'];?>" class="table table-bordered"  style="width:100%;margin-bottom: 2%; margin-top: 0;" hidden>
    <tr>
      <th>Total Invite Sent</th>
      <th>Total Inmail Sent</th>
      <th>Total Connections</th>
      <th>Total Connection Rate Average</th>
      <th>Total Points</th>
    </tr>
 
  <tfoot>
     <tr style="background: #666666; ">
        <td class="avgTD"><?= $total_points[$rowPersona2['user_id']]['invite'] ?></td>
        <td class="avgTD"><?= $total_points[$rowPersona2['user_id']]['inmail'] ?></td>
        <td class="avgTD"><?= $total_points[$rowPersona2['user_id']]['connections'] ?></td>
        <td class="avgTD">0</td>
        <td class="avgTD"><?= $total_points[$rowPersona2['user_id']]['points'] ?></td>
      </tr>
  </tfoot>
</table> -->
<br><br><br>
  <?php } ?>
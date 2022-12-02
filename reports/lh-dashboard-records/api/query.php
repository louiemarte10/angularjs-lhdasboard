<?php 
 $dateNow = date('Y-m-d'); 
 // $sql = "SELECT * FROM  data as d
 //         INNER JOIN data_info as di on d.data_id = di.data_id
 //         INNER JOIN linkedin_account_persona as lap on lap.linkedin_account_persona_id = di.linkedin_account_persona_id
 //         WHERE di.contact_date_added BETWEEN '2022-03-10 00:00:00' and '".$dateNow." 23:59:59'
 //         GROUP BY di.data_id
 //         ";

  $sql0 = "SELECT * FROM data_info as di
         INNER JOIN linkedin_account_persona as lap on lap.linkedin_account_persona_id = di.linkedin_account_persona_id
         WHERE di.date_added BETWEEN '2022-03-10 00:00:00' and '".$dateNow." 23:59:59' and di.linkedin_account_persona_id != 18 and Concat(first_name,' ',last_name) !='John Paul Damasco'
         GROUP BY di.data_id
         ORDER BY di.date_added ASC
         ";

 $sql = "SELECT * FROM data_info as di
         INNER JOIN linkedin_account_persona as lap on lap.linkedin_account_persona_id = di.linkedin_account_persona_id
         WHERE di.date_added BETWEEN '2022-03-10 00:00:00' and '".$dateNow." 23:59:59' and di.linkedin_account_persona_id != 18 and Concat(first_name,' ',last_name) !='John Paul Damasco'
         GROUP BY di.data_id
         ";

  
 $sql2 = "SELECT * FROM data_info as di
         INNER JOIN linkedin_account_persona as lap on lap.linkedin_account_persona_id = di.linkedin_account_persona_id
         where   di.email != '' and di.date_added BETWEEN '2022-03-10 00:00:00' and '".$dateNow." 23:59:59' and di.linkedin_account_persona_id != 18 and Concat(first_name,' ',last_name) !='John Paul Damasco'
         GROUP BY di.data_id
         ";


 

 $sql21 = "SELECT * FROM data_info as di
         INNER JOIN linkedin_account_persona as lap on lap.linkedin_account_persona_id = di.linkedin_account_persona_id
         where  di.email = '' and di.date_added BETWEEN '2022-03-10 00:00:00' and '".$dateNow." 23:59:59' and di.linkedin_account_persona_id != 18 and Concat(first_name,' ',last_name) !='John Paul Damasco'
         GROUP BY di.data_id
         ";

 

  $sql211 = "SELECT * FROM data_info as di
         INNER JOIN linkedin_account_persona as lap on lap.linkedin_account_persona_id = di.linkedin_account_persona_id
         where di.email is NULL and di.date_added BETWEEN '2022-03-10 00:00:00' and '".$dateNow." 23:59:59' and di.linkedin_account_persona_id != 18 and Concat(first_name,' ',last_name) !='John Paul Damasco' 
         GROUP BY di.data_id
         ";    

 

 $sql3 = "SELECT * FROM data_info as di
         INNER JOIN linkedin_account_persona as lap on lap.linkedin_account_persona_id = di.linkedin_account_persona_id
         where di.email_status = 'valid' and di.date_added BETWEEN '2022-03-10 00:00:00' and '".$dateNow." 23:59:59' and di.linkedin_account_persona_id != 18 and Concat(first_name,' ',last_name) !='John Paul Damasco'
         GROUP BY di.data_id
         ";          

 

$sql4 = "SELECT * FROM data_info as di
         INNER JOIN linkedin_account_persona as lap on lap.linkedin_account_persona_id = di.linkedin_account_persona_id
         where di.email_status = 'unverifiable' and di.date_added BETWEEN '2022-03-10 00:00:00' and '".$dateNow." 23:59:59' and di.linkedin_account_persona_id != 18 and Concat(first_name,' ',last_name) !='John Paul Damasco'
         GROUP BY di.data_id
         ";          

 
 $res0 = $conn->query($sql0);    
 $res1 = $conn->query($sql);                                    

$res2 = $conn->query($sql2);
$res21 = $conn->query($sql21);
$res211 = $conn->query($sql211);
$res3 = $conn->query($sql3); 
$res4 = $conn->query($sql4);  
$totalRecords = $res1->num_rows;
$totalEmailsFound = $res2->num_rows;
$totalNoEmails = $res21->num_rows;
$totalNullEmails = $res211->num_rows;
$totalNoEmailFound = $totalNoEmails+$totalNullEmails;
$totalValidEmails = $res3->num_rows;
$totalUnverifiableEmails = $res4->num_rows;


 


  $sql_persona0 = "SELECT * FROM data_info as di
         INNER JOIN linkedin_account_persona as lap on lap.linkedin_account_persona_id = di.linkedin_account_persona_id
         WHERE di.date_added BETWEEN '2022-03-10 00:00:00' and '".$dateNow." 23:59:59' and lap.assigned_to like '%$user_no%'
         GROUP BY di.data_id
         ORDER BY lap.my_email ASC, di.date_added ASC 
         ";

 $sql_persona = "SELECT * FROM data_info as di
         INNER JOIN linkedin_account_persona as lap on lap.linkedin_account_persona_id = di.linkedin_account_persona_id
         WHERE di.date_added BETWEEN '2022-03-10 00:00:00' and '".$dateNow." 23:59:59' and lap.assigned_to like '%$user_no%'
         GROUP BY di.data_id
         ";

  
 $sql_persona2 = "SELECT * FROM data_info as di
         INNER JOIN linkedin_account_persona as lap on lap.linkedin_account_persona_id = di.linkedin_account_persona_id
         where   di.email != '' and di.date_added BETWEEN '2022-03-10 00:00:00' and '".$dateNow." 23:59:59' and lap.assigned_to like '%$user_no%'
         GROUP BY di.data_id
         ";


 

 $sql_persona21 = "SELECT * FROM data_info as di
         INNER JOIN linkedin_account_persona as lap on lap.linkedin_account_persona_id = di.linkedin_account_persona_id
         where  di.email = '' and di.date_added BETWEEN '2022-03-10 00:00:00' and '".$dateNow." 23:59:59' and lap.assigned_to like '%$user_no%' 
         GROUP BY di.data_id
         ";

 

  $sql_persona211 = "SELECT * FROM data_info as di
         INNER JOIN linkedin_account_persona as lap on lap.linkedin_account_persona_id = di.linkedin_account_persona_id
         where di.email is NULL and di.date_added BETWEEN '2022-03-10 00:00:00' and '".$dateNow." 23:59:59' and lap.assigned_to like '%$user_no%' 
         GROUP BY di.data_id
         ";    

 

 $sql_persona3 = "SELECT * FROM data_info as di
         INNER JOIN linkedin_account_persona as lap on lap.linkedin_account_persona_id = di.linkedin_account_persona_id
         where di.email_status = 'valid' and di.date_added BETWEEN '2022-03-10 00:00:00' and '".$dateNow." 23:59:59' and lap.assigned_to like '%$user_no%'  
         GROUP BY di.data_id
         ";          

 

$sql_persona4 = "SELECT * FROM data_info as di
         INNER JOIN linkedin_account_persona as lap on lap.linkedin_account_persona_id = di.linkedin_account_persona_id
         where di.email_status = 'unverifiable' and di.date_added BETWEEN '2022-03-10 00:00:00' and '".$dateNow." 23:59:59' and lap.assigned_to like '%$user_no%'  
         GROUP BY di.data_id
         ";          

 
 $res_sql_persona0 = $conn->query($sql_persona0);    
 $res_sql_persona1 = $conn->query($sql_persona);                                    

$res_sql_persona2 = $conn->query($sql_persona2);
$res_sql_persona21 = $conn->query($sql_persona21);
$res_sql_persona211 = $conn->query($sql_persona211);
$res_sql_persona3 = $conn->query($sql_persona3); 
$res_sql_persona4 = $conn->query($sql_persona4);  
$persona_totalRecords = $res_sql_persona1->num_rows;
$persona_totalEmailsFound = $res_sql_persona2->num_rows;
$persona_totalNoEmails = $res_sql_persona21->num_rows;
$persona_totalNullEmails = $res_sql_persona211->num_rows;
$persona_totalNoEmailFound = $persona_totalNoEmails+$persona_totalNullEmails;
$persona_totalValidEmails = $res_sql_persona3->num_rows;
$persona_totalUnverifiableEmails = $res_sql_persona4->num_rows;
 

 $dateDefault = "<h4> Date Range: Mar 10, 2022 to ".$dateToday."</h4>";



  $getpersona = "SELECT * FROM linkedin_account_persona where assigned_to like '%$user_no%'";
$resultpersona = $conn->query($getpersona);
  $lap_id = array();
 
  while($rowresultpersona = $resultpersona->fetch_assoc()){
  $lap_id[] = $rowresultpersona['linkedin_account_persona_id'];
 }
   $datas = json_encode($lap_id);
 
 ?>
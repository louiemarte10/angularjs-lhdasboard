<?php
    require "{$_SERVER['DOCUMENT_ROOT']}/config/pipeline-x.php";
       px_login::init();
  $conn = new mysqli(config::get_server_by_name('smm_mktg'), "app_pipe", "a33-pipe", "linkedhelper");
  $user_no = px_login::info("user_id");



 



if(isset($_POST["persona_id"])){
 $dateNow = date('Y-m-d');
$persona_id = $_POST["persona_id"];



 

 $query = "SELECT * FROM data_info as di 
          INNER JOIN linkedin_account_persona as lap on lap.linkedin_account_persona_id = di.linkedin_account_persona_id
         where di.date_added BETWEEN '2022-03-10 00:00:00' and '".$dateNow." 23:59:59' and di.linkedin_account_persona_id IN ($persona_id)
         GROUP BY di.data_id
         ORDER BY di.date_added ASC
         ";

  

$query2 = "SELECT * FROM data_info as di 
         where  di.email != '' and di.date_added BETWEEN '2022-03-10 00:00:00' and '".$dateNow." 23:59:59' and di.linkedin_account_persona_id IN ($persona_id)
         GROUP BY di.data_id
         ";

 $query3 = "SELECT * FROM data_info as di 
         where  di.email = '' and di.date_added BETWEEN '2022-03-10 00:00:00' and '".$dateNow." 23:59:59' and di.linkedin_account_persona_id IN ($persona_id)
         GROUP BY di.data_id
         ";

 $query31 = "SELECT * FROM data_info as di
         where  di.email is NULL and di.date_added BETWEEN '2022-03-10 00:00:00' and '".$dateNow." 23:59:59' and di.linkedin_account_persona_id IN ($persona_id)
         GROUP BY di.data_id
         ";  

 $query4 = "SELECT * FROM data_info as di
         where  di.email_status = 'valid' and di.date_added BETWEEN '2022-03-10 00:00:00' and '".$dateNow." 23:59:59' and di.linkedin_account_persona_id IN ($persona_id)
         GROUP BY di.data_id
         ";  

  $query5 = "SELECT * FROM data_info as di
         where  di.email_status = 'unverifiable' and di.date_added BETWEEN '2022-03-10 00:00:00' and '".$dateNow." 23:59:59' and di.linkedin_account_persona_id IN ($persona_id)
         GROUP BY di.data_id
         "; 
               

   $result = $conn->query($query);
   $totalRecordsPersona = $result->num_rows;
   $result2 = $conn->query($query2);
   $totalEmailsFound = $result2->num_rows;
   $result3 = $conn->query($query3);
   $result31 = $conn->query($query31);
   $totalNoEmails = $result3->num_rows+$result31->num_rows;
   $result4 = $conn->query($query4);
   $totalValidEmails = $result4->num_rows;
   $result5 = $conn->query($query5);
   $totalUnverifiableEmails = $result5->num_rows;

 
}









 
if ($totalRecordsPersona == 0){
 

  $output .= '
  <table class="table table-bordered"  style="width:100%;margin-bottom: 2%; margin-top: 0">
         
          <tr id=\'trEmails\'>
            <th>Total Records</th>
            <th>Total Emails Found</th>
            <th>Total No Emails</th>
            <th>Total Valid Emails Status</th>
            <th>Total Unverifiable Emails Status</th>

          </tr>
 ';
   
  $output .= '
  <tr>
    <td colspan=\'5\' style=\'text-align:center;\'>No Data Available</td>

 
    
   </tr>
  ';

 
}else{

if (in_array(209, px_login::roles("ORG")) || px_login::info("user_id") == 51794 || px_login::info("user_id") == 1252979 || px_login::info("user_id") == 6541 ||  px_login::info("user_id") == 1248399)
    { 
      $exportBTN = '<button class=\'btn btn-info font-weight-bold mr-2\' style=\'float: right; margin-bottom: 1%;\' id=\'fetchRecords_persona\'>Export to CSV  &nbsp;<i class=\'flaticon-file-2\'></i></button>';
    }else{ $exportBTN = '';}
 $rows = $result->fetch_assoc();

$output .= '
 <div class=\'row\'>
    <div class=\'col-md-6\'>
    <h4> Total Records - '.$rows['my_fullname'].'</h4>
    <input type=\'text\' value=\''.$rows['my_fullname'].'\' id=\'text-fetch-records\' hidden >
    </div>
    <div class=\'col-md-6\'>
     '.$exportBTN.'
    </div>
    </div>
 ';





 
 $output .= '
  <table class="table table-bordered"  style="width:100%;margin-bottom: 2%; margin-top: 0">
         
          <tr id=\'trEmails\'>
            <th>Total Records</th>
            <th>Total Emails Found</th>
            <th>Total No Emails</th>
            <th>Total Valid Emails Status</th>
            <th>Total Unverifiable Emails Status</th>
          </tr>
 ';
   
  $output .= '
 <tbody id=\'tbodyEmails\'>
    <tr>
    <td>'.number_format($totalRecordsPersona).'</td>
    <td>'. number_format($totalEmailsFound).'</td>
    <td>'. number_format($totalNoEmails).'</td>
    <td>'. number_format($totalValidEmails).'</td>
    <td>'.number_format($totalUnverifiableEmails).'</td>

   </tr>
   </tbody>
  ';








 $output .= '
  <table class="table table-responsive" id="fetch-persona-csv" hidden>
         
  <tr id=\'trEmails\'>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Position</th>
    <th>Email</th>
    <th>Primary Phone Number</th>
    <th>Mobile number</th>
    <th>Direct line number</th>
    <th>Company</th>
    <th>Address</th>
    <th>Country</th>
    <th>Website</th>
    <th>Industry</th>
    <th>Date connected</th>
    <th>Linkedin Profile</th>
    <th>Date Added</th>
    <th>Email Source</th>
    <th>Email Status</th>
    <th>Persona Name/Email</th>
    <th>Account Type</th>
  </tr>
 ';


    while($row = $result->fetch_assoc()){
      if($row['email_status'] == NULL){
        $emailstats = 'unverifiable';
      }else{
        $emailstats = $row['email_status'];
      }

      if($row['date_connected'] == '1970-01-01'){
        $dateconnected = '';
      }else{
        $dateconnected = $row['date_connected'];
      }


  $output .= '
    <tr>
      <td>'.$row['first_name'].'</td>
      <td>'.$row['last_name'].'</td>
      <td>'.$row['organization_title'].'</td>
      <td>'.$row['email'].'</td>
      <td>'.$row['phone_num'].'</td>
      <td>'.$row['mobile_num'].'</td>
      <td>'.$row['direct_line_num'].'</td>
      <td>'.$row['organization_name'].'</td>
      <td>'.$row['organization_location_1'].'</td>
      <td>'.$row['country'].'</td>
      <td>'.$row['organization_website'].'</td>
      <td>'.$row['industry'].'</td>
      <td>'.$dateconnected.'</td>
      <td>'.$row['linkedin_url'].'</td>
      <td>'.$row['date_added'].'</td>
      <td>'.$row['email_source_name'].'</td>
      <td>'.$emailstats.'</td>
      <td>'.$row['my_fullname']." / ".$row['my_email'].'</td>
      <td>'.$row['account_type'].'</td>
   </tr>
  ';

}
 

  }



 echo $output;
 
?>

 <!-- <script type="text/javascript" src="..res/get_records.js"></script> -->
 <script>
 
       $('#fetchRecords_persona').click(function () {
          const dataTable2 = document.getElementById("fetch-persona-csv");
          const filename = document.getElementById("text-fetch-records").value;
          const c = confirm(`Download CSV ? `);
          if (c) {
            const exporter = new TableCSVExporter(dataTable2);
            const csvOutput = exporter.convertToCSV();
            const csvBlob = new Blob([csvOutput], { type: "text/csv" });
            const blobUrl = URL.createObjectURL(csvBlob);
            const anchorElement = document.createElement("a");

            anchorElement.href = blobUrl;
            anchorElement.download =  filename+"-logs-contacts.csv";
            anchorElement.click();

              

            setTimeout(() => {
                URL.revokeObjectURL(blobUrl);
            }, 500);

        }
        });
 
      </script>
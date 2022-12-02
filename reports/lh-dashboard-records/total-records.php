<?php
require('api/config.php');
  require('api/query.php');

 ?>
 <script src="res/javascript.js?v=2.1" defer></script>
    <!-- <link rel="stylesheet" type="text/css" href="res/style.css"> -->
       <script src="jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script>
<!--   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
 <link rel="stylesheet" type="text/css" href="res/total-records.css">
 <style>
   .btn.btn-success {
    color: #fff!important;
    background-color: #04AA6D!important;
    border-color: #04AA6D!important;
}

.btn.btn-success.focus:not(.btn-text), .btn.btn-success:focus:not(.btn-text), .btn.btn-success:hover:not(.btn-text):not(:disabled):not(.disabled) {
    color: #fff!important;
    background-color: #218838 !important;
    border-color: #218838!important;
}


 </style>
<div class="container-panel">

 <?php
$remov = array("[", "]");
$replc   = array('','');
$newphrase = str_replace($remov, $replc, $datas);

if(in_array(209, px_login::roles("ORG")) || px_login::info("user_id") == 51794 ||  px_login::info("user_id") == 1248399){
	
	 $sql_persona = "SELECT * FROM linkedin_account_persona where x = 'active' order by my_email asc ";
}else{
	 $sql_persona = "SELECT * FROM linkedin_account_persona where x = 'active'  and assigned_to like '%$user_no%' order by my_fullname asc ";
}

 ?>
<table class="table-records">
<tr>
 
    <td class="sub_caption_b_t"><span style="margin-right: 20px;">
	<?php 
	  if (in_array(209, px_login::roles("ORG")) || px_login::info("user_id") == 51794 ||  px_login::info("user_id") == 1248399){ ?>


		Select Date Range</span>
		From: <input type='text' class='datepicker'  id='from_datepicker'  /> 
		to: <input type='text' class='datepicker'  id='to_datepicker'/>
		Select Persona:   <select name="persona_id" id="persona_id"  >
		<option value="all">All Persona</option>
		<?php
			$res_persona = $conn->query($sql_persona);
			$totalss = $res_persona->num_rows;
			  while($row_persona = $res_persona->fetch_assoc()){
		?>
		<option value="<?php echo $row_persona['linkedin_account_persona_id'] ?>"><?php echo $row_persona['my_email']; ?></option>
			<?php } ?>
		</select>&nbsp;&nbsp;&nbsp;&nbsp;
		<button id="getRecordsPersona"   class="btn btn-success font-weight-bold mr-2">Search &nbsp;&nbsp;<i class="flaticon-search "></i></button>
 
<?php }else{ ?>
		
		Select Persona:   <select name="persona_id" id="persona_id"  >
		<option value='<?php echo $newphrase; ?>'>All Persona </option>
		<?php 
			$res_persona = $conn->query($sql_persona);
			$totalss = $res_persona->num_rows;
			  while($row_persona = $res_persona->fetch_assoc()){
		?>

		<option value="<?php echo $row_persona['linkedin_account_persona_id'] ?>"><?php echo $row_persona['my_email']; ?></option>
			<?php } ?>
		</select>&nbsp;&nbsp;&nbsp;&nbsp;
		<button id="getRecordsByPersonaID"   class="btn btn-success font-weight-bold mr-2">Search &nbsp;&nbsp;<i class="flaticon-search "></i></button>

<?php } ?>


<input type="text" value="<?php echo "Mar 10, 2022 to ".$dateToday;?>" id="text-all-records" hidden>

    </td>
    
</tr>
 
</table>

 


<br>
<div id="loader" class="lds-dual-ring hidden overlay"></div>
  <div id="getRecords" style="display: none;"> </div>  
  <div id="getRecordsByPersona" style="display: none;"> </div>  

<div id="totalRecords">
   <div class="row">
   	<div class="col-md-6">
   		<?php if (px_login::info("user_id") == 6541){ 
   			echo "";
   		}else{echo $dateDefault;} ?>
</div>
<div class="col-md-6">
<?php 
 if (in_array(209, px_login::roles("ORG")) || px_login::info("user_id") == 51794 || px_login::info("user_id") == 1252979   || px_login::info("user_id") == 6541 ||  px_login::info("user_id") == 1248399){?>
<button class="btn btn-info font-weight-bold mr-2" style="float: right; margin-bottom: 1%;" id="allRecords"> Export to CSV &nbsp;<i class="flaticon-file-2"></i></button>
<?php } ?>

</div>
</div>
 
 

<?php // if (in_array(154, px_login::roles("ORG")) || px_login::info("user_id") == 6541  ){ 
	if (in_array(209, px_login::roles("ORG")) || px_login::info("user_id") == 51794 ||  px_login::info("user_id") == 1248399){ 
 ?>

		<table class="table table-bordered table-hover" id="tableEmails" >
		  <thead>
		  
		    <tr id="trEmails">
		      
		      <th>Total Records</th>
		      <th>Total Emails Found</th>
		      <th>Total No Emails</th>
		      <th>Total Valid Emails Status</th>
		      <th>Total Unverifiable Emails Status</th>
		      
		     

		    </tr>
		  </thead>

		  <tbody id="tbodyEmails">
		  
		 
		     <tr>
		     <td><?php echo number_format($totalRecords); ?></td>
		     <td><?php echo number_format($totalEmailsFound); ?></td>
		     <td><?php echo number_format($totalNoEmailFound); ?></td>
		     <td><?php echo number_format($totalValidEmails); ?></td>
		     <td><?php echo number_format($totalUnverifiableEmails); ?></td>
		   
		    </tr>  
		 
		 

		  </tbody>
		</table>

	<?php }else{ ?>

		<table class="table table-bordered table-hover" id="tableEmails" >
		  <thead>
		  
		    <tr id="trEmails">
		      
		      <th>Total Records</th>
		      <th>Total Emails Found</th>
		      <th>Total No Emails</th>
		      <th>Total Valid Emails Status</th>
		      <th>Total Unverifiable Emails Status</th>
		      
		     

		    </tr>
		  </thead>

		  <tbody id="tbodyEmails">
		  
		 
		     <tr>
		     <td><?php echo number_format($persona_totalRecords); ?></td>
		     <td><?php echo number_format($persona_totalEmailsFound); ?></td>
		     <td><?php echo number_format($persona_totalNoEmailFound); ?></td>
		     <td><?php echo number_format($persona_totalValidEmails); ?></td>
		     <td><?php echo number_format($persona_totalUnverifiableEmails); ?></td>
		   
		    </tr>  
		 
		 

		  </tbody>
		</table>
	<?php } ?>

<?php
 if (in_array(209, px_login::roles("ORG")) || px_login::info("user_id") == 51794 || px_login::info("user_id") == 6541 ||  px_login::info("user_id") == 1248399){
  ?>

<table class="table table-responsive" id="all-records-csv" hidden>
	<thead id="trEmails">
		<tr>
		
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
	</thead>
	<tbody id="tbodyEmails">
	 
	<?php   
		
	   while($row = $res0->fetch_assoc()){
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

		 ?>
		<tr>
			 
		  <td><?php echo $row['first_name']; ?></td>
		  <td><?php echo $row['last_name'] ?></td>
			<td><?php echo $row['organization_title']; ?></td>
			<td><?php echo $row['email']; ?></td>
			<td><?php echo $row['phone_num']; ?></td>
			<td><?php echo $row['mobile_num']; ?></td>
			<td><?php echo $row['direct_line_num']; ?></td>
			<td><?php echo $row['organization_name']; ?></td>
			<td><?php echo $row['organization_location_1']; ?></td>
			<td><?php echo $row['country']; ?></td>
			<td><?php echo $row['organization_website']; ?></td>
			<td><?php echo $row['industry']; ?></td>
			<td><?php echo $dateconnected; ?></td>
			<td><?php echo $row['linkedin_url']; ?></td>
			<td><?php echo $row['date_added']; ?></td>
			<td><?php echo $row['email_source_name']; ?></td>
			<td><?php echo $emailstats; ?></td>
			<td><?php echo $row['my_fullname']." / ".$row['my_email']; ?></td>  
			<td><?php echo $row['account_type']; ?></td>
			
		</tr>
	<?php   }   ?>

	 



	</tbody>
</table>
<?php } ?>

</div>

 
 
</div>
 

 <script type="text/javascript" src="res/get_records.js"></script>
 

































 <?php 
$gui->foot();

?>




<script>
 
$( document ).ready(function() {
//Branded Weekly total Average
var getinviteSentB  = $('#avg_invitesentDaily<?php echo $rowPersona2['user_id']; ?>').text()
var getConnectionsB  = $('#avg_connectionsDaily<?php echo $rowPersona2['user_id']; ?>').text()
var avgWeekBranded =  parseFloat(getConnectionsB/getinviteSentB*100).toFixed(2)+""+"%";
document.getElementById("avg_connections_rateDaily<?php echo $rowPersona2['user_id']; ?>").innerHTML = avgWeekBranded;
document.getElementById("total_connections_rateDaily<?php echo $rowPersona2['user_id']; ?>").innerHTML = avgWeekBranded;
//Generic Weekly total Average
 var getinviteSentG = $('#avg_invitesentGDaily<?php echo $rowPersona2['user_id']; ?>').text()
     var getConnectionsG = $('#avg_connectionsGDaily<?php echo $rowPersona2['user_id']; ?>').text()
var avgWeekGeneric =  parseFloat(getConnectionsG/getinviteSentG*100).toFixed(2)+""+"%";
document.getElementById("avg_connections_rateGDaily<?php echo $rowPersona2['user_id']; ?>").innerHTML = avgWeekGeneric;
 document.getElementById("total_connections_rateGDaily<?php echo $rowPersona2['user_id']; ?>").innerHTML = avgWeekGeneric;

  var TotalBG_ISent = parseInt($('#total_invitesentBDaily<?php echo $rowPersona2['user_id']; ?>').text()) + parseInt($('#total_invitesentGDaily<?php echo $rowPersona2['user_id']; ?>').text());

  var TotalBG_Inmail = parseInt($('#total_inmailBDaily<?php echo $rowPersona2['user_id']; ?>').text()) + parseInt($('#total_inmailGDaily<?php echo $rowPersona2['user_id']; ?>').text());

  var TotalBG_Con = parseInt($('#total_connectionsBDaily<?php echo $rowPersona2['user_id']; ?>').text()) + parseInt($('#total_connectionsGDaily<?php echo $rowPersona2['user_id']; ?>').text());
var totalBG_Rate =  parseFloat(TotalBG_Inmail/TotalBG_ISent*100).toFixed(2)+""+"%";

if (document.getElementById("totalISentDaily<?php echo $rowPersona2['user_id']; ?>")) {
  document.getElementById("totalISentDaily<?php echo $rowPersona2['user_id']; ?>").innerHTML =   TotalBG_ISent;
  document.getElementById("totalInmaleDaily<?php echo $rowPersona2['user_id']; ?>").innerHTML =   TotalBG_Inmail;
  document.getElementById("totalIConDaily<?php echo $rowPersona2['user_id']; ?>").innerHTML =   TotalBG_Con;
  document.getElementById("totalConRateDaily<?php echo $rowPersona2['user_id']; ?>").innerHTML =   totalBG_Rate;
  console.log(TotalBG_ISent);
}  
 
});



function calculateBrandedDaily() {
  var sum = 0;
  var counter  = 0  
   var sum2 = 0;
  var counter2  = 0  
  var sum3 = 0;
  var counter3  = 0  


   
  $('#BrandedTblDaily<?php echo $rowPersona2['user_id']; ?> tbody tr td:nth-child(3)').each(function() {
  // $("table tbody tr td:eq(4)").each(function(){
    if (!isNaN($(this).text()))
    {
      sum+= parseFloat($(this).text());
      counter+= 1;
    }
    });

 
  $('#BrandedTblDaily<?php echo $rowPersona2['user_id']; ?> tbody tr td:nth-child(4)').each(function() {
 
    if (!isNaN($(this).text()))
    {
      sum2 += parseFloat($(this).text());
      counter2 += 1;
    }
    });
 
   $('#BrandedTblDaily<?php echo $rowPersona2['user_id']; ?> tbody tr td:nth-child(5)').each(function() {
 
    if (!isNaN($(this).text()))
    {
      sum3 += parseFloat($(this).text());
      counter3 += 1;
    }
    });

  $("#avg_invitesentDaily<?php echo $rowPersona2['user_id']; ?>").text(parseFloat(sum/counter).toFixed(2));
  $("#avg_inmailDaily<?php echo $rowPersona2['user_id']; ?>").text(parseFloat(sum2/counter2).toFixed(2));
   $("#avg_connectionsDaily<?php echo $rowPersona2['user_id']; ?>").text(parseFloat(sum3/counter3).toFixed(2));

 
 
  $("#total_invitesentBDaily<?php echo $rowPersona2['user_id']; ?>").text(sum);
 $("#total_inmailBDaily<?php echo $rowPersona2['user_id']; ?>").text(sum2);
 $("#total_connectionsBDaily<?php echo $rowPersona2['user_id']; ?>").text(sum3);



}
calculateBrandedDaily();
 
function calculateGenericDaily() {
  var sum = 0;
  var counter  = 0  
   var sum2 = 0;
  var counter2  = 0  
  var sum3 = 0;
  var counter3  = 0  


   
  $('#GenericTblDaily<?php echo $rowPersona2['user_id']; ?> tbody tr td:nth-child(3)').each(function() {
  // $("table tbody tr td:eq(4)").each(function(){
    if (!isNaN($(this).text()))
    {
      sum+= parseFloat($(this).text());
      counter+= 1;
    }
    });

 
  $('#GenericTblDaily<?php echo $rowPersona2['user_id']; ?> tbody tr td:nth-child(4)').each(function() {
 
    if (!isNaN($(this).text()))
    {
      sum2 += parseFloat($(this).text());
      counter2 += 1;
    }
    });
 
   $('#GenericTblDaily<?php echo $rowPersona2['user_id']; ?> tbody tr td:nth-child(5)').each(function() {
 
    if (!isNaN($(this).text()))
    {
      sum3 += parseFloat($(this).text());
      counter3 += 1;
    }
    });

  $("#avg_invitesentGDaily<?php echo $rowPersona2['user_id']; ?>").text(parseFloat(sum/counter).toFixed(2));
  $("#avg_inmailGDaily<?php echo $rowPersona2['user_id']; ?>").text(parseFloat(sum2/counter2).toFixed(2));
   $("#avg_connectionsGDaily<?php echo $rowPersona2['user_id']; ?>").text(parseFloat(sum3/counter3).toFixed(2));

 

 
  $("#total_invitesentGDaily<?php echo $rowPersona2['user_id']; ?>").text(sum);
 $("#total_inmailGDaily<?php echo $rowPersona2['user_id']; ?>").text(sum2);
 $("#total_connectionsGDaily<?php echo $rowPersona2['user_id']; ?>").text(sum3);

 

}
calculateGenericDaily();
</script>

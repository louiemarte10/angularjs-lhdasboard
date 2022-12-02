<script>
 
$( document ).ready(function() {
//Branded Weekly total Average
var getinviteSentB = $('#avg_invitesent<?php echo $rowPersona['user_id']; ?>').text()
var getConnectionsB = $('#avg_connections<?php echo $rowPersona['user_id']; ?>').text()
var avgWeekBranded =  parseFloat(getConnectionsB/getinviteSentB*100).toFixed(2)+""+"%";
document.getElementById("avg_connections_rate<?php echo $rowPersona['user_id']; ?>").innerHTML = avgWeekBranded;
document.getElementById("total_connections_rate<?php echo $rowPersona['user_id']; ?>").innerHTML = avgWeekBranded;

//Generic Weekly total Average
 var getinviteSentG = $('#avg_invitesentG<?php echo $rowPersona['user_id']; ?>').text()
     var getConnectionsG = $('#avg_connectionsG<?php echo $rowPersona['user_id']; ?>').text()
var avgWeekGeneric =  parseFloat(getConnectionsG/getinviteSentG*100).toFixed(2)+""+"%";
document.getElementById("avg_connections_rateG<?php echo $rowPersona['user_id']; ?>").innerHTML = avgWeekGeneric;
 document.getElementById("total_connections_rateG<?php echo $rowPersona['user_id']; ?>").innerHTML = avgWeekGeneric;

  var TotalBG_ISent = parseInt($('#total_invitesentB<?php echo $rowPersona['user_id']; ?>').text()) + parseInt($('#total_invitesentG<?php echo $rowPersona['user_id']; ?>').text());

  var TotalBG_Inmail = parseInt($('#total_inmailB<?php echo $rowPersona['user_id']; ?>').text()) + parseInt($('#total_inmailG<?php echo $rowPersona['user_id']; ?>').text());

  var TotalBG_Con = parseInt($('#total_connectionsB<?php echo $rowPersona['user_id']; ?>').text()) + parseInt($('#total_connectionsG<?php echo $rowPersona['user_id']; ?>').text());
var totalBG_Rate =  parseFloat(TotalBG_Inmail/TotalBG_ISent*100).toFixed(2)+""+"%";

  if (document.getElementById("totalISent<?php echo $rowPersona['user_id']; ?>")) {
    document.getElementById("totalISent<?php echo $rowPersona['user_id']; ?>").innerHTML = TotalBG_ISent;
    document.getElementById("totalInmale<?php echo $rowPersona['user_id']; ?>").innerHTML = TotalBG_Inmail;
    document.getElementById("totalICon<?php echo $rowPersona['user_id']; ?>").innerHTML = TotalBG_Con;
    document.getElementById("totalConRate<?php echo $rowPersona['user_id']; ?>").innerHTML = totalBG_Rate;
  }  
 
 
});



function calculate() {
  var sum = 0;
  var counter  = 0  
   var sum2 = 0;
  var counter2  = 0  
  var sum3 = 0;
  var counter3  = 0  


   
  $('#BrandedTblWeekly<?php echo $rowPersona['user_id']; ?> tbody tr td:nth-child(3)').each(function() {
  // $("table tbody tr td:eq(4)").each(function(){
    if (!isNaN($(this).text()))
    {
      sum+= parseFloat($(this).text());
      counter+= 1;
    }
    });

 
  $('#BrandedTblWeekly<?php echo $rowPersona['user_id']; ?> tbody tr td:nth-child(4)').each(function() {
 
    if (!isNaN($(this).text()))
    {
      sum2 += parseFloat($(this).text());
      counter2 += 1;
    }
    });
 
   $('#BrandedTblWeekly<?php echo $rowPersona['user_id']; ?> tbody tr td:nth-child(5)').each(function() {
 
    if (!isNaN($(this).text()))
    {
      sum3 += parseFloat($(this).text());
      counter3 += 1;
    }
    });

  $("#avg_invitesent<?php echo $rowPersona['user_id']; ?>").text(parseFloat(sum/counter).toFixed(2));
  $("#avg_inmail<?php echo $rowPersona['user_id']; ?>").text(parseFloat(sum2/counter2).toFixed(2));
   $("#avg_connections<?php echo $rowPersona['user_id']; ?>").text(parseFloat(sum3/counter3).toFixed(2));
 
 
  $("#total_invitesentB<?php echo $rowPersona['user_id']; ?>").text(sum);
 $("#total_inmailB<?php echo $rowPersona['user_id']; ?>").text(sum2);
 $("#total_connectionsB<?php echo $rowPersona['user_id']; ?>").text(sum3);



}
calculate();
 
function calculateGeneric() {
  var sum = 0;
  var counter  = 0  
   var sum2 = 0;
  var counter2  = 0  
  var sum3 = 0;
  var counter3  = 0  


   
  $('#GenericTblWeekly<?php echo $rowPersona['user_id']; ?> tbody tr td:nth-child(3)').each(function() {
  // $("table tbody tr td:eq(4)").each(function(){
    if (!isNaN($(this).text()))
    {
      sum+= parseFloat($(this).text());
      counter+= 1;
    }
    });

 
  $('#GenericTblWeekly<?php echo $rowPersona['user_id']; ?> tbody tr td:nth-child(4)').each(function() {
 
    if (!isNaN($(this).text()))
    {
      sum2 += parseFloat($(this).text());
      counter2 += 1;
    }
    });
 
   $('#GenericTblWeekly<?php echo $rowPersona['user_id']; ?> tbody tr td:nth-child(5)').each(function() {
 
    if (!isNaN($(this).text()))
    {
      sum3 += parseFloat($(this).text());
      counter3 += 1;
    }
    });

  $("#avg_invitesentG<?php echo $rowPersona['user_id']; ?>").text(parseFloat(sum/counter).toFixed(2));
  $("#avg_inmailG<?php echo $rowPersona['user_id']; ?>").text(parseFloat(sum2/counter2).toFixed(2));
   $("#avg_connectionsG<?php echo $rowPersona['user_id']; ?>").text(parseFloat(sum3/counter3).toFixed(2));
 

 
  $("#total_invitesentG<?php echo $rowPersona['user_id']; ?>").text(sum);
 $("#total_inmailG<?php echo $rowPersona['user_id']; ?>").text(sum2);
 $("#total_connectionsG<?php echo $rowPersona['user_id']; ?>").text(sum3);

 

}
calculateGeneric();
</script>
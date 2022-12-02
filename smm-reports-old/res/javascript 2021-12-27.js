/*jshint esversion: 11 */
/*jshint -W033 */
var clients = [];
var no_mailjet = [];
var active_only = false;
var isGenerate = false;

$(document).on("change", "#select_date", function(){
    // isGenerate
    
    if($(this).val()=="Date Range"){
        if(isGenerate == true){
            $(".dateRange").html("From: <input type='text' id='from_datepicker' class='datepicker'/>" +
                            "To: <input type='text' class='datepicker' id='to_datepicker'/>&nbsp;<button id='find1'>Go</button>");
            $( ".datepicker" ).datepicker({dateFormat: "yy-mm-dd"});
        }else{
            $(".dateRange").html("From: <input type='text' id='from_datepicker' class='datepicker'/>" +
                            "To: <input type='text' class='datepicker' id='to_datepicker'/>");
            $( ".datepicker" ).datepicker({dateFormat: "yy-mm-dd"});
        }
        
    }
    else{
        $(".dateRange").html("");
        $("#companies").each(function(){
            if($(this).is(":visible")){
            }
            else{
                $(".proj_ids").each(function(){
                    if($(this).is(":checked")){
                        clickFind();
                    return false;
                    }
                });
            }
        });
    }

    

});
 

$(document).on("click", "#all", function(){
	if($(this).attr("g") != "checked") {
		$(this).attr("g","checked");
		$(".proj_ids").each(function(){
	        if(!$(this).prop("checked")){
                $(this).click();
                $('#btn_mailjet_dialer_active').prop('checked', true);
                $('#btn_mailjet_dialer_inactive').prop('checked', true);
                $('#btn1_scheme_active').prop('checked', true);
                $('#btn1_scheme_inactive').prop('checked', true);

            } 
   		});
	}else{
		$(this).attr("g","");
		$(".proj_ids").each(function(){
			if($(this).prop("checked")){
                $(this).click();
                $('#btn_mailjet_dialer_active').prop('checked', false);
                $('#btn_mailjet_dialer_inactive').prop('checked', false);
                $('#btn1_scheme_active').prop('checked', false);
                $('#btn1_scheme_inactive').prop('checked', false);


            } 
		});
	}
 
    active_only = false;

});
$(document).on("change", "#btn_mailjet_dialer_active", function(){
    if ($(this).is(':checked')) {
        $(".proj_ids").each(function () {
            if ($(this).attr("data-mbsx") == 'active') {
                $(this).prop('checked', true);
            }
            // else if($(this).attr("data-mbsx") == 'inactive' && !$(this).prop("checked")) $(this).click();
        });
    }
    else{
        $(".proj_ids").each(function(){
			if($(this).attr("data-mbsx") == 'active') {
                $(this).prop('checked', false);
            }
	        
		});
        // active_only = false;
    }
});
$(document).on("change", "#btn_mailjet_dialer_inactive", function(){
    if ($(this).is(':checked')) {

        $(".proj_ids").each(function () {
            if ($(this).attr("data-mbsx") == 'inactive') {
                $(this).prop('checked', true);
            }
            // else if($(this).attr("data-mbsx") == 'inactive' && !$(this).prop("checked")) $(this).click();
        });
    }
    else{
        $(".proj_ids").each(function(){
			if($(this).attr("data-mbsx") == 'inactive') {
                $(this).prop('checked', false);
            }
	        
		});
        // active_only = false;
    }
});
$(document).on("change", "#btn1_scheme_active", function(){
    
		// $(this).text("Select Active Only");
    if ($(this).is(':checked')) {

		$(".proj_ids").each(function(){
			if($(this).attr("data-status") != 'scheme_inactive' && $(this).attr("data-mbsx") == 'empty') {
                $(this).prop('checked', true);
            }
	        
		});
        // active_only = true;
    }else{
        $(".proj_ids").each(function(){
			if($(this).attr("data-status") != 'scheme_inactive' && $(this).attr("data-mbsx") == 'empty') {
                $(this).prop('checked', false);
            }
	        
		});
        // active_only = false;
    }
        
	
});
$(document).on("change", "#btn1_scheme_inactive", function(){
    if ($(this).is(':checked')) {
    
		$(".proj_ids").each(function(){
			if($(this).attr("data-status") == 'scheme_inactive' && $(this).attr("data-mbsx") == 'empty') {
                $(this).prop('checked', true);
            }
   		});

        // active_only = false;
    }else{
        $(".proj_ids").each(function(){
			if($(this).attr("data-status") == 'scheme_inactive' && $(this).attr("data-mbsx") == 'empty') {
                $(this).prop('checked', false);
            }
	        
		});
        // active_only = false;
    }

	
});
// $(document).on("click", "#btn_scheme_inactive", function(){
//     if($(this).text() == "Select Active Only") {
// 		$(this).text("Select Inactive Only");
// 		$(".proj_ids").each(function(){
// 			if($(this).attr("data-status") == 'scheme_inactive' && $(this).prop("checked")) $(this).click();
// 	        else if($(this).attr("data-status") != 'scheme_inactive' && !$(this).prop("checked")) $(this).click();
//    		});

//         active_only = true;

// 	}else{
// 		$(this).text("Select Active Only");
// 		$(".proj_ids").each(function(){
// 			if($(this).attr("data-status") != 'scheme_inactive' && $(this).prop("checked")) $(this).click();
// 	        else if($(this).attr("data-status") == 'scheme_inactive' && !$(this).prop("checked")) $(this).click();
// 		});

//         active_only = false;
// 	}
// });



function generate(){
    var OPENP = 0;
    var CLICKP = 0;
    var total_contactScheme = 0;
    var total_sendMail = 0;
    var total_clicks = 0;
    var total_openedMails = 0;
    var total_dynamicList = 0;
    var total_callPriority = 0;
    var total_totalAction = 0;

    var total_sent = 0;
    var total_delivered = 0;
    var total_opened = 0;
    var total_opened_perc = 0;
    var total_click = 0;
    var total_x = 0;
    var total_converted = 0;
    var total_unsubs = 0;
    var total_bounce = 0;
    var project_name ="TOTAL";

    var department = $("#select_dept").val();
    var table = $('#ActivityLogResults');
    var table2 = $ ('#EmailMarketingResults');
    var str = "";
    var str2 = "";
    
    if (department == "all" ) {
        department = new Array;
        $("#select_dept").find("option").each(function() {
            if($(this).val() != "all") department.push($(this).val());

        });

        department = department.join(",");
    }
   
        xhr.queue({ //start xhr.queue1
            url: "generate.php",
            type: "POST",
            data: {
                generate:department,
				dt_defined: $('#select_date').val(),
				date_end: $('#to_datepicker').val(),
				include_mail_jet : $('#include_mail_jet').prop('checked'),
				include_inactive_wf : $('#include_inactive_wf').prop('checked'),
				date_start: $('#from_datepicker').val()},
           		success: function(e) { //start success   
               
                    

                $("#companies_scheme").html("");
            	$("#no_mailjet_scheme").html("");
                //alert ("'"+e+"'");
                if (e.trim() == "NoResultsFound") {
                    $('#ActivityLogResults').html('<div class="noResult">No results found</div>');
                    $('#EmailMarketingResults').html('<div class="noResult">No results found</div>');
                    $('#companies_scheme').append("<div class='noResult'>No results found.</div>");
                    $("#go, .company_scheme_title").show();
                }
                else{
                    response = JSON.parse(e);

                    table.html("");
                    table2.html("");
                    var i = 1; var page =1;
                	var i2 = 1;
                	var page2 = 1;
					clients = response.clients;
                	no_mailjet = response.without_mailjet;
                    $.each(clients, function (htree_id) { //start each function
                        
						/*loop++;
	                    if(loop > 1) $("#companies_scheme").append("<div class='columns'>"+htree_id+str+"</div>");
						str = "";*/
						$.each(clients[htree_id], function (index, element2) {
                            
							

							$.each(element2, function (index2, element) {
                               console.log(element);
                       		clients[element.client_id] = element.company;
							str += "<div><input type='checkbox' data-client-id='"+element.client_id+"' ";

                            if(element.mbsx == "inactive" || element.mbsx == "active"){
                                if(element.lnx == "inactive"){
                                    str += "data-mbsx='" + element.lnx + "'";
                                    class2 += " mbsx_inactive"
                                    console.log(element.project_name, element.mbsx);
                                }else{
                                    str += "data-mbsx='"+element.lnx+"'";
                                    class2 += " mbsx_active"
                                    console.log(element.project_name,element.mbsx);
                                }
                                
                            }else{

                                str += "data-mbsx='empty'";

                                if(index!='active') class2='scheme_inactive';
							    else class2 ='scheme_active';
                            }

                            
                            // if(element.mbsx == "active"){
                            //     str += "data-mbsx='"+element.mbsx+"'";
                            //     class2 += " mbsx_active"
                            //     console.log(element.project_name,element.mbsx);
                            // }
                            // else if(element.mbsx == "inactive"){
                            //     str += "data-mbsx='"+element.mbsx+"'";
                            //     class2 += " mbsx_inactive"
                            //     console.log(element.project_name,element.mbsx);
                            // }else{
                            //     str += "data-mbsx='empty'";

                            //     if(index!='active') class2='scheme_inactive';
							//     else class2 ='scheme_active';
                            // }
							str += "data-htree='"+element.node+"' data-val=\""+element.project_name+"\" ";
							str += "data-pg=\""+element.company+"\" data-status='"+class2+"' class='proj_ids "+class2+"'";
							str += "value='"+element.ln_project_id+"' id='lnp_"+element.ln_project_id+"'>";
							str += "<label for='lnp_"+element.ln_project_id+"'>";
							str += element.company+" - <span class='project_name "+class2+"'>" +element.project_name+ "</span></label></div>";
							if(i++==15){
								 $("#companies_scheme").append("<div class='columns' id='"+page+"'>"+str+"</div>");
								 str = "";
								 i =1;
								 page++;
							 }
							});
						});
                    }); //end of each function
                    if(str != ""){
                         $("#companies_scheme").append("<div class='columns' id='"+page+"'>"+str+"</div>");
                    }
                if ($('#include_mail_jet').prop('checked')) {

                    $.each(no_mailjet, function (htree_id, value) {

                        str2 += "<div>";
                        str2 += "<label>";
                        str2 += value + "</label></div>";
                        if (i2++ == 15) {
                            $("#no_mailjet_scheme").append("<div class='columns' id='" + page2 + "'>" + str2 + "</div>");
                            str2 = "";
                            i2 = 1;
                            page2++;
                        }
                    }); //end of each function
                    if (str2 != "") {
                        $("#no_mailjet_scheme").append("<div class='columns' id='" + page2 + "'>" + str2 + "</div>");
                    }
                    $("#no_mailjet").show();
                } 
                else {
                    $("#no_mailjet").hide();
                }

                       $("#go, .company_scheme_title").show();



                    $("#companies").fadeIn('slow');
                    $("#main").fadeOut('slow');
					$("#mj_enrolled").hide();
                  
                }//end success

            }
        });//end xhr.queue1
        isGenerate = false;
        $('#find1').hide();

}
$(document).on("click", "#find", function(){
    // var data = $(this);

	if ($('#choose_report').val() == 'MJ Enrolled'){
		if ($('[data-client-id]:checked').length < 1){
			alert('Please select scheme(s)');
			return;
		}

		var schemes = [];
		$('[data-client-id]:checked').each((i, e) => {
			schemes.push(e.value);
		});

		xhr.queue({
			url: 'api/mj-enrollments.php',
			data: {
				schemes,
				dt_defined: $('#select_date').val(),
				dt_from: $('#from_datepicker').val(),
				dt_to: $('#to_datepicker').val()
			},
			success(htm){
				$("#mj_enrolled").html(htm).show();
               
			}
		});

		$("#mj_enrolled").show();
		$("#companies").hide();
	} else {
	    clickFind();
        campaignStats();
	}
    isGenerate = true;
    // alert(isGenerate);
    if($("#select_date").val()=="Date Range"){
        $('#find1').show();
    }
    
    // $("#no_mailjet").hide();
});
$(document).on("click", "#find1", function(){
    // var data = $(this);

	if ($('#choose_report').val() == 'MJ Enrolled'){
		if ($('[data-client-id]:checked').length < 1){
			alert('Please select scheme(s)');
			return;
		}

		var schemes = [];
		$('[data-client-id]:checked').each((i, e) => {
			schemes.push(e.value);
		});

		xhr.queue({
			url: 'api/mj-enrollments.php',
			data: {
				schemes,
				dt_defined: $('#select_date').val(),
				dt_from: $('#from_datepicker').val(),
				dt_to: $('#to_datepicker').val()
			},
			success(htm){
				$("#mj_enrolled").html(htm).show();
               
			}
		});

		$("#mj_enrolled").show();
		$("#companies").hide();
	} else {
	    clickFind();
        campaignStats();
	}
    isGenerate = true;
    // alert(isGenerate);
    // $("#no_mailjet").hide();
});

function hide_column () {
	const include_mailjet = $('#include_mail_jet').prop('checked');
	if (include_mailjet) {
		$(".hidden_col").each(function () {
			$(this).hide();
		});
	} else {
		$(".hidden_col").each(function () {
			$(this).show();
		});
	}
}

const campaignStats = async () => {
    var department = $("#select_dept").val();
    if (department == "all" ) {
        department = new Array;
        $("#select_dept").find("option").each(function() {
            if($(this).val() != "all") department.push($(this).val());
        });
        department = department.join(",");
    }
    
    await xhr.queue({
        type : 'GET',
        url : '/lead-nurturing/api/campaign-stats.php',
        data : { 
            department,
            dt_defined: $('#select_date').val(),
            date_end: $('#to_datepicker').val(),
            date_start: $('#from_datepicker').val()
        },
        success : function (xml) {
            const result = JSON.parse(xml)
            console.log(result);
            $("#mailjet-stats-body").html("");
            let table_data = "";     
            $("#mailjet-stats").show();       
            $("#mailjet-stats-title").show();  
            if (result.length === 0) {
                
                table_data += "<tr class='breakdown_dept_row'>";
                table_data += `<td colspan='9' style='text-align: center;font-weight: 600'>No Result</td>`;
                table_data += "</tr>";
                $("#mailjet-stats-body").html(table_data);
            } else {
                let total_success_calls = 0;
                let total_success_calls_overlap = 0;
                let total_sent = 0;
                let total_delivered = 0;
                let total_opens = 0;
                let total_bounce = 0;
                let total_clicks = 0;
                for (var x in result) {
                    total_success_calls += result[x].total_success_calls;
                    total_success_calls_overlap += result[x].total_success_calls_overlap;
                    total_sent += result[x].total_sent;
                    total_delivered += result[x].total_delivered;
                    total_opens += result[x].total_opens;
                    total_bounce += result[x].total_bounce;
                    total_clicks += result[x].total_clicks;
                    const open_rate = ((result[x].total_opens / result[x].total_delivered) * 100).toFixed(2);
                    table_data += "<tr class='breakdown_dept_row'>";
                    table_data += `<td>${x}</td>`;
                    table_data += `<td>${result[x].total_success_calls}</td>`;
                    table_data += `<td>${result[x].total_success_calls_overlap}</td>`;
                    table_data += `<td>${result[x].total_sent}</td>`;
                    table_data += `<td>${result[x].total_delivered}</td>`;
                    table_data += `<td>${result[x].total_opens}</td>`;                
                    table_data += `<td>${open_rate}%</td>`;
                    table_data += `<td>${result[x].total_bounce}</td>`;
                    table_data += `<td>${result[x].total_clicks}</td>`;
                    table_data += "</tr>";
                }
                $("#mailjet-stats").show();
                const total_open_rate = ((total_opens / total_delivered) * 100).toFixed(2);
                table_data += "<tr>";
                table_data += `<th class='tl' style='text-align:center;'>Total: </td>`;
                table_data += `<th class='tl' style='text-align:left;'>${total_success_calls}</td>`;
                table_data += `<th class='tl' style='text-align:left;'>${total_success_calls_overlap}</td>`;
                table_data += `<th class='tl' style='text-align:left;'>${total_sent}</td>`;
                table_data += `<th class='tl' style='text-align:left;'>${total_delivered}</td>`;
                table_data += `<th class='tl' style='text-align:left;'>${total_opens}</td>`;                
                table_data += `<th class='tl' style='text-align:left;'>${total_open_rate}%</td>`;                
                table_data += `<th class='tl' style='text-align:left;'>${total_bounce}</td>`;
                table_data += `<th class='tl' style='text-align:left;'>${total_clicks}</td>`;
                table_data += "</tr>";
                $("#mailjet-stats-body").html(table_data);
            }            
        }
    })
}

function clickFind(){
    $("#main").fadeIn('slow');
    $(".total_act_log #cs, .total_act_log #es, .total_act_log #clicks, .total_act_log #oe, .total_act_log #al, .total_act_log #cp, .total_act_log #ta, .total_act_log #pn").text('');

	var ln_project_count = 0;

    var OPENP = 0;
    var CLICKP = 0;
    var total_contactScheme = 0;
    var total_sendMail = 0;
    var total_clicks = 0;
    var total_openedMails = 0;
    var total_dynamicList = 0;
    var total_callPriority = 0;
	var total_reminder = 0;
	var total_replies = 0;
    var total_totalAction = 0;
	var total_totalConverted = 0;

    var total_sent = 0;
    var total_delivered = 0;
    var total_opened = 0;
    var total_opened_perc = 0;
    var total_click = 0;
	var total_replied = 0;
    var total_x = 0;
    var total_converted = 0;
    var total_unsubs = 0;
    var total_bounce = 0;
    var total_soft_bounce = 0;
    var total_hard_bounce = 0;
    var project_name ="TOTAL";
	client_summary = [];
	dept_summary = [];

    var department = $("#select_dept").val();
    var table = $('#ActivityLogResults');
    var table2 = $('#EmailMarketingResults');
	table.html("");
	table2.html("");

    $("#table-head").show();

	if($("#select_date").val() == "Last Week" || $("#select_date").val() == "This Week" || $("#select_date").val() == "Date Range" )	daycount = 5;
	else daycount = 1;

	exc = 1;
    console.log(department);
    if(department == 43 || department == 37 || department == 124 || department == 218 || department == "ITL" ) exc = 0;
	else if($("#include_initial_blast").length!= 0 && $("#include_initial_blast:checked").length) exc = 0;

	$("#emails_on_queue_table tbody").html("");
    // let pid = []
    // $(".proj_ids").each(function () {
    //     pid.push($(this).val())
    // })
    // xhr.queue({  //start xhr.queue2
    //     url: "./api/mailjet.php",
    //     data: {
    //         proj_ids: pid,
    //         dt_defined: $('#select_date').val(),
    //         date_end: $('#to_datepicker').val(),
    //         date_start: $('#from_datepicker').val(),
    //
    //     },
    //     success: function (data) {
    //         console.log(data)
    //     }
    // })
   
  
    var total_delivered_new = 0;
    var total_open_avg_new = 0;
    var total_open_new = 0;
    $(".proj_ids").each(function(){
        if($(this).is(":checked")){
			ln_project_count++;
            var company = $(this).attr("data-pg");
            var proj_name = $(this).attr("data-val");
			var client_id = $(this).attr("data-client-id");
			var htree = $(this).attr("data-htree");
			var ln_project_id = $(this).val();
            

            xhr.queue({  //start xhr.queue2
                url: "/lead-nurturing/api/report-logs.php",
                data: {
                    proj_id: $(this).val(),
                    report_type: 'summary',
                    limit: 0,
                    display: 'logs',
                    dt_defined: $('#select_date').val(),
                    date_end: $('#to_datepicker').val(),
                    date_start: $('#from_datepicker').val(),
                    dataonly: 'true',
					exclude_blast: exc,
                    client_id
                },
                success: function (xml) {
                                        
					if (client_summary[htree] === undefined) client_summary[htree] =[];
                    if (client_summary[htree][client_id] === undefined) client_summary[htree][client_id] = {
                        contactScheme: 0,
                        sendMail: 0,
                        clicks: 0,
                        bounces: 0,
                        softbounces: 0,
                        hardbounces: 0,
                        openedMails: 0,
                        dynamicList: 0,
                        callPriority: 0,
                        reminder: 0,
                        replies: 0,
                        totalAction: 0,
                        totalConverted: 0,
                        schemeCount: 0,
                        schemes: [],
                        mailjet_workflows: [],
                        convertedEmails: [],
                        workflow_summary: {
                            'no response': {
                                contacts_in_scheme: 0,
                                opened_emails: 0,
                                clicks: 0,
                                email_sent: 0,
                                bounces: 0,
								replies: 0
                            },
                            'rfi': {
                                contacts_in_scheme: 0,
                                opened_emails: 0,
                                clicks: 0,
                                email_sent: 0,
                                bounces: 0,
								replies: 0
                            },
                            'positive': {
                                contacts_in_scheme: 0,
                                opened_emails: 0,
                                clicks: 0,
                                email_sent: 0,
                                bounces: 0,
								replies: 0
                            },
							'other': {
								contacts_in_scheme: 0,
								opened_emails: 0,
								clicks: 0,
								email_sent: 0,
								bounces: 0,
								replies: 0
							},
							'no interest': {
								contacts_in_scheme: 0,
								opened_emails: 0,
								clicks: 0,
								email_sent: 0,
								bounces: 0,
								replies: 0
							}
                        }
                    };

					if (dept_summary[htree] === undefined) dept_summary[htree] = { contactScheme: 0, sendMail: 0, clicks: 0, openedMails: 0, dynamicList: 0, callPriority: 0, reminder: 0, replies: 0, bounces: 0, softbounces: 0, hardbounces: 0, totalAction: 0, totalConverted: 0, schemeCount: 0 };

                    contactScheme = $(xml).find("contact_in_scheme").text();
                    sendMail = $(xml).find("send_mail").text();
                    clicks = $(xml).find("clicks").text();
                    openedMails = $(xml).find ("opened_emails").text();
                    dynamicList = $(xml).find("dynamic_list").text();
                    callPriority = $(xml).find("call_priority").text();
					totalConverted = $(xml).find("total_converted").text();
                    workflowType = $(xml).find("workflow_type").text();
                    bounces = $(xml).find("bounces").text();
                    softbounces = $(xml).find("softbounces").text();
                    hardbounces = $(xml).find("hardbounces").text();
                    delivered_top = $(xml).find("delivered").text();
                    if ($(xml).find("emails").text().length !== 0) {
                        convertedEmails = JSON.parse($(xml).find("emails").text());
                    } else {
                        convertedEmails = [];
                    }
                    
					reminder = 0;
					if($(xml).find("reminder").text()) reminder = parseInt($(xml).find("reminder").text()) ;
					if($(xml).find("make_call").text()) reminder+=parseInt($(xml).find("make_call").text())

					replies = $(xml).find("replied").text();
                    totalAction = $(xml).find("total_actions").text();

					if (contactScheme == "") contactScheme = 0;
					if (sendMail == "") sendMail = 0;
					if (clicks == "") clicks = 0;
                    if (bounces == "") bounces = 0;
                    if (softbounces == "") softbounces = 0;
                    if (hardbounces == "") hardbounces = 0;
					if (openedMails == "") openedMails = 0;
					if (dynamicList == "") dynamicList = 0;
					if (callPriority == "") callPriority = 0;
					if (replies == "") replies = 0;
					if (totalAction == "") totalAction = 0;
					if (totalConverted == "") totalConverted = 0;
                   

                    var delivered_new = (sendMail - bounces);
                    total_delivered_new += delivered_new;
                    total_open_new += openedMails;

                


                    total_open_avg_new = (total_open_new / total_delivered_new) * 100;

                    str = "<tr class='scheme_table_rows'>";
                    str += "<td>" + company + "</td>";
                    str += "<td>";
					str += "<a target='_blank' href='/pipeline/lead-nurturing/lead-nurturing-pardot/index.php?v_scheme="+ln_project_id+"'> ";
					str += proj_name + "</a></td>";
                        $(".total_act_log #pn").text(project_name);
						$(".total_act_log #ln_count").text(ln_project_count + " schemes");

                    str += "<td class='as' style='text-align:center;'>" + contactScheme + "</td>";
                        total_contactScheme += parseInt(contactScheme);
                         $(".total_act_log #cs").text(total_contactScheme);

                    str += "<td class='as' style='text-align:center;' title='Does not include initial blast'>" + sendMail + "</td>";
                        total_sendMail += parseInt(sendMail);
                        $(".total_act_log #es").text(total_sendMail);
                      

                    str += "<td class='as' style='text-align:center;' title='Does not include initial blast'>" + delivered_new + "</td>";
            
                        $(".total_act_log #del").text(total_delivered_new);
                  

                    str += "<td class='as' style='text-align:center;'>" + clicks + "</td>";
                    total_clicks += parseInt(clicks);
                        $(".total_act_log #clicks").text(total_clicks);

                    const clickRate = (clicks !== 0) ? (clicks / delivered_new)  * 100 : 0
                    str += "<td class='as' title='Clicks % = Clicks / Delivered' style='text-align:center;'>" + clickRate.toFixed(2) + "%</td>";

                    const ctr = (clicks !== 0) ? (clicks / sendMail)  * 100 : 0
                    str += "<td class='as' title='Click through Rate = Clicks/Opens' style='text-align:center;'>" + ctr.toFixed(2) + "%</td>";

                    str += "<td class='as' style='text-align:center;'>"+ openedMails+"</th>";
                        total_openedMails += parseInt(openedMails);
                        $(".total_act_log #oe").text(total_openedMails);
                        const opens_new = (openedMails !== 0) ? (openedMails / delivered_new) * 100: 0;
                    str += "<td class='as' title='Opens % = Opens/Delivered' style='text-align:center;'>"+ opens_new.toFixed(2)+"%</th>";
                        const opensAvg_new = (total_openedMails !== 0) ? (total_openedMails / total_delivered_new) * 100: 0;
                        $(".total_act_log #o_per").text(opensAvg_new.toFixed(2) + "%");

                    str += "<td class='as hidden_col' style='text-align:center;'>" + dynamicList + "</td>";
                        total_dynamicList += parseInt(dynamicList);
                        $(".total_act_log #al").text(total_dynamicList);

                    str += "<td class='as hidden_col' style='text-align:center;'>" + callPriority + "</td>";
                        total_callPriority  += parseInt(callPriority );
                        $(".total_act_log #cp").text(total_callPriority );

					str += "<td class='as hidden_col' style='text-align:center;'>" + reminder + "</td>";
                        total_reminder  += parseInt(reminder);
                        $(".total_act_log #rem").text(total_reminder );
                    
                    str += "<td class='as' style='text-align:center;'>"+ softbounces + "</th>";
                        total_soft_bounce += parseInt(softbounces);
                        $(".total_act_log #sb").text(total_soft_bounce);
                        const sbRate = (softbounces !== 0) ? (softbounces / sendMail) * 100 : 0
                    str += "<td class='as' title='Soft bounce / Email Sent' style='text-align:center;'>"+ sbRate.toFixed(2) + "%</th>";
                        // total_soft_bounce += parseInt(softbounces);
                        // $(".total_act_log #sbr").text(total_soft_bounce);

                    str += "<td class='as' style='text-align:center;'>"+ hardbounces + "</th>";
                        total_hard_bounce += parseInt(hardbounces);
                        $(".total_act_log #hb").text(total_hard_bounce);
                        const hbRate = (hardbounces !== 0) ? (hardbounces / sendMail) * 100 : 0
                    str += "<td class='as' title='Hard bounce / Email Sent' style='text-align:center;'>"+ hbRate.toFixed(2) + "%</th>";

                    str += "<td class='as' style='text-align:center;'>"+ bounces + "</th>";
                        total_bounce += parseInt(bounces);
                        $(".total_act_log #tb").text(total_bounce);
                        const tbRate = (bounces !== 0) ? (bounces / sendMail) * 100 : 0
                    str += "<td class='as' title='Total bounce / Email Sent' style='text-align:center;'>"+ tbRate.toFixed(2) + "%</th>";
                    const totalSbRate = (total_soft_bounce !== 0) ? (total_soft_bounce / total_sendMail) * 100 : 0;
                    const totalHbRate = (total_hard_bounce !== 0) ? (total_hard_bounce / total_sendMail) * 100 : 0;
                    const totalBounceRate = (total_bounce !== 0) ? (total_bounce / total_sendMail) * 100 : 0;
                    const totalClickRate = (total_clicks !== 0) ? (total_clicks / total_delivered_new) * 100 : 0;
                    const totalCTR = (total_clicks !== 0) ? (total_clicks / total_sendMail) * 100 : 0;
                    $(".total_act_log #sbr").text(totalSbRate.toFixed(2)+'%');
                    $(".total_act_log #hbr").text(totalHbRate.toFixed(2)+'%');
                    $(".total_act_log #tbr").text(totalBounceRate.toFixed(2)+'%');
                    $(".total_act_log #cr").text(totalClickRate.toFixed(2)+'%');
                    $(".total_act_log #ctr").text(totalCTR.toFixed(2)+'%');
					/* str += "<td class='as' style='text-align:center;'>" + replies + "</td>";
                        total_replies  += parseInt(replies);
                        $(".total_act_log #repl").text(total_replies);

                    str += "<td class='as' style='text-align:center;'>" + totalAction + "</td>";
                        total_totalAction += parseInt(totalAction);
                        $(".total_act_log #ta").text(total_totalAction); */

					aveNoOfActions = fixDecimal(totalAction/daycount,2);

					// str += "<td class='as' style='text-align:center;' title='Total No. of Actions/No.of Days'>" + aveNoOfActions + "</td>";
                    const email_str = convertedEmails.sort().join("\n");                    
					str += "<td class='as view_emails' title='"+email_str+"' onclick='copyEmails(this)' style='text-align:center;'>" + totalConverted + "</td>";
                        total_totalConverted += parseInt(totalConverted);
                        $(".total_act_log #overall_conv").text(total_totalConverted);
                    // console.log(client_id + ' ' + bounces)
                    str += "</tr>";
					client_summary[htree][client_id].contactScheme+=parseInt(contactScheme);
					client_summary[htree][client_id].sendMail+=parseInt(sendMail);
					client_summary[htree][client_id].clicks+=parseInt(clicks);
					client_summary[htree][client_id].openedMails+=parseInt(openedMails);
					client_summary[htree][client_id].dynamicList+=parseInt(dynamicList);
					client_summary[htree][client_id].callPriority+=parseInt(callPriority);
					client_summary[htree][client_id].reminder+=parseInt(reminder);
					client_summary[htree][client_id].replies+=parseInt(replies);
					client_summary[htree][client_id].bounces+=parseInt(bounces);
					client_summary[htree][client_id].softbounces+=parseInt(softbounces);
					client_summary[htree][client_id].hardbounces+=parseInt(hardbounces);
					client_summary[htree][client_id].totalAction+=parseInt(totalAction);
					client_summary[htree][client_id].totalConverted+=parseInt(totalConverted);
					client_summary[htree][client_id].schemeCount+=1;
                    client_summary[htree][client_id].schemes.push(ln_project_id);
                    client_summary[htree][client_id].mailjet_workflows.push(workflowType);
                    convertedEmails.forEach(i => client_summary[htree][client_id].convertedEmails.push(i));
                    

                    if (workflowType !== '') {
						client_summary[htree][client_id].workflow_summary[workflowType].opened_emails += parseInt(openedMails);
						client_summary[htree][client_id].workflow_summary[workflowType].clicks += parseInt(clicks);
						client_summary[htree][client_id].workflow_summary[workflowType].email_sent += parseInt(sendMail);
						client_summary[htree][client_id].workflow_summary[workflowType].contacts_in_scheme += parseInt(contactScheme);
						client_summary[htree][client_id].workflow_summary[workflowType].bounces += parseInt(bounces);
						client_summary[htree][client_id].workflow_summary[workflowType].replies += parseInt(replies);
					}


					dept_summary[htree].contactScheme+=parseInt(contactScheme);
					dept_summary[htree].sendMail+=parseInt(sendMail);
					dept_summary[htree].clicks+=parseInt(clicks);
					dept_summary[htree].openedMails+=parseInt(openedMails);
					dept_summary[htree].dynamicList+=parseInt(dynamicList);
					dept_summary[htree].callPriority+=parseInt(callPriority);
					dept_summary[htree].reminder+=parseInt(reminder);
					dept_summary[htree].replies+=parseInt(replies);
					dept_summary[htree].bounces+=parseInt(bounces);
					dept_summary[htree].softbounces+=parseInt(softbounces);
					dept_summary[htree].hardbounces+=parseInt(hardbounces);
					dept_summary[htree].totalAction+=parseInt(totalAction);
					dept_summary[htree].totalConverted+=parseInt(totalConverted);
					dept_summary[htree].schemeCount+=1;
                    // console.log(client_summary[htree][client_id]);
                    // console.log(total_sendMail);
                    table.append(str);
                    // console.log(dept_summary);
                    display_summary(client_summary, dept_summary, total_sendMail);
					hide_column();
                }
            }); //end xhr.queue2
            // total_delivered_new+= delivered_new;
            // total_open_new+= openedMails;
            
            if($("#is_super_user").val()==0 || $("#include_initial_blast").length!= 0){
				xhr.queue({  //start xhr.queue2
					url: "/lead-nurturing/api/report.php",
					data: {
						proj_id: $(this).val(),
						report_type: 'summary',
						display: 'logs',
						tz:'Asia/Manila',
						dt_defined: $('#select_date').val(),
						date_end: $('#to_datepicker').val(),
						date_start: $('#from_datepicker').val(),
						dataonly: 'true',
						exclude_blast: exc
					},
					success: function (xml) {

						sent = $(xml).find("sent").text();
						delivered = $(xml).find("delivered").text();
						opened = $(xml).find("opened").text();
						opened_perc = $(xml).find("opened_perc").text();
						click = $(xml).find("clicks").text();
						replies = $(xml).find("replied").text();
						converted = $(xml).find("converted").text();
						unsubscribed = $(xml).find("unsub").text();
						bounce = $(xml).find("bounce").text();
						softbounces = $(xml).find("softbounces").text();
						hardbounces = $(xml).find("hardbounces").text();

							if (sent == "") sent = 0;
							if (delivered == "") delivered = 0;
							if (opened == "") opened = 0;
							if (opened_perc == "") opened_perc = 0;
							if (click == "") click = 0;
							if (replies == "") replies = 0;
							if (converted == "") converted = 0;
							if (unsubscribed == "") unsubscribed = 0;
							if (bounce == "") bounce = 0;
							if (softbounces == "") softbounces = 0;
							if (hardbounces == "") hardbounces = 0;
							if (opened == 0){
								x = 0;
							}else{
								x = 100 *(parseInt(click)/parseInt(opened));
							}

                         

						tbl = "<tr>";
						tbl += "<td>" + company + "</td>";
						tbl += "<td class='v_scheme' data-id='"+ln_project_id+"'>" + proj_name + "</td>";
							$(".total_email_marketing #pn").text(project_name);
						tbl += "<td style='text-align:center;'>" + sent + "</td>";
							total_sent += parseInt(sent);
							$(".total_email_marketing #sent").text(total_sent);

						tbl += "<td style='text-align:center;'>" + delivered + "</td>";
							total_delivered += parseInt(delivered);
							$(".total_email_marketing #delivered").text(total_delivered);
                            

                            

						tbl += "<td style='text-align:center;'>" + opened + "</td>";
							total_opened += parseInt(opened);
							$(".total_email_marketing #opens").text(total_opened);

						tbl += "<td style='text-align:center;'>" + opened_perc + "%</td>";
							//total_opened_perc += parseInt(opened_perc);
							//var opened_percentage = total_opened_perc / $('.fixed-headers #ActivityLogResults tr').length;
							var opened_percentage = 100  * (total_opened / total_delivered);
							$(".total_email_marketing #operc").text(opened_percentage.toFixed(2) +'%');


						tbl += "<td style='text-align:center;'>" + click + "</td>";
							total_click += parseInt(click);
							$(".total_email_marketing #clicks").text(total_click);

						tbl += "<td style='text-align:center;'>" + x.toFixed(2) + "%</td>";
							//total_x += parseInt(x);
							//var click_percentage = total_x / $('.fixed-headers #EmailMarketingResults tr').length
							var click_percentage = 100 * (total_click / total_opened);
							$(".total_email_marketing #cperc").text(click_percentage.toFixed(2)+'%');

						tbl += "<td style='text-align:center;'>" + replies + "</td>";
							total_replied += parseInt(replies);
							$(".total_email_marketing #replies").text(total_replied);

						tbl += "<td style='text-align:center;'>" + converted + "</td>";
							total_converted += parseInt(converted);
							$(".total_email_marketing #converted").text(total_converted);

						tbl += "<td style='text-align:center;'>" + unsubscribed + "</td>";
						total_unsubs += parseInt(unsubscribed);
							$(".total_email_marketing #unsubs").text(total_unsubs);

						tbl += "<td style='text-align:center;'>" + bounce + "</td>";
							total_bounce += parseInt(bounce);
							$(".total_email_marketing #bounced").text(total_bounce);
						tbl += "</tr>";
						//console.log(tbl);
						table2.append(tbl);
				}
				}); //end xhr.queue2
			}
            // console.log($(this).val());
			xhr.queue({
				url: "/lead-nurturing/api/get-queued-activity-logs.php",
				type: "get",
				data: {proj_id: $(this).val(), project_name: $(this).attr("data-pg"), project_type: $(this).attr("data-val")},
				success: function(xml){
					$("#emails_on_queue_table tbody").append($(xml).find("Payload").text());
					$(".templater").html('<span style="margin-left:3px" title="view template" aria-hidden="true" data-icon="&#xe101;"></span>');
					$(".processing").html('<span style="margin-left:3px" title="cms" aria-hidden="true" data-icon="&#xe037;"></span>');
					$(".webmail").html('<span style="margin-left:3px" title="inbox" aria-hidden="true" data-icon="&#xe010;"></span>');
					$(".bounces").html('<span style="margin-left:3px" title="view bounces" aria-hidden="true" data-icon="&#xe0e6;"></span>');
					$(".delete").html('<span style="margin-left:3px" title="delete" aria-hidden="true" data-icon="&#x2715;"></span>');

				}
			});
        }        
    });
    
    $("#companies").fadeOut('slow');
	$("#brkdown_title").show();
	$("#collapse_button").show();
}

$(document).on("click", "#reload_comp", function(){
	$("#companies").fadeIn('slow');
});

const collapseRows = (event, className) => {
    const rows = document.getElementsByClassName(className);
    Array.from(rows).forEach(i => {
        if (i.style.display === 'none') {
            i.style.removeProperty('display');
            event.innerText = "Collapse Rows"            
        } else {
            i.style.display = 'none';
            event.innerText = "Expand Rows"    
        }
    });
}

$(document).on("click", "#show_schemes", function(){
	if ($("#ActivityLogResults").css("display") == "none") {
        $("#ActivityLogResults").fadeIn('slow');
        $("#collapse_button_2").fadeIn('slow');
    } else {
        $("#ActivityLogResults").fadeOut('slow');
        $("#collapse_button_2").fadeOut('slow');
    }
});

$(document).on("change", "#choose_report", function(){

    if($(this).val()=="Activity_Log") {

        $("#generate").click(function () {
            $("#act_log").show();
            $("#email_marketing").hide();
        });
    }
    else{
        $("#generate").click(function () {
            $("#act_log").hide();
            $("#email_marketing").show();
        });
    }
});

$(document).on("click", ".server_error", function(){
	$(this).html("Retrying . . . Please check again after 10 mins. If Error still persists, contact techsupport to check your server.");
	xhr.queue({
		url: "refresh.php",
		type: "get",
		data: {axn:'reset', 'status': 'server_error', 'templ':$(this).attr("data-templ")},

	});
});
/* Sir Stoic's Ajax Queue System */
/** -+------- AJAX PROCESSING -------+- */
(function(window, undefined){
   var active = true, queue = [], loading_timer = null;
   var ajax_defaults = { type: 'GET', data: {},
                        success: empty_fn,
                        error: empty_fn,
                        timeout: 6e5,
                        loading_msg: "Loading..." };
    window.xhr = {
        busy: false,
        queue: function(params){
            if (!active || !params) return;
            var loading_msg = "", i;

            for (i in ajax_defaults) if (params[i] === undefined) params[i] = ajax_defaults[i];
            if (params.loading_msg){
                loading_msg = params.loading_msg;
                loading_timer = setTimeout(function(){ start_loading(loading_msg);},500);
                params.loading_msg = "";
            }
            if (xhr.busy){ queue.push(params); return;}
            xhr.busy = true;
            $.ajax({
                type: params.type,
                url: params.url,
                data: params.data,
                success: function(data){
                xhr.busy = false;
                end_loading();

                if (loading_msg && data.error){
                    alert(data.error);
                    return;
                }
                (params.success)(data);
                if (queue.length) xhr.queue(queue.shift());
                },
                error: function(jqXHR, err_stat, err_str){
                end_loading();
                (params.error)(err_stat, err_str);
                if (queue.length) xhr.queue(queue.shift());
                },
                timeout: params.timeout
            });
        },
        stop: function(){ active = false;}
    };

   function empty_fn() {}

    function start_loading(msg) {
        if (!xhr.busy) return;
        $('#loading_msg_txt').text(msg);
        $('.bgload').show();
        $('#loading_msg').css('margin-left', '-' + ($('#loading_msg').width() / 2) + 'px');
    }

    function end_loading() {
        xhr.busy = false;
        if (loading_timer) clearTimeout(loading_timer);
        if (queue.length == 0){
            $(".bgload").hide(5000);
        }

    }
})(window);


//----------------scrollable tbody while thead stays fixed when displaying long lists of result-------------------------
(function($) {
    $.fn.fixMe = function() {
        return this.each(function() {
            var $this = $(this),
                $t_fixed;
            function init() {
                $this.wrap('<div class="charaine" />');
                $t_fixed = $this.clone();
                $t_fixed.find("tbody").remove().end().addClass("fixed").insertBefore($this);
                resizeFixed();
            }
            function resizeFixed() {
                $t_fixed.find("th").each(function(index) {
                });
            }
            function scrollFixed() {
                var offset = $(this).scrollTop(),
                    tableOffsetTop = $this.offset().top,
                    tableOffsetBottom = tableOffsetTop + $this.height() - $this.find("thead").height();
                if(offset < tableOffsetTop || offset > tableOffsetBottom)
                    $t_fixed.hide();
                else if(offset >= tableOffsetTop && offset <= tableOffsetBottom && $t_fixed.is(":hidden"))
                    $t_fixed.show();
            }
            $(window).resize(resizeFixed);
            $(window).scroll(scrollFixed);
            init();
        });
    };
})(jQuery);

$(document).ready(function(){
    $("#email_marketing_table").fixMe();
});

function mailjet_summary(client_summary) {
    // console.log(client_summary)
}

function display_summary(client_summary, dept_summary, totalSend) {
    var dept_count = 0;
    var overall_av = 0;
    var overall_campaignCount = 0;
    if ($("#select_date").val() == "Last Week" || $("#select_date").val() == "This Week"  || $("#select_date").val() == "Date Range" )	daycount = 5;
    else daycount = 1;

    var hd="";
		//hd ="<th style='width:20%;'>Company</th>";
    hd += "<th style='width:8%;'>Workflows</th>";
    hd +="<th style='width:8%;'>Contacts in Scheme</th>";
    hd +="<th style='width:8%;'>Emails Sent</th>";
    hd +="<th style='width:8%;'>Delivered</th>";
    hd += "<th style='width:8%;'>Open Emails</th>";
    hd += "<th style='width:8%;'>%</th>";
    hd +="<th style='width:8%;'>Clicks</th>";
    hd +="<th style='width:8%;'>%</th>";
    hd +="<th style='width:8%;'>CTR</th>";
    hd +="<th class='hidden_col' style='width:8%;'>Added to List </th>";
    hd +="<th class='hidden_col' style='width:8%;'>Call Priority </th>";
    hd +="<th class='hidden_col' style='width:8%;'>Reminder </th>";
    hd +="<th style='width:8%;'>Soft Bounce </th>";
    hd +="<th style='width:8%;'>% </th>";
    hd +="<th style='width:8%;'>Hard Bounce </th>";
    hd +="<th style='width:8%;'>% </th>";
    hd +="<th style='width:8%;'>Total Bounce </th>";
    hd +="<th style='width:8%;'>% </th>";
    /* hd +="<th style='width:8%;'>Total No. of Actions</th>";
    hd +="<th style='width:8%;'>Ave. No. of Actions per Day</th>"; */
    hd +="<th style='width:8%;'>Converted<br> (All Channels)</th>";
    hd +="<th style='width:6%;'>&nbsp;</th>";

    let workflow_summary = {
        'no interest': {
            contacts_in_scheme: 0,
            opened_emails: 0,
            clicks: 0,
            email_sent: 0,
            bounces: 0,
			replies: 0
        },
        'no response': {
            contacts_in_scheme: 0,
            opened_emails: 0,
            clicks: 0,
            email_sent: 0,
            bounces: 0,
			replies: 0
        },
        'rfi': {
            contacts_in_scheme: 0,
            opened_emails: 0,
            clicks: 0,
            email_sent: 0,
            bounces: 0,
			replies: 0
        },
        'positive': {
            contacts_in_scheme: 0,
            opened_emails: 0,
            clicks: 0,
            email_sent: 0,
            bounces: 0,
			replies: 0
        },
		'other': {
			contacts_in_scheme: 0,
			opened_emails: 0,
			clicks: 0,
			email_sent: 0,
			bounces: 0,
			replies: 0
		}
    }

    /* const workflow_keys = ['no interest', 'no response', 'rfi', 'positive', 'other']
    const workflow_obj = {
        contacts_in_scheme: 0,
        opened_emails: 0,
        clicks: 0,
        email_sent: 0,
        bounces: 0,
        replies: 0
    }
    let workflow_summary = {};

    workflow_keys.forEach(e => workflow_summary[e] = workflow_obj) */    
	str = "";
	sc_label = "";
    let converted_emails = "";
    var bounces_total_new = 0;
	for(var h in dept_summary){
		campaignCount = 0;
		str+= "<tr id='summary-head'><th>"+h+"</th>";
		str+= hd;
		str+="</tr>";
       
		for(var c in client_summary[h]){			
            var bounces_new = 0;
            let workflows = ''
            if (client_summary[h][c].mailjet_workflows.length >= 3) {
                workflows = 'Complete'
            } else {
                workflows += (!client_summary[h][c].mailjet_workflows.includes('rfi')) ? 'No RFI,' : ''
                workflows += (!client_summary[h][c].mailjet_workflows.includes('no response')) ? ' No Response,' : ''
                workflows += (!client_summary[h][c].mailjet_workflows.includes('positive')) ? ' No Positive,' : ''
            }

			if(client_summary[h][c].schemeCount < 2) sc_label = "scheme";
			else sc_label = "schemes";
			campaignCount++;
			overall_campaignCount++;

            for (var x in client_summary[h][c].workflow_summary) {
                // console.log(client_summary[h][c].workflow_summary[x])
                workflow_summary[x].opened_emails += parseInt(client_summary[h][c].workflow_summary[x].opened_emails)
                workflow_summary[x].clicks += parseInt(client_summary[h][c].workflow_summary[x].clicks)
                workflow_summary[x].email_sent += parseInt(client_summary[h][c].workflow_summary[x].email_sent)
                workflow_summary[x].contacts_in_scheme += parseInt(client_summary[h][c].workflow_summary[x].contacts_in_scheme)
                workflow_summary[x].bounces += parseInt(client_summary[h][c].workflow_summary[x].bounces)
                workflow_summary[x].replies += parseInt(client_summary[h][c].workflow_summary[x].replies)
                bounces_new += parseInt(client_summary[h][c].workflow_summary[x].bounces);
            }
            if (workflows.charAt(workflows.length - 1) === ',') {
                workflows = workflows.slice(0, -1)
            }
            converted_emails = client_summary[h][c].convertedEmails.sort().join("\n");
            bounces_total_new += bounces_new;
            client_summary[h][c].bounces_new =  bounces_new;
            const delivered = client_summary[h][c].sendMail - client_summary[h][c].bounces_new;
            const opensAvg = ( client_summary[h][c].openedMails !== 0) ? ( client_summary[h][c].openedMails / delivered) * 100 : 0;
            const softBounceRate = ( client_summary[h][c].softbounces !== 0) ? ( client_summary[h][c].softbounces / client_summary[h][c].sendMail) * 100 : 0;
            const bounceRate = ( client_summary[h][c].bounces !== 0) ? ( client_summary[h][c].bounces / client_summary[h][c].sendMail) * 100 : 0;
            const hardBounceRate = ( client_summary[h][c].hardbounces !== 0) ? ( client_summary[h][c].hardbounces / client_summary[h][c].sendMail) * 100 : 0;
            const clickRate = ( client_summary[h][c].openedMails !== 0) ? ( client_summary[h][c].clicks / delivered) * 100 : 0;
            const ctr = ( client_summary[h][c].openedMails !== 0) ? ( client_summary[h][c].clicks / client_summary[h][c].openedMails) * 100 : 0;
            let has_bounce = '';
            if (client_summary[h][c].bounces !== 0) {
                has_bounce = ' has_bounce';
            }
			str += "<tr class='breakdown_dept_row' id='c" + c + "'><td title='"+client_summary[h][c].schemeCount+" "+ sc_label+"'>"+clients[c]+" ("+client_summary[h][c].schemeCount+")</td>";
            str += "<td class='td3'>" + workflows + "</td>";
			str +="<td class='td3'>" + client_summary[h][c].contactScheme + "</td>";
			str += "<td class='td3'>" + client_summary[h][c].sendMail + "</td>";
			str += "<td class='td3'>" + delivered + "</td>";
            str += "<td class='td3'>" + client_summary[h][c].openedMails + "</td>";
            str += "<td class='td3' title='Opens % = Opens/Delivered'>" + opensAvg.toFixed(2) + "%</td>";
			str += "<td class='td3'>" + client_summary[h][c].clicks + "</td>";
			str += "<td class='td3' title='Clicks % = Clicks / Delivered'>" + clickRate.toFixed(2) + "%</td>";
			str += "<td class='td3' title='Click through Rate = Clicks/Opens'>" + ctr.toFixed(2) + "%</td>";
			str += "<td class='td3 hidden_col'>" + client_summary[h][c].dynamicList + "</td>";
			str += "<td class='td3 hidden_col'>" + client_summary[h][c].callPriority + "</td>";
			str += "<td class='td3 hidden_col'>" + client_summary[h][c].reminder + "</td>";
			str += "<td class='td3'>" + client_summary[h][c].softbounces + "</td>";
			str += "<td class='td3' title='Soft bounce % = Soft bounce/Emails Sent' >" + softBounceRate.toFixed(2) + "%</td>";
            str += "<td class='td3'>" + client_summary[h][c].hardbounces + "</td>";
            str += "<td class='td3' title='Hard bounce % = Hard bounce/Emails Sent'>" + hardBounceRate.toFixed(2) + "%</td>";
			str += `<td class='td3 ${has_bounce}' onclick='getBounces("${client_summary[h][c].schemes.join(",")}", "${clients[c]}")'>${client_summary[h][c].bounces}</td>`;
            str += "<td class='td3' title='Total bounce / Email Sent'>" + bounceRate.toFixed(2) + "%</td>";
			// str += "<td class='td3'>" + client_summary[h][c].totalAction + "</td>";

			actionsPerScheme = 0;
			actionsPerCampaign = 0;
			if(client_summary[h][c].schemeCount > 0) actionsPerScheme = client_summary[h][c].totalAction/client_summary[h][c].schemeCount;

			avPerScheme = fixDecimal(actionsPerScheme/daycount,2);
			avPerCampaign = fixDecimal(client_summary[h][c].totalAction/daycount,2);
			title = client_summary[h][c].totalAction+" / "+daycount+"day(s)";
			titleS="";
			if(client_summary[h][c].schemeCount > 1) { //if more than 1 scheme display Ave. No of Actions per Scheme
				//titleS = ", Ave. Actions Per Scheme: "+avPerScheme;
				//titleS += " (" + client_summary[h][c].totalAction+" / "+client_summary[h][c].schemeCount+" / "+daycount+"day(s))";
			}


			// str+= "<td class='td3' title='Ave. Actions Per Campaign: "+title+titleS+"' >" + avPerCampaign + "</td>";
			str+= "<td class='td3 view_emails' title='"+converted_emails+"' onclick='copyEmails(this)'>" + client_summary[h][c].totalConverted + "</td>";
            str+= "<td class='td3'><a class='details' data-value='" + client_summary[h][c].schemes.join(",") + "'></a></td></tr>"; /*See Details*/

		}

		str+= "<tr><th class='tl lft' colspan='2'> TOTAL: Campaigns: "+campaignCount+ ", Schemes: " + dept_summary[h].schemeCount+ "</td>";

		actionsPerCampaign = 0;
		if(campaignCount > 0) actionsPerCampaign = dept_summary[h].totalAction/campaignCount;
		title = dept_summary[h].totalAction+" / "+campaignCount+" / "+daycount+"day(s)";
		av = fixDecimal(actionsPerCampaign/daycount,2)

		acPerScheme = dept_summary[h].totalAction/dept_summary[h].schemeCount;
		avPerScheme = fixDecimal(acPerScheme/daycount,2);
       
        
        const delivered = dept_summary[h].sendMail - bounces_total_new;
        const opensAvg = (dept_summary[h].openedMails !== 0) ? (dept_summary[h].openedMails / delivered) * 100 : 0;
        const softBounceRate = (dept_summary[h].softbounces !== 0) ? (dept_summary[h].softbounces / dept_summary[h].sendMail) * 100 : 0;
        const bounceRate = ( dept_summary[h].bounces !== 0) ? ( dept_summary[h].bounces / dept_summary[h].sendMail) * 100 : 0;
        const hardBounceRate = (dept_summary[h].hardbounces !== 0) ? (dept_summary[h].hardbounces / dept_summary[h].sendMail) * 100 : 0;
        const clickRate = (dept_summary[h].openedMails !== 0) ? (dept_summary[h].clicks / delivered) * 100 : 0;
        const ctr = (dept_summary[h].openedMails !== 0) ? (dept_summary[h].clicks / dept_summary[h].openedMails) * 100 : 0;

        bounces_total_new = 0;
        // str += "<th class='tl'></th>";
		str += "<th class='tl'>" + dept_summary[h].contactScheme + "</th>";
		str += "<th class='tl'>" + dept_summary[h].sendMail + "</th>";
		str += "<th class='tl'>" + delivered + "</th>";
		str += "<th class='tl'>" + dept_summary[h].openedMails + "</th>";
		str += "<th class='tl' title='Opens % = Opens/Delivered'>" + opensAvg.toFixed(2) + "%</th>";
        str += "<th class='tl'>" + dept_summary[h].clicks + "</th>";
        str += "<th class='tl' title='Clicks % = Clicks / Delivered'>" + clickRate.toFixed(2) + "%</th>";
        str += "<th class='tl' title='Click through Rate = Clicks/Opens'>" + ctr.toFixed(2) + "%</th>";
		str += "<th class='tl hidden_col'>" + dept_summary[h].dynamicList + "</th>";
		str += "<th class='tl hidden_col'>" + dept_summary[h].callPriority + "</th>";
		str += "<th class='tl hidden_col'>" + dept_summary[h].reminder + "</th>";
		str += "<th class='tl'>" + dept_summary[h].softbounces + "</th>";
		str += "<th class='tl' title='Soft bounce % = Soft bounce/Emails Sent'>" + softBounceRate.toFixed(2) + "%</th>";
        str += "<th class='tl'>" + dept_summary[h].hardbounces + "</th>";
        str += "<th class='tl' title='Hard bounce % = Hard bounce/Emails Sent'>" + hardBounceRate.toFixed(2) + "%</th>";
		str += "<th class='tl'>" + dept_summary[h].bounces + "</th>";
        str += "<th class='tl'>" + bounceRate.toFixed(2) + "%</th>";
		/* str += "<th class='tl'>" + dept_summary[h].totalAction + "</th>";
		str += "<th class='tl' title='Ave. Actions Per Campaign: "+title+"'>" + av + "</th>"; */
		str += "<th class='tl'>" + dept_summary[h].totalConverted + "</td>";
        str += "<th class='tl'>&nbsp;</td></tr>";

		dept_count++;
		overall_av+=av;


	}
	overall_av = fixDecimal(overall_av/dept_count,2)
	$(".total_act_log #overall_ta").text(overall_av);
	$(".total_act_log #pn").text("TOTAL: "+ overall_campaignCount+ " Campaigns");
    // console.log(overall_av / dept_count);
    var total_delivered_new = 0;
    var open_new = 0;
    
    let ws = "";
    ws += "<tr id='workflow-head'>";
    ws += "<th>Type of Workflows</th>";
    ws += "<th>Contacts In Scheme</th>";
    ws += "<th>Email Sent</th>";
    ws += "<th>% from Total Sents</th>";
    ws += "<th>Delivered</th>";
    ws += "<th>Opens</th>";
    ws += "<th>Opens %</th>";
    ws += "<th>Clicks</th>";
    ws += "<th>Clicks %</th>";
    ws += "<th>CTR</th>";
    ws += "<th>Bounces</th>";
    ws += "<th>Bounces %</th>";
    ws += "</tr>";
    for (var x in workflow_summary) {
       
        const totalSentAvg = (workflow_summary[x].email_sent / totalSend) * 100;        
        const delivered = workflow_summary[x].email_sent - workflow_summary[x].bounces;
        const opensAvg = (workflow_summary[x].opened_emails !== 0) ? (workflow_summary[x].opened_emails / delivered) * 100 : 0;
        const bounceAvg = (workflow_summary[x].bounces !== 0) ? (workflow_summary[x].bounces / workflow_summary[x].email_sent) * 100 : 0;
        const totalClicksAvg = (workflow_summary[x].opened_emails !== 0) ? (workflow_summary[x].clicks / delivered) * 100 : 0;
        const ctr = (workflow_summary[x].opened_emails !== 0) ? (workflow_summary[x].clicks / workflow_summary[x].opened_emails) * 100 : 0;
        

        open_new += workflow_summary[x].opened_emails;
       
        ws += "<tr>"
        ws += "<td>" + x.charAt(0).toUpperCase() + x.slice(1) + "</td>"
        ws += "<td>" + workflow_summary[x].contacts_in_scheme + "</td>"
        ws += "<td>" + workflow_summary[x].email_sent + "</td>"
        ws += "<td>" + totalSentAvg.toFixed(2) + "%</td>"
        ws += "<td>" + delivered + "</td>"
        ws += "<td>" + workflow_summary[x].opened_emails + "</td>"
        ws += "<td title='Opens % = Opens/Delivered'>" + opensAvg.toFixed(2) + "%</td>"
        ws += "<td>" + workflow_summary[x].clicks + "</td>"
        ws += "<td title='Clicks % = Clicks / Delivered'>" + totalClicksAvg.toFixed(2) + "%</td>"
        ws += "<td title='Click through Rate = Clicks / Opens'>" + ctr.toFixed(2) + "%</td>"
        ws += "<td>" + workflow_summary[x].bounces + "</td>"
        ws += "<td>" + bounceAvg.toFixed(2) + "%</td>"
        ws += "</tr>"
    }
    // console.log(workflow_summary)
    $("#workflow_title").show();
    $("#workflow_summary table").html(ws);
	$("#summary table").html(str);
    
    // str = "<td class='as' style='text-align:center;' title='Does not include initial blast'>" + total_delivered_new + "</td>";
    // const openAvg_new = (open_new / total_delivered_new) * 100;

    // $(".total_act_log #del").text(openAvg_new.toFixed(2));
    // table.append(str);

}

const copyEmails = title => {
    const emails = title.getAttribute('title')
    
    copyToClipboard(emails)
    .then(() => alert('Copied to clipboard!'))
    .catch(() => alert('Error!'));
}

function copyToClipboard(textToCopy) {
    
    if (navigator.clipboard && window.isSecureContext) {        
        return navigator.clipboard.writeText(textToCopy);
    } else {        
        let textArea = document.createElement("textarea");
        textArea.value = textToCopy;        
        textArea.style.position = "fixed";
        textArea.style.left = "-999999px";
        textArea.style.top = "-999999px";
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        return new Promise((res, rej) => {            
            document.execCommand('copy') ? res() : rej();
            textArea.remove();
        });
    }
}

$('.as').bind({
    keyup:function(){
        //total calculation
        $("#ActivityLogResults tr:last td").text(function (i) {
            var totalVal = 0;
            $(this).parent().prevAll().find("td:nth-child(" + (++i) + ")").each(function () {
                totalVal += parseInt($(this).children('.as').val()) || 0;
                $(".printer-type tr:last td:first").text('Total sheets/year');
            });
            return totalVal;

        });

        var count=0
        for (i=1;i<$('tr').length;i++) {
            var trs=parseInt($('tr:eq('+i+')').find('td:last').text())
            count+=trs
        }
        $(".printer-type tr:last td:last").text(count);
        // console.log(count);
    }
});

$(document).ready(function(e) {
    $("#not_updated_2016_06_11").hide();
	$("#go").show();
	$(".search-form").show();
});


/* Function by aL */
$(document).on("click", "a.details", function(){

    var client = $(this).parents("tr").attr("id").substr(1);
    var dt_defined = $("#select_date").val();
    var date_end = $('#to_datepicker').val();
    var date_start = $('#from_datepicker').val();
    var schemes = $(this).attr("data-value");
    var client_name = clients[client];

    var report_type = "summary";
    var limit = 0;
    var display = "logs";
    var dataonly = "true";

    $("#details-form input").each(function(i, e){
        $(e).val( eval( $(e).attr("id").substr(2) ) );
    });

    $("#details-form").submit();
});

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function fixDecimal(x,places){
	x = x.toFixed(places);
	return parseFloat(x.toString().replace(".00",""));
}

const getBounces = async (schemes, client_name) => {
    const dt_defined = $("#select_date").val();
    const date_end = $('#to_datepicker').val();
    const date_start = $('#from_datepicker').val();
    await xhr.queue({
        type : 'GET',
        url : '/lead-nurturing/api/get-bounces.php',
        data : { 
            schemes,
            dt_defined,
            date_start,
            date_end
        },
        success : data => {
            const result = JSON.parse(data)
            
            if (result.length) {
                exportBounces(result, client_name)
            }
        }
    })
}
const exportBounces = (data, client_name) => {
    let rows = [
        ["FIRST NAME", "LAST NAME", "COMPANY", "EMAIL", "COUNTRY", "BOUNCE TYPE", "BOUNCE ERROR"],
    ]
    
    data.forEach(i => rows.push([
        i.first_name, 
        i.last_name, 
        i.company.replace(",", ";"), 
        i.email, 
        i.country, 
        i.bounce_type, 
        i.bounce_error.replace(/,|#/g, ";")
    ]));
    console.log(rows)
    let csvContent = "data:text/csv;charset=utf-8," + rows.map(e => e.join(",")).join("\n");
    const encodedUri = encodeURI(csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", `${client_name}.csv`);
    document.body.appendChild(link);
    link.click();
}
/*
O += parseInt(opened_perc);
total_opened_perc = parseInt(O)
x = 100 *(parseInt(click)/parseInt(opened));
$(".total_email_marketing #operc").text(total_opened_perc);*/

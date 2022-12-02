$(document).on("change", "#select_date", function(){

    if($(this).val()=="Date Range"){

        $(".dateRange").html("From: <input type='text' id='from_datepicker' class='datepicker'/>" +
                            "To: <input type='text' class='datepicker' id='to_datepicker'/>");
        $( ".datepicker" ).datepicker({dateFormat: "yy-mm-dd"});
    }
    else{
        $(".dateRange").html("");
    }
});


$(document).on("click", "#all", function(){
    $(".proj_ids").each(function(){
        $(this).click();
    });
});


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
            data: {generate:department,
				dt_defined: $('#select_date').val(),
				date_end: $('#to_datepicker').val(),
				date_start: $('#from_datepicker').val()},
           		success: function(e) { //start success
                $("#companies_scheme").html("");
                //alert ("'"+e+"'");
                if (e.trim() == "NoResultsFound") {
                    $('#ActivityLogResults').html('<div class="noResult">No results found</div>');
                    $('#EmailMarketingResults').html('<div class="noResult">No results found</div>');
                    $('#companies_scheme').append("<div class='noResult'>No results found.</div>");
                    $("#go, .company_scheme_title").show(); 
                }
                else{
                    response = JSON.parse(e);
                    var length = response.length;

                    table.html("");
                    table2.html("");
                    var i = 1; var page =1;
					
                    $(response).each(function (index, element) { //start each function

                        // str += "<div><input type='checkbox' data-val='"+element['project_name']+"' data-pg='"+element['company']+"' class='proj_ids' value='"+element['ln_project_id']+"'>"+element['company']+" - " +element['project_name']+ "</div>";
                        // if(i == length){
                        //     $("#companies_scheme").append("<div class='columns' id='"+page+"'>"+str+"</div>");
                        //     str = "";
                        //     i =1;
                        //     page++;
                        // }

                        str += "<div><input type='checkbox' data-val='"+element['project_name']+"' data-pg='"+element['company']+"' class='proj_ids' value='"+element['ln_project_id']+"'>"+element['company']+" - <span class='project_name'>" +element['project_name']+ "</span></div>";
                        if(i++==15){
                             $("#companies_scheme").append("<div class='columns' id='"+page+"'>"+str+"</div>");
                             str = "";
                             i =1;
                             page++;
                         }

                    }); //end of each function
                    if(str != ""){
                         $("#companies_scheme").append("<div class='columns' id='"+page+"'>"+str+"</div>");
                    }
                   
                       $("#go, .company_scheme_title").show(); 
                
                    

                    $("#companies").fadeIn('slow');
                    $("#main").fadeOut('slow');
                }//end success
                
            }
        });//end xhr.queue1
}

$(document).on("click", "#find", function(){
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
    $("#table-head").show();

    $(".proj_ids").each(function(){
        if($(this).is(":checked")){
			ln_project_count++;
            var company = $(this).attr("data-pg");
            var proj_name = $(this).attr("data-val");
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
                    dataonly: 'true'
                },
                success: function (xml) {

                    contactScheme = $(xml).find("contact_in_scheme").text();
                    sendMail = $(xml).find("send_mail").text();
                    clicks = $(xml).find("clicks").text();
                    openedMails = $(xml).find ("opened_emails").text();
                    dynamicList = $(xml).find("dynamic_list").text();
                    callPriority = $(xml).find("call_priority").text();
                    totalAction = $(xml).find("total_actions").text();

                        if (contactScheme == "") contactScheme = 0;
                        if (sendMail == "") sendMail = 0;
                        if (clicks == "") clicks = 0;
                        if (openedMails == "") openedMails = 0;
                        if (dynamicList == "") dynamicList = 0;
                        if (callPriority == "") callPriority = 0;
                        if (totalAction == "") totalAction = 0;

                    str = "<tr>";
                    str += "<td>" + company + "</td>";
                    str += "<td>" + proj_name + "</td>";
                        $(".total_act_log #pn").text(project_name);
						$(".total_act_log #ln_count").text(ln_project_count + " schemes");
						
                    str += "<td class='as' style='text-align:center;'>" + contactScheme + "</td>";
                        total_contactScheme += parseInt(contactScheme);
                         $(".total_act_log #cs").text(total_contactScheme);

                    str += "<td class='as' style='text-align:center;'>" + sendMail + "</td>";
                        total_sendMail += parseInt(sendMail);
                        $(".total_act_log #es").text(total_sendMail);

                    str += "<td class='as' style='text-align:center;'>" + clicks + "</td>";
                    total_clicks += parseInt(clicks);
                        $(".total_act_log #clicks").text(total_clicks);

                    str += "<td class='as' style='text-align:center;'>"+ openedMails+"</th>";
                        total_openedMails += parseInt(openedMails);
                        $(".total_act_log #oe").text(total_openedMails);

                    str += "<td class='as' style='text-align:center;'>" + dynamicList + "</td>";
                        total_dynamicList += parseInt(dynamicList);
                        $(".total_act_log #al").text(total_dynamicList);

                    str += "<td class='as' style='text-align:center;'>" + callPriority + "</td>";
                        total_callPriority  += parseInt(callPriority );
                        $(".total_act_log #cp").text(total_callPriority );

                    str += "<td class='as' style='text-align:center;'>" + totalAction + "</td>";
                        total_totalAction += parseInt(totalAction);
                        $(".total_act_log #ta").text(total_totalAction);
                    str += "</tr>";
                    //console.log(str);
                    table.append(str);


                }
            }); //end xhr.queue2
            
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
                    dataonly: 'true'
                },
                success: function (xml) {

                    sent = $(xml).find("sent").text();
                    delivered = $(xml).find("delivered").text();
                    opened = $(xml).find("opened").text();
                    opened_perc = $(xml).find("opened_perc").text();
                    click = $(xml).find("clicks").text();
                    converted = $(xml).find("converted").text();
                    unsubscribed = $(xml).find("unsub").text();
                    bounce = $(xml).find("bounce").text();

                        if (sent == "") sent = 0;
                        if (delivered == "") delivered = 0;
                        if (opened == "") opened = 0;
                        if (opened_perc == "") opened_perc = 0;
                        if (click == "") click = 0;
                        if (converted == "") converted = 0;
                        if (unsubscribed == "") unsubscribed = 0;
                        if (bounce == "") bounce = 0;
                        if (opened == 0){
                            x = 0;
                        }else{
                            x = 100 *(parseInt(click)/parseInt(opened));
                        }

                    tbl = "<tr>";
                    tbl += "<td>" + company + "</td>";
                    tbl += "<td>" + proj_name + "</td>";
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
    });
    $("#companies").fadeOut('slow');
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

   function empty_fn(){}

   function start_loading(msg){
      if (!xhr.busy) return;
      $('#loading_msg_txt').text(msg);
      $('.bgload').show();
     $('#loading_msg').css('margin-left', '-' + ($('#loading_msg').width() / 2) + 'px');
   }

   function end_loading(){
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
    $("#act_log_table, #email_marketing_table").fixMe();
});


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
        for(i=1;i<$('tr').length;i++){
            var trs=parseInt($('tr:eq('+i+')').find('td:last').text())
            count+=trs
        }
        $(".printer-type tr:last td:last").text(count)
		console.log(count);
    }
});

$(document).ready(function(e) {
    $("#not_updated").hide();
	$("#go").show();
	$(".search-form").show();
});

/*
O += parseInt(opened_perc);
total_opened_perc = parseInt(O)
x = 100 *(parseInt(click)/parseInt(opened));
$(".total_email_marketing #operc").text(total_opened_perc);*/
$( document ).ready(function() {
   $(".from_datepicker").datepicker({ dateFormat: "yyyy-mm-dd" });
   $(".to_datepicker").datepicker({ dateFormat: "yyyy-mm-dd" });
 
});


  $('#btn_toggle_display_mode').click(function () {
    var lightmode = $('.pulse-warning').prop('href');
    var darkmode = $('.pulse-dark').prop('href');
    var btn_toggle_display_mode = $('.btn_toggle_display_mode-dark').prop('href');
 
  if(lightmode == 'http://192.168.50.12/pipeline/linkedin-dashboard/reports/lh-dashboard-records/total-records.php?light-mode'){
    $(".container-panel").css("background-color", "#DDDDDD");
    
     $("#tbodyEmails").css("background-color", "#ffffff");
   $("#tbodyEmails td").css("color", "black");
     $("#persona_id").css("color", "black");
   
  }

if(darkmode == 'http://192.168.50.12/pipeline/linkedin-dashboard/reports/lh-dashboard-records/total-records.php?dark-mode'){
    $(".container-panel").css("background-color", "#1A1A27");
     $("#tbodyEmails").css("background-color", "#1E1E1E");
      $("#tbodyEmails td").css("color", "white");
       $("#persona_id").css("color", "white");
     
  }
 
  
    }); 




$('#getRecordsPersona').click(function () {
     var from_datepicker =$('#from_datepicker').val();
var to_datepicker =$('#to_datepicker').val();
 var persona_id =$('#persona_id').val();
 

     if(from_datepicker == '' || to_datepicker == ''){
  Swal.fire({
                icon: 'error',
                title: `Please fill up date range`,
            })
}else{

 
    load_data();
 
 function load_data(fromDate, toDate, persona_id)
 {

$.ajax({
   url:"api/fetch_records.php",
   method:"POST",
   data:{fromDate:fromDate, toDate:toDate, persona_id:persona_id},
    
    beforeSend: function() {
        $('#loader').removeClass('hidden')
    },
    success: function(data){
         $('#getRecords').html(data);

    },
  complete: function(){
 
        setTimeout(function() {
           $("#getRecords").css("display", "block")
           $("#totalRecords").css("display", "none")
  $('#loader').addClass('hidden')
  
});

    },
});

 } 
}
 

   load_data(from_datepicker,to_datepicker,persona_id);
     // console.log(getclientId);
      console.log(from_datepicker+" / "+to_datepicker+" / "+persona_id);
 

 
   
 });







// FOR ASSIGNED AGENT

$('#getRecordsByPersonaID').click(function () {
     
 var removeChar =$('#persona_id').val();
const persona_id = removeChar.replaceAll('"', '');


    load_data_persona();
 
 function load_data_persona(persona_id)
 {

 

$.ajax({
   url:"api/fetch_by_persona.php",
   method:"POST",
   data:{persona_id:persona_id},
    
    beforeSend: function() {
        $('#loader').removeClass('hidden')
    },
    success: function(data){
         $('#getRecordsByPersona').html(data);

    },
  complete: function(){
 
        setTimeout(function() {
          $("#getRecordsByPersona").css("display", "block")
           $("#getRecords").css("display", "none")
           $("#totalRecords").css("display", "none")
  $('#loader').addClass('hidden')
  
});

    },
});




 } 
 
 

 
 
   load_data_persona(persona_id);
     // console.log(getclientId);
      console.log(persona_id);
  
 });

 

       const dataTable = document.getElementById("all-records-csv");
        const allRecords = document.getElementById("allRecords");
        const filename = document.getElementById("text-all-records").value;
        allRecords.addEventListener("click", () => {

          const c = confirm(`Download CSV ?  ` +filename);
          if (c) {
            const exporter = new TableCSVExporter(dataTable);
            const csvOutput = exporter.convertToCSV();
            const csvBlob = new Blob([csvOutput], { type: "text/csv" });
            const blobUrl = URL.createObjectURL(csvBlob);
            const anchorElement = document.createElement("a");

            anchorElement.href = blobUrl;
            anchorElement.download =  "contacts.csv";
            anchorElement.click();

              

            setTimeout(() => {
                URL.revokeObjectURL(blobUrl);
            }, 500);

        }
        });


class TableCSVExporter {
    constructor (table, includeHeaders = true) {
        this.table = table;
        this.rows = Array.from(table.querySelectorAll("tr"));

        if (!includeHeaders && this.rows[0].querySelectorAll("th").length) {
            this.rows.shift();
        }
    }

    convertToCSV () {
        const lines = [];
        const numCols = this._findLongestRowLength();

        for (const row of this.rows) {
            let line = "";

            for (let i = 0; i < numCols; i++) {
                if (row.children[i] !== undefined) {
                    line += TableCSVExporter.parseCell(row.children[i]);
                }

                line += (i !== (numCols - 1)) ? "," : "";
            }

            lines.push(line);
        }

        return lines.join("\n");
    }

    _findLongestRowLength () {
        return this.rows.reduce((l, row) => row.childElementCount > l ? row.childElementCount : l, 0);
    }

    static parseCell (tableCell) {
        let parsedValue = tableCell.textContent;

        // Replace all double quotes with two double quotes
        parsedValue = parsedValue.replace(/"/g, `""`);

        // If value contains comma, new-line or double-quote, enclose in double quotes
        parsedValue = /[",\n]/.test(parsedValue) ? `"${parsedValue}"` : parsedValue;

        return parsedValue;
    }
}

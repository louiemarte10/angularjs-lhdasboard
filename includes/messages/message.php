<link rel="stylesheet" href="/marketing/marketing_toolv3/assets/style.css">
<link rel="stylesheet" href="/marketing/marketing_toolv3/assets/css/semantic.min.css" type="text/css" />
<link rel="stylesheet" href="/marketing/marketing_toolv3/assets/components/icon.min.css" type="text/css" />
<link rel="stylesheet" href="/marketing/marketing_toolv3/assets/css/style.css?v=1.3" media="all" type="text/css" />
<link rel="stylesheet" href="/framework/styles/callbox-ui-v2/assets/callbox-ui.3.0.css" media="all" type="text/css" />

<link rel="stylesheet" href="/marketing/marketing_toolv3/assets/css/dataTables.semanticui.min.css" media="all" type="text/css" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Orbitron&display=swap">
<link rel="stylesheet" href="/framework/js/3rd-party/jquery/css/ui-smoothness/smoothness-v1-11-0.css">
<link rel="stylesheet" href="/marketing/marketing_toolv3/assets/css/font-awesome.min.css">
<style>
    /* @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');

    * {
        font-family: 'Roboto' !important;
    }

    #personaTbl {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 90%;
        margin-left: auto;
        margin-right: auto;
    }

    #personaTbl td,
    #personaTbl th {
        border: 1px solid #ddd;
        padding: 8px;

    }

   

    #personaTbl tr:hover {
        background-color: #ddd;
    }

    #personaTbl th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #f9fafb;
        color: black;
    }

    .newPersona {
        background-color: #21ba45;
        color: white;
    }

    .titleLinkedIn {
        margin-left: 5%;
    }*/
    .center-screen {
        position: absolute;
        width: 40%;
        top: 50%;
        left: 50%;
        margin-right: -50%;
        transform: translate(-50%, -50%);
        /* background-color: #D3D3D3; */


        margin: 0;
        outline: 0;
        -webkit-appearance: none;

        line-height: 1.21428571em;
        padding: .67857143em 1em;
        font-size: 1em;
        background: #fff;
        border: 1px solid rgba(34, 36, 38, .15);
        color: rgba(0, 0, 0, .87);
        border-radius: .28571429rem;
        -webkit-box-shadow: 0 0 0 0 transparent inset;
        box-shadow: 0 0 0 0 transparent inset;
        -webkit-transition: color .1s ease, border-color .1s ease;
        transition: color .1s ease, border-color .1s ease;


    }

    input[type=text] {
        border: 1px solid #22242626;

    }

    label {
        font-weight: 700;
    }

    input[type=text] {
        display: block;
        text-transform: none;
        font-size: 1em;
        width: 100%;
    }

    .threeColumn {
        width: 48% !important;
        float: left;
        margin-right: 2%;


    }

    .disabled {
        /* pointer-events: none; */
        background: #595959;
        opacity: 0.4;
        /* pointer-events: none; */
    }

    /* #overlay {
        position: fixed;
        display: none;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        z-index: 5;
        background: rgba(0, 0, 0, 0.5);
    } */
    /* table,
    tr,
    td,
    th {
        border-spacing: 0px;
        border-collapse: separate;
        border: 1px solid black;
    } */
</style>
<?php
//  echo '<script src="includes/home/controller.js"></script>';
?>

<section ng-controller="homeCtrl">
    <?php include("../../includes/modal/persona_info.php"); ?>
   

    <div style="margin: 5%;" id="overlay">
        <div style="margin-top: 2%;">
            <button type="button" id="insertConnection" class="ui primary mini button" style="float: right;margin: 2%;">Add New Persona</button>
            <!-- <a href="javascript:void(0)" class="waves-input-wrapper waves-button-input waves-effect newPersona" onclick="openNav()" style="padding: 1%;margin: 1%;margin-right: 5%;float:right">Add New Persona</a> -->
            <!-- <input type="button" class="waves-input-wrapper waves-button-input waves-effect newPersona" value="Add New Persona" style="padding: 1%;margin: 1%;margin-right: 5%;float:right"> -->
        </div>
        <h1>Client: <span id="client_name"></span></h1>
        <table class="ui medium table et_table" id="touchpoints_table" style="width:100%">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Linkedin DM Sents and Follow-ups</th>
                    <th>Linkedin DM Received</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>

</section>
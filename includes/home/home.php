<!-- <link rel="stylesheet" href="/marketing/marketing_toolv3/assets/style.css"> -->
<?php
// header("Location: {$_SERVER['PHP_SELF']}");
ini_set('display_errors', 0);
require("{$_SERVER['DOCUMENT_ROOT']}/config/pipeline-x.php");

// exit(header("Location: {$_SERVER['DOCUMENT_ROOT']}/config/pipeline-x.php"));

// require_once("/var/www/html/internal/activeaccount/model/main.php");
?>
<!-- <link rel="stylesheet" href="/marketing/marketing_toolv3/assets/css/semantic.min.css" type="text/css" /> -->
<link rel="stylesheet" href="/marketing/marketing_toolv3/assets/components/icon.min.css" type="text/css" />
<link rel="stylesheet" href="/marketing/marketing_toolv3/assets/css/style.css?v=1.3" media="all" type="text/css" />
<link rel="stylesheet" href="./assets/style2.scss">
<!-- <link rel="stylesheet" href="/framework/styles/callbox-ui-v2/assets/callbox-ui.3.0.css" media="all" type="text/css" /> -->

<link rel="stylesheet" href="/marketing/marketing_toolv3/assets/css/dataTables.semanticui.min.css" media="all" type="text/css" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Orbitron&display=swap">
<link rel="stylesheet" href="/framework/js/3rd-party/jquery/css/ui-smoothness/smoothness-v1-11-0.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- <script src="../../includes/home/controller.js"></script> -->

<style>
    option:empty {
        display: none;
    }

    #dropdownItemRestricted:hover {
        background-color: gray;
    }

    #dropdownItemReassign:hover {
        background-color: gray;
        color: white;
    }

    #dropdownItemModify:hover {
        background-color: gray;
        color: white;
    }

    .vertical-center {
        margin: 0;
        position: absolute;
        top: 50%;
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
    }
</style>
<section ng-controller="homeCtrl as ctrl">
    <?php
    include("../../includes/header.php");
    include("../../includes/modal/contact_info.php");

    ?>

    <div class="subheader py-2 py-lg-6 subheader-solid" id="cb_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!-- begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!-- begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!-- begin::Page Title-->
                    <!-- <h5 class="text-dark font-weight-bold my-1 mr-5">LinkedIn Dashboard </h5> -->
                    <!-- end::Page Title-->
                    <!-- begin::Breadcrumb-->
                 <!--    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item text-muted">
                            <a class="text-muted" href="http://192.168.50.12/tools/bootstrap5-documentation/">-> Home </a>
                        </li>
                    </ul> -->
                    <!-- end::Breadcrumb-->
                </div>
                <!-- end::Page Heading-->
            </div>
            <!-- end::Info-->
            <!-- begin::Toolbar-->
            <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                Launch demo modal
            </button> -->
            <div class="d-flex align-items-center">
                <button type="button" id="insertConnection" class="btn btn-primary btn-sm mr-2" ng-click="show_hide_div('#connection_modal');">Add New Persona</button>
            </div>
            <!-- end::Toolbar-->
        </div>
    </div>


    <!-- ng-init="show_hide_div('#connection_modal');" -->
    <div>
        <?php include("../../includes/modal/persona_edit.php"); ?>
        <?php include("../../includes/modal/persona_info.php"); ?>
        <?php include("../../includes/modal/assign_user.php"); ?>
    </div>

    <div class="container-fluid" style="margin-top: 10%" id="overlay">
        <!-- <h1>Persona: <span id="client_name"></span></h1> -->
        <!-- <div class="container-fluid" style="margin-top: 8%" id="overlay"> -->
        <!-- <h1>Persona: <span id="client_name"></span></h1> -->

        <div class="row mb-1">
            <div class="col-md-1 " style="max-width: 5vw !important" align="center">
                <div class="row vertical-center" style="margin-top: 10% !important;">

                    <div class="col-md-1 ">

                        <h3>Search: </h3>
                    </div>


                </div>
            </div>
            <div class="col-md-4">

                <div class="row">

                    <div class="col-md-4">
                        <label class="control-label">Name</label>
                        <input class="form-control" placeholder="Name..." type="text" ng-model="search.name" value="" ng-keyup="debug()" />
                    </div>
                    <div class="col-md-4">
                        <label class="control-label">Email</label>
                        <input class="form-control" placeholder="Email..." type="text" ng-model="search.email" value="" ng-keyup="debug()" />
                    </div>

                    <div class="col-md-4">
                        <label class="control-label">SMM Owner</label>
                        <input class="form-control" placeholder="SMM Owner..." type="text" ng-model="search.smm_owner" value="&nbsp;" ng-keyup="debug()" />
                    </div>

                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-3">
                        <label class="control-label">Status</label>
                        <select ng-model="status" id="persona_status" class="form-control " ng-change="getPersona(0, '', 'byStatus')" style="font-size: 1rem">
                            <option value="active" style="font-size: 1.5rem">Active</option>
                            <option value="inactive" style="font-size: 1.5rem">Inactive</option>
                        </select>

                    </div>

                </div>

             
            </div>


            <div class="col-md-3">
                    
                     <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3"><a class="text-muted"href="https://docs.google.com/presentation/d/17XMnmFMlrE03n8H63twxzNribTfreR6f/edit#slide=id.g9f9b7141f4_0_1" target="_blank" style="float:right; margin-top:8%; color:#21A4F1 !important; font-size: 1.1em; "><u> LH Guide</u> </a></span>
            </div>
      
            </div>
          
        </div>
        <!-- <div>
                <ul style="list-style-type: none;">
                    <li style="float: left;padding: 2% !important">Name: <input type="text" ng-model="search.name" value=""></li>
                    <li style="float: left;padding: 2% !important">Email: <input type="text" ng-model="search.email" value=""></li>
                    <li style="float: left;padding: 2% !important">
                        <span>Status:</span> &nbsp;&nbsp;&nbsp;&nbsp;
                        <select ng-model="status" id="persona_status" style="transform: scale(1);" ng-change="getPersona(0, '', 'byStatus')">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                       
                    </li>

                </ul>
            </div> -->
        <div id="table-container" class="overflow-auto" style="height: 29vw;">
            <table class="table table-hover table-bordered table-sm table-striped" id="personaTbl" style="width:100%;margin-bottom: 3%">
                <thead>
                    <?php if (in_array(31, px_login::roles("ORG"))) {
                        echo '<th style="background-color: #c7c5c5;">Persona Id</th>';
                    }
                    ?>
                    <th style="text-align: center;background-color: #c7c5c5;">No.</th>
                    <th style="background-color: #c7c5c5;"></th>
                    <th style="background-color: #c7c5c5;">Account Type</th>
                    <th style="background-color: #c7c5c5;">Name</th>
                    <th style="background-color: #c7c5c5;">Email</th>
                    <th style="text-align: center;background-color: #c7c5c5;"><!-- Assigned To -->Users can Access this Persona</th>
                    <th style="text-align: center;background-color: #c7c5c5;">Primary SMM Owner</th>
                    <th style="text-align: center;background-color: #c7c5c5;">Created By</th>
                    <!-- <th width="40%">Webhook Url</th> -->
                    <th colspan="3" style="background-color: #c7c5c5;"></th>
                    <!-- <th>Action</th> -->
                    <!--  -->
                </thead>
                <!-- | startFrom:currentPage*pageSize | limitTo:pageSize -->
                <tbody>
                    <!-- | limitTo : 5 | limit : 1  -->
                    <!-- | startFrom:currentPage*pageSize | limitTo:pageSize  -->
                    <tr class="bg-light-primary" id="personaRow" ng-repeat="(key,list) in personaList | filter:{my_fullname: search.name,my_email:search.email, users_assigned:search.smm_owner} ">
                        <!-- ng-click="show_hide_contact(list.linkedin_account_persona_id)" -->
                        <?php if (in_array(31, px_login::roles("ORG"))) {
                            echo ' <td style="text-align: center;">';
                            echo ' {{list.linkedin_account_persona_id}}';
                            echo ' </td>';
                        }
                        ?>
                        <td style="text-align: center;">
                            {{key + 1}}
                        </td>
                        <td>

                            <!-- <div align="center" ng-if="list.x == 'active'">
                                <button class="btn btn-light btn-sm btn-text-success btn-hover-text-success font-weight-bold" ng-click="deactivate_persona(list)" style="color:red">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-x" viewBox="0 0 16 16">
                                        <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                                        <path fill-rule="evenodd" d="M12.146 5.146a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z" />
                                    </svg> -->
                            <!-- &nbsp;&nbsp;Set as Restricted -->

                            <!-- </button>
                            </div> -->
                            <div align="center" ng-if="list.x == 'active'">
                                <!-- <button class="btn btn-light btn-sm btn-text-success btn-hover-text-success font-weight-bold" style="color:black">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                        <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                                    </svg>

                                </button> -->
                                <div class="ml-6 ml-lg-0 ml-xxl-6 flex-shrink-0">
                                    <div class="dropdown dropdown-inline mr-4">
                                        <button type="button" class="btn btn-light-primary btn-icon btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="ki ki-bold-more-hor"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <!-- ng-click="map_company(contact.data_id,x);" -->
                                            <a class="dropdown-item" title="Deactive this persona" id="dropdownItemRestricted" href="" ng-click="deactivate_persona(list)" style="color: red;">Mark as Restricted</a>
                                            <a class="dropdown-item" title="Reassign this persona" id="dropdownItemReassign" href="" ng-click="show_hide_div('#assign_user_modal', list);">Reassign User</a>


                                            <a class="dropdown-item" title="Reassign this persona" id="dropdownItemModify" href="" ng-click="show_hide_div('#edit_persona', list);">Modify Persona</a>


                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div align="center" ng-if="list.x == 'inactive'">
                                <!-- <button class="btn btn-light btn-sm btn-text-success btn-hover-text-success font-weight-bold" style="color:black">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                        <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                                    </svg>

                                </button> -->
                                <div class="ml-6 ml-lg-0 ml-xxl-6 flex-shrink-0" ng-if="x.selected != 1">
                                    <div class="dropdown dropdown-inline mr-4">
                                        <button type="button" class="btn btn-light-primary btn-icon btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="ki ki-bold-more-hor"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <!-- ng-click="map_company(contact.data_id,x);" -->
                                            <a class="dropdown-item" href="" ng-click="activate_persona(list)">Activate Persona</a>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </td>

                        <td valign="top">{{list.account_type}} </td>
                        <td valign="top">{{list.my_fullname}} </td>
                        <td valign="top">{{list.my_email}}</td>

                        <td valign="middle">
                            <div ng-if="list.assigned_user.fname.length > 0" align="center">
                                <!-- {{list.assigned_user.fname}}&nbsp;{{list.assigned_user.lname}} -->
                                {{ list.users_assigned }}
                            </div>
                            <div ng-if="!list.assigned_user.fname.length > 0" align="center">
                                <button class="btn btn-light btn-sm btn-text-success btn-hover-text-success font-weight-bold" ng-click="show_hide_div('#assign_user_modal', list);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
                                        <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                                        <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z" />
                                    </svg>
                                    &nbsp;&nbsp;assign a user

                                </button>
                            </div>


                        </td>



                         <td valign="middle">
                            <div ng-if="list.pipeUser.fname.length > 0" align="center">
                                {{list.pipeUser.fname}}&nbsp;{{list.pipeUser.lname}}
                            </div>
                            <div ng-if="list.pipeUser.fname.length <= 0 || list.pipeUser.fname == '' || list.pipeUser.fname == null" align="center">
                                none
                            </div>
                        </td>




                        <td valign="middle">
                            <div ng-if="list.createdBy.fname.length > 0" align="center">
                                {{list.createdBy.fname}}&nbsp;{{list.createdBy.lname}}
                            </div>
                            <div ng-if="list.createdBy.fname.length <= 0 || list.createdBy.fname == '' || list.createdBy.fname == null" align="center">
                                none
                            </div>
                        </td>


                        
                        <!-- <td valign="top" >{{list.catch_hook_url}} </td> -->
                        <td valign="top">
                            <a href="contacts/{{list.linkedin_account_persona_id}}" target="_blank">
                                <button class="btn btn-light btn-sm btn-text-success btn-hover-text-success font-weight-bold" style="float: right;">
                                    <span class="svg-icon svg-icon-primary svg-icon svg-icon-x1">
                                        <!--begin::Svg Icon | path:2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Communication/Share.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path d="M10.9,2 C11.4522847,2 11.9,2.44771525 11.9,3 C11.9,3.55228475 11.4522847,4 10.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,16 C20,15.4477153 20.4477153,15 21,15 C21.5522847,15 22,15.4477153 22,16 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L10.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                <path d="M24.0690576,13.8973499 C24.0690576,13.1346331 24.2324969,10.1246259 21.8580869,7.73659596 C20.2600137,6.12944276 17.8683518,5.85068794 15.0081639,5.72356847 L15.0081639,1.83791555 C15.0081639,1.42370199 14.6723775,1.08791555 14.2581639,1.08791555 C14.0718537,1.08791555 13.892213,1.15726043 13.7542266,1.28244533 L7.24606818,7.18681951 C6.93929045,7.46513642 6.9162184,7.93944934 7.1945353,8.24622707 C7.20914339,8.26232899 7.22444472,8.27778811 7.24039592,8.29256062 L13.7485543,14.3198102 C14.0524605,14.6012598 14.5269852,14.5830551 14.8084348,14.2791489 C14.9368329,14.140506 15.0081639,13.9585047 15.0081639,13.7695393 L15.0081639,9.90761477 C16.8241562,9.95755456 18.1177196,10.0730665 19.2929978,10.4469645 C20.9778605,10.9829796 22.2816185,12.4994368 23.2042718,14.996336 L23.2043032,14.9963244 C23.313119,15.2908036 23.5938372,15.4863432 23.9077781,15.4863432 L24.0735976,15.4863432 C24.0735976,15.0278051 24.0690576,14.3014082 24.0690576,13.8973499 Z" fill="#000000" fill-rule="nonzero" transform="translate(15.536799, 8.287129) scale(-1, 1) translate(-15.536799, -8.287129) " />
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                    view contacts
                                </button>
                            </a>

                        </td>
                        <td valign="top">
                            <a href="messages/{{list.linkedin_account_persona_id}}" target="_blank">
                                <button class="btn btn-light btn-sm btn-text-success btn-hover-text-success font-weight-bold" style="float: right;">
                                    <span class="svg-icon svg-icon-primary svg-icon svg-icon-x1">
                                        <!--begin::Svg Icon | path:2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Communication/Share.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path d="M10.9,2 C11.4522847,2 11.9,2.44771525 11.9,3 C11.9,3.55228475 11.4522847,4 10.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,16 C20,15.4477153 20.4477153,15 21,15 C21.5522847,15 22,15.4477153 22,16 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L10.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                <path d="M24.0690576,13.8973499 C24.0690576,13.1346331 24.2324969,10.1246259 21.8580869,7.73659596 C20.2600137,6.12944276 17.8683518,5.85068794 15.0081639,5.72356847 L15.0081639,1.83791555 C15.0081639,1.42370199 14.6723775,1.08791555 14.2581639,1.08791555 C14.0718537,1.08791555 13.892213,1.15726043 13.7542266,1.28244533 L7.24606818,7.18681951 C6.93929045,7.46513642 6.9162184,7.93944934 7.1945353,8.24622707 C7.20914339,8.26232899 7.22444472,8.27778811 7.24039592,8.29256062 L13.7485543,14.3198102 C14.0524605,14.6012598 14.5269852,14.5830551 14.8084348,14.2791489 C14.9368329,14.140506 15.0081639,13.9585047 15.0081639,13.7695393 L15.0081639,9.90761477 C16.8241562,9.95755456 18.1177196,10.0730665 19.2929978,10.4469645 C20.9778605,10.9829796 22.2816185,12.4994368 23.2042718,14.996336 L23.2043032,14.9963244 C23.313119,15.2908036 23.5938372,15.4863432 23.9077781,15.4863432 L24.0735976,15.4863432 C24.0735976,15.0278051 24.0690576,14.3014082 24.0690576,13.8973499 Z" fill="#000000" fill-rule="nonzero" transform="translate(15.536799, 8.287129) scale(-1, 1) translate(-15.536799, -8.287129) " />
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                    view messages
                                </button>
                            </a>

                        </td>
                        <td valign="top">
                            <button class="btn btn-light btn-sm btn-text-success btn-hover-text-success font-weight-bold" ng-click="copyTextToClipboard(list.catch_hook_url)" style="float: right;">
                                <span class="svg-icon svg-icon-primary svg-icon svg-icon-x1">
                                    <!--begin::Svg Icon | path:2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Communication/Share.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <path d="M10.9,2 C11.4522847,2 11.9,2.44771525 11.9,3 C11.9,3.55228475 11.4522847,4 10.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,16 C20,15.4477153 20.4477153,15 21,15 C21.5522847,15 22,15.4477153 22,16 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L10.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                            <path d="M24.0690576,13.8973499 C24.0690576,13.1346331 24.2324969,10.1246259 21.8580869,7.73659596 C20.2600137,6.12944276 17.8683518,5.85068794 15.0081639,5.72356847 L15.0081639,1.83791555 C15.0081639,1.42370199 14.6723775,1.08791555 14.2581639,1.08791555 C14.0718537,1.08791555 13.892213,1.15726043 13.7542266,1.28244533 L7.24606818,7.18681951 C6.93929045,7.46513642 6.9162184,7.93944934 7.1945353,8.24622707 C7.20914339,8.26232899 7.22444472,8.27778811 7.24039592,8.29256062 L13.7485543,14.3198102 C14.0524605,14.6012598 14.5269852,14.5830551 14.8084348,14.2791489 C14.9368329,14.140506 15.0081639,13.9585047 15.0081639,13.7695393 L15.0081639,9.90761477 C16.8241562,9.95755456 18.1177196,10.0730665 19.2929978,10.4469645 C20.9778605,10.9829796 22.2816185,12.4994368 23.2042718,14.996336 L23.2043032,14.9963244 C23.313119,15.2908036 23.5938372,15.4863432 23.9077781,15.4863432 L24.0735976,15.4863432 C24.0735976,15.0278051 24.0690576,14.3014082 24.0690576,13.8973499 Z" fill="#000000" fill-rule="nonzero" transform="translate(15.536799, 8.287129) scale(-1, 1) translate(-15.536799, -8.287129) " />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                                copy webhook url
                            </button>
                        </td>

                        <!-- <td valign="top" colspan="2">
                <button ng-model="btnViewContact" ng-click="show_hide_contact(list.linkedin_account_persona_id)" ng-if="contactForm[list.linkedin_account_persona_id] != 'show'" ng-disabled="list.contacts.length <= 0 || list.contacts == null ">view contact</button>
                <button ng-model="btnViewContact" ng-click="show_hide_contact(list.linkedin_account_persona_id)" ng-if="list.contacts.length > 0 && contactForm[list.linkedin_account_persona_id] == 'show'">collapse</button>

            </td> -->
                        <!-- <td valign="top"></td> -->


                    </tr>








                </tbody>
                <!-- <tfoot ng-repeat-end>
        <tr>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </tfoot> -->
            </table>
            <!-- </div> -->

        </div>
        <!-- <div class="pagination" align="center">
            <a href="#">&laquo;</a>
            <a href="#">1</a>
            <a href="#">2</a>
            <a href="#">3</a>
            <a href="#">4</a>
            <a href="#">5</a>
            <a href="#">6</a>
            <a href="#">&raquo;</a>
        </div> -->



</section>
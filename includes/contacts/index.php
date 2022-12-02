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
<!-- <link rel="stylesheet" href="/framework/styles/callbox-ui-v2/assets/callbox-ui.3.0.css" media="all" type="text/css" /> -->

<link rel="stylesheet" href="/marketing/marketing_toolv3/assets/css/dataTables.semanticui.min.css" media="all" type="text/css" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Orbitron&display=swap">
<link rel="stylesheet" href="/framework/js/3rd-party/jquery/css/ui-smoothness/smoothness-v1-11-0.css">
<link rel="stylesheet" href="./assets/style2.scss">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css">
<!-- <script src="../../includes/home/controller.js"></script> -->
<style>
    .my-actions {
        margin: 0 3em;
    }

    .order-3 {
        order: 3;
        background-color: #b5c7c6 !important;

    }

    .order-2 {
        order: 2;
        background-color: #85d5e6 !important;
    }

    .order-1 {
        order: 1;
        background-color: #85e6c2 !important;
    }

    /* .paginationclass {
        margin: 19px 28px;
    }

    .paginationclass span {
        margin-left: 15px;
        display: inline-block;
    }

    .pagination-controle li {
        display: inline-block;
    }

    .pagination-controle button {
        font-size: 12px;
        margin-top: -26px;
        cursor: pointer;
    }

    .pagination {
        margin: 5px 12px !important;
    } */



#myButton.loading {
    /*background-color: white;*/
    padding-left: 30px;
}

#myButton.loading:after {
    content: "";
    position: absolute;
    border-radius: 100%;
    left: 335px;
    top: 50%;
    width: 0px;
    height: 0px;
    margin-top: -2px;
    border: 2px solid white;
    border-left-color: #666666;
    border-top-color: #666666;
    animation: spin .6s infinite linear, grow .3s forwards ease-out;
}
@keyframes spin { 
    to {
        transform: rotate(359deg);
    }
}
@keyframes grow { 
    to {
        width: 14px;
        height: 14px;
        margin-top: -8px;
        right: 13px;
    }
}
 
</style>
<section ng-controller="homeCtrl as ctrl" style="margin-bottom: 1%;background-color:white">
    <?php
    include("../../includes/header.php");
    include("../../includes/modal/contact_info.php");
    include("../../includes/modal/import_data.php");

    ?>
    <div>
        <!-- ubheader py-2 py-lg-6 subheader-solid -->
        <div class="mt-20" id="cb_subheader" styl>
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline flex-wrap mr-5">
                       <h5 class="text-dark h3 font-weight-bold my-1 mr-5" ng-model="personaName">{{ personaName }}&nbsp;-&nbsp;{{ personaEmail }} - <small>{{ personaType }}</small> <?php //print_r(px_login::roles("ORG")); 
                                                                                                                                                                                        ?></h5>
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item text-muted">
                                <a href="" class="text-muted">LinkedIn Dashboard </a>
                            </li>
                            <li class="breadcrumb-item text-muted">
                                <a href="" class="text-muted">Contacts List </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>


        <!-- ng-init="show_hide_div('#connection_modal');" -->
        <div>
            <?php include("../../includes/modal/persona_info.php"); ?>
            <?php include("../../includes/modal/edit_contacts.php"); ?>
        </div>

        <div class="container-fluid" id="overlay">
            <!-- <h1>Persona: <span id="client_name"></span></h1> -->
            <div class="filter-div mt-5 pt-5 filter-border">
                <div class="row mb-5">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label">Name</label>
                                <input class="form-control form-control-sm" placeholder="Name..." type="text" ng-model="search.name" value="" />
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Email</label>
                                <input class="form-control form-control-sm" placeholder="Email..." type="text" ng-model="search.email" value="" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="control-label">From</label>
                                <input class="form-control form-control-sm" ng-model="search.dateFrom" id="dateFrom" type="date" ng-disabled="dateFilterDisable" />
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">To</label>
                                <div class="input-group">
                                    <input class="form-control form-control-sm" ng-model="search.dateTo" id="dateTo" type="date" ng-disabled="dateFilterDisable" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="inputState">Filter By</label>
                                <select class="form-control form-control-sm" ng-model="dateFilter.value" ng-options="v.label for v in dateFilter.values" ng-change="dateFilterChange()">
                                </select>
                            </div>
                        </div>
                    </div>

                 <!--    <div class="col-md-3">
                        <div class="row">
                            <div class="col">
                                <div class="form-check mt-8 mr-2">
                                    <input class="form-check-input" type="checkbox" style="transform: scale(1.5);" ng-model="country_var" ng-change="showNoCountries(country_var);" id="flexSwitchCheckChecked" checked>
                                    <label class="form-check-label ml-1 mt-1" for="flexSwitchCheckChecked">Show No Countries:&nbsp;</label>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
                <div class="row mb-5">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="inputState">Campaign Names {{campaign.campaign_helper_id}}  </label>

                            <!--     <select class="form-control form-control-sm" ng-model="searchModel.campaign_helper_id" ng-options="v.label for v in campaignNames.values"  >
                                </select> -->
                                <!-- <select id="campaignName" class="form-control form-control-sm" ng-model="connectionsFilter.value" ng-options="v.label for v in connectionsFilter.values" ng-change="connectionFilterChange()"> -->

                   <!--         <select class="form-control form-control-sm" ng-model="search.campaign_helper_id" ng-change="showCampaign();" hidden>
                                   	<option value="SG_Marketing321"></option>
                                    <option value="409">  test </option>
                                </select>   -->


                    <!--           <select name="country" ng-model="country" class="form-control" ng-change="loadState()">  
                          <option value="">Select Campaign</option>  
                          <option ng-repeat="campaign in campaigns" value="{{campaign.campaign_helper_id}}">{{campaign.campaign_name}}</option>   -->

 
                          <select class="form-control form-control-sm" ng-model="search.campaign_helper_id" ng-change="showCampaign(0);" >
                                    <option value=""></option>
                                    <option ng-repeat="i in campaign_list  " value="{{ i.campaign_helper_id }}">{{ i.campaign_name }}</option>
                                </select>  
                     </select>  



                            </div>
                            <div class="col-md-6">
                                <label for="inputState">Country</label>
                                <select id="country-dropdown" name="selectedCountries[]" ng-model="search.country_id" class="form-control form-control-sm"  > <!-- multiple="multiple" -->
                                    <option value=""></option>
                                    <option value="0">Show No Country</option>
                                    <option ng-repeat="i in country_list" value="{{ i.country_id }}">{{ i.country }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="control-label">Position <!-- <span class="ml-10"><input ng-model="isExactPosition" type="checkbox" style="position: relative; top: 1px" /> Exact</span> --></label>
                                <!-- <input class="form-control form-control-sm" type="text" ng-model="positionFilter" /> --> 
                                <input class="form-control form-control-sm" type="text" ng-model="search.organization_title" />
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Industry</label>
                                <input class="form-control form-control-sm" type="text" ng-model="search.industry" disabled  />
                            </div>
                            <div class="col-md-4">
                                <label for="inputState">Connections Filter</label>
                              <!--   <select id="campaignName" class="form-control form-control-sm" ng-model="connectionsFilter.value" ng-options="v.label for v in connectionsFilter.values" ng-change="connectionFilterChange()">
                                </select> -->
                                 <select class="form-control form-control-sm" ng-model="search.isConnected" >
                                 	<option value=""> </option>
                                    <option value="true">Show connected only</option>
                                   	<option value="false">Show not yet connected</option>
                                </select>


                                <!-- <input class="form-check-input" type="checkbox" style="transform: scale(1.5);" ng-model="country_var" ng-change="showNoCountries(country_var);" id="flexSwitchCheckChecked" checked> -->
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-md-3">
                        <div class="row">
                            <div class="col">
                                <div class="form-check mt-8 mr-2">
                                    <input class="form-check-input" type="checkbox" style="transform: scale(1.5);" ng-model="valid_email_var" ng-change="showValidEmails(valid_email_var);" id="flexSwitchCheckChecked" checked>
                                    <label class="form-check-label ml-1 mt-1" for="flexSwitchCheckChecked">Show Valid Emails:&nbsp;</label>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
                <div class="row mb-5">
                    <div class="col-md-8">
                        <div class="row">
                            <!-- <button type="button" class="btn btn-success btn-sm b-witdh ml-4" ng-click="getPersona(0, '', 'byDate');debug()">Search <i class="bi bi-search button-icon"></i></button> -->
                             <button type="button" class="btn btn-success btn-sm b-witdh ml-4" ng-click="getDate()">Search <i class="bi bi-search button-icon"></i></button>
                            <button class="btn btn-warning btn-sm b-witdh ml-2" ng-click="showImportModal();">Import <i class="bi bi-upload button-icon"></i></button>
                            <?php if (in_array(31, px_login::roles("ORG")) || in_array(207, px_login::roles("ORG"))) { ?>
                                <button class="btn btn-info btn-sm b-witdh ml-2" ng-click="exportToCsv_FullDownload();" id="myButton">Export to CSV <i class="bi bi-filetype-csv button-icon"></i></button>
                            <?php } else { ?>
                                <button class="btn btn-info btn-sm b-witdh ml-2" ng-click="exportToCsv_Normal_Users();" id="myButton">Export to CSV <i class="bi bi-filetype-csv button-icon"></i></button>
                            <?php } ?>


                            <button type="button" class="btn btn-primary btn-sm b-witdh ml-2" ng-click="clearSearch()">Clear <i class="bi bi-x-circle button-icon"></i></button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row justify-content-end pr-10">
                        <?php if(px_login::info("user_id") == 6541){ ?>
                        <!-- <button type="button" class="btn btn-secondary"  ng-click="pageSize =  personaList.contacts.length ">
                              show all contacts
                            </button> -->
                        <?php } ?>
                            <h3>Total Contacts: {{personaList.contacts.length}}</h3> <!-- personaList.contacts.length -->
                        </div>
                    </div>
                </div>
            </div>
            <div id="table-container" class="overflow-auto" style="height: auto !important">
                <table class="table table-hover table-sm" style="width:100%;background-color: white;font-size: 12px;" id="tableID">
                    <thead class="header-sticky">
                        <?php if (in_array(31, px_login::roles("ORG"))) {
                            echo '<th class="">Data ID</th>';
                        }
                        ?>
                        <th class=""></th>

                        <th class=" chk_all" style="text-align: center" data-toggle="tooltip" data-placement="top" title="Check All">
                            <input type="checkbox" id="chk_all" ng-click="selectAll(personaList[0].contacts);">
                        </th>


                        <th class="">Connected</th>
                        <th class="">Name</th>
                        <th class="">Email</th>
                        <th class="">Contact No.</th>
                        <th class="">Company</th>
                        <th class="">Country</th>
                       <th >Campaign</th> 
                        <th class="">Date Connected</th>
                        <th class="">Date Added</th>
                        <!-- <th>Date Added</th> -->
                    </thead>
                    <!-- | startFrom:currentPage*pageSize | limitTo:pageSize -->
                    <tbody>



                        <!-- ng-click="showContactInfo(contact);" , isConnected: isShowConnections  -->
                        <?php if ($_SERVER['REMOTE_ADDR'] == '192.168.60.227') {
                        } ?>


                        <tr ng-repeat="(key,contact) in personaList.contacts | filter:{  'campaign_helper_id': search.campaign_helper_id, 'country_id': search.country_id ,contact_fullname: search.name,contact_email:search.email, isConnected: search.isConnected, no_country: isNoCountry, organization_title: search.organization_title} | pagination: curPage * pageSize | limitTo: pageSize" id="contact_{{contact.data_id}}" ng-click="showContactInfo(contact);">
                            <!-- {{personaList.contacts}} -->
                            <!-- <template id="my-template-{{contact.data_id}}">

                        </template> -->
                            <?php if (in_array(31, px_login::roles("ORG"))) {
                                echo '<td class="align-left" valign="top" style="text-align: left;">';
                                echo "{{contact.data_id}}";
                                echo '</td>';
                            }
                            ?>


                            <td class="align-left" valign="top" style="text-align: left;">
                                <!-- {{key + 1}}. -->
                                {{contact.numbering}}. 
                            </td>

                            <td class="align-left" valign="top" style="text-align: left;">
                                <!-- ng-change="selectContact({{{contact.data_id: contact}}});" -->
                                <input type="checkbox" ng-model="chkBox" class="chk_all" id="chkBox_{{contact.linkedin_account_persona_id}}_{{contact.data_id}}" ng-change="selectContact(contact)">
                                <!-- <input type="checkbox" ng-model="chkBox"  ng-change="selectContact(contact.data_id,{'{{contact.data_id}}': contact})"> -->

                            </td>



                            <td class="align-left" valign="top" ng-click="showContactInfo(contact);" style="text-align: left;">
                                <!-- {{ contact.isConnected}} -->
                                <span ng-if="contact.isConnected === true">Yes</span>
                                <span ng-if="contact.isConnected === false">No</span>

                            </td>
                            <!-- <td valign="top" ng-click="showContactInfo(contact);" ng-repeat="con in contact.connection_data">
                            {{con.}}
                        </td> -->
                            <td class="align-left" valign="top" ng-click="showContactInfo(contact);">
                                <!-- <i class="fas fa-address-card"></i> -->
                                <span style="margin-left: 1%;">{{contact.first_name}}&nbsp;{{contact.last_name}}</span>

                            </td>
                            <td class="align-left" valign="top" ng-click="showContactInfo(contact);" ng-if="contact.contact_email != ''">
                                <!-- {{contact.contact_email}} -->
                                <span class="btn btn-primary position-relative" style="background-color: transparent;color:#3f4254;border: none" ng-if="contact.contact_email.length > 0">
                                    {{contact.contact_email}} &nbsp;
                                    <span ng-if="contact.contact_email_status == 'valid'" style="color: green;">{{contact.contact_email_status}}</span>
                                    <span ng-if="contact.contact_email_status == 'unverifiable'" style="color: orange;">{{contact.contact_email_status}}</span>
                                    <!-- <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success" ng-if="contact.contact_email_status == 'valid'">
                                        valid

                                    </span>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning" ng-if="contact.contact_email_status == 'unverifiable'">
                                        unverifiable

                                    </span>
                                </span>

                                  <br>{{contact.contact_email_status}} -->
                            </td>
                            <td class="align-left" valign="top" ng-click="showContactInfo(contact);" ng-if="contact.contact_email == ''">no email</td>
                            <td class="align-left" valign="top" ng-click="showContactInfo(contact);">
                                <span ng-if="contact.phone_num.length > 0">
                                    Phone:&nbsp;{{contact.phone_num}} <Br>
                                </span>
                                <span ng-if="contact.mobile_num.length > 0">
                                    Mobile:&nbsp;{{contact.mobile_num}} <Br>
                                </span>
                                <span ng-if="contact.direct_line_num.length > 0">
                                    Direct Line:&nbsp;{{contact.direct_line_num}} <Br>
                                </span>

                            </td>
                            <!-- <td class="align-left" valign="top" ng-click="showContactInfo(contact);">
                                <span ng-repeat="x in contact.phone_numbers" ng-if="contact.phone_numbers.length > 0 && x.x == 'active'">
                                    {{x.phone_type}}:&nbsp;{{x.phone}} <Br>
                                </span>

                            </td> -->
                            <!-- <td valign="top" ng-click="showContactInfo(contact);" ng-if="contact.phone_1.length > 0"> {{contact.phone_type_1}}: {{contact.phone_1}}</td> -->
                            <!-- <td valign="top" ng-click="showContactInfo(contact);" ng-if="contact.phone_1 == '' || contact.phone_1 == null || contact.phone_1.length <= 0">none</td> -->


                            <td valign="top" >

                                <div class="px-3">
                                    <div class="row">
                                        <div class="col-md-12 px-1">

                                            <div class="card card-custom mb-2 bg-diagonal bg-diagonal-light-success" ng-if="contact.organization_start.length > 0" style="z-index: 0 !important; min-height: 35px;">
                                                <div class="card-body px-0 py-0">
                                                    <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
                                                        <div class="d-flex flex-column">
                                                            <a href="#" class="small text-dark text-hover-primary">{{contact.company}}</a>
                                                            <p class="small text-muted">{{contact.organization_title}} <Br>{{contact.organization_location}}</p>
                                                            <p class="small text-muted">From: {{contact.organization_start}} To: {{contact.organization_end}}</p>
                                                   
                                                            <p class="small text-muted"><a href="{{contact.organization_website}}" target="_blank">{{contact.organization_website}}</a></p>

                                                        </div>
                                                        <div class="ml-6 ml-lg-0 ml-xxl-6 flex-shrink-0">
                                                            <p class="text-success"><i class="fas fa-check text-success"></i> Current</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                             <div class="card card-custom mb-2 bg-diagonal bg-diagonal-light-success"ng-if="!contact.organization_start.length > 0" align="center" style="z-index: 0 !important; min-height: 35px;">
                                                <div class="card-body px-0 py-0">
                                                    <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
                                                        <div class="d-flex flex-column">
                                                            
                                                                <div ng-if="!contact.organization_start.length > 0" align="center"><p> No Information  </p></div>
                                                        </div>
                                                        <div class="ml-6 ml-lg-0 ml-xxl-6 flex-shrink-0">
                                                            <p class="text-success"><i class="fas fa-check text-success"></i> Current</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        

                                            <!-- <div ng-if="x.selected != 1" class="card card-custom mb-2 " style="z-index: 0 !important; min-height: 35px;">
                                                <div class="card-body px-0 py-0">
                                                    <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
                                                        <div class="d-flex flex-column">
                                                            <a href="#" class="small text-dark text-hover-primary">{{x.organization}}</a>
                                                            <p class="small text-muted">{{x.organization_title}} <Br>{{x.organization_location}}</p>

                                                            <p class="small text-muted">From: {{x.organization_start}} To: {{x.organization_end}}</p>
                                                            <p class="small text-muted"><a href="{{x.organization_website}}" target="_blank">{{x.organization_website}}</a></p>


                                                        </div>
                                                        <div class="ml-6 ml-lg-0 ml-xxl-6 flex-shrink-0" ng-if="x.selected != 1" style="z-index: 1 !important;">
                                                            <div class="dropdown dropdown-inline mr-4">
                                                             
                                                                <a class="dropdown-item" href="#" ng-click="map_company(contact.data_id,x);" style="z-index: 3;background-color:#3f4254;color: white">Set as Current</a>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>

                                <!-- </div> -->
                            </td>
                            <td class="align-left" valign="top" ng-click="showContactInfo(contact);">
                                <span ng-if="contact.country.length > 0">
                                    {{ contact.country }}
                                </span>
                                <span ng-if="!contact.country.length > 0">
                                    {{ contact.country }}
                                </span>

                            </td>
                            
                            <td valign="top" ng-click="showContactInfo(contact);"  >{{contact.campaign_name}}</td> 
                            
                            <td class="align-left" valign="top" ng-click="showContactInfo(contact);" ng-if="contact.cn_date_connected.length > 0">
                                {{contact.cn_date_connected| date}}

                            </td>
                            <td class="align-left" valign="top" ng-click="showContactInfo(contact);" ng-if="!contact.cn_date_connected.length > 0">
                                none

                            </td>
                            <td class="align-left" valign="top">
                                {{contact.date_added_str| date}}

                            </td>
                            <!-- <td valign="top" style="text-align: center;"><a href="">view conversation</a></td> -->
                      

                        </tr>






                    </tbody>
                    <tfoot ng-repeat-end>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>


                <!-- pager -->


                <div class="pagination pagination-centered" ng-show="personaList.contacts.length">
                    <ul class="pagination-controle pagination">
                        <li>
                            <button type="button" class="btn btn-primary" ng-disabled="curPage == 0" ng-click="curPage = curPage-1">
                                &lt; PREV
                            </button>
                        </li>
                        <li>
                            <span>Page {{curPage + 1}} of {{ numberOfPages }}</span>
                        </li>
                        <li>
                            <button type="button" class="btn btn-primary" ng-disabled="curPage >= personaList.contacts.length / pageSize - 1" ng-click="curPage = curPage+1">
                                NEXT &gt;
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</section>
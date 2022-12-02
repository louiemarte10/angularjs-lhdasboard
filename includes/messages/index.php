<!-- <link rel="stylesheet" href="/marketing/marketing_toolv3/assets/style.css"> -->
<?php
// header("Location: {$_SERVER['PHP_SELF']}");
ini_set('display_errors', 0);
require("{$_SERVER['DOCUMENT_ROOT']}/config/pipeline-x.php");

// exit(header("Location: {$_SERVER['DOCUMENT_ROOT']}/config/pipeline-x.php"));

// require_once("/var/www/html/internal/activeaccount/model/main.php");
?>
<!--
<link rel="stylesheet" href="/marketing/marketing_toolv3/assets/css/semantic.min.css" type="text/css" />
<link rel="stylesheet" href="/marketing/marketing_toolv3/assets/components/icon.min.css" type="text/css" />
<link rel="stylesheet" href="/marketing/marketing_toolv3/assets/css/style.css?v=1.3" media="all" type="text/css" />
-->
<!-- <link rel="stylesheet" href="/framework/styles/callbox-ui-v2/assets/callbox-ui.3.0.css" media="all" type="text/css" /> -->

<link rel="stylesheet" href="/marketing/marketing_toolv3/assets/css/dataTables.semanticui.min.css" media="all" type="text/css" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Orbitron&display=swap">
<link rel="stylesheet" href="/framework/js/3rd-party/jquery/css/ui-smoothness/smoothness-v1-11-0.css">

<!-- <script src="../../includes/home/controller.js"></script> -->


<section ng-controller="homeCtrl as ctrl" style="margin-bottom: 1%;height: 5vh !important">
    <?php
    include("../../includes/header.php");
    include("../../includes/modal/contact_info.php");

    ?>

    <div class="subheader py-2 py-lg-6 subheader-solid" id="cb_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!-- begin::Info-->

            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <!--begin::Page Title-->
                <h5 class="text-dark font-weight-bold my-1 mr-5">Messages</h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item text-muted">
                        <a href="" class="text-muted">LinkIn Dashboard</a>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="" class="text-muted">Inbox</a>
                    </li>
                </ul>
                <!--end::Breadcrumb-->
            </div>

            <!-- end::Info-->
            <!-- begin::Toolbar-->
            <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                Launch demo modal
            </button> -->
            <!-- <div class="d-flex align-items-center">
                <button type="button" id="insertConnection" class="btn btn-primary btn-sm mr-2" ng-click="show_hide_div('#connection_modal');">Add New Persona</button>
            </div> -->
            <!-- end::Toolbar-->
        </div>
    </div>


    <!-- ng-init="show_hide_div('#connection_modal');" -->
    <div>
        <?php include("../../includes/modal/persona_info.php"); ?>
    </div>


    <div class="d-flex flex-column-fluid mt-30" ng-repeat="list in personaList">
        <!--begin::Container-->
        <!-- ng-if="list.contacts.length <= 0"  -->
        <div class="container-fluid mt-15" ng-if="!(list.contacts.length > 0)" align="center">
            <!--begin::Inbox-->
            <div class="row">
                <div class="col-md-12">
                    No Messages Found
                </div>
            </div>
        </div>
        <div class="container-fluid mt-15" ng-if="list.contacts.length > 0">
            <!--begin::Inbox-->
            <div class="row">
                <div class="col-md-12">

                    <div class="d-flex flex-row">
                        <!--begin::Aside-->
                        <div class="flex-row-auto offcanvas-mobile" id="kt_inbox_aside" style="width: 25% !important;">
                            <!--begin::Card-->
                            <div class="card card-custom card-stretch">
                                <!--begin::Body-->
                                <div class="card-body px-5">
                                    <!--begin::Compose-->
                                    <div class="px-4 mt-4 mb-10">
                                        <input data-toggle="search_person" class="form-control" ng-model="form.searchPerson" placeholder="Search Person..." />
                                    </div>
                                    <!--end::Compose-->
                                    <!--begin::Navigations-->
                                    <div class="navi navi-hover navi-active navi-link-rounded navi-bold navi-icon-center navi-light-icon" style="height: 50vh !important;overflow:hidden;overflow-y: scroll !important">
                                        <!--begin::Item-->
                                        <div class="navi-item my-2" ng-repeat="(k,v) in list.contacts | filter:{ contact_fullname: form.searchPerson }" id="view_msg" ng-click="view_messages(v)" ng-if="v.messages.length > 0">
                                            <a href="#" class="navi-link active">
                                                <span class="navi-icon mr-4">
                                                    <span class="svg-icon svg-icon-lg">
                                                        <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Communication/Mail-heart.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                                <path d="M6,2 L18,2 C18.5522847,2 19,2.44771525 19,3 L19,13 C19,13.5522847 18.5522847,14 18,14 L6,14 C5.44771525,14 5,13.5522847 5,13 L5,3 C5,2.44771525 5.44771525,2 6,2 Z M13.8,4 C13.1562,4 12.4033,4.72985286 12,5.2 C11.5967,4.72985286 10.8438,4 10.2,4 C9.0604,4 8.4,4.88887193 8.4,6.02016349 C8.4,7.27338783 9.6,8.6 12,10 C14.4,8.6 15.6,7.3 15.6,6.1 C15.6,4.96870845 14.9396,4 13.8,4 Z" fill="#000000" opacity="0.3"></path>
                                                                <path d="M3.79274528,6.57253826 L12,12.5 L20.2072547,6.57253826 C20.4311176,6.4108595 20.7436609,6.46126971 20.9053396,6.68513259 C20.9668779,6.77033951 21,6.87277228 21,6.97787787 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,6.97787787 C3,6.70173549 3.22385763,6.47787787 3.5,6.47787787 C3.60510559,6.47787787 3.70753836,6.51099993 3.79274528,6.57253826 Z" fill="#000000"></path>
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text font-weight-bolder font-size-lg">{{v.first_name}}&nbsp;{{v.last_name}}</span>
                                                <span class="navi-label">
                                                    <span class="label label-rounded label-light-success font-weight-bolder">{{v.messages.length}}</span>
                                                </span>
                                            </a>
                                        </div>
                                        <!--end::Item-->
                                    </div>
                                    <!--end::Navigations-->
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Card-->
                        </div>
                        <!--end::Aside-->
                        <!--begin::List-->
                        <div class="flex-row-fluid ml-lg-8 d-block" id="kt_inbox_list">
                            <!--begin::Card-->
                            <div class="card card-custom card-stretch">
                                <!--begin::Header-->
                                <div class="card-header row row-marginless align-items-center flex-wrap py-5 h-auto">
                                    <!--begin::Toolbar-->
                                    <div class="col-12 col-sm-6 col-xxl-4 order-2 order-xxl-1 d-flex flex-wrap align-items-center">
                                        <div class="d-flex align-items-center mr-1 my-2">
                                            <label data-inbox="group-select" class="checkbox checkbox-inline checkbox-primary mr-3">
                                                <input type="checkbox">
                                                <span class="symbol-label"></span>
                                            </label>
                                            <div class="dropdown">
                                                <span class="btn btn-clean btn-icon btn-sm mr-1" data-toggle="dropdown">
                                                    <i class="ki ki-bold-arrow-down icon-sm"></i>
                                                </span>
                                                <div class="dropdown-menu dropdown-menu-left p-0 m-0 dropdown-menu-sm">
                                                    <ul class="navi py-3">
                                                        <li class="navi-item">
                                                            <a href="#" class="navi-link">
                                                                <span class="navi-text" ng-click="filterMsgType = ''">All</span>
                                                            </a>
                                                        </li>
                                                        <li class="navi-item">
                                                            <a href="#" class="navi-link">
                                                                <span class="navi-text" ng-click="filterMsgType = 'Full Convo'">Full Convo</span>
                                                            </a>
                                                        </li>
                                                        <li class="navi-item">
                                                            <a href="#" class="navi-link">
                                                                <span class="navi-text" ng-click="filterMsgType = 'Direct Message Sent'">Direct Message Sent</span>
                                                            </a>
                                                        </li>
                                                        <li class="navi-item">
                                                            <a href="#" class="navi-link">
                                                                <span class="navi-text" ng-click="filterMsgType = 'Replied Msg'">Replied Message</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <span class="btn btn-clean btn-icon btn-sm mr-2" data-toggle="tooltip" title="" data-original-title="Reload list">
                                                <i class="ki ki-refresh icon-1x"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <!--end::Toolbar-->
                                    <!--begin::Search-->
                                    <div class="col-xxl-3 d-flex order-1 order-xxl-2 align-items-center justify-content-center">
                                        <div class="input-group input-group-lg input-group-solid my-2">
                                            <input type="text" class="form-control pl-4" ng-model="form.searchInbox" placeholder="Search...">
                                            <div class="input-group-append">
                                                <span class="input-group-text pr-3">
                                                    <span class="svg-icon svg-icon-lg">
                                                        <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/General/Search.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                                <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                                                <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"></path>
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Search-->
                                    <!--begin::Pagination-->
                                    <div class="col-12 col-sm-6 col-xxl-4 order-2 order-xxl-3 d-flex align-items-center justify-content-sm-end text-right my-2">
                                        <!--begin::Per Page Dropdown-->
                                        <!-- <div class="d-flex align-items-center mr-2" data-toggle="tooltip" title="" data-original-title="Records per page">
                                            <span class="text-muted font-weight-bold mr-2" data-toggle="dropdown">1 - 50 of 235</span>
                                            <div class="dropdown-menu dropdown-menu-right p-0 m-0 dropdown-menu-sm">
                                                <ul class="navi py-3">
                                                    <li class="navi-item">
                                                        <a href="#" class="navi-link">
                                                            <span class="navi-text">20 per page</span>
                                                        </a>
                                                    </li>
                                                    <li class="navi-item">
                                                        <a href="#" class="navi-link active">
                                                            <span class="navi-text">50 par page</span>
                                                        </a>
                                                    </li>
                                                    <li class="navi-item">
                                                        <a href="#" class="navi-link">
                                                            <span class="navi-text">100 per page</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div> -->
                                        <!--end::Per Page Dropdown-->
                                        <!--begin::Arrow Buttons-->
                                        <!-- <span class="btn btn-default btn-icon btn-sm mr-2" data-toggle="tooltip" title="" data-original-title="Previose page">
                                            <i class="ki ki-bold-arrow-back icon-sm"></i>
                                        </span>
                                        <span class="btn btn-default btn-icon btn-sm mr-2" data-toggle="tooltip" title="" data-original-title="Next page">
                                            <i class="ki ki-bold-arrow-next icon-sm"></i>
                                        </span> -->
                                        <!--end::Arrow Buttons-->
                                        <!--begin::Sort Dropdown-->
                                        <div class="dropdown mr-2" data-toggle="tooltip" title="" data-original-title="Sort">
                                            <span class="btn btn-default btn-icon btn-sm" data-toggle="dropdown">
                                                <i class="flaticon2-console icon-1x"></i>
                                            </span>
                                            <div class="dropdown-menu dropdown-menu-right p-0 m-0 dropdown-menu-sm">
                                                <ul class="navi py-3">
                                                    <li class="navi-item">
                                                        <a href="#" class="navi-link">
                                                            <span class="navi-text" ng-click="order_by = '-send_date'">Default</span>
                                                        </a>
                                                    </li>
                                                    <li class="navi-item">
                                                        <a href="#" class="navi-link">
                                                            <span class="navi-text" ng-click="order_by = '-send_date'">Newest</span>
                                                        </a>
                                                    </li>
                                                    <li class="navi-item">
                                                        <a href="#" class="navi-link">
                                                            <span class="navi-text" ng-click="order_by = 'send_date'">Olders</span>
                                                        </a>
                                                    </li>
                                                    <!-- <li class="navi-item">
                                                        <a href="#" class="navi-link">
                                                            <span class="navi-text">Unread</span>
                                                        </a>
                                                    </li> -->
                                                </ul>
                                            </div>
                                        </div>
                                        <!--end::Sort Dropdown-->
                                    </div>
                                    <!--end::Pagination-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Body-->
                                <div class="card-body table-responsive px-0" ng-repeat="(k,v) in message_info" style="height: 50vh !important;">

                                    <!--begin::Items-->
                                    <div class="list list-hover min-w-500px" data-inbox="list">
                                        <!--begin::Item-->
                                        <div class="d-flex align-items-start list-item card-spacer-x py-3" data-inbox="message" ng-repeat="(k1,v1) in v.messages | filter: form.searchInbox | filter: {msg_type: filterMsgType } | orderBy: order_by">
                                            <!--begin::container-->
                                            <!-- ng-if="v1.msg_type == 'Direct Message Sent' || v1.msg_type == 'Replied Msg'" -->
                                            <div class="d-flex align-items-start list-item card-spacer-x py-3" style="width: 100% !important">
                                                <!--begin::Toolbar-->
                                                <div class="d-flex align-items-center" style="width: 60% !important;">
                                                    <!--begin::Author-->
                                                    <div class="d-flex align-items-center flex-wrap w-xxl mr-3" data-toggle="view">
                                                        <div class="symbol symbol-light-danger symbol-35 mr-3">
                                                            <!-- <span class="symbol-label font-weight-bolder" ng-if="v1.msg_type == 'Replied Msg'">Reply</span>
                                                            <span class="symbol-label font-weight-bolder" ng-if="v1.msg_type == 'Direct Message Sent'">Direct<Br>Message<br>Sent</span>
                                                            <span class="symbol-label font-weight-bolder" ng-if="v1.msg_type == 'Full Convo'">Full<br>Convo</span> -->
                                                            <div ng-if="v1.msg_type == 'Direct Message Sent'" align="center">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                                                                    <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z" />
                                                                </svg>
                                                                {{v.my_fullname}}
                                                                <!-- Direct<Br>Message<br>Sent -->
                                                            </div>
                                                            <div ng-if="v1.msg_type == 'Full Convo'" align="center">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-dots" viewBox="0 0 16 16">
                                                                    <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                                                                    <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9.06 9.06 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.437 10.437 0 0 1-.524 2.318l-.003.011a10.722 10.722 0 0 1-.244.637c-.079.186.074.394.273.362a21.673 21.673 0 0 0 .693-.125zm.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6c0 3.193-3.004 6-7 6a8.06 8.06 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a10.97 10.97 0 0 0 .398-2z" />
                                                                </svg>
                                                                {{v.my_fullname}}

                                                                <!-- Full<br>Convo -->
                                                            </div>
                                                            <div ng-if="v1.msg_type == 'Replied Msg'" align="center">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-reply" viewBox="0 0 16 16">
                                                                    <path d="M6.598 5.013a.144.144 0 0 1 .202.134V6.3a.5.5 0 0 0 .5.5c.667 0 2.013.005 3.3.822.984.624 1.99 1.76 2.595 3.876-1.02-.983-2.185-1.516-3.205-1.799a8.74 8.74 0 0 0-1.921-.306 7.404 7.404 0 0 0-.798.008h-.013l-.005.001h-.001L7.3 9.9l-.05-.498a.5.5 0 0 0-.45.498v1.153c0 .108-.11.176-.202.134L2.614 8.254a.503.503 0 0 0-.042-.028.147.147 0 0 1 0-.252.499.499 0 0 0 .042-.028l3.984-2.933zM7.8 10.386c.068 0 .143.003.223.006.434.02 1.034.086 1.7.271 1.326.368 2.896 1.202 3.94 3.08a.5.5 0 0 0 .933-.305c-.464-3.71-1.886-5.662-3.46-6.66-1.245-.79-2.527-.942-3.336-.971v-.66a1.144 1.144 0 0 0-1.767-.96l-3.994 2.94a1.147 1.147 0 0 0 0 1.946l3.994 2.94a1.144 1.144 0 0 0 1.767-.96v-.667z" />
                                                                </svg>
                                                                {{v.first_name}}&nbsp;{{v.last_name}}
                                                                <!-- Reply -->
                                                            </div>
                                                        </div>
                                                        <!-- <a href="" class="font-weight-bold text-dark-75 text-hover-primary" style="width: auto !important" ng-if="v1.msg_type == 'Full Convo'">{{v.my_fullname}}</a>
                                                        <a href="" class="font-weight-bold text-dark-75 text-hover-primary" style="width: auto !important" ng-if="v1.msg_type == 'Direct Message Sent'">{{v.my_fullname}}</a>
                                                        <a href="" class="font-weight-bold text-dark-75 text-hover-primary" style="width: auto !important" ng-if="v1.msg_type == 'Replied Msg'">{{v.first_name}}&nbsp;{{v.last_name}}</a> -->
                                                    </div>
                                                    <!--end::Author-->
                                                </div>
                                                <!--end::Toolbar-->

                                                <!--begin::Info-->
                                                <div class="flex-grow-1 mt-2 mr-2" style="width: 80% !important;" data-toggle="view" ng-if="v1.msg_type == 'Direct Message Sent'">
                                                    <div>
                                                        <span class="font-weight-bolder font-size-lg mr-2">{{v.first_name}}&nbsp;{{v.last_name}}</span><br>
                                                        <span class="text-muted" ng-bind-html="v1.message_text | highlight:form.searchInbox"></span>
                                                        <!-- {{v1.message_text}} -->
                                                    </div>
                                                </div>
                                                <!--end::Info-->
                                                <!--begin::Info-->
                                                <div class="flex-grow-1 mt-2 mr-2" style="width: 80% !important;" data-toggle="view" ng-if="v1.msg_type == 'Replied Msg'">
                                                    <div>
                                                        <span class="font-weight-bolder font-size-lg mr-2">{{v.my_fullname}}</span><br>
                                                        <span class="text-muted" style="width: 100%  !important;" ng-bind-html="v1.message_text | highlight:form.searchInbox"></span>
                                                        <!-- {{v1.message_text}} -->
                                                    </div>
                                                </div>
                                                <!--end::Info-->
                                                <!--begin::Info-->
                                                <div class="flex-grow-1 mt-2 mr-2" style="width: 80% !important;" data-toggle="view" ng-if="v1.msg_type == 'Full Convo'">
                                                    <div>
                                                        <span class="font-weight-bolder font-size-lg mr-2">{{v.my_fullname}}</span><br>
                                                        <span class="text-muted" style="width: 100%  !important;" ng-bind-html="v1.message_text | highlight:form.searchInbox"></span>
                                                        <!-- {{v1.message_text}} -->
                                                    </div>
                                                </div>
                                                <!--end::Info-->
                                                <!--begin::Datetime-->
                                                <div class="mt-2 mr-3 font-weight-bolder text-right" style="width: 80% !important;" data-toggle="view">{{v1.send_date}}</div>
                                                <!--end::Datetime-->
                                            </div>
                                            <!--end::container-->


                                        </div>
                                        <!--end::Item-->

                                    </div>
                                    <!--end::Items-->
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Card-->
                        </div>
                        <!--end::List-->
                        <!--begin::View-->
                        <div class="flex-row-fluid ml-lg-8 d-none" id="kt_inbox_view">
                            <!--begin::Card-->
                            <div class="card card-custom card-stretch">
                                <!--begin::Header-->
                                <div class="card-header align-items-center flex-wrap justify-content-between py-5 h-auto">
                                    <!--begin::Left-->
                                    <div class="d-flex align-items-center my-2">
                                        <a href="#" class="btn btn-clean btn-icon btn-sm mr-6" data-inbox="back">
                                            <i class="flaticon2-left-arrow-1"></i>
                                        </a>
                                        <span class="btn btn-default btn-icon btn-sm mr-2" data-toggle="tooltip" title="" data-original-title="Archive">
                                            <span class="svg-icon svg-icon-md">
                                                <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Communication/Mail-opened.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                        <path d="M6,2 L18,2 C18.5522847,2 19,2.44771525 19,3 L19,12 C19,12.5522847 18.5522847,13 18,13 L6,13 C5.44771525,13 5,12.5522847 5,12 L5,3 C5,2.44771525 5.44771525,2 6,2 Z M7.5,5 C7.22385763,5 7,5.22385763 7,5.5 C7,5.77614237 7.22385763,6 7.5,6 L13.5,6 C13.7761424,6 14,5.77614237 14,5.5 C14,5.22385763 13.7761424,5 13.5,5 L7.5,5 Z M7.5,7 C7.22385763,7 7,7.22385763 7,7.5 C7,7.77614237 7.22385763,8 7.5,8 L10.5,8 C10.7761424,8 11,7.77614237 11,7.5 C11,7.22385763 10.7761424,7 10.5,7 L7.5,7 Z" fill="#000000" opacity="0.3"></path>
                                                        <path d="M3.79274528,6.57253826 L12,12.5 L20.2072547,6.57253826 C20.4311176,6.4108595 20.7436609,6.46126971 20.9053396,6.68513259 C20.9668779,6.77033951 21,6.87277228 21,6.97787787 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,6.97787787 C3,6.70173549 3.22385763,6.47787787 3.5,6.47787787 C3.60510559,6.47787787 3.70753836,6.51099993 3.79274528,6.57253826 Z" fill="#000000"></path>
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                        <span class="btn btn-default btn-icon btn-sm mr-2" data-toggle="tooltip" title="" data-original-title="Spam">
                                            <span class="svg-icon svg-icon-md">
                                                <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Code/Warning-1-circle.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                        <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"></circle>
                                                        <rect fill="#000000" x="11" y="7" width="2" height="8" rx="1"></rect>
                                                        <rect fill="#000000" x="11" y="16" width="2" height="2" rx="1"></rect>
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                        <span class="btn btn-default btn-icon btn-sm mr-2" data-toggle="tooltip" title="" data-original-title="Delete">
                                            <span class="svg-icon svg-icon-md">
                                                <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/General/Trash.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                        <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path>
                                                        <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path>
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                        <span class="btn btn-default btn-icon btn-sm mr-2" data-toggle="tooltip" title="" data-original-title="Mark as read">
                                            <span class="svg-icon svg-icon-md">
                                                <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/General/Duplicate.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                        <path d="M15.9956071,6 L9,6 C7.34314575,6 6,7.34314575 6,9 L6,15.9956071 C4.70185442,15.9316381 4,15.1706419 4,13.8181818 L4,6.18181818 C4,4.76751186 4.76751186,4 6.18181818,4 L13.8181818,4 C15.1706419,4 15.9316381,4.70185442 15.9956071,6 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                                        <path d="M10.1818182,8 L17.8181818,8 C19.2324881,8 20,8.76751186 20,10.1818182 L20,17.8181818 C20,19.2324881 19.2324881,20 17.8181818,20 L10.1818182,20 C8.76751186,20 8,19.2324881 8,17.8181818 L8,10.1818182 C8,8.76751186 8.76751186,8 10.1818182,8 Z" fill="#000000"></path>
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                        <span class="btn btn-default btn-icon btn-sm mr-2" data-toggle="tooltip" title="" data-original-title="Move">
                                            <span class="svg-icon svg-icon-md">
                                                <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Files/Media-folder.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                        <path d="M3.5,21 L20.5,21 C21.3284271,21 22,20.3284271 22,19.5 L22,8.5 C22,7.67157288 21.3284271,7 20.5,7 L10,7 L7.43933983,4.43933983 C7.15803526,4.15803526 6.77650439,4 6.37867966,4 L3.5,4 C2.67157288,4 2,4.67157288 2,5.5 L2,19.5 C2,20.3284271 2.67157288,21 3.5,21 Z" fill="#000000" opacity="0.3"></path>
                                                        <path d="M10.782158,17.5100514 L15.1856088,14.5000448 C15.4135806,14.3442132 15.4720618,14.0330791 15.3162302,13.8051073 C15.2814587,13.7542388 15.2375842,13.7102355 15.1868178,13.6753149 L10.783367,10.6463273 C10.5558531,10.489828 10.2445489,10.5473967 10.0880496,10.7749107 C10.0307022,10.8582806 10,10.9570884 10,11.0582777 L10,17.097272 C10,17.3734143 10.2238576,17.597272 10.5,17.597272 C10.6006894,17.597272 10.699033,17.566872 10.782158,17.5100514 Z" fill="#000000"></path>
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                    </div>
                                    <!--end::Left-->
                                    <!--begin::Right-->
                                    <div class="d-flex align-items-center justify-content-end text-right my-2">
                                        <span class="text-muted font-weight-bold mr-4" data-toggle="dropdown">1 - 50 of 235</span>
                                        <span class="btn btn-default btn-icon btn-sm mr-2" data-toggle="tooltip" title="" data-original-title="Previose message">
                                            <i class="ki ki-bold-arrow-back icon-sm"></i>
                                        </span>
                                        <span class="btn btn-default btn-icon btn-sm mr-2" data-toggle="tooltip" title="" data-original-title="Next message">
                                            <i class="ki ki-bold-arrow-next icon-sm"></i>
                                        </span>
                                        <div class="dropdown" data-toggle="tooltip" title="" data-original-title="Settings">
                                            <span class="btn btn-default btn-icon btn-sm" data-toggle="dropdown">
                                                <i class="ki ki-bold-more-hor icon-1x"></i>
                                            </span>
                                            <div class="dropdown-menu dropdown-menu-right p-0 m-0 dropdown-menu-md">
                                                <!--begin::Navigation-->
                                                <ul class="navi navi-hover py-5">
                                                    <li class="navi-item">
                                                        <a href="#" class="navi-link">
                                                            <span class="navi-icon">
                                                                <i class="flaticon2-drop"></i>
                                                            </span>
                                                            <span class="navi-text">New Group</span>
                                                        </a>
                                                    </li>
                                                    <li class="navi-item">
                                                        <a href="#" class="navi-link">
                                                            <span class="navi-icon">
                                                                <i class="flaticon2-list-3"></i>
                                                            </span>
                                                            <span class="navi-text">Contacts</span>
                                                        </a>
                                                    </li>
                                                    <li class="navi-item">
                                                        <a href="#" class="navi-link">
                                                            <span class="navi-icon">
                                                                <i class="flaticon2-rocket-1"></i>
                                                            </span>
                                                            <span class="navi-text">Groups</span>
                                                            <span class="navi-link-badge">
                                                                <span class="label label-light-primary label-inline font-weight-bold">new</span>
                                                            </span>
                                                        </a>
                                                    </li>
                                                    <li class="navi-item">
                                                        <a href="#" class="navi-link">
                                                            <span class="navi-icon">
                                                                <i class="flaticon2-bell-2"></i>
                                                            </span>
                                                            <span class="navi-text">Calls</span>
                                                        </a>
                                                    </li>
                                                    <li class="navi-item">
                                                        <a href="#" class="navi-link">
                                                            <span class="navi-icon">
                                                                <i class="flaticon2-gear"></i>
                                                            </span>
                                                            <span class="navi-text">Settings</span>
                                                        </a>
                                                    </li>
                                                    <li class="navi-separator my-3"></li>
                                                    <li class="navi-item">
                                                        <a href="#" class="navi-link">
                                                            <span class="navi-icon">
                                                                <i class="flaticon2-magnifier-tool"></i>
                                                            </span>
                                                            <span class="navi-text">Help</span>
                                                        </a>
                                                    </li>
                                                    <li class="navi-item">
                                                        <a href="#" class="navi-link">
                                                            <span class="navi-icon">
                                                                <i class="flaticon2-bell-2"></i>
                                                            </span>
                                                            <span class="navi-text">Privacy</span>
                                                            <span class="navi-link-badge">
                                                                <span class="label label-light-danger label-rounded font-weight-bold">5</span>
                                                            </span>
                                                        </a>
                                                    </li>
                                                </ul>
                                                <!--end::Navigation-->
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Right-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Body-->
                                <div class="card-body p-0">
                                    <!--begin::Header-->
                                    <div class="d-flex align-items-center justify-content-between flex-wrap card-spacer-x py-5">
                                        <!--begin::Title-->
                                        <div class="d-flex align-items-center mr-2 py-2">
                                            <div class="font-weight-bold font-size-h3 mr-3">Trip Reminder. Thank you for flying with us!</div>
                                            <span class="label label-light-primary font-weight-bold label-inline mr-2">inbox</span>
                                            <span class="label label-light-danger font-weight-bold label-inline">important</span>
                                        </div>
                                        <!--end::Title-->
                                        <!--begin::Toolbar-->
                                        <div class="d-flex py-2">
                                            <span class="btn btn-default btn-sm btn-icon mr-2">
                                                <i class="flaticon2-sort"></i>
                                            </span>
                                            <span class="btn btn-default btn-sm btn-icon" data-dismiss="modal">
                                                <i class="flaticon2-fax"></i>
                                            </span>
                                        </div>
                                        <!--end::Toolbar-->
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Messages-->
                                    <div class="mb-3">
                                        <div class="cursor-pointer shadow-xs toggle-on" data-inbox="message">
                                            <!--begin::Message Heading-->
                                            <div class="d-flex card-spacer-x py-6 flex-column flex-md-row flex-lg-column flex-xxl-row justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <span class="symbol symbol-50 mr-4">
                                                        <span class="symbol-label" style="background-image: url('/metronic/theme/html/demo1/dist/assets/media/users/100_13.jpg')"></span>
                                                    </span>
                                                    <div class="d-flex flex-column flex-grow-1 flex-wrap mr-2">
                                                        <div class="d-flex">
                                                            <a href="#" class="font-size-lg font-weight-bolder text-dark-75 text-hover-primary mr-2">Chris Muller</a>
                                                            <div class="font-weight-bold text-muted">
                                                                <span class="label label-success label-dot mr-2"></span>1 Day ago
                                                            </div>
                                                        </div>
                                                        <div class="d-flex flex-column">
                                                            <div class="toggle-off-item">
                                                                <span class="font-weight-bold text-muted cursor-pointer" data-toggle="dropdown">to me
                                                                    <i class="flaticon2-down icon-xs ml-1 text-dark-50"></i></span>
                                                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left p-5">
                                                                    <table>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="text-muted min-w-75px py-2">From</td>
                                                                                <td>Mark Andre</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-muted py-2">Date:</td>
                                                                                <td>Jul 30, 2019, 11:27 PM</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-muted py-2">Subject:</td>
                                                                                <td>Trip Reminder. Thank you for flying with us!</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-muted py-2">Reply to:</td>
                                                                                <td>mark.andre@gmail.com</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="text-muted font-weight-bold toggle-on-item" data-inbox="toggle">With resrpect, i must disagree with Mr.Zinsser. We all know the most part of important part....</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex my-2 my-xxl-0 align-items-md-center align-items-lg-start align-items-xxl-center flex-column flex-md-row flex-lg-column flex-xxl-row">
                                                    <div class="font-weight-bold text-muted mx-2">Jul 15, 2019, 11:19AM</div>
                                                    <div class="d-flex align-items-center flex-wrap flex-xxl-nowrap" data-inbox="toolbar">
                                                        <span class="btn btn-clean btn-sm btn-icon mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Star">
                                                            <i class="flaticon-star icon-1x"></i>
                                                        </span>
                                                        <span class="btn btn-clean btn-sm btn-icon mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Mark as important">
                                                            <i class="flaticon-add-label-button icon-1x"></i>
                                                        </span>
                                                        <span class="btn btn-clean btn-sm btn-icon mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Reply">
                                                            <i class="flaticon2-reply-1 icon-1x"></i>
                                                        </span>
                                                        <span class="btn btn-clean btn-sm btn-icon" data-toggle="tooltip" data-placement="top" title="" data-original-title="Settings">
                                                            <i class="flaticon-more icon-1x"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Message Heading-->
                                            <div class="card-spacer-x py-3 toggle-off-item">
                                                <p>Hi Bob,</p>
                                                <p>With resrpect, i must disagree with Mr.Zinsser. We all know the most part of important part of any article is the title.Without a compelleing title, your reader won't even get to the first sentence.After the title, however, the first few sentences of your article are certainly the most important part.</p>
                                                <p>Jornalists call this critical, introductory section the "Lede," and when bridge properly executed, it's the that carries your reader from an headine try at attention-grabbing to the body of your blog post, if you want to get it right on of these 10 clever ways to omen your next blog posr with a bang</p>
                                                <p>Best regards,</p>
                                                <p>Jason Muller</p>
                                            </div>
                                        </div>
                                        <div class="cursor-pointer shadow-xs toggle-off" data-inbox="message">
                                            <!--begin::Message Heading-->
                                            <div class="d-flex card-spacer-x py-6 flex-column flex-md-row flex-lg-column flex-xxl-row justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <span class="symbol symbol-50 mr-4" data-toggle="expand">
                                                        <span class="symbol-label" style="background-image: url('/metronic/theme/html/demo1/dist/assets/media/users/100_11.jpg')"></span>
                                                    </span>
                                                    <div class="d-flex flex-column flex-grow-1 flex-wrap mr-2">
                                                        <div class="d-flex" data-toggle="expand">
                                                            <a href="#" class="font-size-lg font-weight-bolder text-dark-75 text-hover-primary mr-2">Lina Nilson</a>
                                                            <div class="font-weight-bold text-muted">
                                                                <span class="label label-success label-dot mr-2"></span>2 Day ago
                                                            </div>
                                                        </div>
                                                        <div class="d-flex flex-column">
                                                            <div class="toggle-off-item">
                                                                <span class="font-weight-bold text-muted cursor-pointer" data-toggle="dropdown">to me
                                                                    <i class="flaticon2-down icon-xs ml-1 text-dark-50"></i></span>
                                                                <div class="dropdown-menu dropdown-menu-md dropdown-menu-left p-5">
                                                                    <table>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="text-muted w-75px py-2">From</td>
                                                                                <td>Mark Andre</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-muted py-2">Date:</td>
                                                                                <td>Jul 30, 2019, 11:27 PM</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-muted py-2">Subject:</td>
                                                                                <td>Trip Reminder. Thank you for flying with us!</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-muted py-2">Reply to:</td>
                                                                                <td>mark.andre@gmail.com</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="text-muted font-weight-bold toggle-on-item" data-toggle="expand">Jornalists call this critical, introductory section the "Lede," and when bridge properly executed....</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex my-2 my-xxl-0 align-items-md-center align-items-lg-start align-items-xxl-center flex-column flex-md-row flex-lg-column flex-xxl-row">
                                                    <div class="font-weight-bold text-muted mx-2" data-toggle="expand">Jul 20, 2019, 03:20PM</div>
                                                    <div class="d-flex align-items-center flex-wrap flex-xxl-nowrap">
                                                        <span class="btn btn-clean btn-sm btn-icon mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Star">
                                                            <i class="flaticon-star icon-1x text-warning"></i>
                                                        </span>
                                                        <span class="btn btn-clean btn-sm btn-icon mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Mark as important">
                                                            <i class="flaticon-add-label-button icon-1x"></i>
                                                        </span>
                                                        <span class="btn btn-clean btn-sm btn-icon mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Reply">
                                                            <i class="flaticon2-reply-1 icon-1x"></i>
                                                        </span>
                                                        <span class="btn btn-clean btn-sm btn-icon" data-toggle="tooltip" data-placement="top" title="" data-original-title="Settings">
                                                            <i class="flaticon-more icon-1x"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Message Heading-->
                                            <div class="card-spacer-x py-3 toggle-off-item">
                                                <p>Hi Bob,</p>
                                                <p>With resrpect, i must disagree with Mr.Zinsser. We all know the most part of important part of any article is the title.Without a compelleing title, your reader won't even get to the first sentence.After the title, however, the first few sentences of your article are certainly the most important part.</p>
                                                <p>Jornalists call this critical, introductory section the "Lede," and when bridge properly executed, it's the that carries your reader from an headine try at attention-grabbing to the body of your blog post, if you want to get it right on of these 10 clever ways to omen your next blog posr with a bang</p>
                                                <p>Best regards,</p>
                                                <p>Jason Muller</p>
                                            </div>
                                        </div>
                                        <div class="cursor-pointer shadow-xs toggle-off" data-inbox="message">
                                            <!--begin::Message Heading-->
                                            <div class="d-flex card-spacer-x py-6 flex-column flex-md-row flex-lg-column flex-xxl-row justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <span class="symbol symbol-50 mr-4" data-toggle="expand">
                                                        <span class="symbol-label" style="background-image: url('/metronic/theme/html/demo1/dist/assets/media/users/100_14.jpg')"></span>
                                                    </span>
                                                    <div class="d-flex flex-column flex-grow-1 flex-wrap mr-2">
                                                        <div class="d-flex" data-toggle="expand">
                                                            <a href="#" class="font-size-lg font-weight-bolder text-dark-75 text-hover-primary mr-2">Sean Stone</a>
                                                            <div class="font-weight-bold text-muted">
                                                                <span class="label label-success label-dot mr-2"></span>1 Day ago
                                                            </div>
                                                        </div>
                                                        <div class="d-flex flex-column">
                                                            <div class="toggle-off-item">
                                                                <span class="font-weight-bold text-muted cursor-pointer" data-toggle="dropdown">to me
                                                                    <i class="flaticon2-down icon-xs ml-1 text-dark-50"></i></span>
                                                                <div class="dropdown-menu dropdown-menu-md dropdown-menu-left p-5">
                                                                    <table>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="text-muted w-75px py-2">From</td>
                                                                                <td>Mark Andre</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-muted py-2">Date:</td>
                                                                                <td>Jul 30, 2019, 11:27 PM</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-muted py-2">Subject:</td>
                                                                                <td>Trip Reminder. Thank you for flying with us!</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-muted py-2">Reply to:</td>
                                                                                <td>mark.andre@gmail.com</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="text-muted font-weight-bold toggle-on-item" data-toggle="expand">With resrpect, i must disagree with Mr.Zinsser. We all know the most part of important part....</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex my-2 my-xxl-0 align-items-md-center align-items-lg-start align-items-xxl-center flex-column flex-md-row flex-lg-column flex-xxl-row">
                                                    <div class="font-weight-bold text-muted mx-2" data-toggle="expand">Jul 15, 2019, 11:19AM</div>
                                                    <div class="d-flex align-items-center flex-wrap flex-xxl-nowrap">
                                                        <span class="btn btn-clean btn-sm btn-icon mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Star">
                                                            <i class="flaticon-star icon-1x"></i>
                                                        </span>
                                                        <span class="btn btn-clean btn-sm btn-icon mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Mark as important">
                                                            <i class="flaticon-add-label-button icon-1x"></i>
                                                        </span>
                                                        <span class="btn btn-clean btn-sm btn-icon mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Reply">
                                                            <i class="flaticon2-reply-1 icon-1x"></i>
                                                        </span>
                                                        <span class="btn btn-clean btn-sm btn-icon" data-toggle="tooltip" data-placement="top" title="" data-original-title="Settings">
                                                            <i class="flaticon-more icon-1x"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Message Heading-->
                                            <div class="card-spacer-x py-3 toggle-off-item">
                                                <p>Hi Bob,</p>
                                                <p>With resrpect, i must disagree with Mr.Zinsser. We all know the most part of important part of any article is the title.Without a compelleing title, your reader won't even get to the first sentence.After the title, however, the first few sentences of your article are certainly the most important part.</p>
                                                <p>Jornalists call this critical, introductory section the "Lede," and when bridge properly executed, it's the that carries your reader from an headine try at attention-grabbing to the body of your blog post, if you want to get it right on of these 10 clever ways to omen your next blog posr with a bang</p>
                                                <p>Best regards,</p>
                                                <p>Jason Muller</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Messages-->
                                    <!--begin::Reply-->
                                    <div class="card-spacer mb-3" id="kt_inbox_reply">
                                        <div class="card card-custom shadow-sm">
                                            <div class="card-body p-0">
                                                <!--begin::Form-->
                                                <form id="kt_inbox_reply_form">
                                                    <!--begin::Body-->
                                                    <div class="d-block">
                                                        <!--begin::To-->
                                                        <div class="d-flex align-items-center border-bottom inbox-to px-8 min-h-50px">
                                                            <div class="text-dark-50 w-75px">To:</div>
                                                            <div class="d-flex align-items-center flex-grow-1">
                                                                <tags class="tagify form-control border-0" tabindex="-1">
                                                                    <tag title="Chris Muller" spellcheck="false" tabindex="-1" class="tagify__tag tagify__tag--primary tagify--noAnim" __isvalid="true" pic="./assets/media/users/100_11.jpg" initialsstate="" initials="" email="chris.muller@wix.com" value="Chris Muller" contenteditable="false">
                                                                        <x title="" class="tagify__tag__removeBtn" role="button" aria-label="remove tag"></x>
                                                                        <div><span class="tagify__tag-text">Chris Muller</span></div>
                                                                    </tag>
                                                                    <tag title="Lina Nilson" spellcheck="false" tabindex="-1" class="tagify__tag tagify__tag--primary tagify--noAnim" __isvalid="true" pic="./assets/media/users/100_15.jpg" initialsstate="danger" initials="LN" email="lina.nilson@loop.com" value="Lina Nilson" contenteditable="false">
                                                                        <x title="" class="tagify__tag__removeBtn" role="button" aria-label="remove tag"></x>
                                                                        <div><span class="tagify__tag-text">Lina Nilson</span></div>
                                                                    </tag><span data-placeholder="​" aria-placeholder="" class="tagify__input" role="textbox" aria-autocomplete="both" aria-multiline="false" contenteditable=""></span>
                                                                </tags><input type="text" class="form-control border-0" name="compose_to" value="Chris Muller, Lina Nilson">
                                                            </div>
                                                            <div class="ml-2">
                                                                <span class="text-muted font-weight-bold cursor-pointer text-hover-primary mr-2" data-inbox="cc-show">Cc</span>
                                                                <span class="text-muted font-weight-bold cursor-pointer text-hover-primary" data-inbox="bcc-show">Bcc</span>
                                                            </div>
                                                        </div>
                                                        <!--end::To-->
                                                        <!--begin::CC-->
                                                        <div class="d-none align-items-center border-bottom inbox-to-cc pl-8 pr-5 min-h-50px">
                                                            <div class="text-dark-50 w-75px">Cc:</div>
                                                            <div class="flex-grow-1">
                                                                <tags class="tagify form-control border-0 tagify--noTags tagify--empty" tabindex="-1">
                                                                    <span data-placeholder="​" aria-placeholder="" class="tagify__input" role="textbox" aria-autocomplete="both" aria-multiline="false" contenteditable=""></span>
                                                                </tags><input type="text" class="form-control border-0" name="compose_cc" value="">
                                                            </div>
                                                            <span class="btn btn-clean btn-xs btn-icon" data-inbox="cc-hide">
                                                                <i class="la la-close"></i>
                                                            </span>
                                                        </div>
                                                        <!--end::CC-->
                                                        <!--begin::BCC-->
                                                        <div class="d-none align-items-center border-bottom inbox-to-bcc pl-8 pr-5 min-h-50px">
                                                            <div class="text-dark-50 w-75px">Bcc:</div>
                                                            <div class="flex-grow-1">
                                                                <tags class="tagify form-control border-0 tagify--noTags tagify--empty" tabindex="-1">
                                                                    <span data-placeholder="​" aria-placeholder="" class="tagify__input" role="textbox" aria-autocomplete="both" aria-multiline="false" contenteditable=""></span>
                                                                </tags><input type="text" class="form-control border-0" name="compose_bcc" value="">
                                                            </div>
                                                            <span class="btn btn-clean btn-xs btn-icon" data-inbox="bcc-hide">
                                                                <i class="la la-close"></i>
                                                            </span>
                                                        </div>
                                                        <!--end::BCC-->
                                                        <!--begin::Subject-->
                                                        <div class="border-bottom">
                                                            <input class="form-control border-0 px-8 min-h-45px" name="compose_subject" placeholder="Subject">
                                                        </div>
                                                        <!--end::Subject-->
                                                        <!--begin::Message-->
                                                        <div class="ql-toolbar ql-snow px-5 border-top-0 border-left-0 border-right-0"><span class="ql-formats"><span class="ql-header ql-picker"><span class="ql-picker-label" tabindex="0" role="button" aria-expanded="false" aria-controls="ql-picker-options-0"><svg viewBox="0 0 18 18">
                                                                            <polygon class="ql-stroke" points="7 11 9 13 11 11 7 11"></polygon>
                                                                            <polygon class="ql-stroke" points="7 7 9 5 11 7 7 7"></polygon>
                                                                        </svg></span><span class="ql-picker-options" aria-hidden="true" tabindex="-1" id="ql-picker-options-0"><span tabindex="0" role="button" class="ql-picker-item" data-value="1"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="2"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="3"></span><span tabindex="0" role="button" class="ql-picker-item ql-selected"></span></span></span><select class="ql-header" style="display: none;">
                                                                    <option value="1"></option>
                                                                    <option value="2"></option>
                                                                    <option value="3"></option>
                                                                    <option selected="selected"></option>
                                                                </select></span><span class="ql-formats"><button type="button" class="ql-bold"><svg viewBox="0 0 18 18">
                                                                        <path class="ql-stroke" d="M5,4H9.5A2.5,2.5,0,0,1,12,6.5v0A2.5,2.5,0,0,1,9.5,9H5A0,0,0,0,1,5,9V4A0,0,0,0,1,5,4Z"></path>
                                                                        <path class="ql-stroke" d="M5,9h5.5A2.5,2.5,0,0,1,13,11.5v0A2.5,2.5,0,0,1,10.5,14H5a0,0,0,0,1,0,0V9A0,0,0,0,1,5,9Z"></path>
                                                                    </svg></button><button type="button" class="ql-italic"><svg viewBox="0 0 18 18">
                                                                        <line class="ql-stroke" x1="7" x2="13" y1="4" y2="4"></line>
                                                                        <line class="ql-stroke" x1="5" x2="11" y1="14" y2="14"></line>
                                                                        <line class="ql-stroke" x1="8" x2="10" y1="14" y2="4"></line>
                                                                    </svg></button><button type="button" class="ql-underline"><svg viewBox="0 0 18 18">
                                                                        <path class="ql-stroke" d="M5,3V9a4.012,4.012,0,0,0,4,4H9a4.012,4.012,0,0,0,4-4V3"></path>
                                                                        <rect class="ql-fill" height="1" rx="0.5" ry="0.5" width="12" x="3" y="15"></rect>
                                                                    </svg></button><button type="button" class="ql-link"><svg viewBox="0 0 18 18">
                                                                        <line class="ql-stroke" x1="7" x2="11" y1="7" y2="11"></line>
                                                                        <path class="ql-even ql-stroke" d="M8.9,4.577a3.476,3.476,0,0,1,.36,4.679A3.476,3.476,0,0,1,4.577,8.9C3.185,7.5,2.035,6.4,4.217,4.217S7.5,3.185,8.9,4.577Z"></path>
                                                                        <path class="ql-even ql-stroke" d="M13.423,9.1a3.476,3.476,0,0,0-4.679-.36,3.476,3.476,0,0,0,.36,4.679c1.392,1.392,2.5,2.542,4.679.36S14.815,10.5,13.423,9.1Z"></path>
                                                                    </svg></button></span><span class="ql-formats"><button type="button" class="ql-list" value="ordered"><svg viewBox="0 0 18 18">
                                                                        <line class="ql-stroke" x1="7" x2="15" y1="4" y2="4"></line>
                                                                        <line class="ql-stroke" x1="7" x2="15" y1="9" y2="9"></line>
                                                                        <line class="ql-stroke" x1="7" x2="15" y1="14" y2="14"></line>
                                                                        <line class="ql-stroke ql-thin" x1="2.5" x2="4.5" y1="5.5" y2="5.5"></line>
                                                                        <path class="ql-fill" d="M3.5,6A0.5,0.5,0,0,1,3,5.5V3.085l-0.276.138A0.5,0.5,0,0,1,2.053,3c-0.124-.247-0.023-0.324.224-0.447l1-.5A0.5,0.5,0,0,1,4,2.5v3A0.5,0.5,0,0,1,3.5,6Z"></path>
                                                                        <path class="ql-stroke ql-thin" d="M4.5,10.5h-2c0-.234,1.85-1.076,1.85-2.234A0.959,0.959,0,0,0,2.5,8.156"></path>
                                                                        <path class="ql-stroke ql-thin" d="M2.5,14.846a0.959,0.959,0,0,0,1.85-.109A0.7,0.7,0,0,0,3.75,14a0.688,0.688,0,0,0,.6-0.736,0.959,0.959,0,0,0-1.85-.109"></path>
                                                                    </svg></button><button type="button" class="ql-list" value="bullet"><svg viewBox="0 0 18 18">
                                                                        <line class="ql-stroke" x1="6" x2="15" y1="4" y2="4"></line>
                                                                        <line class="ql-stroke" x1="6" x2="15" y1="9" y2="9"></line>
                                                                        <line class="ql-stroke" x1="6" x2="15" y1="14" y2="14"></line>
                                                                        <line class="ql-stroke" x1="3" x2="3" y1="4" y2="4"></line>
                                                                        <line class="ql-stroke" x1="3" x2="3" y1="9" y2="9"></line>
                                                                        <line class="ql-stroke" x1="3" x2="3" y1="14" y2="14"></line>
                                                                    </svg></button></span><span class="ql-formats"><button type="button" class="ql-clean"><svg class="" viewBox="0 0 18 18">
                                                                        <line class="ql-stroke" x1="5" x2="13" y1="3" y2="3"></line>
                                                                        <line class="ql-stroke" x1="6" x2="9.35" y1="12" y2="3"></line>
                                                                        <line class="ql-stroke" x1="11" x2="15" y1="11" y2="15"></line>
                                                                        <line class="ql-stroke" x1="15" x2="11" y1="11" y2="15"></line>
                                                                        <rect class="ql-fill" height="1" rx="0.5" ry="0.5" width="7" x="2" y="14"></rect>
                                                                    </svg></button></span></div>
                                                        <div id="kt_inbox_reply_editor" class="border-0 ql-container ql-snow" style="height: 250px">
                                                            <div class="ql-editor ql-blank px-8" data-gramm="false" data-placeholder="Type message..." contenteditable="true">
                                                                <p><br></p>
                                                            </div>
                                                            <div class="ql-clipboard" tabindex="-1" contenteditable="true"></div>
                                                            <div class="ql-tooltip ql-hidden"><a class="ql-preview" rel="noopener noreferrer" target="_blank" href="about:blank"></a><input type="text" data-formula="e=mc^2" data-link="https://quilljs.com" data-video="Embed URL"><a class="ql-action"></a><a class="ql-remove"></a></div>
                                                        </div>
                                                        <!--end::Message-->
                                                        <!--begin::Attachments-->
                                                        <div class="dropzone dropzone-multi px-8 py-4" id="kt_inbox_reply_attachments">
                                                            <div class="dropzone-items">

                                                            </div>
                                                            <div class="dz-default dz-message"><button class="dz-button" type="button">Drop files here to upload</button></div>
                                                        </div>
                                                        <!--end::Attachments-->
                                                    </div>
                                                    <!--end::Body-->
                                                    <!--begin::Footer-->
                                                    <div class="d-flex align-items-center justify-content-between py-5 pl-8 pr-5 border-top">
                                                        <!--begin::Actions-->
                                                        <div class="d-flex align-items-center mr-3">
                                                            <!--begin::Send-->
                                                            <div class="btn-group mr-4">
                                                                <span class="btn btn-primary font-weight-bold px-6">Send</span>
                                                                <span class="btn btn-primary font-weight-bold dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="button"></span>
                                                                <div class="dropdown-menu dropdown-menu-sm dropup p-0 m-0 dropdown-menu-right">
                                                                    <ul class="navi py-3">
                                                                        <li class="navi-item">
                                                                            <a href="#" class="navi-link">
                                                                                <span class="navi-icon">
                                                                                    <i class="flaticon2-writing"></i>
                                                                                </span>
                                                                                <span class="navi-text">Schedule Send</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="navi-item">
                                                                            <a href="#" class="navi-link">
                                                                                <span class="navi-icon">
                                                                                    <i class="flaticon2-medical-records"></i>
                                                                                </span>
                                                                                <span class="navi-text">Save &amp; archive</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="navi-item">
                                                                            <a href="#" class="navi-link">
                                                                                <span class="navi-icon">
                                                                                    <i class="flaticon2-hourglass-1"></i>
                                                                                </span>
                                                                                <span class="navi-text">Cancel</span>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <!--end::Send-->
                                                            <!--begin::Other-->
                                                            <span class="btn btn-icon btn-sm btn-clean mr-2 dz-clickable" id="kt_inbox_reply_attachments_select">
                                                                <i class="flaticon2-clip-symbol"></i>
                                                            </span>
                                                            <span class="btn btn-icon btn-sm btn-clean">
                                                                <i class="flaticon2-pin"></i>
                                                            </span>
                                                            <!--end::Other-->
                                                        </div>
                                                        <!--end::Actions-->
                                                        <!--begin::Toolbar-->
                                                        <div class="d-flex align-items-center">
                                                            <span class="btn btn-icon btn-sm btn-clean mr-2" data-toggle="tooltip" title="" data-original-title="More actions">
                                                                <i class="flaticon2-settings"></i>
                                                            </span>
                                                            <span class="btn btn-icon btn-sm btn-clean" data-inbox="dismiss" data-toggle="tooltip" title="" data-original-title="Dismiss reply">
                                                                <i class="flaticon2-rubbish-bin-delete-button"></i>
                                                            </span>
                                                        </div>
                                                        <!--end::Toolbar-->
                                                    </div>
                                                    <!--end::Footer-->
                                                </form>
                                                <!--end::Form-->
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Reply-->
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Card-->
                        </div>
                        <!--end::View-->
                    </div>
                </div>
            </div>
            <!--end::Inbox-->
        </div>
        <!--end::Container-->
    </div>


    <!-- <div class="container-fluid" style="margin-top: 15vh;" id="overlay">
        <div class="row" ng-repeat="list in personaList">
            <div class="col-9" style="font-size: 2em;margin-bottom: 2%;">{{list.my_fullname}}</div><Br>
            <div class="col-4" style="border: 1px solid black;">

                <div class="row" style="border: 1px solid black;" ng-repeat="(k,v) in list.contacts" ng-click="view_messages(v.messages)">
                    <span style="padding: 1%;">{{v.first_name}}&nbsp; {{v.last_name}}</span>
                </div>
            </div>
            <div class="col-6" style="border: 1px solid black;">
                {{message_info}}
            </div>
        </div>
    </div> -->

</section>
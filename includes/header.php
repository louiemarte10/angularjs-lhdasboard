<!--begin::Header-->

<div id="cb_header" class="header header-fixed">
    <!--begin::Container-->
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <!--begin::Header Menu Wrapper-->
        <div class="header-menu-wrapper header-menu-wrapper-left" id="cb_header_menu_wrapper">
            <!--begin::Header Menu-->
            <div id="cb_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                <!--begin::Header Nav-->
                <ul class="menu-nav">

                    <li>
                        <!-- <a href="http://192.168.55.11/bootstrap5-documentation/" class="brand-logo">
                            <img alt="Logo" style="" src="http://192.168.55.11/framework/bootstrap5/media/logos/callbox-logo.svg" width="90px">
                        </a> -->
                        <a href="" class="brand-logo">
                            <!-- <img alt="Logo" style="" src="http://192.168.55.11/framework/bootstrap5/media/logos/callbox-logo.svg" width="90px"> -->
                        </a>
                    </li>
                    <li>
                        <h3 class="mt-6 ml-10">Linkedhelper Dashboard </h3>
                    </li>

                    <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default ml-10">
                        <!--begin::Header Nav-->
                        <!--end::Header Nav-->
                    </div>
                </ul>
                <!--end::Header Nav-->
            </div>
            <!--end::Header Menu-->
        </div>
        <!--end::Header Menu Wrapper-->
        <!--begin::Topbar-->
        <div class="topbar">


            <div class="dropdown ">
                <div class="topbar-item" data-offset="10px,0px" aria-expanded="true">

               <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3"><a class="text-muted" href="http://192.168.50.12/pipeline/linkedin-dashboard/reports/lh-dashboard-records/total-records.php" target="_blank" style="float:right;"><u>SMM Total Records</u> </a></span> 
                   <!-- <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3"><a class="text-muted" href="http://192.168.50.12/pipeline/linkedin-dashboard/reports/stats.php" target="_blank" style="float:right;"><u> SMM Stats</u> </a></span> -->
                   <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3"><a class="text-muted" href="http://192.168.50.12/pipeline/linkedin-dashboard/smm-reports/stats.php" target="_blank" style="float:right;"><u> SMM Stats</u> </a></span>
                </div>
                <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px" aria-expanded="true">
                    <div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
                        <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
                        <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3"><?= (px_login::info('first_name')) ?></span>
                        <span class="symbol symbol-lg-35 symbol-25 symbol-light-success shadow-sm">
                            <img alt="Avatar" src="http://192.168.50.12/internal/staff/<?= (px_login::info('user_name')) ?>.gif" />
                        </span>
                    </div>
                </div>

                <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg" x-placement="bottom-end">
                    <!--begin:Header-->
                    <div class="d-flex d-flex-fluid">
                        <div class="d-flex align-items-center mx-5 my-5">
                            <div class="symbol symbol-100 mr-5">
                                <div class="symbol-label" style="background-size: 100% 100%;background-image:url('http://192.168.50.12/internal/staff/<?= (px_login::info('user_name')) ?>.gif')"></div>
                                <i class="symbol-badge bg-success"></i>
                            </div>
                            <div class="d-flex flex-column">
                                <a href="#" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary"><?= (px_login::info('first_name')) ?> <?= (px_login::info('last_name')) ?></a>
                                <div class="text-muted mt-1">Callbox Inc.</div>
                                <div class="navi mt-2">
                                    <a href="#" class="navi-item">
                                        <span class="navi-link p-0 pb-2">
                                            <span class="navi-icon mr-1">
                                                <span class="svg-icon svg-icon-lg svg-icon-primary">
                                                    <!--begin::Svg Icon | path:media/svg/icons/Communication/Mail-notification.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"></rect>
                                                            <path d="M21,12.0829584 C20.6747915,12.0283988 20.3407122,12 20,12 C16.6862915,12 14,14.6862915 14,18 C14,18.3407122 14.0283988,18.6747915 14.0829584,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,12.0829584 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z" fill="#000000"></path>
                                                            <circle fill="#000000" opacity="0.3" cx="19.5" cy="17.5" r="2.5"></circle>
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </span>
                                            <span class="navi-text text-muted text-hover-primary"><?= (px_login::info('user_name')) ?>@callboxinc.com</span>
                                        </span>
                                    </a>
                                    <a href="?logoff" class="btn btn-sm btn-light-primary font-weight-bolder py-2 px-5">Sign Out</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end:Nav-->
                </div>
            </div>



            <div class="topbar-item">
                <a href="?logoff" class="btn btn-icon btn-icon-mobile w-auto btn-clean btn-hover-light-danger d-flex align-items-center btn-lg px-2" data-toggle="modal" data-target="#kt_chat_modal">
                    <span class="svg-icon svg-icon-xl svg-icon-danger">
                        <!--begin::Svg Icon | path:media/svg/icons/Communication/Group-chat.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <rect fill="#000000" opacity="0.3" transform="translate(9.000000, 12.000000) rotate(-270.000000) translate(-9.000000, -12.000000) " x="8" y="6" width="2" height="12" rx="1" />
                                <path d="M20,7.00607258 C19.4477153,7.00607258 19,6.55855153 19,6.00650634 C19,5.45446114 19.4477153,5.00694009 20,5.00694009 L21,5.00694009 C23.209139,5.00694009 25,6.7970243 25,9.00520507 L25,15.001735 C25,17.2099158 23.209139,19 21,19 L9,19 C6.790861,19 5,17.2099158 5,15.001735 L5,8.99826498 C5,6.7900842 6.790861,5 9,5 L10.0000048,5 C10.5522896,5 11.0000048,5.44752105 11.0000048,5.99956624 C11.0000048,6.55161144 10.5522896,6.99913249 10.0000048,6.99913249 L9,6.99913249 C7.8954305,6.99913249 7,7.89417459 7,8.99826498 L7,15.001735 C7,16.1058254 7.8954305,17.0008675 9,17.0008675 L21,17.0008675 C22.1045695,17.0008675 23,16.1058254 23,15.001735 L23,9.00520507 C23,7.90111468 22.1045695,7.00607258 21,7.00607258 L20,7.00607258 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.000000, 12.000000) rotate(-90.000000) translate(-15.000000, -12.000000) " />
                                <path d="M16.7928932,9.79289322 C17.1834175,9.40236893 17.8165825,9.40236893 18.2071068,9.79289322 C18.5976311,10.1834175 18.5976311,10.8165825 18.2071068,11.2071068 L15.2071068,14.2071068 C14.8165825,14.5976311 14.1834175,14.5976311 13.7928932,14.2071068 L10.7928932,11.2071068 C10.4023689,10.8165825 10.4023689,10.1834175 10.7928932,9.79289322 C11.1834175,9.40236893 11.8165825,9.40236893 12.2071068,9.79289322 L14.5,12.0857864 L16.7928932,9.79289322 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.500000, 12.000000) rotate(-90.000000) translate(-14.500000, -12.000000) " />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                        <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Logoff</span>
                    </span>
                </a>
            </div>


        </div>
        <!--end::Topbar-->
    </div>
    <!--end::Container-->
</div>
<!--end::Header-->
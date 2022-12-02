<div class="modal fade " id="contact_info" data-backdrop="" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl " role="document">
        <div class="modal-content " ng-repeat="x in modalData">
            <div class="modal-header">
                <!-- <h5 class="modal-title text-dark text-bold" id="exampleModalLabel">{{x.first_name}} &nbsp; {{x.last_name}}</h5> -->
                <h3 class="text-primary mb-1">LinkedIn Information</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" ng-if="x.summary.length > 0 || x.avatar != '' || x.avatar != null || x.avatar.length > 0" style="vertical-align: top;">
                        <div class="d-flex align-items-stretch my-5">
                            <div class="symbol symbol-100 mr-5" style="vertical-align: top;">
                                <div class="symbol-label shadow-sm" style="background-size: 100% 100%;background-image:url('{{x.avatar}}');">
                                    <span ng-if="x.avatar == '' || x.avatar == null || x.avatar.length == 0">
                                        <img src="http://192.168.50.12/framework/bootstrap5/media/users/default.jpg" />
                                    </span>
                                </div>
                                <i class="symbol-badge bg-success"></i>
                            </div>
                            <div class="d-flex flex-column w-100" style="vertical-align: top;">
                                <div class="">
                                    <span style="width:100%;" ng-if="x.summary.length > 0"> {{x.summary}}</span>
                                    <span style="width:100%;" ng-if="x.summary.length <= 0 || x.summary == '' || x.summary == null"> No Summary </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <span class="text-primary mb-1">Profile Information:</span>
                        <div class="separator separator-dashed separator-border-1 separator-primary mb-3"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 text-muted">Name</div>
                                    <div class="col-md-8">{{x.first_name}} &nbsp; {{x.last_name}}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 text-muted">Email</div>
                                    <div class="col-md-8" ng-if="x.contact_email == ''">no email</div>
                                    <div class="col-md-8">{{x.contact_email}}&nbsp;
                                        <span ng-if="x.contact_email != '' && x.contact_email_status == 'valid'" style="color: green;">{{x.contact_email_status}}</span>
                                        <span ng-if="x.contact_email != '' && x.contact_email_status == 'unverifiable'" style="color: orange;">{{x.contact_email_status}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 text-muted">Company</div>
                                    <div class="col-md-8">{{x.company}}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 text-muted">Position</div>
                                    <div class="col-md-7">{{x.position}}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 text-muted">Location</div>
                                    <div class="col-md-8">{{x.address1}}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 text-muted">Contact Number</div>
                                    <div class="col-md-8">
                                        <!-- {{x.phone_1}} -->
                                        <span ng-repeat="(k,v) in x.phone_numbers" ng-if="x.phone_numbers.length > 0">
                                            {{v.phone_type}}:&nbsp;{{v.phone}}&nbsp;
                                            <span class="badge bg-success" style="font-size: 0.8rem;position:relative;top:0" ng-if="v.x == 'active'">{{v.x}}</span>
                                            <span class="badge bg-danger" style="font-size: 0.8rem;" ng-if="v.x != 'active'">{{v.x}}</span> <Br><Br>


                                            <!-- Work: {{x.work_phone}}<br>
                                        Mobile: {{x.mobile_phone}}<br>
                                        Home: {{x.home_phone}} -->

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 text-muted">LinkedIn Url</div>
                                    <div class="col-md-8"><a href="{{x.linkedin_url}}">{{x.linkedin_url}}</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>

                <div class="row" ng-if="x.other_emails.length > 0">
                    <div class="col-md-12">
                        <span class="text-primary mb-1">Other Emails:</span>
                        <div class="separator separator-dashed separator-border-1 separator-primary mb-3"></div>
                    </div>

                    <div class="col-md-6" ng-repeat="email in x.other_emails" ng-if="email.email != x.contact_email">


                        {{email.email}}&nbsp;
                        <!-- <span ng-if="email.email == x.contact_email" style="color: green;">primary,</span> -->
                        <span ng-if="email.status == 'valid'" style="color: green;">{{email.status}}</span>
                        <span ng-if="email.status == 'unverifiable'" style="color: orange;">{{email.status}}</span>

                    </div>


                </div>

                <br>


                <!-- ng-repeat="(key,org) in x.full_org_info" color #b5b5c3 !important-->
                <!-- <div class="row">
                        <div class="col-md-12">
                            <span class="text-primary mb-1">Organization Information:</span>
                            <div class="separator separator-dashed separator-border-1 separator-primary mb-3"></div>
                        </div>
                      
                        <div class="col-md-6">
                            <span style="color: #b5b5c3 !important;margin-right: 2%">Organization:</span>{{x.full_org_info.organization }}
                        </div>
                        <div class="col-md-6">
                            <span style="color: #b5b5c3 !important;margin-right: 2%">Position:</span>{{x.full_org_info.organization_title }}
                        </div>
                        <div class="col-md-6">
                            <span style="color: #b5b5c3 !important;margin-right: 2%">Location:</span>{{x.full_org_info.organization_location }}
                        </div>
                        <div class="col-md-6">
                            <span style="color: #b5b5c3 !important;margin-right: 2%">Start:</span>{{x.full_org_info.organization_start }}&nbsp;
                            <span style="color: #b5b5c3 !important;margin-right: 2%">End:</span>{{x.full_org_info.organization_end }}
                        </div>
                        <div class="col-md-6">
                            <span style="color: #b5b5c3 !important;margin-right: 2%">Country:</span>{{x.full_org_info.country }}
                        </div>
                        <div class="col-md-6">
                            <span style="color: #b5b5c3 !important;margin-right: 2%">LinkedIn Url:</span>{{x.full_org_info.organization_url }}
                        </div>
                        <div class="col-md-6">
                            <span style="color: #b5b5c3 !important;margin-right: 2%">Website:</span>{{x.full_org_info.organization_website }}
                        </div>


                    </div> -->
                <div class="row">
                    <div class="col-md-12">
                        <span class="text-primary mb-1">Organization Information:</span>
                        <div class="separator separator-dashed separator-border-1 separator-primary mb-3"></div>
                    </div>
                    <div class="col-md-6 px-1" ng-repeat="org in x.other_details.companies" id="org_id_{{org.data_other_organization_lkp_id}}">

                        <div ng-if="org.primary_organization == 1" class="card card-custom mb-2 bg-diagonal bg-diagonal-light-success" style="z-index: 0 !important; min-height: 35px;">
                            <div class="card-body px-0 py-0">
                                <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
                                    <div class="d-flex flex-column">
                                        <a href="#" class="small text-dark text-hover-primary">{{org.organization}}</a>
                                        <p class="small text-muted">{{org.organization_title}} <Br>{{org.organization_location}}</p>
                                        <p class="small text-muted">From: {{org.organization_start}} To: {{org.organization_end}}</p>
                                        <p class="small text-muted"><a href="{{org.organization_website}}" target="_blank">{{org.organization_website}}</a></p>

                                    </div>
                                    <div class="ml-6 ml-lg-0 ml-xxl-6 flex-shrink-0" ng-if="org.selected == 1">
                                        <p class="text-success"><i class="fas fa-check text-success"></i> Current</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div ng-if="org.primary_organization != 1" class="card card-custom mb-2 " style="z-index: 0 !important; min-height: 35px;">
                            <div class="card-body px-0 py-0">
                                <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
                                    <div class="d-flex flex-column">
                                        <a href="#" class="small text-dark text-hover-primary">{{org.organization}}</a>
                                        <p class="small text-muted">{{org.organization_title}} <Br>{{org.organization_location}}</p>

                                        <p class="small text-muted">From: {{org.organization_start}} To: {{org.organization_end}}</p>
                                        <p class="small text-muted"><a href="{{org.organization_website}}" target="_blank">{{org.organization_website}}</a></p>


                                    </div>
                                    <div class="ml-6 ml-lg-0 ml-xxl-6 flex-shrink-0" ng-if="org.selected != 1" style="z-index: 1 !important;">
                                        <div class="dropdown dropdown-inline mr-4">

                                            <a class="dropdown-item" href="#" ng-click="map_company(x.data_id,org);" style="z-index: 3;background-color:#3f4254;color: white">Set as Current</a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- <div class="row mt-5">
                    <div class="col-md-12">
                        <h3 class="text-primary mb-1">Persona Information:</h3>
                        <div class="separator separator-dashed separator-border-1 separator-primary mb-3"></div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-2 text-muted">Name</div>
                                    <div class="col-md-7">{{x.my_fullname}}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-2 text-muted">Email</div>
                                    <div class="col-md-7">{{x.my_email}}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-2 text-muted">Account Type</div>
                                    <div class="col-md-7" style="display:flex;align-items:center;">{{x.account_type}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->




                <!-- ng-click="editContact('contact_name',x);" -->
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal" ng-click="editContact('contact_name',x);">Edit</button>

                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary font-weight-bold">Save changes</button> -->

            </div>
        </div>
    </div>
</div>
<style>
    .autocomplete-custom-template {
        width: 100% !important;
    }

    .autocomplete-custom-template .md-autocomplete-suggestion {
        /* border-bottom: 1px solid #ccc; */
        height: auto;
        padding-top: 8px;
        padding-bottom: 8px;
        /* white-space: normal; */
    }

    .autocomplete-custom-template .md-autocomplete-suggestion:last-child {
        border-bottom-width: 0;
    }

    .autocomplete-custom-template .item-title,
    .autocomplete-custom-template .item-metadata {
        display: block;
        line-height: 2;
    }


    .custom-container {
        min-width: 300px !important;
    }

    .autocomplete-custom-template .ng-scope {
        /* padding: 10% !important; */
        /* background-color: red; */
        height: 6vh !important;
        border-bottom: 1px solid green;
    }
</style>

<div class="modal modal3" id="edit_modal" data-backdrop="" style="display: none;">
    <div class="modal-content2" id="connection_modal_content">
        <div class="modal-header modal-header2">
            <h2 id="modal-title">Update Contact</h2>
            <span class="modal_close2" ng-click="show_hide_div('#edit_modal')">&times;</span>
        </div>

        <form id="updateform" name="updateform" class="ui form" ng-repeat="(k,v) in editInfo" ng-submit="update_contact($event,v)">
            <div class="modal-body column">
                <!-- <div class="field">
                    <div class="six wide field">
                        <label>Client</label>

                    </div>
                </div> -->


                <h1>Contact</h1>
                <div class="row">
                    <div class="col-md-6" style="width: 100% !important;">
                        <label for="from">First Name</label>
                        <input class="form-control" id="fname" name="fname" placeholder="" ng-model="edit.firstname" type="text" style="width: 100% !important;" ng-value="v.first_name" />

                    </div>
                    <div class="col-md-6" style="width: 100% !important;">
                        <label for="from">Last Name</label>
                        <input class="form-control" id="lname" name="lname" placeholder="" ng-model="edit.lastname" type="text" style="width: 100% !important;" ng-value="v.last_name" />
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12" style="width: 100% !important;">
                        <label for="from">Email</label>
                        <input class="form-control" id="contact_email" name="contact_email" placeholder="" ng-model="edit.email" type="text" style="width: 100% !important;" ng-value="v.contact_email" />
                    </div>
                </div>
                <div class="row mt-3">
                    <!-- <div class="row mt-3" > -->
                    <div class="col-md-12">

                        <label for="">Contact No(s)</label>
                    </div>
                    <div class="col-md-3" style="float: left;" ng-repeat="(ky,pn) in phone_numbers_edit" ng-if="pn.x == 'active'">

                        <select class="form-control" ng-custom-change="getSelectValue(ky)" id="phone_type_{{ky}}">
                            <option value="home">HOME</option>
                            <option value="mobile">MOBILE</option>
                            <option value="work">WORK</option>
                        </select>
                        <select class="form-control" id="phone_type_status_{{ky}}">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <span ng-init="init_phone_type(ky,pn.phone_type);init_phone_status(ky,pn.x)">
                            
                            <input class="form-control" id="phone_{{ky}}" name="phone" placeholder="" type="text" ng-value="pn.phone" />


                            <a href="" ng-if="pn.isNew == 1" ng-click="remove_phone(ky);" title="remove phone number">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-minus" viewBox="0 0 16 16" style="margin-right: 0.5%;color:red; font-size: 2em;float:right">
                                    <path fill-rule="evenodd" d="M10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5z" />
                                    <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                                </svg>

                            </a>


                            <a href="" data-toggle="dropdown" aria-haspopup="true" style="font-size: 2rem;float: left;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                    <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                                </svg>
                            </a>

                            <div class="dropdown-menu">
                                <!-- style="float: left;margin-right: 5%" -->
                                <!-- <a href=""  ng-if="pn.phone_type == 'mobile' && (pn.primary == undefined || pn.primary == null)" title="set as primary mobile no." ng-click="set_as_primary_no(pn.indx,'mobile');">
                                    Set as primary mobile no.
                                </a> -->
                                <a class="dropdown-item" href="" ng-if="pn.phone_type == 'mobile'" ng-click="set_as_primary_no(pn.indx,'Mobile');">Set as primary mobile no.</a>
                                <a class="dropdown-item" href="" ng-if="pn.phone_type == 'phone' || pn.phone_type == 'work'" ng-click="set_as_primary_no(pn.indx,'Phone');">Set as primary phone no.</a>
                                <a class="dropdown-item" href="" ng-if="pn.phone_type == 'phone' || pn.phone_type == 'work'" ng-click="set_as_primary_no(pn.indx,'Direct Line');">Set as primary direct line no.</a>
                            </div>




                            <a href="" ng-if="(pn.primary != undefined || pn.primary != null)" ng-click="remove_primary(pn.indx)" style="float: left;margin-left: 5%;color: red">
                                Remove as primary {{pn.primary}}
                            </a>






                        </span>
                        <!-- <input class="form-control mt-2" id="phone_{{ky}}" name="phone" placeholder="" type="text" ng-value="pn.phone" />
                        <span ng-init="init_phone_type(ky,pn.phone_type)" style="position: relative; left: 420px; top: -30px">                            
                            <a href="" ng-click="remove_phone(ky);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10%" height="15%" fill="currentColor" class="bi bi-telephone-minus" viewBox="0 0 16 16" style="color:red;">
                                    <path fill-rule="evenodd" d="M10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5z" />
                                    <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                                </svg>
                            </a>
                        </span> -->
                    </div>
                    <!-- </div> -->
                </div>
                <!-- style="width: 5% !important;height: 5% !important" -->
                <br><Br>
                <div class="row">
                    <div class="col-md-6">
                        <a href="" ng-click="add_phone(v.data_id);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10%" height="50%" fill="currentColor" class="bi bi-telephone-plus" viewBox="0 0 16 16">
                                <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                                <path fill-rule="evenodd" d="M12.5 1a.5.5 0 0 1 .5.5V3h1.5a.5.5 0 0 1 0 1H13v1.5a.5.5 0 0 1-1 0V4h-1.5a.5.5 0 0 1 0-1H12V1.5a.5.5 0 0 1 .5-.5z" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="from">Company</label>
                        <!-- layout-padding -->
                        <!-- <input class="form-control" id="company" name="company" placeholder="" ng-model="edit.company" type="text" style="width: 100% !important;" ng-value="v.company" /> -->
                        <md-content layout="column" style="width: 100% !important;">
                            <!-- <p>Use <code>&lt;md-autocomplete&gt;</code> with custom templates to show styled autocomplete results.</p> -->
                            <md-autocomplete style="width: 100% !important;" md-Input-Name="mdSearchCompany" id="custom-template" md-selected-item="item.organization_name" md-search-text-change="search_organization(searchCompany)" md-search-text="searchCompany" md-selected-item-change="selected_organization(item)" md-items="item in organization" md-item-text="item.organization_name" md-min-length="0" md-escape-options="clear" input-aria-label="Current Repository" placeholder="{{v.company}}" md-menu-class="autocomplete-custom-template" md-menu-container-class="custom-container">
                                <md-item-template>
                                    <span class="item-title">
                                        <span> {{item.organization_name}} </span>
                                    </span>
                                    <span class="item-metadata">
                                        <span>
                                            {{item.organization_location_1}}
                                        </span>

                                    </span>
                                </md-item-template>
                                <md-not-found>
                                    No company matching "{{searchCompany}}" were found.
                                    <!-- <a href="">Create a new one!</a> -->
                                    <!-- ng-click="addOrg(searchCompany)" -->
                                </md-not-found>
                            </md-autocomplete>
                        </md-content>
                        <input class="form-control" type="hidden" id="editCompany" ng-value="v.company" />
                        <!-- <md-autocomplete flex role="combobox" md-selected-item="text" md-no-cache="true" md-search-text="searchCompany" md-search-text-change="search_organization(searchCompany)" md-items="item in organization" md-item-text="item.organization_name" md-min-length="5" md-selected-item-change="ctrl.get_user(item);" on-enter ng-cloak>
                            <md-item-template>

                                <span class="item-title">
                                    <md-icon md-svg-icon="img/icons/octicon-repo.svg" aria-hidden="true"></md-icon>
                                    <span> {{item.organization_name}} </span>
                                </span>
                                <span class="item-metadata">
                                    <span>
                                        <strong>{{item.organization_location_1}}</strong> watchers
                                    </span>
                             
                                </span>



                            </md-item-template>
                            <md-not-found>
                                No company matching "{{searchCompany}}" were found.
                                <a href="">Create a new one!</a>
                            </md-not-found>
                        </md-autocomplete> -->
                        <!-- <input class="form-control" type="hidden" ng-model="form.user_id" required /> -->
                    </div>




                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <label for="from">Position</label>
                        <input class="form-control" id="position" name="position" placeholder="" ng-model="edit.position" type="text" ng-value="v.organization_title" />
                    </div>
                    <div class="col-md-4">
                        <label for="from">Location</label>
                        <input class="form-control" id="organization_location_1" name="organization_location_1" placeholder="" ng-model="edit.organization_location_1" type="text" ng-value="v.organization_location_1" />
                    </div>
                    <div class="col-md-4">
                        <label for="from">Country</label>
                        <select class="form-control" id="country" ng-model="country" ng-init="init_country(v.country_id);">
                            <option ng-repeat="country in country_list" value="{{country.country_id}}">{{country.country}}</option>
                        </select>
                    </div>

                </div>
                <div class="row mt-3">
                    <!-- <label class="control-label"></label> -->
                    <input class="form-check-input" type="checkbox" ng-model="isCurrentlyEmployed" id="isCurrentlyEmployed">
                    <div class="col-md-4">
                        <label class="control-label">Organization Start (Optional) </label>

                        <input class="form-control form-control-sm" id="org_start" type="date" ng-value="v.full_org_info.organization_start" ng-disabled="isCurrentlyEmployed == false" />

                    </div>


                    <div class="col-md-4">


                        <span>

                            <label class="control-label">Organization End (Optional)</label>
                            <div class="input-group">
                                <input class="form-control form-control-sm" id="org_end" type="date" ng-value="v.full_org_info.organization_end" ng-disabled="isCurrentlyEmployed == false" />
                            </div>
                        </span>

                    </div>
                </div>

                <?php //if ($_SERVER['REMOTE_ADDR'] == '192.168.60.227') { 
                ?>
                <div class="fields">




                </div>
                <?php //} 
                ?>




                <!-- <h1>Persona</h1>
                        <div class="fields">
                            <div class="six wide field" style="width: 100% !important;">
                                <label for="from">Name</label>
                                <input class="form-control" id="my_fullname" name="my_fullname" placeholder="" ng-model="edit.my_fullname" type="text" style="width: 100% !important;" ng-value="v.my_fullname"  />

                            </div>


                        </div>
                        <div class="fields">
                            <div class="six wide field" style="width: 100% !important;">
                                <label for="from">Email</label>
                                <input class="form-control" id="my_email" name="my_email" placeholder="" ng-model="edit.my_email" type="text" style="width: 100% !important;" ng-value="v.my_email"  />

                            </div>

                        </div> -->






            </div>

            <div class="modal-footer field">

                <button type="submit" id="updateContact" class="btn btn-primary">
                    <span class="svg-icon">
                        <!--begin::Svg Icon | path:2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/General/Save.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24" />
                                <path d="M17,4 L6,4 C4.79111111,4 4,4.7 4,6 L4,18 C4,19.3 4.79111111,20 6,20 L18,20 C19.2,20 20,19.3 20,18 L20,7.20710678 C20,7.07449854 19.9473216,6.94732158 19.8535534,6.85355339 L17,4 Z M17,11 L7,11 L7,4 L17,4 L17,11 Z" fill="#000000" fill-rule="nonzero" />
                                <rect fill="#000000" opacity="0.3" x="12" y="4" width="3" height="5" rx="0.5" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    Update
                </button>
                <button type="button" ng-click="show_hide_div('#edit_modal')" class="btn btn-primary">
                    <span class="svg-icon">Close</span>
                </button>


            </div>

        </form>
    </div>
</div>
<!-- <script>
    $(document).on('change', '#team', function() {
        $("#ht_id").val($("#pipe_teams option[value='" + $("#team").val() + "']").attr("ht_id"));
    });
</script> -->
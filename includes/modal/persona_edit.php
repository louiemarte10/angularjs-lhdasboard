<div class="modal modal2" id="edit_persona" style="display: none;">
    <div class="modal-content2" id="connection_modal_content">
        <div class="modal-header modal-header2">
            <h2 id="modal-title">Edit Persona</h2>
            <span class="modal_close2" ng-click="show_hide_div('#edit_persona')">&times;</span>
        </div>
        <!-- ng-submit="addPersona($event,form)" -->
        <form ng-submit="updatePersona($event,formEdit)" id="connectionform3" name="connectionform3" class="ui form">
            <div class="modal-body column">
                <!-- <div class="field">
                    <div class="six wide field">
                        <label>Client</label>

                    </div>formEdit
                </div> -->
                <input class="form-control" id="editPersonaId" name="editPersonaId" ng-model="formEdit.editPersonaId" type="hidden" style="width: 100% !important;" required />

                <div class="fields">
                    <div class="six wide field" style="width: 100% !important;">
                        <label for="from">Fullname</label>
                        <input class="form-control" id="editFullname" name="editFullname" placeholder="Persona Fullname" ng-model="formEdit.editFullname" type="text" style="width: 100% !important;" required />
                        <!-- <input id="fullname" name="fullname" placeholder="Persona Fullname" ng-model="fullname" type="text"  list="pipe_fullname"/> -->
                        <!-- <datalist id="pipe_fullname">
                            <option ng-repeat="name in personaList" value="https://developer.mozilla.org/">
                        </datalist> -->
                    </div>
                    <div class="six wide field" style="width: 100% !important;">
                        <label for="from">Email</label>
                        <input class="form-control" id="editEmail" name="editEmail" placeholder="Persona Email" style="width: 100% !important;" ng-model="formEdit.editEmail" type="email" required />
                    </div>
                    <div class="six wide field" style="width: 100% !important;">
                        <label for="from">Account Type</label>
                        <select class="form-control" ng-model="formEdit.editAccount_type" id="editAccount_type" required>
                            <option value="" hidden>
                            <option value="generic">GENERIC</option>
                            <option value="branded">BRANDED</option>
                            <option value="marketing">MARKETING</option>
                        </select>
                        <!-- <input id="fullname" name="fullname" placeholder="Persona Email" style="width: 100% !important;" ng-model="formEdit.email" type="email" required /> -->
                    </div>
                </div>
                <!-- <div class="field">
                    <div class="six wide field" style="width: 100% !important;">
                     
                        <label for="from">Assign User</label>
                        <md-autocomplete flex role="combobox" md-selected-item="text" md-no-cache="true" md-search-text="editSearchText" md-search-text-change="search_employees(editSearchText)" md-items="item in usersList" md-item-text="item.fullname" md-min-length="5" md-selected-item-change="ctrl.get_user(item);" on-enter ng-cloak>
                            <span id="autocompleteText" md-highlight-text="editSearchText" md-highlight-flags="^i">{{item.fullname}} </span>
                        </md-autocomplete>
                        <input class="form-control" type="hidden" ng-model="formEdit.user_id" required />

                    </div>
                </div> -->
                <div class="fields">
                    <div class="six wide field" style="width: 35% !important;">
                        <label for="from">Team Access (optional)</label>
                        <input class="form-control" id="team" name="team" placeholder="Teams" ng-change="getEmployeeByTeam(formEdit.team);" type="text" list="pipe_teams" ng-model="formEdit.team" style="width: 100% !important;" />
                        <!-- <textarea ng-model="formEdit.selectedTeam">

                        </textarea> -->
                        <datalist id="pipe_teams">
                            <!-- <select ng-model="data.team_list" > -->
                            <option ng-repeat="team in teamList" team_name="{{team.team_name}}" ht_id="{{team.hierarchy_tree_id}}" value="{{team.team_name}}">
                                <!-- </select> -->
                        </datalist>


                    </div>
                    <!-- </div>
                <div class="fields"> -->

                    <!-- style="width: 100% !important" -->
                    <div class="six wide field" style="width: 45% !important">
                        <label style="float:left;width:100% !important">Selected Team:</label>
                        <div ng-repeat="(k,v) in selectedTeamList" style="background-color: skyblue;color: white;float:left;margin: 2px;padding: 1%" align="center">
                            <!-- {{k}} -->
                            <!-- {{v}} -->
                            {{v.team}} <button type="button" ng-click="removeFromSelectedTeam(v.ht_id)" style="border:none; background-color: transparent; color: red">x</button><br>
                        </div>

                    </div>
                    <!-- <div class="four wide field" style="margin-top: auto">
                        <button type="button" id="add_persona_new_modal" class="mini ui positive basic button" style="width: 100%">ADD PERSONA
                        </button>
                    </div> -->
                </div>

                <!--                <input type="hidden" value="0" name="inmail_sent">-->
                <!--                <input type="hidden" value="0" name="inmail_received">-->
                <!--                <input type="hidden" value="0" name="leads">-->
                <input type="hidden" value="0" name="discussions">
                <input type="hidden" value="0" name="social_media_id" id="social_media_id">
                <input type="hidden" value="false" name="is_generic" id="is_generic">



            </div>

            <div class="modal-footer field">
                <button type="submit" ng-disabled="connectionform3.$invalid" id="insertConnection" class="btn btn-primary">
                    <span class="svg-icon">
                        <!--begin::Svg Icon | path:2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/General/Save.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
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
            </div>

        </form>
    </div>
</div>
<!-- <script>
    $(document).on('change', '#team', function() {
        $("#ht_id").val($("#pipe_teams option[value='" + $("#team").val() + "']").attr("ht_id"));
    });
</script> -->
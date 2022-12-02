<div class="modal modal2" id="connection_modal" style="display: none;">
    <div class="modal-content2" id="connection_modal_content">
        <div class="modal-header modal-header2">
            <h2 id="modal-title">Insert New Persona</h2>
            <span class="modal_close2" ng-click="show_hide_div('#connection_modal')">&times;</span>
        </div>

        <form ng-submit="addPersona($event,form)" id="connectionform2" name="connectionform2" class="ui form">
            <div class="modal-body column">
                <div class="row">
                    <div class="col-md-4" style="width: 100% !important;">
                        <label for="from">Fullname</label>
                        <input class="form-control" id="fullname" name="fullname" placeholder="Persona Fullname" ng-model="form.fullname" type="text" style="width: 100% !important;" required />                        
                    </div>
                    <div class="col-md-4" style="width: 100% !important;">
                        <label for="from">Email</label>
                        <input class="form-control" id="email" name="email" placeholder="Persona Email" style="width: 100% !important;" ng-model="form.email" type="email" required />
                    </div>
                    <div class="col-md-4" style="width: 100% !important;">
                        <label for="from">Account Type</label>
                        <select class="form-control" ng-model="form.account_type" required>
                            <option value="" hidden>
                            <option value="generic">GENERIC</option>
                            <option value="branded">BRANDED</option>
                            <option value="marketing">MARKETING</option>
                        </select>
                        <!-- <input id="fullname" name="fullname" placeholder="Persona Email" style="width: 100% !important;" ng-model="form.email" type="email" required /> -->
                    </div>
                </div>
                <!-- <div class="row mt-2">
                    <div class="col-md-12">
                        <label for="from">Assign User</label>
                        <md-autocomplete flex role="combobox" md-selected-item="text" md-no-cache="true" md-search-text="searchText" md-search-text-change="search_employees(searchText)" md-items="item in usersList" md-item-text="item.fullname" md-min-length="5" md-selected-item-change="ctrl.get_user(item);" on-enter ng-cloak>
                            <span id="autocompleteText" md-highlight-text="searchText" md-highlight-flags="^i">{{item.fullname}} </span>
                        </md-autocomplete>
                        <input class="form-control" type="hidden" ng-model="form.user_id" required />

                    </div>                    
                </div> -->


             <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="from">Primary SMM Owner</label>
                        <select id="pipe_user_id" ng-model="form.pipe_user_id" class="form-control"  >
                             <option value=""></option>
                            <option ng-repeat="i in allEmployees" value="{{ i.id }}">{{ i.name }}</option>
                        </select>
                    </div>
                </div> 




                <div class="row mt-2">
                    <div class="col-md-12">
                        <label for="from">Other users that can access this persona</label>
                        <select id="assigned-users" class="form-control"  multiple="multiple">
                            <option ng-repeat="i in allEmployees" value="{{ i.id }}">{{ i.name }}</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6" >
                        <label for="from">Team Access (optional)</label>
                        <input  class="form-control" id="team" name="team" placeholder="Teams" ng-change="getEmployeeByTeam(form.team);" type="text" list="pipe_teams" ng-model="form.team" style="width: 100% !important;" />
                        <!-- <textarea ng-model="form.selectedTeam">

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
                    <div class="col-md-6" >
                        <label style="float:left;width:100% !important">Selected Team:</label>
                        <div ng-repeat="(k,v) in selectedTeamList" style="background-color: skyblue;color: white;float:left;margin: 2px" align="center">
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
                    <button type="submit" ng-disabled="connectionform2.$invalid" id="insertConnection" class="btn btn-primary" >
                        <span class="svg-icon"><!--begin::Svg Icon | path:2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/General/Save.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24"/>
                                <path d="M17,4 L6,4 C4.79111111,4 4,4.7 4,6 L4,18 C4,19.3 4.79111111,20 6,20 L18,20 C19.2,20 20,19.3 20,18 L20,7.20710678 C20,7.07449854 19.9473216,6.94732158 19.8535534,6.85355339 L17,4 Z M17,11 L7,11 L7,4 L17,4 L17,11 Z" fill="#000000" fill-rule="nonzero"/>
                                <rect fill="#000000" opacity="0.3" x="12" y="4" width="3" height="5" rx="0.5"/>
                            </g>
                        </svg><!--end::Svg Icon--></span>
                        Insert
                    </button>
            </div>

        </form>
    </div>
</div>

<style type="text/css">
	.select2-container--default .select2-selection--single .select2-selection__rendered{
padding: 0.15rem 1rem 0.45rem 0.5rem !important;
	}
</style>

<!-- <script>
    $(document).on('change', '#team', function() {
        $("#ht_id").val($("#pipe_teams option[value='" + $("#team").val() + "']").attr("ht_id"));
    });
</script> -->
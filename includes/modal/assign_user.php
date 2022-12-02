<div class="modal modal2" id="assign_user_modal" style="display: none;">
    <div class="modal-content2" id="connection_modal_content">
        <div class="modal-header modal-header2">
            <h2 id="modal-title">Assign Pipeline User</h2>
            <span class="modal_close2" ng-click="show_hide_div('#assign_user_modal')">&times;</span>
        </div>

        <form ng-submit="assign_persona($event,form)" id="connectionform" name="connectionform" class="ui form">
            <div class="modal-body column">
                <div class="row">
                    <div class="col">
                        <label for="from">Persona Name</label>

                        <input class="form-control" type="text" id="personaName" ng-model="form.personaName" disabled />
                    </div>
                </div>
                <!-- <div class="row">
                    <div class="col">
                        <label for="from">Assign User</label>
                        <md-autocomplete flex role="combobox" md-selected-item="text" md-no-cache="true" md-search-text="searchText" md-search-text-change="search_employees(searchText)" md-items="item in usersList" md-item-text="item.fullname" md-min-length="5" md-selected-item-change="ctrl.get_user(item);" on-enter ng-cloak>
                            <span id="autocompleteText" md-highlight-text="searchText" md-highlight-flags="^i">{{item.fullname}} </span>
                        </md-autocomplete>
                        <input class="form-control" type="hidden" ng-model="form.user_id" required />
                        <input class="form-control" type="hidden" id="personaId" ng-model="form.personaId" required />
                    </div>
                </div> -->

                <div class="row mt-4">
                    <div class="col-md-6">
                        <label for="from">Primary SMM Owner</label>
                        <select id="pipe_user_id2" ng-model="form.pipe_user_id2" class="form-control" >
                            <option ng-repeat="i in allEmployees" value="{{ i.id }}">{{ i.name }}</option>
                        </select>
                    </div>
                </div> 


                <div class="row mt-4">
                    <div class="col">
                        <label for="from">Other users that can access this persona:</label>
                        <select id="assigned-users2" class="form-control"  multiple="multiple">
                            <option ng-repeat="i in allEmployees" value="{{ i.id }}">{{ i.name }}</option>
                        </select>
                    </div>
                </div>
                <!-- <div class="field">
                    <div class="six wide field" style="width: 100% !important;">
                        
                        <label for="from">Assign User</label>
                        <md-autocomplete flex role="combobox" md-selected-item="text" md-no-cache="true" md-search-text="searchText" md-search-text-change="search_employees(searchText)" md-items="item in usersList" md-item-text="item.fullname" md-min-length="5" md-selected-item-change="ctrl.get_user(item);" on-enter ng-cloak>
                            <span id="autocompleteText" md-highlight-text="searchText" md-highlight-flags="^i">{{item.fullname}} </span>
                        </md-autocomplete>
                        <input class="form-control" type="hidden" ng-model="form.user_id" required />
                        <input class="form-control" type="hidden" id="personaId" ng-model="form.personaId" required />
                        <br>
                    </div>
                </div> -->
            </div>

            <div class="modal-footer field">
                <button type="submit" ng-disabled="connectionform.$invalid" id="insertConnection" class="btn btn-primary">
                    <span class="svg-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
                            <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                            <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z" />
                        </svg>
                    </span>
                    Assign
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
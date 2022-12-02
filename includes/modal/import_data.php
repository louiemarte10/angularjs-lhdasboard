<div class="modal fade " id="import_modal" data-backdrop="" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl " role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title text-dark font-weight-bolder" id="exampleModalLabel">Import</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
               <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" ng-click="goToTab('tm-outbound-tab')" role="tab" aria-controls="home" aria-selected="true">TM Outbound</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" ng-click="goToTab('digital-marketing-tab')" role="tab" aria-controls="profile" aria-selected="false">Digital Marketing Tool</a>
               </li>
            </ul>
            <div class="tab-content">
               <div class="tab-pane fade show active" id="tm-outbound-tab" role="tabpanel">
                  <form ng-submit="importData()" id="importform" name="importform">
                     <div class="modal-body">               
                        <div class="form-row">
                           <div class="form-group col-md-6">
                              <label for="inputState">Department</label>
                              <select id="inputState" class="form-control form-control-sm" ng-model="selectDept" ng-change="getClients()" ng-options="dept as dept.node for dept in departments">
                                 <!-- <option selected>Select Department</option>
                                 <option ng-repeat="i in departments" value="{{i.id}}">{{i.node}}</option> -->
                              </select>
                           </div>
                           <div class="form-group col-md-6">
                              <label for="inputState">Client</label>
                              <select id="inputState" class="form-control form-control-sm" ng-model="selectClient" ng-change="getClientAccounts()" ng-options="client as client.client for client in clients">
                              <!-- <option selected>Select Client</option>
                              <option ng-repeat="i in clients">{{i}}</option> -->
                              </select>
                           </div>
                        </div>
                        <div class="form-row">
                           <div class="form-group col-md-3">
                              <label for="inputState">Client Account</label>
                              <select id="inputState" class="form-control form-control-sm" ng-model="selectClientAccount" ng-change="getClientLists()" ng-options="client_account as client_account.account_number for client_account in clientAccounts">
                              <!-- <option selected>Select Account</option>-->
                              </select> 
                           </div>
                           <div class="form-group col-md-6">
                              <label for="inputState">List</label>
                              <select id="inputState" class="form-control form-control-sm" ng-model="selectList" ng-change="getList()" ng-options="list as list.list for list in clientLists">
                              <!-- <option selected>Select List</option> -->
                              </select>
                           </div>
                           <div class="form-group col-md-3">
                              <label for="inputState">Status</label>
                              <select id="inputState" required class="form-control form-control-sm" ng-model="selectEvent" ng-change="getEventState()" ng-options="event_state as event_state.event_state for event_state in eventStates">                        
                              </select> 
                           </div>                     
                        </div>
                        <div class="form-row">                        
                           <div class="form-group col-md-6">
                              <div class="form-row">
                                 <div class="form-group form-check col mb-1">
                                    Date & Time that will reflect in Pipeline
                                 </div>
                              </div> 
                              <div class="form-row">
                                 <div class="ml-5 form-group form-check col" style="margin-bottom: 0">
                                    <input type="checkbox" class="form-check-input" ng-model="dateConnected" ng-disabled="isDateConnected" ng-change="dateConnectedChange()">
                                    <label style="margin-top: 2px" class="form-check-label">Use Date Connected found in Linkedin</label>
                                 </div>
                              </div> 
                              <div class="form-row">
                                 <div class="ml-5 form-group form-check col mb-2">
                                    <input type="checkbox" class="form-check-input" ng-disabled="specDate" ng-model="checkDate" ng-change="checkDateChange()">
                                    <label style="margin-top: 2px" class="form-check-label">Use Specific Date and Time:</label>
                                 </div>
                              </div>  
                              <div class="form-row">
                                 <div class="form-group col-md-6">
                                    <label for="inputState">Date</label>
                                    <input type="date" class="form-control form-control-sm" ng-model="dateInserted" ng-disabled="disableDate">
                                 </div>
                                 <div class="form-group col-md-6">
                                    <label for="inputState">Time</label>
                                    <input type="time" class="form-control form-control-sm" ng-model="timeInserted" ng-disabled="disableDate">
                                 </div>      
                              </div>
                           </div>            
                        </div>                                               
                     </div>
                     <div class="modal-footer">
                        <div style="margin-right: auto">You are about to import {{ selectedCount }} contact(s).</div>
                        <button type="submit" ng-disabled="importform.$invalid" class="btn btn-light-primary font-weight-bold">Import</button>
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                     </div>
                  </form>
               </div>
               <div class="tab-pane fade" id="digital-marketing-tab" role="tabpanel">
                  <form ng-submit="insertToDMT()" id="importform2" name="importform2">
                     <div class="modal-body">               
                        <div class="form-row">
                           <div class="form-group col-md-4">
                              <label for="inputState">Department</label>
                              <select required id="inputState" class="form-control form-control-sm" ng-model="selectDept" ng-change="getClients()" ng-options="dept as dept.node for dept in departments">
                              </select>
                           </div>
                           <div class="form-group col-md-4">
                              <label for="inputState">Client</label>
                              <select required id="inputState" class="form-control form-control-sm" ng-model="selectClient" ng-change="getClientAccounts()" ng-options="client as client.client for client in clients">
                              </select>
                           </div>
                           <div class="form-group col-md-4">
                              <label for="inputState">Client Account</label>
                              <select required id="inputState" class="form-control form-control-sm" ng-model="selectClientAccount" ng-change="getClientLists()" ng-options="client_account as client_account.account_number for client_account in clientAccounts">                              
                              </select> 
                           </div>  
                        </div>
                        <div class="form-row">
                           <div class="form-group col-md-3">
                              <label for="inputState">Connections</label>
                              <input required type="number" ng-model="connections" class="form-control form-control-sm">
                           </div>  
                           <div class="form-group col-md-3">
                              <label for="inputState">Direct Message Sent</label>
                              <input required type="number" ng-model="directMessageSent" class="form-control form-control-sm">
                           </div>
                           <div class="form-group col-md-3">
                              <label for="inputState">Connection Invite Sent</label>
                              <input required type="number" ng-model="connectionInviteSent" class="form-control form-control-sm">
                           </div>  
                           <div class="form-group col-md-3">
                              <label for="inputState">Inmail Received</label>
                              <input required type="number" ng-model="inmailReceived" class="form-control form-control-sm">
                           </div> 
                        </div>
                        <div class="form-row">
                           <div class="form-group col-md-3">
                              <label for="inputState">Date</label>
                              <input type="date" class="form-control form-control-sm" ng-model="dateInserted" required>
                           </div>
                           <div class="ml-10 mt-10 form-group col-md-3">
                              <input class="form-check-input" type="checkbox" style="transform: scale(1.3);" ng-model="isGeneric">
                              <label class="form-check-label ml-1">Generic</label>    
                           </div>
                           <!-- <div class="ml-5 form-group form-check col mb-2">
                              <input type="checkbox" class="form-check-input" ng-disabled="specDate" ng-model="checkDate" ng-change="checkDateChange()">
                              <label style="margin-top: 2px" class="form-check-label">Use Specific Date and Time:</label>
                           </div> -->
                        </div>                                                            
                     </div>
                     <div class="modal-footer">
                        <button type="submit" ng-disabled="importform2.$invalid" class="btn btn-light-primary font-weight-bold">Import</button>
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                     </div>
                  </form>
               </div>
            </div>            
        </div>
    </div>
</div>
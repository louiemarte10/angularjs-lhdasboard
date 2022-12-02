app.controller("homeCtrl", function ($scope, $http, $window, data, $compile, $rootScope, $routeParams) {
    // data.getData("GET", "https://pipeline.callboxinc.com/pipeline/debugJp/4950628/123", {}).then(function (data) {

    //     console.log(data);
    // });
    // var id = $routeParams.id;        




    var logged_userId = 0;

    if (typeof $("#logged_userId").val() != "undefined") {
        if ($("#logged_userId").val() > 0) {
            logged_userId = $("#logged_userId").val();
            console.log(logged_userId);
        }
    }
    // window.location.href = '/pipeline/linkedin-dashboard/';
    $rootScope.$on('$locationChangeSuccess', function (event) {
        var url = window.location.url,
            params = window.location.search;
        console.log(url);
        console.log(params);
        if (params == "?logoff") {
            location.reload();
        }
    })
    var self = this;
    self.get_user = get_user;
    $scope.isShowConnections = "";

    $scope.personaList = [];
    $scope.personaNames = [];
    $scope.teamList = [];
    $scope.form = [];
    $scope.personaName = null;
    $scope.personaEmail = null;
    $scope.personaType = null;

    $scope.contactForm = [];
    $scope.usersList = [];

    $scope.selectedTeamList = [];
    $scope.selectedTeamList_str = [];


    $scope.phone_numbers_edit = {};
    $scope.isCurrentlyEmployed = false;
    $scope.selectedUser = "";
    $scope.curPage = 0;
    $scope.pageSize = 100;
    $scope.currentPage = 0;
    $scope.lastPage = 10;
    $scope.numberOfPages = 0;

 

    $scope.modalData = [];
    $scope.editInfo = [];
    // $scope.organization = {};
    $scope.organization = [];
    // var selected = [];
    var selected = {};

    var scrollto_id = "";

    $scope.departments = []
    $scope.clients = []
    $scope.clientAccounts = []
    $scope.clientLists = []
    $scope.eventStates = []

    $scope.country_list = []
    $scope.campaign_list = []

    $scope.isNoCountry = "";
    $scope.isValidEmails = "";

    $scope.selectedDept = 0
    $scope.selectedClient = 0
    $scope.selectedClientAccount = 0
    $scope.selectedClientList = 0
    $scope.selectedEventState = 0
    $scope.selectedCampaign = 0

    $scope.disableDate = true
    $scope.dateInserted = null
    $scope.timeInserted = null
    $scope.specDate = false
    $scope.dateConnected = false
    $scope.isDateConnected = true
    $scope.selectedCount = 0
    $scope.selectedConnectionsFilter = 0
    $scope.dateFilterDisable = true
    $scope.positionFilter = ""
    $scope.isExactPosition = false
    $scope.dateFilter = {
        type: 'select',
        value: 0,
        values: [
            {
                id: 0, label: ''
            },
            {
                id: 1, label: 'Date Added'
            },
            {
                id: 2, label: 'Date Connected'
            }
        ]
    }


    $scope.campaignNames = {
        type: 'select',
        value: 0,
        values: []
    }
    $scope.connectionsFilter = {
        type: 'select',
        value: 0,
        values: [
            {
                id: 0, label: ''
            },
            {
                id: 1, label: 'Show Connected Only'
            },
            {
                id: 2, label: 'Show Not Yet Connected'
            }
        ]
    }



    $scope.test_function_jp = function (val) {
        alert(val);
    }

    $scope.search_employees_debug = function (val) {
        console.log(val);

    }

    function scrollTo(selector) {
        document.querySelector(selector).scrollIntoView({ behavior: 'smooth' });
        window.scroll({
            top: 1,
            left: 0,
            behavior: 'smooth'
        });
    }
    data.getData("POST", "api/api.php", { "query_type": "getCountries" }).then(function (data) {

        $scope.country_list = data;
        // $scope.contactForm 
        console.log($scope.country_list);
    });

 
        data.getData("POST", "api/api.php", { "query_type": "getcamp" , "personaId": $routeParams.personaId, "name": "", "logged_userId": logged_userId}).then(function (data) {

        $scope.campaign_list = data;
         // $scope.pp = personaId;
        console.log($scope.campaign_list);
    });
    
    $scope.rowCount = $("#tableID tr .align-left").length;

    //      (() => {
    //     const p = {
    //         "query_type": "getcamp",
    //         "personaId": $routeParams.personaId,
    //         "name": "",
    //         "logged_userId": logged_userId
    //     }
    //     data.getData("POST", "api/api.php", p).then(res => $scope.campaign_list.values = res)
    // })()
  

    
    $scope.search_employees = function (val) {
        // var val = $("#tags").val();
        console.log(val.length);
        if (typeof val !== "undefined" && val.length >= 2) {

            console.log(val);
            data.getData("POST", "api/api.php", { "query_type": "getEmployees", "search": val }).then(function (res) {

                $scope.usersList = [];


                $scope.usersList = res;
                // angular.forEach(res, function (value, key) {
                //     Object.assign($scope.usersListByUserId, { key3: value.user_id });
                //     // $scope.usersListByUserId[parseInt(value.user_id)].push(value);
                // });


            });



        }
 
    }   

    $scope.search_organization = function (val) {
        // var val = $("#tags").val();
        console.log(val.length);
        console.log(val);
        // $scope.organization = [];
        if (typeof val !== "undefined" && val.length >= 2) {

            console.log(val);
            data.getData("POST", "api/api.php", { "query_type": "getOrganization", "search": val }).then(function (res) {
                console.log(res);
                // $scope.organization = {};
                $scope.organization = [];

                $scope.organization = res;
                $(window).scrollTop(0);
                // angular.forEach(res, function (value, key) {
                //     $scope.organization[value['organization_lkp_id']] = value;
                // });


            });



        }


    }
    $scope.remove_primary = function (indx) {

        if (indx >= 0) {
            $scope.phone_numbers_edit[indx]['primary'] = null;
        }
        console.log($scope.phone_numbers_edit[indx]);
    }
    $scope.selected_organization = function (org) {
        //
        console.log(org);

        $("#editCompany").val(org.organization_name);

    }
    function get_user(user) {
        // console.log(user);
        if (typeof user !== "undefined") {
            let found_user = $scope.usersList.find(o => o.user_id == user.user_id);
            if (typeof found_user.user_id !== "undefined") {
                console.log(found_user.length);
                console.log(found_user);
                $scope.form.user_id = found_user.user_id;
            }
        } else {
            $scope.form.user_id = "";
        }
        console.log($scope.form.user_id);


    }
    $scope.show_hide_contact = function (linkedin_account_persona_id) {
        console.log($scope.contactForm[parseInt(linkedin_account_persona_id)]);
        if ($scope.contactForm[parseInt(linkedin_account_persona_id)] == "show") {
            $scope.contactForm[parseInt(linkedin_account_persona_id)] = "no";
        } else {
            $scope.contactForm[parseInt(linkedin_account_persona_id)] = "show";


        }
        //    $scope.contactForm[list.linkedin_account_persona_id] == 'show'
        $('[data-toggle="popover"]', document).each(function () {
            $(this).popover();
        });

    }

    $scope.show_hide_div = function (div) {
        if ($(div).is(":visible")) {
            $(div).hide();
        } else {
            $(div).show();

        }
        $scope.selectedTeamList = [];
        $scope.form.email = "";
        $scope.form.fullname = "";
        $scope.form.team = "";

    }
    $scope.getEmployeeByTeam = function (team_name) {
        // $('#foobar').attr('foo','bar'); 

        if (team_name != "" || team_name != null) {
            var t_name = $("#pipe_teams option[value='" + team_name + "']").attr("team_name");
            var ht_id = $("#pipe_teams option[value='" + team_name + "']").attr("ht_id");
            if (typeof t_name !== "undefined" && typeof ht_id !== "undefined") {
                var team_push = {};
                // team_push[ht_id] = { "team": t_name, "ht_id": ht_id }; 
                team_push = { "team": t_name, "ht_id": ht_id };
                var isFound = false;
                for (var i = 0; i < $scope.selectedTeamList.length; i++) {
                    if ($scope.selectedTeamList[i].ht_id == ht_id) {
                        isFound = true;
                        break;
                    }
                }

                if (team_push != null && isFound == false) {
                    $scope.selectedTeamList.push(team_push);
                }

                // $scope.selectedTeamList_str.push(t_name);

                console.log($scope.selectedTeamList);
                $scope.form.team = "";
                // $scope.form.selectedTeam = $scope.selectedTeamList_str.join(', ');
                // $scope.form.selectedTeam = $scope.selectedTeamList_str.join('<Br>');
                // var selectedTeam = document.getElementById("selectedTeam");
                // selectedTeam.innerHTML = "";
                // angular.forEach($scope.selectedTeamList, function (value, key) {
                //     // ng-click="removeFromSelectedTeam(\'' + parseInt(value.ht_id) + '\')"
                //     selectedTeam.innerHTML += value.team + '<button type="button" id="selected' + value.ht_id + '" style="border:none; background-color: transparent; color: red">x</button><Br>';
                //     $('#selected' + value.ht_id).replaceWith($('#selected' + value.ht_id));

                //     // change ng-click
                //     $('#selected' + value.ht_id).attr('ng-click', 'removeFromSelectedTeam(' + value.ht_id + ')');

                //     // compile the element

                // });

                // $compile($('#selectedTeam'))($scope);

            }

        }






    }
    $scope.removeFromSelectedTeam = function (ht_id) {
        console.log(ht_id + " has been removed!");
        // const index = $scope.selectedTeamList.indexOf(ht_id);
        // if (index > -1) {
        //     $scope.selectedTeamList.splice(index, 1); // 2nd parameter means remove one item only
        // }
        for (var i = 0; i < $scope.selectedTeamList.length; i++) {
            if ($scope.selectedTeamList[i].ht_id == ht_id) {
                $scope.selectedTeamList.splice(i, 1);
                break;
            }
        }
        console.log($scope.selectedTeamList);

    }

    // data.getData("POST", "api/api.php", { "query_type": "getTeam" }).then(function (data) {

    //     $scope.teamList = data;
    //     // $scope.contactForm 
    //     console.log($scope.teamList);
    // });
    $scope.getPersona = function (personaId = 0, name = "", req_type = "all") {

        if (($('#dateFrom').val() === "" || $('#dateTo').val() === "") && ![undefined, 0].includes($scope.dateFilter.value.id)) {

            Swal.fire({
                icon: 'error',
                title: `Please choose date range`,
            })
            return false
        }

        $scope.personaList = [];

        selected = {};
        if (req_type == "all") {
            data.getData("POST", "api/api.php", { "query_type": "getPersonaWithJoins", "personaId": 0, "name": "", "logged_userId": logged_userId }).then(function (data) {
                angular.forEach(data, function (value, key) {
                    // console.log(value);
                    // if()
                    $scope.contactForm[value.linkedin_account_persona_id] = "no";
                    $scope.personaList.push(value);
                    // $('#country-dropdown').select2()
                    $('#country-dropdown');

                });

                // $scope.personaList = data;
            });
        } else if (req_type == "byDate") {
            /* if (($routeParams.personaId > 0 && $('#dateFrom').val().length > 0 && $('#dateTo').val().length > 0) || $scope.selectedCampaign !== "0" || selectedCountries.length > 0) {
                
                // $scope.sendRequest("POST", "api/api.php", { "query_type": "getPersonaWithJoins", "personaId": personaId, "name": "" });
            } */
            var from = $('#dateFrom').val();
            var to = $('#dateTo').val();
            const selectedCountries = $("#country-dropdown").val();
            let params = {
                "campaign_helper_id": $scope.campaignNames.value.id,
                "query_type": "getPersonaWithJoinsDebug",  
                 // "query_type": "getPersonaWithJoins",
                "personaId": $routeParams.personaId,
                "name": "",
                "logged_userId": logged_userId,
                "from": $('#dateFrom').val(),
                "to": $('#dateTo').val(),
  
                "date_filter": $scope.dateFilter.value.id,
   
            }

            data.getData("POST", "api/api.php", params).then(function (data) {
                angular.forEach(data, function (value, key) {
                    // console.log(value);
                    // if()
                    $scope.contactForm[value.linkedin_account_persona_id] = "no";
                    $scope.personaList.push(value);
                });
                $(document).ready(function () {
                    angular.forEach(selected, function (value) {
                        var elem = "#chkBox_" + value.linkedin_account_persona_id + "_" + value.data_id;

                        $(elem).prop('checked', true);
                    });
                    if (scrollto_id.length > 0) {
                        // scrollTo("#" + scrollto_id);
                        $('html,body').animate({ scrollTop: $("#" + scrollto_id).offset().top - 215 }, 'slow');

                    }
                    $('#dateFrom').val(from);
                    $('#dateTo').val(to);
                    $('#country-dropdown');
                    $('#country-dropdown').val(selectedCountries).trigger("change")
                });
                // $scope.personaList = data;
            });
        } else {
            if (personaId > 0) {

                //don't delete/modify start
                $http({
                    method: "POST",
                    url: "api/api.php",
                    data: { "query_type": "getPersonaWithJoinsDebug", "personaId": personaId, "name": "", "logged_userId": logged_userId }
                }).then(function (response) {
                    console.log(response);
                     $scope.pID = personaId;
                    // $scope.pID2 = response.data.organization_end;
                    // $scope.campaignNames.values
                    $scope.personaList = response.data;
                    $scope.personaName = response.data.my_fullname;
                    $scope.personaEmail = response.data.my_email;
                    $scope.personaType = response.data.account_type;
                    $scope.numberOfPages = Math.ceil(response.data.contacts.length / $scope.pageSize);
                    // $http({
                    //     method: "POST",
                    //     url: "api/api.php",
                    //     data: { "query_type": "getPersonaDataWithJoinsDebug", "personaId": personaId, "name": "", "logged_userId": logged_userId }
                    // }).then(function (response1) {
                    //     console.log(response1);
                    console.log($scope.personaList);

                    // }, function (response1) {
                    //     console.log(response1);
                    // });

                }, function (response) {
                    console.log(response);
                });
        
            } else if (name != "") {
                data.getData("POST", "api/api.php", { "query_type": "getPersonaWithJoins", "personaId": 0, "name": name, "logged_userId": logged_userId }).then(function (data) {

                    $scope.personaNames = data;
                    $('#country-dropdown');
                });
                // $scope.sendRequest("POST", "api/api.php", { "query_type": "getPersonaWithJoins", "personaId": 0, "name": name });
            }
        }

        $(document).ready(function () {
            // //
            $scope.isShowConnections = "";
            $('#country-dropdown');

        });
    }

    $scope.showConnections = function (val) {
        if (val == true) {
            $scope.isShowConnections = true;
        } else {
            $scope.isShowConnections = "";
        }
    }




    $scope.showNoCountries = function (val) {
        clearCheckbox()
        $scope.isNoCountry = val === true ? true : ""
    }
    $scope.showValidEmails = function (val) {
        clearCheckbox()
        $scope.isValidEmails = val === true ? "valid" : null;

        console.log($scope.isValidEmails);
    }
        


    $scope.getDate = function(){

        const dfrom = $('#dateFrom').val();
        const dto = $('#dateTo').val();
        const selectedCountries = $("#country-dropdown").val();
    $scope.personaList = [];
            //  let params = {
            //     "campaign_helper_id": $scope.campaignNames.value.id,
            //     "query_type": "getPersonaWithJoinsDebug",
            //     "personaId": $routeParams.personaId,
            //     "name": "",
            //     "logged_userId": logged_userId,
            //     "from":dfrom,
            //     "to": dto
            // }

             let params = {
                "campaign_helper_id": $scope.campaignNames.value.id,
                "query_type": "getPersonaWithJoinsDebug",
                "personaId": $routeParams.personaId,
                "name": "",
                "logged_userId": logged_userId,
                "from": dfrom,
                "to": dto,
                "country_filter": selectedCountries,
                "connections_filter": $scope.connectionsFilter.value.id,
                "date_filter": $scope.dateFilter.value.id,
                "position_filter": $scope.positionFilter,
                "is_exact_position": $scope.isExactPosition
            }


            
            data.getData("POST", "api/api.php", params).then(function (data) {
                angular.forEach(data, function (value, key) {
                    // console.log(value);
                    // if()
                    $scope.contactForm[value.linkedin_account_persona_id] = "no";
                    $scope.personaList.push(value);
                });
             
                $scope.personaList = data;

          
            });

     


    }
    



                // $http({
                //     method: "GET",
                //     url: "load_campaign.php"
                //     // data: { "query_type": "get_campaign_name2", "personaId": personaId, "name": "", "logged_userId": logged_userId }
                // }).success(function(data){  
                // $scope.campaigns = data;  
                //  }) 

      

        
    


    $scope.clearSearch = () => {
        // $("#campaignName").val('0').change();
        // $('#country-dropdown').val(null).trigger('change')
        // $('#dateFrom').val(null)
        // $('#dateTo').val(null)
        // $scope.campaignNames.value = 0
        // // selectedConnectionsFilter = 0
        // $scope.connectionsFilter.value = 0
        // $scope.isExactPosition = false
        // $scope.positionFilter = ""
        // $scope.getPersona($routeParams.personaId, "", "user")
        // selected = {}
        // clearCheckbox()
        location.reload();
    }

    


    $scope.addPersona = function (e, formdata) {
        if ($scope.selectedTeamList != "") {
            formdata.selectedteam = $scope.selectedTeamList;
        } else {
            formdata.selectedteam = "0";
        }

        formdata.query_type = "createPersona";


        e.preventDefault();
        Swal.fire({
            title: 'Are you sure do you want to create this persona?',
            // input: 'text',
            // inputAttributes: {
            //     autocapitalize: 'off'
            // },
            showCancelButton: true,
            confirmButtonText: 'Create',
            showLoaderOnConfirm: true,
            preConfirm: (login) => {
                data.getData("POST", "api/api.php", { "query_type": "createPersona", "fullname": formdata.fullname, "email": formdata.email, "team_id_access": formdata.selectedteam, "account_type": formdata.account_type }).then(function (result) {
                    if (result.message == "successfull") {

                        Swal.fire(
                            'Success',
                            'Persona has been successfully created.',
                            'success'
                        ).then(() => {
                            window.location.reload();//where you want to redirect after success
                        });

                    } else if (result.message == "exist") {
                        // alert("Email: " + formdata.email + " is already used by \n persona " + result.existed_data.my_fullname);
                        Swal.fire({
                            title: '<strong>Exist</strong>',
                            icon: 'info',
                            html:
                                "" + formdata.email + " is already used by persona " + result.existed_data.my_fullname,
                            showCloseButton: true,
                            showCancelButton: false,
                            focusConfirm: false
                            // confirmButtonText:
                            //     '<button></button>',
                            // confirmButtonAriaLabel: 'Thumbs up, great!',
                            // cancelButtonText:
                            //     '<button>Close</button>',
                            // cancelButtonAriaLabel: 'Closes'
                        })
                    }
                    else if (result.message == "error") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: 'Error type: ' + result.error_type + '<Br><Br>' + "Error: " + result.error_info,
                            footer: '<a href="">Please contact programmers</a>'
                        })
                    }
                    // $scope.getPersona(0, "", "all");
                });
                // return fetch(`//api.github.com/users/${login}`)
                //     .then(response => {
                //         if (!response.ok) {
                //             throw new Error(response.statusText)
                //         }
                //         return response.json()
                //     })
                //     .catch(error => {
                //         Swal.showValidationMessage(
                //             `Request failed: ${error}`
                //         )
                //     })
            },
            allowOutsideClick: () => !Swal.isLoading()
        });


    }
    $scope.copyTextToClipboard = function (text) {
        var dummy = document.createElement("textarea");
        document.body.appendChild(dummy);
        dummy.value = text;
        dummy.select();
        document.execCommand("copy");
        document.body.removeChild(dummy);
        // alert("webhook url copied")
        Swal.fire("webhook url copied");
        // Swal.fire("webhook url copied <a href=''>test</a>");

    }

    $scope.showContactInfo = function (info) {
        console.log(info);
        $scope.modalData = [];
        info.other_details = [];
        data.getData("POST", "api/api.php", { "query_type": "getContactOtherCompanies", "data_id": info.data_id }).then(function (result) {
            console.log(result);
            info.other_details = result[0];
            // $scope.phone_numbers_edit = result;
        });
        data.getData("POST", "api/api.php", { "query_type": "getContactOtherEmails", "data_id": info.data_id, "linkedin_account_persona_id": info.linkedin_account_persona_id }).then(function (result) {
            console.clear();
            console.log(result);
            info.other_emails = result;
            // $scope.phone_numbers_edit = result;
        });
        $scope.modalData.push(info);
        if (!$('#contact_info').is(':visible')) {
            $('#contact_info').modal('toggle');
        } else {
            $('#contact_info').modal('toggle');


        }
        console.log($scope.modalData);
    }
    $scope.showImportModal = function () {
        /* $scope.modalData = [];
        $scope.modalData.push(); */
        resetForm()
        getDepartments()
        if (Object.keys(selected).length > 0) {
            if (!$('#import_modal').is(':visible')) {
                $('#import_modal').modal('toggle');
            } else {
                $('#import_modal').modal('toggle');
            }
        } else {
            Swal.fire({
                icon: 'error',
                title: `Please select one or more contacts`,
            })
        }


    }
    $scope.editContact = function (type, info) {
        console.clear();
        $scope.editInfo = [];
        $scope.editInfo.push(info);
        $scope.phone_numbers_edit = {};
        data.getData("POST", "api/api.php", { "query_type": "getContactPhoneNumbers", "data_id": info.data_id }).then(function (result) {
            console.log(result);
            var count = 0;
            angular.forEach(result, function (value) {
                // if ($row3['phone_number_id'] == $row1['phone_num_id']) {
                //     $row3['primary'] = "Phone";
                // }
                // if ($row3['phone_number_id'] == $row1['mobile_num_id']) {
                //     $row3['primary'] = "Mobile";
                // }
                // if ($row3['phone_number_id'] == $row1['direct_line_num_id']) {
                //     $row3['primary'] = "Direct Line";
                // }
                if (info.phone_num_id == value.phone_number_id) {
                    value.primary = "Phone";
                }
                if (info.mobile_num_id == value.phone_number_id) {
                    value.primary = "Mobile";
                }
                if (info.direct_line_num_id == value.phone_number_id) {
                    value.primary = "Direct Line";
                }
                value.isNew = 0;
                $scope.phone_numbers_edit[count] = value;
                $scope.phone_numbers_edit[count]['elem_id'] = "phone_type_" + count;
                $scope.phone_numbers_edit[count]['indx'] = count;
                count += 1;
            });
            // $scope.phone_numbers_edit = result;
        });

        // if (typeof info.phone_numbers != 'undefined') {
        //     var count = 0;
        //     angular.forEach(info.phone_numbers, function (value) {
        //         $scope.phone_numbers_edit[count] = value;
        //         $scope.phone_numbers_edit[count]['elem_id'] = "phone_type_" + count;
        //         $scope.phone_numbers_edit[count]['indx'] = count;

        //         count += 1;
        //     });

        // }

        var size = Object.keys($scope.phone_numbers_edit).length;
        console.log(size);
        console.log($scope.editInfo);
        $('#edit_modal').show();
        console.log(info.country_id);
        $('#country').val(info.country_id);

    }
    $scope.init_country = function (country_id) {


        // $('#country').val(country_id).change();
        $scope.country = country_id;
        console.log(country_id);
        console.log($scope.country);

    }
    $scope.map_company = function (data_id, org) {
        // org['organization_id']
        org.user_id = logged_userId;
        console.log(org);
        console.log(data_id);
        // logged_userId
        data.getData("POST", "api/api.php", { "query_type": "mapCompany", "data_id": data_id, "org": org }).then(function (res) {
            console.clear();
            console.log(res);
            scrollto_id = "contact_" + data_id;
            $scope.getPersona($routeParams.personaId, "", "user");
            $('#contact_info').hide();


        });


    }
    $scope.init_phone_type = function (key, type) {
        // org['organization_id']
        console.log(key);
        console.log(type);
        // $("#phone_type_" + key).val(val).change();
        var elem = '#phone_type_' + key;
        console.log(elem);
        $(elem).ready(function () {
            $(elem + ' option[value="' + type + '"]').prop('selected', "selected");
        });


        // document.querySelector(elem).value = val;
        // $(elem).val(type);

    }
    $scope.init_phone_status = function (key, type) {
        // org['organization_id']
        console.log(key);
        console.log(type);
        // $("#phone_type_" + key).val(val).change();
        var elem = '#phone_type_status_' + key;
        console.log(elem);
        $(elem).ready(function () {
            $(elem + ' option[value="' + type + '"]').prop('selected', "selected");
        });


        // document.querySelector(elem).value = val;
        // $(elem).val(type);

    }


    $scope.update_contact = function (e, form) {

        console.log(form);
        console.log($("#country").val());
        var update_data = {};
        var org = {};

        var searchInput = document.getElementById('input-1');

        var value_search = "";
        // editCompany
        console.log($("input[name=mdSearchCompany]").val());
        console.log($("#editCompany").val());
        console.log($('#isCurrentlyEmployed').is(':checked'));


        console.log(form.isCurrentlyEmployed);
        if (typeof $("input[name=mdSearchCompany]").val() != "undefined" && $("input[name=mdSearchCompany]").val().length > 0) {

            if (typeof $("input[name=mdSearchCompany]").val() != "undefined" && $("input[name=mdSearchCompany]").val() != null || $("input[name=mdSearchCompany]").val() != "") {

                value_search = $("input[name=mdSearchCompany]").val();
            }
            else if (typeof searchInput.value == "undefined" && searchInput.value == null || searchInput.value == "") {
                value_search = $("#editCompany").val();
            }
        } else {
            value_search = $("#editCompany").val();
        }

        if ($("#fname").val() != form.first_name) {
            update_data['first_name'] = $("#fname").val();
        }
        if ($("#lname").val() != form.last_name) {

            update_data['last_name'] = $("#lname").val();
        }
        update_data['email'] = $("#contact_email").val();
        if ($("#editCompany").val() != form.company) {

            org['organization'] = value_search;
            org['organization_title'] = $("#position").val();
            org['organization_location'] = $("#organization_location_1").val();




        }
        if ($("#position").val() != form.organization_title_1) {

            org['organization'] = value_search;
            org['organization_title'] = $("#position").val();
            org['organization_location'] = $("#organization_location_1").val();
            // update_data['org'] = org;

        }
        if ($("#organization_location_1").val() != form.organization_location_1) {

            org['organization'] = value_search;
            org['organization_title'] = $("#position").val();
            org['organization_location'] = $("#organization_location_1").val();
            // update_data['org'] = org;

        }

        if ($("#organization_location_1").val() != form.organization_location_1) {

        }


        if (Object.keys($scope.phone_numbers_edit).length > 0) {

            angular.forEach($scope.phone_numbers_edit, function (value, key) {
                $scope.phone_numbers_edit[key]['phone_type'] = $("#phone_type_" + key).val();
                $scope.phone_numbers_edit[key]['phone'] = $("#phone_" + key).val();
            });

            update_data['phones'] = $scope.phone_numbers_edit;


        }

        if ($("#country").val() > 0) {
            org = {};

            org['organization'] = value_search;
            org['organization_title'] = $("#position").val();
            org['organization_location'] = $("#organization_location_1").val();
            console.log(org);
            update_data['country'] = $("#country").val();
        }
        if ($('#isCurrentlyEmployed').is(':checked')) {
            org['organization_start'] = $("#org_start").val();
            org['organization_end'] = $("#org_end").val();
        }
        org['user_id'] = logged_userId;
        console.log(org);
        console.log($scope.personaList);
        update_data['linkedin_account_persona_id'] = $scope.personaList.linkedin_account_persona_id;

        var size = Object.keys(update_data).length;
        var phone_size = Object.keys($scope.phone_numbers_edit).length;
        if (size > 0 || phone_size > 0) {
            if (value_search != form.company) {
                // start
                Swal.fire({
                    // title: '<strong></strong>',
                    icon: 'info',
                    html:
                        "Do you want to add " + value_search + " to this contact's company history?",
                    // showCloseButton: true,
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Update and add to history",
                    denyButtonText: "Update without saving to history",
                    cancelButtonText: "Close Without Saving",
                    focusConfirm: false,
                    customClass: {
                        actions: 'my-actions',

                        confirmButton: 'order-1',
                        denyButton: 'order-2',
                        cancelButton: 'order-3',
                    }
                }).then(function (res) {
                    console.log(res);
                    if (res.isConfirmed) {
                        org['add_to_history'] = true;
                        update_data['org'] = org;
                        console.log($scope.phone_numbers_edit);

                        data.getData("POST", "api/api.php", { "query_type": "updateContact", "data_id": form.data_id, "update": update_data }).then(function (data) {

                            console.log(data);
                            scrollto_id = "contact_" + form.data_id;
                            // $scope.getPersona($routeParams.personaId, "", "user");
                            $('#edit_modal').hide();
                            Swal.fire('Saved!', '', 'success')

                        });

                    } else if (res.isDenied) {
                        update_data['org'] = org;
                        console.log($scope.phone_numbers_edit);

                        data.getData("POST", "api/api.php", { "query_type": "updateContact", "data_id": form.data_id, "update": update_data }).then(function (data) {

                            console.log(data);
                            scrollto_id = "contact_" + form.data_id;
                            $scope.getPersona($routeParams.personaId, "", "user");
                            $('#edit_modal').hide();
                            Swal.fire('Saved!', '', 'success')

                        });
                        // console.log(res);
                        // $scope.show_hide_div('#assign_user_modal', []);
                    }
                    else {
                        Swal.fire('Changes are not saved', '', 'info')
                    }
                });
                //end

                // Swal.fire({
                //     title: '<strong>Warning</strong>',
                //     icon: 'info',
                //     html:
                //         "Do you want to change this contact organization to this " + value_search + "?",
                //     showCloseButton: true,
                //     showCancelButton: true,
                //     confirmButtonText: "Yes",
                //     cancelButtonText: "Cancel",
                //     focusConfirm: false,
                // }).then(function (res) {
                //     // console.log(res);
                //     if (res.isConfirmed) {
                //         org['add_to_history'] = true;
                //         update_data['org'] = org;
                //         console.log($scope.phone_numbers_edit);

                //         data.getData("POST", "api/api.php", { "query_type": "updateContact", "data_id": form.data_id, "update": update_data }).then(function (data) {

                //             console.log(data);

                //             scrollto_id = "contact_" + form.data_id;
                //             // $scope.getPersona($routeParams.personaId, "", "user");
                //             $('#edit_modal').hide();


                //         });

                //     } else {
                //         $('#edit_modal').hide();
                //     }
                // });


            } else {
                // // update_data['org'] = org;
                // console.log(org.organization);
                update_data['org'] = org;

                console.log(update_data);
                console.log("test1");

                data.getData("POST", "api/api.php", { "query_type": "updateContact", "data_id": form.data_id, "update": update_data }).then(function (data) {

                    console.log(data);
                    scrollto_id = "contact_" + form.data_id;
                    // $scope.getPersona($routeParams.personaId, "", "user");
                    $('#edit_modal').hide();


                });
            }



        } else {
            console.log("test2");

            // $('#edit_modal').hide();


        }

        // }


    }

    $scope.addOrg = function (org_name) {
        var org = {};
        org['organization'] = org_name;
        org['organization_title'] = $("#position").val();
        org['organization_location'] = $("#organization_location_1").val();
        Swal.fire({
            title: '<strong>Warning</strong>',
            icon: 'info',
            html:
                "Do you want to add " + org_name + " to contact organization/company history?",
            showCloseButton: true,
            showCancelButton: true,
            focusConfirm: false,
        }).then(function (res) {
            // console.log(res);
            alert(org_name);

        });


    }
    $scope.add_phone = function (data_id) {
        //
        var count = 0;
        var size = Object.keys($scope.phone_numbers_edit).length;
        if (data_id > 0) {
            if (size > 0) {


                var for_add_phone = {
                    data_id: data_id, phone: "", phone_type: "work", x: "active", isNew: 1
                }
                $scope.phone_numbers_edit[(size + 1)] = for_add_phone;


            } else if (size <= 0) {


                var for_add_phone = {
                    data_id: data_id, phone: "", phone_type: "work", x: "active", isNew: 1
                }
                $scope.phone_numbers_edit[0] = for_add_phone;


            }
        }
        console.clear();
        console.log($scope.phone_numbers_edit);

    }
    $scope.change_phone_type = function (indx, phone_type) {


        var elem = "#phone_type_" + indx;
        $scope.phone_numbers_edit[indx]['phone_type'] = $(elem).val();
        console.log(indx);
        console.log($scope.phone_numbers_edit[indx]);




    }
    $scope.remove_phone = function (indx) {
        //
        console.log(indx);
        if (indx >= 0) {

            $scope.phone_numbers_edit[indx]['x'] = 'inactive';
            $scope.init_phone_status(indx, 'inactive');
        }
    }
    $scope.set_as_primary_no = function (indx, phone_type) {

        var indicator = "";
        console.log(indx);
        console.log(phone_type);
        if (phone_type == 'Mobile') {
            indicator = "Mobile";
        } else if (phone_type == 'Phone') {
            indicator = "Phone";
        } else if (phone_type == 'Direct Line') {
            indicator = "Direct Line";
        }

        if (indicator != "") {
            angular.forEach($scope.phone_numbers_edit, function (value, key) {
                if (typeof value.primary != "undefined") {

                    if (value.primary == indicator) {
                        // delete value.primary;
                        value.primary = null;
                    }
                }
                console.log(value);
            });
            $scope.phone_numbers_edit[indx]['primary'] = indicator;
        }
        // var elem = "#phone_type_" + indx;
        // $scope.phone_numbers_edit[indx]['phone_type'] = $(elem).val();
        // console.log(indx);
        console.log($scope.phone_numbers_edit[indx]);





    }

    $scope.selectContact = function (data) {
        // selected.push(data);

        //

        var elem = "#chkBox_" + data.linkedin_account_persona_id + "_" + data.data_id
        if ($(elem).prop('checked')) {
            selected[data.data_id] = data;
            // $scope.selectedCount = selected.length;                        
        } else {
            delete selected[data.data_id];
            // $scope.selectedCount = selected.length;            
            $("#chk_all").prop('checked', false)
        }

    }
    // $scope.getPersona = function (personaId = 0, name = "", req_type = "all") {

    $scope.getPersona($routeParams.personaId, "", "user");

    $scope.selectAll = function (all_data) {
        console.log(all_data);
        //
        var counts = 0;
        if ($("#chk_all").prop('checked')) {
            // $scope.selectedCount = 0;

            angular.forEach(all_data, function (value, key) {

                if ($scope.isNoCountry) {
                    if (value.has_country === "no") {
                        selected[value.data_id] = value;
                        counts += 1;
                    }
                } else {
                    selected[value.data_id] = value;
                    counts += 1;
                }
                // $scope.selectedCount++;
            });
            $('.chk_all').click()
            $('.chk_all').prop('checked', true);



        } else {
            selected = {};
            $('.chk_all').click()
            $('.chk_all').prop('checked', false);
            // $scope.selectedCount = 0;
        }
    }
    function downloadCSV(csv, filename) {
        var csvFile;
        var downloadLink;

        // CSV File
        csvFile = new Blob([csv], { type: "text/csv" });

        // download link
        downloadLink = document.createElement("a");

        // file name
        downloadLink.download = filename;

        // create link to file
        downloadLink.href = window.URL.createObjectURL(csvFile);

        // hide download link
        downloadLink.style.display = "";

        // add link to DOM
        document.body.appendChild(downloadLink);

        // click download link
        downloadLink.click();
    }
    function downloadableCSVNew(filename, rows) {
        var processRow = function (row) {
            var finalVal = '';
            for (var j = 0; j < row.length; j++) {
                var innerValue = row[j] === null ? '' : row[j].toString();
                if (row[j] instanceof Date) {
                    innerValue = row[j].toLocaleString();
                };
                var result = innerValue.replace(/"/g, '""');
                if (result.search(/("|,|\n)/g) >= 0)
                    result = '"' + result + '"';
                if (j > 0)
                    finalVal += ',';
                finalVal += result;
            }
            return finalVal + '\n';
        };

        var csvFile = '';
        for (var i = 0; i < rows.length; i++) {
            csvFile += processRow(rows[i]);
        }

        var blob = new Blob([csvFile], { type: 'text/csv;charset=utf-8;' });
        if (navigator.msSaveBlob) { // IE 10+
            navigator.msSaveBlob(blob, filename);
        } else {
            var link = document.createElement("a");
            if (link.download !== undefined) { // feature detection
                // Browsers that support HTML5 download attribute
                var url = URL.createObjectURL(blob);
                link.setAttribute("href", url);
                link.setAttribute("download", filename);
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                const c = confirm(`Download CSV?`)

                 if (c) {
                function removeClass(){  
                myButton.className = myButton.className.replace(new RegExp('(?:^|\\s)loading(?!\\S)'), '');
                }
                var myButton = document.getElementById('myButton');
                myButton.className = myButton.className + ' loading';
                setTimeout(removeClass, 2000);
                setTimeout(function() {                         
                 link.click()
                }, 2000);

                  }

                document.body.removeChild(link);
            }
        }
    }

    function downloadableCSV(rows) {

        // let csvContent = "data:text/csv;charset=utf-8,\uFEFF" + encodeURI(rows.map(e => e.join(",")).join("\n"))

        // console.log(exportData);
        let csvContent = "data:text/csv;charset=utf-8,%EF%BB%BF" + encodeURI(rows.map(e => e.join(",")).join("\n"));
        // console.log(csvContent);
        // const encodedUri = encodeURI(csvContent)
        const encodedUri = csvContent;
        // console.log(csvContent)
        const link = document.createElement("a")

        link.setAttribute("href", encodedUri)

        link.setAttribute("download", `contacts.csv`)

        document.body.appendChild(link)

        const c = confirm(`Download CSV?`)

        if (c)
            link.click()

    }
    $scope.exportToCsv_Normal_Users = function () {
        var keys = Object.keys(selected);
        if (keys.length === 0) {
            Swal.fire({
                icon: 'error',
                title: `Please select one or more contacts`,
            })
        } else {
            var exportData = [];
            exportData.push(
                [

                    'Linkedin Profile'
                ]
            );
            keys.forEach((element) => {
                var elemData = []
                console.log(selected[element]);
                var position = "";
                var company = "";
                var address = "";


                var phone_no = "";
                var mobile_no = "";
                var direct_no = "";

                // angular.forEach(selected[element]['other_details']['companies'], function (value, key) {
                //     console.log(value);
                //     if (typeof value['selected'] != "undefined") {
                //         if (value['selected'] == 1) {
                //             position = value['organization_title'];
                //             company = value['organization'];
                //             address = value['organization_location'];
                //         }

                //     }

                // });
                // angular.forEach(selected[element]['phone_numbers'], function (value, key) {
                //     console.log(value);
                //     if (typeof value['primary'] != "undefined") {
                //         if (value['primary'] == "Direct Line") {
                //             direct_no = value['phone'];
                //         }
                //         else if (value['primary'] == "Mobile") {
                //             mobile_no = value['phone'];
                //         }
                //         else if (value['primary'] == "Phone") {
                //             phone_no = value['phone'];
                //         }

                //     }

                // });
                elemData.push(

                    selected[element]['linkedin_url'] !== null ? selected[element]['linkedin_url'].split(',').join(' ') : ""

                    // selected[element]['contact_fullname'] !== null ? selected[element]['contact_fullname'].split(',').join(' ') : "",
                    // selected[element]['contact_email'],
                    // selected[element]['company'] !== null ? selected[element]['company'].split(',').join(' ') : "",
                    // selected[element]['organization_title_1'] !== null ? selected[element]['organization_title_1'].split(',').join(' ') : "",
                    // selected[element]['linkedin_url'] !== null ? selected[element]['linkedin_url'].split(',').join(' ') : ""
                    // selected[element]['organization_location_1'].split(',').join(' ')
                )
                exportData.push(elemData)
            })
            // downloadableCSVNew("test", elemData);

            // downloadableCSV(exportData)
            downloadableCSVNew("contacts", exportData);

        }
    }

    $scope.exportToCsv_FullDownload = function () {
        var keys = Object.keys(selected);
        var exportData = [];
        if (keys.length === 0) {
            Swal.fire({
                icon: 'error',
                title: `Please select one or more contacts`,
            })
        } else {

            exportData.push(
                [
                    'first name',
                    'last name',
                    'position',
                    'email',
                    'primary phone',
                    'primary mobile',
                    'primary direct line',
                    'company',
                    'address',
                    'country',
                    'industry',
                    'Date connected',
                    'Linkedin Profile',
                    'Date Added',
                    "Email Source",
                    "Email Status",
                    "Other Emails"
                ]
            );
            keys.forEach((element) => {
                var elemData = []
                console.log(selected[element]);
                console.log(selected[element]['other_emails']);
                // var position = "";
                // var company = "";
                // var address = "";
                var phone_no = selected[element]['phone_num'];
                var mobile_no = selected[element]['mobile_num'];
                var direct_no = selected[element]['direct_line_num'];
                var other_email_data = "";
                angular.forEach(selected[element]['other_emails'], function (value, key) {
                    console.log(value);
                    if (value.source_name == "") {
                        value.source_name = "LH Email Finder";
                    }
                    other_email_data += value.email + "-" + value.status + "-" + value.source_name + "\n";
                    // if (typeof value['selected'] != "undefined") {
                    //     if (value['selected'] == 1) {
                    //         position = value['organization_title'];
                    //         company = value['organization'];
                    //         address = value['organization_location'];
                    //     }

                    // }

                });
                 // angular.forEach(selected[element]['other_details']['companies'], function (value, key) {
                     angular.forEach(selected[element]['other_details'],selected[element]['companies'], function (value, key) {
                    // console.log(value);
                    if (typeof value['selected'] != "undefined") {
                        if (value['selected'] == 1) {
                            position = value['organization_title'];
                            company = value['organization'];
                            address = value['organization_location'];
                        }

                    }

                });

                angular.forEach(selected[element]['phone_numbers'], function (value, key) {
                    // console.log(value);
                    if (typeof value['primary'] != "undefined") {
                        if (value['primary'] == "Direct Line") {
                            direct_no = value['phone'];
                        }
                        else if (value['primary'] == "Mobile") {
                            mobile_no = value['phone'];
                        }
                        else if (value['primary'] == "Phone") {
                            phone_no = value['phone'];
                        }

                    }

                });
                elemData.push(

                    selected[element]['first_name'] !== null ? selected[element]['first_name'] : "",
                    selected[element]['last_name'] !== null ? selected[element]['last_name'] : "",
                    // position !== null ? position : "",
                    selected[element]['organization_title'] !== null ? selected[element]['organization_title'] : "",
                    selected[element]['contact_email'] !== null ? selected[element]['contact_email'] : "",
                    phone_no !== null ? phone_no : "",
                    mobile_no !== null ? mobile_no : "",
                    direct_no !== null ? direct_no : "",
                    // company !== null ? company : "",
                     selected[element]['company'] !== null ? selected[element]['company'] : "",
                    // address !== null ? address : "",
                    selected[element]['organization_location_1'] !== null ? selected[element]['organization_location_1'] : "",
                    selected[element]['country'] !== null ? selected[element]['country'] : "",
                    // selected[element]['industry'] !== null ? selected[element]['industry'] : "",
                    selected[element]['organization_title'] !== null ? selected[element]['organization_title'] : "",
                    selected[element]['cn_date_connected'] !== null ? selected[element]['cn_date_connected'] : "",
                    selected[element]['linkedin_url'] !== null ? selected[element]['linkedin_url'] : "",
                    selected[element]['pure_date_added'] !== null ? selected[element]['pure_date_added'] : "",
                    selected[element]['contact_email_source'] !== null ? selected[element]['contact_email_source'] : "",
                    selected[element]['contact_email_status'] !== null ? selected[element]['contact_email_status'] : "",
                    other_email_data !== null ? other_email_data : ""

 

                    // selected[element]['first_name'] !== null ? selected[element]['first_name'] : "",
                    // selected[element]['last_name'] !== null ? selected[element]['last_name'] : "",
                    // position !== null ? position : "",
                    // selected[element]['contact_email'] !== null ? selected[element]['contact_email'] : "",
                    // phone_no !== null ? phone_no : "",
                    // mobile_no !== null ? mobile_no : "",
                    // direct_no !== null ? direct_no : "",
                    // company !== null ? company : "",
                    // address !== null ? address : "",
                    // selected[element]['country'] !== null ? selected[element]['country'] : "",
                    // selected[element]['industry'] !== null ? selected[element]['industry'] : "",
                    // selected[element]['cn_date_connected'] !== null ? selected[element]['cn_date_connected'] : "",
                    // selected[element]['linkedin_url'] !== null ? selected[element]['linkedin_url'] : "",
                    // selected[element]['pure_date_added'] !== null ? selected[element]['pure_date_added'] : "",
                    // selected[element]['contact_email_source'] !== null ? selected[element]['contact_email_source'] : "",
                    // selected[element]['contact_email_status'] !== null ? selected[element]['contact_email_status'] : "",
                    // other_email_data !== null ? other_email_data : ""




                    // selected[element]['contact_fullname'] !== null ? selected[element]['contact_fullname'].split(',').join(' ') : "",
                    // selected[element]['contact_email'],
                    // selected[element]['company'] !== null ? selected[element]['company'].split(',').join(' ') : "",
                    // selected[element]['organization_title_1'] !== null ? selected[element]['organization_title_1'].split(',').join(' ') : "",
                    // selected[element]['linkedin_url'] !== null ? selected[element]['linkedin_url'].split(',').join(' ') : ""
                    // selected[element]['organization_location_1'].split(',').join(' ')
                )
                // elemData.push(
                //     selected[element]['first_name'] !== null ? selected[element]['first_name'].split(',').join(' ') : "",
                //     selected[element]['last_name'] !== null ? selected[element]['last_name'].split(',').join(' ') : "",
                //     position !== null ? position.split(',').join(' ') : "",
                //     selected[element]['contact_email'] !== null ? selected[element]['contact_email'].split(',').join(' ') : "",
                //     phone_no !== null ? phone_no.split(',').join(' ') : "",
                //     mobile_no !== null ? mobile_no.split(',').join(' ') : "",
                //     direct_no !== null ? direct_no.split(',').join(' ') : "",
                //     company !== null ? company.split(',').join(' ') : "",
                //     address !== null ? address.split(',').join(' ') : "",
                //     selected[element]['country'] !== null ? selected[element]['country'].split(',').join(' ') : "",
                //     selected[element]['industry'] !== null ? selected[element]['industry'].split(',').join(' ') : "",
                //     selected[element]['cn_date_connected'] !== null ? selected[element]['cn_date_connected'].split(',').join(' ') : "",
                //     selected[element]['linkedin_url'] !== null ? selected[element]['linkedin_url'].split(',').join(' ') : "",
                //     selected[element]['pure_date_added'] !== null ? selected[element]['pure_date_added'].split(',').join(' ') : ""

                //     // selected[element]['contact_fullname'] !== null ? selected[element]['contact_fullname'].split(',').join(' ') : "",
                //     // selected[element]['contact_email'],
                //     // selected[element]['company'] !== null ? selected[element]['company'].split(',').join(' ') : "",
                //     // selected[element]['organization_title_1'] !== null ? selected[element]['organization_title_1'].split(',').join(' ') : "",
                //     // selected[element]['linkedin_url'] !== null ? selected[element]['linkedin_url'].split(',').join(' ') : ""
                //     // selected[element]['organization_location_1'].split(',').join(' ')
                // )
                exportData.push(elemData)
            })
            console.log(exportData);

            // downloadableCSV(exportData)
            downloadableCSVNew("contacts", exportData);

        }
    }

    $scope.goToTab = function (tab) {

        switch (tab) {
            case 'tm-outbound-tab':
                $('#' + tab).addClass('show active')
                $('#digital-marketing-tab').removeClass('show active')
                break;
            case 'digital-marketing-tab':
                $('#' + tab).addClass('show active')
                $('#tm-outbound-tab').removeClass('show active')
                break;

        }

    }

    $scope.insertToDMT = function () {
        let formData = {
            hierarchy_tree_id: $scope.selectedDept,
            client_id: $scope.selectedClient,
            clientaccount: $scope.selectedClientAccount,
            user_id: logged_userId,
            date_from: dateFormat($scope.dateInserted, $scope.dateInserted),
            connections: $scope.connections,
            direct_message_sent: $scope.directMessageSent,
            connection_invite_sent: $scope.connectionInviteSent,
            inmail_received: $scope.inmailReceived,
            is_generic: $scope.isGeneric,
            persona_name: $scope.personaName
        }

        data.getData("POST", "api/api.php", { query_type: 'insert_to_dmt', 'form_data': formData }).then(res => {
            $('#import_modal').modal('toggle')
            // $('.chk_all').prop('checked', false);
            Swal.close()
            if (typeof res !== 'object') {
                Swal.fire({
                    icon: 'error',
                    title: `There's an error uploading. Please Contact Softdev for support.`
                })
            } else {
                Swal.fire({
                    icon: res.status,
                    title: res.message
                })
            }
            clearCheckbox()
            resetForm()
        })

        console.log(formData)
    }

    $scope.importData = function () {

        let formData = {
            hierarchy_tree_id: $scope.selectedDept,
            client_id: $scope.selectedClient,
            clientaccount: $scope.selectedClientAccount,
            client_list_id: $scope.selectedClientList,
            event_state_lkp_id: $scope.selectedEventState,
            channel_lkp_id: 3,
            user_id: logged_userId
        }

        let no_connection = 0
        let no_countries = []

        angular.forEach(selected, function (value, key) {

            if (value.connection_id === null)
                no_connection++

            if (value.has_country === "no")
                no_countries.push(value.contact_fullname)

        })

        if (no_countries.length > 0) {
            Swal.fire({
                icon: 'error',
                title: `Please add a country to the following contact(s) first`,
                html: no_countries.join("<br/>")
            })
            return false
        }

        if ($scope.checkDate) {
            if ($scope.dateInserted === null || $scope.timeInserted === null) {
                Swal.fire({
                    icon: 'error',
                    title: `Please select date and time.`,
                })
                return false
            }
            formData.upload_date = dateFormat($scope.dateInserted, $scope.timeInserted)
        }

        if (parseInt(formData.event_state_lkp_id) === 618) {
            if (no_connection > 0) {
                Swal.fire({
                    icon: 'error',
                    title: `Unable to import. ${no_connection} contact(s) has no date connected.`,
                    text: `When importing 'Connection Accepted', please filter show connections only.`,
                })
                return false
            }
        }

        const params = {
            'query_type': 'import_to_tm_outbound',
            'formData': formData,
            'contacts': selected,
            'selected_count': $scope.selectedCount,
            'is_spec_date': $scope.checkDate,
            'is_connection_accepted': $scope.dateConnected
        }

        Swal.fire({
            html: '<h2>Importing..</h2><br/><p>Please wait...</p>',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        })

        data.getData("POST", "api/api.php", params).then(res => {
            $('#import_modal').modal('toggle')
            // $('.chk_all').prop('checked', false);            
            Swal.close()
            if (typeof res !== 'object') {
                Swal.fire({
                    icon: 'error',
                    title: `There's an error uploading. Please Contact Softdev for support.`
                })
            } else {
                Swal.fire({
                    icon: res.status,
                    title: res.message
                })
            }
            clearCheckbox()
            resetForm()
        })

    }

    $scope.selectCampaignChange = function (e) {
        $scope.selectedCampaign = e.selectCampaign
    }

    $scope.selectConnectionsFilter = function (e) {
        $scope.selectedConnectionsFilter = e.selectConnectionsF
    }

    $scope.getClients = function () {
        $scope.clientAccounts = []
        $scope.eventStates = []
        if ($scope.selectDept !== null) {
            $scope.selectedDept = $scope.selectDept.id
            data.getData("POST", "api/api.php", { "query_type": "get_clients", "dept_id": $scope.selectDept.id }).then(res => $scope.clients = res)
        }
        // consoleLog($scope)
    }

    $scope.getClientAccounts = function () {
        $scope.clientLists = []
        $scope.eventStates = []
        if ($scope.selectClient !== null) {
            $scope.selectedClient = $scope.selectClient.id
            data.getData("POST", "api/api.php", { "query_type": "get_client_accounts", "client_id": $scope.selectClient.id }).then(res => $scope.clientAccounts = res)
        }
    }

    $scope.getClientLists = function () {
        if ($scope.selectClientAccount !== null) {
            $scope.selectedClientAccount = $scope.selectClientAccount.id
            data.getData("POST", "api/api.php", { "query_type": "get_client_lists", "client_account_id": $scope.selectClientAccount.id }).then(res => $scope.clientLists = res)
        }
    }

    $scope.getList = function () {
        $scope.eventStates = []
        if ($scope.selectList !== null) {
            $scope.selectedClientList = $scope.selectList.id
            data.getData("POST", "api/api.php", { "query_type": "get_event_states", "client_list_id": $scope.selectList.id }).then(res => $scope.eventStates = res)
        }
    }

    $scope.getEventState = function () {
        if ($scope.selectEvent !== null && $scope.selectEvent !== undefined) {
            $scope.selectedEventState = $scope.selectEvent.id
            if ($scope.selectEvent.id === "618") {
                // $scope.dateConnected = true
                $scope.isDateConnected = false
            } else {
                $scope.isDateConnected = true
                $scope.dateConnected = false
                $scope.disableDate = false
                $scope.specDate = false
                $scope.checkDate = true
            }
        }
    }

    $scope.checkDateChange = function () {
        if ($scope.checkDate !== null) {
            $scope.disableDate = !$scope.checkDate
            if (!$scope.checkDate) {
                $scope.dateInserted = null
                $scope.timeInserted = null
            }
        }
    }

    $scope.dateConnectedChange = function () {
        if ($scope.dateConnected !== null) {

            $scope.specDate = $scope.dateConnected

            if ($scope.checkDate) {
                $scope.checkDate = !$scope.checkDate
                $scope.disableDate = !$scope.checkDate
            }

            if ($scope.dateConnected) {
                $scope.dateInserted = null
                $scope.timeInserted = null
            }
        }
    }

    $scope.dateFilterChange = function () {
        $scope.dateFilterDisable = $scope.dateFilter.value.id === 0
        if ($scope.dateFilter.value.id === 0) {
            $('#dateFrom').val(null)
            $('#dateTo').val(null)
        }
    }

    $scope.connectionFilterChange = function () {
        // $scope.dateFilterDisable = $scope.connectionsFilter.value.id === 0
        $scope.getPersona(0, '', 'byDate')
    }

     $scope.testCampaignFilter = function (test) {
        // $scope.dateFilterDisable = $scope.connectionsFilter.value.id === 0
        // $scope.getPersona(0, '', 'byDate')
        alert(test);
    }

    const getDepartments = () => {
        data.getData("POST", "api/api.php", { "query_type": "get_department" }).then(res => $scope.departments = res)
        console.log($scope.departments);
    }

    (() => {
        const p = {
            "query_type": "get_campaign_name",
            "personaId": $routeParams.personaId,
            "name": "",
            "logged_userId": logged_userId
        }
        data.getData("POST", "api/api.php", p).then(res => $scope.campaignNames.values = res)
    })()

 

    $scope.getSelectValue = function (indx) {
        // $scope.dateFilterDisable = $scope.connectionsFilter.value.id === 0
        var elem_id = "#phone_type_" + indx;

        if (indx >= 0) {
            $scope.phone_numbers_edit[indx]['phone_type'] = $(elem_id).val();
        }
        console.log($scope.phone_numbers_edit[indx]);
    }

    const consoleLog = data => console.log(data)

    const dateFormat = (date, time) => {
        return `${date.getFullYear()}-${date.getMonth() + 1}-${date.getDate()} ${time.getHours()}:${time.getMinutes()}:${time.getSeconds()}`
    }

    const resetForm = () => {

        $scope.departments = []
        $scope.clients = []
        $scope.clientAccounts = []
        $scope.clientLists = []
        $scope.eventStates = []

        $scope.selectedDept = 0
        $scope.selectedClient = 0
        $scope.selectedClientAccount = 0
        $scope.selectedClientList = 0
        $scope.selectedEventState = 0

        $scope.checkDate = true
        $scope.disableDate = false
        $scope.dateInserted = null
        $scope.timeInserted = null
        $scope.specDate = false
        $scope.dateConnected = false
        $scope.isDateConnected = true
        $scope.selectedCount = 0
        $scope.selectedCount = Object.keys(selected).length;

        $scope.connections = 0
        $scope.directMessageSent = 0
        $scope.connectionInviteSent = 0
        $scope.inmailReceived = 0
        $scope.isGeneric = false
        angular.forEach(selected, function (value, key) {

            if (value.connection_id !== null) {
                $scope.connections++
                $scope.directMessageSent++
            }

            $scope.connectionInviteSent++

        })
    }

    const clearCheckbox = () => {
        $('.chk_all').each(function () {
            if ($(this).prop('checked') === true) {
                $(this).click()
            }
        })
    }
    // $scope.numberOfPages = function () {
    //     // alert($scope.personaList.contacts.length);
    //     $(document).ready(function () {
    //         console.clear();
    //         return Math.ceil($scope.personaList.contacts.length / $scope.pageSize);
            
    //     });

    // };



});
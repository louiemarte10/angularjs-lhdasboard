app.controller("homeCtrl", function ($scope, $http, $window, data, $compile, $rootScope, $routeParams) {
    // data.getData("GET", "https://pipeline.callboxinc.com/pipeline/debugJp/4950628/123", {}).then(function (data) {

    //     console.log(data);
    // });
    // var id = $routeParams.id;
    var logged_userId = 0;

    if (typeof $("#logged_userId").val() != "undefined") {
        if ($("#logged_userId").val() > 0) {
            logged_userId = $("#logged_userId").val();
        }
    }
    console.log(logged_userId);
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
    $scope.message_info = [];
    $scope.order_by = '-send_date';
    $scope.filterMsgType = '';

    $scope.personaList = [];
    $scope.personaNames = [];
    $scope.teamList = [];
    $scope.form = [];

    $scope.contactForm = [];
    $scope.usersList = [];

    $scope.selectedTeamList = [];
    $scope.selectedTeamList_str = [];

    $scope.selectedUser = "";

    $scope.pageSize = 10;
    $scope.currentPage = 0;
    $scope.lastPage = 10;

    $scope.modalData = [];

    $scope.search_employees_debug = function (val) {
        console.log(val);

    }
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
    $scope.view_messages = function (val) {
        // org['organization_id']
        console.log(val);
        $scope.message_info = [];
        $scope.message_info.push(val);
        $scope.filterMsgType = '';
        // data.getData("POST", "api/api.php", { "query_type": "getMessages", "data_id": val.data_id, "linkedin_account_persona_id": val.linkedin_account_persona_id }).then(function (data) {
        //     console.log(data);

        //     $scope.message_info = [];
        //     val.messages = data;
        //     $scope.message_info.push(val);

        //     // angular.forEach(data, function (value, key) {
        //     //     $scope.message_info.push(value);
        //     // });


        //     // $scope.getPersona(0, "", "all");
        // });
        // data.getData("POST", "api/api.php", { "query_type": "getMessages", "data_id": data.data_id, "linkedin_account_persona_id": data.linkedin_account_persona_id }).then(function (res) {
        //     // $scope.message_info = [];
        //     // $scope.message_info.push(res);
        //     console.log(res);
        //     // $scope.personaNames = data;
        // });
    }

    data.getData("POST", "api/api.php", { "query_type": "getTeam" }).then(function (data) {

        $scope.teamList = data;
        // $scope.contactForm 
        // console.log($scope.teamList);
    });
    $scope.getPersona = function (personaId = 0, name = "", req_type = "all") {
        $scope.personaList = [];
        console.log(personaId);
        console.log(name);
        console.log(req_type);
        if (req_type == "all") {
            data.getData("POST", "api/api.php", { "query_type": "getPersonaWithJoins", "personaId": 0, "name": "", "logged_userId": logged_userId }).then(function (data) {
                angular.forEach(data, function (value, key) {
                    console.log(value);
                    // if()
                    $scope.contactForm[value.linkedin_account_persona_id] = "no";
                    $scope.personaList.push(value);
                });

                // $scope.personaList = data;
                console.log(data);
            });
        } else {
            if (personaId > 0) {
                data.getData("POST", "api/api.php", { "query_type": "getPersonaWithJoins", "personaId": personaId, "name": "", "logged_userId": logged_userId }).then(function (data) {
                    console.log(data);
                    angular.forEach(data, function (value, key) {

                        // if()
                        $scope.contactForm[value.linkedin_account_persona_id] = "no";
                        $scope.personaList.push(value);
                    });
                    // $scope.personaList = data;
                });
                // $scope.sendRequest("POST", "api/api.php", { "query_type": "getPersonaWithJoins", "personaId": personaId, "name": "" });
            } else if (name != "") {
                data.getData("POST", "api/api.php", { "query_type": "getPersonaWithJoins", "personaId": 0, "name": name, "logged_userId": logged_userId }).then(function (data) {

                    $scope.personaNames = data;
                });
                // $scope.sendRequest("POST", "api/api.php", { "query_type": "getPersonaWithJoins", "personaId": 0, "name": name });
            }
        }

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
                console.log(formdata);
                data.getData("POST", "api/api.php", { "query_type": "createPersona", "fullname": formdata.fullname, "email": formdata.email, "team_id_access": formdata.selectedteam, "account_type": formdata.account_type }).then(function (result) {
                    console.log(result);
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
        $scope.modalData.push(info);
        if (!$('#contact_info').is(':visible')) {
            $('#contact_info').modal('toggle');
        } else {
            $('#contact_info').modal('toggle');


        }
    }
    $scope.map_company = function (data_id, org) {
        // org['organization_id']
        console.log(org);
        console.log(data_id);

        data.getData("POST", "api/api.php", { "query_type": "mapCompany", "data_id": data_id, "org": org }).then(function (res) {
            console.log(res);
            $scope.getPersona(0, "", "all");
        });

    }

    // $scope.getPersona = function (personaId = 0, name = "", req_type = "all") {

    $scope.getPersona($routeParams.personaId, "", "user");





});
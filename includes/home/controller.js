app.controller("homeCtrl", function ($scope, $http, $window, data, $compile, $rootScope, $routeParams) {
    // data.getData("GET", "https://pipeline.callboxinc.com/pipeline/debugJp/4950628/123", {}).then(function (data) {

    //     console.log(data);
    // });
    // var id = $routeParams.id;

    console.log($routeParams.pageNo);
    console.log($("#logged_userId").val());
    var logged_userId = 0;

    if (typeof $("#logged_userId").val() != "undefined") {
        if ($("#logged_userId").val() > 0) {
            logged_userId = $("#logged_userId").val();
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

    $scope.personaList = [];
    $scope.personaNames = [];
    $scope.teamList = [];
    $scope.form = [];
    $scope.formEdit = [];

    $scope.contactForm = [];
    $scope.usersList = [];

    $scope.selectedTeamList = [];
    $scope.selectedTeamList_str = [];

    $scope.selectedUser = "";

    $scope.pageSize = 10;
    $scope.currentPage = 0;
    $scope.lastPage = 10;

    $scope.modalData = [];

    $scope.allEmployees = []

    $scope.search_employees_debug = function (val) {
        console.log(val);

    }
    $scope.search_employees = function (val, user_id = 0) {
        // var val = $("#tags").val();
        console.log(val.length);
        if (typeof val !== "undefined" && val.length >= 2) {

            console.log(val);
            data.getData("POST", "api/api.php", { "query_type": "getEmployeesWithTeam", "search": val }).then(function (res) {

                console.log(res);
                $scope.usersList = [];


                $scope.usersList = res;
                // angular.forEach(res, function (value, key) {
                //     Object.assign($scope.usersListByUserId, { key3: value.user_id });
                //     // $scope.usersListByUserId[parseInt(value.user_id)].push(value);
                // });


            });



        }


    }

    data.getData("POST", "api/api.php", { "query_type": "get_all_employees" }).then(function (data) {
        $scope.allEmployees = data;
    })

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

    $scope.show_hide_div = function (elem, params) {
        $scope.selectedTeamList = [];
        $scope.form.email = "";
        $scope.form.fullname = "";
        $scope.form.team = "";
        $scope.form.user_id = "";
       // $scope.form.pipe_user_id2 = "";
        console.log(params)
        setTimeout(() => {
            $('#assigned-users').select2()
            $('#assigned-users2').select2()
            $('#pipe_user_id2').select2()
           $('#pipe_user_id').select2()
        }, 200)
        if ($(elem).is(":visible")) {
            $(elem).hide();
        } else {
            $(elem).show();



            if (elem == "#assign_user_modal") {
                $('#assigned-users2').val(params.assigned_to.split(",")).trigger("change");
                 $('#pipe_user_id2').val(params.pipe_user_id).trigger("change");   
                console.log(params);
                console.log(params.pipe_user_id+" test "+elem+" / "+params);
                $scope.form.personaId = params.linkedin_account_persona_id;
                $("#personaId").val(params.linkedin_account_persona_id);
                $('#personaName').val(params.my_fullname);
              
             

                $('#input-1').val('');
            } else if (elem == "#connection_modal") {
                $('#input-1').val('');
            } else if (elem == "#edit_persona") {
                $scope.formEdit.editPersonaId = params.linkedin_account_persona_id;
                $scope.formEdit.editFullname = params.my_fullname;
                $scope.formEdit.editEmail = params.my_email;
                $scope.formEdit.editAccount_type = params.account_type.toLowerCase();
                // $("#editAccount_type").val(params.account_type.toUpperCase());
                var team_id_access = params.team_id_access.split(",");
                console.log(team_id_access);
                console.log(params.account_type.toUpperCase());
                // console.log($scope.teamList);
                team_id_access.forEach((team_id) => {
                    let obj = $scope.teamList.find(o => o.hierarchy_tree_id === team_id);
                    console.log(obj);

                    $scope.selectedTeamList.push({ "ht_id": obj.hierarchy_tree_id, "team": obj.team_name });
                });
                // let obj = arr.find(o => o.name === 'string 1');
                // $scope.selectedTeamList
                $('#input-1').val('');
            }

        }

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

    data.getData("POST", "api/api.php", { "query_type": "getTeam" }).then(function (data) {

        $scope.teamList = data;
        // $scope.contactForm 
        // console.log($scope.teamList);
    });


    const splitArr = (arr, size) => {

        const res = [];
            for (let i = 0; i < arr.length; i += size) {
                const chunk = arr.slice(i, i + size);
                res.push(chunk);
            }

        return res;
        
    }


    $scope.getPersona = function (personaId = 0, name = "", req_type = "all") {
        $scope.personaList = [];
        var page_no = 0;
        if (typeof $routeParams.pageNo != "undefined") {
            if ($routeParams.pageNo > 0) {
                page_no = $routeParams.pageNo;
            }
        }

        if (req_type == "all") {
            data.getData("POST", "api/api.php", { "query_type": "getPersonaWithJoins", "personaId": 0, "name": "", "logged_userId": logged_userId, "status": "active", "page_start": page_no }).then(function (data) {
                angular.forEach(data, function (value, key) {
                    // console.log(value);
                    // if()
                    $scope.contactForm[value.linkedin_account_persona_id] = "no";
                    $scope.personaList.push(value);
                });
            });
        } else if (req_type == "byStatus") {
            var searchStatus = 'active';
            if ($scope.status == 'inactive') {
                searchStatus = 'inactive';

            }
            data.getData("POST", "api/api.php", { "query_type": "getPersonaWithJoins", "personaId": personaId, "name": "", "logged_userId": logged_userId, "status": searchStatus, "page_start": page_no }).then(function (data) {                

                angular.forEach(data, function (value, key) {
                    // console.log(value);
                    // if()
                    $scope.contactForm[value.linkedin_account_persona_id] = "no";
                    $scope.personaList.push(value);
                });
            });
        } else {
            if (personaId > 0) {
                data.getData("POST", "api/api.php", { "query_type": "getPersonaWithJoins", "personaId": personaId, "name": "", "logged_userId": logged_userId, "page_start": page_no }).then(function (data) {
                    angular.forEach(data, function (value, key) {
                        // console.log(value);
                        // if()
                        $scope.contactForm[value.linkedin_account_persona_id] = "no";
                        $scope.personaList.push(value);
                    });
                    // $scope.personaList = data;
                });
                // $scope.sendRequest("POST", "api/api.php", { "query_type": "getPersonaWithJoins", "personaId": personaId, "name": "" });
            } else if (name != "") {
                data.getData("POST", "api/api.php", { "query_type": "getPersonaWithJoins", "personaId": 0, "name": name, "logged_userId": logged_userId, "page_start": page_no }).then(function (data) {

                    $scope.personaNames = data;
                });
                // $scope.sendRequest("POST", "api/api.php", { "query_type": "getPersonaWithJoins", "personaId": 0, "name": name });
            }
        }

    }
    $scope.updatePersona = function (e, formdata) {
        // console.log(formdata);
        var team_id_access = "";

        angular.forEach($scope.selectedTeamList, function (value) {
            // console.log(value);
            team_id_access = team_id_access + value.ht_id + ",";

        });





        team_id_access = team_id_access.slice(0, -1);
        formdata['editTeam_id_access'] = team_id_access;
        // console.log(formdata);

        var keys = Object.keys(formdata);
        // console.log(keys);

        var persona_edit_data = [];
        var key_data = {};
        angular.forEach(keys, function (value) {

            key_data[value] = formdata[value];

        });
        persona_edit_data.push(key_data);
        // formdata['query_type'] = "updatePersona";        
        data.getData("POST", "api/api.php", { "query_type": "updatePersona", "persona": persona_edit_data }).then(function (res) {            
            if (res > 0) {

                var personaId = formdata['editPersonaId'];
                let obj = $scope.personaList.find(o => o.linkedin_account_persona_id == personaId);
                var isEdited = "no";
                if (formdata['editFullname'] != obj.my_fullname) {
                    obj.my_fullname = formdata['editFullname'];
                    isEdited = "yes";

                }
                if (formdata['editEmail'] != obj.my_email) {
                    obj.my_email = formdata['editEmail'];
                    isEdited = "yes";

                }
                if (formdata['editAccount_type'] != obj.account_type) {
                    obj.account_type = formdata['editAccount_type'].toUpperCase();
                    isEdited = "yes";

                }
                if (formdata['editTeam_id_access'] != obj.team_id_access) {
                    obj.team_id_access = formdata['editTeam_id_access'];
                    isEdited = "yes";

                }
                if (isEdited == "yes") {
                    $scope.personaList = $scope.personaList.map(x => (x.linkedin_account_persona_id === obj.linkedin_account_persona_id) ? obj : x)                    
                }
                alert("persona successfully modified!");
                $scope.show_hide_div('#edit_persona');

            }
            // if (Number.isInteger(res)) {
            //     alert("persona successfully modified!");
            // }

        });
    }


    $scope.addPersona = function (e, formdata) {
        if ($scope.selectedTeamList != "") {
            formdata.selectedteam = $scope.selectedTeamList;
        } else {
            formdata.selectedteam = "0";
        }

        formdata.query_type = "createPersona";
        const assignedUsers = $("#assigned-users").select2("val");
        const pipe_user_id = $("#pipe_user_id").select2("val");
        // if (pipeUsers.length === 0) {
             if (pipe_user_id == '') {
            Swal.fire({
                icon: 'error',
                title: `Please choose Primary SMM Owner`,
            })
            return false
        }
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
                data.getData("POST", "api/api.php", { "query_type": "createPersona", "logged_userId": logged_userId, "fullname": formdata.fullname, "email": formdata.email, "team_id_access": formdata.selectedteam, "account_type": formdata.account_type, "assigned_to": formdata.user_id, assigned_users: assignedUsers, pipe_users: pipe_user_id, "pipe_user_id": formdata.pipe_user_id }).then(function (result) {
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
        Swal.fire("webhook url copied <br> " + text);
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
    $scope.deactivate_persona = function (personaInfo) {
        // org['organization_id']
        console.log(personaInfo);
        Swal.fire({
            title: '<strong>Warning</strong>',
            icon: 'info',
            html:
                "Are you sure <Br> do you want to deactivate persona <Br> " + personaInfo.my_fullname + "?",
            showCloseButton: true,
            showCancelButton: true,
            focusConfirm: false,
        }).then(function (res) {
            // console.log(res);
            if (res.isConfirmed) {
                var indexOfPersona = $scope.personaList.map((el) => el.linkedin_account_persona_id).indexOf(personaInfo.linkedin_account_persona_id);

                var persona = $scope.personaList[indexOfPersona];

                console.log(persona);
                if (typeof persona.linkedin_account_persona_id != 'undefined') {
                    data.getData("POST", "api/api.php", { "query_type": "setPersonaStatus", "linkedin_account_persona_id": persona.linkedin_account_persona_id, "status": 'inactive' }).then(function (res) {
                        $scope.getPersona(0, "", "all");
                        $("#persona_status").val('active').change();

                    });
                }
            } else {

            }
        });




    }



    $scope.activate_persona = function (personaInfo) {
        // org['organization_id']
        console.log(personaInfo);
        Swal.fire({
            title: '<strong>Warning</strong>',
            icon: 'info',
            html:
                "Are you sure <Br> do you want to re-activate persona <Br> " + personaInfo.my_fullname + "?",
            showCloseButton: true,
            showCancelButton: true,
            focusConfirm: false,
        }).then(function (res) {
            // console.log(res);
            if (res.isConfirmed) {
                var indexOfPersona = $scope.personaList.map((el) => el.linkedin_account_persona_id).indexOf(personaInfo.linkedin_account_persona_id);

                var persona = $scope.personaList[indexOfPersona];

                console.log(persona);
                if (typeof persona.linkedin_account_persona_id != 'undefined') {
                    data.getData("POST", "api/api.php", { "query_type": "setPersonaStatus", "linkedin_account_persona_id": persona.linkedin_account_persona_id, "status": 'active' }).then(function (res) {
                        $scope.getPersona(0, "", "all");
                        // window.location.reload();
                        $("#persona_status").val('active').change();

                    });
                }
            } else {

            }
        });




    }










    $scope.assign_persona = function (e, formdata) {
        // var val = $("#tags").val();
        console.log(formdata);

        if ($('#assigned-users2').select2("val").length === 0) {
            Swal.fire({
                icon: 'error',
                title: `Please select one or more users can access this persona`
            })

            return false
        }




        
         const assignusers = $('#assigned-users2').select2("val").join(",")
         const pipe_user_id2 = $('#pipe_user_id2').select2("val");
           console.log(pipe_user_id2+" "+formdata.assignusers); 
 


        //     if ($('#pipe_user_id2').select2("val").length === 0) {
        //     Swal.fire({
        //         icon: 'error',
        //         title: `Please select one users`
        //     })

        //     return false
        // }  `Are you sure do you want to assign selected users to this persona ${$('#personaName').val()}?`,

       

       
        Swal.fire({
            title: '<strong>Warning</strong>',
            icon: 'info',
            html:
               // `Are you sure do you want to assign selected users to this persona ${$('#personaName').val()}?`,
                `Are you sure do you want to update this persona ${$('#personaName').val()}?`,
            showCloseButton: true,
            showCancelButton: true,
            focusConfirm: false,
        }).then(function (res) {
            // console.log(res);
            if (res.isConfirmed) {
                console.log("confirm");
                data.getData("POST", "api/api.php", { "query_type": "assignUserToPersona", "user_id": assignusers, "personaId": formdata.personaId, "pipe_user_id2": pipe_user_id2 }).then(function (res) {
                    console.log(res);
                    // if (res > 0) {
                        $scope.getPersona(0, "", "all");
                        $scope.show_hide_div('#assign_user_modal', []);
                    // }
                });
            } else {
                console.log(res);
                $scope.show_hide_div('#assign_user_modal', []);
            }
        });


    }

    $scope.getPersona(0, "", "all");




    $(document).ready(function () {
        $("#persona_status").val('active').change();
    });
























});
<?php

try {
    require_once 'config.php';
    require_once 'query.php';
} catch (Exception $e) {
    echo json_encode("awts");
}

$request = json_decode(file_get_contents('php://input'));

$query_type = $request->query_type;
// echo json_encode($request);

$smm = new SMM();
$pipe = new PIPE();
if ($query_type == "debug") {
    echo json_encode($request);
} else if ($query_type == "getContactOtherEmails") {
    $data_id = $request->data_id;
    echo json_encode($smm->getContactOtherEmails($request->data_id, $request->linkedin_account_persona_id));
} else if ($query_type == "getContactPhoneNumbers") {
    $data_id = $request->data_id;

    echo json_encode($smm->getContactPhoneNumbers($data_id));
} else if ($query_type == "getContactOtherCompanies") {
    $data_id = $request->data_id;

    echo json_encode($smm->getContactOtherCompanies($data_id));
} 
// Filter query condition 
elseif ($query_type == "getPersonaWithJoins") {

    $personaId = (int) $request->personaId;
    $name = $request->name;
    $logged_userId = $request->logged_userId;
    $page_start = $request->page_start;
    // $campaign_helper_id = isset($request->campaign_helper_id) ? $request->campaign_helper_id : 0;
    // echo json_encode($page_start + 10);
    // LIMIT $page_no, 50
    if (isset($request->from) && isset($request->to)) {
        echo $smm->getPersonaWithJoins($personaId, $name, $logged_userId, 'active', $request->from, $request->to, $request);
    } elseif ($campaign_helper_id != 0) {
        echo $smm->getPersonaWithJoins($personaId, $name, $logged_userId, 'active', '', '', $request);
    } elseif ($request->status == "active") {
        echo $smm->getPersonaOnly($personaId, $name, $logged_userId, 'active', '', '', $request, $page_start);
    } elseif ($request->status == "inactive") {
        echo $smm->getPersonaOnly($personaId, $name, $logged_userId, 'inactive', '', '', $request, $page_start);
    } else {
        echo $smm->getPersonaWithJoins($personaId, $name, $logged_userId, 'none', '', '', $request);
    }
} 


elseif ($query_type == "getPersonaWithJoinsDebug") {

    $personaId = (int) $request->personaId;
    $name = $request->name;
    $logged_userId = $request->logged_userId;
    $page_start = $request->page_start;
    // $campaign_helper_id = isset($request->campaign_helper_id) ? $request->campaign_helper_id : 0;
    // echo json_encode($page_start + 10);
    // LIMIT $page_no, 50
    if (isset($request->from) && isset($request->to)) {
        $smm->getPersonaWithJoinsDebug($personaId, $name, $logged_userId, 'active', $request->from, $request->to, $request);
    } elseif ($campaign_helper_id != 0) {
        $smm->getPersonaWithJoinsDebug($personaId, $name, $logged_userId, 'active', '', '', $request);
    } elseif ($request->status == "active") {
        echo $smm->getPersonaOnly($personaId, $name, $logged_userId, 'active', '', '', $request, $page_start);
    } elseif ($request->status == "inactive") {
        echo $smm->getPersonaOnly($personaId, $name, $logged_userId, 'inactive', '', '', $request, $page_start);
    } else {
        $smm->getPersonaWithJoinsDebug($personaId, $name, $logged_userId, 'none', '', '', $request);
    }
} elseif ($query_type == "getPersonaDataWithJoinsDebug") {

    $personaId = (int) $request->personaId;
    $name = $request->name;
    $logged_userId = $request->logged_userId;
    $page_start = $request->page_start;

    $smm->getPersonaDataWithJoinsDebug($personaId, $name, $logged_userId, 'none', '', '', $request);
} elseif ($query_type == "getMessages") {

    $data_id = $request->data_id;
    $linkedin_account_persona_id = $request->linkedin_account_persona_id;
    echo $smm->getMessages((int) $data_id, (int) $linkedin_account_persona_id);
} elseif ($query_type == "getTeam") {

    $pipe->getTeam();
} elseif ($query_type == "getCountries") {
    // echo json_encode($request->persona[0]);
    echo json_encode($smm->getAllsCountries());
} elseif ($query_type == "updatePersona") {
    // echo json_encode($request->persona[0]);
    echo json_encode($smm->updatePersona($request->persona[0]));
} elseif ($query_type == "createPersona") {


    $email = $request->email;
    $account_type = $request->account_type;
    $fullname = $request->fullname;
    $assigned_to = $request->assigned_users;
    $team_id_access = "0";
    $logged_userId = $request->logged_userId;
    $pipe_user_id = $request->pipe_users;
    if ($request->team_id_access != 0 || $request->team_id_access != "0") {
        $team_ids = array();
        foreach (json_decode(json_encode($request->team_id_access), true) as $val) {
            $team_ids[] = $val['ht_id'];
        }

        $team_id_access = implode(",", $team_ids);
    }


    $debug = array();
    $debug['req'] = $request;
    $debug['tid'] = $team_id_access;

    // echo json_encode($debug);
    // $name = $request->name;
    echo $smm->createPersona($fullname, $email, $team_id_access, $account_type, $assigned_to, $pipe_user_id, $logged_userId);
} elseif ($query_type == "getEmployeesWithTeam") {
    $search = $request->search;
    if (isset($request->user_id)) {
        echo json_encode($pipe->getEmployeesWithTeam("", $request->user_id));
    } else {
        echo json_encode($pipe->getEmployeesWithTeam($search, 0));
    }
} elseif ($query_type == "mapCompany") {
    $data_id = $request->data_id;
    $org = $request->org;
    // echo json_encode($request);

    // return json_encode("test");
    if (count($org) > 0) {
        echo json_encode($smm->map_company($data_id, $org, 0, 1));
    }
    // echo json_encode(count($org));

    // 
} elseif ($query_type == "assignUserToPersona") {
    $user_id = $request->user_id;
    $personaId = $request->personaId;
    $pipe_user_id2 = $request->pipe_user_id2;
    if ($pipe_user_id2 > 0 && $user_id > 0 && $personaId > 0) {
        echo $smm->assignUserToPersona($pipe_user_id2, $user_id, $personaId);
    }
    // echo json_encode(count($org));

    // 
} elseif ($query_type == "updateContact") {
    $update = $request->update;
    $data_id = $request->data_id;
    echo $smm->updateData($data_id, $update);
    // echo json_encode($smm->updateData($data_id, $update));
} elseif ($query_type == "getOrganization") {
    $search = $request->search;
    echo json_encode($smm->get_organization($search));
} elseif ($query_type == "setPersonaStatus") {
    $linkedin_account_persona_id = $request->linkedin_account_persona_id;
    $status = $request->status;
    echo json_encode($smm->setPersonaStatus($linkedin_account_persona_id, $status));
} elseif ($query_type == "get_department") {
    echo json_encode($pipe->getDepartments());
} elseif ($query_type == "get_clients") {
    echo json_encode($pipe->getClients($request->dept_id));
} elseif ($query_type == "get_client_accounts") {
    echo json_encode($pipe->getClientAccounts($request->client_id));
} elseif ($query_type == "get_client_lists") {
    echo json_encode($pipe->getClientLists($request->client_account_id));
} elseif ($query_type == "get_event_states") {
    echo json_encode($pipe->getEventState($request->client_list_id));
} elseif ($query_type == "import_to_tm_outbound") {
    echo json_encode($pipe->importToTmOutbound($request));
} elseif ($query_type == "get_campaign_name") {
   $personaId = $request;
    echo json_encode($smm->getCampaignNames($personaId));
} elseif ($query_type == "get_all_employees") {
    echo json_encode($pipe->getAllEmployees());
} elseif ($query_type == "get_username") {
    echo json_encode($pipe->getUsername($request->user_id));
} elseif ($query_type == "insert_to_dmt") {
    echo json_encode($pipe->insertToDMT($request->form_data));
}

// elseif ($query_type == "getcamp") {
//    // $personaId = $request;
//     echo $smm->get_campaign_names($request->linkedin_account_persona_id);
// } 
elseif ($query_type == "getcamp") {
      $personaId = $request;
       // $personaId = $request->linkedin_account_persona_id;
    echo json_encode($smm->get_campaign_names($personaId));
}
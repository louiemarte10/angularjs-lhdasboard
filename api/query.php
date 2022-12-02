<?php

header('Content-Type: text/html; charset=UTF-8');
class SMM
{

	public function getContactPhoneNumbers($data_id)
	{
		$response = array();
		if ($data_id > 0) {
			$sql = "SELECT * FROM `data_phone_numbers` dpn LEFT OUTER JOIN phone_numbers pn ON pn.phone_number_id = dpn.phone_number_id WHERE data_id = " . $data_id;


			$res = smm_db::query($sql);

			if (mysqli_num_rows($res) > 0) {
				while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
					$response[] = $row;
				}
			}
		}
		return $response;
	}
	public function getContactOtherEmails($data_id, $linkedin_account_persona_id)
	{
		$response = array();
		if ($data_id > 0) {
			$sql = "SELECT * FROM `data_email_lkp` del 
			INNER JOIN emails_lkp el ON el.email_id = del.email_lkp_id 
			INNER JOIN email_src_lkp esl ON esl.email_src_id = del.email_src_id  
			WHERE data_id = " . $data_id . " AND linkedin_account_persona_id = " . $linkedin_account_persona_id . " GROUP BY email,status";


			$res = smm_db::query($sql);

			if (mysqli_num_rows($res) > 0) {
				while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
					$response[] = $row;
				}
			}
		}
		return $response;
	}
	public function getContactOtherCompanies($data_id)
	{
		$response = array();
		if ($data_id > 0) {
			$sql = "SELECT ot.*,doo.*,doh.*,
								ol.organization_name as organization,
								ol.organization_location_1 as organization_location,
								ol.linkedin_organization_id,
								ol.organization_url,
								ol.organization_website,
								ol.country_id,
								c.country 
								FROM `data_other_organization_lkp` doo 
								INNER JOIN organizations_lkp ol ON doo.organization_lkp_id = ol.organization_lkp_id 
								INNER JOIN organization_titles ot ON ot.organization_title_id = doo.organization_title_id 
								INNER JOIN data_organization_history doh ON doh.data_other_organization_lkp_id = doo.data_other_organization_lkp_id  
								LEFT OUTER JOIN countries_lkp c ON c.country_id = ol.country_id   
								LEFT OUTER JOIN industries_lkp il ON il.industry_lkp_id = ol.industry_lkp_id   
								WHERE data_id = " . $data_id;
			$data_other_organization_lkp = smm_db::query($sql);

			// $row1['other_details']['counts'] = $sql;
			// echo json_encode(smm_db::getError());
			if (mysqli_num_rows($data_other_organization_lkp) > 0) {
				$org_list = array();
				$new_org_arr = array();
				while ($row2 = $data_other_organization_lkp->fetch_array(MYSQLI_ASSOC)) {


					$row2['new'] = 1;
					$row2['organization_location'] =  utf8_decode($row2['organization_location']);
					$row2['organization'] =  utf8_decode($row2['organization']);
					if ($row2['primary_organization'] == 1) {
						$row2['selected'] = 1;
					}
					$org_list[$row2['sort']] = $row2;

					// print_r($row2);
					// $arr['selected'] = 1;
					// $arr['organization'] = $row1['company'];
					// $arr['organization_title'] = $row1['organization_title_1'];
					// $arr['organization_location'] = $row1['organization_location_1'];
					// $org_key = "org_" . ($counter + 1);
					// $org_list[$org_key] = $arr;
				}
				$new_org_arr['companies'] = $org_list;

				$new_org_arr['counts'] = count($new_org_arr['companies']);

				// $row1['other_details'] = $new_org_arr;
				$response[] = $new_org_arr;
			}
		}
		return $response;
	}

	public function getPersonaWithJoinsDebug($personaId, $name, $logged_userId = 0, $status = 'none', $from  , $to , $request = array())
	{

		$pipe = new PIPE();
		if ($request) {
			$request = (array) $request;
		}
		extract($request, EXTR_OVERWRITE);
		$campaign_helper_id = isset($campaign_helper_id) ? $campaign_helper_id : 0;
		// $db_linkedin = new MySQLi("192.168.50.47", "app_pipe", "a33-pipe", "callbox_mailer_data");
		if ($logged_userId > 0) {
			$start = time();
			$sql = "";
			if ($personaId > 0 && $status != 'none') {
				$sql = "SELECT * FROM linkedin_account_persona WHERE `x` = '" . $status . "' AND linkedin_account_persona_id =" . $personaId . "";
			} elseif ($personaId > 0) {
				$sql = "SELECT * FROM linkedin_account_persona WHERE linkedin_account_persona_id =" . $personaId . "";
			} elseif ($name != "") {
				$sql = "SELECT * FROM linkedin_account_persona WHERE my_fullname LIKE '{$name}%' ORDER BY linkedin_account_persona_id DESC";
			} elseif ($status != 'none') {
				$sql = "SELECT * FROM linkedin_account_persona WHERE `x` = '" . $status . "' ORDER BY linkedin_account_persona_id DESC";
			} else {
				$sql = "SELECT * FROM linkedin_account_persona ORDER BY linkedin_account_persona_id DESC ";
			}

			$res = smm_db::query($sql);

			$response = array();
			if (mysqli_num_rows($res) > 0) {

				while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
					$row['query_start'] = $start;

					$row['ipadd'] = $_SERVER['REMOTE_ADDR'];
					if ($row['assigned_to'] != 0) {
						$assigned_users = explode(",", $row['assigned_to']);
						$assigned_user = $pipe->getEmployeeByUserId($assigned_users[0]);

						$row['assigned_to'] = trim($row['assigned_to']);
						$row['assigned_user']['fname'] = $assigned_user[0]['first_name'];
						$row['assigned_user']['lname'] = $assigned_user[0]['last_name'];
						$n = array();

						foreach ($assigned_users as $a) {

							$x = $pipe->getEmployeeByUserId($a);
							$n[] = $x[0]['first_name'] . ' ' . $x[0]['last_name'];
						}

						$row['users_assigned'] = implode(", ", $n);
					}
					if ($row['created_by'] > 0) {
						$createdBy = $pipe->getEmployeeByUserId($row['created_by']);


						$row['createdBy']['fname'] = $createdBy[0]['first_name'];
						$row['createdBy']['lname'] = $createdBy[0]['last_name'];
					}


					if ($row['pipe_user_id'] > 0) {
						$pipeUser = $pipe->getEmployeeByUserId($row['pipe_user_id']);


						$row['pipeUser']['fname'] = $pipeUser[0]['first_name'];
						$row['pipeUser']['lname'] = $pipeUser[0]['last_name'];
					}



					$row['account_type'] = strtoupper($row['account_type']);

					$li_persona_id = $row['linkedin_account_persona_id'];
								  $test = "";
					 
					 if($date_filter == 0){
					 	$join .= "";
					 }else{
					 	  $col = $date_filter == 1 ? 'di.contact_date_added' : 'di.date_connected';
					 	$join .= "AND $col BETWEEN '$from 00:00:00' AND '$to 23:59:59' ";
					 }
								  
					$sql = "SELECT 
							*,
							date_connected as cn_date_connected,
							contact_date_added as d_date_added,
							email_source_name as contact_email_source,
							email as contact_email,
							`email_status` as contact_email_status, 
							industry,
							organization_name as company, 
							organization_location_1 AS address1,
							contact_date_added AS pure_date_added, 
							country, 
							IF(country_id IS NULL, 'no', 'yes') AS has_country,
							country_id, 
							organization_title AS position 
					FROM campaigns_helper as ch
					INNER JOIN data_txns as dtxn on ch.campaign_helper_id = dtxn.campaign_helper_id
					INNER JOIN data_info as di on dtxn.data_id = di.data_id AND ch.linkedin_account_persona_id = di.linkedin_account_persona_id 
					WHERE ch.linkedin_account_persona_id = '$li_persona_id' $join  GROUP BY di.data_id ORDER BY di.data_id DESC /** dot73/pipeline/linkedin-dashboard/api/query.php **/";
				 

				 
					// $sql = "SELECT * FROM data_date_added WHERE linkedin_account_persona_id = ".$row['linkedin_account_persona_id']." GROUP BY data_id ORDER BY data_id DESC ";
					$res1 = smm_db::query($sql);
					if (mysqli_num_rows($res1) > 0) {
						$contacts_numbering = 0;
						while ($row1 = $res1->fetch_array(MYSQLI_ASSOC)) {
							$contacts_numbering++;
							$row1['numbering'] = $contacts_numbering;

							if ($row1['connection_id'] > 0) {
								$row1['isConnected'] = true;
								// $row1['date_connected'] = $row1['date_connected'];
							} else {
								$row1['isConnected'] = false;
							};

							if (!$row1['data_email_lkp_id'] > 0) {
								$row1['contact_email'] = "no email";
								// $row1['date_connected'] = $row1['date_connected'];
							};
							if ($row1['phone_num_id'] == 1) {
								$row1['phone_num'] = "not set";
								// $row1['date_connected'] = $row1['date_connected'];
							}
							if ($row1['mobile_num_id'] == 1) {
								$row1['mobile_num'] = "not set";
								// $row1['date_connected'] = $row1['date_connected'];
							}
							if ($row1['direct_line_num_id'] == 1) {
								$row1['direct_line_num'] = "not set";
								// $row1['date_connected'] = $row1['date_connected'];
							}

							$row1['first_name'] = utf8_decode($row1['first_name']);
							$row1['last_name'] = utf8_decode($row1['last_name']);
							$row1['company'] = utf8_decode($row1['organization_name']);

							$row1['no_country'] = $row1['has_country'] == "no" ? true : false;
							$row1['date_added_str'] = date('M j, Y', strtotime($row1['pure_date_added']));
							$row1['summary'] = stripslashes($row1['summary']);
							$row1['summary'] = trim($row1['summary'], "'");
							$row1['contact_fullname'] = $row1['first_name'] . " " . $row1['last_name'];
							$row1['account_type'] = strtoupper($row1['account_type']);
							$row['contacts'][] = $row1;
						}
					}

					// WHERE linkedin_account_persona_id = ".$row['linkedin_account_persona_id'] ."

					echo json_encode($row);
					// $this->getPersonaDataWithJoinsDebug($personaId, $name, $logged_userId, $status, $from, $to, $request, $row);
				}

				// echo json_encode($response);
			} else {
				return json_encode("error");
			}
		} else {
			return json_encode("not logged");
		}
	}
	public function getPersonaDataWithJoinsDebugz($data_id)
	{

		$sql = "SELECT * FROM data_info WHERE ";


		$res = smm_db::query($sql);

		$response = array();
		if (mysqli_num_rows($res) > 0) {

			while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
			}
		}
	}

	public function getPersonaDataWithJoinsDebug($personaId, $name, $logged_userId = 0, $status = 'none', $from, $to, $request = array(), $row = array())
	{
		$pipe = new PIPE();
		if ($request) {
			$request = (array) $request;
		}
		extract($request, EXTR_OVERWRITE);
		$campaign_helper_id = isset($campaign_helper_id) ? $campaign_helper_id : 0;
		$join = "";
		$selected = "";

		// d.data_id = cn.data_id AND 
		/* if (strtotime($from) && strtotime($to)) {
						$join = " AND YEAR(cn.date_connected) > 1972 AND cn.date_connected >= '" . $from . "' AND cn.date_connected <= '" . $to . "' ";
					} */
		if ($campaign_helper_id != 0) {
			$join .= " AND ch.campaign_helper_id = $campaign_helper_id ";
		}

		if ($country_filter) {
			$join .= " AND ol.country_id IN (" . implode(",", $country_filter) . ") ";
		}

		if ($connections_filter > 0) {
			$is_connected = $connections_filter == 1 ? 'IS NOT NULL' : 'IS NULL';
			$join .= " AND cn.connection_id $is_connected ";
		}

		if ($date_filter > 0) {
			$col = $date_filter == 1 ? 'dd.date_added' : 'cn.date_connected';
			$join .= " AND $col BETWEEN '$from' AND '$to' ";
		}

		if (isset($position_filter) && $position_filter !== "") {
			$filter = "LIKE";
			if ($is_exact_position) {
				$filter =  "IN ('" . implode("','", explode(",", $position_filter)) . "')";
			} else {
				$position_filter = explode(",", $position_filter);
				foreach ($position_filter as $position) {
					$filter .= $filter == "LIKE" ? " '%$position%' " : " OR '%$position%' ";
				}
			}

			$join .= " AND (ot.organization_title $filter)";
		}
		$response = array();
		$sql = "
							SELECT 
							ch.*,
							lap.*,
							dt.*,
							email_lkp.*,
							d.*,
							cn.connection_id,cn.date_connected as cn_date_connected,
							d.date_added as d_date_added,
							esl.source_name as contact_email_source,email_lkp.email as contact_email,email_lkp.status as contact_email_status, il.industry,ol.organization_name as company, ol.organization_location_1 AS address1,
							dd.date_added AS pure_date_added, cl.country, IF(cl.country_id IS NULL, 'no', 'yes') AS has_country,
							ol.country_id, ot.organization_title AS position 
							FROM campaigns_helper as ch 
							INNER JOIN linkedin_account_persona as lap ON ch.linkedin_account_persona_id = lap.linkedin_account_persona_id 
							INNER JOIN data_txns as dt ON ch.campaign_helper_id = dt.campaign_helper_id 
							INNER JOIN `data` as d ON dt.data_id = d.data_id 
							LEFT OUTER JOIN `connections` as cn ON cn.linked_account_persona_id = ch.linkedin_account_persona_id AND cn.data_id = d.data_id 							
							
							INNER JOIN data_date_added dd ON (dd.data_id = d.data_id)
							
							LEFT OUTER JOIN data_other_organization_lkp doo ON doo.data_id = d.data_id AND doo.primary_organization = 1 AND doo.data_type = 'contact' 
							LEFT OUTER JOIN data_email_lkp de ON (de.data_email_lkp_id = doo.data_email_lkp_id)
							LEFT OUTER JOIN `emails_lkp` as email_lkp ON de.email_lkp_id = email_lkp.email_id 
							LEFT OUTER JOIN `email_src_lkp` as esl ON esl.email_src_id = de.email_src_id 
							LEFT OUTER JOIN organizations_lkp ol ON ol.organization_lkp_id = doo.organization_lkp_id  
							LEFT OUTER JOIN industries_lkp il USING(industry_lkp_id)
							LEFT OUTER JOIN countries_lkp cl ON (ol.country_id = cl.country_id)
							LEFT OUTER JOIN organization_titles ot USING(organization_title_id)
							WHERE ch.linkedin_account_persona_id = " . $personaId . $join . " 
							GROUP BY d.data_id ORDER BY d.data_id DESC ";
		// echo json_encode($sql);
		$row['sql'] = str_replace(array("\r", "\n", "\t"), '', $sql);
		// echo json_encode(str_replace(array("\r", "\n", "\t"), '', $sql));
		$res1 = smm_db::query($sql);
		// $res1 = "debugz";
		// LEFT OUTER JOIN `connections` as cn ON ch.linkedin_account_persona_id = cn.linked_account_persona_id AND YEAR(cn.date_connected) > 1972 " . $join . " 

		if (mysqli_num_rows($res1) > 0) {
			while ($row1 = $res1->fetch_array(MYSQLI_ASSOC)) {
				if ($row1['connection_id'] > 0) {
					$row1['isConnected'] = true;
					// $row1['date_connected'] = $row1['date_connected'];
				} else {
					$row1['isConnected'] = false;
				}

				$row1['no_country'] = $row1['has_country'] == "no" ? true : false;
				$row1['date_added_str'] = date('M j, Y', strtotime($row1['pure_date_added']));


				// if ($row['linkedin_account_persona_id'] > 0 && $row1['data_id'] > 0) {
				// 	$sql = "SELECT * FROM `connections` WHERE YEAR(date_connected) > 1972 AND data_id = " . $row1['data_id'] . " AND linked_account_persona_id = " . $row['linkedin_account_persona_id'] . " ORDER BY `date_connected` ASC";
				// 	$res_connections = smm_db::query($sql);
				// 	if (mysqli_num_rows($res_connections) > 0) {


				// 		while ($row_connections = $res_connections->fetch_array(MYSQLI_ASSOC)) {
				// 			$row1['connection_data'][] = $row_connections;
				// 		}
				// 		$row1['isConnected'] = true;
				// 		$row1['date_connected'] = $row1['connection_data'][0]['date_connected'];
				// 		// if($row1['data_id'] == 110){
				// 		// 	$row1['isConnected'] = false;

				// 		// }
				// 	} else {
				// 		$row1['isConnected'] = false;
				// 		$row1['date_connected'] = "none";
				// 	}
				// }

				// ,
				// c.* 
				// LEFT OUTER JOIN `connections` as c ON d.data_id = c.data_id AND c.linked_account_persona_id = ch.linkedin_account_persona_id 
				// if($row1['connection_id'] > 0){
				// 	$row1['isConnected'] = true;
				// }else{
				// 	$row1['isConnected'] = false;

				// }
				$sql = "SELECT * FROM messages WHERE data_id = " . $row1['data_id'] . " AND linkedin_account_persona_id = " . $personaId;
				$res2 = smm_db::query($sql);
				// $row = $result -> fetch_assoc();
				// $row1['messages'] = $res2->fetch_assoc();
				// $row1['messages'][] = mysqli_num_rows($res2);

				if (mysqli_num_rows($res2) > 0) {
					while ($row_messsage = $res2->fetch_array(MYSQLI_ASSOC)) {

						$row_messsage['message_text'] = str_replace(' ', '-', $row_messsage['message_text']); // Replaces all spaces with hyphens.

						$row_messsage['message_text'] = preg_replace('/[^A-Za-z0-9\-.-:-,-]/', '', $row_messsage['message_text']); // Removes special chars
						$row_messsage['message_text'] = str_replace('-', ' ', $row_messsage['message_text']); // Replaces all spaces with hyphens.
						$row1['messages'][] = $row_messsage;
					}
					// 	while ($row2 = $res2->fetch_array(MYSQLI_ASSOC)) {
					// 		// $row2['message_text'] = ltrim($row2['message_text'],"'");
					// 		// $row2['message_text'] = rtrim($row2['message_text'],"'");
					// 		// $row2['message_text'] = smm_db::real_escape_string($row2['message_text']);
					// 		$row1['messages'][] = $row2;
					// 	}
				}

				$sql = "SELECT * FROM data_phone_numbers as dpn INNER JOIN phone_numbers as pn USING (phone_number_id) WHERE data_id = " . $row1['data_id'];
				$res3 = smm_db::query($sql);
				// $row = $result -> fetch_assoc();
				// $row1['messages'] = $res2->fetch_assoc();
				// $row1['messages'][] = mysqli_num_rows($res2);

				if (mysqli_num_rows($res3) > 0) {
					while ($row3 = $res3->fetch_array(MYSQLI_ASSOC)) {
						if ($row3['phone_number_id'] == $row1['phone_num_id']) {
							$row3['primary'] = "Phone";
						}
						if ($row3['phone_number_id'] == $row1['mobile_num_id']) {
							$row3['primary'] = "Mobile";
						}
						if ($row3['phone_number_id'] == $row1['direct_line_num_id']) {
							$row3['primary'] = "Direct Line";
						}




						$row1['phone_numbers'][] = $row3;
					}
					// 	while ($row2 = $res2->fetch_array(MYSQLI_ASSOC)) {
					// 		// $row2['message_text'] = ltrim($row2['message_text'],"'");
					// 		// $row2['message_text'] = rtrim($row2['message_text'],"'");
					// 		// $row2['message_text'] = smm_db::real_escape_string($row2['message_text']);
					// 		$row1['messages'][] = $row2;
					// 	}
				}
				$sql = "SELECT del.*,el.*,esl.source_name FROM data_email_lkp as del 
							INNER JOIN emails_lkp as el ON el.email_id = del.email_lkp_id 
							INNER JOIN email_src_lkp as esl ON esl.email_src_id = del.email_src_id 
							WHERE data_id = " . $row1['data_id'];
				$res4 = smm_db::query($sql);
				// $row = $result -> fetch_assoc();
				// $row1['messages'] = $res2->fetch_assoc();
				// $row1['messages'][] = mysqli_num_rows($res2);

				if (mysqli_num_rows($res4) > 0) {
					while ($row4 = $res4->fetch_array(MYSQLI_ASSOC)) {




						$row1['other_emails'][] = $row4;
					}
					// 	while ($row2 = $res2->fetch_array(MYSQLI_ASSOC)) {
					// 		// $row2['message_text'] = ltrim($row2['message_text'],"'");
					// 		// $row2['message_text'] = rtrim($row2['message_text'],"'");
					// 		// $row2['message_text'] = smm_db::real_escape_string($row2['message_text']);
					// 		$row1['messages'][] = $row2;
					// 	}
				}




				$sql = "SELECT ot.*,doo.*,doh.*,
								ol.organization_name as organization,
								ol.organization_location_1 as organization_location,
								ol.linkedin_organization_id,
								ol.organization_url,
								ol.organization_website,
								ol.country_id,
								c.country 
								FROM `data_other_organization_lkp` doo 
								INNER JOIN organizations_lkp ol ON doo.organization_lkp_id = ol.organization_lkp_id 
								INNER JOIN organization_titles ot ON ot.organization_title_id = doo.organization_title_id 
								LEFT OUTER JOIN data_organization_history doh ON doh.data_other_organization_lkp_id = doo.data_other_organization_lkp_id  
								LEFT OUTER JOIN countries_lkp c ON c.country_id = ol.country_id   
								LEFT OUTER JOIN industries_lkp il ON il.industry_lkp_id = ol.industry_lkp_id   
								WHERE data_id = " . $row1['data_id'];
				$row1['test_query'] = $sql;
				$data_other_organization_lkp = smm_db::query($sql);

				$row1['other_details'] = array();
				$row1['other_details']['counts'] = mysqli_num_rows($data_other_organization_lkp);
				// $row1['other_details']['counts'] = $sql;
				// echo json_encode(smm_db::getError());
				if (mysqli_num_rows($data_other_organization_lkp) > 0) {
					$org_list = array();
					$new_org_arr = array();
					while ($row2 = $data_other_organization_lkp->fetch_array(MYSQLI_ASSOC)) {


						$row2['new'] = 1;
						$row2['organization_location'] =  utf8_decode($row2['organization_location']);
						$row2['organization'] =  utf8_decode($row2['organization']);
						if ($row2['primary_organization'] == 1) {
							$row2['selected'] = 1;
							$row1['company'] =  utf8_decode($row2['organization']);
							$row1['address1'] =  utf8_decode($row2['organization_location']);
							$row1['full_org_info'] =  $row2;
						}
						$org_list[$row2['sort']] = $row2;

						// print_r($row2);
						// $arr['selected'] = 1;
						// $arr['organization'] = $row1['company'];
						// $arr['organization_title'] = $row1['organization_title_1'];
						// $arr['organization_location'] = $row1['organization_location_1'];
						// $org_key = "org_" . ($counter + 1);
						// $org_list[$org_key] = $arr;
					}
					$new_org_arr['companies'] = $org_list;

					$new_org_arr['counts'] = count($new_org_arr['companies']);

					$row1['other_details'] = $new_org_arr;
				}

				// {{contact.first_name}}&nbsp;{{contact.last_name}}<
				// $row1['first_name'] = trim($row1['first_name'], "'");
				// $row1['last_name'] = trim($row1['last_name'], "'");

				$row1['first_name'] = utf8_decode($row1['first_name']);
				$row1['last_name'] = utf8_decode($row1['last_name']);

				if (strlen($row1['contact_email']) > 0) {
				} else {
					$row1['contact_email'] = utf8_decode($row1['linkedIn_email']);
					// 	email_lkp1.email as linkedIn_email,
					// email_lkp1.status as linkedIn_email_status,
					$row1['contact_email_status'] = $row1['linkedIn_email_status'];
				}

				// linkedIn_email
				// $row1['first_name'] = mb_detect_encoding($row1['first_name']);
				// $row1['last_name'] = mb_detect_encoding($row1['last_name']);

				$row1['summary'] = stripslashes($row1['summary']);
				$row1['summary'] = trim($row1['summary'], "'");
				$row1['contact_fullname'] = $row1['first_name'] . " " . $row1['last_name'];
				$row1['account_type'] = strtoupper($row1['account_type']);


				// $row['contacts'][] = $row1;
				$response[] = $row1;
			}
			echo json_encode($response);
		}
	}






















































	public function getPersonaOnly($personaId, $name, $logged_userId = 0, $status = 'none', $from, $to, $request = array(), $page_start = 0)
	{

		$pipe = new PIPE();
		if ($request) {
			$request = (array) $request;
		}
		extract($request, EXTR_OVERWRITE);
		$campaign_helper_id = isset($campaign_helper_id) ? $campaign_helper_id : 0;
		// $db_linkedin = new MySQLi("192.168.50.47", "app_pipe", "a33-pipe", "callbox_mailer_data");
		if ($logged_userId > 0) {
			$sql = "";
			if ($personaId > 0 && $status != 'none') {
				$sql = "SELECT * FROM linkedin_account_persona WHERE `x` = '" . $status . "' AND linkedin_account_persona_id =" . $personaId . "";
			} elseif ($personaId > 0) {
				$sql = "SELECT * FROM linkedin_account_persona WHERE linkedin_account_persona_id =" . $personaId . "";
			} elseif ($name != "") {
				$sql = "SELECT * FROM linkedin_account_persona WHERE my_fullname LIKE '{$name}%' ORDER BY linkedin_account_persona_id DESC";
			} elseif ($status != 'none') {
				$page_end = 10;
				// if($page_start > 1){
				// 	$page_end = 10 * $page_start;
				// }
				$page_start = $page_start - 1;
				$page_start = 10 * $page_start;

				$page_end = $page_start + 10;
				// return json_encode($page_start."==".$page_end);

				$sql = "SELECT * FROM linkedin_account_persona WHERE `x` = '" . $status . "' ORDER BY linkedin_account_persona_id DESC";
				// $sql = "SELECT * FROM linkedin_account_persona WHERE `x` = '" . $status . "' ORDER BY linkedin_account_persona_id DESC LIMIT $page_start,10 ";
			} else {
				$sql = "SELECT * FROM linkedin_account_persona ORDER BY linkedin_account_persona_id DESC";
			}

			$res = smm_db::query($sql);

			$response = array();
			if (mysqli_num_rows($res) > 0) {

				while ($row = $res->fetch_array(MYSQLI_ASSOC)) {

					if ($row['assigned_to'] != 0) {
						$assigned_users = explode(",", $row['assigned_to']);
						$assigned_user = $pipe->getEmployeeByUserId($assigned_users[0]);

						$row['assigned_to'] = trim($row['assigned_to']);
						$row['assigned_user']['fname'] = $assigned_user[0]['first_name'];
						$row['assigned_user']['lname'] = $assigned_user[0]['last_name'];

						$n = $pipe->getUsers($row['assigned_to']);
						$row['users_assigned'] = $n['users'];
					}
					if ($row['created_by'] > 0) {
						$createdBy = $pipe->getEmployeeByUserId($row['created_by']);


						$row['createdBy']['fname'] = $createdBy[0]['first_name'];
						$row['createdBy']['lname'] = $createdBy[0]['last_name'];
					}

					if ($row['pipe_user_id'] > 0) {
						$pipeUser = $pipe->getEmployeeByUserId($row['pipe_user_id']);


						$row['pipeUser']['fname'] = $pipeUser[0]['first_name'];
						$row['pipeUser']['lname'] = $pipeUser[0]['last_name'];
					}


					$row['account_type'] = strtoupper($row['account_type']);





					$exploded_team_access = explode(",", $row['team_id_access']);
					$isAllowed = "no";
					foreach ($exploded_team_access as $team_id) {
						$check_permission = $pipe->checkUserPermission($team_id, $logged_userId);
						if ($check_permission == "yes") {
							$isAllowed = "yes";
						}
					}

					if ($isAllowed == "yes") {
						$response[] = $row;
					} elseif ($row['assigned_to'] != 0) {
						// mag show ang persona based sa assigned_to  - louie 1
						$assigned_users = explode(",", $row['assigned_to']);
						if (in_array($logged_userId, $assigned_users)) {
							$response[] = $row;
						}

						/* if ((int) $row['assigned_to'] == (int) $logged_userId) {
							$response[] = $row;
						} */
					}
					elseif ($row['pipe_user_id'] != 0) {
						 
						// mag show ang persona based sa primary owner  - louie 2
						$assigned_users2 =  explode(",", $row['pipe_user_id']);
						
						if (in_array($logged_userId, $assigned_users2)) {
							$response[] = $row;
						}
					 
					}
				}


				return json_encode($response);
			} else {
				return json_encode("error");
			}
		} else {
			return json_encode("not logged");
		}
	}
	public function getPersonaWithJoins($personaId, $name, $logged_userId = 0, $status = 'none', $from, $to, $request = array())
	{

		$pipe = new PIPE();
		if ($request) {
			$request = (array) $request;
		}
		extract($request, EXTR_OVERWRITE);
		$campaign_helper_id = isset($campaign_helper_id) ? $campaign_helper_id : 0;
		// $db_linkedin = new MySQLi("192.168.50.47", "app_pipe", "a33-pipe", "callbox_mailer_data");
		if ($logged_userId > 0) {
			$start = time();
			$sql = "";
			if ($personaId > 0 && $status != 'none') {
				$sql = "SELECT * FROM linkedin_account_persona WHERE `x` = '" . $status . "' AND linkedin_account_persona_id =" . $personaId . "";
			} elseif ($personaId > 0) {
				$sql = "SELECT * FROM linkedin_account_persona WHERE linkedin_account_persona_id =" . $personaId . "";
			} elseif ($name != "") {
				$sql = "SELECT * FROM linkedin_account_persona WHERE my_fullname LIKE '{$name}%' ORDER BY linkedin_account_persona_id DESC";
			} elseif ($status != 'none') {
				$sql = "SELECT * FROM linkedin_account_persona WHERE `x` = '" . $status . "' ORDER BY linkedin_account_persona_id DESC";
			} else {
				$sql = "SELECT * FROM linkedin_account_persona ORDER BY linkedin_account_persona_id DESC ";
			}

			$res = smm_db::query($sql);

			$response = array();
			if (mysqli_num_rows($res) > 0) {

				while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
					$row['query_start'] = $start;

					$row['ipadd'] = $_SERVER['REMOTE_ADDR'];
					if ($row['assigned_to'] != 0) {
						$assigned_users = explode(",", $row['assigned_to']);
						$assigned_user = $pipe->getEmployeeByUserId($assigned_users[0]);

						$row['assigned_to'] = trim($row['assigned_to']);
						$row['assigned_user']['fname'] = $assigned_user[0]['first_name'];
						$row['assigned_user']['lname'] = $assigned_user[0]['last_name'];
						$n = array();

						foreach ($assigned_users as $a) {

							$x = $pipe->getEmployeeByUserId($a);
							$n[] = $x[0]['first_name'] . ' ' . $x[0]['last_name'];
						}

						$row['users_assigned'] = implode(", ", $n);
					}
					if ($row['created_by'] > 0) {
						$createdBy = $pipe->getEmployeeByUserId($row['created_by']);


						$row['createdBy']['fname'] = $createdBy[0]['first_name'];
						$row['createdBy']['lname'] = $createdBy[0]['last_name'];
					}


					if ($row['pipe_user_id'] > 0) {
						$pipeUser = $pipe->getEmployeeByUserId($row['pipe_user_id']);


						$row['pipeUser']['fname'] = $pipeUser[0]['first_name'];
						$row['pipeUser']['lname'] = $pipeUser[0]['last_name'];
					}



					$row['account_type'] = strtoupper($row['account_type']);

					$join = "";
					$selected = "";

					// d.data_id = cn.data_id AND 
					/* if (strtotime($from) && strtotime($to)) {
						$join = " AND YEAR(cn.date_connected) > 1972 AND cn.date_connected >= '" . $from . "' AND cn.date_connected <= '" . $to . "' ";
					} */
					if ($campaign_helper_id != 0) {
						$join .= " AND ch.campaign_helper_id = $campaign_helper_id ";
					}

					if ($country_filter) {
						$join .= " AND ol.country_id IN (" . implode(",", $country_filter) . ") ";
					}

					if ($connections_filter > 0) {
						$is_connected = $connections_filter == 1 ? 'IS NOT NULL' : 'IS NULL';
						$join .= " AND cn.connection_id $is_connected ";
					}

					if ($date_filter > 0) {
						$col = $date_filter == 1 ? 'dd.date_added' : 'cn.date_connected';
						$join .= " AND $col BETWEEN '$from 00:00:00' AND '$to 23:59:59' ";
					}

					if (isset($position_filter) && $position_filter !== "") {
						$filter = "LIKE";
						if ($is_exact_position) {
							$filter =  "IN ('" . implode("','", explode(",", $position_filter)) . "')";
						} else {
							$position_filter = explode(",", $position_filter);
							foreach ($position_filter as $position) {
								$filter .= $filter == "LIKE" ? " '%$position%' " : " OR '%$position%' ";
							}
						}

						$join .= " AND (ot.organization_title $filter)";
					}



					$sql = "
							SELECT 
							ch.*,
							lap.*,
							dt.*,
							email_lkp.*,
							d.*,
							cn.connection_id,cn.date_connected as cn_date_connected,
							d.date_added as d_date_added,
							esl.source_name as contact_email_source,email_lkp.email as contact_email,email_lkp.status as contact_email_status, il.industry,ol.organization_name as company, ol.organization_location_1 AS address1,
							dd.date_added AS pure_date_added, cl.country, IF(cl.country_id IS NULL, 'no', 'yes') AS has_country,
							ol.country_id, ot.organization_title AS position 
							FROM campaigns_helper as ch 
							INNER JOIN linkedin_account_persona as lap ON ch.linkedin_account_persona_id = lap.linkedin_account_persona_id 
							INNER JOIN data_txns as dt ON ch.campaign_helper_id = dt.campaign_helper_id 
							INNER JOIN `data` as d ON dt.data_id = d.data_id 
							LEFT OUTER JOIN `connections` as cn ON cn.linked_account_persona_id = ch.linkedin_account_persona_id AND cn.data_id = d.data_id 							
							INNER JOIN data_date_added dd ON (dd.data_id = d.data_id)
							LEFT OUTER JOIN data_other_organization_lkp doo ON doo.data_id = d.data_id AND doo.primary_organization = 1 AND doo.data_type = 'contact' 
							LEFT OUTER JOIN data_email_lkp de ON (de.data_email_lkp_id = doo.data_email_lkp_id)
							LEFT OUTER JOIN `emails_lkp` as email_lkp ON de.email_lkp_id = email_lkp.email_id 
							LEFT OUTER JOIN `email_src_lkp` as esl ON esl.email_src_id = de.email_src_id 
							LEFT OUTER JOIN organizations_lkp ol ON ol.organization_lkp_id = doo.organization_lkp_id  
							LEFT OUTER JOIN industries_lkp il USING(industry_lkp_id)
							LEFT OUTER JOIN countries_lkp cl ON (ol.country_id = cl.country_id)
							LEFT OUTER JOIN organization_titles ot USING(organization_title_id)
							WHERE ch.linkedin_account_persona_id = " . $row['linkedin_account_persona_id'] . $join . " 
							GROUP BY d.data_id ORDER BY d.data_id DESC";

			 
					// echo json_encode($sql);
					$row['sql'] = str_replace(array("\r", "\n", "\t"), '', $sql);

					$res1 = smm_db::query($sql);
					if (mysqli_num_rows($res1) > 0) {
						$contacts_numbering = 0;
						while ($row1 = $res1->fetch_array(MYSQLI_ASSOC)) {
							$contacts_numbering++;
							$row1['numbering'] = $contacts_numbering;

							if ($row1['connection_id'] > 0) {
								$row1['isConnected'] = true;
								// $row1['date_connected'] = $row1['date_connected'];
							} else {
								$row1['isConnected'] = false;
							};

							if (!$row1['data_email_lkp_id'] > 0) {
								$row1['contact_email'] = "no email";
								// $row1['date_connected'] = $row1['date_connected'];
							};
							if ($row1['phone_num_id'] == 1) {
								$row1['phone_num'] = "not set";
								// $row1['date_connected'] = $row1['date_connected'];
							}
							if ($row1['mobile_num_id'] == 1) {
								$row1['mobile_num'] = "not set";
								// $row1['date_connected'] = $row1['date_connected'];
							}
							if ($row1['direct_line_num_id'] == 1) {
								$row1['direct_line_num'] = "not set";
								// $row1['date_connected'] = $row1['date_connected'];
							}

							$row1['first_name'] = utf8_decode($row1['first_name']);
							$row1['last_name'] = utf8_decode($row1['last_name']);
							$row1['company'] = utf8_decode($row1['organization_name']);

							$row1['no_country'] = $row1['has_country'] == "no" ? true : false;
							$row1['date_added_str'] = date('M j, Y', strtotime($row1['pure_date_added']));
							$row1['summary'] = stripslashes($row1['summary']);
							$row1['summary'] = trim($row1['summary'], "'");
							$row1['contact_fullname'] = $row1['first_name'] . " " . $row1['last_name'];
							$row1['account_type'] = strtoupper($row1['account_type']);
							$row['contacts'][] = $row1;
						}
					}

					// WHERE linkedin_account_persona_id = ".$row['linkedin_account_persona_id'] ."

					echo json_encode($row);
					// $this->getPersonaDataWithJoinsDebug($personaId, $name, $logged_userId, $status, $from, $to, $request, $row);
				}

				// echo json_encode($response);
			} else {
				return json_encode("error");
			}
		} else {
			return json_encode("not logged");
		}
	}



	
	public function getMessages($data_id, $linkedin_account_persona_id)
	{
		$sql = "";
		if ($data_id > 0 && $linkedin_account_persona_id > 0) {
			$sql = "SELECT * FROM messages WHERE data_id = " . $data_id . " AND linkedin_account_persona_id = " . $linkedin_account_persona_id . " ORDER BY send_date ASC";
		}

		$response = array();

		if ($sql != "") {
			$res = smm_db::query($sql);

			if (mysqli_num_rows($res) > 0) {
				while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
					// ’'
					$row['message_text'] = str_replace(' ', '-', $row['message_text']); // Replaces all spaces with hyphens.

					$row['message_text'] = preg_replace('/[^A-Za-z0-9\-]/', '', $row['message_text']); // Removes special chars
					// $row['message_text'] = htmlspecialchars(stripslashes($row['message_text'])); // stripslashes($row['message_text']);
					$row['message_text'] = str_replace('-', ' ', $row['message_text']); // Replaces all spaces with hyphens.

					$response[] = $row;
				}
				// print_r($response);
				return json_encode($response);
			}
		}
		// return array();
	}
	public function createPersona($fullname, $email, $team_id_access, $account_type, $assigned_to, $pipe_user_id, $logged_userId = 0)
	{


		require("{$_SERVER['DOCUMENT_ROOT']}/config/pipeline-x.php");
		$db_linkedin = new MySQLi("192.168.50.64", "app_pipe", "a33-pipe", "linkedhelper");
		$response = array();

		$sql = "";


		if (strlen($fullname) > 0 && strlen($email) > 0 && $fullname != "debugError") {

			if ($account_type == "generic" || $account_type == "branded" || $account_type == "marketing") {


				$sql = "";

				$sql = "SELECT * FROM linkedin_account_persona WHERE my_email = '" . $email . "'";



				$res = $db_linkedin->query($sql);
				// $res = smm_db::query($sql);
				if (mysqli_error($db_linkedin) != "") {
					$response['fullname'] = $fullname;
					$response['email'] = $email;
					$response['team_id_access'] = $team_id_access;
					$response['message'] = "error";
					$response['error_info'] = mysqli_error($db_linkedin);
					$response['error_type'] = "1st";
					return json_encode($response);
				}


				if (mysqli_num_rows($res) > 0) {
					$response["message"] = "exist";
					while ($row = $res->fetch_array(MYSQLI_ASSOC)) {

						$response["existed_data"] = $row;
					}
				} else {



					$assigned_to = implode(",", $assigned_to);

					 // $pipe = preg_split ("/\,/", $assigned_to); 
					 // 					 $leaders = array(9327,6541,1252676,1242041,1236039,1249759, 1251570, 51794 ,0, 57, 104);
					 // 					 $pipeuser = 0;
					 // 					foreach($pipe as $user_attempt_id){
					 //                      if (!in_array($user_attempt_id,$leaders)) {
					 //                        $pipeuser= $user_attempt_id;
					 //                        break;
					 //                      } 
						// 				}

					if(empty($assigned_to)){
						$assignUserAccess = $pipe_user_id;
					}else{
						$assignUserAccess = $assigned_to;
					}

					$sql = "";
					$sql = 'INSERT INTO linkedin_account_persona (my_email,my_fullname,assigned_to,pipe_user_id,created_by,team_id_access,account_type,`x`) VALUES ("' . $db_linkedin->real_escape_string($email) . '","' . $db_linkedin->real_escape_string($fullname) . '","' . $assignUserAccess .'","'. $pipe_user_id . '",' . $logged_userId . ',"' . $team_id_access . '","' . $account_type . '","active")';
					$res =  $db_linkedin->query($sql);
					// $res = smm_db::query($sql);
					if (mysqli_error($db_linkedin) != "") {
						$response['fullname'] = $fullname;
						$response['email'] = $email;
						$response['team_id_access'] = $team_id_access;
						$response['message'] = "error";
						$response['error_info'] = mysqli_error($db_linkedin);
						$response['error_type'] = "2nd";
						$response['sql'] = $sql;
						return json_encode($response);
					}

					$inserted_id = mysqli_insert_id($db_linkedin);
					// $inserted_id = smm_db::insert_id();
					if ($inserted_id > 0) {
						$response['message'] = "successfull";
						$response['id'] = $inserted_id . "-lkapi";
						$url_base = "https://pipeline.callboxinc.com/pipeline/linkedinHelper/";
						$base_apikey = $inserted_id . "-lkapi";
						$apikey = base64_encode($base_apikey);
						$catch_hook_url = "https://pipeline.callboxinc.com/pipeline/linkedinHelper/" . $apikey;


						$sql = "";
						$sql = "UPDATE linkedin_account_persona SET catch_hook_url = '" . $catch_hook_url . "', api_key = '" . $apikey . "' WHERE linkedin_account_persona_id = " . $inserted_id;
						$res =  $db_linkedin->query($sql);
						// $res = smm_db::query($sql);
						if (mysqli_error($db_linkedin) != "") {
							$response['fullname'] = $fullname;
							$response['email'] = $email;
							$response['team_id_access'] = $team_id_access;
							$response['message'] = "error";
							$response['error_info'] = mysqli_error($db_linkedin);
							$response['error_type'] = "3rd";
							return json_encode($response);
						}
						$response['affected_rows'] = smm_db::affected_rows();
					}

					$response['fullname'] = $fullname;
					// $response['email'] = $email;
					// $response['team_id_access'] = $team_id_access;
					// $response['message'] = "successfull";
				}
				return json_encode($response);
			}
			$response['fullname'] = $fullname;
			$response['email'] = $email;
			$response['team_id_access'] = $team_id_access;
			$response['account_type'] = $account_type;
			$response['message'] = "error";
			$response['error_type'] = "4th";

			return json_encode($response);
		} else {
			$response['fullname'] = $fullname;
			$response['email'] = $email;
			$response['team_id_access'] = $team_id_access;
			$response['message'] = "error";
			$response['error_type'] = "5th";
		}


		return json_encode($response);
	}
	public function checkandinsert_data_email_lkp($data_id, $email_lkp_id, $linkedin_account_persona_id)
	{

		// $email_lkp = (array) $db->table('emails_lkp')
		// 	->whereRaw($whereRaw)
		// 	->select('*')
		// 	->first();
		if ($data_id > 0 && $email_lkp_id > 0 && $linkedin_account_persona_id > 0) {
			$email_lkp = array();

			$sql = 'SELECT * FROM data_email_lkp 
			WHERE data_id = ' . $data_id . ' AND 
			email_lkp_id = ' . $email_lkp_id . ' AND 
			linkedin_account_persona_id = ' . $linkedin_account_persona_id . ' AND email_src_id = 5';


			$res = smm_db::query($sql);

			if (mysqli_num_rows($res) > 0) {
				while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
					// ’'
					return $row['data_email_lkp_id'];
					$email_lkp = $row;
				}
				// print_r($response);
				// return json_encode($response);
			} else {

				$sql_insert = 'INSERT INTO data_email_lkp 
				(data_id,email_lkp_id,linkedin_account_persona_id,email_src_id) VALUES 
				(' . $data_id . ',' . $email_lkp_id . ',' . $linkedin_account_persona_id . ', 5)';
				$res_insert = smm_db::query($sql_insert);
				return smm_db::insert_id();
			}
		}
		return 0;
	}
	public function check_and_insert_email($data_id, $email, $linkedin_account_persona_id)
	{

		// $email_lkp = (array) $db->table('emails_lkp')
		// 	->whereRaw($whereRaw)
		// 	->select('*')
		// 	->first();
		if ($data_id > 0 && strlen($email) > 0 && $linkedin_account_persona_id > 0) {
			$email_lkp = array();

			$sql = 'SELECT * FROM emails_lkp WHERE email = "' . utf8_encode($email)  . '"';


			$res = smm_db::query($sql);

			if (mysqli_num_rows($res) > 0) {
				while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
					// ’'
					$row['data_email_lkp_id'] = $this->checkandinsert_data_email_lkp($data_id, $row['email_id'], $linkedin_account_persona_id);
					return $row['data_email_lkp_id'];
					$email_lkp = $row;
				}
				// print_r($response);
				// return json_encode($response);
			} else {
				$sql = "";
				$sql = 'INSERT INTO emails_lkp (email) VALUES ("' . utf8_encode($email) . '")';

				$res = smm_db::query($sql);
				$data_email_lkp_id = $this->checkandinsert_data_email_lkp($data_id, smm_db::insert_id(), $linkedin_account_persona_id);

				return $data_email_lkp_id;
			}


			// if (!empty($email_lkp)) {

			// 	return $email_lkp['data_email_lkp_id'];
			// } else {
			// 	$sql = "";
			// 	$sql = 'INSERT INTO emails_lkp (email) VALUES ("' . utf8_encode($email) . '")';

			// 	$res = smm_db::query($sql);
			// 	$data_email_lkp_id = $this->checkandinsert_data_email_lkp($data_id, smm_db::insert_id(), $linkedin_account_persona_id);

			// 	return $data_email_lkp_id;
			// }
		}

		return 0;
	}
	public function showMessagesForDebug()
	{

		// $db_linkedin = new MySQLi("192.168.50.47", "app_pipe", "a33-pipe", "callbox_mailer_data");

		$sql = "";
		$sql = "SELECT * FROM messages AS m INNER JOIN `data` as d USING (data_id) INNER JOIN linkedin_account_persona as lap USING (linkedin_account_persona_id) WHERE m.message_id > 75";



		$res = smm_db::query($sql);

		$response = array();
		echo "<style>tr,
		td,
		th {
			border-spacing: 0px;
			border-collapse: separate;
			border: 1px solid black;
		} </style>";
		echo "<table>";
		echo "<tr>";
		echo "<th>Send Date</th>";
		echo "<th>Persona</th>";
		echo "<th>Contact</th>";
		echo "<th>Msg</th>";
		echo "</tr>";

		while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
			echo "<tr>";
			echo "<td>" . $row['send_date'] . "</td>";
			echo "<td>" . $row['my_fullname'] . "</td>";
			echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "<br>" . $row['email'] . "</td>";

			echo "<td>";
			echo $row['message_text'];

			echo "</td>";



			echo "</tr>";
			$response[] = $row;
		}
		echo "</table>";



		// echo json_encode($response);
	}
	public function insert_org($org)
	{
		if (strlen($org->organization) > 0) {
			$sql = 'INSERT INTO 
			organizations_lkp 
			(
				linkedin_organization_id,
				organization_name,
				organization_url,
				organization_website,
				organization_location_1
			) 
			VALUES  
			(
				' . $org->organization_id . ',
				"' . $org->organization . '",
				"' . $org->organization_url . '",
				"' . $org->organization_website . '",
				"' . $org->organization_location . '"
			)';
			$res = smm_db::query($sql);
			return smm_db::insert_id();
		}
		return 0;
	}
	public function insert_phone_numbers($phone)
	{
		if (strlen($phone) > 0) {
			$sql = 'INSERT INTO 
			phone_numbers 
			(
				`phone`
			) 
			VALUES  
			(
				"' . $phone . '"
			)';
			$res = smm_db::query($sql);
			return smm_db::insert_id();
		}
		return 0;
	}
	public function get_heirarchy($user_id = null)
	{
		if ($user_id != null) {
			$filter = "WHERE u.user_id IN ($user_id)";
		}

		if ($filter) {
			$filter .= " AND h_t_team.x='active' AND h_t_group.x='active' AND h_t_dept.x='active'";
		} else {
			$filter = " WHERE h_t_team.x='active' AND h_t_group.x='active' AND h_t_dept.x='active'";
		}


		$sql = "SELECT SQL_SMALL_RESULT SQL_CACHE CONCAT(emp.first_name,' ',emp.last_name) AS name,u.user_id AS id,
			  h_t_team.hierarchy_tree_id AS grpid,h_t_group.hierarchy_tree_id AS busid,
			  h_t_dept.hierarchy_tree_id AS deptid,emp.extension AS extension
			  FROM users AS u
			  INNER JOIN employees AS emp ON (u.user_id=emp.user_id)
			  INNER JOIN hierarchy_tree_details AS htd ON (htd.user_id=u.user_id)
			  INNER JOIN hierarchy_tree AS h_t_team ON (htd.hierarchy_tree_id=h_t_team.hierarchy_tree_id)
			  INNER JOIN hierarchy_tree AS h_t_group ON (h_t_group.hierarchy_tree_id=h_t_team.parent_id)
			  INNER JOIN hierarchy_tree AS h_t_dept ON (h_t_dept.hierarchy_tree_id=h_t_group.parent_id)
			  $filter	
			";

		return $sql;
	}
	public function getOrg($org = array())
	{
		$sql = "";

		if ($org['organization_lkp_id'] > 0) {
			$sql = "SELECT * FROM `organizations_lkp` WHERE `organization_lkp_id` = " . $org['organization_lkp_id'];
		} elseif ($org['linkedin_organization_id'] > 0) {
			$sql = "SELECT * FROM `organizations_lkp` WHERE `linkedin_organization_id` = " . $org['linkedin_organization_id'] . " AND organization_location_1 = \"" . $org['organization_location_1'] . "\"";
		} elseif (strlen($org['organization']) > 0) {
			$sql = 'SELECT * FROM `organizations_lkp` WHERE `organization_name` = "' . $org['organization'] . '"' . " AND organization_location_1 = \"" . $org['organization_location_1'] . "\"";
		}
		$response = array();

		if ($sql != "") {
			$res = smm_db::query($sql);

			if (mysqli_num_rows($res) > 0) {
				while ($row = $res->fetch_array(MYSQLI_ASSOC)) {

					$response = $row;
				}
				return $response;
			}
		}
		return array();
	}
	public function getPhoneNumbers($phone = array())
	{
		$sql = "";

		if (isset($phone['phone'])) {
			$phone_formatted = $string = preg_replace('/\s+/', '', $phone['phone']);
			$sql = 'SELECT * FROM `phone_numbers` WHERE `phone` = "' . $phone_formatted . '" LIMIT 1';
		} elseif (isset($phone['phone_number_id'])) {
			$sql = "SELECT * FROM `phone_numbers` WHERE `phone_number_id` = " . $phone['phone_number_id'] . " LIMIT 1";
		}
		$response = array();

		if ($sql != "") {
			$res = smm_db::query($sql);

			if (mysqli_num_rows($res) > 0) {
				while ($row = $res->fetch_array(MYSQLI_ASSOC)) {

					$response = $row;
				}
				return $response;
			}
		}
		return array();
	}
	public function getDataPhoneNumbers($data_id)
	{
		$sql = "";

		if ($data_id > 0) {
			$sql = 'SELECT * FROM `data_phone_numbers` WHERE `data_id` = ' . $data_id;
		}
		$response = array();

		if ($sql != "") {
			$res = smm_db::query($sql);

			if (mysqli_num_rows($res) > 0) {
				while ($row = $res->fetch_array(MYSQLI_ASSOC)) {

					$response[] = $row;
				}
				return $response;
			}
		}
		return array();
	}
	// public function updateDataPhoneNumbers($phones)
	// {

	// 	$sql = "";
	// 	if (!empty($phones)) {

	// 		$params = "";
	// 		foreach ($phones as $k => $val) {
	// 			// return $val['data_id'] . "====" . $val['phone'];
	// 			if (isset($val['data_id'])) {
	// 				if ($val['data_id'] > 0) {

	// 					if (isset($val['phone_lkp_id']) && $val['phone_lkp_id'] > 1) {
	// 						$sql = "UPDATE `data_phone_numbers` SET `x` = '" . $val['x'] . "' WHERE phone_lkp_id = " . $val['phone_lkp_id'];

	// 						$res = smm_db::query($sql);
	// 						// return smm_db::affected_rows();
	// 					} else {

	// 						// $phone_formatted = $string = preg_replace('/\s+/', '', $val['phone']);
	// 						// $sql = "INSERT IGNORE INTO phone_numbers";

	// 						// $resCheckPhones = smm_db::query($sql);

	// 						if (isset($val['phone']) && strlen($val['phone']) > 0) {
	// 							$phone_formatted = $string = preg_replace('/\s+/', '', $val['phone']);
	// 							$sql = 'SELECT * FROM `phone_numbers` WHERE `phone` = "' . $phone_formatted . '" LIMIT 1';
	// 							$response = array();

	// 							$resCheckPhones = smm_db::query($sql);

	// 							if (mysqli_num_rows($resCheckPhones) > 0) {
	// 							} else {
	// 								$sql = "INSERT IGNORE INTO phone_numbers (`phone`) VALUES ('" . $phone_formatted . "')";

	// 								$resInsertedPhones = smm_db::query($sql);
	// 								if (smm_db::affected_rows() > 0 && smm_db::insert_id() > 0) {
	// 									$sql = "INSERT IGNORE INTO data_phone_numbers (`phone_number_id`,`data_id`,`phone_type`,`x`) VALUES (" . smm_db::insert_id() . "," . $val['data_id'] . ",'" . $val['phone_type'] . "','active')";
	// 									$resInsertedPhonesNos = smm_db::query($sql);
	// 								}
	// 							}
	// 						}
	// 					}
	// 				}
	// 			}
	// 		}
	// 	}
	// 	return array();
	// }
	public function updateDataPhoneNumbers($phones)
	{

		$sql = "";
		if (!empty($phones)) {

			$params = "";
			$response = array();
			foreach ($phones as $k => $val) {
				// return $val['data_id'] . "====" . $val['phone'];
				if (isset($val['data_id'])) {
					if ($val['data_id'] > 0) {

						if (isset($val['phone_lkp_id']) && $val['phone_lkp_id'] > 1) {

							if ($val['phone_number_id'] > 0) {
								$sql = 'SELECT * FROM `phone_numbers` WHERE `phone` = "' . $val['phone'] . '" LIMIT 1';


								$resCheckPhones = smm_db::query($sql);

								if (mysqli_num_rows($resCheckPhones) > 0) {
									while ($row = $resCheckPhones->fetch_array(MYSQLI_ASSOC)) {
										$sql_update_data_phone_numbers_params = "";
										if ($row['phone_number_id'] != $val['phone_number_id']) {
											$sql_update_data_phone_numbers_params = ", phone_number_id = " . $row['phone_number_id'];
										}


										$sql = "UPDATE `data_phone_numbers` SET `phone_type` = '" . $val['phone_type'] . "' , `x` = '" . $val['x'] . "' " . $sql_update_data_phone_numbers_params . " WHERE phone_lkp_id = " . $val['phone_lkp_id'];

										$res = smm_db::query($sql);
									}
								} else {

									$sql = "UPDATE `phone_numbers` SET `phone` = '" . $val['phone'] . "' WHERE phone_number_id = " . $val['phone_number_id'];

									$res_data_phone_numbers = smm_db::query($sql);
								}
							}
							if (isset($val['primary'])) {
								if (strlen($val['primary']) > 0) {
									$response[$val['primary']] = $val['phone_number_id'];
								}
							}
							// return smm_db::affected_rows();
						} else {

							// $phone_formatted = $string = preg_replace('/\s+/', '', $val['phone']);
							// $sql = "INSERT IGNORE INTO phone_numbers";

							// $resCheckPhones = smm_db::query($sql);

							if (isset($val['phone']) && strlen($val['phone']) > 0) {
								$phone_formatted = $string = preg_replace('/\s+/', '', $val['phone']);
								$sql = 'SELECT * FROM `phone_numbers` WHERE `phone` = "' . $phone_formatted . '" LIMIT 1';


								$resCheckPhones = smm_db::query($sql);

								if (mysqli_num_rows($resCheckPhones) > 0) {
								} else {
									$sql = "INSERT IGNORE INTO phone_numbers (`phone`) VALUES ('" . $phone_formatted . "')";

									$resInsertedPhones = smm_db::query($sql);
									if (smm_db::affected_rows() > 0 && smm_db::insert_id() > 0) {
										if (isset($val['primary'])) {
											if (strlen($val['primary']) > 0) {
												$response[$val['primary']] = smm_db::insert_id();
											}
										}
										$sql = "INSERT IGNORE INTO data_phone_numbers (`phone_number_id`,`data_id`,`phone_type`,`x`) VALUES (" . smm_db::insert_id() . "," . $val['data_id'] . ",'" . $val['phone_type'] . "','active')";
										$resInsertedPhonesNos = smm_db::query($sql);
									}
								}
							}
						}
					}
				}
			}
			return $response;
		}
		return array();
	}
	public function map_org($org)
	{
		$response = array();
		if (isset($org->organization_id) && $org->organization_id > 0) {
			// if ($org->organization_id > 0) {
			$org_info = $this->getOrg(array("linkedin_organization_id" => $org->organization_id, "organization_location_1" => $org->organization_location));
			if (isset($org_info['organization_lkp_id']) > 0) {
				return $org_info['organization_lkp_id'];
			} else {
				$organization_lkp_id = $this->insert_org($org);
				return $organization_lkp_id;
			}
			// }
		} elseif (strlen($org->organization) > 0) {
			$org_info = $this->getOrg(array("organization" => $org->organization, "organization_location_1" => $org->organization_location));
			if (isset($org_info['organization_lkp_id']) > 0) {
				return $org_info['organization_lkp_id'];
			} else {
				$org_insert = new stdClass();
				$org_insert->organization_id = 0;
				$org_insert->organization = $org->organization;
				$org_insert->organization_location = $org->organization_location;
				if (isset($org->organization_url)) {
					$org_insert->organization_url = $org->organization_url;
				}
				if (isset($org->organization_url)) {
					$org_insert->organization_website = $org->organization_website;
				}


				$organization_lkp_id = $this->insert_org($org_insert);
				return $organization_lkp_id;
			}
		}
		return 0;
	}
	public function map_org_old($org)
	{
		$response = array();
		if (isset($org->organization_id) && $org->organization_id > 0) {
			// if ($org->organization_id > 0) {
			$org_info = $this->getOrg(array("linkedin_organization_id" => $org->organization_id));
			if (isset($org_info['organization_lkp_id']) > 0) {
				return $org_info['organization_lkp_id'];
			} else {
				$organization_lkp_id = $this->insert_org($org);
				return $organization_lkp_id;
			}
			// }
		} elseif (strlen($org->organization) > 0) {
			$org_info = $this->getOrg(array("organization" => $org->organization));
			if (isset($org_info['organization_lkp_id']) > 0) {
				return $org_info['organization_lkp_id'];
			} else {
				$org_insert = new stdClass();
				$org_insert->organization_id = 0;
				$org_insert->organization = $org->organization;
				$org_insert->organization_location = $org->organization_location;
				if (isset($org->organization_url)) {
					$org_insert->organization_url = $org->organization_url;
				}
				if (isset($org->organization_url)) {
					$org_insert->organization_website = $org->organization_website;
				}


				$organization_lkp_id = $this->insert_org($org_insert);
				return $organization_lkp_id;
			}
		}
		return 0;
	}

	public function updatePersona($personaInfo)
	{
		// return $personaInfo;
		$params = "";
		foreach ($personaInfo as $k => $val) {
			if ($k != "editPersonaId") {
				if ($k == "editFullname") {
					$params .= 'my_fullname = "' . $val . '",';
				}
				if ($k == "editEmail") {
					$params .= 'my_email = "' . $val . '",';
				}
				if ($k == "editAccount_type") {
					$params .= 'account_type = "' . $val . '",';
				}
				if ($k == "editTeam_id_access") {
					$params .= 'team_id_access = "' . $val . '",';
				}
				// if ($k == "regenerate") {
				// 	// $url_base = "https://pipeline.callboxinc.com/pipeline/linkedinHelper/";
				// 	$base_apikey = $val . "-lkapi";
				// 	$apikey = base64_encode($base_apikey);
				// 	$catch_hook_url = "https://pipeline.callboxinc.com/pipeline/linkedinHelper/" . $apikey;


				// 	$sql = "";
				// 	$sql = "UPDATE linkedin_account_persona SET catch_hook_url = '" . $catch_hook_url . "', api_key = '" . $apikey . "' WHERE linkedin_account_persona_id = " . $personaInfo['editPersonaId'];
				// 	$res = smm_db::query($sql);
				// }
			}
		}
		$params = rtrim($params, ",");
		if (strlen($params) > 0 && $personaInfo->editPersonaId > 0) {
			$sql = "UPDATE linkedin_account_persona SET " . $params . " WHERE linkedin_account_persona_id = " . $personaInfo->editPersonaId;
			$res = smm_db::query($sql);
			return smm_db::affected_rows();
		}
	}
	public function updateData($data_id, $data)
	{
		$sql = "";
		$response = array();
		if (!empty($data) && $data_id > 0) {
			$params = "";
			// return json_encode(json_decode(json_encode($data), true));
			$decoded_data = json_decode(json_encode($data), true);
			foreach ($data as $k => $val) {
				if ($k == "org") {
					// if (isset($val->add_to_history)) {
					// 	$org = array();
					// 	$org['organization_'] = $val->organization;
					// 	$org['organization_title_'] = $val->organization_title;
					// 	$org['organization_location_'] = $val->organization_location;
					// 	$added_other_data = $this->add_company_to_data_other_details($data_id, $org);
					// 	$added_other_data_encoded = json_encode($added_other_data);
					// 	$added_other_data_decoded = json_decode($added_other_data_encoded, true);
					// 	// return json_encode($added_other_data_decoded);
					// 	if (!empty($added_other_data)) {
					// 		$sql_data_other_details = "";
					// 		$sql_data_other_details = 'UPDATE `data_other_details` SET `companies` = "' . smm_db::real_escape_string(json_encode($added_other_data_decoded))  . '" WHERE `data_id` = ' . $data_id;
					// 		// $sql = 'UPDATE `data_other_details` SET companies = "' . json_encode($added_other_data) . '" WHERE data_id = ' . $data_id;
					// 		$resUpdate = smm_db::query($sql_data_other_details);
					// 		// return smm_db::affected_rows();

					// 	}
					// 	//weird ssql error
					// }

					$email_lkp_id_org = $this->check_and_insert_email($data_id, $decoded_data['email'], $decoded_data['linkedin_account_persona_id']);

					$organization_lkp_id = $this->map_company($data_id, $val, $email_lkp_id_org);
					// return json_encode($organization_lkp_id);
					// return json_encode(json_decode(json_encode($val), true));
					// return json_encode("org_id === " . $organization_lkp_id);

					if (isset($decoded_data["country"]) && $organization_lkp_id > 0) {

						if ($decoded_data["country"] > 0) {

							$sql_countries_lkp = "UPDATE organizations_lkp SET country_id = " . $decoded_data['country'] . " WHERE organization_lkp_id = " . $organization_lkp_id . " AND organization_location_1 = \"" . utf8_encode($val->organization_location) . "\"";
							$resUpdate = smm_db::query($sql_countries_lkp);
							// return json_encode($sql_countries_lkp);

							// return json_encode($k . "====" . $val);
						}
						// $params .= 'organization_lkp_id="' . $organization_lkp_id . '",';
					}
					// return json_encode($mapped_company);
					// foreach ($val->companies as $v) {
					// 	echo json_encode($v->organization);
					// 	// $organization_lkp_id = $this->map_org($v);
					// $params .= 'organization_lkp_id="' . $organization_lkp_id . '",';
					// }
				} elseif ($k == "email") {
					$email_lkp_id = $this->check_and_insert_email($data_id, $val, $decoded_data['linkedin_account_persona_id']);
					// $params .= 'email_lkp_id="' . $email_lkp_id . '",';
				} elseif ($k == "phones") {
					/// updateDataPhoneNumbers

					$Phone_var = 0;
					$Mobile_var = 0;
					$DirectLine_var = 0;
					$phone_mapped = $this->updateDataPhoneNumbers(json_decode(json_encode($val), true));
					if (!empty($phone_mapped)) {
						foreach ($phone_mapped as $key => $v) {
							if ($key == "Phone") {
								$Phone_var = $v;
							} elseif ($key == "Mobile") {
								$Mobile_var = $v;
							} elseif ($key == "Direct Line") {
								$DirectLine_var = $v;
							}
						}
						$params .=  "mobile_num_id=" . $Mobile_var . ",";
						$params .=  "phone_num_id=" . $Phone_var . ",";
						$params .=  "direct_line_num_id=" . $DirectLine_var . ",";
					}
					// return json_encode($phone_mapped);
				} elseif ($k == "country") {
				} elseif ($k == "linkedin_account_persona_id") {
				} else {
					$params .= $k . "='" . $val . "',";
				}
			}
			$params = rtrim($params, ",");
			if ($params != "") {
				$sql = "";
				$sql = "UPDATE `data` SET " . $params . " WHERE data_id = " . $data_id;
			}
			if ($sql != "") {
				$res = smm_db::query($sql);
				// return $sql;
				return smm_db::affected_rows();
			}
		}

		return 0;
	}

	public function getAllsCountries()
	{
		$sql = "";
		$response = array();

		$sql = "SELECT * FROM `countries_lkp` WHERE x = 'active'";
		$res = smm_db::query($sql);
		if (mysqli_num_rows($res) > 0) {

			while ($row = $res->fetch_array(MYSQLI_ASSOC)) {

				$response[] = $row;
			}
			return $response;
		}

		return array();
	}
	public function getData($data = array())
	{
		$sql = "";
		$response = array();
		if (isset($data['data_id']) && $data['data_id'] > 0) {
			$sql = "SELECT * FROM `data` WHERE `data_id` = " . $data['data_id'];
		}
		if (isset($data['email']) && strlen($data['email']) > 0) {
			$sql = "SELECT * FROM `data` WHERE `email` = " . $data['email'];
		}
		if ($sql != "") {
			$res = smm_db::query($sql);
			if (mysqli_num_rows($res) > 0) {

				while ($row = $res->fetch_array(MYSQLI_ASSOC)) {

					$response[] = $row;
				}
				return $response;
			}
		}
		return array();
	}
	public function assignUserToPersona($pipe_user_id2 = 0, $user_id = 0, $personaId = 0 )
	{
		$sql = "";
		$response = array();
		if ($pipe_user_id2 > 0 && $user_id > 0 && $personaId > 0) {


			$sql = "UPDATE linkedin_account_persona SET assigned_to = '$user_id', pipe_user_id = '$pipe_user_id2' WHERE linkedin_account_persona_id = $personaId";
		}
		if ($sql != "") {
			$res = smm_db::query($sql);
			return json_encode(smm_db::affected_rows());
		}
		return json_encode("error");
	}
	public function map_company($data_id, $org, $email_lkp_id_org = 0, $isSetCompany = 0)
	{
		if ($data_id > 0) {
			$response = array();
			// return $org;

			if (isset($org->organization_lkp_id) && $org->organization_lkp_id > 0) {
				$organization_lkp_id = $org->organization_lkp_id;
			} else {
				$organization_lkp_id = $this->map_org($org);
			}



			if ($organization_lkp_id > 0) {
				// $org_insert = new stdClass();
				// $org_insert->organization_id = 0;
				// $org_insert->organization = $org->organization;
				// $org_insert->organization_url = $org->organization_url;
				// $org_insert->organization_website = $org->organization_website;
				// $org_insert->organization_location = $org->organization_location;
				// $organization_lkp_id = $this->insert_org($org_insert);
				// return $organization_lkp_id;
				$data = array();
				$data['company'] = $org->organization;
				$data['data_id'] = $data_id;

				$data['add_to_history'] = $org->add_to_history;
				$data['organization_lkp_id'] = $organization_lkp_id;
				$data['organization_title_1'] = $org->organization_title;
				$data['organization_location_1'] = $org->organization_location;
				$data['user_id'] = 0;
				if ($org->user_id > 0) {
					$data['user_id'] = $org->user_id;
				}
				if (isset($org->organization_start)) {
					$data['organization_start'] = $org->organization_start;
				} else {
					$data['organization_start'] = null;
				}

				if (isset($org->organization_end)) {
					$data['organization_end'] = $org->organization_end;
				} else {
					$data['organization_end'] = null;
				}


				if ($email_lkp_id_org > 0) {
					$data['email_lkp_id_org'] = $email_lkp_id_org;
				} else {
					$data['email_lkp_id_org'] = $org->data_email_lkp_id;
					$email_lkp_id_org = $org->data_email_lkp_id;
				}

				$data['organization_title_id'] = $this->checkandinsert_organization_titles($org->organization_title);
				// $data['data_other_organization_lkp_id'] = $this->checkandinsert_data_other_organization_lkp($data);
				if (isset($org->add_to_history) && $org->add_to_history == true) {
					$data['data_other_organization_lkp_id'] = $this->checkandinsert_data_other_organization_lkp($data);
				} else {
					if ($isSetCompany > 0) {
						// $data['data_other_organization_lkp_id'] = $this->update_primary_data_other_organization_lkp($data_id, $organization_lkp_id);
						if (isset($org->data_other_organization_lkp_id) && $org->data_other_organization_lkp_id  > 0 && $email_lkp_id_org > 0) {
							$sql = "UPDATE data_other_organization_lkp SET primary_organization = 0, updated_by = " . $data['user_id'] . "  WHERE data_id = " . $data['data_id'] . " AND primary_organization = 1";
							$res = smm_db::query($sql);
							$sql1 = "UPDATE data_other_organization_lkp SET data_email_lkp_id = " . $email_lkp_id_org . ",primary_organization = 1, updated_by = " . $data['user_id'] . "  WHERE data_other_organization_lkp_id = " . $org->data_other_organization_lkp_id . "";
							$res1 = smm_db::query($sql1);
						}
					} else {
						$data['data_other_organization_lkp_id'] = $this->checkandinsert_data_other_organization_lkp($data);
					}
				}



				$data_organization_history_id = $this->checkandinsert_data_organization_history($data);
				// return $data_organization_history_id;
				// if (isset($org->add_to_history)) {
				// 	$this->get_data_other_details($data_id);
				// }
				// $data_updated = $this->updateDataForCompanyMapped($data_id, $data);

				return $organization_lkp_id;
				// echo json_encode($data_updated);
			}


			// $sql = "SELECT * FROM `data` WHERE `data_id` = " . $data_id;
			// $res = smm_db::query($sql);


			// while ($row = $res->fetch_array(MYSQLI_ASSOC)) {

			// 	$response[] = $row;
			// }
			// echo json_encode($response);
		} else {
			return 0;
		}
	}
	public function update_primary_data_other_organization_lkp($data_id, $organization_lkp_id)
	{
		// if ($data_id > 0 && $organization_lkp_id > 0) {
		// 	$sql = "UPDATE data_other_organization_lkp SET organization_lkp_id = " . $organization_lkp_id . " WHERE data_id = " . $data_id . " AND primary_organization = 1";
		// 	$res = smm_db::query($sql);
		// }
	}
	public function checkmydate($date)
	{
		$tempDate = explode('-', $date);
		return checkdate($tempDate[1], $tempDate[2], $tempDate[0]);
	}
	public function checkandinsert_data_organization_history($org = array())
	{
		// $data['organization_start'] = $org->organization_start;
		// $data['organization_end'] = $org->organization_end;

		if ($org['organization_title_id'] > 0 && $org['data_other_organization_lkp_id'] > 0) {
			$sql = 'SELECT * FROM data_organization_history WHERE 
			data_other_organization_lkp_id = ' . $org['data_other_organization_lkp_id'] .
				' AND organization_title_id = ' . $org['organization_title_id'];

			if (isset($org['organization_start']) && $org['organization_start'] != null && $this->checkmydate($org['organization_start'])) {
				$sql .= " AND organization_start = \"" . $org['organization_start'] . "\"";
			}
			if (isset($org['organization_end']) && $org['organization_end'] != null && $this->checkmydate($org['organization_end'])) {
				$sql .= " AND organization_end = \"" . $org['organization_end'] . "\"";
			}

			$res = smm_db::query($sql);
			$response = array();
			if (mysqli_num_rows($res) > 0) {
			} else {
				$sql_insert = 'INSERT INTO data_organization_history 
			(data_other_organization_lkp_id,organization_start,organization_end,organization_title_id) VALUES 
			(
				' . $org['data_other_organization_lkp_id'] . ',
				"' . $org['organization_start'] . '",
				"' . $org['organization_end'] . '",
				' . $org['organization_title_id'] . '
			)';
				$res_insert = smm_db::query($sql_insert);
				return smm_db::insert_id();
			}
		}
		return 0;
	}
	public function checkandinsert_data_other_organization_lkp($org)
	{

		if (!$org['user_id'] > 0) {
			$org['user_id'] = 0;
		}
		$sql = 'SELECT * FROM data_other_organization_lkp 
		WHERE data_id = ' . $org['data_id'] . " 
		AND organization_lkp_id = " . $org['organization_lkp_id'] . " 
		AND organization_title_id = " . $org['organization_title_id'];
		$res = smm_db::query($sql);
		$response = array();
		if (mysqli_num_rows($res) > 0) {
			if ($org['data_id'] > 0) {
				$sql_update = "UPDATE data_other_organization_lkp SET primary_organization = 0, updated_by = " . $org['user_id'] . " WHERE data_id = " . $org['data_id'] . " AND primary_organization = 1";
				$res_update = smm_db::query($sql_update);
			}

			while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
				$sql_update1 = "UPDATE data_other_organization_lkp SET primary_organization = 1, updated_by = " . $org['user_id'] . " WHERE data_other_organization_lkp_id = " . $row['data_other_organization_lkp_id'];
				$res_update1 = smm_db::query($sql_update1);



				return $row['data_other_organization_lkp_id'];
				$response = $row['data_other_organization_lkp_id'];
			}
		} else {
			if ($org['data_id'] > 0) {

				$sql_update = "UPDATE data_other_organization_lkp SET primary_organization = 0, updated_by = " . $org['user_id'] . " WHERE data_id = " . $org['data_id'] . " AND primary_organization = 1";
				$res_update = smm_db::query($sql_update);
			}

			$sql = 'INSERT INTO data_other_organization_lkp 
			(data_id,organization_lkp_id,sort,primary_organization,organization_title_id,data_email_lkp_id,added_by) VALUES 
			(
				' . $org['data_id'] . ',
				' . $org['organization_lkp_id'] . ',
				(SELECT MAX( `sort` )+1 FROM data_other_organization_lkp as doo WHERE data_id = ' . $org['data_id'] . '),
				1,
				' . $org['organization_title_id'] . ',
				' . $org['email_lkp_id_org'] . ',
				' . $org['user_id'] . '
			)';
			$res = smm_db::query($sql);
			return smm_db::insert_id();
		}
		return 0;
	}
	public function checkandinsert_organization_titles($org_title)
	{

		$sql = 'SELECT * FROM organization_titles WHERE organization_title = "' . utf8_encode($org_title) . '" LIMIT 1';
		$res = smm_db::query($sql);
		$response = array();
		if (mysqli_num_rows($res) > 0) {

			while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
				return $row['organization_title_id'];
			}
		} else {
			$sql = 'INSERT INTO organization_titles (organization_title) VALUES ("' . utf8_encode($org_title) . '")';
			$res =  smm_db::query($sql);
			return smm_db::insert_id();
		}
		return 0;
	}

	public function map_contact_no($phone, $data_id)
	{

		$response = array();
		// $data = array();getDataPhoneNumbers
		// $data['company'] = $org->organization;
		// $data['organization_lkp_id'] = $organization_lkp_id;
		// $data['organization_title_1'] = $org->organization_title;
		// $data['organization_location_1'] = $org->organization_location;
		// $data_updated = $this->updateData($data_id, $data);
		// echo json_encode($data_updated);
		if (strlen($phone) > 0) {
			$phone_info = $this->getPhoneNumbers(array("phone" => $phone));
			if (isset($phone_info['phone_number_id']) > 0) {
				// return $phone_info['phone_number_id'];
				$phone_numbers = $this->getDataPhoneNumbers($data_id);
			} else {

				$phone_number_id = $this->insert_phone_numbers($phone);
				$phone_numbers = $this->getDataPhoneNumbers($data_id);

				// return $phone_number_id;
			}
		}
		return 0;
	}
	public function get_organization($search)
	{
		$sql = 'SELECT * FROM organizations_lkp WHERE organization_name LIKE "%' . $search . '%" LIMIT 10';
		$res = smm_db::query($sql);
		$response = array();
		if (mysqli_num_rows($res) > 0) {

			while ($row = $res->fetch_array(MYSQLI_ASSOC)) {

				$response[] = $row;
			}
			return $response;
		}
		return array();
	}
	public function setPersonaStatus($linkedin_account_persona_id, $status)
	{
		if ($linkedin_account_persona_id > 0 && ($status == "active" || $status == "inactive")) {
			$sql = 'UPDATE linkedin_account_persona SET `x` = "' . $status . '" WHERE linkedin_account_persona_id = ' . $linkedin_account_persona_id;
			$res = smm_db::query($sql);
			$response = array();
			return smm_db::affected_rows();
		}

		return null;
	}
	public function add_company_to_data_other_details($data_id, $org = array())
	{
		$sql = "SELECT * FROM `data_other_details` WHERE LENGTH(companies) > 1 AND data_id = " . $data_id . " LIMIT 1";
		$data_other_details = smm_db::query($sql);
		// $row1['other_details']['counts'] = $sql;
		// echo json_encode(smm_db::getError());
		if (mysqli_num_rows($data_other_details) > 0) {

			while ($row2 = $data_other_details->fetch_array(MYSQLI_ASSOC)) {
				// print_r($row2);


				$decoded_companies = json_decode($row2['companies'], true);
				$i = 0;
				$counter = 0;
				$response = array();
				if (isset($decoded_companies['organization_1'])) {
					$org_arr_fields = array(
						"organization_",

						"organization_id_",

						"organization_url_",

						"organization_title_",

						"organization_start_",

						"organization_end_",

						"organization_description_",

						"organization_location_",

						"organization_website_",

						"organization_domain_"

					);
					while ($i == 0) {
						$counter++;
						$key = "organization_" . $counter;
						$key2 = "organization_title_" . $counter;
						$arr = array();
						if ($counter == 20) {
							$i = 1;
						}
						if (isset($decoded_companies[$key])) {

							foreach ($org_arr_fields as $val) {
								$key_org = substr_replace($val, "", -1);
								$orig_key = $val;
								$val = $val . $counter;
								$response[$val] = trim($decoded_companies[$val]);
							}
							// $response[] = $arr;
						} else {
							if (!empty($org)) {
								foreach ($org_arr_fields as $val) {
									$key_org = substr_replace($val, "", -1);
									$orig_key = $val;
									$val = $val . $counter;
									$response[$val] = trim($org[$orig_key]);
								}
								// $response['organization_' . $counter] = $org['company'];
								// $response['organization_title_' . $counter] = $org['organization_title'];
								// $response['organization_location_' . $counter] = $org['organization_location'];
								// $response[$val]  
							}

							$i = 1;
						}
					}
				}
			}
			return $response;
		}
		return array();
	}
	public function getCampaignNames($request)
	{

		$sql = "SELECT 
					* 
				  FROM
				   campaigns_helper 
				  WHERE
				   linkedin_account_persona_id = {$request->personaId}";

		$res = smm_db::query($sql);

		$response = array(
			array("id" => 0, "label" => "")
		);

		while ($row = $res->fetch_array(MYSQLI_ASSOC))
			$response[] = array("id" => $row['campaign_helper_id'], "label" => $row['campaign_name']);

		return $response;
	}







// 	public function get_campaign_names($request){
// 	$sql = "SELECT 
// 					* 
// 				  FROM
// 				   campaigns_helper 
// 				  WHERE
// 				   linkedin_account_persona_id = {$request->personaId}";

// 		$res = smm_db::query($sql);
// while ($row = $res->fetch_array(MYSQLI_ASSOC))
//  {  
//       $output[] = $row;  
//  }  
//  echo json_encode($output);		
//  }


public function get_campaign_names($request)
	{
		$sql = "";
		$response = array();

		$sql = "SELECT * FROM `campaigns_helper` WHERE linkedin_account_persona_id = {$request->personaId} ";
		$res = smm_db::query($sql);
		if (mysqli_num_rows($res) > 0) {

			while ($row = $res->fetch_array(MYSQLI_ASSOC)) {

				$response[] = $row;
			}
			return $response;
		}

		return array();
	}


};































class PIPE
{

	public function getTeam()
	{

		$sql = "SELECT node AS team_name, hierarchy_tree_id, parent_id FROM hierarchy_tree WHERE node_type = 'team' AND module_id = 1 AND x= 'active' ORDER BY team_name ASC";
		$res = pipe_db::query($sql);

		$response = array();
		if (mysqli_num_rows($res) > 0) {

			while ($row = $res->fetch_array(MYSQLI_ASSOC)) {

				$response[] = $row;
			}
		}


		echo json_encode($response);
	}

	public function getDepartments()
	{

		$dept = array(5, 123, 128, 11, 18, 23, 28, 126, 424, 284);

		$sql = "SELECT
				   hierarchy_tree_id, node
				  FROM
				   hierarchy_tree
				  WHERE
				   hierarchy_tree_id IN (" . implode(",", $dept) . ")
				  AND
				   x = 'active'";

		$res = pipe_db::query($sql);

		$response = array();
		if (mysqli_num_rows($res) > 0) {
			while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
				$response[$row['hierarchy_tree_id']] = $row['node'];
			}
		}
		$sorted = array();

		foreach ($dept as $id) {
			$sorted[] = array("id" => $id, "node" => $response[$id]);
		}

		return $sorted;
	}

	public function getClients($dept_id)
	{
		$params = array();
		$params["date_from"] = date("Y-m-d", strtotime("-8 months"));;
		$params["date_to"] = date("Y-m-d");
		$params["hierarchy_tree_id"] = array($dept_id);
		$params['follow_sort_params'] = 1;

		$active_clients  = px_report::get_active_clients($params);

		$clients = array();

		foreach ($active_clients['clients_lookup'] as $id => $client) {
			$clients[] = array('id' => $id, 'client' => $client);
		}

		return $clients;
	}

	public function getClientAccounts($client_id)
	{

		$sql = "SELECT
				 	client_account_id, account_number
				  FROM
				   client_accounts
				  WHERE 
				   client_id = $client_id
				  AND
				   x = 'active'";

		$res = pipe_db::query($sql);

		$response = array();

		if (mysqli_num_rows($res) > 0) {
			while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
				$response[] = array('id' => $row['client_account_id'], 'account_number' => $row['account_number']);
			}
		}

		return $response;
	}

	public function getClientLists($client_account_id)
	{

		$sql = "SELECT
		 			cl.client_list_id, cl.list
				  FROM
				   client_accounts ca
				  INNER JOIN
				   client_job_orders cjo USING(client_account_id)
				  INNER JOIN
				   client_lists cl USING(client_job_order_id)
				  WHERE
				   ca.client_account_id = $client_account_id AND cl.x = 'active'";

		$res = pipe_db::query($sql);

		$response = array();

		if (mysqli_num_rows($res) > 0) {
			while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
				$response[] = array('id' => $row['client_list_id'], 'list' => $row['list']);
			}
		}

		return $response;
	}

	public static function formatContacts($data)
	{

		$headers = array(
			'email', 'firstname', 'lastname', 'notes', 'content', 'address1', 'company', 'state', 'country',
			'position', 'phone', 'zipcode', 'website', 'country', 'date_connected', 'date_added',
			'date sent', 'time sent', 'persona', 'date opened', 'time opened'
		);

		$keys = array(
			'email', 'first_name', 'last_name', 'notes', 'content', 'address1', 'company', 'state', 'country', 'position', 'phone_1',
			'zipcode', 'website', 'country', 'cn_date_connected', 'pure_date_added'
		);

		$db_headers = array(
			'email' 			=> 'email',
			'firstname' 	=> 'fname',
			'lastname' 		=> 'lname',
			'first name' 	=> 'fname',
			'last name' 	=> 'lname',
			'notes' 			=> 'note',
			'content' 		=> 'note',
			'address1' 		=> 'address',
			'company' 		=> 'company',
			'state' 			=> 'state',
			'position' 		=> 'position',
			'phone' 			=> 'phone',
			'zipcode' 		=> 'zipcode',
			'siccode' 		=> 'siccode',
			'website' 		=> 'website',
			'date sent' 	=> 'date_sent',
			'time sent' 	=> 'time_sent',
			'persona' 		=> 'persona_name',
			'date opened' 	=> 'date_sent',
			'time opened' 	=> 'time_sent'
		);

		$new_data = array();

		foreach ($data as $value) {
			$x = array();
			foreach ($keys as $key) {
				$x[] = $value->$key ?: "";
			}
			$new_data[] = $x;
		}

		return array($new_data, $db_headers, $headers);
	}

	public function insertToDMT($request)
	{

		extract((array) $request, EXTR_OVERWRITE);

		$table = $is_generic ? 'social_media_report_generic' : 'social_media_report';

		$date_from = date('Y-m-d', strtotime($date_from));

		$sql = "SELECT 
					* 
				  FROM
				   $table 
				  WHERE
				   date_from = '$date_from' 
				  AND
				   client_account_id = $clientaccount
				  AND
				   user_id = $user_id";

		$res = pipe_db::query($sql);

		$res = $res->fetch_array(MYSQLI_ASSOC);
		if (!empty($res)) {

			$sql = "UPDATE 
						$table 
					  SET 
					  	connections = $connections,
						invite_sent = $connection_invite_sent,
						inmail_sent = $direct_message_sent,
						inmail_received = $inmail_received
					  WHERE
					   date_from = '$date_from'
					  AND
					   client_account_id = $clientaccount
					  AND
					   user_id = $user_id";

			if (pipe_db::query($sql))
				return array('status' => 'success', 'message' => "Successfully Updated.");

			return array('status' => 'error', 'message' => 'There\'s an error!');
		}

		$sql = "INSERT INTO $table 
					(user_id, client_id, client_account_id, connections, invite_sent, inmail_sent, inmail_received, date_from, persona)
				  VALUES
				   ($user_id, $client_id, $clientaccount, $connections, $connection_invite_sent, $direct_message_sent, $inmail_received, '$date_from', '$persona_name')";

		if (pipe_db::query($sql))
			return array('status' => 'success', 'message' => "Successfully imported to Digital Marketing Tool.");

		return array('status' => 'error', 'message' => 'There\'s an error!');
	}

	public function importToTmOutbound($request)
	{

		extract((array) $request, EXTR_OVERWRITE);

		list($csv_dec, $db_headers, $headers) = self::formatContacts($contacts);

		// $csv_dec = json_decode(stripslashes($csv));

		$record_ids = array();
		$s = self::get_event_status();
		$marketing_event_status = array(
			'Linkedin - Connected' => 'Connection Accepted',
			'Linkedin Invite Sent' => 'Connection Invite Sent',
			'Linkedin DM Sent' 	 => 'Direct Message Sent',
			'Linkedin DM Received' => 'Replied Msg'
		);

		for ($i = 0; $i < count($s); $i++) {

			if ($s[$i]['event_state'] == "")
				continue;

			$statuses[strtolower($s[$i]['event_state'])] = $s[$i]['event_state_lkp_id'];
		}

		$formData = (array) $formData;

		if ($is_spec_date) {
			$date_contacted = self::toUTCdate("Y-m-d", $formData['upload_date']);
			$time_contacted = self::toUTCdate("H:i:s", $formData['upload_date']);
		}
		// return $request;
		foreach ($csv_dec as $k => $i) {
			$t = array();
			foreach ($i as $j => $x) {
				$event_tm_ob_lkp_id = 0;
				if ($x == "") continue;
				$header_name = ($db_header[$headers[$j]]) ? $db_header[$headers[$j]] : $headers[$j];

				if ($header_name == "phone" || $header_name == "mobile_phone") $x = self::cleanPhone($x);

				if ($header_name == "username") {
					$header_name = "tm_user_id";
					$user_id = self::checkUsername(trim($x));
					$x = $user_id['user_id'];
					$hierarchy_tree_id = self::getHierarchyTreeId($x);
				}
				if ($header_name == "channel") {
					$channel = self::checkChannel(trim($x));
					$header_name = "channel_lkp_id";
					$x = $channel['channel_lkp_id'];
				}

				if ($header_name == 'status') {
					if (isset($marketing_event_status[$x])) {
						$t[$header_name] = $statuses[strtolower($marketing_event_status[$x])];
					} else {
						$t[$header_name] = $statuses[strtolower($x)];
					}
				} else {
					$t[$header_name] = $x;
				}
			}
			$t['country'] = $t['country'] ?: 'SG';
			$t['status'] = $formData['event_state_lkp_id'];
			$t['channel_lkp_id'] = 3;
			$t['tm_user_id'] = $formData['user_id'];
			if (!$is_spec_date) {
				$date_contacted = self::toUTCdate("Y-m-d", $t['date_added']);
				$time_contacted = self::toUTCdate("H:i:s", $t['date_added']);
				unset($t['date_added']);
				unset($t['date_connected']);
			}
			if ($is_connection_accepted) {
				$date_contacted = self::toUTCdate("Y-m-d", $t['date_connected']);
				$time_contacted = self::toUTCdate("H:i:s", $t['date_connected']);
				unset($t['date_added']);
				unset($t['date_connected']);
			}
			// return "$date_contacted $time_contacted";
			$hierarchy_tree_id = $formData['hierarchy_tree_id'];
			$status_flip = array_flip($statuses);

			$checkTarget = self::checkTarget($formData['client_list_id'], $t, $formData['clientaccount']);

			$client_list_detail_id = 0;
			if (!empty($checkTarget)) {
				$target_detail_id = $checkTarget['target_detail_id'];
				$client_list_detail_id = $checkTarget['client_list_detail_id'];
			} else {
				$t['clientaccount'] = $formData['clientaccount'];
				$t['client_id'] = $formData['client_id'];
				$t['client_list_id'] = $formData['client_list_id'];
				list($target_detail_id, $comp_detail_id) = self::save_target($t);
			}

			$p = array();
			$p['target_detail_id'] = $target_detail_id;
			$p['client_list_id'] = $formData['client_list_id'];
			$p['op_center_lkp_id'] = 1;
			$p['event_tm_ob_txn_id'] = 0;
			$p['x'] = 'active';
			$client_list_detail_id = !empty($client_list_detail_id) ? $client_list_detail_id : self::insertClientListDetails($p);

			if ($t['status'] == 22) { // Never Dialed
				$record_ids[] = 'cl-' . $client_list_detail_id;
			} else {
				$p['date_contacted'] = $date_contacted;
				$p['user_id'] = $t['tm_user_id'];
				$p['hierarchy_tree_id'] = $hierarchy_tree_id;
				if ($event_tm_ob_lkp_id == 0) {
					// return $p;
					$event_tm_ob_lkp_id = self::insertEventsTmObLkp($p);
				}
				$p['event_tm_ob_lkp_id'] = $event_tm_ob_lkp_id;
				$p['client_list_detail_id'] = $client_list_detail_id;
				$p['event_state_lkp_id'] = $t['status'];
				$p['time_contacted'] = $time_contacted;
				$p['notes'] = isset($t['note']) ? $t['note'] : ucwords($status_flip[$t['status']]);
				$p['channel_lkp_id'] = $t['channel_lkp_id'];
				$events_tm_ob_txn_id = self::insertEventsTmObTxn($p);
				self::updateClientListDetails($client_list_detail_id, $events_tm_ob_txn_id);
				$record_ids[] = $events_tm_ob_txn_id;
			}
		}

		return ($record_ids) ? array('status' => 'success', 'message' => "Successfully imported $selected_count contact(s) to TM Outbound.", 'txn_ids' => $record_ids) : array('status' => 'error', 'message' => 'There\'s an error!');
	}

	public static function insertClientListDetails($data)
	{

		extract($data, EXTR_OVERWRITE);

		$sql = "SELECT 
					client_list_detail_id 
				  FROM 
				  	client_list_details
				  WHERE 
				  	target_detail_id = $target_detail_id 
				  AND 
				   client_list_id = $client_list_id AND x = 'active'";

		$res = pipe_db::query($sql);

		$result = $res->fetch_array(MYSQLI_ASSOC);

		if (!empty($result)) {

			$sql = "UPDATE 
						client_list_details 
					  SET 
					  	client_list_id = $client_list_id, 
						target_detail_id = $target_detail_id, 
						event_tm_ob_txn_id = $event_tm_ob_txn_id, 
						x = '$x'
					  WHERE 
					  	client_list_detail_id = {$client_list_detail_id['client_list_detail_id']}";

			return $result['client_list_detail_id'];
		}

		$sql = "INSERT INTO 
					client_list_details (op_center_lkp_id, client_list_id, target_detail_id, event_tm_ob_txn_id, x)
				  VALUE 
				  	($op_center_lkp_id, $client_list_id, $target_detail_id, $event_tm_ob_txn_id, '$x')";

		pipe_db::query($sql);

		return pipe_db::insert_id();
	}

	public static function insertEventsTmObLkp($data)
	{

		extract($data, EXTR_OVERWRITE);

		$sql = "SELECT 
					event_tm_ob_lkp_id 
				  FROM 
				  	events_tm_ob_lkp
				  WHERE 
				   client_list_id = $client_list_id 
				  AND 
				   user_id = $user_id
				  AND 
				  	date_contacted = '$date_contacted'";

		$res = pipe_db::query($sql);

		$result = $res->fetch_array(MYSQLI_ASSOC);

		if (!empty($result))
			return $result['event_tm_ob_lkp_id'];

		$sql = "INSERT INTO 
					events_tm_ob_lkp (date_contacted, client_list_id, user_id, user_htree_id)
				  VALUE 
				   ('$date_contacted', $client_list_id, $user_id, $hierarchy_tree_id)";

		pipe_db::query($sql);

		return pipe_db::insert_id();
	}

	public static function insertEventsTmObTxn($data)
	{

		extract($data, EXTR_OVERWRITE);

		$notes = str_replace('"', "'", $notes);

		$sql = "INSERT INTO 
					events_tm_ob_txn (event_tm_ob_lkp_id, client_list_detail_id, event_state_lkp_id, time_contacted, notes, channel_lkp_id)
				  VALUE 
				   ($event_tm_ob_lkp_id, $client_list_detail_id, $event_state_lkp_id, '$time_contacted', \"$notes\", $channel_lkp_id)";

		pipe_db::query($sql);

		return pipe_db::insert_id();
	}

	public static function updateClientListDetails($client_list_detail_id, $events_tm_ob_txn_id)
	{

		$sql = "UPDATE 
					client_list_details 
				  SET 
				  	event_tm_ob_txn_id = $events_tm_ob_txn_id 
				  WHERE 
				  	client_list_detail_id = $client_list_detail_id";

		pipe_db::query($sql);
	}

	public static function get_event_status()
	{

		$sql = "SELECT 
					* 
				  FROM
				   event_states_lkp 
				  WHERE
				   x='active'
				  AND
				   module_id = 2 
				  ORDER BY
				   event_state ASC";

		$res = pipe_db::query($sql);

		$ret = array();

		while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
			$ret[] = $row;
		}

		return $ret;
	}

	public static function toUTCdate($format, $date)
	{
		return date($format, strtotime($date) - 60 * 60 * 8);
	}

	public static function cleanPhone($str)
	{
		return preg_replace('/[^0-9]/', '', $str);
	}

	public static function checkUsername($username)
	{

		if ($username == "") return 1;

		$sql = "SELECT user_id FROM users WHERE user_name LIKE '$username'";

		$res = pipe_db::query($sql);

		$row = $res->fetch_array(MYSQLI_ASSOC);

		return $row;
	}

	public static function getHierarchyTreeId($user_id)
	{

		$sql = "SELECT 
					hierarchy_tree_id 
				  FROM
				   hierarchy_tree_details
				  WHERE
				   user_id = $user_id
				  AND
				   x = 'active'";

		$res = pipe_db::query($sql);

		return $res->fetch_array(MYSQLI_ASSOC);
	}

	public static function checkChannel($channel)
	{

		if ($channel == "")
			return 1;

		$sql = "SELECT 
					channel_lkp_id 
				  FROM
				   channels_lkp 
				  WHERE
				   channel LIKE '$channel'";

		$res = pipe_db::query($sql);

		$res = $res->fetch_array(MYSQLI_ASSOC);

		return $res;
	}

	public static function checkTarget($client_list_id, $data, $client_account_id)
	{

		if (!empty($data['email'])) {

			$sql = "SELECT 
			   		cld.target_detail_id, cld.client_list_detail_id 
					  FROM
					   client_list_details cld
				  	  INNER JOIN
						target_details td USING(target_detail_id)
				  	  INNER JOIN
						emails_lkp e USING(email_lkp_id)
				  	  WHERE
						cld.client_list_id = $client_list_id
				  	  AND
						e.email LIKE \"" . pipe_db::real_escape_string($data['email']) . "\" AND cld.x = 'active' AND td.x = 'active'";

			$res = pipe_db::query($sql);

			$result = $res->fetch_array(MYSQLI_ASSOC);

			if (!empty($result))
				return $result;

			$sql = "SELECT 
						cld.target_detail_id, cld.client_list_detail_id, cld.client_list_id 
					  FROM
					   client_list_details cld
					  INNER JOIN
					   client_lists cl USING(client_list_id)
					  INNER JOIN
					   client_job_orders cjo USING(client_job_order_id)
					  INNER JOIN
					   target_details td ON(td.target_detail_id = cld.target_detail_id)
					  INNER JOIN
					   emails_lkp e USING(email_lkp_id)
					  WHERE
					   cjo.client_account_id = $client_account_id
					  AND
					   e.email LIKE \"" . pipe_db::real_escape_string($data['email']) . "\" AND cld.x = 'active' AND td.x = 'active'";

			$res = pipe_db::query($sql);

			$result = $res->fetch_array(MYSQLI_ASSOC);

			if (!empty($result)) {

				if ($client_list_id == 192933 && $result['client_list_id'] != 192933) {

					pipe_db::query("INSERT INTO 
										  client_list_details (client_list_id, target_detail_id, event_tm_ob_txn_id) 
										 VALUES
										  ($client_list_id, {$result['target_detail_id']}, 0)");

					$result['client_list_id'] = $client_list_id;

					$result['client_list_detail_id'] = pipe_db::insert_id();
				}

				return $result;
			}
		}

		return self::searchByName($data, $client_list_id, $client_account_id);
	}

	public static function searchByName($data, $client_list_id, $client_account_id)
	{

		extract($data, EXTR_OVERWRITE);

		if (!empty($phone) && !empty($firstname) && !empty($lastname)) {

			$sql = "SELECT
					   cld.target_detail_id, cld.client_list_detail_id 
					  FROM
					   client_list_details cld
					  INNER JOIN
					   target_details td USING(target_detail_id)
					  INNER JOIN
					   targets t using (target_id) 
					  INNER JOIN
					   contacts c using (contact_id)
					  WHERE
					   name_trim = \"$firstname $lastname\"
					  AND
					   t.target = \"$phone\" 
					  AND
					   cld.client_list_id = $client_list_id 
					  AND
					   cld.x='active'";

			$res = pipe_db::query($sql);

			$result = $res->fetch_array(MYSQLI_ASSOC);

			if (!empty($result))
				return $result;

			$sql = "SELECT
			 			cld.target_detail_id, cld.client_list_detail_id FROM client_list_details cld
					  INNER JOIN
					   client_lists cl USING(client_list_id)
				  	  INNER JOIN
						client_job_orders cjo USING(client_job_order_id)
					  INNER JOIN
					   target_details td ON(td.target_detail_id = cld.target_detail_id)
					  INNER JOIN
					   targets t using (target_id) 
					  INNER JOIN
					   contacts c using (contact_id)
					  WHERE
					   name_trim = \"$firstname $lastname\" 
					  AND
					   t.target = \"$phone\" 
					  AND
					   cjo.client_account_id = $client_account_id";

			$res = pipe_db::query($sql);

			$result = $res->fetch_array(MYSQLI_ASSOC);

			return $result;
		} elseif (!empty($company) && !empty($firstname) && !empty($lastname)) {

			$sql = "SELECT
					 	cld.target_detail_id, cld.client_list_detail_id FROM client_list_details cld
					  INNER JOIN
					   target_details td USING(target_detail_id)
					  INNER JOIN
					   targets t using (target_id) 
					  INNER JOIN
					   contacts c using (contact_id)
					  INNER JOIN
					   comp_details ON (td.comp_detail_id = comp_details.comp_detail_id)
					  INNER JOIN
					   companies com ON (comp_details.company_id = com.company_id)
					  WHERE
					   name_trim = \"$firstname $lastname\" AND com.company = \"$company\" 
					  AND
					   cld.client_list_id = $client_list_id AND cld.x='active'";

			$res = pipe_db::query($sql);

			$result = $res->fetch_array(MYSQLI_ASSOC);

			if (!empty($result))
				return $result;

			$sql = "SELECT
					 	cld.target_detail_id, cld.client_list_detail_id 
					  FROM
					   client_list_details cld
					  INNER JOIN
					   client_lists cl USING(client_list_id)
					  INNER JOIN
					   client_job_orders cjo USING(client_job_order_id)
					  INNER JOIN
					   target_details td ON(td.target_detail_id = cld.target_detail_id)
					  INNER JOIN
					   targets t USING (target_id) 
					  INNER JOIN
					   contacts c USING (contact_id)
					  INNER JOIN
					   comp_details ON (td.comp_detail_id = comp_details.comp_detail_id)
					  INNER JOIN
					   companies com ON (comp_details.company_id = com.company_id)
					  WHERE
					   name_trim = \"$firstname $lastname\" AND com.company = \"$company\" 
					  AND
					   cjo.client_account_id = $client_account_id";

			$res = pipe_db::query($sql);

			$result = $res->fetch_array(MYSQLI_ASSOC);

			return $result;
		}

		return array();
	}

	public static function save_target($data)
	{

		$fields = array('firstname', 'lastname', 'email', 'phone', 'position', 'country', 'notes', 'company', 'address', 'city', 'state', 'postal_code');
		$target_info_fields = array(
			'position ' => 'position', 'mobile_phone' => 'mobile phone', 'direct_line' => 'direct_line',
			'ext' => 'ext', 'linkedin' => 'linkedin_acct', 'facebook' => 'facebook_acct', 'twitter' => 'twitter_acct'
		);
		$td_data = array();
		$comp_info = array();
		$target_info = array();
		$comp_fields = array('company', 'address', 'city', 'state', 'postal_code', 'country_id', 'phone', 'company_email', 'website', 'fax', 'employee_size', 'annual_revenue');
		$comp_info_fields = array('email', 'website', 'fax', 'employee_size', 'annual_revenue');
		foreach ($data as $key => $val) {
			foreach ($fields as $field) {
				if ($key == $field) {
					if ($key == 'firstname') $field = 'first_name';
					if ($key == 'lastname') $field = 'last_name';
					if ($key == 'country') {
						$cid = self::getCountryId($val);
						$field = 'country_id';
						$val = $cid['country_id'];
					}
					$td_data[$field] = $val;
					if ($key == 'position') $target_info['position'] = $val;
				} else if ($key == 'jobtitle') {
					$td_data['position'] = $val;
					$target_info['position'] = $val;
				}
			}
			foreach ($comp_fields as $field) {

				$k = $field;

				if ($key == $k) {
					if (in_array($field, $comp_info_fields)) {

						$x = $field;

						if ($field == 'annual_revenue')
							$x = 'annualsaleid';
						if ($field == 'employee_size')
							$x = 'empsizeid';
						else
							$comp_info[$x]  =  $val;
					}
				}
			}
		}
		$db = new mysqli('192.168.50.45', 'app_pipe', 'a33-pipe', 'callbox_pipeline2');

		px_target::set_db($db);

		return px_target::save($td_data, 0, $comp_info, $target_info);
	}

	public static function getCountryId($code)
	{

		if ($code == 'United States')
			$code = 'USA';

		$sql = "SELECT 
					country_id 
				  FROM
				   countries 
				  WHERE
				   (country LIKE '{$code}' 
				  OR
				   country_code LIKE '" . strtoupper($code) . "')
				  AND x = 'active'";

		$res = pipe_db::query($sql);

		return $res->fetch_array(MYSQLI_ASSOC);
	}

	public function getEventState($client_list_id)
	{

		$sql = "SELECT
					cjo.report_state_lkp_ids
				  FROM
				   client_lists cl
				  INNER JOIN 
				   client_job_orders cjo USING(client_job_order_id)
				  WHERE
				   cl.x = 'active' AND cl.client_list_id = $client_list_id";

		$res = pipe_db::query($sql);

		$event_states = array();

		if (mysqli_num_rows($res) > 0) {
			while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
				$event_states = explode(",", $row['report_state_lkp_ids']);
			}
		}

		$event_states = implode(",", array_unique(array_merge(array(618, 617, 619), $event_states)));

		$sql = "SELECT
					event_state_lkp_id, event_state
				  FROM
				   event_states_lkp
				  WHERE
				   event_state_lkp_id IN ($event_states)
				  AND
				   x = 'active'";

		$res = pipe_db::query($sql);

		$response = array();

		if (mysqli_num_rows($res) > 0) {
			while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
				if (in_array($row['event_state_lkp_id'], array(617, 618, 619))) {
					array_unshift($response, array('id' => $row['event_state_lkp_id'], 'event_state' => $row['event_state']));
				} else {
					$response[] = array('id' => $row['event_state_lkp_id'], 'event_state' => $row['event_state']);
				}
			}
		}

		return $response;
	}

	public function checkUserPermission($team_id = 0, $user_id = 0)
	{
		// team nga maka access sa tanan nga mga persona - louie 3
		// $sql = "SELECT node AS team_name, hierarchy_tree_id, parent_id FROM hierarchy_tree WHERE node_type = 'team' AND module_id = 1 AND x= 'active' ORDER BY team_name ASC ";
		if ($user_id > 0) {
			$isProgrammer = "AND hd.hierarchy_tree_id = 88";
			if ($team_id != 88 && $team_id > 0) {
				$isProgrammer = "AND hd.hierarchy_tree_id IN (" . $team_id . ", 88)";
			} elseif ($team_id > 0) {
				$isProgrammer = "AND hd.hierarchy_tree_id  = " . $team_id;
			}

			$sql = "SELECT e.*, h.node AS team_name, h.hierarchy_tree_id, h.parent_id, CONCAT(e.first_name, ' ', e.last_name) AS fullname 
            FROM callbox_pipeline2.employees e 
            INNER JOIN callbox_pipeline2.hierarchy_tree_details hd on e.user_id = hd.user_id 
            INNER JOIN callbox_pipeline2.hierarchy_tree h on hd.hierarchy_tree_id = h.hierarchy_tree_id 
            WHERE e.user_id > 0 " . $isProgrammer . " AND hd.user_id = " . $user_id . " AND e.x='active' AND h.x= 'active' AND hd.`x` = 'active'";
		}

		$res = pipe_db::query($sql);

		$response = array();
		if (mysqli_num_rows($res) > 0) {

			return "yes";
		} else {
			return "no";
		}
	}

	public function getAllEmployees()
	{

		$sql = "SELECT
					user_id, CONCAT(first_name, ' ', last_name) AS full_name, cbemail
				  FROM
				   employees
				  WHERE
				   x = 'active'
				  ORDER BY
				   first_name ASC";

		$res = pipe_db::query($sql);

		$response = array();

		while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
			$response[] = array('id' => $row['user_id'], 'name' => $row['full_name'], 'username' => $row['cbemail']);
		}

		return $response;
	}

	public function getUsername($user_id)
	{

		$sql = "SELECT
					cbemail
				  FROM
				   employees
				  WHERE
				   x = 'active'
				  AND
				   user_id = $user_id	
				  ORDER BY
				   first_name ASC";

		$res = pipe_db::query($sql);

		return $res->fetch_array(MYSQLI_ASSOC);
	}

	public function getEmployeesWithTeam($search, $user_id = 0)
	{

		// $sql = "SELECT node AS team_name, hierarchy_tree_id, parent_id FROM hierarchy_tree WHERE node_type = 'team' AND module_id = 1 AND x= 'active' ORDER BY team_name ASC ";
		if ($user_id > 0) {
			$sql = "SELECT e.*, h.node AS team_name, h.hierarchy_tree_id, h.parent_id, CONCAT(e.first_name, ' ', e.last_name) AS fullname 
            FROM callbox_pipeline2.employees e 
            INNER JOIN callbox_pipeline2.hierarchy_tree_details hd on e.user_id = hd.user_id 
            INNER JOIN callbox_pipeline2.hierarchy_tree h on hd.hierarchy_tree_id = h.hierarchy_tree_id 
            WHERE e.user_id > 0 AND e.user_id = " . $user_id . " AND e.x='active' AND h.x= 'active' AND hd.`x` = 'active'";
		} else {
			$sql = 'SELECT e.*, h.node AS team_name, h.hierarchy_tree_id, h.parent_id, CONCAT(e.first_name, " ", e.last_name) AS fullname 
            FROM callbox_pipeline2.employees e 
            INNER JOIN callbox_pipeline2.hierarchy_tree_details hd on e.user_id = hd.user_id 
            INNER JOIN callbox_pipeline2.hierarchy_tree h on hd.hierarchy_tree_id = h.hierarchy_tree_id 
            WHERE (CONCAT(e.first_name, " ", e.last_name) LIKE "' . $search . '%" OR e.cbemail LIKE "' . $search . '%") AND e.x="active" AND h.x= "active" AND hd.`x` = "active"';
		}

		$res = pipe_db::query($sql);

		$response = array();
		if (mysqli_num_rows($res) > 0) {

			while ($row = $res->fetch_array(MYSQLI_ASSOC)) {

				$response[] = $row;
			}
			return $response;
		} else {
			return array();
		}
	}
	public function getEmployeeByUserId($user_id = 0)
	{

		// $sql = "SELECT node AS team_name, hierarchy_tree_id, parent_id FROM hierarchy_tree WHERE node_type = 'team' AND module_id = 1 AND x= 'active' ORDER BY team_name ASC ";
		if ($user_id > 0) {
			$sql = "SELECT * FROM callbox_pipeline2.employees WHERE user_id > 0 AND user_id = " . $user_id . " AND `x` = 'active'";
		}

		$res = pipe_db::query($sql);

		$response = array();
		if (mysqli_num_rows($res) > 0) {

			while ($row = $res->fetch_array(MYSQLI_ASSOC)) {

				$response[] = $row;
			}
			return $response;
		} else {
			return array();
		}
	}

	public function getUsers($user_ids)
	{

		$sql = "SELECT 
					GROUP_CONCAT(' ',CONCAT(first_name, ' ', last_name)) AS users
				  FROM
				   employees 
				  WHERE 
				   user_id IN ($user_ids) 
				  ORDER BY
				   first_name ASC";

		$res = pipe_db::query($sql);

		return $res->fetch_array(MYSQLI_ASSOC);
	}








};

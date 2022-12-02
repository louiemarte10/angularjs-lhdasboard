<?php 
    require "{$_SERVER['DOCUMENT_ROOT']}/config/pipeline-x.php";
 px_login::init();
 $config= array();
$config['title'] = "Social Media Report per SMM";
$config['api_name'] = 'SOCIAL MEDIA REPORT PER SMM';
  $config['auth'] = true;
$gui = new px_gui($config);
$gui->head();
$gui->topnav();
 
   $conn = new mysqli(config::get_server_by_name('main'), "app_pipe", "a33-pipe", "callbox_pipeline2");
    $conn_lh = new mysqli(config::get_server_by_name('smm_mktg'), "app_pipe", "a33-pipe", "linkedhelper");
$user_no = px_login::info("user_id");
$dateToday = date('M d, Y'); 
 ?>
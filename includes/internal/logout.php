<?php
ini_set('display_errors',0);

require("{$_SERVER['DOCUMENT_ROOT']}/config/pipeline-x.php");



$user_info = px_login::info();

// wetware7

$_SESSION = array();
$_SESSION["pipelinex_auth_lastuser"] = $user_info['user_name'];
setcookie("pipelinex_auth_name", "", time(), "/");
setcookie("pipelinex_auth_hash", "", time(), "/");

header("Location: {$_SERVER['PHP_SELF']}");

exit();

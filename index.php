<?php
ini_set('display_errors', 0);



include("{$_SERVER['DOCUMENT_ROOT']}/config/pipeline-x.php");


include("/var/www/html/internal/activeaccount/model/main.php");
px_login::init();

$user_info = px_login::info();
$roles = px_login::roles("ORG");
$roles_hr = px_login::roles("HRWIZ");
$roles = array_merge($roles, $roles_hr);
$_SESSION['user_info'] = $user_info;

// $allowed_roles = array(154, 170, 86, 121, 5, 13, 12, 31, 9, 39, 200, 202, 147);
$is_allowed = true; //array_intersect($roles, $allowed_roles) ? true : false;
// if ($user_info['user_id'] == 1252348) {
//     $is_allowed = true;
// }
// $is_allowed = true;
// if ($_SERVER['REMOTE_ADDR'] == '192.168.60.227'){
//     echo "<script>window.location.href = '/pipeline/linkedin-dashboard/messages';</script>";
// }
$url = "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s" : "") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$file_name = basename(parse_url($url, PHP_URL_PATH));
// echo $_SERVER['REQUEST_URI'];
$exploded_urlpath = explode("/", $_SERVER['REQUEST_URI']);
// echo "<pre>";
// print_r($user_info);
// echo "</pre>";


if ($file_name == 'index.php') {
    echo "<script>window.location.href = '/pipeline/linkedin-dashboard/';</script>";
}
//$user_id = px_login::info("user_id");
//$name = px_login::info("first_name")." ".px_login::info("last_name");
// $_SESSION = array();
//         $_SESSION["pipelinex_auth_lastuser"] = self::$auth_name;
//         setcookie("pipelinex_auth_name", "", time(), "/");
//         setcookie("pipelinex_auth_hash", "", time(), "/");
//         header("Location: {$_SERVER['PHP_SELF']}");
//         exit();

// echo "<pre>";
// print_r($user_info);
// echo "</pre>";



?>
<html ng-app="linkedIn">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Linkedhelper Dashboard</title>
    <base href="/pipeline/linkedin-dashboard/">

    <script src="assets/angularv1.8/font-awesome-jp.js"></script>
    <script>
        console.log(window.location.pathname);


        function logOff() {

            setTimeout(
                function() {
                    var url_string = window.location.href;
                    var url = new URL(url_string);
                    var logoff = url.searchParams.get("logoff");
                    console.log(location.search.split('?'));
                    if (location.search.split('?')[1] == "logoff") {
                        location.reload();
                    }
                },
                200);
        }
    </script>
    <link rel="stylesheet" href="assets/leaflet.css" />
    <link rel="stylesheet" href="assets/angular-material.1.0.8.min.css" />
    <!-- <link rel="stylesheet" href="assets/jquery-ui.1.13.1.css" /> -->



    <script src="assets/angularv1.8/angular.js"></script>
    <script src="assets/angularv1.8/angular-route.js"></script>
    <script src="assets/angularv1.8/angular-ui-router.min.js"></script>
    <script src="assets/angularv1.8/angular-sanitize.js"></script>
    <script src="assets/angularv1.8/angular-filter.js"></script>
    <script src="assets/angularv1.8/angular-filter.min.js"></script>
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <!-- <script src="assets/js/jquery-1.8.11.ui.min.js"></script> -->
    <script src="assets/angularv1.8/leaflet.js"></script>
    <script src="assets/js/angular-material.min.js"></script>
    <script src="assets/angularv1.8/angular-animate.min.js"></script>
    <script src="assets/angularv1.8/angular-aria.min.js"></script>
    <!-- <script src="assets/js/jquery-ui.1.13.1.js"></script> -->
    <script src="assets/js/app.js?v=2.6"></script>
    


    <script src="assets/js/sweetalert.js"></script>
    <!-- begin::Global Theme (used by all pages)-->
    <link rel="stylesheet" href="/framework/bootstrap5/v7/plugins/global/plugins.bundle.css" />
    <link rel="stylesheet" href="/framework/bootstrap5/v7/css/style.bundle.min.css" />
    <!-- end::Global Theme Styles-->

    <!-- begin::Global Layout (used by some instances)-->
    <link rel="stylesheet" href="/framework/bootstrap5/v7/css/themes/layout/header/base/light.css" />
    <link rel="stylesheet" href="/framework/bootstrap5/v7/css/themes/layout/header/menu/light.css" />
    <!-- end::Global Layout -->

    <!-- start::Callbox Default Themes-->
    <link href="/framework/bootstrap5/cb/css/default.css" rel="stylesheet" type="text/css" />
    <!-- end::Layout Themes-->

    <!-- <script type="application/javascript" ng-src="includes/home/controller.js"></script> -->

    <!-- <script src="assets/js/loadscript.js"></script> -->
    <!-- <script src="assets/js/angular.1.6.5.js"></script> -->
    <!-- <script src="assets/js/angular-resource.1.8.2.js"></script> -->
    <!-- <script src="includes/home/controller.js" defer></script> -->
    <!-- <script src="assets/js/index.js"></script> -->

    <style>
        .modal-dialog.modal-xl {
            min-width: 75% !important;
        }

        /* table tbody tr:nth-child(odd) td {
            background-color: white !important;
            color: black !important;
        }

        table tbody tr:nth-child(even) td {
            background-color: gray !important;
            color: white !important;
        } */



        /* .table tbody tr:nth-child(odd) td {

            background-color: #dadde3 !important;
            color: black !important;
        }

        .table tbody tr:nth-child(even) td {
            background-color: white !important;
            color: black !important;
        } */

        .table tbody tr:hover td {
            background-color: #4183c4 !important;
            color: white !important;
        }

        /* .table tbody tr td{
            border: 1px solid black !important;
        }
        .table thead th{
            border: 1px solid black !important;
        } */
    </style>

</head>
<!-- class="disabled" -->


<body class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed page-loading">
    <?php
    // if ($file_name == 'linkedin-dashboard') {
    //     echo '<script src="includes/home/controller.js"></script>';
    // } elseif ($file_name == 'test') {
    //     echo '<script src="includes/home/controller.js"></script>';
    // }
    // echo "<Br><br><Br><br><Br><br><pre>";
    // print_r($exploded_urlpath);
    // echo "</pre>";

    // Array
    // (
    //     [0] => 
    //     [1] => pipeline
    //     [2] => linkedin-dashboard
    //     [3] => 
    // )
    // echo strlen($exploded_urlpath[3]);
    // echo $exploded_urlpath[3];
    if (strlen($exploded_urlpath[3]) > 0) {
        // if(isset($exploded_urlpat[3]) && ){
        if ($exploded_urlpath[3] == "contacts") {
            echo '<script src="includes/contacts/controller.js?v=2.6" defer></script>';
        } elseif ($exploded_urlpath[3] == "messages") {
            echo '<script src="includes/messages/controller.js?v=1.1" defer></script>';
        }
        elseif ($exploded_urlpath[3] == "page") {
            echo '<script src="includes/home/controller.js?v=1.2" defer></script>';
        }
    } else {
        echo '<script src="includes/home/controller.js?v=1.2" defer></script>';
    }

    ?>


    <?php
    if (!$is_allowed) {
        echo '<div id="not_allowed" style="font-size:20px"><div>You are not allowed here!</div></div></div></body></html>';
        echo '<a  href="?logoff" onclick="logOff()" style="font-size:20px">Back</a> ';
        exit();
    } else {
    ?>
        <input type="hidden" id="logged_userId" value="<?= $user_info['user_id'] ?>">
        <div data-ng-view="">


        </div>
    <?php
    }
    // include("includes/header.php");

    ?>



    <!-- <ui-view ng-cloak>
        <i>Loading ....</i>
    </ui-view> -->

    <!-- <div ng-view></div> -->



    <script>
        var HOST_URL = "/tools/bootstrap5-documentation/";
    </script>
    <!--begin::Global Config(global config for global JS scripts)-->
    <script>
        var KTAppSettings = {
            "breakpoints": {
                "sm": 576,
                "md": 768,
                "lg": 992,
                "xl": 1200,
                "xxl": 1400
            },
            "colors": {
                "theme": {
                    "base": {
                        "white": "#ffffff",
                        "primary": "#3699FF",
                        "secondary": "#E5EAEE",
                        "success": "#1BC5BD",
                        "info": "#8950FC",
                        "warning": "#FFA800",
                        "danger": "#F64E60",
                        "light": "#E4E6EF",
                        "dark": "#181C32"
                    },
                    "light": {
                        "white": "#ffffff",
                        "primary": "#E1F0FF",
                        "secondary": "#EBEDF3",
                        "success": "#C9F7F5",
                        "info": "#EEE5FF",
                        "warning": "#FFF4DE",
                        "danger": "#FFE2E5",
                        "light": "#F3F6F9",
                        "dark": "#D6D6E0"
                    },
                    "inverse": {
                        "white": "#ffffff",
                        "primary": "#ffffff",
                        "secondary": "#3F4254",
                        "success": "#ffffff",
                        "info": "#ffffff",
                        "warning": "#ffffff",
                        "danger": "#ffffff",
                        "light": "#464E5F",
                        "dark": "#ffffff"
                    }
                },
                "gray": {
                    "gray-100": "#F3F6F9",
                    "gray-200": "#EBEDF3",
                    "gray-300": "#E4E6EF",
                    "gray-400": "#D1D3E0",
                    "gray-500": "#B5B5C3",
                    "gray-600": "#7E8299",
                    "gray-700": "#5E6278",
                    "gray-800": "#3F4254",
                    "gray-900": "#181C32"
                }
            },
            "font-family": "Poppins"
        };
    </script>


    <!--end::Global Config-->
    <script src="/framework/bootstrap5/v7/plugins/global/plugins.bundle.js"></script>
    <script src="/framework/bootstrap5/v7/js/scripts.bundle.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#f').on('submit', function(e) {
                // validation code here

                e.preventDefault();

            });
        });
    </script>
</body>

</html>
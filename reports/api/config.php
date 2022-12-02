<?php
    require "{$_SERVER['DOCUMENT_ROOT']}/config/pipeline-x.php";
    px_login::init();
   config::connect_db(db::$db, "pipe", "callbox_pipeline2");
    px_h3_v3::init();
 

    $user_id = px_login::get_info('user_id'); 
    if($user_id == 4069):
    $node = px_h3_v3::get_user_node(4004);
    else:
    $node = px_h3_v3::get_user_node($user_id);
    endif;
    $my_team  = px_h3_v3::get_users($node);
    $roles2 = px_login::roles("ORG");
    $managers = array(1,7,23,86,114,137,107);
    $leaders = array(8,9,35,37,39,46,57,67,77,85,141); 
    $softdev = array(31); 
    //lib::debug($node);
    $dept = $node['hierarchy_tree_id'];
    $dept_name = $node['node'];

    //$conn = new mysqli("192.168.50.72", "ojt", "ojt", "callbox_pipeline2");
    $conn = new mysqli(config::get_server_by_name('main'), "app_pipe", "a33-pipe", "callbox_pipeline2");
    
    //$node = px_h3_v3::get_user_node($user_id);
    //$full_tree = px_h3_v3::get_full_tree();
    //$child_nodes = $full_tree[$node['hierarchy_tree_id']]['children'];
    //lib::debug($full_tree[$node['hierarchy_tree_id']]);

class info{

    public static $user_id = 0;

    public static $fullname = "";

    public static $first_name = "";

    public static $admin = 0;

    public static $super_user = 0;

    public static $ln_admin = 0;    

    public static $ems = 0;

    public static $ems_coords = 0;

    public static $parent = "";

    public static $dept = "";

    public static $downlines = array();

    public static $roles = array();
    
    public static $isCampaignManager = 0;

    public function init(){

        self::$user_id = px_login::info('user_id');

        self::$fullname = px_login::info('fullname');

        self::$first_name = px_login::info('first_name');

        self::$roles = px_login::roles('ORG');

        $h = px_login::hierarchy_tree_details('ORG');

        self::$dept = $h[0]['hierarchy_tree_id'];

        $user_node = px_h3_v3::get_user_node(px_login::info('user_id'));

        self::$downlines = px_h3_v3::get_users($user_node);

        $xd = px_h3_v3::get_department(self::$dept);

        if($xd['node_type'] == "dept") self::$parent = $xd['hierarchy_tree_id'];

        else self::$parent = $xd['parent_id'];

        
        // lib::debug($xd);

        if(substr_count(strtoupper($xd['node']), "CLUSTER"))
            self::$parent = $xd['hierarchy_tree_id'];
        else
            self::$parent = $xd['parent_id'];
        if(self::$user_id == 1235733) self::$parent = 43; //charmainee-os 
        if(in_array(self::$dept, array(4, 5, 6, 88, 89, 144, 226, 105, 106, 144))) self::$admin = 1;

        elseif(in_array(159, self::$roles)) self::$ems_coords = 1;
        
        elseif(in_array(147, self::$roles)) self::$ems = 1;
        
        if(in_array(170, self::$roles)) self::$isCampaignManager = 1;

        if(in_array(self::$user_id, array(1241434, 57, 152, 1238065, 4069, 8210,50739,4060)) || self::$parent == 5 || self::$parent == 4 || self::$parent == 144 || self::$dept == 144 || in_array(31,self::$roles)) self::$super_user = 1;
        //08-06-21 added emerald 4060
        
        if(in_array(156, self::$roles)) self::$ln_admin = 1;

    }
}



 


?>


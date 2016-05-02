<?php
function install_table(){
global $wpdb;

$table_name = $wpdb->prefix ."sugarcrm_settings";
$sql = "CREATE TABLE `".$table_name."` (
		  `id` int(11) NOT NULL,
		  `url` varchar(500) default NULL,
		  `username` varchar(255) default NULL,
		  `password` varchar(255) default NULL,
		  PRIMARY KEY  (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
$wpdb->query($sql);
$insertData = "INSERT INTO `".$table_name."`(id,url,username,password) VALUES ()";
}
function insertData(){
	global $wpdb;
    $table_name = $wpdb->prefix ."sugarcrm_settings";
	
    $url = "http://youdomain.com/crm";
    $username = "admin";
    $password = "123";
	
    $rows_affected = $wpdb->insert( $table_name, array( 'id' => 1, 'url' => $url, 'username' => $username, 'password' => md5($password) ) );	
}
function uninstall_table(){
	
    global $wpdb;
    $table_name = $wpdb->prefix ."sugarcrm_settings";
    $sql = "DROP TABLE IF EXISTS `".$table_name."`; " ;
    $wpdb->query($sql);
	
}
/**
* This function returns stored sugarcrm settings from database
* param - Void
* Return - Array
**/

function getSugarConfig(){
    global $wpdb;
    $table_name = $wpdb->prefix . "sugarcrm_settings";
    $crm_option = $wpdb->get_row("SELECT `url`,`username`,`password` FROM ".$table_name." WHERE id = 1", ARRAY_A);	
	$sugar_array = array();
	$sugar_array[] = $crm_option['url'];
	$sugar_array[] = $crm_option['username'];
	$sugar_array[] = $crm_option['password'];
	return $sugar_array;
}
/**
* Get Contact details from SugarCRM
* Param - String
* Return - Array
**/
function get_sugar_contact_details($user_email){
	//Get Stored sugar login details from database
	$sugar_config = getSugarConfig();
	//Create URL
	$url = $sugar_config[0].'/service/wordpress-sugar/rest.php';
	// Open a curl session for making the call
	$curl = curl_init($url);
	// Tell curl to use HTTP POST
	curl_setopt($curl, CURLOPT_POST, true);
	// Tell curl not to return headers, but do return the response
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	/***************************************************************
	*  Connect to SugarCRM
	*/
	// Set the POST arguments to pass to the Sugar server
	$parameters = array(
	'user_auth' => array(
		'user_name' => $sugar_config[1],
		'password'  => md5($sugar_config[2]),
	),
	);
	$json = json_encode($parameters);
	$postArgs = array(
		'method' => 'login',
		'input_type' => 'JSON',
		'response_type' => 'JSON',
		'rest_data' => $json,
	);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postArgs);
	
	// Make the REST call, returning the result
	$response = curl_exec($curl);
	
	//Display User Information based on the Call like Id, Name, Language
	//first Convert the result from JSON format to a PHP array
	$result = json_decode($response);
	// build the shared parameters
	$session_id = $result->id;
	$user_id = $result->name_value_list->user_id->value;
	//Get User email from function param
	$email_id = $user_email;
	$session_parameters = array(
		'session' => array(
		'session_id' => $session_id,
		'user_id' => $user_id,
		'email' => $email_id,
	),
	);
	$session_parameters = json_encode($session_parameters);
	
	
	/***************************************************************
	*  Get the Contact Details
	*/
	$postArgs2 = array(
		'method' => 'getContactDetails',
		'input_type' => 'JSON',
		'response_type' => 'JSON',
		'rest_data' => $session_parameters
	);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postArgs2);
	
	// Make the REST call, returning the result
	$response2 = curl_exec($curl);
	
	$result2 = json_decode($response2);
	$contact_details = $result2;
	
	return $contact_details;
}


function saveConfig($sugar){
	require_once('../wp-admin/admin.php');
	global $wpdb;
	$crm_url = $sugar[0];
	
	$last = $crm_url[strlen($crm_url)-1]; 

	if($last=="/")
	$crm_url = substr($crm_url,0,-1);

	$crm_user = $sugar[1];
	$crm_pwd = md5($sugar[2]);

	$data =array('url'=>$crm_url, 'username'=>$crm_user, 'password'=>$crm_pwd);
	$where = array('id'=>1);
	$table_name = $wpdb->prefix . "sugarcrm_settings";

	$wpdb->update($table_name, $data, $where, $format = null, $where_format = null );
	
	return true;
}
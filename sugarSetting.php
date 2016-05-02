<head>
	<link rel="stylesheet" href="../wp-content/plugins/SugarConnect/style.css" type="text/css">
</head>
<div class="wrap">
<?php    echo "<h2>" . __( 'SugarCRM Configuration Settings', 'crmcon_trdom' ) . "</h2>"; ?>
<?php
if($_POST['crm-settings-save']){
	echo '<strong>Options saved</strong></p></div>';
	require_once('sugarConnectUtils.php');
	$sugar[] = $_POST['crm_url'];
	$sugar[] = $_POST['crm_user'];
	$sugar[] = $_POST['crm_pwd'];
	saveConfig($sugar);
}
global $wpdb;
$table_name = $wpdb->prefix . "sugarcrm_settings";
$crm_option = $wpdb->get_row("SELECT * FROM ".$table_name." WHERE id = 1", ARRAY_A);
?>
<div class="crm-settings-panel">
  <h3>SugarCRM Settings</h3>
  <div class="crmform">
    <div class="metabox-prefs">
      <form action="" method="post">
        <label for="crm_url">URL : </label>
        <input type="text" name="crm_url" id="crm_url" value="<?php echo wp_specialchars(stripslashes($crm_option['url']), 1) ?>" size="20" />
        <br>
        <label for="crm_user">Username : </label>
        <input type="text" name="crm_user" id="crm_user" value="<?php echo wp_specialchars(stripslashes($crm_option['username']), 1) ?>" size="20" />
        <br>
        <label for="crm_pwd">Password : </label>
        <input type="password" name="crm_pwd" id="crm_pwd" size="20" />
        <br>
        <div id="crm_config_error" class="error"></div>
        <input type="submit" name="crm-settings-save" id="crm-settings-save" value="Save" class="button" />
        <input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
      </form>
    </div>
  </div>
</div>
<hr/>
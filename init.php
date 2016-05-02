<?php
require_once(dirname(__FILE__) . '/sugarConnectUtils.php');
require_once('SugarConnect.php');


add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );

function extra_user_profile_fields(){
    global $current_user;
    $current_user = wp_get_current_user();
	$user = get_sugar_contact_details($current_user->user_email);
	
?>
<!-- Start Sugar Modification -->
<table class="form-table">
<h3><?php _e('SugarCRM Info') ?></h3>
<tr id="sugarFields1">
	<th><label for="sugar_fname"><?php _e('First Name :'); ?></label></th>
    <td><input type="text" name="sugar_fname" id="sugar_fname" value="<?php echo $user->first_name; ?>" class="regular-text code" /></td>
    <th><label for="sugar2"><?php _e('Last Name :'); ?></label></th>
    <td><input type="text" name="sugar_lname" id="sugar_lname" value="<?php echo $user->last_name; ?>" class="regular-text code" /></td>
</tr>
<tr id="sugarFields2">
	<th><label for="sugar_mobile"><?php _e('Mobile No :'); ?></label></th>
    <td><input type="text" name="sugar_mobile" id="sugar_mobile" value="<?php echo $user->phone_mobile; ?>" class="regular-text code" /></td>
    <th><label for="sugar_email"><?php _e('Office Phone :'); ?></label></th>
    <td><input type="text" name="sugar_email" id="sugar_email" value="<?php echo $user->phone_work; ?>" class="regular-text code" /></td>
</tr>
<tr id="sugarFields3">
	<th><label for="sugar_mobile"><?php _e('Fax :'); ?></label></th>
    <td><input type="text" name="sugar_mobile" id="sugar_mobile" value="<?php echo $user->phone_fax; ?>" class="regular-text code" /></td>
    <th><label for="sugar_email"><?php _e('Department :'); ?></label></th>
    <td><input type="text" name="sugar_email" id="sugar_email" value="<?php echo $user->department; ?>" class="regular-text code" /></td>
</tr>
<tr id="sugarFields3">
	<th><label for="sugar_mobile"><?php _e('Address :'); ?></label></th>
    <td><input type="text" name="sugar_mobile" id="sugar_mobile" value="<?php echo $user->primary_address_street; ?>" class="regular-text code" /></td>
    <th><label for="sugar_email"><?php _e('City :'); ?></label></th>
    <td><input type="text" name="sugar_email" id="sugar_email" value="<?php echo $user->primary_address_city; ?>" class="regular-text code" /></td>
</tr>
<tr id="sugarFields3">
	<th><label for="sugar_mobile"><?php _e('State :'); ?></label></th>
    <td><input type="text" name="sugar_mobile" id="sugar_mobile" value="<?php echo $user->primary_address_state; ?>" class="regular-text code" /></td>
    <th><label for="sugar_email"><?php _e('Postal Code :'); ?></label></th>
    <td><input type="text" name="sugar_email" id="sugar_email" value="<?php echo $user->primary_address_postalcode; ?>" class="regular-text code" /></td>
</tr>
<tr id="sugarFields3">
	<th><label for="sugar_mobile"><?php _e('Country :'); ?></label></th>
    <td><input type="text" name="sugar_mobile" id="sugar_mobile" value="<?php echo $user->primary_address_country; ?>" class="regular-text code" /></td>
</tr>
</table>
<!-- End Sugar Modification -->
<?php	
}
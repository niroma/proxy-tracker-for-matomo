<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.niroma.net
 * @since      1.0.0
 *
 * @author    Niroma
 */


	if( current_user_can( 'manage_options' ) ) {
?>
<div class="wrap">
    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
	<form name="matomo_tracker_settings" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
		<table class="form-table">	
			<tr valign="top">
				<th scope="row">
					<label for="<?php echo $this->plugin_name; ?>-url">
						<span><?php esc_attr_e('Matomo Installation Url', $this->plugin_name); ?></span>
					</label>
				</th>
				<td>								
					<input type="url" id="<?php echo $this->plugin_name; ?>-url" name="<?php echo $this->plugin_name; ?>-url" class="regular-text" value ="<?php echo stripslashes( get_option( $this->plugin_name.'-url' ) ); ?>" />
				</td>
			</tr>			
			<tr valign="top">
				<th scope="row">
					<label for="<?php echo $this->plugin_name; ?>-tracking-id">
						<span><?php esc_attr_e('Matomo Tracking Id', $this->plugin_name); ?></span>
					</label>
				</th>
				<td>								
					<input type="number" id="<?php echo $this->plugin_name; ?>-tracking-id" name="<?php echo $this->plugin_name; ?>-tracking-id" value ="<?php echo get_option( $this->plugin_name.'-tracking-id' ); ?>" class="regular-text" />
				</td>
			</tr>	
			<tr valign="top">
				<th scope="row">
				</th>
				<td>
					<input type="hidden" name="action" value="matomo_tracker_form_response">
					<?php wp_nonce_field( $this->plugin_name.'submit-matomo-form' ); ?>
					<input class="button button-primary" type="submit" id="<?php echo $this->plugin_name; ?>-submit" name="<?php echo $this->plugin_name; ?>-submit" value="<?php esc_attr_e('Save Settings', $this->plugin_name); ?>"/>
				</td>
			</tr>
		</table>
    </form>
</div>
<?php } else { ?>
	<p><?php __("You are not authorized to perform this operation.", $this->plugin_name); ?></p>
<?php  } ?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->

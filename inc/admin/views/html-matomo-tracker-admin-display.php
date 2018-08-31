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
						<span><?php esc_attr_e('Matomo Installation Url', $this->plugin_text_domain); ?></span>
					</label>
				</th>
				<td>								
					<input type="url" id="<?php echo $this->plugin_name; ?>-url" name="<?php echo $this->plugin_name; ?>-url" class="regular-text" value ="<?php echo stripslashes( get_option( $this->plugin_name.'-url' ) ); ?>" />
					<p  id="<?php echo $this->plugin_name; ?>-url-description" class="description">Ex. : http://mytrackingdomain.com</p>	
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="<?php echo $this->plugin_name; ?>-token">
						<span><?php esc_attr_e('Matomo Auth Token', $this->plugin_name); ?></span>
					</label>
				</th>
				<td>								
					<input type="text" id="<?php echo $this->plugin_name; ?>-token" name="<?php echo $this->plugin_name; ?>-token" value ="<?php echo get_option( $this->plugin_name.'-token' ); ?>" class="regular-text" />
					<p  id="<?php echo $this->plugin_name; ?>-token-description" class="description">Ex. : a8454100y45g22r8134sf99b1a87147f - Need help finding your token ? <a href="https://matomo.org/faq/general/faq_114/">Read Matomo FAQ</a></p>	
				</td>
			</tr>	
			<tr valign="top">
				<th scope="row">
					<label for="<?php echo $this->plugin_name; ?>-tracking-id">
						<span><?php esc_attr_e('Matomo Tracking Id', $this->plugin_text_domain); ?></span>
					</label>
				</th>
				<td>								
					<input type="number" id="<?php echo $this->plugin_name; ?>-tracking-id" name="<?php echo $this->plugin_name; ?>-tracking-id" value ="<?php echo get_option( $this->plugin_name.'-tracking-id' ); ?>" class="regular-text" />
					<p  id="<?php echo $this->plugin_name; ?>-tracking-id-description" class="description">Ex. : 46</p>	
				</td>
			</tr>	
			<tr valign="top">
				<th scope="row">
					<label for="<?php echo $this->plugin_name; ?>-tracking-mode">
						<span><?php esc_attr_e('Tracking Mode', $this->plugin_text_domain); ?></span>
					</label>
				</th>
				<td>								
                	<select id="<?php echo $this->plugin_name; ?>-tracking-mode" name="<?php echo $this->plugin_name; ?>-tracking-mode">
						<option value="js"<?php if (( get_option( $this->plugin_name.'-tracking-mode' ) == 'js')  || empty(get_option( $this->plugin_name.'-tracking-mode' )) ) echo ' selected';  ?>>Javascript</option>
						<option value="php"<?php if ( get_option( $this->plugin_name.'-tracking-mode' ) == 'php') echo ' selected';  ?>>PHP</option>
					</select>
					<p  id="<?php echo $this->plugin_name; ?>-tracking-id-description" class="description">
                    	<b>Javascript</b> : <?php esc_attr_e('More accurate details, Loads an additional js script in footer', $this->plugin_text_domain); ?> <br />
                    	<b>PHP</b> : <?php esc_attr_e('Works for all pages (php hook in head), totally invisible but less accurate', $this->plugin_text_domain); ?> 
                    </p>	
				</td>
			</tr>	
			<tr id="matomoJsMode" valign="top">
				<th scope="row">
					<label for="<?php echo $this->plugin_name; ?>-javascript-mode">
						<span><?php esc_attr_e('Javascript Loading Mode', $this->plugin_text_domain); ?></span>
					</label>
				</th>
				<td>								
                	<select id="<?php echo $this->plugin_name; ?>-javascript-mode" name="<?php echo $this->plugin_name; ?>-javascript-mode">
						<option value="defer"<?php if (( get_option( $this->plugin_name.'-javascript-mode' ) == 'defer')  || empty(get_option( $this->plugin_name.'-javascript-mode' )) ) echo ' selected';  ?>>defer</option>
						<option value="async"<?php if ( get_option( $this->plugin_name.'-javascript-mode' ) == 'async') echo ' selected';  ?>>async</option>
						<option value="none"<?php if ( get_option( $this->plugin_name.'-javascript-mode' ) == 'none') echo ' selected';  ?>>none</option>
					</select>
				</td>
			</tr>	
			<tr id="matomoJsDisallowRobot" valign="top">
				<th scope="row">
					<label for="<?php echo $this->plugin_name; ?>-javascript-disallow-robot">
						<span><?php esc_attr_e('Disallow JS File in robot.txt', $this->plugin_text_domain); ?></span>
					</label>
				</th>
				<td>								
                	<select id="<?php echo $this->plugin_name; ?>-javascript-disallow-robot" name="<?php echo $this->plugin_name; ?>-javascript-disallow-robot">
						<option value="y"<?php if (( get_option( $this->plugin_name.'-javascript-disallow-robot' ) == 'y')  || empty(get_option( $this->plugin_name.'-javascript-disallow-robot' )) ) echo ' selected';  ?>>Yes</option>
						<option value="n"<?php if ( get_option( $this->plugin_name.'-javascript-disallow-robot' ) == 'n') echo ' selected';  ?>>No</option>
					</select>
					<p  id="<?php echo $this->plugin_name; ?>-javascript-disallow-robot-description" class="description">
                    	<?php esc_attr_e('If activated this option will disallow js file in robot.txt', $this->plugin_text_domain); ?>
                    </p>	
				</td>
			</tr>	
			<tr valign="top">
				<th scope="row">
				</th>
				<td>
					<input type="hidden" name="action" value="matomo_tracker_form_response">
					<?php wp_nonce_field( $this->plugin_name.'submit-matomo-form' ); ?>
					<input class="button button-primary" type="submit" id="<?php echo $this->plugin_name; ?>-submit" name="<?php echo $this->plugin_name; ?>-submit" value="<?php esc_attr_e('Save Settings', $this->plugin_text_domain); ?>"/>
				</td>
			</tr>
		</table>
    </form>
</div>
<?php } else { ?>
	<p><?php __("You are not authorized to perform this operation.", $this->plugin_text_domain); ?></p>
<?php  } ?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->

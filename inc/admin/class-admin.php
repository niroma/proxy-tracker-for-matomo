<?php

namespace Mytomo_Tracker\Inc\Admin;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @link       https://www.niroma.net
 * @since      1.0.0
 *
 * @author    Niroma
 */
class Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The text domain of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_text_domain    The text domain of this plugin.
	 */
	private $plugin_text_domain;
	
	private $plugin_name_dir;
	private $plugin_name_url;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since       1.0.0
	 * @param       string $plugin_name        The name of this plugin.
	 * @param       string $version            The version of this plugin.
	 * @param       string $plugin_text_domain The text domain of this plugin.
	 */
	public function __construct( $plugin_name, $version, $plugin_text_domain, $plugin_name_dir, $plugin_name_url ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->plugin_text_domain = $plugin_text_domain;
		
		$this->plugin_name_dir = $plugin_name_dir;
		$this->plugin_name_url = $plugin_name_url;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
/*	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
/*
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mytomo-tracker-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		/*
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mytomo-tracker-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function display_plugin_setup_page() {
		include_once( 'views/html-mytomo-tracker-admin-display.php' );
	}
	
	public function add_plugin_admin_menu() {

    /*
     * Add a settings page for this plugin to the Settings menu.
     *
     * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
     *
     *        Administration Menus: http://codex.wordpress.org/Administration_Menus
     *
     */
		add_submenu_page( 'options-general.php', 'Mytomo Tracker', 'Mytomo Tracker', 'manage_categories', $this->plugin_name, array($this, 'display_plugin_setup_page') );
	}
	
	
	public function check_for_event_submissions(){
			if ( isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], $this->plugin_name.'submit-mytomo-form') ){
				$admin_notice = '';
				$messageLog = '';
				$mytomoUrl = $_POST[$this->plugin_name.'-url'] ?  sanitize_text_field($_POST[$this->plugin_name.'-url']) : '';
				$mytomoToken = $_POST[$this->plugin_name.'-token'] ?  sanitize_text_field($_POST[$this->plugin_name.'-token']) : '';
				$mytomoId = $_POST[$this->plugin_name.'-tracking-id'] ? (int) $_POST[$this->plugin_name.'-tracking-id'] : '';
				$mytomoMode = $_POST[$this->plugin_name.'-tracking-mode'] ? $_POST[$this->plugin_name.'-tracking-mode'] : '';
				/*$mytomoJsMode = $_POST[$this->plugin_name.'-javascript-mode'] ? $_POST[$this->plugin_name.'-javascript-mode'] : 'defer';*/
				$mytomoDisallowRobot = $_POST[$this->plugin_name.'-javascript-disallow-robot'] ? $_POST[$this->plugin_name.'-javascript-disallow-robot'] : 'y';
				$mytomoUsers = $_POST[$this->plugin_name.'-users-auth'] ? $_POST[$this->plugin_name.'-users-auth'] : 'all';
				
				if (empty($mytomoUrl)) {
					$admin_notice = "error";
					$messageLog .= 'url is empty ';
				
				}
				if (empty($mytomoToken)) {
					$admin_notice = "error";
					$messageLog .= 'token is empty ';
				
				}
				if (empty($mytomoId)) {
					$admin_notice = "error";
					$messageLog .= 'id is empty ';
				}
				if (empty($mytomoMode)) {
					$admin_notice = "error";
					$messageLog .= 'mode is empty ';
				}
				if (empty($admin_notice)) {
					if ( get_option( $this->plugin_name.'-url' ) !== false ) {
						update_option( $this->plugin_name.'-url', $mytomoUrl );
					} else {
						add_option( $this->plugin_name.'-url', $mytomoUrl);
					}
					if ( get_option( $this->plugin_name.'-token' ) !== false ) {
						update_option( $this->plugin_name.'-token', $mytomoToken );
					} else {
						add_option( $this->plugin_name.'-token', $mytomoToken);
					}
					if ( get_option( $this->plugin_name.'-tracking-id' ) !== false ) {
						update_option( $this->plugin_name.'-tracking-id', $mytomoId );
					} else {
						add_option( $this->plugin_name.'-tracking-id', $mytomoId);
					}	
					if ( get_option( $this->plugin_name.'-tracking-mode' ) !== false ) {
						update_option( $this->plugin_name.'-tracking-mode', $mytomoMode );
					} else {
						add_option( $this->plugin_name.'-tracking-mode', $mytomoMode);
					}	
					/*
					if ( get_option( $this->plugin_name.'-javascript-mode' ) !== false ) {
						update_option( $this->plugin_name.'-javascript-mode', $mytomoJsMode );
					} else {
						add_option( $this->plugin_name.'-javascript-mode', $mytomoJsMode);
					}		
					*/
					if ( get_option( $this->plugin_name.'-javascript-disallow-robot' ) !== false ) {
						update_option( $this->plugin_name.'-javascript-disallow-robot', $mytomoDisallowRobot );
					} else {
						add_option( $this->plugin_name.'-javascript-disallow-robot', $mytomoDisallowRobot);
					}		
					if ( get_option( $this->plugin_name.'-users-auth' ) !== false ) {
						update_option( $this->plugin_name.'-users-auth', $mytomoUsers );
					} else {
						add_option( $this->plugin_name.'-users-auth', $mytomoUsers);
					}	
					$admin_notice = "success";
					$messageLog .= 'Settings saved';
				}
				/*$this->update_tracker_settings();*/
				$this->custom_redirect( $admin_notice, $messageLog);
				die();
			}  else {
				wp_die( __( 'Invalid nonce specified', $this->plugin_name ), __( 'Error', $this->plugin_name ), array(
						'response' 	=> 403,
						'back_link' => 'options-general.php?page=' . $this->plugin_name,
				) );
			}
	}
	/*
	private function check_for_update() {
		$our_plugin = plugin_basename( __FILE__ );
		// If an update has taken place and the updated type is plugins and the plugins element exists
		if( $options['action'] == 'update' && $options['type'] == 'plugin' && isset( $options['plugins'] ) ) {
			// Iterate through the plugins being updated and check if ours is there
			foreach( $options['plugins'] as $plugin ) {
				if( $plugin == $our_plugin ) {
					$this->update_tracker_settings();
				}
			}
		}
		
	}
	
	private function update_tracker_settings() {
		if ( get_option( $this->plugin_name.'-tracking-mode' ) != 'php' && !empty(get_option( $this->plugin_name.'-url' )) && !empty(get_option( $this->plugin_name.'-tracking-id' )) && !empty(get_option( $this->plugin_name.'-token' )) ) {
						$piwikId = get_option( $this->plugin_name.'-tracking-id' );
						$piwikFileDir = $this->plugin_name_url . 'inc/frontend/';
						$piwikJsFile = $this->plugin_name_dir . 'inc/frontend/track.js';
						$js = 'var _paq = _paq || []; _paq.push(["trackPageView"]); _paq.push(["enableLinkTracking"]); (function() { var u="'. $piwikFileDir .'piwik.php"; _paq.push(["setTrackerUrl", u]); _paq.push(["setSiteId", "'. $piwikId .'"]);  var d=document, g=d.createElement("script"), s=d.getElementsByTagName("script")[0]; g.type="text/javascript"; g.async=true; g.defer=true; g.src=u; s.parentNode.insertBefore(g,s); })();';
						file_put_contents($piwikJsFile, $js);
		}
	}
	*/
	public function custom_redirect( $admin_notice, $response ) {
		wp_redirect( esc_url_raw( add_query_arg( array(
									'mytomo_tracker_admin_add_notice' => $admin_notice,
									'mytomo_tracker_response' => $response,
									),
							admin_url('options-general.php?page='. $this->plugin_name ) 
					) ) );

	}

	public function print_plugin_admin_notices() {              
		  if ( isset( $_REQUEST['mytomo_tracker_admin_add_notice'] ) ) {
			if( $_REQUEST['mytomo_tracker_admin_add_notice'] === "success") {
				$html =	'<div class="notice notice-success is-dismissible"> 
							<p><strong>' . htmlspecialchars( print_r( $_REQUEST['mytomo_tracker_response'], true) ) . '</strong></p></div>';
				echo $html;
			}
			if( $_REQUEST['mytomo_tracker_admin_add_notice'] === "error") {
				$html =	'<div class="notice notice-error is-dismissible"> 
							<p><strong>' . htmlspecialchars( print_r( $_REQUEST['mytomo_tracker_response'], true) ) . '</strong></p></div>';
				echo $html;
			}
		  } else {
			  return;
		  }

	}

}

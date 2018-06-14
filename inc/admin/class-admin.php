<?php

namespace Matomo_Tracker\Inc\Admin;

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

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since       1.0.0
	 * @param       string $plugin_name        The name of this plugin.
	 * @param       string $version            The version of this plugin.
	 * @param       string $plugin_text_domain The text domain of this plugin.
	 */
	public function __construct( $plugin_name, $version, $plugin_text_domain ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->plugin_text_domain = $plugin_text_domain;

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
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/matomo-tracker-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
/*	public function enqueue_scripts() {
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
/*
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/matomo-tracker-admin.js', array( 'jquery' ), $this->version, false );

	}
	*/
	public function display_plugin_setup_page() {
		include_once( 'views/html-matomo-tracker-admin-display.php' );
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
		add_submenu_page( 'options-general.php', 'Matomo Tracker', 'Matomo Tracker', 'manage_categories', $this->plugin_name, array($this, 'display_plugin_setup_page') );
	}
	
	
	public function check_for_event_submissions(){
			if ( isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], $this->plugin_name.'submit-matomo-form') ){
				$admin_notice = '';
				$messageLog = '';
				$matomoUrl = $_POST[$this->plugin_name.'-url'] ?  sanitize_text_field($_POST[$this->plugin_name.'-url']) : '';
				$matomoToken = $_POST[$this->plugin_name.'-token'] ?  sanitize_text_field($_POST[$this->plugin_name.'-token']) : '';
				$matomoId = $_POST[$this->plugin_name.'-tracking-id'] ? (int) $_POST[$this->plugin_name.'-tracking-id'] : '';
				$matomoMode = $_POST[$this->plugin_name.'-tracking-mode'] ? $_POST[$this->plugin_name.'-tracking-mode'] : '';
				
				if (empty($matomoUrl)) {
					$admin_notice = "error";
					$messageLog .= 'url is empty ';
				
				}
				if (empty($matomoToken)) {
					$admin_notice = "error";
					$messageLog .= 'token is empty ';
				
				}
				if (empty($matomoId)) {
					$admin_notice = "error";
					$messageLog .= 'id is empty ';
				}
				if (empty($matomoMode)) {
					$admin_notice = "error";
					$messageLog .= 'mode is empty ';
				}
				if (empty($admin_notice)) {
					if ( get_option( $this->plugin_name.'-url' ) !== false ) {
						update_option( $this->plugin_name.'-url', $matomoUrl );
					} else {
						add_option( $this->plugin_name.'-url', $matomoUrl);
					}
					if ( get_option( $this->plugin_name.'-token' ) !== false ) {
						update_option( $this->plugin_name.'-token', $matomoToken );
					} else {
						add_option( $this->plugin_name.'-token', $matomoToken);
					}
					if ( get_option( $this->plugin_name.'-tracking-id' ) !== false ) {
						update_option( $this->plugin_name.'-tracking-id', $matomoId );
					} else {
						add_option( $this->plugin_name.'-tracking-id', $matomoId);
					}	
					if ( get_option( $this->plugin_name.'-tracking-mode' ) !== false ) {
						update_option( $this->plugin_name.'-tracking-mode', $matomoMode );
					} else {
						add_option( $this->plugin_name.'-tracking-mode', $matomoMode);
					}			
					$admin_notice = "success";
					$messageLog .= 'Settings saved';
				}
				
				
				$this->custom_redirect( $admin_notice, $messageLog);
				die();
			}  else {
				wp_die( __( 'Invalid nonce specified', $this->plugin_name ), __( 'Error', $this->plugin_name ), array(
						'response' 	=> 403,
						'back_link' => 'options-general.php?page=' . $this->plugin_name,
				) );
			}
	}
	
	public function custom_redirect( $admin_notice, $response ) {
		wp_redirect( esc_url_raw( add_query_arg( array(
									'matomo_tracker_admin_add_notice' => $admin_notice,
									'matomo_tracker_response' => $response,
									),
							admin_url('options-general.php?page='. $this->plugin_name ) 
					) ) );

	}

	public function print_plugin_admin_notices() {              
		  if ( isset( $_REQUEST['matomo_tracker_admin_add_notice'] ) ) {
			if( $_REQUEST['matomo_tracker_admin_add_notice'] === "success") {
				$html =	'<div class="notice notice-success is-dismissible"> 
							<p><strong>' . htmlspecialchars( print_r( $_REQUEST['matomo_tracker_response'], true) ) . '</strong></p></div>';
				echo $html;
			}
			if( $_REQUEST['matomo_tracker_admin_add_notice'] === "error") {
				$html =	'<div class="notice notice-error is-dismissible"> 
							<p><strong>' . htmlspecialchars( print_r( $_REQUEST['matomo_tracker_response'], true) ) . '</strong></p></div>';
				echo $html;
			}
		  } else {
			  return;
		  }

	}

}

<?php

namespace Matomo_Tracker\Inc\Frontend;
use PiwikTracker as PiwikTracker;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @link       https://www.niroma.net
 * @since      1.0.0
 *
 * @author    Niroma
 */
class Frontend {

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
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	/*public function enqueue_styles() {/*

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
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/matomo-tracker-frontend.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
/*	public function enqueue_scripts() {

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
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/matomo-tracker-frontend.js', array( 'jquery' ), $this->version, false );

	}
	*/
	public function add_tracking_code_footer() {
		if ( !empty(get_option( $this->plugin_name.'-url' )) && !empty(get_option( $this->plugin_name.'-tracking-id' )) && !empty(get_option( $this->plugin_name.'-token' )) ) {
			$piwikFileDir = plugin_dir_url( __FILE__ );
			$matomoJsMode = get_option( $this->plugin_name.'-javascript-mode' );
			$matomoScript = "<script type='text/javascript'";
			if ($matomoJsMode == 'defer') $matomoScript .= " defer='defer'";
			if ($matomoJsMode == 'async') $matomoScript .= " async='async'";
			$matomoScript .= " src='".$piwikFileDir."track.js'></script>";
			echo $matomoScript;
		}
	}
	
	public function disallow_javascript_tracking( $output, $public ) {
		if ( '1' === $public ) {
			$output .= "Disallow: /wp-content/plugins/matomo-tracker/inc/frontend/track.js\n";
		}
			return $output;
	}
	
	public function add_php_tracking() {
		if ( !empty(get_option( $this->plugin_name.'-url' )) && !empty(get_option( $this->plugin_name.'-tracking-id' )) && !empty(get_option( $this->plugin_name.'-token' )) ) {
			$piwikurl = untrailingslashit( get_option( $this->plugin_name.'-url' ) );
			$piwikid = get_option( $this->plugin_name.'-tracking-id' );
			$token = get_option( $this->plugin_name.'-token' );
			
			if (!class_exists('PiwikTracker')) require( plugin_dir_path( __FILE__ ).'PiwikTracker.php');
			PiwikTracker::$URL=$piwikurl;
			$tracker = new PiwikTracker($piwikid);
			$tracker->setTokenAuth($token);
			$tracker->doTrackPageView(wp_title('', false));
		}
	}

}

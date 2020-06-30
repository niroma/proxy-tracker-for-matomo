<?php

namespace Proxy_Tracker_For_Matomo\Inc\Frontend;
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
	
	private $plugin_name_dir;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since       1.0.0
	 * @param       string $plugin_name        The name of this plugin.
	 * @param       string $version            The version of this plugin.
	 * @param       string $plugin_text_domain The text domain of this plugin.
	 */
	public function __construct( $plugin_name, $version, $plugin_text_domain, $plugin_name_dir ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->plugin_text_domain = $plugin_text_domain;
		
		$this->plugin_name_dir = $plugin_name_dir;

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
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/proxy-tracker-for-matomo-frontend.css', array(), $this->version, 'all' );

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
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/proxy-tracker-for-matomo-frontend.js', array( 'jquery' ), $this->version, false );

	}
	*/
	public function add_tracking_code_footer() {
		if ( !empty(get_option( $this->plugin_name.'-url' )) && !empty(get_option( $this->plugin_name.'-tracking-id' )) && !empty(get_option( $this->plugin_name.'-token' )) ) {
			echo '<script>'. $this->get_javascript_tracking_code() .'</script>';
		}
	}
	
	public function enqueue_tracking_script() {
		if ( !empty(get_option( $this->plugin_name.'-url' )) && !empty(get_option( $this->plugin_name.'-tracking-id' )) && !empty(get_option( $this->plugin_name.'-token' )) ) {
			$piwikJsFile = $this->plugin_name_dir . 'inc/frontend/track.js';
			file_put_contents($piwikJsFile, $this->get_javascript_tracking_code());
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'track.js', array(), $this->version, true );
		}
	}
	
	
	public function add_note_footer() {
		echo '<!-- MATOMO TRACKING CODE DISABLED FOR '. get_option( $this->plugin_name.'-users-auth' ) .' USERS -->';
	}
	
	private function get_javascript_tracking_code() {
		$currentDomain = get_site_url();
		$parse = parse_url($currentDomain);
		$piwikFileDir = str_replace($currentDomain, "", plugin_dir_url( __FILE__ ) );
		if (!empty($parse['path'])) $piwikFileDir = $parse['path'] . $piwikFileDir;
		$currentDomain = preg_replace("(^https?:)", "", $currentDomain );
		$piwikId = get_option( $this->plugin_name.'-tracking-id' );
		update_option( $this->plugin_name.'-frontend', plugin_dir_url( __FILE__ ) );
		return 'var _paq = _paq || []; _paq.push(["trackPageView"]);_paq.push(["enableLinkTracking"]);(function() {var u="'. $currentDomain .'";var v= "'. $piwikFileDir .'";_paq.push(["setTrackerUrl", u+v+"piwik.php"]); _paq.push(["setSiteId", "'. $piwikId .'"]);var d=document, g=d.createElement("script"), s=d.getElementsByTagName("script")[0];g.type="text/javascript"; g.async=true; g.defer=true; g.src=u+v+"piwik.php";s.parentNode.insertBefore(g,s);})();';
	}
	
	public function disallow_javascript_tracking( $output, $public ) {
		if ( '1' === $public ) {
			$output .= "Disallow: /wp-content/plugins/proxy-tracker-for-matomo/inc/frontend/track.js\n";
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

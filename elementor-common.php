<?php
/**
 * Plugin Name: Elementor Extension Common
 * Description: Custom Elementor extension which includes custom widgets.
 * Plugin URI:  https://www.anahian.com/
 * Version:     1.0.0
 * Author:      Abdullah Nahian
 * Author URI:  https://www.anahian.com/
 * Text Domain: elementor-common
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * EWA Elementor Ashley Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class Elementor_Common_Extension {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.0';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 * @static
	 *
	 * @var Elementor_Common_Extension The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 *
	 * @return Elementor_Common_Extension An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {

		add_action( 'init', [ $this, 'i18n' ] );
		add_action( 'plugins_loaded', [ $this, 'init' ] );

	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 *
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function i18n() {

		load_plugin_textdomain( 'elementor-common', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );

	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed load the files required to run the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}


		// Add Plugin actions
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
		add_action( 'elementor/controls/controls_registered', [ $this, 'init_controls' ] );

        // added by EWA - action hook for 'ewa-ashley, EWA Elements' custom category for panel widgets
		add_action( 'elementor/init', [ $this, 'elementor_category' ] );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'elementor-common' ),
			'<strong>' . esc_html__( 'EWA Elementor Ashley', 'elementor-common' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementor-common' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-common' ),
			'<strong>' . esc_html__( 'EWA Elementor Ashley', 'elementor-common' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementor-common' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-common' ),
			'<strong>' . esc_html__( 'EWA Elementor Ashley', 'elementor-common' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'elementor-common' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init_widgets() {

		// Include Widget files
		require_once( __DIR__ . '/widgets/elementor-common.php' );

		// added by EWA - EWA own Register widgets, loading all widget names

		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_Common_Widget() );
		


	}

	// added by EWA
	public function widget_styles() {

			// todo: file path needs to replaced by minified one
			wp_register_style( 'ewa-elementor-style', plugins_url( 'style.css', __FILE__ ) );
			wp_enqueue_style('ewa-elementor-style');

	}	

    // added by EWA
	public function widget_scripts() {

			// todo: file path needs to replaced by minified one
		    // name needs to modified
		    wp_register_script( 'ewa-elementor-slick-js', plugins_url( 'assets/js/vendor/slick.min.js', __FILE__ ) );
		    wp_register_script( 'ewa-elementor-waypoints-js', plugins_url( 'assets/js/vendor/waypoints.min.js', __FILE__ ) );
		    wp_register_script( 'ewa-elementor-counter-js', plugins_url( 'assets/js/vendor/jquery.counterup.min.js', __FILE__ ) );
			wp_register_script( 'ewa-elementor-script', plugins_url( 'assets/minified/js/scripts.min.js', __FILE__ ) );
			wp_enqueue_script('ewa-elementor-slick-js');
			wp_enqueue_script('ewa-elementor-waypoints-js');
			wp_enqueue_script('ewa-elementor-counter-js');
			wp_enqueue_script('ewa-elementor-script');

	}

    // added by EWA - added a custom category for panel widgets which is added by an action hook at the top 'init'
    public function elementor_category () {

	   \Elementor\Plugin::$instance->elements_manager->add_category( 
	   	'elementor-common',
	   	[
	   		'title' => __( 'Elementor Category', 'elementor-common' ),
	   		'icon' => 'fa fa-plug', //default icon
	   	],
	   	2 // position
	   );

	}


}

Elementor_Common_Extension::instance();
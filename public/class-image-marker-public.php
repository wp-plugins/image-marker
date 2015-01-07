<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://L6n.org
 * @since      1.0.0
 *
 * @package    Image_Marker
 * @subpackage Image_Marker/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Image_Marker
 * @subpackage Image_Marker/public
 * @author     Neil Boyd <NeilBoyd@gmail.com>
 */
class Image_Marker_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $image_marker    The ID of this plugin.
	 */
	private $image_marker;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $image_marker       The name of the plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $image_marker, $version ) {

		$this->image_marker = $image_marker;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Image_Marker_Public_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Image_Marker_Public_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// wp_enqueue_style( $this->image_marker, plugin_dir_url( __FILE__ ) . 'css/image-marker-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Image_Marker_Public_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Image_Marker_Public_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// wp_enqueue_script( $this->image_marker, plugin_dir_url( __FILE__ ) . 'js/image-marker-public.js', array( 'jquery' ), $this->version, false );

	}

}

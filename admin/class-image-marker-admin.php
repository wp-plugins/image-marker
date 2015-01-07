<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://L6n.org
 * @since      1.0.0
 *
 * @package    Image_Marker
 * @subpackage Image_Marker/admin
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Image_Marker
 * @subpackage Image_Marker/admin
 * @author     Neil Boyd <NeilBoyd@gmail.com>
 */
class Image_Marker_Admin {

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
	 * @var      string    $image_marker       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $image_marker, $version ) {

		$this->image_marker = $image_marker;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Image_Marker_Admin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Image_Marker_Admin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->image_marker, plugin_dir_url( __FILE__ ) . 'css/image-marker-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Image_Marker_Admin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Image_Marker_Admin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->image_marker, plugin_dir_url( __FILE__ ) . 'js/image-marker-admin.js', array( 'jquery' ), $this->version, false );
		$nonce = wp_create_nonce( $this->image_marker );
		wp_localize_script( $this->image_marker, 'my_ajax_obj', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce'    => $nonce,
			'error_message' => __( 'Image has no location data', $this->image_marker )
		) );

	}

	/**
	 * add an extra option to row in media library
	 * @since    1.0.0
	 * @param $actions
	 * @param $post
	 * @param $detached
	 * @return mixed
	 */
	public function filter_add_map_marker($actions, $post, $detached) {
		$actions['map_marker'] = $this->render_map_marker_action_link( 'image-marker-create', $post->ID );
		return $actions;
	}

	/**
	 * add an extra option to row in NextGEN gallery
	 * @since    1.0.0
	 * @param $num
	 * @return mixed
	 */
	function filter_ngg_num_columns( $num ) {
		return $num + 1;
	}

	/**
	 * add an extra option to row in NextGEN gallery
	 * @since    1.0.0
	 * @param $actions
	 * @return mixed
	 */
	function filter_ngg_image_marker_create( $actions ) {
		$actions['map_marker'] = array( &$this, 'render_ngg_map_marker_action_link' );
		return $actions;
	}

	/**
	 * add an extra option to row in NextGEN gallery
	 * @since    1.0.0
	 * @param $id
	 * @param $picture
	 * @return string
	 */
	function render_ngg_map_marker_action_link( $id, $picture ) {
		return $this->render_map_marker_action_link( 'ngg-image-marker-create', $picture-> pid );
	}

	/**
	 * function to render the link
	 * @since    1.0.0
	 * @param $class
	 * @param $id
	 * @return string
	 */
	function render_map_marker_action_link( $class, $id )
	{
		$label	= esc_html__( 'Marker', $this->image_marker );
		$title	= esc_attr(__( 'Marker', $this->image_marker ));
		return "<a class='{$class}' data-id='{$id}' href='#' title='{$title}'>{$label}</a>";
	}

	/**
	 * this is the function that's called from JavaScript
	 *
	 * @since    1.0.0
	 */
	function image_marker_create() {

		check_ajax_referer( $this->image_marker );

		$result = Media_Library_Marker::read_file_data( $_REQUEST["id"] );

		echo json_encode($result);
		die();
	}

	/**
	 * this is the function that's called from JavaScript
	 *
	 * @since    1.0.0
	 */
	function ngg_image_marker_create() {

		check_ajax_referer( $this->image_marker );

		$result = NextGen_Image_Marker::read_file_data( $_REQUEST["id"] );

		echo json_encode($result);
		die();
	}

}
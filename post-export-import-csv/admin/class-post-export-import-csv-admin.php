<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       www.cmsminds.com
 * @since      1.0.0
 *
 * @package    Post_Export_Import_Csv
 * @subpackage Post_Export_Import_Csv/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Post_Export_Import_Csv
 * @subpackage Post_Export_Import_Csv/admin
 * @author     Rizwan Shaikh <rizwan@cmsminds.com>
 */
class Post_Export_Import_Csv_Admin {

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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Post_Export_Import_Csv_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Post_Export_Import_Csv_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/post-export-import-csv-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Post_Export_Import_Csv_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Post_Export_Import_Csv_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
	}

	// Define custom function here
	/**
	 * Adds 'Export' button on post page
	 */
	public function addCustomExportBtnToPostPage()
	{
		global $current_screen;

	    // Not our post type, exit earlier
	    if ( 'post' !== $current_screen->post_type ) {
	        return;
	    }
	    wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/post-export-import-csv-admin.js', array( 'jquery' ), $this->version, false );
	}

	// Fetch post data and create a CSV file for user
	public function fun_fetch_csv_with_post_data() {
		global $post;

		$args = array(
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
        );
  
        $arr_post = get_posts( $args );
        if ( $arr_post ) {
  
            $output_filename = 'wp_post_export_' . strftime( '%Y-%m-%d_%H-%M-%S' )  . '.csv';
			$output_handle   = @fopen( $output_filename, 'w' );

			header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
			header( 'Content-Description: File Transfer' );
			header( 'Content-type: text/csv' );
			header( 'Content-Disposition: attachment; filename=' . $output_filename );
			header( 'Expires: 0' );
			header( 'Pragma: public' );
  
            fputcsv( $output_handle, array(
            	__( 'Post Title', $this->plugin_name ),
            	__( 'Content', $this->plugin_name ),
            	__( 'URL', $this->plugin_name ),
            	__( 'Author', $this->plugin_name ),
            	__( 'Categories', $this->plugin_name ),
            	__( 'Tags', $this->plugin_name ),
            	__( 'Published Date', $this->plugin_name )
            ));
  
            foreach ( $arr_post as $post ) {
                setup_postdata( $post );
                  
                $categories = get_the_category();
                $cats = array();
                if ( ! empty( $categories ) && is_array( $categories ) ) {
                    foreach ( $categories as $category ) {
                        $cats[] = $category->name;
                    }
                }
  
                $post_tags = get_the_tags();
                $tags = array();
                if ( ! empty( $post_tags ) && is_array($tags) ) {
                    foreach ( $post_tags as $tag ) {
                        $tags[] = $tag->name;
                    }
                }
  
                fputcsv( $output_handle, array(
                		get_the_title(),
                		sanitize_text_field( get_the_content() ),
                		sanitize_url( get_the_permalink() ),
                		get_the_author(),
                		implode( ',', $cats ),
                		implode( ',', $tags ),
                		get_the_date()
                	)
            	);
            }
  
  			// Close output file stream
			fclose( $output_handle );
			echo $output_filename;
            exit;
        }
	}
}

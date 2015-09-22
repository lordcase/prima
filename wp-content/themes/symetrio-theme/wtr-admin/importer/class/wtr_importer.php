<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

if ( ! class_exists( 'WTR_Importer' ) ) {

	class WTR_Importer {

		private $import_data = array();
		private $path;
		private $path_uri;
		private $status_proces = array();



		public function __construct( $import_data = null , $path = null, $path_uri = null) {

			if( empty( $import_data ) OR empty( $path ) OR empty( $path_uri ) ){
				return false;
			}
			$this->import_data	= $import_data;
			$this->path			= $path;
			$this->path_uri			= $path_uri;
		}// end __construct


		public function import( $clear_content = true ){
			if( $clear_content ) {
				$this->clear_content();
			}

			foreach ( $this->import_data as $type ) {
				$this->status_proces[] = $type->import( $this->path, $this->path_uri );
			}
		} // end import


		public function checkStatusProces(){
			return !in_array( false, $this->status_proces );
		}//end getStatusProces


		private function clear_content(){

			//delete post
			global $wtr_custom_posts_type;

			$types		= array( 'attachment', 'post', 'page', 'revision', 'nav_menu_item' );
			$posts_type	= ( is_array( $wtr_custom_posts_type ) AND ! empty( $wtr_custom_posts_type ) ) ? array_unique( array_merge( $wtr_custom_posts_type, $types ) ) : $types;

			$args = array(
				'offset'			=> 0,
				'orderby'			=> 'post_date',
				'order'				=> 'DESC',
				 'post_type'		=> $posts_type,
				'post_status'		=> array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash'),
				'posts_per_page'	=> -1,
				'fields'			=> 'ids'
			);

			$posts = get_posts( $args );
			foreach ( (array) $posts as $post) {
				wp_delete_post( $post, true );
			}

			//delete  terms
			foreach ( $posts_type as $post_type) {

				$taxonomies = get_object_taxonomies( $post_type, 'names' );
				foreach ( (array) $taxonomies as $taxonomy ) {
					$terms = get_terms( $taxonomy, array( 'hide_empty' => false, 'fields' => 'ids' ) );

					if ( $terms ) {
						foreach( $terms as $term ) {
							wp_delete_term( $term,  $taxonomy );
						}
					}
				}
			}
		}// end clear_content
	};// end WTR_Importer
}
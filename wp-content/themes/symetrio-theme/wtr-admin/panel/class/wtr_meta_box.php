<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

if (! class_exists('WTR_Meta_Box')) {
	class WTR_Meta_Box extends WTR_core
	{

		protected $id;
		protected $title;
		protected $page;
		protected $context;
		protected $priority;
		protected $sections;
		protected $callback ='render_meta_box_content';
		protected static $count = 0;

		public function __construct($data = array())
		{
			if (! is_array($data) or
				 ! isset($data[ 'id' ]) or
				 ! isset($data[ 'title' ]) or
				 ! isset($data[ 'page' ]) or
				 ! isset($data[ 'context' ]) or
				 ! isset($data[ 'priority' ]) or
				 ! isset($data[ 'sections' ]) or
				 ! is_array($data[ 'sections' ])
			) {
				throw new Exception($this->errors['param_construct']);
			}

			foreach ($data[ 'sections' ] as $sections) {
				foreach ($sections['fields'] as $key => $value) {
					if ('WTR_Filed' !=  get_parent_class($value)) {
						throw new Exception($this->errors[ 'param_construct' ] . $this->errors[ 'param_construct_parent' ]);
					}
				}
			}

			foreach ($data as $key => $value) {
				$this->$key = $value;
			}

			if (!self::$count) {
				//add_action('wp_enqueue_script', array( &$this, 'init_enqueue' ));
				add_action('add_meta_boxes', array( &$this, 'init_enqueue' ));
				self::$count++;
			}

			add_action('add_meta_boxes', array( &$this, 'add_meta_box'));
			add_action('save_post', array( &$this, 'save' ));
		}// end __construct


		public function init_enqueue()
		{
			// Enqueue Stylesheets
			wp_enqueue_style('site');
			wp_enqueue_style('normalize');
			wp_enqueue_style('aristo');
			wp_enqueue_style('minicolors');
			wp_enqueue_style('prettyCheckable');
			wp_enqueue_style('pikaday');

			// Enqueue Scripts
			wp_enqueue_script('jquery-mini');
			wp_enqueue_script('jquery-ui');
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'jquery-ui-button' );

			wp_enqueue_script('minicolors');

			wp_enqueue_script('gmaps');
			wp_enqueue_script('wtr_google_maps_style');
			wp_enqueue_script('moment');
			wp_enqueue_script('pikaday');
			wp_enqueue_script('obj_loader');
			wp_enqueue_script('admin_panel_j');
			wp_enqueue_script('prettyCheckable');
		}// end init_enqueue


		public function add_meta_box()
		{
			add_meta_box($this->id, $this->title, array( &$this, $this->callback ), $this->page, $this->context, $this->priority);

			if ('side' != $this->context) {
				add_filter('postbox_classes_' . $this->page . '_' . $this->id, array( &$this, 'add_meta_box_classes' ));
			}
		}// end add_meta_box


		public function add_meta_box_classes($classes=array())
		{
			if (! in_array('wtrOptionPanel', $classes)) {
				$classes[] = 'wtrOptionPanel';
			}
			return $classes;
		} // end add_meta_box_classes


		public function render_meta_box_content($post)
		{
			echo '<div class="wtrPageOptions wtrUIContener">';
			echo '<div class="wtrPageOptionsInner">';
			echo '<div class="wtrPageOptionsBranding">';
			echo '<div class="wtrPageOptionsBrandingInner">';
			echo '<span class="wtrPageOptionsBrandingItem">' . WTR_THEME_NAME . ' </span>';
			echo '</div>';
			echo '</div>';
			echo '<ul class="wtrPageOptionsTabsInsider">';
			$section_count =  count($this->sections);
			foreach ($this->sections as $sections_key => $sections) {
				$active_tab    = (!empty($sections['active_tab'])) ?'wtrActivePageOptionTab' : 'wtrNonActivePageOptionTab';
				$exclusion    = (!empty($sections['exclusion'])) ? $sections['exclusion'] : '';
				echo '<li><span class="wtrPageOptionsTabItem ' . $active_tab . ' ' . $exclusion . '" data-trigger="wtrPageOptionsTabItem_' . $sections['class'] . '" >' . $sections['name'] . '</span></li>';
			}
			echo '</ul>';
			echo '</div>';

			echo '<div class="wtrPageOptionsTabsContent">';
			wp_nonce_field('wtr_meta_box', 'wtr_meta_box_nonce');
			foreach ($this->sections as $sections) {
				echo '<div class="wtrPageOptionsTabContentInner wtrPageOptionsTabItem_' . $sections['class'] . '" >';
				foreach ($sections['fields'] as $field) {
					$wtr_meta_db_value  = get_post_meta($post->ID, $field->get('id'), true);

					if ($wtr_meta_db_value or '0' === $wtr_meta_db_value) {
						$field->set('value', $wtr_meta_db_value);
					} else {
						$field->set('value', $field->get('default_value'));
					}
					$field->draw();
				}
				echo '</div>';
			}
			echo '</div>';
			echo '</div>';
		}// end render_meta_box_content


		public function render_right_meta_box_content($post)
		{
			foreach ($this->sections as $sections) {
				foreach ($sections['fields'] as $field) {
					$wtr_meta_db_value  = get_post_meta($post->ID, $field->get('id'), false);
					$field->set('value', $wtr_meta_db_value);
					$field->draw();
				}
			}
		} // end render_right_meta_box_content


		// Save post metadata when a post is saved.
		public function save($post_id)
		{

			// Check if our nonce is set.
			if (! isset($_POST['wtr_meta_box_nonce'])) {
				return $post_id;
			}

			$nonce = $_POST['wtr_meta_box_nonce'];

			// Verify that the nonce is valid.
			if (! wp_verify_nonce($nonce, 'wtr_meta_box')) {
				return $post_id;
			}

			// If this is an autosave, our form has not been submitted,
			// so we don't want to do anything.
			if (defined('DOING_AUTOSAVE') and DOING_AUTOSAVE) {
				return $post_id;
			}

			// Check the user's permissions.
			if ('page' == $_POST['post_type']) {
				if (! current_user_can('edit_page', $post_id)) {
					return $post_id;
				}
			} else {
				if (! current_user_can('edit_post', $post_id)) {
					return $post_id;
				}
			}

			do_action('wtr_post_save_' . $_POST['post_type'], $post_id);

			$old_values = ($_POST['ID'] == $post_id) ? get_post_meta($post_id) : get_post_meta($_POST['ID']);

			foreach ($this->sections as $sections) {
				foreach ($sections['fields'] as $field) {
					$id_field    = $field->get('id');
					$no_default    = $field->get('no_default');

					if (isset($_POST[ $id_field])) {
						$new_value = $_POST[ $id_field ];
					} elseif ($no_default == 1) {
						$new_value = 0;
					} else {
						$new_value = $field->get('default_value');
					}

					//trim value
					if (! is_array($new_value)) {
						$new_value    = trim($new_value);
					}

					// add post meta
					if (! isset($old_values[ $id_field ])) {
						add_post_meta($post_id, $id_field, $new_value);
					// update post meta
					} elseif ($new_value != $old_values[ $id_field ]) {
						update_post_meta($post_id, $id_field, $new_value);
					}
				}
			}
		}// end save
	}// WTR_Meta_Box
}

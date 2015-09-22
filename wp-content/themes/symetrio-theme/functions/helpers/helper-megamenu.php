<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('-1'); }


if( ! class_exists( 'WTR_MegaMenu' ) ) {

	class WTR_MegaMenu {

		function __construct() {

			add_action( 'wp_update_nav_menu_item', array( $this, 'update_menu' ), 10, 3 );
			add_filter( 'wp_edit_nav_menu_walker', array( $this, 'add_custom_fields' ) );
			add_filter( 'wp_setup_nav_menu_item', array( $this, 'add_data_to_menu' ) );

		} // end __construct(


		//Edit nav walker
		function add_custom_fields() {
			return 'WTR_Walker_Nav_Menu_Edit';
		} // end add_custom_fields


		//Update custom Fields
		function update_menu( $menu_id, $menu_item_db_id, $args ) {

			$check = array( 'megamenu_status', 'megamenu_columns', 'megamenu_new_row', 'menu_img', 'menu_icon', 'menu_status', 'menu_status_color', 'menu_no_generate_link', 'menu_no_generate_headline' );

			foreach ( $check as $key ) {

				if( ! isset( $_REQUEST['menu-item-wtr-' . $key ][ $menu_item_db_id ] ) ) {
					$_REQUEST['menu-item-wtr-' . $key ][ $menu_item_db_id ] = '';
				}
				$value = $_REQUEST['menu-item-wtr-' . $key ][ $menu_item_db_id ];
				update_post_meta( $menu_item_db_id, '_menu_item_wtr_' . $key, $value );
			}
		} // end  save_custom_fields


		// Add custom fields
		function add_data_to_menu( $menu_item ) {

			$menu_item->wtr_megamenu_status				= get_post_meta( $menu_item->ID, '_menu_item_wtr_megamenu_status', true );
			$menu_item->wtr_megamenu_columns			= get_post_meta( $menu_item->ID, '_menu_item_wtr_megamenu_columns', true );
			$menu_item->wtr_megamenu_new_row			= get_post_meta( $menu_item->ID, '_menu_item_wtr_megamenu_new_row', true );
			$menu_item->wtr_menu_img					= get_post_meta( $menu_item->ID, '_menu_item_wtr_menu_img', true );
			$menu_item->wtr_menu_no_generate_link		= get_post_meta( $menu_item->ID, '_menu_item_wtr_menu_no_generate_link', true );
			$menu_item->wtr_menu_no_generate_headline	= get_post_meta( $menu_item->ID, '_menu_item_wtr_menu_no_generate_headline', true );
			$menu_item->wtr_menu_icon					= get_post_meta( $menu_item->ID, '_menu_item_wtr_menu_icon', true );
			$menu_item->wtr_menu_status					= get_post_meta( $menu_item->ID, '_menu_item_wtr_menu_status', true );
			$menu_item->wtr_menu_status_color			= get_post_meta( $menu_item->ID, '_menu_item_wtr_menu_status_color', true );
			return $menu_item;

		} // end add_data_to_menu

	} // end WTR_MegaMenu
}
new WTR_MegaMenu;


if( ! class_exists( 'WTR_Walker_Nav_Menu_Edit' ) ) {

	class WTR_Walker_Nav_Menu_Edit extends Walker_Nav_Menu {

		/**
		 * Starts the list before the elements are added.
		 *
		 * @see Walker_Nav_Menu::start_lvl()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference.
		 * @param int	$depth  Depth of menu item. Used for padding.
		 * @param array  $args   Not used.
		 */
		function start_lvl( &$output, $depth = 0, $args = array() ) {}

		/**
		 * Ends the list of after the elements are added.
		 *
		 * @see Walker_Nav_Menu::end_lvl()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference.
		 * @param int	$depth  Depth of menu item. Used for padding.
		 * @param array  $args   Not used.
		 */
		function end_lvl( &$output, $depth = 0, $args = array() ) {}

		/**
		 * Start the element output.
		 *
		 * @see Walker_Nav_Menu::start_el()
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item   Menu item data object.
		 * @param int	$depth  Depth of menu item. Used for padding.
		 * @param array  $args   Not used.
		 * @param int	$id	 Not used.
		 */
		function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			global $_wp_nav_menu_max_depth;
			$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

			ob_start();
			$item_id = esc_attr( $item->ID );
			$removed_args = array(
				'action',
				'customlink-tab',
				'edit-menu-item',
				'menu-item',
				'page-tab',
				'_wpnonce',
			);

			$original_title = '';
			if ( 'taxonomy' == $item->type ) {
				$original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
				if ( is_wp_error( $original_title ) )
					$original_title = false;
			} elseif ( 'post_type' == $item->type ) {
				$original_object = get_post( $item->object_id );
				$original_title = get_the_title( $original_object->ID );
			}

			$classes = array(
				'menu-item menu-item-depth-' . $depth,
				'menu-item-' . esc_attr( $item->object ),
				'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
			);

			$title = $item->title;

			if ( ! empty( $item->_invalid ) ) {
				$classes[] = 'menu-item-invalid';
				/* translators: %s: title of menu item which is invalid */
				$title = sprintf( __( '%s (Invalid)', 'wtr_framework' ), $item->title );
			} elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
				$classes[] = 'pending';
				/* translators: %s: title of menu item in draft status */
				$title = sprintf( __( '%s (Pending)', 'wtr_framework' ), $item->title );
			}

			$title = ( ! isset( $item->label ) || '' == $item->label ) ? $title : $item->label;

			$submenu_text = '';
			if ( 0 == $depth )
				$submenu_text = 'style="display: none;"';

			?>
			<li id="menu-item-<?php echo $item_id; ?>" class="<?php echo implode(' ', $classes ); ?>">
				<dl class="menu-item-bar">
					<dt class="menu-item-handle">
						<span class="item-title"><span class="menu-item-title"><?php echo esc_html( $title ); ?></span> <span class="is-submenu" <?php echo $submenu_text; ?>><?php _e( 'sub item', 'wtr_framework' ); ?></span></span>
						<span class="item-controls">
							<span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
							<span class="item-order hide-if-js">
								<a href="<?php
									echo wp_nonce_url(
										add_query_arg(
											array(
												'action' => 'move-up-menu-item',
												'menu-item' => $item_id,
											),
											remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
										),
										'move-menu_item'
									);
								?>" class="item-move-up"><abbr title="<?php esc_attr_e( 'Move up', 'wtr_framework' ); ?>">&#8593;</abbr></a>
								|
								<a href="<?php
									echo wp_nonce_url(
										add_query_arg(
											array(
												'action' => 'move-down-menu-item',
												'menu-item' => $item_id,
											),
											remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
										),
										'move-menu_item'
									);
								?>" class="item-move-down"><abbr title="<?php esc_attr_e( 'Move down', 'wtr_framework' ); ?>">&#8595;</abbr></a>
							</span>
							<a class="item-edit" id="edit-<?php echo $item_id; ?>" title="<?php esc_attr_e( 'Edit Menu Item', 'wtr_framework' ); ?>" href="<?php
								echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
							?>"><?php _e( 'Edit Menu Item', 'wtr_framework' ); ?></a>
						</span>
					</dt>
				</dl>

				<div class="menu-item-settings" id="menu-item-settings-<?php echo $item_id; ?>">
					<?php if( 'custom' == $item->type ) : ?>
						<p class="field-url description description-wide">
							<label for="edit-menu-item-url-<?php echo $item_id; ?>">
								<?php _e( 'URL', 'wtr_framework' ); ?><br />
								<input type="text" id="edit-menu-item-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
							</label>
						</p>
					<?php endif; ?>
					<p class="description description-thin">
						<label for="edit-menu-item-title-<?php echo $item_id; ?>">
							<?php _e( 'Navigation Label', 'wtr_framework' ); ?><br />
							<input type="text" id="edit-menu-item-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
						</label>
					</p>
					<p class="description description-thin">
						<label for="edit-menu-item-attr-title-<?php echo $item_id; ?>">
							<?php _e( 'Title Attribute', 'wtr_framework' ); ?><br />
							<input type="text" id="edit-menu-item-attr-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
						</label>
					</p>
					<p class="field-link-target description">
						<label for="edit-menu-item-target-<?php echo $item_id; ?>">
							<input type="checkbox" id="edit-menu-item-target-<?php echo $item_id; ?>" value="_blank" name="menu-item-target[<?php echo $item_id; ?>]"<?php checked( $item->target, '_blank' ); ?> />
							<?php _e( 'Open link in a new window/tab', 'wtr_framework' ); ?>
						</label>
					</p>
					<p class="field-css-classes description description-thin">
						<label for="edit-menu-item-classes-<?php echo $item_id; ?>">
							<?php _e( 'CSS Classes (optional)', 'wtr_framework' ); ?><br />
							<input type="text" id="edit-menu-item-classes-<?php echo $item_id; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item_id; ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
						</label>
					</p>
					<p class="field-xfn description description-thin">
						<label for="edit-menu-item-xfn-<?php echo $item_id; ?>">
							<?php _e( 'Link Relationship (XFN)', 'wtr_framework' ); ?><br />
							<input type="text" id="edit-menu-item-xfn-<?php echo $item_id; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
						</label>
					</p>
					<p class="field-description description description-wide">
						<label for="edit-menu-item-description-<?php echo $item_id; ?>">
							<?php _e( 'Description', 'wtr_framework' ); ?><br />
							<textarea id="edit-menu-item-description-<?php echo $item_id; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item_id; ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
							<span class="description"><?php _e( 'The description will be displayed in the menu if the current theme supports it.', 'wtr_framework' ); ?></span>
						</label>
					</p>

			<!-- START Custom fields  -->
				<!-- START first level -->
					<!-- START mega menu -->
					<p class="field-wtr-megamenu_status description description-wide">
						<label for="edit-menu-item-wtr-megamenu_status-<?php echo $item_id; ?>">
							<input type="checkbox" id="edit-menu-item-wtr-megamenu_status-<?php echo $item_id; ?>" class="widefat code edit-menu-item-wtr-megamenu_status" name="menu-item-wtr-megamenu_status[<?php echo $item_id; ?>]" value="enabled" <?php checked( $item->wtr_megamenu_status, 'enabled' ); ?> />
							<?php _e( 'Enable Wonster Mega Menu', 'wtr_framework' ); ?>
						</label>
					</p>

					<p class="field-wtr-megamenu_columns description description-wide">
						<label for="edit-menu-item-wtr-megamenu_columns-<?php echo $item_id; ?>">
							<?php _e( 'Mega Menu Number of Columns', 'wtr_framework' ); ?>
							<select id="edit-menu-item-wtr-megamenu_columns-<?php echo $item_id; ?>" class="widefat code edit-menu-item-wtr-megamenu_columns" name="menu-item-wtr-megamenu_columns[<?php echo $item_id; ?>]">
								<option value="2" <?php selected( $item->wtr_megamenu_columns, '2' ); ?>>2</option>
								<option value="3" <?php selected( $item->wtr_megamenu_columns, '3' ); ?>>3</option>
								<option value="4" <?php selected( $item->wtr_megamenu_columns, '4' ); ?>>4</option>
							</select>
						</label>
					</p>

					<p class="field-wtr-menu_img description description-wide">
						<label for="edit-menu-item-wtr-menu_img-<?php echo $item_id; ?>">
							<?php _e( 'Background image', 'wtr_framework' ); ?>
							<input  type="hidden" id="edit-menu-item-wtr-menu_img-<?php echo $item_id; ?>" data-trigger="<?php echo $item_id; ?>" class="widefat code edit-menu-item-wtr-menu_img" name="menu-item-wtr-menu_img[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->wtr_menu_img ); ?>" />
							<img id="wtr-mega-menu-media-img-<?php echo $item_id; ?>" class="wtr-mega-menu-media-img" />
							<span id="wtr-mega-menu-delete-img-<?php echo $item_id; ?>" class="wtr-mega-menu-remove-img" data-trigger="<?php echo $item_id; ?>"><?php _e( 'Remove image', 'wtr_framework' ); ?></span>
						</label>
					</p>
					<span id="wtr-mega-menu-set-thumbnail-<?php echo $item_id; ?>" class="wtr-mega-menu-set-thumbnail wtr-mega-menu-set-thumbnail-btn" data-trigger="<?php echo $item_id; ?>">Set Thumbnail</span>
					<!-- END mega menu -->
				<!-- END first level -->

				<!-- START second level -->
					<!-- START mega menu -->
					<p class="field-wtr-megamenu_new_row description description-wide">
						<label for="edit-menu-item-wtr-megamenu_new_row-<?php echo $item_id; ?>">
							<input type="checkbox" id="edit-menu-item-wtr-megamenu_new_row-<?php echo $item_id; ?>" class="widefat code edit-menu-item-wtr-megamenu_new_row" name="menu-item-wtr-megamenu_new_row[<?php echo $item_id; ?>]" value="enabled" <?php checked( $item->wtr_megamenu_new_row, 'enabled' ); ?> />
							<?php _e( 'This item should start a new row', 'wtr_framework' ); ?>
						</label>
					</p>
					<p class="field-wtr-menu_no_generate_headline description description-wide">
						<label for="edit-menu-item-wtr-menu_no_generate_headline-<?php echo $item_id; ?>">
							<input type="checkbox" id="edit-menu-item-wtr-menu_no_generate_headline-<?php echo $item_id; ?>" class="widefat code edit-menu-item-wtr-menu_no_generate_headline" name="menu-item-wtr-menu_no_generate_headline[<?php echo $item_id; ?>]" value="enabled" <?php checked( $item->wtr_menu_no_generate_headline, 'enabled' ); ?> />
							<?php _e( 'Don\'t generate headline', 'wtr_framework' ); ?>
						</label>
					</p>
					<!-- END  mega menu  -->
				<!-- END second level -->

				<!-- START each level -->
					<p class="field-wtr-menu_no_generate_link description description-wide">
						<label for="edit-menu-item-wtr-menu_no_generate_link-<?php echo $item_id; ?>">
							<input type="checkbox" id="edit-menu-item-wtr-menu_no_generate_link-<?php echo $item_id; ?>" class="widefat code edit-menu-item-wtr-menu_no_generate_link" name="menu-item-wtr-menu_no_generate_link[<?php echo $item_id; ?>]" value="enabled" <?php checked( $item->wtr_menu_no_generate_link, 'enabled' ); ?> />
							<?php _e( 'Don\'t generate Link', 'wtr_framework' ); ?>
						</label>
					</p>
					<p class="field-wtr-menu_status description description-thin">
						<label for="edit-menu-item-wtr-menu_status-<?php echo $item_id; ?>">
							<?php _e( 'Status', 'wtr_framework' ); ?>
							<input  type="text" id="edit-menu-item-wtr-menu_status-<?php echo $item_id; ?>" class="widefat code edit-menu-item-wtr-menu_status" name="menu-item-wtr-menu_status[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->wtr_menu_status ); ?>" />
						</label>
					</p>
					<p class="field-wtr-menu_status_color description description-thin">
						<label for="edit-menu-item-wtr-menu_status_color-<?php echo $item_id; ?>">
							<?php _e( 'Status color', 'wtr_framework' ); ?>
							<select id="edit-menu-item-wtr-menu_status_color-<?php echo $item_id; ?>" class="widefat code edit-menu-item-wtr-menu_status_color" name="menu-item-wtr-menu_status_color[<?php echo $item_id; ?>]">
								<option value="1" <?php selected( $item->wtr_menu_status_color, '1' ); ?>><?php _e( 'Style 1', 'wtr_framework' ); ?></option>
								<option value="2" <?php selected( $item->wtr_menu_status_color, '2' ); ?>><?php _e( 'Style 2', 'wtr_framework' ); ?></option>
								<option value="3" <?php selected( $item->wtr_menu_status_color, '3' ); ?>><?php _e( 'Style 3', 'wtr_framework' ); ?></option>
								<option value="4" <?php selected( $item->wtr_menu_status_color, '4' ); ?>><?php _e( 'Style 4', 'wtr_framework' ); ?></option>
							</select>
						</label>
					</p>

					<p class="field-wtr-menu_icon description description-wide">
						<label for="edit-menu-item-wtr-menu_icon-<?php echo $item_id; ?>">
							<?php _e( 'Icon (from: <a target="_blank" href="http://fortawesome.github.io/Font-Awesome/icons/">Font Awesome</a>) | eg. <b>fa</b> fa-code', 'wtr_framework' ); ?>
							<input  type="text" id="edit-menu-item-wtr-menu_icon-<?php echo $item_id; ?>" class="widefat code edit-menu-item-wtr-menu_icon" name="menu-item-wtr-menu_icon[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->wtr_menu_icon ); ?>" />
						</label>
					</p>

				<!-- END each level -->
			<!-- END Custom fields  -->

					<p class="field-move hide-if-no-js description description-wide">
						<label>
							<span><?php _e( 'Move', 'wtr_framework' ); ?></span>
							<a href="#" class="menus-move-up"><?php _e( 'Up one', 'wtr_framework' ); ?></a>
							<a href="#" class="menus-move-down"><?php _e( 'Down one', 'wtr_framework' ); ?></a>
							<a href="#" class="menus-move-left"></a>
							<a href="#" class="menus-move-right"></a>
							<a href="#" class="menus-move-top"><?php _e( 'To the top', 'wtr_framework' ); ?></a>
						</label>
					</p>

					<div class="menu-item-actions description-wide submitbox">
						<?php if( 'custom' != $item->type && $original_title !== false ) : ?>
							<p class="link-to-original">
								<?php printf( __( 'Original: %s', 'wtr_framework' ), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
							</p>
						<?php endif; ?>
						<a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id; ?>" href="<?php
						echo wp_nonce_url(
							add_query_arg(
								array(
									'action' => 'delete-menu-item',
									'menu-item' => $item_id,
								),
								admin_url( 'nav-menus.php' )
							),
							'delete-menu_item_' . $item_id
						); ?>"><?php _e( 'Remove', 'wtr_framework' ); ?></a> <span class="meta-sep hide-if-no-js"> | </span> <a class="item-cancel submitcancel hide-if-no-js" id="cancel-<?php echo $item_id; ?>" href="<?php echo esc_url( add_query_arg( array( 'edit-menu-item' => $item_id, 'cancel' => time() ), admin_url( 'nav-menus.php' ) ) );
							?>#menu-item-settings-<?php echo $item_id; ?>"><?php _e( 'Cancel', 'wtr_framework' ); ?></a>
					</div>

					<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>" />
					<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
					<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
					<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
					<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
					<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
				</div><!-- .menu-item-settings-->
				<ul class="menu-item-transport"></ul>
			<?php
			$output .= ob_get_clean();
		} // end start_el

	} // WTR_Walker_Nav_Menu_Edit
}


if( ! class_exists( 'WTR_Walker_Nav_Menu' ) ) {

	class WTR_Walker_Nav_Menu extends Walker_Nav_Menu {

		private $megamenu_status			= '';
		private $megamenu_columns			= '';

		private $menu_img					= '';
		private $menu_no_generate_link		= '';
		private $menu_no_generate_headline	= '';
		private $menu_icon					= '';
		private $menu_status				= '';
		private $menu_status_color			= '';


		private $megamenu_count_columns		= 0;
		private $megamenu_new_column		= false;
		private $megamenu_class_columns		= '';

		private $megamenu_new_row			= false;
		private $megamenu_count_row			= 0;


		private $menu_status_class			= array( 1 => 'green ', 2 => 'red ', 3 => 'blue ', 4 => 'yellow ' );
		private $menu_column_class			= array( 2 => 'Two', 3 => 'Three', 4 => 'Four' );


		/**
		 * Starts the list before the elements are added.
		 *
		 * @see Walker::start_lvl()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   An array of arguments. @see wp_nav_menu()
		 */
		function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);

			if( 0 === $depth AND "enabled" == $this->megamenu_status ) {
				$output .= "\n{MegaMenuContainer}\n";
			} else if( 1 === $depth AND "enabled" == $this->megamenu_status ) {

			} else if( 0 === $depth ) {
				$output .= "\n{MegaMenuContainer}\n";
				$output .= "\n$indent<ul class=\"sub-menu wtrSecondNavigation \">\n";
			} else if( 1 === $depth ) {
				$output .= "\n$indent<ul class=\"sub-menu wtrThirdNavigation wtrThirdDrop wtrMegaMenuContainerColorSecond apperAnimationSec \">\n";

			} else {
				$output .= "\n$indent<ul class=\"sub-menu wtrSecondNavigation \">\n";
			}
		} // end start_lvl


		/**
		 * Ends the list of after the elements are added.
		 *
		 * @see Walker::end_lvl()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   An array of arguments. @see wp_nav_menu()
		 */
		function end_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			if( 0 === $depth AND "enabled" == $this->megamenu_status ) {
				$output .= "\t</ul>\n</div>\n";

				$background		= '';
				if( $this->menu_img ){
					$background = "style=\"background:url('" . $this->menu_img . "');\" ";
				}

				$output = str_replace( "{MegaMenuContainer}", "<div " . $background . "class=\"wtrMegaMenuContainer wtrMegaMenuContainerColor apperAnimation clearfix\">", $output );
				$output = str_replace( "{MegaMenuCol}", "wtrMegaMenuCol wtrMegaMenuColOne" . $this->megamenu_class_columns , $output );
			} else if( 1 === $depth AND "enabled" == $this->megamenu_status ) {

			} else if( 0 === $depth ) {
				$output .= "$indent</ul>\n</div>\n";

				$background		= '';
				if( $this->menu_img ){
					$background = "style=\"background:url('" . $this->menu_img . "');\"";
				}

				$output = str_replace( "{MegaMenuContainer}", "<div $background class=\"wtrSecondMenuContainer wtrStandardMenu wtrMegaMenuContainerColor apperAnimation clearfix\">", $output );
			} else {
				$output .= "$indent</ul>\n";
			}
		} // end end_lvl


		/**
		 * Start the element output.
		 *
		 * @see Walker::start_el()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item   Menu item data object.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   An array of arguments. @see wp_nav_menu()
		 * @param int    $id     Current item ID.
		 */
		function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			$item->classes = empty( $item->classes ) ? array() : $item->classes ;

			// lvl 0
			if( 0 === $depth ) {
				$this->megamenu_status		= $item->wtr_megamenu_status;
				$this->megamenu_columns		= $item->wtr_megamenu_columns;
				$this->menu_img				= trim( $item->wtr_menu_img );

				/*
				//IMG attachment ID
				$menu_img					= wp_get_attachment_image_src( 465, 'full' );
				$this->$menu_img			= $menu_img[0];
				*/

				$this->megamenu_count_columns	= 0;
				$this->megamenu_new_column		= false;
				$this->megamenu_count_row		= 0;
				$this->megamenu_new_row			= false;

				// Mega menu <ul> columns class
				if( $this->megamenu_status == "enabled" ) {
					$this->megamenu_class_columns = isset ( $this->menu_column_class[ $this->megamenu_columns ] ) ? $this->menu_column_class[ $this->megamenu_columns ] : 4;
				}
			}

			// each lvl
			$this->menu_icon					= trim( $item->wtr_menu_icon );
			$this->menu_status					= trim( $item->wtr_menu_status );
			$this->menu_status_color			= trim( $item->wtr_menu_status_color );
			$this->menu_no_generate_link		= trim( $item->wtr_menu_no_generate_link );
			$this->menu_no_generate_headline	= trim( $item->wtr_menu_no_generate_headline );


			// Mega menu columns
			if( $this->megamenu_status == "enabled" ){

				if( 1 === $depth ){

					$this->megamenu_new_row	= ( 'enabled' === $item->wtr_megamenu_new_row OR true === $this->megamenu_new_row ) ? true :  false;
					$MegaMenuColLast		= '';

					$this->megamenu_count_columns ++;

					//Mega menu end column
					if( true === $this->megamenu_new_column ){
						$output .= "$indent</ul>";
						$this->megamenu_new_column		= false;

						//Mega menu new row
						if( true === $this->megamenu_new_row ){
							$output .= "\n$indent<div class=\"wtrMegaMenuDivider\"></div>";
							$this->megamenu_count_columns	= 1;
							$this->megamenu_new_row			= false;
							$this->megamenu_count_row ++;

						}
					}

					//Mega menu last colum class
					if( $this->megamenu_columns ==  $this->megamenu_count_columns ){
						$MegaMenuColLast				= 'wtrMegaMenuColLast';
						$this->megamenu_count_columns	= 0;
						$this->megamenu_new_row			= true;
					}

					//Mega menu new column
					$this->megamenu_new_column = true;
					$output .= "\n$indent<ul class=\"sub-menu wtrSecondNavigation {MegaMenuCol} $MegaMenuColLast \">\n";
				}
			}

			// Drop down icon
			$dropicon_after		= '';
			$dropicon_before	= '';
			if( ( 0 === $depth OR  ( 1 === $depth AND "enabled" !== $this->megamenu_status )  ) AND $args->has_children ){
				$dropicon_before	= '<span class="wtrDropIcon">';
				$dropicon_after		= '</span>';
			}

			// <li> class
			if( 0 === $depth ) {

				$item->classes[] = 'wtrNaviItem';

				if( $args->has_children ){
					if( "enabled" == $this->megamenu_status ) {
						$item->classes[] = 'wtrMegaDrop';
					} else {
						$item->classes[] = 'wtrSecondDrop';
					}
				}
			} else if ( 1 === $depth ) {
				$item->classes[] = 'wtrSecNaviItem';

				if( "enabled" == $this->megamenu_status ){
					if( "enabled" !== $this->menu_no_generate_headline ) {
						$item->classes[] = 'wtrMegaMenuHeadline';
					}
				} else if( $args->has_children ){
					$item->classes[] = 'wtrSecNaviItem wtrThirdNavi';
				}
			} else {
				$item->classes[] = 'wtrSecNaviItem';
			}


			//link class
			$item_link_class = '';
			if( 0 === $depth ) {
				$item_link_class = 'wtrMenuLinkColor';
				if( "enabled" == $this->menu_no_generate_link ){
					$item_link_class .= ' wtrNaviNoLink';
				}
			} else if( 1 === $depth AND "enabled" == $this->megamenu_status ) {
				if( "enabled" == $this->menu_no_generate_headline ) {
					$item_link_class = 'wtrSecNaviItemLink wtrSecondMenuLinkColor';
				}else if( "enabled" !== $this->menu_no_generate_link ){
					$item_link_class = 'wtrSecondMenuLinkColor';
				}
			} else if( 2 === $depth AND "enabled" == $this->megamenu_status ) {
				$item_link_class = 'wtrSecNaviItemLink wtrSecondMenuLinkColor';
			} else if( 1 === $depth ) {
				$item_link_class = 'wtrSecNaviItemLink wtrSecondMenuLinkColor';
			} else if( 2 === $depth ) {
				$item_link_class = 'wtrSecNaviItemLink wtrThirdMenuLinkColor';
			}




			$class_names = $value = '';

			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;

			/**
			 * Filter the CSS class(es) applied to a menu item's <li>.
			 *
			 * @since 3.0.0
			 *
			 * @param array  $classes The CSS classes that are applied to the menu item's <li>.
			 * @param object $item    The current menu item.
			 * @param array  $args    An array of arguments. @see wp_nav_menu()
			 */
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			/**
			 * Filter the ID applied to a menu item's <li>.
			 *
			 * @since 3.0.1
			 *
			 * @param string The ID that is applied to the menu item's <li>.
			 * @param object $item The current menu item.
			 * @param array $args An array of arguments. @see wp_nav_menu()
			 */
			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li' . $id . $value . $class_names .'>';

			$atts = array();
			$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
			$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
			$atts['href']   = ! empty( $item->url )        ? $item->url        : '';
			$atts['class']  = ! empty( $item_link_class )  ? $item_link_class  : '';


			/**
			 * Filter the HTML attributes applied to a menu item's <a>.
			 *
			 * @since 3.6.0
			 *
			 * @param array $atts {
			 *     The HTML attributes applied to the menu item's <a>, empty strings are ignored.
			 *
			 *     @type string $title  The title attribute.
			 *     @type string $target The target attribute.
			 *     @type string $rel    The rel attribute.
			 *     @type string $href   The href attribute.
			 * }
			 * @param object $item The current menu item.
			 * @param array  $args An array of arguments. @see wp_nav_menu()
			 */
			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			$item_output = $args->before;

			if( "enabled" == $this->menu_no_generate_link ){
				if( ! empty( $item_link_class ) ) {
					$item_output .= '<span class="' . $atts['class']  . '">';
				}
			} else {
				$item_output .= '<a'. $attributes .'>';
			}



			//start drop down icon
			$item_output .= $dropicon_before;

			//icon menu item
			if( ! empty( $this->menu_icon ) ){
				$item_output .='<i class="' . $this->menu_icon . '"></i>';
			}

			/** This filter is documented in wp-includes/post-template.php */
			$item_output .=  $args->link_before .  apply_filters( 'the_title', $item->title, $item->ID ) .  $args->link_after;

			//statusmenu item
			$menu_item_status_colors = isset ( $this->menu_status_class[ $this->menu_status_color ] ) ? $this->menu_status_class[ $this->menu_status_color ] : 1;

			if( ! empty( $this->menu_status ) ){
				$item_output .='<span class="wtrNaviFlag ' . $menu_item_status_colors . ' wtrRadius50">' . $this->menu_status . '</span>';
			}

			//end drop down icon
			$item_output .= $dropicon_after;

			if( "enabled" == $this->menu_no_generate_link ) {
				if( ! empty( $item_link_class ) ) {
					$item_output .= '</span>';
				}
			} else {
				$item_output .= '</a>';
			}

			$item_output .= $args->after;

			/**
			 * Filter a menu item's starting output.
			 *
			 * The menu item's starting output only includes $args->before, the opening <a>,
			 * the menu item's title, the closing </a>, and $args->after. Currently, there is
			 * no filter for modifying the opening and closing <li> for a menu item.
			 *
			 * @since 3.0.0
			 *
			 * @param string $item_output The menu item's starting HTML output.
			 * @param object $item        Menu item data object.
			 * @param int    $depth       Depth of menu item. Used for padding.
			 * @param array  $args        An array of arguments. @see wp_nav_menu()
			 */
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		} // end start_el


		/**
		 * Ends the element output, if needed.
		 *
		 * @see Walker::end_el()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item   Page data object. Not used.
		 * @param int    $depth  Depth of page. Not Used.
		 * @param array  $args   An array of arguments. @see wp_nav_menu()
		 */
		function end_el( &$output, $item, $depth = 0, $args = array() ) {

			if( $depth === 1 OR "enabled" == $this->megamenu_status ) {

			} else {
				$output .= "</li>\n";
			}
		} // end end_el


		/**
		 * Traverse elements to create list from elements.
		 *
		 * Display one element if the element doesn't have any children otherwise,
		 * display the element and its children. Will only traverse up to the max
		 * depth and no ignore elements under that depth. It is possible to set the
		 * max depth to include all depths, see walk() method.
		 *
		 * This method should not be called directly, use the walk() method instead.
		 *
		 * @since 2.5.0
		 *
		 * @param object $element           Data object.
		 * @param array  $children_elements List of elements to continue traversing.
		 * @param int    $max_depth         Max depth to traverse.
		 * @param int    $depth             Depth of current element.
		 * @param array  $args              An array of arguments.
		 * @param string $output            Passed by reference. Used to append additional content.
		 * @return null Null on failure with no changes to parameters.
		 */
		function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {

			if ( ! $element )
				return;

			$id_field = $this->db_fields['id'];

			//display this element
			if ( is_object( $args[0] ) ){
				$args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
			}

			parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
		} // end display_element


		// The function used when the menu does not exist
		public static function fallback( $args ) {
			return null;
		} // end fallback

	} // WTR_Walker_Nav_Menu
}
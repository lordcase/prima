<?php
/**
 * WooCommerce compatibility
 *
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

function wtr_woocommerce_detect_activation( $plugin, $network_activation ) {
	if( 'woocommerce/woocommerce.php' == $plugin ){
		update_option( 'wtr_woocommerce_activation', 1 );
	}
} // end wtr_woocommerce_detect_activation
add_action( 'activated_plugin', 'wtr_woocommerce_detect_activation', 10, 2 );


function wtr_woocommerce_update_settings(){
	$status	= get_option( 'wtr_woocommerce_activation' );
	if( 1 == $status ){
		global $WTR_Opt;
		$WTR_Opt->update_options();
		delete_option( 'wtr_woocommerce_activation');
	}
} // end wtr_woocommerce_update_settings
add_action( 'after_setup_theme', 'wtr_woocommerce_update_settings' );


if( ! function_exists( 'is_woocommerce' ) ) {
	return false;
}


// WooCommerce Support
add_theme_support('woocommerce');


if( ! function_exists( 'wtr_woocommerce_styles' ) ) {

	function wtr_woocommerce_styles(){
		wp_enqueue_style( 'wtr_woocommerce_css', WTR_EXTENSIONS_URI . '/woocommerce/assets/css/woocommerce.css' );
	} // end wtr_woocommerce_styles
}
add_action( 'wp_enqueue_scripts', 'wtr_woocommerce_styles', 100 );


if( ! function_exists( 'wtr_woocommerce_init' ) ) {

	function wtr_woocommerce_init( $option ){

		//Woocommerce: wtr_WoocommerceSidebarSection
		$wtr_WoocommerceGeneralShoopIcon = new WTR_Radio( array(
				'id'			=> 'wtr_WoocommerceGeneralShoopIcon',
				'title'			=> __( 'Shop icon inside main navigation', 'wtr_framework' ),
				'desc'			=> '',
				'value'			=> '',
				'default_value' => '1',
				'info'			=> '',
				'allow'			=> 'int',
				'option'		=> array( '1' => 'On' , '0' => 'Off' ),
			)
		);

		$wtr_WoocommerceGeneralProductsPerPage = new WTR_Text( array(
				'id'			=> 'wtr_WoocommerceGeneralProductsPerPage',
				'class'			=> '',
				'title'			=> __( 'Number of Products per Page', 'wtr_framework' ),
				'desc'			=> '',
				'value'			=> '',
				'default_value' => '5',
				'info'			=> '',
				'allow'			=> 'all',
			)
		);


		//Woocommerce: wtr_WoocommerceSidebarSection
		$wtr_SidebarPositionOnShoopArchivePage= new WTR_Radio_Img( array(
				'id'			=> 'wtr_SidebarPositionOnShoopArchivePage',
				'title'			=> __( 'Sidebar position on Shop archive pages', 'wtr_framework' ),
				'desc'			=> '',
				'value'			=> '',
				'default_value' => 'setNone',
				'info'			=> '',
				'allow'			=> 'all',
				'checked' 		=> 'sideChecked',
				'class' 		=> 'sideSetter',
				'option'		=> array( 'setLeftSide' , 'setRightSide', 'setNone' ),
			)
		);

		$wtr_SidebarPositionOnShoopProductPage = new WTR_Radio_Img( array(
				'id'			=> 'wtr_SidebarPositionOnShoopProductPage',
				'title'			=> __( 'Sidebar position on Shop product pages', 'wtr_framework' ),
				'desc'			=> '',
				'value'			=> '',
				'default_value' => 'setNone',
				'info'			=> '',
				'allow'			=> 'all',
				'checked' 		=> 'sideChecked',
				'class' 		=> 'sideSetter',
				'option'		=> array( 'setLeftSide' , 'setRightSide', 'setNone' ),
			)
		);

		$wtr_SidebarPositionOnShoopCartPage = new WTR_Radio_Img( array(
				'id'			=> 'wtr_SidebarPositionOnShoopCartPage',
				'title'			=> __( 'Sidebar position on Shop Cart pages', 'wtr_framework' ),
				'desc'			=> '',
				'value'			=> '',
				'default_value' => 'setNone',
				'info'			=> '',
				'allow'			=> 'all',
				'checked' 		=> 'sideChecked',
				'class' 		=> 'sideSetter',
				'option'		=> array( 'setLeftSide' , 'setRightSide', 'setNone' ),
			)
		);

		$wtr_SidebarPositionOnShoopCheckoutPage = new WTR_Radio_Img( array(
				'id'			=> 'wtr_SidebarPositionOnShoopCheckoutPage',
				'title'			=> __( 'Sidebar position on Shop Checkou pages', 'wtr_framework' ),
				'desc'			=> '',
				'value'			=> '',
				'default_value' => 'setNone',
				'info'			=> '',
				'allow'			=> 'all',
				'checked' 		=> 'sideChecked',
				'class' 		=> 'sideSetter',
				'option'		=> array( 'setLeftSide' , 'setRightSide', 'setNone' ),
			)
		);

		$wtr_SidebarPositionOnShoopAccountPage = new WTR_Radio_Img( array(
				'id'			=> 'wtr_SidebarPositionOnShoopAccountPage',
				'title'			=> __( 'Sidebar position on Shop Account pages', 'wtr_framework' ),
				'desc'			=> '',
				'value'			=> '',
				'default_value' => 'setNone',
				'info'			=> '',
				'allow'			=> 'all',
				'checked' 		=> 'sideChecked',
				'class' 		=> 'sideSetter',
				'option'		=> array( 'setLeftSide' , 'setRightSide', 'setNone' ),
			)
		);

		$wtr_WoocommerceGeneralSection = new WTR_Section( array(
				'id'		=> 'wtr_WoocommerceGeneralSection',
				'title'		=> __( 'General', 'wtr_framework' ),
				'fields'	=> array(
					$wtr_WoocommerceGeneralProductsPerPage,
					$wtr_WoocommerceGeneralShoopIcon,
				),
			)
		);

		$wtr_WoocommerceSidebarSection = new WTR_Section( array(
				'id'		=> 'wtr_WoocommerceSidebarSection',
				'title'		=> __( 'Sidebar', 'wtr_framework' ),
				'fields'	=> array(
					$wtr_SidebarPositionOnShoopArchivePage,
					$wtr_SidebarPositionOnShoopProductPage,
					$wtr_SidebarPositionOnShoopCartPage,
					$wtr_SidebarPositionOnShoopAccountPage,
					$wtr_SidebarPositionOnShoopCheckoutPage,
				),
			)
		);

		$wtr_WoocommerceGroup = new WTR_Group( array(
				'title'		=> __( 'Woocommerce', 'wtr_framework' ),
				'class'		=> 'wtr_WoocommerceGroup',
				'sections'	=> array(
					$wtr_WoocommerceGeneralSection,
					$wtr_WoocommerceSidebarSection,
				),
			)
		);
		$option[] = $wtr_WoocommerceGroup;
		return $option;
	} // end wtr_woocommerce_init
}
add_filter( 'wtr_init', 'wtr_woocommerce_init' );


if( ! function_exists( 'wtr_woocommerce_post_settings' ) ) {

	function wtr_woocommerce_post_settings( $post_settings ){

		if( is_product() ) {
			$post_settings['wtr_SidebarPosition']		= $post_settings['wtr_SidebarPositionOnShoopProductPage'];
			$post_settings['wtr_Sidebar']				= 'woocommerce_product';
		} else if( is_shop() OR is_product_taxonomy() ) {
			$shop_page_id 	= woocommerce_get_page_id( 'shop' );
			$post_settings['wtr_SidebarPosition']		= $post_settings['wtr_SidebarPositionOnShoopArchivePage'];
			$post_settings['wtr_Sidebar']				= 'woocommerce_shop';
			$post_settings['wtr_page_nav_menu']			= get_post_meta(  $shop_page_id , '_wtr_page_nav_menu', true );
		} else if( is_cart() ) {
			$post_settings['wtr_SidebarPosition']		= $post_settings['wtr_SidebarPositionOnShoopCartPage'];
			$post_settings['wtr_Sidebar']				= 'woocommerce_cart';
		} else if( is_checkout() ) {
			$post_settings['wtr_SidebarPosition']		= $post_settings['wtr_SidebarPositionOnShoopCheckoutPage'];
			$post_settings['wtr_Sidebar']				= 'woocommerce_checkout';
		} else if( is_account_page() ) {
			$post_settings['wtr_SidebarPosition']		= $post_settings['wtr_SidebarPositionOnShoopAccountPage'];
			$post_settings['wtr_Sidebar']				= 'woocommerce_account';
		}

		return $post_settings;
	} // end wtr_woocommerce_post_settings
}
add_filter( 'wtr_post_settings', 'wtr_woocommerce_post_settings');


if( ! function_exists( 'wtr_woocommerce_register_sidebars' ) ) {
	// register custom sidebars
	function wtr_woocommerce_register_sidebars() {

		global $WTR_Opt;

		// footer
		$woocommerce = array(
			array('name' => __( 'Woocommerce Shop  Page', WTR_THEME_NAME ), 'id' => 'custom-sidebar-woocommerce_shop'),
			array('name' => __( 'Woocommerce Product Page', WTR_THEME_NAME ), 'id' => 'custom-sidebar-woocommerce_product'),
			array('name' => __( 'Woocommerce Cart Page', WTR_THEME_NAME ), 'id' => 'custom-sidebar-woocommerce_cart'),
			array('name' => __( 'Woocommerce Checkout Page', WTR_THEME_NAME ), 'id' => 'custom-sidebar-woocommerce_checkout'),
			array('name' => __( 'Woocommerce Account Page', WTR_THEME_NAME ), 'id' => 'custom-sidebar-woocommerce_account')
		);

		foreach ( $woocommerce as $key => $value) {
			register_sidebar( array(
			'name'			=> $value['name'],
			'id'			=> $value['id'],
			'description'	=> '',
			'class'			=> '',
			'before_widget'	=> '<div id="%1$s" class="widget %2$s">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<h6>',
			'after_title'	=> '</h6>',
			));
		}

	} // end wtr_woocommerce_register_sidebars
}
add_action( 'widgets_init', 'wtr_woocommerce_register_sidebars', 20 );


if( ! function_exists( 'wtr_woocommerce_related_products_args' ) ) {
	function wtr_woocommerce_related_products_args( $args ) {
		$args['posts_per_page']	= 4; // 4 related products
		$args['columns']		= 4; // arranged in 2 columns
		return $args;
	} // end wtr_woocommerce_related_products_args
}
add_filter( 'woocommerce_output_related_products_args', 'wtr_woocommerce_related_products_args' );


if( ! function_exists( 'wtr_woocommerce_header_add_to_cart_fragment' ) ) {
	function wtr_woocommerce_header_add_to_cart_fragment( $fragments ) {

		global $post_settings;
		if( 1 == $post_settings['wtr_WoocommerceGeneralShoopIcon'] ){
			global $woocommerce;
			ob_start();

			echo '<a class="wtr_cart wtrNaviCartLink" href="' . esc_url( $woocommerce->cart->get_cart_url() ) . '" title="' . esc_attr( __( 'View your shopping cart', 'woothemes' ) ) . '" >';
					echo '<i class="fa fa-shopping-cart"></i>';
					echo '<span class="wtrCartCounter wtrCartCounterSmall wtrMenuLinkColor">';
						echo $woocommerce->cart->cart_contents_count;
					echo '</span>';
			echo '</a>';

			$fragments['a.wtr_cart'] = ob_get_clean();
			return $fragments;
		}
	} // end wtr_woocommerce_header_add_to_cart_fragment
}
add_filter('add_to_cart_fragments', 'wtr_woocommerce_header_add_to_cart_fragment');


if( ! function_exists( 'wtr_woocommerce_shop_icon' ) ) {

	// add search icon inside main navigation
	function wtr_woocommerce_shop_icon ( $items, $args ) {

		global $post_settings, $woocommerce;

		if ( 'primary' ==  $args->theme_location AND  0 == $post_settings['wtr_HeaderCleanMenuMod'] AND 1 == $post_settings['wtr_WoocommerceGeneralShoopIcon'] AND is_numeric( strpos($args->menu_class, 'wtrMainNavigation') ) ) {

			$items .= '<li class="wtrNaviItem wtrNaviCartItem">';
				$items .= '<a class="wtr_cart wtrNaviCartLink" href="' . esc_url( $woocommerce->cart->get_cart_url() ) . '" title="' . esc_attr( __( 'View your shopping cart', 'woothemes' ) ) . '" >';
					$items .= '<i class="fa fa-shopping-cart"></i>';
					$items .= '<span class="wtrCartCounter wtrCartCounterSmall wtrMenuLinkColor">';
						$items .= $woocommerce->cart->cart_contents_count;
					$items .= '</span>';
				$items .= '</a>';
			$items .= '</li>';
		}
		return $items;
	} // end wtr_woocommerce_shop_icon
}
add_filter( 'wp_nav_menu_items', 'wtr_woocommerce_shop_icon', 6, 2 );


if( ! function_exists( 'wtr_woocommerce_shop_per_page' ) ) {
	function wtr_woocommerce_shop_per_page( $count ){
		global $post_settings;
		return $post_settings['wtr_WoocommerceGeneralProductsPerPage'];
	} // end wtr_woocommerce_shop_per_page
}
add_filter( 'loop_shop_per_page', 'wtr_woocommerce_shop_per_page');


if( ! function_exists( 'wtr_woocommerce_output_upsells' ) ) {
	function wtr_woocommerce_output_upsells() {
		woocommerce_upsell_display( 4,4 ); // Display 3 products in rows of 3
	} // end wtr_woocommerce_output_upsells
}
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_after_single_product_summary', 'wtr_woocommerce_output_upsells', 15 );


if( ! function_exists( 'wtr_woocommerce_cross_sell_display' ) ) {

	function wtr_woocommerce_cross_sell_display() {
		woocommerce_cross_sell_display( 2, 2 ); // Display 3 products in rows of 3
	} // end wtr_woocommerce_cross_sell_display
}
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
add_action( 'woocommerce_cart_collaterals', 'wtr_woocommerce_cross_sell_display' );


if( ! function_exists( 'wtr_woocommerce_breadcrumbs' ) ) {

	function wtr_woocommerce_breadcrumbs( $output_crumbs ) {

		if( is_woocommerce() ) {

			$shop_id	= woocommerce_get_page_id('shop');

			// shop
			if( is_shop() ) {

				$output_crumbs		= wtr_woocommerce_shop_breadcrumbs( $output_crumbs, $shop_id, false ) ;

			// product
			} else if( is_product() ) {

				$output_crumbs		= wtr_woocommerce_shop_breadcrumbs( $output_crumbs, $shop_id, true ) ;
				$post_type			= get_post_type_object( get_post_type() );
				$output_crumbs[]	= array( 'name' => $post_type->labels->singular_name );
				$output_crumbs[]	= array( 'url' => '', 'name' => get_the_title() );

			// product category /  product tag
			} else if( is_product_category() OR  is_product_tag() ) {
				$shop_crumbs = wtr_woocommerce_shop_breadcrumbs( $output_crumbs, $shop_id, true );
				array_splice( $output_crumbs, 0, 1, $shop_crumbs );
			}

		}
		return $output_crumbs;
	} // end wtr_woocommerce_breadcrumbs
}
add_filter( 'wtr_breadcrumbs_output_crumbs', 'wtr_woocommerce_breadcrumbs');


if( ! function_exists( 'wtr_woocommerce_shop_breadcrumbs' ) ) {

	function wtr_woocommerce_shop_breadcrumbs( $crumbs, $shop_id, $shop_link ) {

		$output_crumbs[]	= $crumbs[0];

		if( ! empty( $shop_id ) AND -1 != $shop_id ) {
			$shop				= get_post( $shop_id  );
			$parent_id			= $shop->post_parent;
			$output_crumbs		= wtr_breadcrumbs_parents_page( $parent_id, $output_crumbs );
		}

		if( true == $shop_link ){
			$output_crumbs[]	= array( 'url' => get_permalink( $shop_id ), 'name' => wtr_woocommerce_get_shop_title() );
		} else {
			$output_crumbs[]	= array( 'url' => '', 'name' => wtr_woocommerce_get_shop_title() );
		}
		return $output_crumbs;
	} // end wtr_woocommerce_shop_breadcrumbs
}


if( ! function_exists( 'wtr_woocommerce_get_shop_title' ) ) {

	function wtr_woocommerce_get_shop_title( ) {

		$shop_page_id 	= woocommerce_get_page_id( 'shop' );
		$page_title 	= get_the_title( $shop_page_id );
		$title 			= apply_filters( 'woocommerce_page_title', $page_title );

		return $title;
	} // end wtr_woocommerce_get_shop_title
}


if( ! function_exists( 'wtr_woocommerce_breadcrumbs_title' ) ) {

	function wtr_woocommerce_breadcrumbs_title( $title ) {

		if( is_shop() ){
			$title 	= wtr_woocommerce_get_shop_title();
		}
		return $title;
	} // end wtr_woocommerce_breadcrumbs_title
}
add_filter( 'wtr_breadcrumbs_title', 'wtr_woocommerce_breadcrumbs_title');


if (!function_exists('wtr_woocommerce_loop_columns')) {
	function wtr_woocommerce_loop_columns() {
		return 3; // 3 products per row
	} // end wtr_woocommerce_loop_columns
}
add_filter('loop_shop_columns', 'wtr_woocommerce_loop_columns');
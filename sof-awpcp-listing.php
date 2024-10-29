<?php
	if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	/**
	 * Plugin Name: AWPCP Listing Grid View
	 * Plugin URI: http://leah.ellasol.com/sof-awpcp-listing-grid.zip
	 * Description: Turn the Another WordPress Classified Plugin (AWPCP) into a grid view (pinterest style).
	 * Version: 1.0.0
	 * Author: RexAK
	 * Author URI: http://ellasol.com
	 * License: GPLv2 or later
	 */


	// add wrap to listing class - fastest way, since nothing seems to hook AFTER listings

	function sof_listing_js() {
		wp_enqueue_style( 'style-name', plugins_url( 'css', __FILE__ ) . '/sof-wrap-listings.css' );
		wp_enqueue_script( 'sof-wrap-listings', plugins_url( 'js', __FILE__ ) . '/wrap-listings.js', array(), '1.0.0', true );
		wp_enqueue_script( 'sof-grid-masonry', plugins_url( 'js', __FILE__ ) . '/masonry.pkgd.min.js', array('jquery'), '1.0.0', false );
	}

	add_action( 'wp_enqueue_scripts', 'sof_listing_js' );


	if ( array_key_exists( 'awpcp', $GLOBALS ) ) {

		add_filter( 'awpcp-render-listing-item', 'my_filter_handler', 10, 2 );
		function my_filter_handler( $rendered_listing, $listing, $position ) {

			// some custom classes/methods:
			include( 'class/awpcp-base.php' );
			$_awpcp = new SOF_AWPCP_BASE();
			$_images = $_awpcp->get_images_from_ad_listing_obj( $listing );
			$_location = $_awpcp->get_listing_location( $listing );
			$_category = $_awpcp->get_categories_from_listing( $listing );
			// build cat link
			$_cat_link = '/ads/browse-categories/'.$_category[0]->category_id.'/'.sanitize_title($_category[0]->category_name).'/';

			// some AWPCP built in functions and classes
			$ad_link = awpcp_listing_renderer()->get_view_listing_url( $listing );
			$ad_title_link = awpcp_listing_renderer()->get_view_listing_link( $listing );

			ob_start();
			?>

			<div class="pin">
				<a href="<?php echo $ad_link; ?>">
					<img class="sof_listing_image" src="<?php echo $_images[0]->path; ?>"/>
				</a>

				<div class="sof_details_wrap">

					<p class="sof_listing_price">
						<?php echo '$' . number_format( (float)$listing->ad_item_price * .01, 2, '.', '' ); ?>
					</p>
										<p class="sof_listing_title"><?php echo $ad_title_link; ?></p>


					<!--					<p class="sof_listing_postdate">-->
<!--						Posted: --><?php //echo date( "M jS, Y", strtotime( $listing->ad_postdate ) ); ?>
<!--					</p>-->

<!--					<p class="sof_listing_details">-->
<!--						--><?php //echo substr( $listing->ad_details, 0, 100 ) . ' ...'; ?>
<!--					</p>-->
<!---->
<!--					<p class="sof_listing_location">--><?php //echo $_location; ?><!--</p>-->
<!---->
<!--					<p class="sof_listing_total_views">Views: --><?php //echo $listing->ad_views; ?><!--</p>-->
					<p class="sof_listing_category">
						<a href="<?php echo $_cat_link;?>">
						<?php echo $_category[0]->category_name; ?>
						</a>
					</p>

				</div>
			</div>

			<?php

			$modified_listing = ob_get_clean();


//		return $rendered_listing;
			return $modified_listing;
		}
	}


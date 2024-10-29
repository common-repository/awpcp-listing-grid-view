<?php
	if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	if ( !class_exists( 'SOF_AWPCP_BASE' ) ) {
		class SOF_AWPCP_BASE {


			function get_images_from_ad_listing_obj( $listing ) {
				global $wpdb;
				$_images_to_return = NULL;
				$file_path = wp_upload_dir();
				$file_path = $file_path['baseurl'] . '/awpcp/';

				$sql_call = $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "awpcp_media WHERE ad_id = %d", (int)$listing->ad_id );
//			$_sql = $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "usermeta WHERE meta_key LIKE %s", '%_reminder_%' );
				$_images = $wpdb->get_results( $sql_call );
				foreach ( $_images as $_image ) {
					if ( strpos( $_image->status, 'Approved' ) !== false ) {
						$_image->path = $file_path . $_image->path;
						$_images_to_return[] = $_image;
					}
				}


				return $_images_to_return;
			}


			function get_listing_location( $listing ) {
				global $wpdb;
				$sql_call = $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "awpcp_ads WHERE ad_id = %d", (int)$listing->ad_id );
//			$_sql = $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "usermeta WHERE meta_key LIKE %s", '%_reminder_%' );
				$_location = $wpdb->get_results( $sql_call );
				$i=0;
				$_location_return = false;
				if(unserialize($_location[0]->college) === false){
					$loc_spec = $_location[0]->college;
				}else{
					$loc_spec = null;
					$loc_temp = unserialize($_location[0]->college);
					$total_locs = count($loc_temp);
					for($i=1;$i<=$total_locs;$i++){
						$loc_spec .= $loc_temp[$i-1];
						if($i<$total_locs){
							$loc_spec .= ', ';
						}
					}

				}
				$_location_return = $loc_spec;
				return $_location_return;
			}

			function get_categories_from_listing($listing){
				global $wpdb;
				$sql_call = $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "awpcp_categories WHERE category_id = %d", (int)$listing->ad_category_id );
//			$_sql = $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "usermeta WHERE meta_key LIKE %s", '%_reminder_%' );
				$_child_category = $wpdb->get_results( $sql_call );
				return $_child_category;
			}


		}
	}

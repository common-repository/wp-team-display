<?php

	/*
	* @Author 		Themefantasy
	* Copyright: 	2016 Themefantasy
	* Version : 1.6
	*/

	if ( ! defined( 'ABSPATH' ) )

	die("Can't load this file directly");


	/*===================================================================
		Register Custom Post Function
	=====================================================================*/
if ( ! function_exists( 'wpts_d_custom_post_type' ) ) {
	function wpts_d_custom_post_type(){
		$labels = array(
			'name'                  => _x( 'Team Showcase', 'Post Type General Name', 'fwpteamshowcase' ),
			'singular_name'         => _x( 'Team Showcase', 'Post Type Singular Name', 'fwpteamshowcase' ),
			'menu_name'             => esc_html__( 'Team Showcase', 'fwpteamshowcase' ),
			'name_admin_bar'        => esc_html__( 'Team Manager', 'fwpteamshowcase' ),
			'parent_item_colon'     => esc_html__( 'Parent Item:', 'fwpteamshowcase' ),
			'all_items'             => esc_html__( 'All Team Members', 'fwpteamshowcase' ),
			'add_new_item'          => esc_html__( 'Add New Member', 'fwpteamshowcase' ),
			'add_new'               => esc_html__( 'Add New Member', 'fwpteamshowcase' ),
			'new_item'              => esc_html__( 'New Member', 'fwpteamshowcase' ),
			'edit_item'             => esc_html__( 'Edit Member', 'fwpteamshowcase' ),
			'update_item'           => esc_html__( 'Update Member', 'fwpteamshowcase' ),
			'view_item'             => esc_html__( 'View Member', 'fwpteamshowcase' ),
			'search_items'          => esc_html__( 'Search Team Member', 'fwpteamshowcase' ),
			'not_found'             => esc_html__( 'Not found', 'fwpteamshowcase' ),
			'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'fwpteamshowcase' ),
			'featured_image'        => esc_html__( 'Team Member Image', 'fwpteamshowcase' ),
			'set_featured_image'    => esc_html__( 'Set Team Member image', 'fwpteamshowcase' ),
			'remove_featured_image' => esc_html__( 'Remove Team Member image', 'fwpteamshowcase' ),
			'use_featured_image'    => esc_html__( 'Use as Team Member image', 'fwpteamshowcase' ),
			'items_list'            => esc_html__( 'Items list', 'fwpteamshowcase' ),
			'items_list_navigation' => esc_html__( 'Items list navigation', 'fwpteamshowcase' ),
			'filter_items_list'     => esc_html__( 'Filter items list', 'fwpteamshowcase' ),
		);
		$args = array(
			'label'                 => esc_html__( 'Post Type', 'fwpteamshowcase' ),
			'description'           => esc_html__( 'Post Type Description', 'fwpteamshowcase' ),
			'labels'                => $labels,
			'supports'              =>  array( 'title', 'editor', 'thumbnail',),
			'hierarchical'          => false,
			'public'                => true,
			'menu_icon' 			=> 'dashicons-admin-users',
			'show_ui'               => true,
			'show_in_menu'          => true,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,		
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
		);
		register_post_type( 'team_mf', $args );

	}
	}
	// end custom post type
	add_action('init', 'wpts_d_custom_post_type');

if ( ! function_exists( 'wpts_d_custom_post_taxonomies_reg' ) ) {
	function wpts_d_custom_post_taxonomies_reg() {
		$labels = array(
			'name'              => _x( 'Team Member Groups', 'taxonomy general name' ),
			'singular_name'     => _x( 'Team Group', 'taxonomy singular name' ),
			'search_items'      => esc_html__( 'Search Groups' , 'fwpteamshowcase'),
			'all_items'         => esc_html__( 'All Groups' , 'fwpteamshowcase'),
			'parent_item'       => esc_html__( 'Parent Group', 'fwpteamshowcase' ),
			'parent_item_colon' => esc_html__( 'Parent Group:' , 'fwpteamshowcase'),
			'edit_item'         => esc_html__( 'Edit Team Group', 'fwpteamshowcase' ), 
			'update_item'       => esc_html__( 'Update Group' , 'fwpteamshowcase'),
			'add_new_item'      => esc_html__( 'Add New Team Group', 'fwpteamshowcase' ),
			'new_item_name'     => esc_html__( 'New Team Group', 'fwpteamshowcase' ),
			'menu_name'         => esc_html__( 'Team Groups' , 'fwpteamshowcase'),
		);
		$args = array(
			'labels' => $labels,
			'hierarchical' => true,
		);
		register_taxonomy( 'team_mfcategory', 'team_mf', $args );
	}
	}
	add_action( 'init', 'wpts_d_custom_post_taxonomies_reg', 0 );
	
	
	
	
	

	# Team Image uploader custom notice
	if ( ! function_exists( 'wpts_d_custom_post_help' ) ) {
	function wpts_d_custom_post_help($content){
		global $post_type,$post;
		if ($post_type == 'team_mf') {
			if(!has_post_thumbnail( $post->ID )){
			   $content .= '<p>'.esc_html__('Please upload square-cropped photos with a minimum dimension of 300px','fwpteamshowcase').'</p>';
			}
		}
		return $content;
	}
	}
	add_filter('admin_post_thumbnail_html','wpts_d_custom_post_help');

	

	# Add Team Meta Box
	if ( ! function_exists( 'wpts_d_custom_post_meta_box' ) ) {
	function wpts_d_custom_post_meta_box() {
		add_meta_box(
			'custom_meta_box', 
			'Member Personal Information', 
			'wpts_d_custom_inner_custom_boxes', 
			'team_mf', 
			'normal', 
			'high'
		); 
		add_meta_box(
			'custom_meta_box2', 
			'Member Social Profiles', 
			'wpts_d_custom_inner_custom_boxess',
			'team_mf', 
			'normal'
		);
	}
	}
	add_action('add_meta_boxes', 'wpts_d_custom_post_meta_box');

	/*----------------------------------------------------------------------
		Content Options Meta Box 
	----------------------------------------------------------------------*/
	if ( ! function_exists( 'wpts_d_custom_inner_custom_boxes' ) ) {
	function wpts_d_custom_inner_custom_boxes( $post ) {

		// Use nonce for verification
		wp_nonce_field( plugin_basename( __FILE__ ), 'wpts_d_custom_inner_custom_boxes_noncename' );

		?>

		<div id="details_profiles_area">
			<div class="details_profiles_cols">
				
				<p><label for="post_title_designation"><strong><?php echo esc_html__('Designation', 'fwpteamshowcase');?></strong></label></p>
				<input type="text" name="post_title_designation" placeholder="Designation" id="post_title_designation" value="<?php echo esc_attr(get_post_meta($post->ID, 'client_designation', true)); ?>" />

				<p><label for="contact_number_input"><strong><?php echo esc_html__('Contact Number', 'fwpteamshowcase');?></strong></label></p>
				<input type="text" name="contact_number_input" placeholder="xxx-xxx-xxxx" id="contact_number_input" value="<?php echo esc_attr(get_post_meta($post->ID, 'contact_number', true)); ?>" />
			
			
				<p><label for="contact_email_input"><strong><?php echo esc_html__('Email', 'fwpteamshowcase');?></strong></label></p>
				<input type="text" name="contact_email_input" placeholder="email@exapmle.com" id="contact_email_input" value="<?php echo esc_attr(get_post_meta($post->ID, 'contact_email', true)); ?>" />

			</div>
		</div>
		<?php
	}
	}
	
	if ( ! function_exists( 'wpts_d_custom_inner_custom_boxess' ) ) {
	function wpts_d_custom_inner_custom_boxess( $post ) { ?>
		<div id="details_profiles_area">
			<div class="team-backend-socialprofiles">

				<div class="single-team-social-icons">
					
					<p><label for="facebook_social_input"><strong><?php echo esc_html__('Facebook', 'fwpteamshowcase');?></strong></label></p>
					<input type="text" name="facebook_social_input" placeholder="https://example.com/username" id="facebook_social_input" value="<?php echo esc_url(get_post_meta($post->ID, 'social_facebook', true)); ?>" />
				</div>

				<div class="single-team-social-icons">
				
				<p><label for="twitter_social_input"><strong><?php echo esc_html__('Twitter', 'fwpteamshowcase');?></strong></label></p>
				<input type="text" name="twitter_social_input" placeholder="https://example.com/username" id="twitter_social_input" value="<?php echo esc_url(get_post_meta($post->ID, 'social_twitter', true)); ?>" />
				</div>
				<div class="single-team-social-icons">
				
				<p><label for="googleplus_social_input"><strong><?php echo esc_html__('Google Plus', 'fwpteamshowcase');?></strong></label></p>
				<input type="text" name="googleplus_social_input" placeholder="https://example.com/username" id="googleplus_social_input" value="<?php echo esc_url(get_post_meta($post->ID, 'social_googleplus', true)); ?>" />
				</div>
				<div class="single-team-social-icons">
				
				<p><label for="instagram_social_input"><strong><?php echo esc_html__('Instagram', 'fwpteamshowcase');?></strong></label></p>
				<input type="text" name="instagram_social_input" placeholder="https://example.com/username" id="instagram_social_input" value="<?php echo esc_url(get_post_meta($post->ID, 'social_instagram', true)); ?>" />
				</div>
				<div class="single-team-social-icons">
			
				<p><label for="pinterest_social_input"><strong><?php echo esc_html__('Pinterest', 'fwpteamshowcase');?></strong></label></p>
				<input type="text" name="pinterest_social_input" placeholder="https://example.com/username" id="pinterest_social_input" value="<?php echo esc_url(get_post_meta($post->ID, 'social_pinterest', true)); ?>" />
				</div>
				<div class="single-team-social-icons">
				
				<p><label for="linkedIn_social_input"><strong><?php echo esc_html__('LinkedIn', 'fwpteamshowcase');?></strong></label></p>
				<input type="text" name="linkedIn_social_input" placeholder="https://example.com/username" id="linkedIn_social_input" value="<?php echo esc_url(get_post_meta($post->ID, 'social_linkedin', true)); ?>" />
				</div>
				<div class="single-team-social-icons">
				
				<p><label for="dribbble_social_input"><strong><?php echo esc_html__('Dribbble', 'fwpteamshowcase');?></strong></label></p>
				<input type="text" name="dribbble_social_input" placeholder="https://example.com/username" id="dribbble_social_input" value="<?php echo esc_url(get_post_meta($post->ID, 'social_dribbble', true)); ?>" />
				</div>
				<div class="single-team-social-icons">
			
				<p><label for="youtube_social_input"><strong><?php echo esc_html__('Youtube', 'fwpteamshowcase');?></strong></label></p>
				<input type="text" name="youtube_social_input" placeholder="https://example.com/username" id="youtube_social_input" value="<?php echo esc_url(get_post_meta($post->ID, 'social_youtube', true)); ?>" />
				</div>
				<div class="single-team-social-icons">
				
				<p><label for="skype_social_input"><strong><?php echo esc_html__('Skype', 'fwpteamshowcase');?></strong></label></p>
				<input type="text" name="skype_social_input" placeholder="https://example.com/username" id="skype_social_input" value="<?php echo esc_attr(get_post_meta($post->ID, 'social_skype', true)); ?>" />
				</div>
			</div>
		</div>
		<?php
	}
	
	}

	if ( ! function_exists( 'wpts_d_custom_inner_custom_boxes_save' ) ) {
	# Save Options Meta Box Function
	function wpts_d_custom_inner_custom_boxes_save($post_id){
		
		$post_title_designation = sanitize_text_field($_POST['title']);
		if(isset($post_title_designation)) {
			update_post_meta($post_id, 'client_designation', $post_title_designation);
		}

		$contact_number_input = sanitize_text_field($_POST['contact_number_input']);
		if(isset($contact_number_input)) {
			update_post_meta($post_id, 'contact_number', $contact_number_input);
		}
		
		$contact_email_input = sanitize_text_field($_POST['contact_email_input']);
		if(isset($contact_email_input)) {
			update_post_meta($post_id, 'contact_email',$contact_email_input);
		}

		$facebook_social_input = sanitize_text_field($_POST['facebook_social_input']);
		if(isset($facebook_social_input)) {
			update_post_meta($post_id, 'social_facebook', $facebook_social_input);
		}
		
		$twitter_social_input = sanitize_text_field($_POST['twitter_social_input']);
		if(isset($twitter_social_input)) {
			update_post_meta($post_id, 'social_twitter', $twitter_social_input);
		}

		$googleplus_social_input = sanitize_text_field($_POST['googleplus_social_input']);
		if(isset($googleplus_social_input)) {
			update_post_meta($post_id, 'social_googleplus',$googleplus_social_input);
		}

		$instagram_social_input = sanitize_text_field($_POST['instagram_social_input']);
		if(isset($instagram_social_input)) {
			update_post_meta($post_id, 'social_instagram', $instagram_social_input);
		}

		$pinterest_social_input = sanitize_text_field($_POST['pinterest_social_input']);
		if(isset($pinterest_social_input)) {
			update_post_meta($post_id, 'social_pinterest', $pinterest_social_input);
		}

		$linkedIn_social_input = sanitize_text_field($_POST['linkedIn_social_input']);
		if(isset($linkedIn_social_input)) {
			update_post_meta($post_id, 'social_linkedin', $linkedIn_social_input);
		}

		$dribbble_social_input = sanitize_text_field($_POST['dribbble_social_input']);
		if(isset($dribbble_social_input)) {
			update_post_meta($post_id, 'social_dribbble', $dribbble_social_input);
		}

		$youtube_social_input = sanitize_text_field($_POST['youtube_social_input']);
		if(isset($youtube_social_input)) {
			update_post_meta($post_id, 'social_youtube', $youtube_social_input);
		}
		
		$skype_social_input = sanitize_text_field($_POST['skype_social_input']);
		if(isset($skype_social_input)) {
			update_post_meta($post_id, 'social_skype', $skype_social_input);
		}
	}
	}
add_action('save_post', 'wpts_d_custom_inner_custom_boxes_save');
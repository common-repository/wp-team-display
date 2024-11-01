<?php
/*
Plugin Name: WP Team Display
Plugin URI: https://themefantasy.com/wordpress-team-showcase/
Description: WP Team Display is a WordPress team plugin that allows to easily create and manage teams. You can display single teams as multiple responsive, you can also showcase all teams in various styles.
Version: 1.7
Author: Themefantasy
Author URI: https://themefantasy.com
License: GPLv2
Text Domain: fwpteamshowcase

*/


	/**********************************************************
	 * Exit if accessed directly
	 **********************************************************/

	if ( ! defined( 'ABSPATH' ) )

	die("Can't load this file directly");
	
	
	define('FWPTS_PLUGIN_DIR', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
	

	
	require_once( plugin_dir_path(__FILE__) . 'include/wpteam-post-type.php');
	
	if ( ! function_exists( 'wpts_f_admin_scripts' ) ) {
	function wpts_f_admin_scripts(){
		wp_enqueue_style('fwpts-admin', FWPTS_PLUGIN_DIR.'css/admin.css');
		
		}
		}
	add_action('admin_enqueue_scripts', 'wpts_f_admin_scripts');	
	
	if ( ! function_exists( 'wpts_f_scripts' ) ) {
	function wpts_f_scripts(){
		wp_enqueue_style('fwpts-design', FWPTS_PLUGIN_DIR.'css/design.css');
	}
	}
	add_action('wp_enqueue_scripts', 'wpts_f_scripts');
	
	add_action('admin_menu', 'wpts_f_page');
	if ( ! function_exists( 'wpts_f_page' ) ) {
		function wpts_f_page() {
		add_submenu_page(
			'edit.php?post_type=team_mf',
			'Shortcode',
			'Shortcode', 
			'manage_options',
			'wpteamshowcaseshortcode',
			'wpts_f_shortcode_callback'	
		);
	}
}
 
if ( ! function_exists( 'wpts_f_shortcode_callback' ) ) {
function wpts_f_shortcode_callback() { 
    ?>
    <div class="wrap shortcode_generate_wpteam">
    <div class=" shortcode_tswrp">
        <h1><?php echo esc_html__('Shortcode','fwpteamshowcase'); ?></h1>
		<h2>Below are some example shortcode, Copy paste the shortcode in your page, widget or wherever you want.</h2>
			<p>eg:<br>
			[team]<br>
			[team group="web-development"]</p>
			<p>Please note you have to change your group name as per in your document</p>
			
			
			<h1>Pro Version </h1>
			<p>Please also check there for pro version. <a class="admin-buy-now"  href="https://codecanyon.net/item/fancy-wordpress-team-showcase/25151565" target="_blank">Buy Pro</a> </p>
			<h2>Benefits</h2>
			<ul>
				<li>High-quality code guaranteed checked by Themeforest</li>
				<li>Creative and Unique Design approved by Themeforest</li>
				<li>Choose your own style solution, you are free to use 5 option design with multiple color options</li>
				<li>Customise with extra functionality like Carousel</li>
				<li>Unlimited shortcode generator</li>
				<li>100% compatible with WordPress and work with any theme</li>
				<li>Easy and fast no coding skill required</li>
				<li>Premium Support</li>
				
			</ul>
				<a class="admin-buy-now" href="https://codecanyon.net/item/fancy-wordpress-team-showcase/25151565" target="_blank">Buy Pro</a>	
			<a href="https://codecanyon.net/item/fancy-wordpress-team-showcase/25151565" target="_blank">
			<img src="<?php echo FWPTS_PLUGIN_DIR;?>/images/screenshot-1.png" alt="pro version" style="    width: 100%;">
			</a>
			<a class="admin-buy-now" href="https://codecanyon.net/item/fancy-wordpress-team-showcase/25151565" target="_blank">Buy Pro</a>	
    </div>
    </div>
<?php
	}
	
}
	
	if ( ! function_exists( 'wpts_f_func' ) ) {
		function wpts_f_func( $atts ) {
			$a = shortcode_atts( array(
				'group' => '',
				'limit' => '-1',
		
				'profile_width' => '200',
		
			), $atts );
			
			
			$html = ' <div class="no-carousel">  ';
			if($a['group']=="" || $a['group']==" ") {
			$args = array( 
				'post_type' => 'team_mf',
				'posts_per_page' => $a['limit']
			);
			}else {
			 $args = array( 
				'post_type' => 'team_mf',
				'posts_per_page' => $a['limit'],
				'tax_query' => array(
					array(
						'taxonomy' => 'team_mfcategory',
						'field'    => 'slug',
						'terms'    => $a['group'],
					),
				),
			);
			}
			// The Query
			$the_query = new WP_Query( $args );
			 
			// The Loop
			if ( $the_query->have_posts() ) {
				
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					$social = "<ul>";
				   $html .=' <div class="item">';
					$html .='<div class="member_wrp" ><div class="member_thumbnail " style="width:'.$a['profile_width'].'px;height:'.$a['profile_width'].'px;">'.get_the_post_thumbnail(get_the_ID(),"large").'</div>';
					$html .='<h2>'.esc_html(get_the_title()).'</h2>';
					if(esc_html(get_post_meta(get_the_ID(), 'client_designation', true))) {
					$html .='<p>'.esc_html(get_post_meta(get_the_ID(), 'client_designation', true)).'</h2>';
					}
					if(esc_html(get_post_meta(get_the_ID(), 'contact_number', true))) {
					$html .='<p><a href="tel:'.esc_html(get_post_meta(get_the_ID(), 'contact_number', true)).'">'.get_post_meta(get_the_ID(), 'contact_number', true).'</a></h2>';
					}
					if(esc_html(get_post_meta(get_the_ID(), 'contact_email', true))) {
					$html .='<p><a href="mail:'.esc_html(get_post_meta(get_the_ID(), 'contact_email', true)).'">'.get_post_meta(get_the_ID(), 'contact_email', true).'</a></h2>';
					}
					if(esc_url(get_post_meta(get_the_ID(), 'social_facebook', true))) {
					$social .='<li><a href="'.esc_url(get_post_meta(get_the_ID(), 'social_facebook', true)).'"><img src="'.FWPTS_PLUGIN_DIR.'/images/32/facebook.png"></a></li>';
					}
					if(esc_url(get_post_meta(get_the_ID(), 'social_twitter', true))) {
					$social .='<li><a href="'.esc_url(get_post_meta(get_the_ID(), 'social_twitter', true)).'"><img src="'.FWPTS_PLUGIN_DIR.'/images/32/twitter.png"></a></li>';
					}
					if(esc_url(get_post_meta(get_the_ID(), 'social_googleplus', true))) {
					$social .='<li><a href="'.esc_url(get_post_meta(get_the_ID(), 'social_googleplus', true)).'"><img src="'.FWPTS_PLUGIN_DIR.'/images/32/googleplus.png"></a></li>';
					}
					if(esc_url(get_post_meta(get_the_ID(), 'social_instagram', true))) {
					$social .='<li><a href="'.esc_url(get_post_meta(get_the_ID(), 'social_instagram', true)).'"><img src="'.FWPTS_PLUGIN_DIR.'/images/32/instagram.png"></a></li>';
					}
					
					if(esc_url(get_post_meta(get_the_ID(), 'social_pinterest', true))) {
					$social .='<li><a href="'.esc_url(get_post_meta(get_the_ID(), 'social_pinterest', true)).'"><img src="'.FWPTS_PLUGIN_DIR.'/images/32/pinterest.png"></a></li>';
					}
					if(esc_url(get_post_meta(get_the_ID(), 'social_linkedin', true))) {
					$social .='<li><a href="'.esc_url(get_post_meta(get_the_ID(), 'social_linkedin', true)).'"><img src="'.FWPTS_PLUGIN_DIR.'/images/32/linkedin.png"></a></li>';
					}
					if(esc_url(get_post_meta(get_the_ID(), 'social_dribbble', true))) {
					$social .='<li><a href="'.esc_url(get_post_meta(get_the_ID(), 'social_dribbble', true)).'"><img src="'.FWPTS_PLUGIN_DIR.'/images/32/dribbble.png"></a></li>';
					}
					if(esc_url(get_post_meta(get_the_ID(), 'social_youtube', true))) {
					$social .='<li><a href="'.esc_url(get_post_meta(get_the_ID(), 'social_youtube', true)).'"><img src="'.FWPTS_PLUGIN_DIR.'/images/32/youtube.png"></a></li>';
					}	
					if(esc_url(get_post_meta(get_the_ID(), 'social_skype', true))) {
					$social .='<li><a href="skype:'.esc_html(get_post_meta(get_the_ID(), 'social_skype', true)).'"><img src="'.FWPTS_PLUGIN_DIR.'/images/32/skype.png"></a></li>';
					}
					
					$html .= $social.'</ul>'.'</div></div>';
					
				}
			   
			} else {
				// no posts found
			}
		
			wp_reset_postdata();
				 
			$html .='    
				
			  </div>';
  
	
			return $html;
		}
		}
add_shortcode( 'team', 'wpts_f_func' ); 
	
?>
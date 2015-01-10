<?php 
/**
 * @package News_ticker
 * @version 1.0
 */
/*
/*
Plugin Name: Hm News Ticker
Plugin URI: custom.webuda.com/plugins
Description: This is a news ticker wordpress plugin. This is easy to use in your wordpress theme. This plugin is usually use in news site.
Author: hmmurad
Version: 1.0
Author URI: designbd.host56.com/hmmurad
*/

function hm_news_ticker_jquery() {
	wp_enqueue_script('jquery');
}
add_action('init', 'hm_news_ticker_jquery');



function hm_news_ticker() {
    wp_enqueue_script( 'lazy-news-js', plugins_url( '/js/jquery.ticker.js', __FILE__ ), array('jquery'), 1.0, false);
    wp_enqueue_style( 'lazy-news-css', plugins_url( '/css/ticker-style.css', __FILE__ ));

}

add_action( 'init', 'hm_news_ticker');





//This code for dynamic shortcode 

function ticker_list_shortcode($atts){
	extract( shortcode_atts( array(
		'id' => 'hm',
		'color' => '#1984FC',
		'bg' => '#F075C9',
		'title' => 'latest post',
		'speed' => '0.10',
		'control' => 'true',
		'category' => '',
		'quantity' => '5',
		'category_slug' => 'category_ID',
	), $atts, 'projects' ) );
	
    $q = new WP_Query(
        array('posts_per_page' => $quantity, 'post_type' => 'post', $category_slug => $category)
        );		
		
		
	$list = '
		<style type="text/css">
			.ticker-content a,.ticker-swipe span, .ticker-title{color:'.$color.'}
			.ticker-wrapper.has-js, .ticker, .ticker-title, .ticker-content, .ticker-swipe, .no-js-news{background:'.$bg.';}
			.ticker-swipe span{border-bottom: 2px solid '.$color.';}
		</style>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery("#newstic'.$id.'").ticker({
					speed: '.$speed.',
					controls: '.$control.',
					titleText: "'.$title.' :",
				});
			});		
		</script>	
	<ul id="newstic'.$id.'" class="js-hidden news_ticker">';
	while($q->have_posts()) : $q->the_post();
		$idd = get_the_ID();
		$list .= '
		
			<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>
		
		';        
	endwhile;
	$list.= '</ul>';
	wp_reset_query();
	return $list;
}
add_shortcode('ticker_list', 'ticker_list_shortcode');























?>
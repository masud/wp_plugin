<?php
/*
Plugin Name: Headline Plugin
Plugin URI: http://msdtheme.com/plugins/headline_plugin/
Description: A lightweight plugin for animating News Headline.
Author: M$D
Version: 1.0
Author URI: http://msdtheme.com/
*/

function latest_news_main () {
	wp_enqueue_script( 'latest-news-js', plugins_url('/js/jquery.ticker.min.js', __FILE__), array('jquery'), 1.2, false);
    wp_enqueue_style( 'latest-news-css', plugins_url('/css/style.css', __FILE__), array(), 1.2);
}

add_action('init','latest_news_main');

function latest_news_active (){?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery('.ticker').ticker();

	});
	</script>
<?php
}

add_action('wp_head','latest_news_active');

function news_list_shortcode($atts){
    extract( shortcode_atts( array(
            'category' => '',
            'count' => '3',
            'category_slug' => 'category_ID',
         ), $atts, '') );

    $query = new WP_Query(
             array('posts_per_page' => $count, 'post_type' => 'post', 'category_slug' => $category));

    $header = '<div class="ticker"><strong>Headline</strong><ul>';

    while ($query->have_posts()) : $query->the_post();

        $header .= '
            <li>'.get_the_title().'</li>';
    endwhile;

    $header.= '</ul></div>';
    wp_reset_query();

    return $header;
}

add_shortcode('headline', 'news_list_shortcode');

?>

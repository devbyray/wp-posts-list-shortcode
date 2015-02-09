<?php
/* Plugin Name: WP Posts List Shortcode
 * Plugin URI: https://github.com/raymonschouwenaar/wp-posts-list-shortcode
 * Description: [posts-list] gives a list of the most recent posts
 * Version: 0.1.0
 * Author: Raymon Schouwenaar
 * Author URI: http://raymonschouwenaar.nl
 */



function get_excerpt($count){
  $permalink = get_permalink($post->ID);
  $excerpt = get_the_content();
  $excerpt = strip_tags($excerpt);
  $excerpt = substr($excerpt, 0, $count);
  $excerpt = $excerpt.'...';
  return $excerpt;
}

function get_title($count){
  $permalink = get_permalink($post->ID);
  $title = get_the_title();
  $title = strip_tags($title);
  $title = substr($title, 0, $count);
  return $title;
}


function rss_posts_lists_shortcode($atts, $content = null) {
	extract(
		shortcode_atts(
			array(
			'total' => -1,
			'category' => '',
			'characters_length' => '',
			'title_length' => '',
			),
			$atts
		)
	);

//	print_r($total);
	if($total != '' && $total >= 0) {
		$total = $total - 1;
	}
	if($characters_length == '') {
		$characters_length = 55;
	}
	if($title_length == '') {
		$title_length = 20;
	}

    $queryArgs = array(
    	'posts_per_page'   => $total,
    	'category_name' => $category
    );

    $queryPosts = new WP_Query( $queryArgs );

    $output = '<ul class="rss-wp-posts-list">';

    while ( $queryPosts->have_posts() ) {
        $queryPosts->the_post();
        $output .= '<li class="rss-wp-post-item">'
					. '<div class="rss-post-thumbnail">'
						. '<span class="rss-post-thumb-wrapper">'
							. '<a href="'.get_permalink().'">'
								. get_the_post_thumbnail( $queryPosts->ID, 'rss-thumb')
							. '</a>'
						. '</span>'
					. '</div>'
					. '<div class="rss-inner-content">'
						. '<strong>'. get_title($title_length) . '</strong>'
						. '<p>' . get_excerpt($characters_length) . '</p>'
						. '<a href="'.get_permalink().'" class="button">'
							. 'Lees meer'
						. '</a>'
					. '</div>'
				.'</li>';
    }
    $output .= '</ul>';

    return $output;
}
add_shortcode('posts-list', 'rss_posts_lists_shortcode');

add_image_size( 'rss-thumb', 300, 180, true );
?>
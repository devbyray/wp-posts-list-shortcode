<?php
/* Plugin Name: WP Posts List Shortcode
 * Plugin URI: https://github.com/raymonschouwenaar/wp-posts-list-shortcode
 * Description: [posts-list] gives a list of the most recent posts
 * Version: 0.1.0
 * Author: Raymon Schouwenaar
 * Author URI: http://raymonschouwenaar.nl
 */
function rss_posts_lists_shortcode($atts, $content = null) {
	extract(
		shortcode_atts(
			array(
			'total' => -1,
			'category' => '',
			),
			$atts
		)
	);

//	print_r($total);
	if($total != '' && $total >= 0) {
		$total = $total - 1;
	}

    $queryArgs = array(
    	'posts_per_page'   => $total,
    	'category_name' => $category
    );

    $queryPosts = new WP_Query( $queryArgs );
//	print_r('<pre>');
//	print_r($queryPosts);
//	print_r('</pre>');

    $output = '<ul class="rss-wp-posts-list">';

    while ( $queryPosts->have_posts() ) {
        $queryPosts->the_post();
        $output .= '<li class="rss-wp-post-item">'
        	. '<span class="rss-post-thumbnail">'
        	. '<a href="'.get_permalink().'">'
            . get_the_post_thumbnail( $queryPosts->ID, 'thumbnail')
            . '</a>'
            . '</span>'
            . '<strong>'. get_the_title() . '</strong>'
            . '<p>' . get_the_excerpt() . '</p>'
        	. '<a href="'.get_permalink().'" class="button">'
        	. 'Lees meer'
            . '</a>'
            .'</li>';
    }
    $output .= '</ul>';

    return $output;
}
add_shortcode('posts-list', 'rss_posts_lists_shortcode');
?>
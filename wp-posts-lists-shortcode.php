<?php
/* Plugin Name: WP Posts List Shortcode
 * Plugin URI: https://github.com/raymonschouwenaar/wp-posts-list-shortcode
 * Description: Replace [recent] with a short latest posts list
 * Version: 0.1.0
 * Author: Raymon Schouwenaar
 * Author URI: https://raymonschouwenaar.nl
 */
function rss_posts_lists_shortcode()
{
    $out = '<ul>\n';
    $recentPosts = new WP_Query();
    $recentPosts->query( 'posts_per_page=5' );
    while ( $recentPosts->have_posts() ) {
        $recentPosts->the_post();
        $out .= '<li>\n'.
        	.'<a href="' . get_permalink() . '">\n'
            . get_the_title() . '</a>\n'
            .'</li>\n';
    }
    $out .= '</ul>\n';
    return $out;
}
add_shortcode('posts-list', 'rss_posts_lists_shortcode');
?>
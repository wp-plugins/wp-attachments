<?php
/*
Plugin Name: WP-Attachments
Plugin URI: http://www.milesimarco.altervista.org/wp-attachments
Description: This plugin allow to automatically list PDF/WORD attachments under your posts/pages with a cool and clean style!
Author: Marco Milesi
Version: 1.0
Author URI: http://www.milesimarco.altervista.org/
*/

<?php  
  
add_filter( 'the_content', 'my_the_content_filter' );
function my_the_content_filter( $content ) {
	global $post;

		$attachments = get_posts( array(
			'post_type' => 'attachment',
			'post_mime_type' => 'application/pdf,application/msword',
			'posts_per_page' => 100,
			'post_parent' => $post->ID
		) );

		if ( $attachments ) {
			$content .= '<h2>Attachments:</h2>';
			$content .= '<ul class="post-attachments">';
			foreach ( $attachments as $attachment ) {
				$class = "post-attachment mime-" . sanitize_title( $attachment->post_mime_type );
				$title = wp_get_attachment_link( $attachment->ID, false );
				$content .= '<li class="' . $class . '">' . $title . '</li>';
			}
			$content .= '</ul>';
		}

	return $content;
}
 
  
?>  
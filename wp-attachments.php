<?php  
/*
Plugin Name: WP-Attachments
Plugin URI: http://www.milesimarco.altervista.org/wp-attachments
Description: Automatically shows your doc, xls and pdf attachments under every post and page. Simply and Easily. As it should be!
Author: Marco Milesi
Version: 2.0
Author URI: http://www.milesimarco.altervista.org/
*/
  
add_filter( 'the_content', 'wpatt_content_filter' );
function wpatt_content_filter( $content ) {
	global $post;

		$attachments = get_posts( array(
			'post_type' => 'attachment',
			'post_mime_type' => 'application/pdf,application/msword,application/msexcel',
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
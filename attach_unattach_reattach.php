<?php
function wpa_upload_columns($columns) {

	unset($columns['parent']);
	$columns['wpattachments_parent'] = "WP Attachments";

	return $columns;

}
 function wpa_media_custom_columns($column_name, $id) {
	$post = get_post($id);
	__('Include images','wp-attachments');
	if($column_name != 'wpattachments_parent')
		return;

		if ( $post->post_parent > 0 ) {
			if ( get_post($post->post_parent) ) {
				$title =_draft_or_post_title($post->post_parent);
			}
			?>
			<strong><a href="<?php echo get_edit_post_link( $post->post_parent ); ?>"><?php echo $title ?></a></strong><br/><?php echo get_the_date(); ?>
			<hr>
			<a class="button button-small hide-if-no-js" onclick="findPosts.open('media[]','<?php echo $post->ID ?>');return false;" href="#the-list"><?php _e('Re-Attach','wp-attachments'); ?></a>

			<?php
		} else {
			?>
			<?php echo 'Unattached'; ?><hr>
			<a class="button button-primary button-small hide-if-no-js" onclick="findPosts.open('media[]','<?php echo $post->ID ?>');return false;" href="#the-list"><?php _e('Attach','wp-attachments'); ?></a>
			<?php
		}

}
function custom_admin_css() {
	echo '<style>
	#wpattachments_parent {
  		width: 15%;
	}
   	</style>';
		add_filter("manage_upload_columns", 'wpa_upload_columns');
	add_action("manage_media_custom_column", 'wpa_media_custom_columns', 0, 2);
 }
add_action('admin_head', 'custom_admin_css');
?>
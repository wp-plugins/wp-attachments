	<?php if ($attachments->have_posts()): ?>
	<div id="ij-post-attachments" class="ij-post-attachment-list">
		<ul>
			<?php while ($attachments->have_posts()): $atchment = $attachments->next_post(); ?>
			<li class="ij-post-attachment" style="height: 55px;box-shadow: 0px 1px 2px rgba(0,0,0,.04); padding: 20px 10px 20px 20px;border: 1px solid #eee;"
			    data-mimetype="<?php echo $atchment->post_mime_type; ?>"
			    data-alt="<?php echo esc_attr(get_post_meta(611, '_wp_attachment_image_alt', true)); ?>"
			    data-attachmentid="<?php echo $atchment->ID; ?>"
			    data-url="<?php echo wp_get_attachment_url($atchment->ID); ?>"
			    data-title="<?php echo esc_attr($atchment->post_title); ?>">
				<!--Item title-->
				<div class="ij-post-attachment-title">
					<div style="float:left;">
						<?php echo wp_get_attachment_image($atchment->ID, array(80, 60), true); ?>
					</div>
					<div style="float:right;">
                        <a href="<?php echo wp_get_attachment_url($atchment->ID); ?>" class="button button-small ij-post-attachment-edit"><?php _e('Edit'); ?></a>
						<?php $url = admin_url('tools.php?page=unattach&noheader=true&&id=' . $atchment->ID); ?>
						<a class="button button-small " href="<?php echo esc_url( $url );?>" onclick = "if (! confirm('<?php _e('Are you sure you want to do this?');?>')) { return false; }"><?php echo _e('Unattach','wp-attachments'); ?></a>
						
                        <a href="<?php echo get_delete_post_link($atchment->ID); ?>" class="button button-small ij-post-attachment-delete" onclick="if (! confirm('<?php _e('Are you sure you want to do this?');?>')) { return false; } else { $(this).fadeOut(); }"><?php _e('Remove'); ?></a>
                        
					</div>
					<h3 style="padding-top: 20px; padding-left: 80px;">
					<?php echo esc_html($atchment->post_title); ?></h3>
				</div>

				<!--Item body-->
				<div style="padding:1px 5px 5px">
					<div class="ij-post-attachment-type">
						<?php
							echo '<div style="float:right;">'.strtoupper(str_replace( array("image/", "application/") , '', get_post_mime_type($atchment->ID))).' &bull; <b>';
							if ((file_exists(get_attached_file($atchment->ID)))) {
								$wpatt_fs = wpatt_format_bytes(filesize(get_attached_file($atchment->ID)));
							} else {
								$wpatt_fs = 'not found';
							}
							echo $wpatt_fs;
							echo '</b></div>';
						?>
					</div>
					
				</div>
			</li>
			<?php endwhile; ?>
		</ul>
		<div class="clear"></div>
	</div>
	<?php else: ?>
	<p><?php _e('No media attachments found.'); ?></p>
	<?php endif; ?>
</div>
	<div id="wp-content-media-buttons" style="  float: none;
  background: #fcfcfc;
  border-top: 1px solid #dfdfdf;
  height: 50px;" class="wp-media-buttons">
		<center>
			<a style="margin-top: 10px;" href="#" id="insert-media-button" class="button insert-media add_media" data-editor="content"><span class="wp-media-buttons-icon"></span> <?php _e('Add Media'); ?></a>
        </center>
            <div style="float: right; margin: 17px; position: relative; top: -40px;">
                <input type="checkbox" id="wpa_off_n" name="wpa_off" 
                       <?php
                        if ( get_post_meta($post->ID, 'wpa_off', true) ) { echo 'checked="checked"'; }
                       ?> />
                <label for="wpa_off_n"><?php _e('Deactivate'); ?></label>
            </div>
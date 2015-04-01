    <?php if ($attachments->have_posts()): ?>

	<div id="ij-post-attachments" class="ij-post-attachment-list">
		<ul>
			<?php while ($attachments->have_posts()): $atchment = $attachments->next_post(); ?>
			<li class="ij-post-attachment" style="background:white; height: 45px; border-left: 3px solid #dfdfdf"
			    data-mimetype="<?php echo $atchment->post_mime_type; ?>"
			    data-alt="<?php echo esc_attr(get_post_meta(611, '_wp_attachment_image_alt', true)); ?>"
			    data-attachmentid="<?php echo $atchment->ID; ?>"
			    data-url="<?php echo wp_get_attachment_url($atchment->ID); ?>"
			    data-title="<?php echo esc_attr($atchment->post_title); ?>">
           
                <table class="widefat" style="border: none; text-align: center;">
                    <td width="50%" style="text-align: left;">
                        <li style="height: 20px;" class="post-attachment mime-<?php echo sanitize_title($atchment->post_mime_type); ?>">
                        <a target="_blank" href="<?php echo wp_get_attachment_url($atchment->ID); ?>">
                            <?php echo esc_html($atchment->post_title); ?>
                        </a>
                            <?php
                                $wpatt_date = new DateTime($attachment->post_date);
                                echo '<br><small>'.$wpatt_date->format(get_option('wpatt_option_date_localization')).'</small>';
                            ?>
                        </li>
                    </td>
                    <td width="10%">
                        <?php if (get_option('wpatt_counter')) { ?>
                        <span style="display: initial;" class="dashicons dashicons-download"></span> <?php echo wpa_get_downloads($atchment->ID); ?>
                        <?php } ?>
                    </td>
                    <td width="10%">
                        <?php echo pathinfo(wp_get_attachment_url($atchment->ID), PATHINFO_EXTENSION); ?>
                    </td>
                    <td width="10%">
                    <?php
                        if ((file_exists(get_attached_file($atchment->ID)))) {
                            echo wpatt_format_bytes(filesize(get_attached_file($atchment->ID)));
                        } else {
                            echo 'not found';
                        }
                        ?>
                    </td>
                    <td width="30%">
                    <a href="<?php echo wp_get_attachment_url($atchment->ID); ?>" class="button button-small ij-post-attachment-edit" title="<?php _e('Edit'); ?>">
                        <span class="dashicons dashicons-edit"></span>
                    </a>
                        
						<a class="button button-small " href="<?php echo esc_url( admin_url('tools.php?page=unattach&noheader=true&id=' . $atchment->ID) );?>"
                           onclick = "if (! confirm('<?php _e('Are you sure you want to do this?');?>')) { return false; }" title="<?php echo _e('Unattach','wp-attachments'); ?>">
                            <span class="dashicons dashicons-editor-unlink"></span>
                        </a>
                        <a href="<?php echo get_delete_post_link($atchment->ID);?>" class="button button-small ij-post-attachment-delete" title="<?php _e('Delete'); ?>">
                            <span class="dashicons dashicons-trash"></span>
                        </a>
                    </td>
                    </table>
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
			<a style="margin-top: 10px;" href="#" id="insert-media-button" class="button insert-media add_media" data-editor="content" title="<?php _e('Add Media'); ?>"><span class="wp-media-buttons-icon"></span> <?php _e('Add Media'); ?></a>
            <button style="margin-top: 10px;" name="save" type="submit" class="button-primary lollo" id="publish" accesskey="p" title="<?php _e('Refresh'); ?>"><span class="dashicons dashicons-update" style="padding-top: 3px;"></span></button>
            <style>
            .lollo {
            font-family: "dashicons";
content: "\f110";
            }</style>
        </center>
            <div style="float: right; margin: -23px 17px 0 0; position: relative;">
                <input type="checkbox" id="wpa_off_n" name="wpa_off" 
                       <?php
                        if ( get_post_meta($post->ID, 'wpa_off', true) ) { echo 'checked="checked"'; }
                       ?> />
                <label for="wpa_off_n"><?php _e('Deactivate'); ?></label>
            </div>
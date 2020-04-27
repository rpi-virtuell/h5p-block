<?php

/**
 * Testimonial Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$bid = 'h5p-' . $block['id'];


// Create class attribute allowing for custom "className" and "align" values.
$className = 'h5p-block';
if( !empty($block['className']) ) {
	$className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
	$className .= ' align' . $block['align'];
}

// Load values and assign defaults.
$id = get_field('h5p_inhalt') ?: '';
$hide = get_field('hide_url') ?: 0;

?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <?php if (  $id == '' ) { ?>
    Bitte einen H5P Inhalt auswählen.
    <?php } else {
        $link = get_site_url() . "/ru/" . $id; ?>

        <iframe src="<?php echo admin_url(); ?>admin-ajax.php?action=h5p_embed&id=<?php echo $id; ?>" width="578" height="350" frameborder="0" allowfullscreen="allowfullscreen"></iframe><script src="<?php echo site_url(); ?>/wp-content/plugins/h5p/h5p-php-library/js/h5p-resizer.js" charset="UTF-8"></script>
        <?php if ( $hide == 0 ) { ?>
            <a href="<?php echo $link; ?>">Vollbild</a> <input style="display:hidden;" type="text" value="<?php echo $link; ?>" id="link-<?php echo $bid; ?>"><button onclick="copyh5purl2clipboard('link-<?php echo $bid; ?>')">Link in Zwischenablage kopieren</button><br><br>
            <?php do_action('rw_h5p_block'); ?>
        <?php } ?>
    <?php } ?>
</div>
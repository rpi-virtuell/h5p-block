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

?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <?php if (  $id == '' ) { ?>
    Bitte einen H5P Inhalt auswählen.
    <?php } else {
        $link = get_site_url() . "/ru/" . $id; ?>
    [h5p id="<?php echo $id; ?>"]<br>
    Link zu diesem <a href="<?php echo $link; ?>">Material</a> <input style="display:hidden;" type="text" value="<?php echo $link; ?>" id="link-<?php echo $bid; ?>"><button onclick="copyh5purl2clipboard('link-<?php echo $bid; ?>')">Link in Zwischenablage kopieren</button><br><br>
    <?php } ?>
</div>
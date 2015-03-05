<?php

/**
 * The view of a single portfolio item from the shortcode
 *
 * @link       http://slushman.com/plugins/agency-portfolio
 * @since      1.0.0
 *
 * @package    Agency_Portfolio
 * @subpackage Agency_Portfolio/public/partials
 */

$meta 		= get_post_meta( $item->ID );
$classes 	= $this->get_cats_as_classes( $item->ID );

//pretty( $classes ); ?>

<a href="<?php echo get_permalink( $item->ID ); ?>" class="item-link <?php echo $classes; ?>">
	<div <?php post_class( 'item-wrapper '); ?> style="background-image:url(<?php echo $this->get_thumbnail_url( $item->ID ); ?>);">
		<div class="dcchover">
			<p class="item-name"><?php echo $item->post_title; ?></p>
		</div>
	</div>
</a>

<?php

/**
 * The view of the all the filters in a select menu from the shortcode
 *
 * @link       http://slushman.com/plugins/agency-portfolio
 * @since      1.0.0
 *
 * @package    Agency_Portfolio
 * @subpackage Agency_Portfolio/public/partials
 */

/*$return .= '<div class="portfolio-' . strtolower( $tax->label ) . '-filters portfolio-filters">';
$return .= '<label><h3 class="portfolio-filter-label">' . $tax->label . '</h3>';
$return .= '<select class="portfolio-filters-select" id="portfolio-' . strtolower( $tax->label ) . '-select">';
$return .= '<option value="All" class="portfolio-filter all">All</option>';

$terms = $this->get_all_terms( $tax->rewrite['slug'] );

foreach ( $terms as $term ) {

	$return .= '<option value="' . $term->slug . '" class="portfolio-filter ' . $term->slug . '">' . esc_attr( $term->name ) . '</option>';

} // foreach

$return .= '</select></label></div>';*/


?><div class="portfolio-<?php echo strtolower( $tax->label ); ?>-filters portfolio-filter">
<label><h3 class="portfolio-filter-label"><?php echo $tax->label; ?></h3>
<select class="portfolio-filters-select" id="portfolio-<?php echo strtolower( $tax->label ); ?>-select">
<option value="All" class="portfolio-filter" data-filter="">All</option><?php

$terms = $this->get_all_terms( $tax->rewrite['slug'] );

foreach ( $terms as $term ) {

	?><option value="<?php echo $term->slug; ?>" class="portfolio-filter" data-filter=".<?php echo $term->slug; ?>"><?php echo esc_attr( $term->name ); ?></option><?php

} // foreach

?></select></label></div>
<?php

/**
 * The view of the all the filters in a list from the shortcode
 *
 * @link       http://slushman.com/plugins/agency-portfolio
 * @since      1.0.0
 *
 * @package    Agency_Portfolio
 * @subpackage Agency_Portfolio/public/partials
 */

$return .= '<div class="portfolio-filter-wrap portfolio-' . strtolower( $tax->label ) . '-filters">';
$return .= '<h3 class="portfolio-filter-label">' . $tax->label . '</h3>';
$return .= '<ul class="portfolio-filters">';

$terms = $this->get_all_terms( $tax->rewrite['slug'] );

foreach ( $terms as $term ) {

	$return .= '<li class="portfolio-filter ' . strtolower( esc_attr( $term  ) ) . '"><a href="#">' . esc_attr( $term ) . '</a></li>';

} // foreach

$return .= '</ul></div>';
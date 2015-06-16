<?php

/**
 * The view of the all the filters and portfolio items from the shortcode
 *
 * @link       http://slushman.com/plugins/agency-portfolio
 * @since      1.0.0
 *
 * @package    Agency_Portfolio
 * @subpackage Agency_Portfolio/public/partials
 */

?><div class="portfolio-filters"><?php

echo $this->get_portfolio_filters();

?></div>
<div class="portfolio-items-wrap"><?php

foreach ( $items->posts as $item ) {

	include( plugin_dir_path( __FILE__ ) . 'agency-portfolio-public-display-single.php' );

} // foreach

?></div>
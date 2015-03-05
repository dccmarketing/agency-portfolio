<?php

/**
 * Sanitize anything
 *
 * @package   Slushman Toolkit
 * @version   1.0.0
 * @since     1.0.0
 * @author    Slushman <chris@slushman.com>
 * @copyright Copyright (c) 2015, Slushman
 * @link      http://slushman.com/plugins/slushman-toolkit
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

class Agency_Portfolio_Sanitizer {

	/**
	 * The data to be sanitized
	 *
	 * @access 	private
	 * @since 	1.0.0
	 * @var 	string
	 */
	private $data = '';

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $i18n    The ID of this plugin.
	 */
	private $i18n;

	/**
	 * The type of data
	 *
	 * @access 	private
	 * @since 	1.0.0
	 * @var 	string
	 */
	private $type = '';

	/**
	 * Sets the i18n class variable
	 *
	 * @access 	public
	 * @since 	1.0.0
	 * @param 	string 		$i18n 		The i18n indentifier
	 * @return 	void
	 */
	public function __construct( $i18n ) {

		$this->i18n = $i18n;

	} // __construct()

	/**
	 * Cleans the data
	 *
	 * @access 	public
	 * @since 	1.0.0
	 * @return  mixed         The sanitized data
	 */
	public function clean() {

		$sanitized = '';

		/**
		 * Add additional sanitization before the default sanitization
		 */
		do_action( 'slushman_pre_sanitize', $sanitized );

		switch ( $this->type ) {

			case 'color'			:
			case 'radio'			:
			case 'select'			: $sanitized = $this->sanitize_random( $this->data ); break;

			case 'date'				:
			case 'datetime'			:
			case 'datetime-local'	:
			case 'time'				:
			case 'week'				: $sanitized = strtotime( $this->data ); break;

			case 'number'			:
			case 'range'			: $sanitized = intval( $this->data ); break;

			case 'hidden'			:
			case 'month'			:
			case 'text'				:
			case 'uploader_gallery'	: $sanitized = sanitize_text_field( $this->data ); break;

			case 'uploader_single'	:
			case 'url'				: $sanitized = esc_url( $this->data ); break;

			case 'checkbox'			: $sanitized = ( isset( $this->data ) ? 1 : 0 ); break;
			case 'email'			: $sanitized = sanitize_email( $this->data ); break;
			case 'file'				: $sanitized = sanitize_file_name( $this->data ); break;
			case 'tel'				: $sanitized = $this->sanitize_phone( $this->data ); break;
			case 'textarea'			: $sanitized = esc_textarea( $this->data ); break;

		} // switch

		/**
		 * Add additional sanitization after the default sanitization.
		 */
		do_action( 'slushman_post_sanitize', $sanitized );

		return $sanitized;

	} // clean()

	/**
	 * Set the data class variable to the data you want sanitized
	 *
	 * @since	1.0.0
	 * @access 	public
	 * @param 	mixed 	$data 	The data to be sanitized
	 * @return 	void
	 */
	public function set_data( $data ) {

		if ( empty( $data ) ) { return FALSE; }

		$check = '';

		if ( empty( $data ) ) {

			$check = new WP_Error( 'forgot_data', __( 'Please set the data to sanitize.', $this->i18n ) );

		}

		$this->data = $data;

	} // set_data()

	/**
	 * Sets the type
	 *
	 * @since	1.0.0
	 * @access 	public
	 * @param 	string 	$type 	The type of field
	 * @return  void
	 */
	public function set_type( $type ) {

		if ( empty( $type ) ) { return FALSE; }

		$check = '';

		if ( empty( $type ) ) {

			$check = new WP_Error( 'forgot_type', __( 'Please set the data type to sanitize.', $this->i18n ) );

		}

		$this->type = $type;

	} // set_data()



/* ==========================================================================
   Private Methods
   ========================================================================== */

	/**
	 * Validates a phone number
	 *
	 * @access 	private
	 * @since	1.0.0
	 * @link	http://jrtashjian.com/2009/03/code-snippet-validate-a-phone-number/
	 * @param 	string 			$phone				A phone number string
	 * @return	string|bool		$phone|FALSE		Returns the valid phone number, FALSE if not
	 */
	private function sanitize_phone( $phone ) {

		if ( empty( $phone ) ) { return FALSE; }

		if ( preg_match( '/^[+]?([0-9]?)[(|s|-|.]?([0-9]{3})[)|s|-|.]*([0-9]{3})[s|-|.]*([0-9]{4})$/', $phone ) ) {

			return trim( $phone );

		}

		return FALSE;

	} // sanitize_phone()

	/**
	 * Performs general cleaning functions on data
	 *
	 * @access 	private
	 * @since	1.0.0
	 * @param 	mixed 	$input 		Data to be cleaned
	 * @return 	mixed 	$return 	The cleaned data
	 */
	private function sanitize_random( $input ) {

		if ( empty( $input ) ) { return FALSE; }

		$one	= trim( $input );
		$two	= stripslashes( $one );
		$return	= htmlspecialchars( $two );

		return $return;

	} // sanitize_random()

	/**
	 * Checks a date against a format to ensure its validity
	 *
	 * @access 	private
	 * @since	1.0.0
	 * @link 	http://www.php.net/manual/en/function.checkdate.php
	 * @param  	string 		$date   		The date as collected from the form field
	 * @param  	string 		$format 		The format to check the date against
	 * @return 	string 		A validated, formatted date
	 */
	public function validate_date( $date, $format = 'Y-m-d H:i:s' ) {

		if ( empty( $date ) ) { return FALSE; }

		$version = explode( '.', phpversion() );

		if ( ( (int) $version[0] >= 5 && (int) $version[1] >= 2 && (int) $version[2] > 17 ) ) {

			$d = DateTime::createFromFormat( $format, $date );

		} else {

			$d = new DateTime( date( $format, strtotime( $date ) ) );

		}

		return $d && $d->format( $format ) == $date;

	} // validate_date()

} // class

?>
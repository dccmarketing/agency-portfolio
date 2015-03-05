<?php

/**
 * A class for creating a form field
 *
 * @package 	Slushman Toolkit
 * @version 	1.0.0
 * @since 		1.0.0
 * @author 		Slushman <chris@slushman.com>
 * @copyright 	Copyright (c) 2015, Slushman
 * @link 		http://slushman.com/plugins/slushman-toolkit
 * @license 	http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */


class Agency_Portfolio_Field_Generator {

	/**
	 * Optional attributes for any input
	 *
	 * @access 	private
	 * @since 	1.0.0
	 * @var 	array
	 */
	private $atts = array();

	/**
	 * Select Menu Blank Menu Option
	 *
	 * @access 	private
	 * @since 	1.0.0
	 * @var 	string
	 */
	private $blank = '';

	/**
	 * Options for a datalist
	 *
	 * @access 	private
	 * @since 	1.0.0
	 * @var 	array
	 */
	private $datalist = array( 'id' => '', 'sels' => array() );

	/**
	 * Input Field Description
	 *
	 * @access 	private
	 * @since 	1.0.0
	 * @var 	string
	 */
	private $desc = '';

	/**
	 * Input Field Label
	 *
	 * @access 	private
	 * @since 	1.0.0
	 * @var 	string
	 */
	private $label = '';

	/**
	 * Radio, Checkboxes, and Select Field Selections
	 *
	 * @access 	private
	 * @since 	1.0.0
	 * @var 	array
	 */
	private $selections = array();

	/**
	 * The HTML code for the field
	 *
	 * @access 	private
	 * @since 	1.0.0
	 * @var 	string
	 */
	private $tag = '';

	/**
	 * Input Field Type
	 *
	 * @access 	private
	 * @since 	1.0.0
	 * @var 	string
	 */
	private $type = 'text';

	/**
	 * Input Field Value
	 *
	 * @access 	private
	 * @since 	1.0.0
	 * @var 	string
	 */
	private $value = '';

	/**
	 * Sets class variables
	 *
	 * Params
	 * 	 autocomplete: for autocompleting entries in a text input
	 * 	 blank: for select menu; false for none, true for a blank option, or string as the option text
	 * 	 class: used for the class attribute
	 * 	 desc: description used for the description span
	 * 	 id: used for the id and name attributes
	 *	 label: the text used to title the field
	 *   name: (optional), can be a separate value from ID
	 *   placeholder: The text that appears in the field before a value is entered.
	 *   selections: an array of data to use as the selections in the menu
	 *   size: an array with the columns and rows to size the textarea
	 *   type: determines the particular type of input field to be created
	 *	 value: used for the value attribute
	 *
	 * @param 	array 		$params
	 *
	 * @return 	void
	 */
	public function __construct( $params ) {

		$keys = array( 'blank', 'datalist', 'desc', 'label', 'selections', 'type', 'value' );

		foreach ( $keys as $key ) {

			if ( isset( $params[$key] ) || !empty( $params[$key] ) ) {

				$this->{$key} = $params[$key];

			}

		} // foreach loop

		$this->set_atts( $params['atts'] );

		$this->tag = '';

	} // __construct()

	/**
	 * Determines which field type to create
	 *
	 * @uses 	build_single()
	 * @uses 	build_checks()
	 * @uses 	build_editor()
	 * @uses 	build_radios()
	 * @uses 	build_select()
	 *
	 * @return 	mixed | bool			HTML fields or FALSE if type is not set
	 */
	public function create_field() {

		switch( $this->type ) {

			case 'editor'			: return $this->build_editor(); break;
			case 'range'			: return $this->build_range(); break;
			case 'select'			: return $this->build_select(); break;

			case 'checkbox'			:
			case 'radio'			: return $this->build_group(); break;

			case 'file'				:
			case 'image' 			:

			case 'color'			:
			case 'date'				:
			case 'datetime'			:
			case 'datetime-local' 	:
			case 'email'			:
			case 'hidden'			:
			case 'month' 			:
			case 'number'			:
			case 'password'			:
			case 'search'			:
			case 'tel'				:
			case 'text'				:
			case 'time' 			:
			case 'url'				:
			case 'week' 			: return $this->build_single(); break;

		} // switch

		return FALSE;

	} // create_field()



/* ==========================================================================
   Build Methods
   ========================================================================== */

	/**
	 * Builds a WordPress editor field
	 *
	 * @access  private
	 * @since 	1.0.0
	 *
	 * @uses 	wp_editor()
	 *
	 * @return 	mixed 			A WordPress editor field
	 */
	private function build_editor() {

		$editor['dfw'] 					= TRUE;
		$editor['editor_height'] 		= 360;
		$editor['media_buttons'] 		= FALSE;
		$editor['tabfocus_elements'] 	= 'sample-permalink,post-preview';
		$editor['textarea_name'] 		= $this->atts['name'];

		wp_editor( $this->value, $this->atts['id'], $editor );

	} // build_editor()

	/**
	 * Builds a group of either radios or checkboxes
	 *
	 * @access  private
	 * @since 	1.0.0
	 *
	 * @uses 	add_label()
	 * @uses 	add_opening()
	 * @uses 	add_attribute()
	 * @uses 	add_closing()
	 * @uses 	checked()
	 *
	 * @return 	mixed 			An HTML group or either radios or checkboxes
	 */
	private function build_group() {

		$this->add_label();
		$this->add_opening( 'div' );
		$this->add_attribute( 'id', $this->atts['id'] );
		$this->add_closing();
		$this->add_tag( 'fieldset' );
		$this->add_tag( 'legend', 'screen-reader-text' );
		$this->add_span( $this->desc );
		$this->add_closing_tag( 'legend' );

		foreach ( $this->selections as $selection ) {

			$this->add_tag( 'label' );
			$this->add_opening();

			$this->add_attribute( 'type', $this->type );

			foreach ( $this->atts as $att => $value ) {

				$this->add_attribute( $att, $value );

			} // foreach loop

			$this->add_attribute( 'value', $selection['value'] );
			$this->add_checked( $selection['value'] );
			$this->add_closing();

			if ( !empty( $selection['label'] ) ) {

				$this->add_span( $selection['label'], $this->atts['id'] . '_labels' );

			} // label check

			$this->add_closing_tag( 'label' );
			$this->add_tag( 'br' );

		} // foreach loop

		$this->add_closing_tag( 'fieldset' );
		$this->add_closing_tag( 'div' );
		$this->add_description();

		return $this->tag;

	} // build_group()

	/**
	 * Builds a range field
	 *
	 * @access  private
	 * @since 	1.0.0
	 *
	 * @return 	mixed 		An HTML range field
	 */
	private function build_range() {

		$this->add_span( $this->atts['min'], 'slushman_range_min' );
		$this->add_opening();

		$this->add_attribute( 'type', $this->type );

		foreach ( $this->atts as $att => $value ) {

			$this->add_attribute( $att, $value );

		} // foreach loop

		$this->add_closing( 'self' );
		$this->add_span( $this->atts['max'], 'slushman_range_max' );
		$this->add_datalist();
		$this->add_opening( 'output' );
		$this->add_attribute( 'class', 'range_output' );
		$this->add_attribute( 'name', 'range_output' );
		$this->add_closing();
		$this->add_text( $this->atts['min'] );
		$this->add_closing_tag( 'output' );
		$this->add_description();

		return $this->tag;

	} // build_range()

	/**
	 * Builds an HTML select menu
	 *
	 * @access  private
	 * @since 	1.0.0
	 *
	 * @uses 	add_label()
	 * @uses 	add_opening()
	 * @uses 	add_attribute()
	 * @uses 	add_blank()
	 * @uses 	selected()
	 * @uses 	add_closing()
	 *
	 * @return 	mixed 			An HTML select menu
	 */
	private function build_select() {

		$this->add_label();
		$this->add_opening( 'select' );

		$this->add_attribute( 'type', $this->type );

		foreach ( $this->atts as $att => $value ) {

			$this->add_attribute( $att, $value );

		} // foreach loop

		$this->add_closing();
		$this->add_blank();

		foreach ( $this->selections as $selection ) {

			$this->add_opening( 'option' );
			$this->add_attribute( 'value', $selection['value'] );
			$this->add_selected( $selection['value'] );
			$this->add_closing();
			$this->add_text( $selection['label'] );
			$this->add_closing_tag( 'option' );

		} // foreach loop

		$this->add_closing_tag( 'select' );
		$this->add_description();

		return $this->tag;

	} // build_select()

	/**
	 * Builds a single HTML field
	 *
	 * @access  private
	 * @since 	1.0.0
	 *
	 * @uses 	add_label()
	 * @uses 	add_opening()
	 * @uses 	add_attribute()
	 * @uses 	checked()
	 * @uses 	add_closing()
	 *
	 * @return 	mixed 			An HTML field
	 */
	private function build_single() {

		if ( 'hidden' !== $this->type ) {

			$this->add_label();

		}

		$this->add_opening();
		$this->add_attribute( 'type', $this->type );

		foreach ( $this->atts as $att => $value ) {

			$this->add_attribute( $att, $value );

		} // foreach loop

		$this->add_attribute( 'value', $this->value );
		$this->add_closing( 'self' );
		$this->add_description();

		return $this->tag;

	} // build_single()

	/**
	 * Builds a textarea field
	 *
	 * @access  private
	 * @since 	1.0.0
	 *
	 * @uses 	add_label()
	 * @uses 	add_opening()
	 * @uses 	add_attribute()
	 * @uses 	add_closing()
	 *
	 * @return 	mixed 		An HTML textarea field
	 */
	private function build_textarea() {

		$this->add_label();
		$this->add_opening( 'textarea' );

		foreach ( $this->atts as $att => $value ) {

			$this->add_attribute( $att, $value );

		} // foreach loop

		$this->add_closing();
		$this->add_attribute( 'value', $this->value );
		$this->add_closing_tag( 'textarea' );
		$this->add_description();

		return $this->tag;

	} // build_textarea()



/* ==========================================================================
   Add Methods
   ========================================================================== */

	/**
	 * Adds an HTML attribute tp the tag class variable
	 *
	 * @access  private
	 * @since 	1.0.0
	 *
	 * @param  	string 		$type  		The type of attribute to add
	 * @param  	string 		$value 		The value to assign to the attribute, default: NULL
	 *
	 * @return 	void
	 */
	private function add_attribute( $type, $value ) {

		if ( is_array( $value ) ) {

			$value = implode( ',', $value );

		}

		if ( is_int( $value ) ) {

			$this->tag .= sprintf( ' %s="%d"', $type, $value );

		} else {

			$this->tag .= sprintf( ' %s="%s"', $type, $value );

		}

	} // add_attribute()

	/**
	 * Adds a blank option for a select menu, possibly with text
	 *
	 * @access 	private
	 * @since 	1.0.0
	 *
	 * @uses 	add_opening()
	 * @uses 	add_closing()
	 * @uses 	add_closing()
	 *
	 * @return  void
	 */
	private function add_blank() {

		if ( $this->blank === FALSE || empty( $this->blank ) ) { return ''; }

		$this->add_opening( 'option' );
		$this->add_closing();

		if ( !is_bool( $this->blank ) ) {

			$this->tag .= __( $this->blank );

		}

		$this->add_closing( 'tag', 'option' );

	} // add_blank()

	/**
	 * Adds a button to the field
	 *
	 * @access 	private
	 * @since 	1.0.0
	 *
	 * @return 	void
	 */
	private function add_button( $text = 'Upload', $type = 'custom' ) {

		switch ( $type ) {

			case 'custom' :
				$this->add_opening();
				$this->add_attribute( 'class', 'button slushman_uploader_button' );
				$this->add_attribute( 'id', $this->atts['id'] );
				$this->add_attribute( 'name', $this->atts['name'] );
				$this->add_attribute( 'value', $text );
				$this->add_closing();
				break;
			case 'submit' :
				$this->tag .= get_submit_button( $text, 'primary', $this->atts['name'], FALSE );
				break;

		} // switch

	} // add_button()

	/**
	 * Adds the result of checked() to the tag class variable
	 *
	 * @access 	private
	 * @since 	1.0.0
	 *
	 * @return 	void
	 */
	private function add_checked( $sel_value ) {

		$this->tag .= checked( $this->value, $sel_value, FALSE );

	} // add_checked()

	/**
	 * Adds the closing HTML to the tag class variable
	 *
	 * @access 	private
	 * @since 	1.0.0
	 *
	 * @param 	string 		$type 		The type of tag, default: ''
	 *
	 * @return 	void
	 */
	private function add_closing( $type = '' ) {

		if ( 'self' == $type ) {

			$this->tag .= ' />';

		} else {

			$this->tag .= '>';

		} // tag and type check

	} // add_closing()

	/**
	 * Adds the closing HTML tag to the tag class variable
	 *
	 * @access 	private
	 * @since 	1.0.0
	 *
	 * @param 	string 		$tag 		The tag text to use
	 *
	 * @return 	void
	 */
	private function add_closing_tag( $tag ) {

		$this->tag .= '</' . $tag . '>';

	} // add_closing_tag()

	/**
	 * Builds a HTML datalist
	 *
	 * @access 	private
	 * @since 	1.0.0
	 *
	 * @return 	void
	 */
	private function add_datalist() {

		if ( empty( $this->datalist ) ) { return; }

		$this->add_opening( 'datalist' );
		$this->add_attribute( 'id', $this->datalist['id'] );
		$this->add_closing();

		foreach ( $this->datalist['sels'] as $sel ) {

			$this->add_tag( 'option' );
			$this->add_attribute( 'value', $sel );
			$this->add_closing_tag( 'option' );

		} // while loop

		$this->add_closing_tag( 'datalist' );

	} // add_datalist()

	/**
	 * Adds the description text to the tag class varible
	 *
	 * @access 	private
	 * @since 	1.0.0
	 *
	 * @return 	void
	 */
	private function add_description() {

		if ( !empty( $this->desc ) ) {

			$this->tag .= '<p class="description"';

			if ( !empty( $this->atts['id'] ) ) {

				$this->tag .= ' id="' . $this->atts['id'] . '_description"';

			} // class check

			$this->tag .= '>';
			$this->tag .= $this->desc;
			$this->tag .= '</p>';

		}

	} // add_description()

	/**
	 * Adds the field label to the tag class variable
	 *
	 * @access 	private
	 * @since 	1.0.0
	 *
	 * @param 	string 		$type 		The type of label to add, default: label
	 * @param 	string 		$label 		The label text to use, default: ''
	 *
	 * @return 	void
	 */
	private function add_label( $type = 'label', $label = '' ) {

		$text = ( empty( $label ) ? $this->label : $label );

		if ( 'label' == $type ) {

			$this->tag .= sprintf( '<label for="%s">%s</label>', $this->atts['id'], $text );

		} else {

			$this->tag .= sprintf( '<legend>%s</legend>', $text );

		} // $type check

	} // add_label()

	/**
	 * Adds the oppening p tag with an optional class attribute
	 *
	 * @access 	private
	 * @since 	1.0.0
	 *
	 * @param  	string 			$class 		An optional class attribute
	 *
	 * @return 	void
	 */
	private function add_paragraph( $class = '' ) {

		$this->tag .= '<p';

		if ( !empty( $class ) ) {

			$this->tag .= ' class=' . $class;

		}

		$this->tag .= '>';

	} // add_paragraph()

	/**
	 * Adds the opening HTML to the tag class variable
	 *
	 * @access 	private
	 * @since 	1.0.0
	 *
	 * @param 	string 			$type 		The type of opening text to add, default: input
	 *
	 * @return 	void
	 */
	private function add_opening( $type = 'input' ) {

		$this->tag .= '<' . $type;

	} // add_opening()

	/**
	 * Adds the result of selected() to the tag class variable
	 *
	 * @access 	private
	 * @since 	1.0.0
	 *
	 * @return 	void
	 */
	private function add_selected( $sel_value ) {

		$this->tag .= selected( $this->value, $sel_value, FALSE );

	} // add_selected()

	/**
	 * Adds a span tag with data inside the tags and an optional class attribute
	 *
	 * @access 	private
	 * @since 	1.0.0
	 *
	 * @param  	string 			$data 		The data to display between the tags
	 * @param  	string 			$class 		An optional class attribute
	 *
	 * @return 	void
	 */
	private function add_span( $data, $class = '' ) {

		$this->tag .= '<span';

		if ( !empty( $class ) ) {

			$this->tag .= ' class=' . $class;

		}

		$this->tag .= '>';
		$this->tag .= $data;
		$this->tag .= '</span>';

	} // add_span()

	/**
	 * Adds a complete HTML tag to the output
	 *
	 * @access 	private
	 * @since 	1.0.0
	 *
	 * @param  	string 			$tag 		The tag name
	 * @param  	string 			$class 		An optional class attribute
	 *
	 * @return 	void
	 */
	private function add_tag( $tag, $class = '' ) {

		$this->tag .= '<';
		$this->tag .= $tag;

		if ( !empty( $class ) ) {

			$this->tag .= ' class=' . $class;

		}

		if ( 'br' == $tag ) {

			$this->tag .= ' />';

		} else {

			$this->tag .= '>';

		}

	} // add_tag()

	/**
	 * Adds text to the tag class variable
	 *
	 * @access 	private
	 * @since 	1.0.0
	 *
	 * @return 	void
	 */
	private function add_text( $text ) {

		$this->tag .= $text;

	} // add_text()



/* ==========================================================================
   Setter Methods
   ========================================================================== */

	/**
	 * Sets the atts class variable
	 * If name isn't set, it's set using the id attribute
	 *
	 * @access 	private
	 * @since 	1.0.0
	 *
	 * @param 	array 		$atts 		The atts array
	 *
	 * @return 	void
	 */
	private function set_atts( $atts ) {

		$this->atts = $atts;

		if ( !isset( $atts['name'] ) ) {

			$this->atts['name'] = $atts['id'];

		}

	} // set_atts()



} // class

/*

All field options

atts: optional attributes to add
	autocomplete: on/off - used with a datalist for autocompleting values
	class: for styling
	cols: how many columns for a textarea
	data-*: (optional) data that needs to be present for the field
	id: used for the id and name attributes
	list: the name of the datalist to use with this field
	max: the maximum allowed value
	min: the minimum allowed value
	name: (optional), can be a separate value from ID
	oninput: a Javascript cue for an action to take place on input
	placeholder: The text that appears in the field before a value is entered.
	rows: how many rows for a textarea
	size: an array with the columns and rows to size the textarea
	step: the interval between values
	wrap: how to wrap text within a textarea
blank: for select menu; false for none, true for a blank option, or string as the option text
desc: description used for the description span
label: the text used to title the field
selections: an array of data to use as the selections in the menu
type: determines the particular type of input field to be created
	checkbox
	color
	date
	datetime
	datetime-local
	editor*
	email
	file
	hidden
	image
	month
	number
	password
	radio
	range
	search
	select
	tel
	text
	time
	url
	week
value: used for the value attribute




Examples of creating fields

$j									= 0;
$fields[$i]['atts']['class']		= 'slushman_field';
$fields[$i]['atts']['id']			= 'slushman_checkbox_field';
$fields[$i]['atts']['name']			= 'slushman_first[slushman_checkbox_field]';
$fields[$i]['atts']['desc']			= 'Checkbox Field';
$fields[$i]['label']				= 'Checkbox Field';
$fields[$i]['section']				= 'first_section';
$fields[$i]['selections'][$j]		= array( 'label' => 'Checkbox 1', 'value' => 1 );
$j++;
$fields[$i]['setting']				= 'slushman_first';
$fields[$i]['type']					= 'checkbox';
$fields[$i]['value']				= 0;
$i++;

$fields[$i]['atts']['class']		= 'slushman_field';
$fields[$i]['atts']['id']			= 'slushman_color_field';
$fields[$i]['atts']['name']			= 'slushman_first[slushman_color_field]';
$fields[$i]['desc']					= 'Color Field';
$fields[$i]['label']				= 'Color Field';
$fields[$i]['section']				= 'first_section';
$fields[$i]['setting']				= 'slushman_first';
$fields[$i]['type']					= 'color';
$fields[$i]['value']				= '';
$i++;

$fields[$i]['atts']['class']		= 'slushman_field';
$fields[$i]['atts']['format']		= '';
$fields[$i]['atts']['id']			= 'slushman_date_field';
$fields[$i]['atts']['name']			= 'slushman_first[slushman_date_field]';
$fields[$i]['atts']['placeholder']	= 'Date Field';
$fields[$i]['desc']					= 'Date Field';
$fields[$i]['label']				= 'Date Field';
$fields[$i]['section']				= 'first_section';
$fields[$i]['setting']				= 'slushman_first';
$fields[$i]['type']					= 'date';
$fields[$i]['value']				= '';
$i++;

$fields[$i]['atts']['class']		= 'slushman_field';
$fields[$i]['atts']['id']			= 'slushman_datetime_field';
$fields[$i]['atts']['name']			= 'slushman_first[slushman_datetime_field]';
$fields[$i]['atts']['placeholder']	= 'DateTime  Field';
$fields[$i]['desc']					= 'DateTime Field';
$fields[$i]['label']				= 'DateTime Field';
$fields[$i]['section']				= 'first_section';
$fields[$i]['setting']				= 'slushman_first';
$fields[$i]['type']					= 'datetime';
$fields[$i]['value']				= '';
$i++;

$fields[$i]['atts']['class']		= 'slushman_field';
$fields[$i]['atts']['id']			= 'slushman_datetime_local_field';
$fields[$i]['atts']['name']			= 'slushman_first[slushman_datetime_local_field]';
$fields[$i]['atts']['placeholder']	= 'DateTime Local Field';
$fields[$i]['desc']					= 'DateTime Local Field';
$fields[$i]['label']				= 'DateTime Local Field';
$fields[$i]['section']				= 'first_section';
$fields[$i]['setting']				= 'slushman_first';
$fields[$i]['type']					= 'datetime-local';
$fields[$i]['value']				= '';
$i++;

$fields[$i]['atts']['id']			= 'slushman_editor_field';
$fields[$i]['atts']['name']			= 'slushman_first[slushman_editor_field]';
$fields[$i]['section']				= 'first_section';
$fields[$i]['setting']				= 'slushman_first';
$fields[$i]['type']					= 'editor';
$fields[$i]['value']				= '';
$i++;

$fields[$i]['atts']['class']		= 'slushman_field';
$fields[$i]['atts']['id']			= 'slushman_email_field';
$fields[$i]['atts']['name']			= 'slushman_first[slushman_email_field]';
$fields[$i]['atts']['placeholder']	= 'Email Field';
$fields[$i]['desc']					= 'Email Field';
$fields[$i]['label']				= 'Email Field';
$fields[$i]['section']				= 'first_section';
$fields[$i]['setting']				= 'slushman_first';
$fields[$i]['type']					= 'email';
$fields[$i]['value']				= '';
$i++;

$fields[$i]['atts']['class']		= 'slushman_field';
$fields[$i]['atts']['id']			= 'slushman_file_field';
$fields[$i]['atts']['name']			= 'slushman_first[slushman_file_field]';
$fields[$i]['atts']['placeholder']	= 'File Field';
$fields[$i]['desc']					= 'File Field';
$fields[$i]['label']				= 'File Field';
$fields[$i]['section']				= 'first_section';
$fields[$i]['setting']				= 'slushman_first';
$fields[$i]['type']					= 'file';
$fields[$i]['value']				= '';
$i++;

$fields[$i]['atts']['id']			= 'slushman_image_field';
$fields[$i]['atts']['name']			= 'slushman_first[slushman_image_field]';
$fields[$i]['section']				= 'first_section';
$fields[$i]['setting']				= 'slushman_first';
$fields[$i]['type']					= 'hidden';
$fields[$i]['value']				= '';
$i++;

$fields[$i]['atts']['class']		= 'slushman_field';
$fields[$i]['atts']['id']			= 'slushman_image_field';
$fields[$i]['atts']['name']			= 'slushman_first[slushman_image_field]';
$fields[$i]['atts']['placeholder']	= 'Image Field';
$fields[$i]['desc']					= 'Image Field';
$fields[$i]['label']				= 'Image Field';
$fields[$i]['section']				= 'first_section';
$fields[$i]['setting']				= 'slushman_first';
$fields[$i]['type']					= 'image';
$fields[$i]['value']				= '';
$i++;

$fields[$i]['atts']['class']		= 'slushman_field';
$fields[$i]['atts']['id']			= 'slushman_month_field';
$fields[$i]['atts']['name']			= 'slushman_first[slushman_month_field]';
$fields[$i]['atts']['placeholder']	= 'Month Field';
$fields[$i]['desc']					= 'Month Field';
$fields[$i]['label']				= 'Month Field';
$fields[$i]['section']				= 'first_section';
$fields[$i]['setting']				= 'slushman_first';
$fields[$i]['type']					= 'month';
$fields[$i]['value']				= '';
$i++;

$fields[$i]['atts']['class']		= 'slushman_field';
$fields[$i]['atts']['id']			= 'slushman_number_field';
$fields[$i]['atts']['name']			= 'slushman_first[slushman_number_field]';
$fields[$i]['atts']['placeholder']	= 'Number Field';
$fields[$i]['desc']					= 'Number Field';
$fields[$i]['label']				= 'Number Field';
$fields[$i]['section']				= 'first_section';
$fields[$i]['setting']				= 'slushman_first';
$fields[$i]['type']					= 'number';
$fields[$i]['value']				= '';
$i++;

$fields[$i]['atts']['class']		= 'slushman_field';
$fields[$i]['atts']['id']			= 'slushman_password_field';
$fields[$i]['atts']['name']			= 'slushman_first[slushman_password_field]';
$fields[$i]['atts']['placeholder']	= 'Password Field';
$fields[$i]['desc']					= 'Password Field';
$fields[$i]['label']				= 'Password Field';
$fields[$i]['section']				= 'first_section';
$fields[$i]['setting']				= 'slushman_first';
$fields[$i]['type']					= 'password';
$fields[$i]['value']				= '';
$i++;

$j									= 0;
$fields[$i]['atts']['class']		= 'slushman_field';
$fields[$i]['atts']['id']			= 'slushman_radio_field';
$fields[$i]['atts']['desc']			= 'Radio Field';
$fields[$i]['atts']['name']			= 'slushman_first[slushman_radio_field]';
$fields[$i]['label']				= 'Radio Field';
$fields[$i]['section']				= 'first_section';
$fields[$i]['selections'][$j]		= array( 'label' => 'Radio 1', 'value' => 1 );
$j++;
$fields[$i]['selections'][$j]		= array( 'label' => 'Radio 2', 'value' => 2 );
$j++;
$fields[$i]['setting']				= 'slushman_first';
$fields[$i]['type']					= 'radio';
$fields[$i]['value']				= 0;
$i++;

$fields[$i]['atts']['class']		= 'slushman_field';
$fields[$i]['atts']['id']			= 'slushman_range_field';
$fields[$i]['atts']['max']			= 10;
$fields[$i]['atts']['min']			= 0;
$fields[$i]['atts']['name']			= 'slushman_first[slushman_range_field]';
$fields[$i]['atts']['oninput']		= 'range_output.value=value';
$fields[$i]['atts']['step']			= 1;
$fields[$i]['datalist']['id']		= 'slushman_range_values';
$fields[$i]['datalist']['sels']		= range(0, 10);
$fields[$i]['desc']					= 'Range Field';
$fields[$i]['label']				= 'Range Field';
$fields[$i]['section']				= 'first_section';
$fields[$i]['setting']				= 'slushman_first';
$fields[$i]['type']					= 'range';
$fields[$i]['value']				= '';
$i++;

$fields[$i]['atts']['class']		= 'slushman_field';
$fields[$i]['atts']['id']			= 'slushman_search_field';
$fields[$i]['atts']['name']			= 'slushman_first[slushman_search_field]';
$fields[$i]['atts']['placeholder']	= 'Search Field';
$fields[$i]['desc']					= 'Search Field';
$fields[$i]['label']				= 'Search Field';
$fields[$i]['section']				= 'first_section';
$fields[$i]['setting']				= 'slushman_first';
$fields[$i]['type']					= 'search';
$fields[$i]['value']				= '';
$i++;

$j									= 0;
$fields[$i]['atts']['class']		= 'slushman_field';
$fields[$i]['atts']['id']			= 'slushman_select_field';
$fields[$i]['atts']['name']			= 'slushman_first[slushman_select_field]';
$fields[$i]['desc']					= 'Select Field';
$fields[$i]['label']				= 'Select Field';
$fields[$i]['section']				= 'first_section';
$fields[$i]['selections'][$j]		= array( 'label' => 'Select 1', 'value' => 1 );
$j++;
$fields[$i]['selections'][$j]		= array( 'label' => 'Select 2', 'value' => 2 );
$j++;
$fields[$i]['setting']				= 'slushman_first';
$fields[$i]['type']					= 'select';
$fields[$i]['value']				= '';
$i++;

$fields[$i]['atts']['class']		= 'slushman_field';
$fields[$i]['atts']['id']			= 'slushman_tel_field';
$fields[$i]['atts']['name']			= 'slushman_first[slushman_tel_field]';
$fields[$i]['atts']['placeholder']	= 'Telephone Field';
$fields[$i]['desc']					= 'Telephone Field';
$fields[$i]['label']				= 'Telephone Field';
$fields[$i]['section']				= 'first_section';
$fields[$i]['setting']				= 'slushman_first';
$fields[$i]['type']					= 'tel';
$fields[$i]['value']				= '';
$i++;

$fields[$i]['atts']['class']		= 'slushman_field';
$fields[$i]['atts']['id']			= 'slushman_text_field';
$fields[$i]['atts']['name']			= 'slushman_first[slushman_text_field]';
$fields[$i]['atts']['placeholder']	= 'Text Field';
$fields[$i]['desc']					= 'Text Field';
$fields[$i]['label']				= 'Text Field';
$fields[$i]['section']				= 'first_section';
$fields[$i]['setting']				= 'slushman_first';
$fields[$i]['type']					= 'text';
$fields[$i]['value']				= '';
$i++;

$fields[$i]['atts']['class']		= 'slushman_field';
$fields[$i]['atts']['cols']			= 50;
$fields[$i]['atts']['id']			= 'slushman_textarea_field';
$fields[$i]['atts']['name']			= 'slushman_first[slushman_textarea_field]';
$fields[$i]['atts']['rows']			= 10;
$fields[$i]['atts']['wrap']			= 'hard';
$fields[$i]['desc']					= 'Textarea';
$fields[$i]['label']				= 'Textarea';
$fields[$i]['section']				= 'first_section';
$fields[$i]['setting']				= 'slushman_first';
$fields[$i]['type']					= 'textarea';
$fields[$i]['value']				= '';
$i++;

$fields[$i]['atts']['class']		= 'slushman_field';
$fields[$i]['atts']['id']			= 'slushman_time_field';
$fields[$i]['atts']['name']			= 'slushman_first[slushman_time_field]';
$fields[$i]['desc']					= 'Time Field';
$fields[$i]['label']				= 'Time Field';
$fields[$i]['section']				= 'first_section';
$fields[$i]['setting']				= 'slushman_first';
$fields[$i]['type']					= 'time';
$fields[$i]['value']				= '';
$i++;

$fields[$i]['atts']['class']		= 'slushman_field';
$fields[$i]['atts']['id']			= 'slushman_url_field';
$fields[$i]['atts']['name']			= 'slushman_first[slushman_url_field]';
$fields[$i]['atts']['placeholder']	= 'URL Field';
$fields[$i]['desc']					= 'URL Field';
$fields[$i]['label']				= 'URL Field';
$fields[$i]['section']				= 'first_section';
$fields[$i]['setting']				= 'slushman_first';
$fields[$i]['type']					= 'url';
$fields[$i]['value']				= '';
$i++;

$fields[$i]['atts']['class']		= 'slushman_field';
$fields[$i]['atts']['id']			= 'slushman_week_field';
$fields[$i]['atts']['name']			= 'slushman_first[slushman_week_field]';
$fields[$i]['desc']					= 'Week Field';
$fields[$i]['label']				= 'Week Field';
$fields[$i]['section']				= 'first_section';
$fields[$i]['setting']				= 'slushman_first';
$fields[$i]['type']					= 'week';
$fields[$i]['value']				= '';
$i++;
*/

?>
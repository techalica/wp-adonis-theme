<?php
class ACF_Post {

	protected static $instances = array();
	public           $post_id;

	public static function instance( $post_id_provided = NULL ) {
		$post_id = ( $post_id_provided === NULL ) ? get_the_ID() : $post_id_provided;
		if ( ! array_key_exists( $post_id_provided, self::$instances ) ) {

			if($post_id_provided === "front_page") {
				$post_id = (int) get_option('page_on_front');
			}

			self::$instances[ $post_id_provided ] = new ACF_Post( $post_id );
		}

		return self::$instances[ $post_id_provided ];
	}

	public function __construct( $post_id ) {
		$this->post_id = $post_id;
	}

	public function image( $property, $css_class = "" ) {
		$image = $this->get_field( $property );
		if ( empty( $image ) ) {
			return;
		}

		//In case we changed the Field ID _meta_field_id
		if ( is_numeric( $image ) ) {
			$field = acf_get_valid_field( array(
				'name' => $property,
				'key'  => '',
				'type' => 'image',
			) );

			$image = acf_format_value( $image, $this->post_id, $field );
		}

		if ( is_array( $image ) ) {
			$image = $image['url'];
		}

		printf( '<img src="%s" alt="" class="%s" />', $image, $css_class );
	}

	public function background_image( $property ) {
		$image = $this->get_background_image( $property );
		if ( empty( $image ) ) {
			return;
		}

		printf( 'background-image:url(%s);', $image );
	}

	public function get_background_image( $property ) {
		$image = $this->get_field( $property );
		if ( empty( $image ) ) {
			return;
		}

		//In case we changed the Field ID _meta_field_id
		if ( is_numeric( $image ) ) {
			$field = acf_get_valid_field( array(
				'name' => $property,
				'key'  => '',
				'type' => 'image',
			) );

			$image = acf_format_value( $image, $this->post_id, $field );
		}

		if ( is_array( $image ) ) {
			$image = $image['url'];
		}

		return $image;
	}

	public function display( $property ) {
		the_field( $property, $this->post_id );
	}

	public function get_field( $property ) {
		$actual_value = get_field( $property, $this->post_id );
		return $actual_value;
	}

	public function has_field( $property ) {
		$actual_value = $this->get_field( $property);
		return (!empty($actual_value));
	}

	public function repeater( $property ) {
		$values = get_field( $property, $this->post_id );
		$values = is_array( $values ) ? $values : array();

		return $values;
	}

}

function options() {
	return ACF_Post::instance( 'options' );
}

function front_page() {
	return ACF_Post::instance( 'front_page' );
}
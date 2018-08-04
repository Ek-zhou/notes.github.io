<?php
/**
 * Add user profile fields
 */

if ( ! function_exists( 'exort_modify_contact_methods' ) ) {
	function exort_modify_contact_methods( $profile_fields ) {

		// Add new fields
		$profile_fields['country_code'] = __( 'Country Code', 'exort' );
		$profile_fields['phone'] = __( 'Phone Number', 'exort' );
		$profile_fields['birthday'] = __( 'Date of Birth', 'exort' );
		$profile_fields['address'] = __( 'Address', 'exort' );
		$profile_fields['city'] = __( 'City', 'exort' );
		$profile_fields['country'] = __( 'Country', 'exort' );
		$profile_fields['zip'] = __( 'Zip Code', 'exort' );
		$profile_fields['author_facebook'] = __( 'Facebook ', 'exort' );
		$profile_fields['author_twitter'] = __( 'Twitter', 'exort' );
		$profile_fields['author_linkedin'] = __( 'LinkedIn', 'exort' );
		$profile_fields['author_dribbble'] = __( 'Dribbble', 'exort' );
		$profile_fields['author_gplus'] = __( 'Google+', 'exort' );
		$profile_fields['author_custom'] = __( 'Custom Message', 'exort' );
		$profile_fields['photo_url'] = __( 'Custom User Photo Url', 'exort' );

		return $profile_fields;
	}
}
add_filter('user_contactmethods', 'exort_modify_contact_methods');
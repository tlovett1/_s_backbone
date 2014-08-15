<?php

/**
 * Build path data for current request.
 *
 * @return string|bool
 */
function _s_backbone_get_request_path() {
	global $wp_rewrite;

	if ( $wp_rewrite->using_permalinks() ) {
		global $wp;

		// If called too early, bail
		if ( ! isset( $wp->request ) ) {
			return false;
		}

		// Determine path for paginated version of current request
		if ( false != preg_match( '#' . $wp_rewrite->pagination_base . '/\d+/?$#i', $wp->request ) ) {
			$path = preg_replace( '#' . $wp_rewrite->pagination_base . '/\d+$#i', $wp_rewrite->pagination_base . '/%d', $wp->request );
		} else {
			$path = $wp->request . '/' . $wp_rewrite->pagination_base . '/%d';
		}

		// Slashes everywhere we need them
		if ( 0 !== strpos( $path, '/' ) )
			$path = '/' . $path;

		$path = user_trailingslashit( $path );
	} else {
		// Clean up raw $_REQUEST input
		$path = array_map( 'sanitize_text_field', $_REQUEST );
		$path = array_filter( $path );

		$path['paged'] = '%d';

		$path = add_query_arg( $path, '/' );
	}

	return empty( $path ) ? false : $path;
}

/**
 * Return query string for current request, prefixed with '?'.
 *
 * @return string
 */
function _s_backbone_get_request_parameters() {
	$uri = $_SERVER[ 'REQUEST_URI' ];
	$uri = preg_replace( '/^[^?]*(\?.*$)/', '$1', $uri, 1, $count );
	if ( $count != 1 ) {
		return '';
	}

	return $uri;
}
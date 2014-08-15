( function( $, Backbone, _, settings, undefined ) {
	'use strict';

	var document = window.document;

	var $postContainer = $( document.getElementById( 'main' ) );
	var moreButtonTemplate = document.getElementById( 'more-button-template' );
	var contentTemplate = document.getElementById( 'content-template' );

	// Abort completely if we don't have this stuff
	if ( ! $postContainer || ! moreButtonTemplate || ! contentTemplate ) {
		return false;
	}

	var $moreButton = $( _.template( moreButtonTemplate.innerHTML )() );
	var postTemplate = _.template( contentTemplate.innerHTML );

	var origURL = window.location.href;
	var offset = 1;
	var page = 1;
	var timer;

	window.posts = new wp.api.collections.Posts();
	var options = {
		data: {
			page: 2
		}
	};

	if ( 'archive' === settings.loopType ) {
		options.data.filter = {
			tax_query: [
				{
					taxonomy: settings.queriedObject.taxonomy,
					field: 'id',
					terms: settings.queriedObject.term_id
				}
			]
		};
	} else if ( 'search' === settings.loopType ) {
		options.data.filter = {
			s: settings.searchQuery
		};
	}

	/**
	 * Update current url using HTML5 history API
	 *
	 * @param {Number} pageNum
	 */
	function updateURL( pageNum ) {
		var offset = offset > 0 ? offset - 1 : 0;
		var pageSlug = ( -1 === pageNum ) ? origURL : window.location.protocol + '//' + settings.pathInfo.host + settings.pathInfo.path.replace( /%d/, pageNum + offset ) + settings.pathInfo.parameters;

		if ( window.location.href !== pageSlug ) {
			history.pushState( null, null, pageSlug );
		}
	}

	/**
	 * Grab more posts if more button is clicked and append them to loop
	 */
	function setupMoreListener() {
		$postContainer.on( 'click', '.more-button', function( event ) {
			event.preventDefault();

			$moreButton.hide();

			posts.more().done( function() {

				var $setContainer = $( '<div data-page-num="' + posts.state.currentPage + '" class="post-set"></div>' );
				posts.each( function( model ) {
					$setContainer.append( postTemplate( { post: model.attributes } ) );
				});

				$postContainer.append( $setContainer );

				if ( posts.hasMore() ) {
					$moreButton.appendTo( $postContainer).show();
				}
			} );
		});
	};

	/**
	 * Determine URL for pushing new history
	 */
	function determineURL() {
		var windowTop = $( window ).scrollTop();
		var windowBottom = windowTop + $( window ).height();
		var windowSize = $( window ).height();
		var setsInView = [];
		var pageNum = false;

		$postContainer.find( '.post-set' ).each( function() {
			var $currentSet = $( this );

			var setTop = $currentSet.offset().top;
			var setHeight = $currentSet.outerHeight( false );
			var setBottom = setTop + setHeight;
			var setPageNum = parseInt( $currentSet.attr( 'data-page-num' ) );

			if ( 0 === setHeight ) {
				$( '> *', this ).each( function() {
					setHeight += $currentSet.outerHeight( false );
				});
			}

			if ( setTop < windowTop && setBottom > windowBottom ) { // top of set is above window, bottom is below
				setsInView.push( { 'id': $currentSet.attr( 'id' ), 'top': setTop, 'bottom': setBottom, 'pageNum': setPageNum } );
			} else if( setTop > windowTop && setTop < windowBottom ) { // top of set is between top (gt) and bottom (lt)
				setsInView.push( { 'id': $currentSet.attr( 'id' ), 'top': setTop, 'bottom': setBottom, 'pageNum': setPageNum } );
			} else if( setBottom > windowTop && setBottom < windowBottom ) { // bottom of set is between top (gt) and bottom (lt)
				setsInView.push( { 'id': $currentSet.attr( 'id' ), 'top': setTop, 'bottom': setBottom, 'pageNum': setPageNum } );
			}

		});

		// Parse number of sets found in view in an attempt to update the URL to match the set that comprises the majority of the window.
		if ( 0 === setsInView.length ) {
			pageNum = -1;
		} else if ( 1 === setsInView.length ) {
			var setData = setsInView.pop();

			// If the first set of IS posts is in the same view as the posts loaded in the template by WordPress, determine how much of the view is comprised of IS-loaded posts
			if ( ( ( windowBottom - setData.top ) / windowSize ) < 0.5 ) {
				pageNum = -1;
			} else {
				pageNum = setData.pageNum;
			}
		} else {
			var majorityPercentageInView = 0;

			// Identify the IS set that comprises the majority of the current window and set the URL to it.
			$.each( setsInView, function( i, setData ) {
				var topInView = 0;
				var bottomInView = 0;
				var percentOfView = 0;

				// Figure percentage of view the current set represents
				if ( setData.top > windowTop && setData.top < windowBottom ) {
					topInView = ( windowBottom - setData.top ) / windowSize;
				}

				if ( setData.bottom > windowTop && setData.bottom < windowBottom ) {
					bottomInView = ( setData.bottom - windowTop ) / windowSize;
				}

				// Figure out largest percentage of view for current set
				if ( topInView >= bottomInView ) {
					percentOfView = topInView;
				} else if ( bottomInView >= topInView ) {
					percentOfView = bottomInView;
				}

				// Does current set's percentage of view supplant the largest previously-found set?
				if ( percentOfView > majorityPercentageInView ) {
					pageNum = setData.pageNum;
					majorityPercentageInView = percentOfView;
				}
			} );
		}

		// We do this last check in case something bad happened
		if ( 'number' == typeof pageNum ) {
			updateURL( pageNum );
		}
	}

	/**
	 * Setup scroll listeners for changing history
	 */
	function setupScrollListener() {
		$( window ).on( 'scroll', function() {

			clearTimeout( timer );
			timer = setTimeout( determineURL , 100 );
		});
	}

	/**
	 * Initial posts fetch
	 */
	posts.fetch( options ).done( function() {

		if ( posts.hasMore() ) {

			$postContainer.append( $moreButton );

			setupMoreListener();
			setupScrollListener();
		}
	});

})( jQuery, Backbone, _, settings );
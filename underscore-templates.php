<script type="text/html" id="content-template">
	<article id="post-<%= post.ID %>" class="post">
		<header class="entry-header">
			<h1 class="entry-title"><a href="<%= post.link %>" rel="bookmark"><%= post.title %></a></h1>

			<% if ( 'post' === post.type ) { %>
			<div class="entry-meta">
				<%= post.date %>
			</div><!-- .entry-meta -->
			<% } %>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<%= post.content %>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<% if ( 'post' === post.type ) { %>
				<% if ( post.terms.category ) { %>
					<span class="cat-links">
						<?php esc_html_e( 'Posted in', '_s_backbone' ); ?>
						<% _.each( post.terms.category, function( category ) { %>
							<a href="<%= category.link %>"><%= category.name %></a>
						<% } ); %>
					</span>
				<% } %>

				<% if ( post.terms.tag ) { %>
					<span class="tags-links">
						<% _.each( post.terms.tag, function( tag ) { %>
							<a href="<%= tag.link %>"><%= tag.name %></a>
						<% } ); %>
					</span>
				<% } %>
			<% } %>
		</footer><!-- .entry-footer -->
	</article><!-- #post-<%= post.ID %> -->
</script>

<script type="text/html" id="more-button-template">
	<div class="more-posts">

		<a class="more-button button" href="#"><?php esc_html_e( 'More', '_s_backbone' ); ?></a>

	</div>
</script>

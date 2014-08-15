<?php
/**
 * @package _s_backbone
 */
?>

<article id="post-<?php the_ID(); ?>" class="post">
	<header class="entry-header">
		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

		<?php if ( 'post' == get_post_type() ) : ?>
			<div class="entry-meta">
				<?php _s_backbone_posted_on(); ?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( __( ', ', '_s_backbone' ) );
			if ( $categories_list && _s_backbone_categorized_blog() ) :
				?>
				<span class="cat-links">
				<?php printf( __( 'Posted in %1$s', '_s_backbone' ), $categories_list ); ?>
			</span>
			<?php endif; // End if categories ?>

			<?php
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', __( ', ', '_s_backbone' ) );
			if ( $tags_list ) :
				?>
				<span class="tags-links">
				<?php printf( __( 'Tagged %1$s', '_s_backbone' ), $tags_list ); ?>
			</span>
			<?php endif; // End if $tags_list ?>
		<?php endif; // End if 'post' == get_post_type() ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
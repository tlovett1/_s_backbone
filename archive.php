<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package _s_backbone
 */

get_header(); ?>

	<?php get_template_part( 'underscore-templates' ); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">
					<?php
						if ( is_category() ) :
							single_cat_title();

						elseif ( is_tag() ) :
							single_tag_title();

						elseif ( is_author() ) :
							printf( esc_html__( 'Author: %s', '_s_backbone' ), '<span class="vcard">' . get_the_author() . '</span>' );

						elseif ( is_day() ) :
							printf( esc_html__( 'Day: %s', '_s_backbone' ), '<span>' . get_the_date() . '</span>' );

						elseif ( is_month() ) :
							printf( esc_html__( 'Month: %s', '_s_backbone' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', '_s_backbone' ) ) . '</span>' );

						elseif ( is_year() ) :
							printf( esc_html__( 'Year: %s', '_s_backbone' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', '_s_backbone' ) ) . '</span>' );

						else :
							esc_html_e( 'Archives', '_s_backbone' );

						endif;
					?>
				</h1>
				<?php
					// Show an optional term description.
					$term_description = term_description();
					if ( ! empty( $term_description ) ) :
						printf( '<div class="taxonomy-description">%s</div>', $term_description );
					endif;
				?>
			</header><!-- .page-header -->

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content' ); ?>

			<?php endwhile; ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

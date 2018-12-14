<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Latest
 */

get_header();
echo do_shortcode('[uo_breadcrumbs]');


$comment_style = get_option( 'latest_comment_style', 'click' );

if ( comments_open() ) {
	$comments_status = 'open';
} else {
	$comments_status = 'closed';
}
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php while ( have_posts() ) : the_post(); ?>


			<article id="post-<?php the_ID(); ?>" <?php post_class( 'post full-post' . $image_style ); ?>>

				<div class="entry-content">
					<header class="entry-header">

							<!-- <h1 class="entry-title"><?php the_title(); ?></h1> -->

					</header><!-- .entry-header -->

					<div class="post-content">
						<?php
								the_content( esc_html__( 'Read More', 'latest' ) );
						?>
					</div><!-- .post-content -->
				</div><!-- .entry-content -->

			</article><!-- #post-## -->


			<?php

			if ( function_exists( 'sharing_display' ) ) { ?>
				<div class="share-icons <?php echo esc_attr( $comments_status ); ?>">
					<?php echo sharing_display(); ?>
				</div>
			<?php }

			// Author profile box
			// latest_author_box();


		endwhile; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php get_sidebar();

get_footer(); ?>

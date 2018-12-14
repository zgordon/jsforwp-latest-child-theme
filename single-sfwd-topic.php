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

		<?php while ( have_posts() ) : the_post();



			// Move Jetpack share links below author box
			if ( function_exists( 'sharing_display' ) && ! function_exists( 'dsq_comment' ) ) {
				remove_filter( 'the_content', 'sharing_display', 19 );
				remove_filter( 'the_excerpt', 'sharing_display', 19 );
			}
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'post full-post' . $image_style ); ?>>

				<div class="entry-content">
					<header class="entry-header">

						<h1 class="entry-title"><?php the_title(); ?></h1>

					</header>

					<div class="post-content">
						<?php
							// Get the excerpt style for the blog index
							$excerpt_style  = get_theme_mod( 'latest_one_column_excerpt' );
							$excerpt_length = get_theme_mod( 'latest_one_column_excerpt_length', '40' );

							the_content( esc_html__( 'Read More', 'latest' ) );

							// Load the share icons on mobile
							if ( function_exists( 'array_load_sharing_icons' ) ) {
								$detect = new Mobile_Detect;

								if ( $detect->isMobile() || $detect->isTablet() ) {
									array_load_sharing_icons();
								}
							}
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

	<?php get_sidebar('learndash');

get_footer(); ?>
